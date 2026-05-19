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
            $this->pdo->query("SELECT latitude FROM villes LIMIT 1");
            $tableExists = true;
        } catch (Exception $e) {
            $tableExists = false;
        }

        if (!$tableExists) {
            try {
                $this->pdo->exec("
                    DROP TABLE IF EXISTS factures;
                    DROP TABLE IF EXISTS settings;
                    DROP TABLE IF EXISTS transits;
                    DROP TABLE IF EXISTS marchandises;
                    DROP TABLE IF EXISTS modes_transport;
                    DROP TABLE IF EXISTS clients;
                    DROP TABLE IF EXISTS villes;
                    DROP TABLE IF EXISTS pays;
                ");

                $this->pdo->exec("
                    CREATE TABLE IF NOT EXISTS pays (id INT AUTO_INCREMENT PRIMARY KEY, nom VARCHAR(255) NOT NULL);
                    CREATE TABLE IF NOT EXISTS villes (id INT AUTO_INCREMENT PRIMARY KEY, nom VARCHAR(255) NOT NULL, pays_id INT NOT NULL, latitude DOUBLE DEFAULT NULL, longitude DOUBLE DEFAULT NULL);
                    CREATE TABLE IF NOT EXISTS clients (id INT AUTO_INCREMENT PRIMARY KEY, nom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL);
                    CREATE TABLE IF NOT EXISTS modes_transport (id INT AUTO_INCREMENT PRIMARY KEY, nom VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, tarif_unitaire DOUBLE NOT NULL);
                    CREATE TABLE IF NOT EXISTS marchandises (id INT AUTO_INCREMENT PRIMARY KEY, designation VARCHAR(255) NOT NULL, poids DOUBLE NOT NULL, surface DOUBLE NOT NULL, etat VARCHAR(255) NOT NULL, client_id INT NOT NULL);
                    CREATE TABLE IF NOT EXISTS transits (id INT AUTO_INCREMENT PRIMARY KEY, ville_depart_id INT NOT NULL, ville_arrivee_id INT NOT NULL, date_depart DATETIME NOT NULL, date_arrivee DATETIME NOT NULL, marchandise_id INT NOT NULL, mode_transport_id INT NOT NULL, distance INT NOT NULL DEFAULT 0);
                    CREATE TABLE IF NOT EXISTS factures (id INT AUTO_INCREMENT PRIMARY KEY, numero VARCHAR(100) NOT NULL UNIQUE, montant_brut DOUBLE NOT NULL, montant_ttc DOUBLE NOT NULL, base_calcul DOUBLE NOT NULL, date_facturation DATETIME NOT NULL, transit_id INT NOT NULL);
                    CREATE TABLE IF NOT EXISTS settings (id INT AUTO_INCREMENT PRIMARY KEY, key_name VARCHAR(100) NOT NULL UNIQUE, value VARCHAR(255) NOT NULL);
                ");

                $this->pdo->exec("
                    INSERT INTO pays (nom) VALUES ('Guinée'), ('Sénégal'), ('Mali'), ('Côte d''Ivoire');
                    
                    INSERT INTO villes (nom, pays_id, latitude, longitude) VALUES 
                    ('Conakry', 1, 9.5370, -13.6773),
                    ('Kamsar', 1, 10.6667, -14.6167),
                    ('Boké', 1, 10.9333, -14.3000),
                    ('Kankan', 1, 10.3854, -9.3057),
                    ('Dakar', 2, 14.7167, -17.4677),
                    ('Bamako', 3, 12.6392, -8.0029),
                    ('Abidjan', 4, 5.3600, -4.0083);
                    
                    INSERT INTO modes_transport (nom, type, tarif_unitaire) VALUES 
                    ('Maritime', 'Maritime', 125000), 
                    ('Aérien', 'Aérien', 450000), 
                    ('Terrestre', 'Terrestre', 35000), 
                    ('Ferroviaire', 'Ferroviaire', 18000);
                    
                    INSERT INTO settings (key_name, value) VALUES ('tva_rate', '0.20') ON DUPLICATE KEY UPDATE value = value;
                ");
            } catch (Exception $e) {
                throw new Exception("Erreur d'initialisation BDD MySQL : " . $e->getMessage());
            }
        }
    }
}
