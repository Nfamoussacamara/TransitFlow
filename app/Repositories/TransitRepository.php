<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Config\Database;
use App\Models\Pays;
use App\Models\Ville;
use App\Models\Client;
use App\Models\ModeTransport;
use App\Models\Marchandise;
use App\Models\Transit;
use App\Models\Facture;
use DateTimeImmutable;
use PDO;

/**
 * Gère les requêtes brutes de la base de données et l'hydratation
 * des modèles pour la gestion des transits et factures.
 */
class TransitRepository
{
    private PDO $pdo;

    public function __construct()
    {
        $dbConfig = new Database();
        $this->pdo = $dbConfig->getConnection();
    }

    /**
     * Retourne l'instance PDO sous-jacente si nécessaire.
     */
    public function getPdo(): PDO
    {
        return $this->pdo;
    }

    /**
     * Supprime un transit et ses dépendances.
     */
    public function deleteTransit(int $transitId): void
    {
        // 1. Récupération de l'id marchandise
        $stmt = $this->pdo->prepare("SELECT marchandise_id FROM transits WHERE id = :id");
        $stmt->execute([':id' => $transitId]);
        $marchandiseId = $stmt->fetchColumn();

        // 2. Supprimer la facture
        $stmtF = $this->pdo->prepare("DELETE FROM factures WHERE transit_id = :tid");
        $stmtF->execute([':tid' => $transitId]);

        // 3. Supprimer le transit
        $stmtT = $this->pdo->prepare("DELETE FROM transits WHERE id = :id");
        $stmtT->execute([':id' => $transitId]);

        // 4. Supprimer la marchandise
        if ($marchandiseId) {
            $stmtM = $this->pdo->prepare("DELETE FROM marchandises WHERE id = :id");
            $stmtM->execute([':id' => $marchandiseId]);
        }
    }

    /**
     * Récupère la liste de tous les transits hydratés.
     */
    public function findAllTransits(): array
    {
        $transits = [];
        $query = "
            SELECT 
                t.id AS transit_id, t.date_depart, t.date_arrivee,
                vd.id AS vd_id, vd.nom AS vd_nom, pd.id AS pd_id, pd.nom AS pd_nom,
                va.id AS va_id, va.nom AS va_nom, pa.id AS pa_id, pa.nom AS pa_nom,
                m.id AS m_id, m.designation AS m_des, m.poids AS m_pds, m.surface AS m_surf, m.etat AS m_etat,
                c.id AS c_id, c.nom AS c_nom, c.email AS c_email,
                mt.id AS mt_id, mt.nom AS mt_nom, mt.type AS mt_type, mt.tarif_unitaire AS mt_tarif,
                f.id AS f_id, f.numero AS f_num, f.montant_brut AS f_brut, f.montant_ttc AS f_ttc, f.date_facturation AS f_date
            FROM transits t
            JOIN villes vd ON t.ville_depart_id = vd.id
            JOIN pays pd ON vd.pays_id = pd.id
            JOIN villes va ON t.ville_arrivee_id = va.id
            JOIN pays pa ON va.pays_id = pa.id
            JOIN marchandises m ON t.marchandise_id = m.id
            JOIN clients c ON m.client_id = c.id
            JOIN modes_transport mt ON t.mode_transport_id = mt.id
            LEFT JOIN factures f ON f.transit_id = t.id
            ORDER BY t.date_depart DESC
        ";

        $stmt = $this->pdo->query($query);
        $rows = $stmt->fetchAll();

        foreach ($rows as $row) {
            $transits[] = $this->hydrateTransit($row);
        }

        return $transits;
    }

    /**
     * Récupère la liste de toutes les factures hydratées.
     */
    public function findAllFactures(): array
    {
        $factures = [];
        $query = "
            SELECT 
                f.id AS f_id, f.numero AS f_num, f.montant_brut AS f_brut, f.montant_ttc AS f_ttc, f.base_calcul AS f_base, f.date_facturation AS f_date,
                t.id AS transit_id, t.date_depart, t.date_arrivee,
                vd.id AS vd_id, vd.nom AS vd_nom, pd.id AS pd_id, pd.nom AS pd_nom,
                va.id AS va_id, va.nom AS va_nom, pa.id AS pa_id, pa.nom AS pa_nom,
                m.id AS m_id, m.designation AS m_des, m.poids AS m_pds, m.surface AS m_surf, m.etat AS m_etat,
                c.id AS c_id, c.nom AS c_nom, c.email AS c_email,
                mt.id AS mt_id, mt.nom AS mt_nom, mt.type AS mt_type, mt.tarif_unitaire AS mt_tarif
            FROM factures f
            JOIN transits t ON f.transit_id = t.id
            JOIN villes vd ON t.ville_depart_id = vd.id
            JOIN pays pd ON vd.pays_id = pd.id
            JOIN villes va ON t.ville_arrivee_id = va.id
            JOIN pays pa ON va.pays_id = pa.id
            JOIN marchandises m ON t.marchandise_id = m.id
            JOIN clients c ON m.client_id = c.id
            JOIN modes_transport mt ON t.mode_transport_id = mt.id
            ORDER BY f.date_facturation DESC
        ";

        $stmt = $this->pdo->query($query);
        $rows = $stmt->fetchAll();

        foreach ($rows as $row) {
            $transit = $this->hydrateTransit($row);
            $factureObj = new Facture(
                $row['f_num'], (float)$row['f_brut'], (float)$row['f_ttc'],
                (float)$row['f_base'], new DateTimeImmutable($row['f_date']),
                $transit, (int)$row['f_id']
            );
            $transit->setFacture($factureObj);
            $factures[] = $factureObj;
        }

        return $factures;
    }

    /**
     * Recherche un client par email.
     */
    public function findClientIdByEmail(string $email): ?int
    {
        $stmt = $this->pdo->prepare("SELECT id FROM clients WHERE email = :email LIMIT 1");
        $stmt->execute([':email' => $email]);
        $id = $stmt->fetchColumn();
        return $id ? (int)$id : null;
    }

    /**
     * Insère un nouveau client.
     */
    public function insertClient(string $nom, string $email): int
    {
        $stmt = $this->pdo->prepare("INSERT INTO clients (nom, email) VALUES (:nom, :email)");
        $stmt->execute([':nom' => $nom, ':email' => $email]);
        return (int)$this->pdo->lastInsertId();
    }

    /**
     * Met à jour le nom d'un client.
     */
    public function updateClientNom(int $id, string $nom): void
    {
        $stmt = $this->pdo->prepare("UPDATE clients SET nom = :nom WHERE id = :id");
        $stmt->execute([':nom' => $nom, ':id' => $id]);
    }

    /**
     * Récupère les informations d'un mode de transport.
     */
    public function findModeTransportRow(int $id): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM modes_transport WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    /**
     * Récupère une ville avec son pays.
     */
    public function findVilleRow(int $id): array
    {
        $stmt = $this->pdo->prepare("
            SELECT v.*, p.nom AS pays_nom, p.id AS pays_id 
            FROM villes v 
            JOIN pays p ON v.pays_id = p.id 
            WHERE v.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    /**
     * Insère une marchandise.
     */
    public function insertMarchandise(array $data, int $clientId): int
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO marchandises (designation, poids, surface, etat, client_id)
            VALUES (:designation, :poids, :surface, :etat, :client_id)
        ");
        $stmt->execute([
            ':designation' => $data['designation'],
            ':poids'        => $data['poids'],
            ':surface'      => $data['surface'],
            ':etat'         => $data['etat'],
            ':client_id'    => $clientId,
        ]);
        return (int)$this->pdo->lastInsertId();
    }

    /**
     * Met à jour une marchandise.
     */
    public function updateMarchandise(int $id, array $data, int $clientId): void
    {
        $stmt = $this->pdo->prepare("
            UPDATE marchandises 
            SET designation = :designation, poids = :poids, surface = :surface, etat = :etat, client_id = :client_id
            WHERE id = :id
        ");
        $stmt->execute([
            ':designation' => $data['designation'],
            ':poids'        => $data['poids'],
            ':surface'      => $data['surface'],
            ':etat'         => $data['etat'],
            ':client_id'    => $clientId,
            ':id'           => $id
        ]);
    }

    /**
     * Récupère l'ID marchandise lié à un transit.
     */
    public function findMarchandiseIdByTransit(int $transitId): int
    {
        $stmt = $this->pdo->prepare("SELECT marchandise_id FROM transits WHERE id = :id");
        $stmt->execute([':id' => $transitId]);
        return (int)$stmt->fetchColumn();
    }

    /**
     * Insère un transit.
     */
    public function insertTransit(array $data, int $marchandiseId): int
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO transits (ville_depart_id, ville_arrivee_id, date_depart, date_arrivee, marchandise_id, mode_transport_id)
            VALUES (:vd, :va, :dd, :da, :mid, :mtid)
        ");
        $stmt->execute([
            ':vd'   => (int)$data['ville_depart_id'],
            ':va'   => (int)$data['ville_arrivee_id'],
            ':dd'   => date('Y-m-d H:i:s', strtotime($data['date_depart'])),
            ':da'   => date('Y-m-d H:i:s', strtotime($data['date_arrivee'])),
            ':mid'  => $marchandiseId,
            ':mtid' => (int)$data['mode_transport_id'],
        ]);
        return (int)$this->pdo->lastInsertId();
    }

    /**
     * Met à jour un transit.
     */
    public function updateTransit(int $id, array $data): void
    {
        $stmt = $this->pdo->prepare("
            UPDATE transits 
            SET ville_depart_id = :vd, ville_arrivee_id = :va, date_depart = :dd, date_arrivee = :da, mode_transport_id = :mtid
            WHERE id = :id
        ");
        $stmt->execute([
            ':vd'   => (int)$data['ville_depart_id'],
            ':va'   => (int)$data['ville_arrivee_id'],
            ':dd'   => date('Y-m-d H:i:s', strtotime($data['date_depart'])),
            ':da'   => date('Y-m-d H:i:s', strtotime($data['date_arrivee'])),
            ':mtid' => (int)$data['mode_transport_id'],
            ':id'   => $id
        ]);
    }

    /**
     * Insère une facture.
     */
    public function insertFacture(string $numero, float $brut, float $ttc, float $baseCalcul, int $transitId): void
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO factures (numero, montant_brut, montant_ttc, base_calcul, date_facturation, transit_id)
            VALUES (:num, :brut, :ttc, :base, :date, :tid)
        ");
        $stmt->execute([
            ':num'  => $numero,
            ':brut' => $brut,
            ':ttc'  => $ttc,
            ':base' => $baseCalcul,
            ':date' => (new DateTimeImmutable())->format('Y-m-d H:i:s'),
            ':tid'  => $transitId,
        ]);
    }

    /**
     * Hydrate une ligne de BDD en objet Transit.
     */
    private function hydrateTransit(array $row): Transit
    {
        $paysDepart = new Pays($row['pd_nom'], (int)$row['pd_id']);
        $villeDepart = new Ville($row['vd_nom'], $paysDepart, (int)$row['vd_id']);

        $paysArrivee = new Pays($row['pa_nom'], (int)$row['pa_id']);
        $villeArrivee = new Ville($row['va_nom'], $paysArrivee, (int)$row['va_id']);

        $client = new Client($row['c_nom'], $row['c_email'], (int)$row['c_id']);
        $marchandise = new Marchandise(
            $row['m_des'], (float)$row['m_pds'], (float)$row['m_surf'], 
            $row['m_etat'], $client, (int)$row['m_id']
        );

        $modeTransport = new ModeTransport(
            $row['mt_nom'], $row['mt_type'], (float)$row['mt_tarif'], (int)$row['mt_id']
        );

        $transit = new Transit(
            $villeDepart, $villeArrivee,
            new DateTimeImmutable($row['date_depart']), new DateTimeImmutable($row['date_arrivee']),
            $marchandise, $modeTransport, (int)$row['transit_id']
        );

        if (isset($row['f_id']) && $row['f_id'] !== null) {
            $factureObj = new Facture(
                $row['f_num'], (float)$row['f_brut'], (float)$row['f_ttc'],
                $transit->getBaseCalcul(), new DateTimeImmutable($row['f_date']),
                $transit, (int)$row['f_id']
            );
            $transit->setFacture($factureObj);
        }

        return $transit;
    }
}
