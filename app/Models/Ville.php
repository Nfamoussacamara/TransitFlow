<?php

// Définition de l'espace de noms pour organiser nos modèles.
namespace App\Models;

// Importation de la classe parente Entity depuis son espace de noms.
use App\Abstracts\Entity;

// La classe Ville hérite de la classe abstraite Entity.
class Ville extends Entity
{
    // Propriété privée contenant le nom de la ville (ex: Conakry, Kankan).
    private string $nom;

    // Propriété de type Pays (notion d'association/composition : une ville appartient à un Pays).
    private Pays $pays;

    // Constructeur de la classe Ville.
    // Il nécessite le nom de la ville (string), un objet de type Pays, et optionnellement un ID.
    public function __construct(string $nom, Pays $pays, ?int $id = null) 
    {
        // Appel du constructeur parent (Entity) pour stocker l'ID.
        parent::__construct($id);
        
        // Affectation des valeurs passées en paramètres aux propriétés de notre objet.
        $this->nom = $nom;
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

    // Récupère l'objet Pays auquel est rattachée la ville.
    public function getPays(): Pays
    {
        return $this->pays;
    }

    // Modifie ou met à jour le Pays de cette ville.
    public function setPays(Pays $pays): void
    {
        $this->pays = $pays;
    }

    // Convertit l'objet Ville et l'objet Pays associé sous forme de tableau associatif.
    // L'appel à $this->pays->toArray() démontre la récursivité de la sérialisation en tableau.
    public function toArray(): array
    {
        return [
            'id'   => $this->getId(),
            'nom'  => $this->nom,
            'pays' => $this->pays->toArray(),
        ];
    }
}

