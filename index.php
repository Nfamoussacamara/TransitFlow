<?php
// Force le typage strict en PHP pour détecter les erreurs de types.
declare(strict_types=1);

/**
 * TransitFlow - Point d'Entrée Principal et Fallback (Racine du Projet)
 * 
 * Si le module Apache "mod_rewrite" n'est pas configuré ou activé sur WampServer,
 * l'URL de base pointera vers ce fichier racine au lieu du sous-dossier "public/".
 * 
 * Ce fichier sert donc de passerelle en incluant de manière transparente 
 * le vrai point d'entrée de production de l'application situé dans "public/index.php".
 */

// Définition d'une constante de contrôle pour signaler à l'application que le routage passe par la racine.
define('TRANSIT_FALLBACK_ROUTING', true);

// Inclusion et exécution immédiate du point d'entrée public de l'application.
require_once __DIR__ . '/public/index.php';
