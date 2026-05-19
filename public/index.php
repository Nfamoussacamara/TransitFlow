<?php
/**
 * TransitFlow - Front Controller (Contrôleur Frontal Principal)
 * 
 * C'est l'unique point d'entrée de toute l'application. 
 * N'importe quelle URL demandée par l'utilisateur passe d'abord par ce fichier.
 * Il se charge d'initialiser l'environnement PHP, de charger les bibliothèques (autoload),
 * d'instancier le Routeur et de déléguer le travail au bon contrôleur.
 */

// Configuration PHP de développement : Affiche toutes les erreurs et warnings à l'écran.
// À désactiver absolument en production pour ne pas afficher de failles de sécurité.
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

// ÉTAPE 1 : Chargement de l'autoloader généré par Composer.
// Cela nous évite d'utiliser des 'require_once' à chaque fois qu'on veut utiliser une classe PHP.
require_once __DIR__ . '/../vendor/autoload.php';

// Importation de la classe Router depuis son espace de noms.
use App\Core\Router;

// ÉTAPE 2 : Instanciation du Routeur central de l'application.
$router = new Router();

// ÉTAPE 3 : Chargement du fichier de configuration des routes (qui contient les associations URL <=> Contrôleur).
require_once __DIR__ . '/../routes/web.php';

// ÉTAPE 4 : Résolution de la requête.
// Compare l'URL visitée avec les routes définies ci-dessus et appelle la bonne méthode.
$router->resolve();
