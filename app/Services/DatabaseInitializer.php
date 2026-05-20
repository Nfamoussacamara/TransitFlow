<?php
declare(strict_types=1);

namespace App\Services;

use App\Config\Database;
use Exception;
use PDO;

/**
 * DatabaseInitializer - Service d'initialisation de la base de données
 *
 * Ce service est appelé UNE SEULE FOIS au démarrage de l'application (dans public/index.php).
 * Son rôle est de vérifier si les tables de la base de données existent déjà.
 * Si ce n'est pas le cas, il les crée et remplit les données de base (pays, villes, tarifs).
 *
 * C'est l'équivalent d'une "migration" dans des frameworks comme Laravel.
 */
class DatabaseInitializer
{
    // La connexion PDO (PHP Data Objects) à MySQL, stockée comme propriété de classe.
    private PDO $pdo;

    /**
     * Le constructeur est appelé automatiquement quand on fait : new DatabaseInitializer()
     * Il se connecte immédiatement à la base de données via la classe Database.
     */
    public function __construct()
    {
        $dbConfig = new Database();
        $this->pdo = $dbConfig->getConnection();
    }

    /**
     * Méthode principale : initialise le schéma de la base de données.
     *
     * Elle vérifie si les tables existent déjà.
     * - Si OUI : elle ne touche à rien (les données existantes sont préservées).
     * - Si NON : elle crée toutes les tables et insère les données initiales.
     */
    public function initialize(): void
    {
        // --- ÉTAPE 1 : Vérification de l'existence des tables ---
        // On essaie de lire la colonne 'latitude' dans la table 'villes'.
        // Si la table n'existe pas, MySQL lèvera une Exception que l'on intercepte.
        try {
            $this->pdo->query("SELECT latitude FROM villes LIMIT 1");
            $tableExists = true; // La table existe, tout va bien.
        } catch (Exception $e) {
            $tableExists = false; // La table n'existe pas, il faut la créer.
        }

        // --- ÉTAPE 2 : Création des tables (seulement si nécessaire) ---
        if (!$tableExists) {
            try {
                // On supprime les anciennes tables si elles existent (dans le bon ordre
                // pour respecter les contraintes de clés étrangères).
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

                // Création de toutes les tables de l'application.
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

                // Remplissage des tables avec les données initiales de l'application.
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

        // ---------------------------------------------------------------------
        // ÉTAPE 3 : Gestion de la table UTILISATEURS (Authentification)
        //
        // Ce bloc est VOLONTAIREMENT séparé du bloc principal ci-dessus.
        // Raison : si la base de données existait déjà avant l'ajout de cette
        // fonctionnalité, le bloc principal ne s'exécute pas (tableExists = true).
        // Ce bloc s'exécute donc TOUJOURS, pour s'assurer que la table
        // `utilisateurs` est présente même sur des bases de données existantes.
        // ---------------------------------------------------------------------
        try {
            // Création de la table `utilisateurs` si elle n'existe pas encore.
            // La colonne `username` est limitée à VARCHAR(191) au lieu de 255 pour
            // respecter la limite d'index MySQL (767 octets en utf8mb4).
            $this->pdo->exec("
                CREATE TABLE IF NOT EXISTS utilisateurs (
                    id       INT AUTO_INCREMENT PRIMARY KEY,
                    username VARCHAR(191) NOT NULL UNIQUE, -- Identifiant de connexion (doit être unique)
                    password VARCHAR(255) NOT NULL,         -- Mot de passe haché par PHP (jamais en clair !)
                    role     VARCHAR(100) DEFAULT 'admin'  -- Rôle de l'utilisateur (ex: admin, user)
                );
            ");

            // On compte le nombre d'utilisateurs existants dans la table.
            $count = (int)$this->pdo->query("SELECT COUNT(*) FROM utilisateurs")->fetchColumn();

            // Si aucun utilisateur n'existe, on crée le compte administrateur par défaut.
            if ($count === 0) {
                // password_hash() transforme le mot de passe en un hash sécurisé (bcrypt).
                // On ne stocke JAMAIS le mot de passe en clair en base de données !
                $hashedPassword = password_hash('admin123', PASSWORD_DEFAULT);

                // On insère l'administrateur avec son mot de passe haché.
                $stmt = $this->pdo->prepare("INSERT INTO utilisateurs (username, password, role) VALUES ('admin', :pass, 'admin')");
                $stmt->execute([':pass' => $hashedPassword]);
            }

        } catch (Exception $e) {
            throw new Exception("Erreur d'initialisation de la table utilisateurs : " . $e->getMessage());
        }
    }
}
