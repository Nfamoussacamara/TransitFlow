<?php
/**
 * TransitPro - Custom PSR-4 Autoloader
 * 
 * Émule le comportement de Composer pour charger dynamiquement les classes
 * en respectant les conventions PSR-4.
 */

spl_autoload_register(function ($class) {
    // Liste des namespaces cartographiés et de leurs dossiers correspondants
    $prefixes = [
        'App\\Config\\' => __DIR__ . '/../config/',
        'App\\' => __DIR__ . '/../app/',
    ];

    foreach ($prefixes as $prefix => $baseDir) {
        // Est-ce que la classe utilise ce préfixe de namespace ?
        $len = strlen($prefix);
        if (strncmp($prefix, $class, $len) !== 0) {
            continue;
        }

        // Récupérer le nom relatif de la classe (sans le préfixe de namespace)
        $relativeClass = substr($class, $len);

        // Remplacer les séparateurs de namespace par des séparateurs de dossiers et ajouter .php
        $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

        // Si le fichier existe, on le charge
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});
