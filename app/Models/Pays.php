<?php

// Définition de l'espace de noms pour organiser nos modèles.
namespace App\Models;

// Importation de la classe parente Entity depuis son espace de noms.
use App\Abstracts\Entity;

// La classe Pays hérite de la classe abstraite Entity (notion d'héritage).
// Cela signifie qu'elle possède automatiquement la propriété $id et ses getters/setters.
class Pays extends Entity
{
    // Propriété privée contenant le nom du pays (ex: Guinée, Sénégal).
    // Le type "string" garantit qu'il s'agit obligatoirement d'une chaîne de caractères.
    private string $nom;

    // Constructeur de la classe Pays.
    // On lui transmet le nom du pays et éventuellement un ID (optionnel, null par défaut).
    public function __construct(string $nom, ?int $id = null) 
    {
        // Appel du constructeur de la classe parente (Entity) pour stocker l'ID de manière sécurisée.
        parent::__construct($id);
        
        // Affectation du nom reçu à la propriété de l'objet ($this->nom).
        $this->nom = $nom;
    }

    // Récupère le nom du pays.
    public function getNom(): string
    {
        return $this->nom;
    }

    // Modifie le nom du pays.
    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }

    // Implémentation obligatoire de la méthode abstraite toArray() définie dans Entity.php.
    // Cette méthode retourne un tableau associatif avec les clés 'id' et 'nom'.
    public function toArray(): array
    {
        return [
            'id'  => $this->getId(),
            'nom' => $this->nom,
        ];
    }
}

