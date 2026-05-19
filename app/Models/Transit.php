<?php

// Définition de l'espace de noms pour organiser nos modèles.
namespace App\Models;

// Importation des dépendances.
use App\Abstracts\Entity;
use App\Interfaces\Facturable; // Importation de l'interface Facturable.
use DateTimeImmutable; // Classe native de PHP pour manipuler des dates de manière immuable (non modifiables après création).

// La classe Transit hérite de la classe abstraite Entity et implémente l'interface Facturable.
class Transit extends Entity implements Facturable
{
    // Propriétés privées représentant le cycle de vie du Transit de marchandise.
    private ?Facture $facture = null;         // La facture liée (peut être nulle si pas encore émise).
    private Ville $villeDepart;               // Ville de départ (Objet de type Ville).
    private Ville $villeArrivee;              // Ville de destination (Objet de type Ville).
    private DateTimeImmutable $dateDepart;    // Date de début d'expédition.
    private DateTimeImmutable $dateArrivee;   // Date de livraison estimée ou réelle.
    private Marchandise $marchandise;         // Marchandise transportée (Objet de type Marchandise).
    private ModeTransport $modeTransport;     // Mode de routage (Objet de type ModeTransport).

    // Constructeur de la classe Transit.
    public function __construct(
        Ville $villeDepart,
        Ville $villeArrivee,
        DateTimeImmutable $dateDepart,
        DateTimeImmutable $dateArrivee,
        Marchandise $marchandise,
        ModeTransport $modeTransport,
        ?int $id = null
    ) {
        // Enregistre l'ID via le constructeur parent.
        parent::__construct($id);
        
        // Hydratation de notre objet.
        $this->villeDepart = $villeDepart;
        $this->villeArrivee = $villeArrivee;
        $this->dateDepart = $dateDepart;
        $this->dateArrivee = $dateArrivee;
        $this->marchandise = $marchandise;
        $this->modeTransport = $modeTransport;
    }

    // Récupère la Facture liée au transit.
    public function getFacture(): ?Facture
    {
        return $this->facture;
    }

    // Associe une Facture à ce transit.
    public function setFacture(?Facture $facture): void
    {
        $this->facture = $facture;
    }

    // Récupère la Ville de départ.
    public function getVilleDepart(): Ville
    {
        return $this->villeDepart;
    }

    // Modifie la Ville de départ.
    public function setVilleDepart(Ville $villeDepart): void
    {
        $this->villeDepart = $villeDepart;
    }

    // Récupère la Ville d'arrivée.
    public function getVilleArrivee(): Ville
    {
        return $this->villeArrivee;
    }

    // Modifie la Ville d'arrivée.
    public function setVilleArrivee(Ville $villeArrivee): void
    {
        $this->villeArrivee = $villeArrivee;
    }

    // Récupère la Date de départ.
    public function getDateDepart(): DateTimeImmutable
    {
        return $this->dateDepart;
    }

    // Modifie la Date de départ.
    public function setDateDepart(DateTimeImmutable $dateDepart): void
    {
        $this->dateDepart = $dateDepart;
    }

    // Récupère la Date d'arrivée.
    public function getDateArrivee(): DateTimeImmutable
    {
        return $this->dateArrivee;
    }

    // Modifie la Date d'arrivée.
    public function setDateArrivee(DateTimeImmutable $dateArrivee): void
    {
        $this->dateArrivee = $dateArrivee;
    }

    // Récupère l'objet Marchandise associé.
    public function getMarchandise(): Marchandise
    {
        return $this->marchandise;
    }

    // Modifie la Marchandise.
    public function setMarchandise(Marchandise $marchandise): void
    {
        $this->marchandise = $marchandise;
    }

    // Récupère le Mode de transport.
    public function getModeTransport(): ModeTransport
    {
        return $this->modeTransport;
    }

    // Modifie le Mode de transport.
    public function setModeTransport(ModeTransport $modeTransport): void
    {
        $this->modeTransport = $modeTransport;
    }

    // Génère un libellé complet décrivant l'itinéraire et la marchandise de manière conviviale.
    public function getLibelle(): string
    {
        return sprintf(
            "Transit de '%s' (Via %s) de %s vers %s",
            $this->marchandise->getDesignation(),
            $this->modeTransport->getNom(),
            $this->villeDepart->getNom(),
            $this->villeArrivee->getNom()
        );
    }

    // Règle métier : retourne la grandeur physique utilisée pour facturer (RG3/RG4).
    // Si transport Maritime, la facturation se fait sur la Surface (m²).
    // Sinon (Aérien, Terrestre, Ferroviaire), elle se fait sur le Poids (kg).
    public function getBaseCalcul(): float
    {
        $type = $this->modeTransport->getType();

        if ($type === 'Maritime') {
            return $this->marchandise->getSurface();
        }

        return $this->marchandise->getPoids();
    }

    // Récupère le tarif unitaire du moyen de transport lié.
    public function getTarifUnitaire(): float
    {
        return $this->modeTransport->getTarifUnitaire();
    }

    // Calcule dynamiquement le statut actuel du transit en comparant l'heure actuelle avec les dates.
    public function getStatut(): string
    {
        $now = new \DateTimeImmutable();
        if ($now < $this->dateDepart) {
            return 'Programmé';
        }
        if ($now > $this->dateArrivee) {
            return 'Livré';
        }
        return 'En cours';
    }

    // Détermine la classe CSS de badge appropriée selon le statut calculé.
    public function getStatutClass(): string
    {
        $statut = $this->getStatut();
        if ($statut === 'Programmé') {
            return 'badge-slate'; // Gris pour programmé
        }
        if ($statut === 'Livré') {
            return 'badge-cyan';  // Cyan pour livré
        }
        return 'badge-indigo';    // Indigo pour en cours
    }

    // Convertit le transit complet sous forme de tableau associatif.
    // Cette structure est idéale pour sérialiser en JSON et envoyer à l'interface Javascript.
    public function toArray(): array
    {
        return [
            'id'            => $this->getId(),
            'villeDepart'   => $this->villeDepart->toArray(),
            'villeArrivee'  => $this->villeArrivee->toArray(),
            'dateDepart'    => $this->dateDepart->format('Y-m-d H:i:s'),
            'dateArrivee'   => $this->dateArrivee->format('Y-m-d H:i:s'),
            'marchandise'   => $this->marchandise->toArray(),
            'modeTransport' => $this->modeTransport->toArray(),
            'baseCalcul'    => $this->getBaseCalcul(),
            'libelle'       => $this->getLibelle(),
            'statut'        => $this->getStatut(),
            'statut_class'  => $this->getStatutClass(),
        ];
    }
}

