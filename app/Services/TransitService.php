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
 * TransitFlow - TransitService
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

        // Insertion transit
        $transitId = $this->repository->insertTransit($data, $marchandiseId);

        // Émission de la facture légale
        $this->generateFactureForTransit($transitId, $data, $marchandiseId, $cleanDesignation);
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
    private function generateFactureForTransit(int $transitId, array $data, int $marchandiseId, string $cleanDesignation): void
    {
        $mtRow = $this->repository->findModeTransportRow((int)$data['mode_transport_id']);
        $modeObj = new ModeTransport($mtRow['nom'], $mtRow['type'], (float)$mtRow['tarif_unitaire'], (int)$mtRow['id']);
        
        $clientTmp = new Client('tmp', 'tmp@tmp.com');
        $marchandiseObj = new Marchandise(
            $cleanDesignation,
            (float)$data['poids'],
            (float)$data['surface'],
            $data['etat'],
            $clientTmp,
            $marchandiseId
        );
        
        $vdRow = $this->repository->findVilleRow((int)$data['ville_depart_id']);
        $vaRow = $this->repository->findVilleRow((int)$data['ville_arrivee_id']);

        $transitObj = new Transit(
            new Ville($vdRow['nom'], new Pays($vdRow['pays_nom'], $vdRow['pays_id']), $vdRow['id']),
            new Ville($vaRow['nom'], new Pays($vaRow['pays_nom'], $vaRow['pays_id']), $vaRow['id']),
            new DateTimeImmutable($data['date_depart']),
            new DateTimeImmutable($data['date_arrivee']),
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
        $dbConfig = new \App\Config\Database();
        $pdo = $dbConfig->getConnection();
        
        $modes = $pdo->query("SELECT id, nom, type, tarif_unitaire FROM modes_transport ORDER BY nom")->fetchAll();
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
}
