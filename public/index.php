<?php
/**
 * TransitPro - Front Controller (Contrôleur Frontal Principal)
 *
 * C'est l'unique point d'entrée de toute l'application.
 * N'importe quelle URL demandée par l'utilisateur passe d'abord par ce fichier.
 *
 * Le cycle de vie d'une requête HTTP est le suivant :
 * 1. L'utilisateur visite une URL (ex: http://localhost/transit/?url=expeditions)
 * 2. Apache redirige la requête vers ce fichier index.php
 * 3. L'autoloader charge automatiquement toutes nos classes PHP
 * 4. La base de données est vérifiée/initialisée
 * 5. Le routeur analyse l'URL et appelle le bon Contrôleur → la bonne Méthode
 * 6. Le Contrôleur charge une Vue (HTML) qui est affichée à l'utilisateur
 */

// --- MODE DÉBOGAGE (À DÉSACTIVER EN PRODUCTION) ---
// Ces 3 lignes affichent les erreurs PHP à l'écran pendant le développement.
// En production, un vrai site web doit logger les erreurs dans un fichier, pas les afficher !
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

// --- ÉTAPE 1 : Chargement de l'Autoloader Composer ---
// Composer génère un fichier "autoload.php" qui sait où trouver chaque classe PHP du projet.
// Grâce à lui, on peut écrire "new App\Controllers\AuthController()" sans aucun require_once manuel.
require_once __DIR__ . '/../vendor/autoload.php';

// --- ÉTAPE 2 : Initialisation de la Base de Données ---
// Le DatabaseInitializer vérifie si les tables existent et crée le compte admin si nécessaire.
// Il s'exécute à chaque requête mais ne fait rien si la BDD est déjà en place (très rapide).
// Si une erreur critique survient (ex: MySQL éteint), on affiche un message clair et on stoppe.
try {
    $dbInitializer = new App\Services\DatabaseInitializer();
    $dbInitializer->initialize();
} catch (Exception $e) {
    die("Erreur critique d'initialisation de l'application : " . $e->getMessage());
}

// Import de la classe Router (nécessaire pour utiliser son nom court sans le namespace complet).
use App\Core\Router;

// --- ÉTAPE 3 : Création du Routeur ---
// Le routeur est l'aiguilleur central : il enregistre les associations URL → Contrôleur.
$router = new Router();

// --- ÉTAPE 4 : Chargement des Routes ---
// Le fichier routes/web.php déclare toutes les routes de l'application
// (ex: GET /login → AuthController::showLogin).
require_once __DIR__ . '/../routes/web.php';

// --- ÉTAPE 5 : Traitement de la Requête ---
// Le routeur analyse l'URL actuelle et appelle la méthode du bon contrôleur.
// C'est ici que la vraie logique de la page démarre.
$router->resolve();
