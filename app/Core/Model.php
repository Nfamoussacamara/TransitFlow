<?php

// Définition de l'espace de noms pour les composants fondamentaux de notre mini-framework (Core).
namespace App\Core;

// Importation de la classe de configuration de base de données.
use App\Config\Database;
// Utilisation de la classe PDO native de PHP (PHP Data Objects) pour la connexion.
use PDO;

/**
 * Classe de base Model (non utilisée dans ce projet)
 *
 * POURQUOI CETTE CLASSE EXISTE-T-ELLE ?
 * ======================================
 * Dans de nombreux frameworks PHP (Laravel, Symfony...), les classes "Model" gèrent
 * directement la base de données. Ce fichier montre ce pattern classique.
 *
 * POURQUOI NE L'UTILISE-T-ON PAS ICI ?
 * ======================================
 * TransitPro suit une architecture plus moderne où :
 *   - Les MODÈLES (app/Models/) sont de simples objets de données (sans SQL).
 *   - Les REPOSITORIES (app/Repositories/) gèrent tout le SQL.
 *   - Les SERVICES (app/Services/) orchestrent la logique métier.
 *
 * Cette séparation est plus lisible et plus facile à tester unitairement.
 * Ce fichier est conservé à titre pédagogique pour montrer l'alternative.
 *
 * Si vous voulez ajouter une nouvelle fonctionnalité simple avec accès BDD direct,
 * vous pouvez étendre cette classe avec : class MonModel extends Model { ... }
 */
abstract class Model
{
    // Propriété protégée contenant l'instance active de la connexion PDO.
    protected PDO $db;

    // Le constructeur initialise automatiquement la connexion.
    public function __construct()
    {
        $dbConfig = new Database();
        $this->db = $dbConfig->getConnection();
    }
}
