<?php

// Importation du contrôleur principal qui va orchestrer les pages.
use App\Controllers\TransitController;

/**
 * Fichier de routage de l'application (routes/web.php)
 * 
 * Il déclare l'ensemble des chemins d'URL accessibles par l'utilisateur et les associe
 * aux méthodes correspondantes du TransitController.
 * 
 * Syntaxe :
 * - $router->get('/url', [Controleur::class, 'nomMethode']) : pour l'affichage de pages.
 * - $router->post('/url', [Controleur::class, 'nomMethode']) : pour le traitement de formulaires.
 */

// Route d'affichage du Tableau de Bord (Dashboard) principal.
$router->get('/', [TransitController::class, 'dashboard']);

// Route POST recevant la soumission du formulaire d'ajout ou de modification de transit.
$router->post('/', [TransitController::class, 'storeTransit']);

// Route d'affichage du registre des Expéditions (liste complète).
$router->get('/expeditions', [TransitController::class, 'expeditions']);

// Route d'affichage du registre comptable des Factures.
$router->get('/factures', [TransitController::class, 'factures']);

// Route d'affichage de la page de paramètres.
$router->get('/settings', [TransitController::class, 'settings']);

// Route de traitement du formulaire de paramètres.
$router->post('/settings', [TransitController::class, 'updateSettings']);
