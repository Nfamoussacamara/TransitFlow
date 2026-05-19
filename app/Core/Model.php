<?php

// Définition de l'espace de noms pour les composants fondamentaux de notre mini-framework (Core).
namespace App\Core;

// Importation de la classe de configuration de base de données.
use App\Config\Database;
// Utilisation de la classe PDO native de PHP (PHP Data Objects) pour la connexion.
use PDO;

/**
 * Classe de base Model
 * 
 * Toutes les classes modèles nécessitant un accès direct à la base de données
 * peuvent hériter de cette classe pour hériter automatiquement de la connexion PDO ($this->db).
 */
abstract class Model {
    // Propriété protégée contenant l'instance active de la connexion PDO.
    protected PDO $db;

    // Le constructeur initialise automatiquement la connexion.
    public function __construct() {
        $dbConfig = new Database();
        $this->db = $dbConfig->getConnection();
    }
}
