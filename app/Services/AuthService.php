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
     * @param string $motDePasseBrut  Le mot de passe saisi dans le formulaire.
     * @param string $hashEnBase      Le hash stocké en base de données.
     * @return bool true si le mot de passe est correct, false sinon.
     */
    public function verifierMotDePasse(string $motDePasseBrut, string $hashEnBase): bool
    {
        return password_verify($motDePasseBrut, $hashEnBase);
    }

    /**
     * Crée un compte utilisateur de type 'client' lié à un client existant.
     * L'email du client est utilisé comme identifiant (username).
     *
     * @param string $email     L'email (servira d'identifiant username).
     * @param string $hashed    Le mot de passe déjà haché.
     * @param int    $clientId  L'ID du client dans la table clients.
     */
    public function createClientAccount(string $email, string $hashed, int $clientId): void
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO utilisateurs (username, password, role, client_id) VALUES (:username, :password, 'client', :client_id)"
        );
        $stmt->execute([
            ':username'  => $email,
            ':password'  => $hashed,
            ':client_id' => $clientId,
        ]);
    }
}
