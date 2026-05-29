<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Services\AuthService;
use App\Repositories\TransitRepository;
use Exception;

/**
 * AuthController - Contrôleur d'Authentification
 *
 * Gère sur l'unique page /login :
 *   - GET  /login  → Afficher le formulaire (connexion standard OU activation)
 *   - POST /login  → Connexion standard (admin → / | client → /client)
 *   - POST /login?action=check_email  → Vérifier l'email pour l'auto-activation
 *   - POST /login?action=activate     → Créer le compte client et connecter
 *   - GET  /logout → Fermer la session
 */
class AuthController extends Controller
{
    private AuthService $authService;
    private TransitRepository $repository;

    public function __construct()
    {
        $this->authService = new AuthService();
        $this->repository  = new TransitRepository();
    }

    /**
     * Affiche la page de connexion unifiée.
     * GET /login
     */
    public function showLogin(): void
    {
        $this->startSession();

        // Déjà connecté → rediriger selon le rôle
        if (isset($_SESSION['user_id'])) {
            $this->redirectByRole($_SESSION['role'] ?? 'admin');
            exit;
        }

        // Passe les variables à la vue (step = 'login' | 'set_password')
        $step  = $_GET['step'] ?? 'login';
        $email = htmlspecialchars($_GET['email'] ?? '');
        $error = $_GET['error'] ?? '';

        $this->view('login', compact('step', 'email', 'error'));
    }

    /**
     * Traite la soumission du formulaire de connexion (POST).
     *
     * URL associée : POST /login
     */
    public function login(): void
    {
        // Démarrage de la session pour pouvoir y écrire les données de l'utilisateur.
        $this->startSession();

        // On vérifie que la requête est bien de type POST (envoi d'un formulaire).
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/login');
            return;
        }

        // Aiguillage pour l'auto-activation du compte client
        $action = $_GET['action'] ?? '';
        if ($action === 'check_email') {
            $this->checkEmail();
            return;
        }
        if ($action === 'activate') {
            $this->activateAccount();
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

            if ($user && $this->authService->verifierMotDePasse($password, $user['password'])) {
                $_SESSION['user_id']   = $user['id'];
                $_SESSION['username']  = $user['username'];
                $_SESSION['role']      = $user['role'];
                $_SESSION['client_id'] = $user['client_id'] ?? null;

                $this->redirectByRole($user['role']);
                exit;
            }
        } catch (Exception $e) {
            $this->redirect('/login?error=Erreur+système');
            exit;
        }

        $this->redirect('/login?error=1');
        exit;
    }

    /**
     * Étape 1 de l'auto-activation : vérifier que l'email existe dans la table clients.
     * POST /login?action=check_email
     */
    private function checkEmail(): void
    {
        $email = trim($_POST['email'] ?? '');

        if ($email === '') {
            $this->redirect('/login?error=email_vide&step=activate');
            return;
        }

        // L'email est-il dans la table clients ?
        $clientId = $this->repository->findClientIdByEmail($email);

        if ($clientId === null) {
            // Email inconnu → aucune marchandise enregistrée
            $this->redirect('/login?error=email_inconnu&step=activate');
            return;
        }

        // Un compte utilisateur existe-t-il déjà pour ce client ?
        $compte = $this->repository->findUtilisateurByClientId($clientId);

        if ($compte !== null) {
            // Compte déjà actif → rediriger vers connexion standard
            $this->redirect('/login?error=deja_actif');
            return;
        }

        // Email valide, pas encore de compte → étape 2 : choisir un mot de passe
        $emailEncode = urlencode($email);
        $this->redirect("/login?step=set_password&email={$emailEncode}");
    }

    /**
     * Étape 2 de l'auto-activation : créer le compte client et connecter.
     * POST /login?action=activate
     */
    private function activateAccount(): void
    {
        $this->startSession();

        $email    = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirm  = $_POST['password_confirm'] ?? '';

        if ($email === '' || $password === '') {
            $this->redirect('/login?error=champs_manquants&step=set_password&email=' . urlencode($email));
            return;
        }

        if ($password !== $confirm) {
            $this->redirect('/login?error=mdp_diff&step=set_password&email=' . urlencode($email));
            return;
        }

        $clientId = $this->repository->findClientIdByEmail($email);

        if ($clientId === null) {
            $this->redirect('/login?error=email_inconnu');
            return;
        }

        // Créer le compte utilisateur lié au client
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $this->authService->createClientAccount($email, $hashed, $clientId);

        // Connecter directement
        $user = $this->authService->findUserByUsername($email);
        if ($user) {
            $_SESSION['user_id']   = $user['id'];
            $_SESSION['username']  = $user['username'];
            $_SESSION['role']      = 'client';
            $_SESSION['client_id'] = $clientId;
        }

        $this->redirect('/client');
        exit;
    }

    /**
     * Redirige l'utilisateur selon son rôle.
     */
    private function redirectByRole(string $role): void
    {
        if ($role === 'client') {
            $this->redirect('/client');
        } else {
            $this->redirect('/dashboard');
        }
    }

    /**
     * Déconnecte l'utilisateur.
     * GET /logout
     */
    public function logout(): void
    {
        $this->startSession();

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
