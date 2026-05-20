<?php
declare(strict_types=1);

namespace App\Services;

use App\Config\Database;
use PDO;

/**
 * AuthService - Service d'authentification
 *
 * Ce service est responsable de TOUTE la logique liée aux utilisateurs :
 *   - Rechercher un utilisateur par son pseudo (username)
 *   - Vérifier que son mot de passe correspond au hash stocké en base
 *
 * POURQUOI un Service séparé ?
 * ============================
 * En architecture MVC propre, un Contrôleur ne doit PAS exécuter des requêtes SQL.
 * Son rôle est uniquement d'orchestrer : recevoir la requête, appeler le bon service,
 * puis décider quoi afficher ou vers où rediriger.
 *
 * Grâce à ce service, AuthController ne "sait" plus comment fonctionne la base de données.
 * Il sait juste qu'il peut appeler findUserByUsername() et obtenir un résultat.
 */
class AuthService
{
    // La connexion PDO partagée par toutes les méthodes de ce service.
    private PDO $pdo;

    /**
     * Le constructeur se connecte automatiquement à la base de données.
     */
    public function __construct()
    {
        $dbConfig = new Database();
        $this->pdo = $dbConfig->getConnection();
    }

    /**
     * Cherche un utilisateur dans la base de données par son pseudo.
     *
     * @param string $username Le pseudo saisi dans le formulaire de connexion.
     * @return array|false Un tableau avec les données de l'utilisateur, ou false s'il n'existe pas.
     */
    public function findUserByUsername(string $username): array|false
    {
        // On prépare une requête SQL sécurisée avec un paramètre nommé (:username).
        // Cela empêche les injections SQL (attaque très courante sur les formulaires de login).
        $stmt = $this->pdo->prepare("SELECT * FROM utilisateurs WHERE username = :username LIMIT 1");
        $stmt->execute([':username' => $username]);

        // fetch() retourne un tableau associatif si l'utilisateur existe, ou false sinon.
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Vérifie qu'un mot de passe brut correspond au hash stocké en base.
     *
     * POURQUOI password_verify() ?
     * ============================
     * On ne stocke jamais les mots de passe en clair en base de données.
     * On stocke un "hash" (empreinte chiffrée) généré par password_hash().
     * password_verify() compare le mot de passe saisi par l'utilisateur
     * avec ce hash pour valider ou rejeter la connexion.
     *
     * @param string $motDePasseBrut  Le mot de passe saisi dans le formulaire.
     * @param string $hashEnBase      Le hash stocké en base de données.
     * @return bool true si le mot de passe est correct, false sinon.
     */
    public function verifierMotDePasse(string $motDePasseBrut, string $hashEnBase): bool
    {
        return password_verify($motDePasseBrut, $hashEnBase);
    }
}
