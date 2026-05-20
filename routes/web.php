<?php

// Importation des contrôleurs utilisés dans les routes.
use App\Controllers\TransitController; // Gère le Dashboard, les Expéditions, les Factures, les Paramètres.
use App\Controllers\AuthController;    // Gère la Connexion et la Déconnexion.

/**
 * Fichier de routage de l'application (routes/web.php)
 *
 * C'est ici que l'on déclare TOUTES les URLs accessibles par l'utilisateur.
 * Chaque route associe :
 *   - une méthode HTTP (GET pour afficher, POST pour soumettre un formulaire)
 *   - un chemin d'URL (ex: '/login')
 *   - un contrôleur et une méthode à exécuter (ex: AuthController::showLogin)
 *
 * Exemple de lecture :
 *   $router->get('/login', [AuthController::class, 'showLogin']);
 *   Signifie : "Quand l'utilisateur visite /login en GET, appeler la méthode showLogin() de AuthController."
 */

// =============================================
// ROUTES D'AUTHENTIFICATION (Publiques)
// Ces routes sont accessibles SANS être connecté.
// =============================================

// Affiche le formulaire de connexion (page login.php).
$router->get('/login', [AuthController::class, 'showLogin']);

// Reçoit les données du formulaire de connexion (username + password) et les vérifie.
$router->post('/login', [AuthController::class, 'login']);

// Déconnecte l'utilisateur et le renvoie vers la page de connexion.
$router->get('/logout', [AuthController::class, 'logout']);

// =============================================
// ROUTES PROTÉGÉES (Nécessitent une connexion)
// L'accès est filtré automatiquement dans le constructeur de TransitController.
// =============================================

// Page d'accueil : Tableau de Bord (Dashboard) avec les statistiques et la carte.
$router->get('/', [TransitController::class, 'dashboard']);

// Soumission du formulaire d'ajout ou de modification d'un transit.
$router->post('/', [TransitController::class, 'storeTransit']);

// Page listant toutes les expéditions de marchandises.
$router->get('/expeditions', [TransitController::class, 'expeditions']);

// Page listant toutes les factures générées.
$router->get('/factures', [TransitController::class, 'factures']);

// Page des paramètres (affichage du formulaire de configuration des tarifs et taxes).
$router->get('/settings', [TransitController::class, 'settings']);

// Soumission du formulaire de paramètres (enregistrement des tarifs et de la TVA).
$router->post('/settings', [TransitController::class, 'updateSettings']);
