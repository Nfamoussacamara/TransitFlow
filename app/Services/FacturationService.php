<?php
// "declare(strict_types=1)" active le typage strict en PHP.
// Si une fonction attend un "float" et qu'on lui passe un "string", PHP lèvera une erreur au lieu d'essayer de convertir.
declare(strict_types=1);

// Définition de l'espace de noms pour organiser nos services métiers.
namespace App\Services;

// Importation de l'interface Facturable.
use App\Interfaces\Facturable;

/**
 * TransitPro - Service FacturationService
 * 
 * Classe responsable de la logique purement financière de l'application.
 * Elle est découplée des détails du modèle de base de données.
 * En utilisant l'interface Facturable (DIP - Dependency Inversion Principle),
 * ce service peut facturer n'importe quel objet qui implémente cette interface (pas seulement un Transit).
 */
class FacturationService
{
    /**
     * Calcule le montant brut hors taxes (HT).
     * Règle métier : Quantité (base de calcul) multipliée par le Tarif Unitaire.
     * 
     * @param Facturable $entite N'importe quel objet implémentant l'interface Facturable.
     * @return float Le montant brut calculé.
     */
    public function calculerMontantBrut(Facturable $entite): float
    {
        // Récupère la base de calcul (ex: poids ou surface) et le tarif unitaire, puis fait la multiplication.
        return $entite->getBaseCalcul() * $entite->getTarifUnitaire();
    }

    /**
     * Calcule le montant final toutes taxes comprises (TTC).
     * Règle comptable : Montant Brut HT * (1 + Taux TVA).
     * Par défaut, le taux de TVA légal est fixé à 20% (0.20).
     * 
     * @param Facturable $entite L'objet à facturer.
     * @param float $tauxTva Taux de TVA applicable (par défaut 0.20).
     * @return float Le montant TTC calculé.
     */
    public function calculerMontantTtc(Facturable $entite, float $tauxTva = 0.20): float
    {
        // On calcule d'abord le montant brut HT à l'aide de la méthode ci-dessus.
        $brut = $this->calculerMontantBrut($entite);
        
        // On applique la formule mathématique pour ajouter la taxe.
        return $brut * (1.0 + $tauxTva);
    }
}

