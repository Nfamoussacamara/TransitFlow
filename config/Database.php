<?php
// Active le typage strict en PHP pour renforcer la robustesse du code.
declare(strict_types=1);

// Définition de l'espace de noms pour les configurations globales de l'application.
namespace App\Config;

// Importation des classes de gestion PDO.
use PDO;
use PDOException;
use Exception;

/**
 * TransitPro - Gestion de la connexion Base de Données
 * 
 * Initialise et configure de manière transparente la connexion PDO vers MySQL.
 * Gère également la création automatique de la base de données si celle-ci n'existe pas encore.
 */
class Database
{
    // Informations de connexion à la base de données MySQL locale (WampServer).
    private string $host = '127.0.0.1'; // Adresse IP du serveur de base de données (localhost).
    private string $user = 'root';      // Nom d'utilisateur par défaut de MySQL sous Wamp.
    private string $password = '';      // Mot de passe vide par défaut sous Wamp.
    private string $dbName = 'transit'; // Nom de la base de données dédiée à l'application.
    private string $port = '3306';      // Port standard d'écoute de MySQL.

    // Constructeur vide.
    public function __construct()
    {
    }

    /**
     * Initialise et retourne une nouvelle connexion PDO configurée.
     * Crée la base de données au préalable si elle n'existe pas.
     * 
     * @return PDO Instance de connexion active.
     * @throws Exception En cas d'impossibilité de se connecter.
     */
    public function getConnection(): PDO
    {
        try {
            // Options de configuration pour notre instance PDO.
            $options = [
                // Active le mode d'erreur sous forme d'exceptions pour pouvoir les intercepter avec try/catch.
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                // Configure le format de retour des données sous forme de tableau associatif.
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                // Désactive l'émulation des requêtes préparées pour utiliser le vrai moteur MySQL (plus sécurisé).
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];

            // ÉTAPE 1 : Connexion au serveur MySQL sans spécifier de base de données.
            // Cela évite que la connexion échoue si la base n'a pas encore été créée.
            $dsnWithoutDb = "mysql:host={$this->host};port={$this->port};charset=utf8mb4";
            $pdo = new PDO($dsnWithoutDb, $this->user, $this->password, $options);
            
            // ÉTAPE 2 : Création de la base de données si elle n'existe pas.
            // On configure le charset (jeu de caractères) en utf8mb4 pour le support des accents et caractères spéciaux.
            $pdo->exec("CREATE DATABASE IF NOT EXISTS `{$this->dbName}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
            
            // ÉTAPE 3 : Connexion finale en ciblant spécifiquement notre base de données "transit".
            $dsnWithDb = "mysql:host={$this->host};port={$this->port};dbname={$this->dbName};charset=utf8mb4";
            return new PDO($dsnWithDb, $this->user, $this->password, $options);
            
        } catch (PDOException $e) {
            // Interception des erreurs de connexion SQL pour les encapsuler dans une Exception générique plus lisible.
            throw new Exception("Erreur de connexion MySQL (WampServer) : " . $e->getMessage(), (int)$e->getCode());
        }
    }

    /**
     * Retourne le nom de la base de données.
     */
    public function getDbPath(): string
    {
        return $this->dbName;
    }
}
