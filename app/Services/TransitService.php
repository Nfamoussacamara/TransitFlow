<?php
// "declare(strict_types=1)" active le typage strict en PHP.
declare(strict_types=1);

namespace App\Services;

use App\Repositories\TransitRepository;
use App\Models\Pays;
use App\Models\Ville;
use App\Models\Client;
use App\Models\ModeTransport;
use App\Models\Marchandise;
use App\Models\Transit;
use DateTimeImmutable;
use Exception;

/**
 * TransitPro - TransitService
 * 
 * Classe responsable de la validation métier et de l'orchestration des flux
 * d'expédition et de facturation (Pattern Service Layer).
 */
class TransitService
{
    private TransitRepository $repository;
    private FacturationService $facturationService;
    private DatabaseInitializer $initializer;

    public function __construct()
    {
        $this->repository = new TransitRepository();
        $this->facturationService = new FacturationService();
        $this->initializer = new DatabaseInitializer();
    }

    /**
     * Initialise la base de données (création tables et seed structurel).
     */
    public function initializeDatabase(): void
    {
        $this->initializer->initialize();
    }

    /**
     * Supprime un transit et ses données liées.
     */
    public function deleteTransit(int $transitId): void
    {
        $this->repository->deleteTransit($transitId);
    }

    /**
     * Calcule et compile les indicateurs du tableau de bord.
     */
    public function getDashboardData(): array
    {
        $transitsList = $this->repository->findAllTransits();
        
        $transits = [];
        $totalRevenue = 0.0;
        $totalWeight = 0.0;
        $totalSurface = 0.0;

        foreach ($transitsList as $transit) {
            $factureObj = $transit->getFacture();
            if ($factureObj !== null) {
                $totalRevenue += $factureObj->getMontantTtc();
            }

            $transits[] = [
                'transit' => $transit,
                'facture' => $factureObj
            ];

            $totalWeight += $transit->getMarchandise()->getPoids();
            $totalSurface += $transit->getMarchandise()->getSurface();
        }

        return [
            'transits'            => $transits,
            'totalRevenue'        => $totalRevenue,
            'totalWeight'         => $totalWeight,
            'totalSurface'        => $totalSurface,
            'activeTransitsCount' => count($transits)
        ];
    }

    /**
     * Charge les transits pour la vue Expéditions.
     */
    public function getExpeditionsData(): array
    {
        return $this->repository->findAllTransits();
    }

    /**
     * Récupère le registre de facturation complet et calcule les totaux.
     */
    public function getFacturesData(): array
    {
        $factures = $this->repository->findAllFactures();
        
        $totalTtc = 0.0;
        $totalHt  = 0.0;

        foreach ($factures as $facture) {
            $totalTtc += $facture->getMontantTtc();
            $totalHt  += $facture->getMontantBrut();
        }

        return [
            'factures' => $factures,
            'totalTtc' => $totalTtc,
            'totalHt'  => $totalHt
        ];
    }

    /**
     * Crée un nouveau transit et sa facture associée.
     */
    public function createTransit(array $data): void
    {
        $this->validerDonnees($data);

        // Résolution / Création du client
        $clientId = $this->resolveClient($data['client_nom'], $data['client_email']);

        // Insertion marchandise
        $cleanDesignation = htmlspecialchars(trim($data['designation']));
        $marchandiseId = $this->repository->insertMarchandise([
            'designation' => $cleanDesignation,
            'poids'       => (float)$data['poids'],
            'surface'     => (float)$data['surface'],
            'etat'        => $data['etat']
        ], $clientId);

        // Résolution dynamique des villes de départ et d'arrivée
        $data['ville_depart_id'] = $this->repository->resolveDynamicCity((string)$data['ville_depart_id']);
        $data['ville_arrivee_id'] = $this->repository->resolveDynamicCity((string)$data['ville_arrivee_id']);

        // Insertion transit
        $transitId = $this->repository->insertTransit($data, $marchandiseId);

        // Émission de la facture légale (avec le client résolu)
        $this->generateFactureForTransit($transitId, $data, $marchandiseId, $cleanDesignation, $clientId);
    }

    /**
     * Met à jour un transit existant.
     */
    public function updateTransit(int $transitId, array $data): void
    {
        $this->validerDonnees($data);

        // Récupération marchandise ID liée
        $marchandiseId = $this->repository->findMarchandiseIdByTransit($transitId);

        // Résolution / Création du client
        $clientId = $this->resolveClient($data['client_nom'], $data['client_email']);

        // Mise à jour marchandise
        $cleanDesignation = htmlspecialchars(trim($data['designation']));
        $this->repository->updateMarchandise($marchandiseId, [
            'designation' => $cleanDesignation,
            'poids'       => (float)$data['poids'],
            'surface'     => (float)$data['surface'],
            'etat'        => $data['etat']
        ], $clientId);

        // Mise à jour transit
        // Résolution dynamique des villes de départ et d'arrivée
        $data['ville_depart_id'] = $this->repository->resolveDynamicCity((string)$data['ville_depart_id']);
        $data['ville_arrivee_id'] = $this->repository->resolveDynamicCity((string)$data['ville_arrivee_id']);

        $this->repository->updateTransit($transitId, $data);
    }

    /**
     * Valide la cohérence et l'intégrité des entrées formulaires.
     */
    private function validerDonnees(array $data): void
    {
        if ((int)$data['ville_depart_id'] === (int)$data['ville_arrivee_id']) {
            throw new Exception("La ville de départ et de destination doivent être différentes.");
        }
        if ((float)$data['poids'] <= 0 || (float)$data['surface'] <= 0) {
            throw new Exception("Le poids et la surface doivent être supérieurs à 0.");
        }
        if (strtotime($data['date_depart']) >= strtotime($data['date_arrivee'])) {
            throw new Exception("La date d'arrivée doit être après la date de départ.");
        }
    }

    /**
     * Résout un client par son email (le crée ou met à jour son nom).
     */
    private function resolveClient(string $nom, string $email): int
    {
        $cleanEmail = htmlspecialchars(trim($email));
        $cleanNom   = htmlspecialchars(trim($nom));

        $clientId = $this->repository->findClientIdByEmail($cleanEmail);

        if ($clientId !== null) {
            $this->repository->updateClientNom($clientId, $cleanNom);
            return $clientId;
        }

        return $this->repository->insertClient($cleanNom, $cleanEmail);
    }

    /**
     * Calcule et enregistre la facture historique liée au transit.
     */
    private function generateFactureForTransit(int $transitId, array $data, int $marchandiseId, string $cleanDesignation, int $clientId): void
    {
        $mtRow = $this->repository->findModeTransportRow((int)$data['mode_transport_id']);
        $modeObj = new ModeTransport($mtRow['nom'], $mtRow['type'], (float)$mtRow['tarif_unitaire'], (int)$mtRow['id']);
        
        // Résolution du client avec ses vraies informations
        $clientObj = new Client(
            htmlspecialchars(trim($data['client_nom'])),
            htmlspecialchars(trim($data['client_email'])),
            $clientId
        );
        $marchandiseObj = new Marchandise(
            $cleanDesignation,
            (float)$data['poids'],
            (float)$data['surface'],
            $data['etat'],
            $clientObj,
            $marchandiseId
        );
        
        $vdRow = $this->repository->findVilleRow((int)$data['ville_depart_id']);
        $vaRow = $this->repository->findVilleRow((int)$data['ville_arrivee_id']);

        // DÉCOMPOSITION PÉDAGOGIQUE POUR LES DÉBUTANTS :
        // Au lieu d'imbriquer les instanciations de classes "new" les unes dans les autres,
        // nous créons d'abord des objets intermédiaires clairs pour la ville de départ et d'arrivée.
        
        // 1. Création des objets Pays
        $paysDepart = new Pays($vdRow['pays_nom'], (int)$vdRow['pays_id']);
        $paysArrivee = new Pays($vaRow['pays_nom'], (int)$vaRow['pays_id']);

        // 2. Création des objets Ville (avec injection de leurs objets Pays respectifs)
        $villeDepart = new Ville($vdRow['nom'], $paysDepart, (int)$vdRow['id']);
        $villeArrivee = new Ville($vaRow['nom'], $paysArrivee, (int)$vaRow['id']);

        // 3. Création des objets de Date immutables
        $dateDepart = new DateTimeImmutable($data['date_depart']);
        $dateArrivee = new DateTimeImmutable($data['date_arrivee']);

        // 4. Instanciation finale du Transit principal
        $transitObj = new Transit(
            $villeDepart,
            $villeArrivee,
            $dateDepart,
            $dateArrivee,
            $marchandiseObj,
            $modeObj,
            $transitId
        );

        $tvaRate = $this->repository->getTvaRate();
        $montantBrut = $this->facturationService->calculerMontantBrut($transitObj);
        $montantTtc  = $this->facturationService->calculerMontantTtc($transitObj, $tvaRate);
        $numero      = 'FAC-' . date('Y') . '-' . str_pad((string)($transitId + 10), 4, '0', STR_PAD_LEFT);

        $this->repository->insertFacture($numero, $montantBrut, $montantTtc, $transitObj->getBaseCalcul(), $transitId);
    }

    /**
     * Récupère le taux de TVA et les tarifs de transport pour la configuration.
     */
    public function getSettingsData(): array
    {
        $modes = $this->repository->findAllModesTransport();
        $tvaRate = $this->repository->getTvaRate();

        return [
            'tvaRate' => $tvaRate,
            'modes'   => $modes
        ];
    }

    /**
     * Enregistre les nouvelles valeurs de configuration de taxes et tarifs.
     */
    public function updateSettings(float $tvaRate, array $tarifs): void
    {
        // 1. Validation basique
        if ($tvaRate < 0) {
            throw new Exception("Le taux de TVA ne peut pas être négatif.");
        }

        // 2. Mise à jour de la TVA (conversion de pourcentage en float ex: 20 -> 0.20)
        $this->repository->updateTvaRate($tvaRate / 100.0);

        // 3. Mise à jour de chaque tarif de transport
        foreach ($tarifs as $id => $tarif) {
            $valTarif = (float)$tarif;
            if ($valTarif < 0) {
                throw new Exception("Le tarif unitaire ne peut pas être négatif.");
            }
            $this->repository->updateModeTransportTarif((int)$id, $valTarif);
        }
    }

    /**
     * Récupère la liste de tous les clients via le dépôt (Repository).
     */
    public function getClientsList(): array
    {
        return $this->repository->findAllClients();
    }

    /**
     * Récupère la liste de toutes les villes avec leurs coordonnées géographiques et pays via le dépôt.
     */
    public function getVillesList(): array
    {
        return $this->repository->findAllVilles();
    }

    /**
     * Récupère la liste simple de tous les modes de transport via le dépôt.
     */
    public function getModesTransportList(): array
    {
        return $this->repository->findAllModesTransport();
    }
}
