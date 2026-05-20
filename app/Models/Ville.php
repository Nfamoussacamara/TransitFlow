<?php

// Définition de l'espace de noms pour organiser nos modèles.
namespace App\Models;

// Importation de la classe parente Entity depuis son espace de noms.
use App\Abstracts\Entity;

// La classe Ville hérite de la classe abstraite Entity.
class Ville extends Entity
{
    // Propriétés privées décrivant la Ville.
    private string $nom;               // Nom de la ville (ex: Conakry, Kankan).
    private Pays $pays;                 // Le pays associé (Objet de type Pays).
    private ?float $latitude = null;    // Coordonnée de latitude géographique pour l'affichage de carte.
    private ?float $longitude = null;   // Coordonnée de longitude géographique pour l'affichage de carte.

    // Constructeur de la classe Ville.
    // Reçoit le nom, l'objet pays et l'identifiant unique (optionnel).
    public function __construct(string $nom, Pays $pays, ?int $id = null) 
    {
        // Appel du constructeur parent (Entity) pour stocker l'ID de manière centralisée.
        parent::__construct($id);
        
        // Hydratation des propriétés.
        $this->nom  = $nom;
        $this->pays = $pays;
    }

    // Récupère le nom de la ville.
    public function getNom(): string 
    { 
        return $this->nom; 
    }

    // Modifie le nom de la ville.
    public function setNom(string $nom): void 
    { 
        $this->nom = $nom; 
    }

    // Récupère l'objet Pays associé.
    public function getPays(): Pays 
    { 
        return $this->pays; 
    }

    // Modifie l'objet Pays associé.
    public function setPays(Pays $pays): void 
    { 
        $this->pays = $pays; 
    }

    // Récupère la latitude géographique.
    public function getLatitude(): ?float 
    { 
        return $this->latitude; 
    }

    // Modifie la latitude géographique.
    public function setLatitude(?float $lat): void 
    { 
        $this->latitude = $lat; 
    }

    // Récupère la longitude géographique.
    public function getLongitude(): ?float 
    { 
        return $this->longitude; 
    }

    // Modifie la longitude géographique.
    public function setLongitude(?float $lng): void 
    { 
        $this->longitude = $lng; 
    }

    // Convertit la ville sous forme de tableau associatif.
    // Très utile pour l'envoi de données structurées aux vues ou formats JSON.
    public function toArray(): array
    {
        return [
            'id'        => $this->getId(),
            'nom'       => $this->nom,
            'pays'      => $this->pays->toArray(),
            'latitude'  => $this->latitude,
            'longitude' => $this->longitude,
        ];
    }
}

