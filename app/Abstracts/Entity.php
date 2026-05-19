<?php

// Définition de l'espace de noms (namespace) pour organiser nos classes.
// Cela évite les collisions de noms de classes si plusieurs classes s'appellent pareil.
namespace App\Abstracts;

// Déclaration d'une classe abstraite. Une classe abstraite sert de modèle/parent.
// On ne peut pas l'instancier directement (on ne peut pas faire $e = new Entity()).
// Elle est faite pour être héritée par d'autres classes (ex: Marchandise, Transit, etc.).
abstract class Entity
{
    // Propriété protégée (accessible par la classe elle-même et ses classes enfants).
    // Le type "?int" signifie que l'identifiant peut être un entier (int) ou nul (null).
    protected ?int $id;

    // Le constructeur est la méthode appelée automatiquement lors de la création d'un objet (new).
    // On lui passe un identifiant optionnel (par défaut null si l'entité n'est pas encore en base de données).
    public function __construct(?int $id = null) 
    {
        // On affecte l'identifiant reçu en paramètre à la propriété protégée de l'objet ($this->id).
        $this->id = $id;
    }

    // Un "getter" : méthode publique permettant de récupérer la valeur de l'identifiant depuis l'extérieur.
    // Elle renvoie un entier ou null (?int).
    public function getId(): ?int
    {
        return $this->id;
    }

    // Un "setter" : méthode publique permettant de modifier l'identifiant de l'entité.
    // Utile par exemple après avoir inséré l'entité en base de données pour lui attribuer son ID généré.
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    // Déclaration d'une méthode abstraite.
    // Toutes les classes enfants (ex: Marchandise, Facture) devront OBLIGATOIREMENT implémenter cette méthode.
    // Elle permet de convertir l'objet et ses données sous forme de tableau associatif simple (clé => valeur).
    abstract public function toArray(): array;
}

