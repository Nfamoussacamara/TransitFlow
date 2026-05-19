<?php

// Définition de l'espace de noms pour organiser nos modèles.
namespace App\Models;

// Importation de la classe parente Entity.
use App\Abstracts\Entity;

// La classe ModeTransport hérite de la classe abstraite Entity.
class ModeTransport extends Entity
{
    // Propriétés privées décrivant le moyen de routage.
    private string $nom;           // Nom commercial du transport (ex: TransGuinée Express, Cargo Maritime Soguipah).
    private string $type;          // Type physique de transport (ex: Maritime, Aérien, Terrestre, Ferroviaire).
    private float $tarifUnitaire;  // Coût unitaire appliqué au calcul de facturation.

    // Constructeur de la classe ModeTransport.
    public function __construct(string $nom, string $type, float $tarifUnitaire, ?int $id = null) 
    {
        // Appel du constructeur parent (Entity) pour stocker l'ID de manière centralisée.
        parent::__construct($id);
        
        // Hydratation des propriétés de notre objet.
        $this->nom = $nom;
        $this->type = $type;
        $this->tarifUnitaire = $tarifUnitaire;
    }

    // Récupère le nom commercial.
    public function getNom(): string
    {
        return $this->nom;
    }

    // Modifie le nom commercial.
    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }

    // Récupère le type de transport (Maritime, Aérien, Terrestre, Ferroviaire).
    public function getType(): string
    {
        return $this->type;
    }

    // Modifie le type de transport.
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    // Récupère le tarif unitaire.
    public function getTarifUnitaire(): float
    {
        return $this->tarifUnitaire;
    }

    // Modifie le tarif unitaire.
    public function setTarifUnitaire(float $tarifUnitaire): void
    {
        $this->tarifUnitaire = $tarifUnitaire;
    }

    // Convertit le mode de transport sous forme de tableau associatif.
    // Note : $this->type est une chaîne simple (string) suite au retrait des Enums, donc pas de ->value.
    public function toArray(): array
    {
        return [
            'id'            => $this->getId(),
            'nom'           => $this->nom,
            'type'          => $this->type,
            'tarifUnitaire' => $this->tarifUnitaire,
        ];
    }
}

