<?php

// Définition de l'espace de noms pour organiser nos interfaces.
namespace App\Interfaces;

/**
 * Interface Facturable
 * 
 * Définit le contrat que doit respecter tout objet pouvant être facturé par le FacturationService.
 * Grâce à cette interface, le service de facturation ne dépend pas d'un modèle concret (comme Transit)
 * mais uniquement des méthodes nécessaires au calcul.
 */
interface Facturable
{
    /**
     * Récupère la base de calcul (ex: poids en kg, surface en m², etc.).
     * 
     * @return float
     */
    public function getBaseCalcul(): float;

    /**
     * Récupère le tarif unitaire applicable.
     * 
     * @return float
     */
    public function getTarifUnitaire(): float;
}
