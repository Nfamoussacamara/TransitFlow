<?php

// Définition de l'espace de noms pour les composants fondamentaux du framework (Core).
namespace App\Core;

/**
 * Classe Router
 * 
 * Enregistre les routes définies par l'application (en méthode GET et POST) 
 * et résout l'URL demandée pour appeler le bon contrôleur et la bonne méthode.
 */
class Router {
    // Tableau multidimensionnel associant la méthode HTTP (GET/POST) et le chemin d'URL à un callback.
    protected array $routes = [];

    /**
     * Enregistre une route HTTP GET.
     * 
     * @param string $path Le chemin d'URL (ex: '/dashboard').
     * @param mixed $callback Une fonction anonyme ou un tableau [NomClasseControleur, 'NomMethode'].
     */
    public function get($path, $callback) {
        $this->routes['GET'][$path] = $callback;
    }

    /**
     * Enregistre une route HTTP POST.
     * 
     * @param string $path Le chemin d'URL (ex: '/store').
     * @param mixed $callback Une fonction anonyme ou un tableau [NomClasseControleur, 'NomMethode'].
     */
    public function post($path, $callback) {
        $this->routes['POST'][$path] = $callback;
    }

    /**
     * Résout la route correspondant à la requête HTTP actuelle.
     * Détermine quelle méthode de quel contrôleur doit être exécutée.
     */
    public function resolve() {
        // Récupère la méthode HTTP de la requête actuelle (GET, POST, etc.).
        $method = $_SERVER['REQUEST_METHOD'];
        
        // --- GESTION DU FALLBACK D'URL (SANS MOD_REWRITE) ---
        // Si le serveur Apache/Wamp ne supporte pas la réécriture d'URL (.htaccess),
        // on peut passer par un paramètre 'url' dans la requête (ex: index.php?url=/dashboard).
        if (isset($_GET['url']) && $_GET['url'] !== '') {
            $path = '/' . ltrim($_GET['url'], '/');
        } else {
            // Sinon, on extrait le chemin directement de REQUEST_URI.
            $path = $_SERVER['REQUEST_URI'] ?? '/';
            // Nettoyage de l'URL pour enlever les dossiers d'installation sous Wamp.
            $path = str_replace('/transit', '', $path);
            $path = str_replace('/public', '', $path);
            // On sépare l'URL des paramètres de requête (tout ce qui est après le point d'interrogation '?').
            $path = explode('?', $path)[0];
            
            // Rétrocompatibilité : on nettoie les extensions '.php' et 'index.php' si présentes dans l'URL.
            $path = str_replace('index.php', '', $path);
            $path = str_replace('.php', '', $path);
            $path = rtrim($path, '/');
        }
        
        // Si l'URL finale est vide, on la remplace par le chemin par défaut '/' (racine).
        if ($path === '' || $path === '/') {
            $path = '/';
        }

        // On cherche s'il y a un callback enregistré pour la méthode HTTP et le chemin actuel.
        $callback = $this->routes[$method][$path] ?? false;

        // Si aucune route ne correspond (404) :
        if ($callback === false) {
            http_response_code(404); // Envoi du code HTTP 404 au navigateur.
            echo "<h1>Erreur 404 - Page introuvable</h1>";
            echo "<p>L'URL demandée n'existe pas dans le routeur.</p>";
            return;
        }

        // Si le callback est un tableau (ex: [TransitController::class, 'dashboard']) :
        if (is_array($callback)) {
            // Instancie dynamiquement le contrôleur (ex: new TransitController()).
            $controller = new $callback[0]();
            // Récupère le nom de la méthode à exécuter (ex: 'dashboard').
            $method = $callback[1];
            // Exécute la méthode sur l'objet contrôleur instancié.
            return $controller->$method();
        }

        // Si le callback est une fonction anonyme, on l'appelle directement.
        return call_user_func($callback);
    }
}
