<?php
declare(strict_types=1);

namespace App\Services;

use App\Config\Database;
use Exception;
use PDO;

/**
 * Service d'initialisation et de migration de la base de données.
 */
class DatabaseInitializer
{
    private PDO $pdo;

    public function __construct()
    {
        $dbConfig = new Database();
        $this->pdo = $dbConfig->getConnection();
    }

    /**
     * Crée les tables et injecte les données structurelles initiales si nécessaire.
     */
    public function initialize(): void
    {
        try {
            $this->pdo->query("SELECT 1 FROM clients LIMIT 1");
            $tableExists = true;
        } catch (Exception $e) {
            $tableExists = false;
        }

        if (!$tableExists) {
            try {
                $this->pdo->exec("
                    CREATE TABLE IF NOT EXISTS pays (id INT AUTO_INCREMENT PRIMARY KEY, nom VARCHAR(255) NOT NULL);
                    CREATE TABLE IF NOT EXISTS villes (id INT AUTO_INCREMENT PRIMARY KEY, nom VARCHAR(255) NOT NULL, pays_id INT NOT NULL);
                    CREATE TABLE IF NOT EXISTS clients (id INT AUTO_INCREMENT PRIMARY KEY, nom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL);
                    CREATE TABLE IF NOT EXISTS modes_transport (id INT AUTO_INCREMENT PRIMARY KEY, nom VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, tarif_unitaire DOUBLE NOT NULL);
                    CREATE TABLE IF NOT EXISTS marchandises (id INT AUTO_INCREMENT PRIMARY KEY, designation VARCHAR(255) NOT NULL, poids DOUBLE NOT NULL, surface DOUBLE NOT NULL, etat VARCHAR(255) NOT NULL, client_id INT NOT NULL);
                    CREATE TABLE IF NOT EXISTS transits (id INT AUTO_INCREMENT PRIMARY KEY, ville_depart_id INT NOT NULL, ville_arrivee_id INT NOT NULL, date_depart DATETIME NOT NULL, date_arrivee DATETIME NOT NULL, marchandise_id INT NOT NULL, mode_transport_id INT NOT NULL);
                    CREATE TABLE IF NOT EXISTS factures (id INT AUTO_INCREMENT PRIMARY KEY, numero VARCHAR(100) NOT NULL UNIQUE, montant_brut DOUBLE NOT NULL, montant_ttc DOUBLE NOT NULL, base_calcul DOUBLE NOT NULL, date_facturation DATETIME NOT NULL, transit_id INT NOT NULL);
                ");

                $this->pdo->exec("
                    INSERT INTO pays (nom) VALUES ('Guinée'), ('Sénégal'), ('Mali'), ('Côte d''Ivoire');
                    INSERT INTO villes (nom, pays_id) VALUES ('Conakry', 1), ('Kamsar', 1), ('Boké', 1), ('Kankan', 1), ('Dakar', 2), ('Bamako', 3), ('Abidjan', 4);
                    INSERT INTO modes_transport (nom, type, tarif_unitaire) VALUES ('Maritime', 'Maritime', 125000), ('Aérien', 'Aérien', 450000), ('Terrestre', 'Terrestre', 35000), ('Ferroviaire', 'Ferroviaire', 18000);
                ");
            } catch (Exception $e) {
                throw new Exception("Erreur d'initialisation BDD MySQL : " . $e->getMessage());
            }
        }
    }
}
