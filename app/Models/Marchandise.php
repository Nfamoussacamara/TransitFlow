<?php

// Définition de l'espace de noms pour organiser nos modèles.
namespace App\Models;

// Importation de la classe parente Entity.
use App\Abstracts\Entity;

// La classe Marchandise hérite de la classe abstraite Entity.
class Marchandise extends Entity
{
    // Propriétés privées de la marchandise.
    private string $designation; // Libellé / description de la marchandise (ex: Sacs de riz, Ordinateurs).
    private float $poids;         // Poids en kilogrammes (float = nombre décimal).
    private float $surface;       // Surface au sol en mètres carrés (m²).
    private string $etat;         // État de la marchandise (ex: Neuf, Usagé, Périssable).
    private Client $client;       // Le client (propriétaire) lié à cette marchandise.

    // Constructeur de la classe Marchandise.
    // Prend tous les attributs nécessaires pour caractériser une cargaison.
    public function __construct(string $designation, float $poids, float $surface, string $etat, Client $client, ?int $id = null) 
    {
        // Appel du constructeur de la classe parente Entity pour enregistrer l'ID.
        parent::__construct($id);
        
        // Hydratation des propriétés privées de notre instance de Marchandise.
        $this->designation = $designation;
        $this->poids = $poids;
        $this->surface = $surface;
        $this->etat = $etat;
        $this->client = $client;
    }

    // Récupère la désignation.
    public function getDesignation(): string
    {
        return $this->designation;
    }

    // Modifie la désignation.
    public function setDesignation(string $designation): void
    {
        $this->designation = $designation;
    }

    // Récupère le poids.
    public function getPoids(): float
    {
        return $this->poids;
    }

    // Modifie le poids.
    public function setPoids(float $poids): void
    {
        $this->poids = $poids;
    }

    // Récupère la surface.
    public function getSurface(): float
    {
        return $this->surface;
    }

    // Modifie la surface.
    public function setSurface(float $surface): void
    {
        $this->surface = $surface;
    }

    // Récupère l'état physique (Neuf, Usagé, Périssable) sous forme de chaîne de caractères.
    public function getEtat(): string
    {
        return $this->etat;
    }

    // Modifie l'état physique.
    public function setEtat(string $etat): void
    {
        $this->etat = $etat;
    }

    // Récupère l'objet Client.
    public function getClient(): Client
    {
        return $this->client;
    }

    // Modifie le client.
    public function setClient(Client $client): void
    {
        $this->client = $client;
    }

    // Convertit l'objet Marchandise sous forme de tableau associatif.
    // Note : $this->etat est une simple chaîne de caractères désormais, pas besoin de appeler ->value.
    public function toArray(): array
    {
        return [
            'id'          => $this->getId(),
            'designation' => $this->designation,
            'poids'       => $this->poids,
            'surface'     => $this->surface,
            'etat'        => $this->etat,
            'client'      => $this->client->toArray(),
        ];
    }
}

