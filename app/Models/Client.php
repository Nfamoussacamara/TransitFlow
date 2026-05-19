<?php

// Définition de l'espace de noms pour organiser nos modèles.
namespace App\Models;

// Importation de la classe parente Entity.
use App\Abstracts\Entity;

// La classe Client hérite de la classe abstraite Entity.
class Client extends Entity
{
    // Propriété privée contenant le nom du client (ex: Alpha Diallo, Fatoumata Camara).
    private string $nom;

    // Propriété privée contenant l'adresse email du client.
    private string $email;

    // Constructeur de la classe Client.
    // Reçoit le nom, l'email et l'identifiant unique (optionnel).
    public function __construct(string $nom, string $email, ?int $id = null) 
    {
        // Appel du constructeur parent (Entity) pour stocker l'ID.
        parent::__construct($id);
        
        // Affectation des valeurs reçues en paramètres aux propriétés correspondantes.
        $this->nom = $nom;
        $this->email = $email;
    }

    // Récupère le nom du client.
    public function getNom(): string
    {
        return $this->nom;
    }

    // Modifie le nom du client.
    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }

    // Récupère l'adresse email du client.
    public function getEmail(): string
    {
        return $this->email;
    }

    // Modifie l'adresse email du client.
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    // Retourne le client sous forme de tableau associatif.
    public function toArray(): array
    {
        return [
            'id'    => $this->getId(),
            'nom'   => $this->nom,
            'email' => $this->email,
        ];
    }
}

