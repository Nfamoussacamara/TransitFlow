<?php

// Définition de l'espace de noms pour les composants fondamentaux du framework (Core).
namespace App\Core;

/**
 * Classe abstraite de base Controller
 * 
 * Tous les contrôleurs du projet en héritent pour bénéficier des fonctions
 * utilitaires de rendu de vue (view) et de redirection HTTP (redirect).
 */
abstract class Controller {

    /**
     * Démarre la session PHP de manière sécurisée si elle n'est pas déjà active.
     */
    protected function startSession(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Vérifie si l'utilisateur est connecté. Redirige vers /login sinon.
     * 
     * @param string|null $requiredRole Rôle optionnel requis (ex: 'admin' ou 'client').
     */
    protected function checkAuth(?string $requiredRole = null): void {
        $this->startSession();

        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
            exit;
        }

        if ($requiredRole !== null && ($_SESSION['role'] ?? '') !== $requiredRole) {
            // Si l'utilisateur est connecté mais n'a pas le bon rôle.
            $this->redirect('/login?error=unauthorized');
            exit;
        }
    }
    
    /**
     * Charge un fichier de Vue PHP et lui transmet un tableau de données.
     * 
     * @param string $view Le nom de la vue à charger (sans l'extension .php).
     * @param array $data Tableau associatif contenant les variables à transmettre à la vue.
     */
    protected function view(string $view, array $data = []) {
        // La fonction native PHP extract() transforme les clés d'un tableau associatif en variables réelles.
        // Exemple : ['nom' => 'Jean'] devient la variable $nom avec la valeur 'Jean' dans l'environnement de la vue.
        extract($data);
        
        // Construction du chemin absolu menant au fichier de la vue.
        $viewPath = __DIR__ . "/../Views/" . $view . ".php";
        
        // Vérification de sécurité pour s'assurer que le fichier existe bien avant de l'inclure.
        if (file_exists($viewPath)) {
            // Inclusion et exécution de la vue (le code HTML et PHP est rendu).
            require_once $viewPath;
        } else {
            // Arrêt propre du script en cas d'erreur de développement.
            die("La vue '$view' n'existe pas.");
        }
    }

    /**
     * Effectue une redirection HTTP (Header Location) propre.
     * 
     * @param string $url L'URL relative ou le paramètre de requête vers lequel rediriger.
     */
    protected function redirect(string $url) {
        // Normalisation de l'URL pour ajouter un slash de début si nécessaire.
        if ($url !== '' && $url[0] !== '/' && $url[0] !== '?') {
            $url = '/' . $url;
        }
        // Même chose si l'URL commence par un paramètre de type '?'.
        if ($url !== '' && $url[0] === '?') {
            $url = '/' . $url;
        }
        // Envoi de l'en-tête HTTP de redirection.
        // "/transit" correspond au dossier virtuel sur Wamp.
        header("Location: /transit" . $url);
        // On stoppe immédiatement l'exécution pour s'assurer que la redirection soit traitée par le navigateur.
        exit();
    }
}
