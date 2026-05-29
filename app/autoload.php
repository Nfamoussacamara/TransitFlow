<?php
// Active le typage strict pour garantir la robustesse du code.
declare(strict_types=1);

/**
 * TransitPro - Autoloader Fait Maison (100% Vanilla PHP)
 * 
 * Ce fichier remplace intégralement l'autoloader généré par Composer.
 * Il utilise la fonction native PHP `spl_autoload_register` pour charger 
 * automatiquement les classes du projet à la volée en résolvant leurs Namespaces.
 */
spl_autoload_register(function (string $class) {
    // ÉTAPE 1 : Gestion spécifique de l'espace de noms App\Config\ (vers le dossier config/)
    $configPrefix = 'App\\Config\\';
    $configLen = strlen($configPrefix);
    
    if (strncmp($configPrefix, $class, $configLen) === 0) {
        // Extrait le nom de la classe après 'App\Config\' (ex: Database)
        $relativeClass = substr($class, $configLen);
        
        // Résout le chemin physique vers le dossier 'config/' situé au même niveau que 'app/'
        $file = __DIR__ . '/../config/' . str_replace('\\', DIRECTORY_SEPARATOR, $relativeClass) . '.php';
        
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }

    // ÉTAPE 2 : Gestion générale de l'espace de noms App\ (vers le dossier app/)
    $appPrefix = 'App\\';
    $appLen = strlen($appPrefix);
    
    if (strncmp($appPrefix, $class, $appLen) === 0) {
        // Extrait le nom de la classe après 'App\' (ex: Controllers\TransitController)
        $relativeClass = substr($class, $appLen);
        
        // Résout le chemin physique vers le dossier 'app/'
        $file = __DIR__ . '/' . str_replace('\\', DIRECTORY_SEPARATOR, $relativeClass) . '.php';
        
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});
