<?php

// Définition de l'espace de noms pour organiser nos modèles.
namespace App\Models;

// Importation de la classe parente Entity depuis son espace de noms.
use App\Abstracts\Entity;

// La classe Ville hérite de la classe abstraite Entity.
class Ville extends Entity
{
    private string $nom;
    private Pays $pays;
    private ?float $latitude = null;
    private ?float $longitude = null;

    public function __construct(string $nom, Pays $pays, ?int $id = null) 
    {
        parent::__construct($id);
        $this->nom  = $nom;
        $this->pays = $pays;
    }

    public function getNom(): string { return $this->nom; }
    public function setNom(string $nom): void { $this->nom = $nom; }

    public function getPays(): Pays { return $this->pays; }
    public function setPays(Pays $pays): void { $this->pays = $pays; }

    public function getLatitude(): ?float { return $this->latitude; }
    public function setLatitude(?float $lat): void { $this->latitude = $lat; }

    public function getLongitude(): ?float { return $this->longitude; }
    public function setLongitude(?float $lng): void { $this->longitude = $lng; }

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

