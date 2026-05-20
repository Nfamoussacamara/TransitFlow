<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Services\AuthService;
use Exception;

/**
 * AuthController - Contrôleur d'Authentification
 *
 * Ce contrôleur gère toutes les actions liées à la connexion/déconnexion :
 *   - GET  /login  → Afficher le formulaire de connexion
 *   - POST /login  → Vérifier les identifiants et ouvrir la session
 *   - GET  /logout → Fermer la session et déconnecter l'utilisateur
 *
 * RÔLE D'UN CONTRÔLEUR (rappel MVC) :
 * =====================================
 * Un contrôleur reçoit la requête HTTP, appelle les services métiers
 * et décide quoi afficher. Il ne contient pas de SQL ni de HTML.
 *
 * Il hérite de Controller (app/Core/Controller.php) pour utiliser :
 *   - $this->view('nom_vue')    → Afficher une page HTML
 *   - $this->redirect('/url')   → Rediriger vers une autre page
 */
class AuthController extends Controller
{
    // Le service qui gère la logique de vérification des utilisateurs.
    private AuthService $authService;

    /**
     * Le constructeur instancie le service d'authentification.
     */
    public function __construct()
    {
        // On instancie AuthService qui contient toute la logique liée aux utilisateurs.
        $this->authService = new AuthService();
    }

    /**
     * Affiche l'écran de connexion.
     *
     * URL associée : GET /login
     */
    public function showLogin(): void
    {
        // On démarre la session PHP si elle n'est pas déjà active.
        // La session permet de mémoriser l'utilisateur connecté entre les pages.
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // SÉCURITÉ : Si l'utilisateur est déjà connecté (sa session existe),
        // on le redirige directement vers le Dashboard. Inutile de lui montrer le login.
        if (isset($_SESSION['user_id'])) {
            $this->redirect('/');
            exit;
        }

        // Sinon, on affiche la vue login.php.
        $this->view('login');
    }

    /**
     * Traite la soumission du formulaire de connexion (POST).
     *
     * URL associée : POST /login
     */
    public function login(): void
    {
        // Démarrage de la session pour pouvoir y écrire les données de l'utilisateur.
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // On vérifie que la requête est bien de type POST (envoi d'un formulaire).
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/login');
            return;
        }

        // --- ÉTAPE 1 : Récupération et nettoyage des données du formulaire ---
        // trim() supprime les espaces vides au début et à la fin de la saisie.
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        // Si l'un des deux champs est vide, on renvoie vers le login avec une erreur.
        if ($username === '' || $password === '') {
            $this->redirect('/login?error=1');
            return;
        }

        try {
            // --- ÉTAPE 2 : Recherche de l'utilisateur en base de données ---
            // On délègue la recherche SQL à AuthService (pas de SQL ici dans le contrôleur).
            $user = $this->authService->findUserByUsername($username);

            // --- ÉTAPE 3 : Vérification du mot de passe ---
            // On délègue la vérification du hash à AuthService.
            if ($user && $this->authService->verifierMotDePasse($password, $user['password'])) {

                // CONNEXION RÉUSSIE :
                // On enregistre les informations clés de l'utilisateur dans la session du serveur.
                // La session est stockée côté serveur (pas dans le navigateur), donc sécurisée.
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];

                // On redirige vers l'accueil (Dashboard).
                $this->redirect('/');
                exit;
            }

        } catch (Exception $e) {
            // En cas de panne de base de données, on redirige avec un message d'erreur clair.
            $this->redirect('/login?error=' . urlencode("Erreur système. Veuillez réessayer."));
            exit;
        }

        // IDENTIFIANTS INCORRECTS : on recharge la page de login avec le paramètre error=1.
        $this->redirect('/login?error=1');
        exit;
    }

    /**
     * Déconnecte l'utilisateur en détruisant sa session.
     *
     * URL associée : GET /logout
     */
    public function logout(): void
    {
        // Démarrage de la session pour pouvoir la manipuler.
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // ÉTAPE 1 : On vide toutes les variables stockées dans $_SESSION.
        $_SESSION = [];

        // ÉTAPE 2 : On supprime le cookie de session dans le navigateur (PHPSESSID).
        // C'est une bonne pratique pour s'assurer que le navigateur oublie complètement la session.
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        // ÉTAPE 3 : On détruit la session côté serveur.
        session_destroy();

        // ÉTAPE 4 : Redirection vers la page de connexion.
        $this->redirect('/login');
        exit;
    }
}
