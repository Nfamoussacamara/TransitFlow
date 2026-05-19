<?php

// Définition de l'espace de noms pour organiser nos modèles.
namespace App\Models;

// Importation des dépendances.
use App\Abstracts\Entity;
use DateTimeImmutable; // Manipulation de dates immuables.

// La classe Facture hérite de la classe abstraite Entity.
class Facture extends Entity
{
    // Propriétés privées de la Facture.
    private string $numero;                     // Numéro unique de facture (ex: FAC-0001).
    private float $montantBrut;                 // Montant HT de la facture.
    private float $montantTtc;                  // Montant TTC (TVA 20% incluse).
    private float $baseDeCalcul;                // Quantité de base logistique calculée (poids ou surface).
    private DateTimeImmutable $dateFacturation; // Date et heure de l'émission de la facture.
    private Transit $transit;                   // Le transit concerné par cette facturation (Objet Transit).

    // Constructeur de la classe Facture.
    public function __construct(string $numero, float $montantBrut, float $montantTtc, float $baseDeCalcul, DateTimeImmutable $dateFacturation, Transit $transit, ?int $id = null) 
    {
        // Enregistre l'ID via la classe parente.
        parent::__construct($id);
        
        // Hydratation de notre objet Facture.
        $this->numero = $numero;
        $this->montantBrut = $montantBrut;
        $this->montantTtc = $montantTtc;
        $this->baseDeCalcul = $baseDeCalcul;
        $this->dateFacturation = $dateFacturation;
        $this->transit = $transit;
    }

    // Récupère le numéro de facture.
    public function getNumero(): string
    {
        return $this->numero;
    }

    // Modifie le numéro de facture.
    public function setNumero(string $numero): void
    {
        $this->numero = $numero;
    }

    // Récupère le montant brut (HT).
    public function getMontantBrut(): float
    {
        return $this->montantBrut;
    }

    // Modifie le montant brut.
    public function setMontantBrut(float $montantBrut): void
    {
        $this->montantBrut = $montantBrut;
    }

    // Récupère le montant TTC.
    public function getMontantTtc(): float
    {
        return $this->montantTtc;
    }

    // Modifie le montant TTC.
    public function setMontantTtc(float $montantTtc): void
    {
        $this->montantTtc = $montantTtc;
    }

    // Récupère la base de calcul (poids ou surface).
    public function getBaseDeCalcul(): float
    {
        return $this->baseDeCalcul;
    }

    // Modifie la base de calcul.
    public function setBaseDeCalcul(float $baseDeCalcul): void
    {
        $this->baseDeCalcul = $baseDeCalcul;
    }

    // Récupère la date de facturation.
    public function getDateFacturation(): DateTimeImmutable
    {
        return $this->dateFacturation;
    }

    // Modifie la date de facturation.
    public function setDateFacturation(DateTimeImmutable $dateFacturation): void
    {
        $this->dateFacturation = $dateFacturation;
    }

    // Récupère le Transit associé.
    public function getTransit(): Transit
    {
        return $this->transit;
    }

    // Modifie le Transit associé.
    public function setTransit(Transit $transit): void
    {
        $this->transit = $transit;
    }

    // Convertit la facture en tableau associatif simple.
    public function toArray(): array
    {
        return [
            'id'              => $this->getId(),
            'numero'          => $this->numero,
            'montantBrut'     => $this->montantBrut,
            'montantTtc'      => $this->montantTtc,
            'baseDeCalcul'    => $this->baseDeCalcul,
            'dateFacturation' => $this->dateFacturation->format('Y-m-d H:i:s'),
            'transit'         => $this->transit->toArray(),
        ];
    }
}

