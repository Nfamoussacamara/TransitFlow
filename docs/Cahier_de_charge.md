Cahier des Charges — Système de Gestion de Transit de Marchandises (PHP 8.2+ POO Moderne)

Ce document spécifie l'architecture orientée objet (POO) pour la mise en place d'un système de gestion de transit de marchandises. La structure, le code et l'organisation sont conformes aux standards de production professionnels modernes (SOLID, PSR-4, Enums, typage strict et immuabilité).

---

## 1. Structure du projet (Norme PSR-4)

L'architecture est structurée de manière modulaire sous un espace de noms `App\`. Les fichiers sources résident dans le dossier `src/` et l'autoloading est géré par **Composer** via la norme **PSR-4** afin d'éviter l'usage d'inclusions manuelles (`require_once`).

```
transit/
├── config/
│   └── Database.php             # Connexion PDO configurable
├── src/
│   ├── Abstracts/
│   │   └── Entity.php           # Classe de base pour toutes les entités (DRY)
│   ├── Enums/
│   │   ├── TypeTransport.php     # Enumération des types de transport autorisés
│   │   └── EtatMarchandise.php   # Enumération des états de marchandise
│   ├── Interfaces/
│   │   └── Facturable.php        # Contrat de facturation (DIP & OCP)
│   ├── Models/
│   │   ├── Pays.php
│   │   ├── Ville.php
│   │   ├── Client.php
│   │   ├── Marchandise.php
│   │   ├── ModeTransport.php
│   │   ├── Transit.php
│   │   └── Facture.php
│   └── Services/
│       └── FacturationService.php # Logique métier de facturation
├── composer.json                # Fichier de configuration Composer
└── index.php                    # Point d'entrée de démonstration
```

---

## 2. Configuration d'Autoloading (`composer.json`)

Le fichier `composer.json` déclare le namespace racine `App\` pointant vers le dossier `src/` ainsi que le dossier `config/` (mappé sous `App\Config\`).

```json
{
    "name": "app/transit",
    "description": "Système de Gestion de Transit de Marchandises en PHP POO",
    "type": "project",
    "require": {
        "php": ">=8.2"
    },
    "autoload": {
        "psr-4": {
            "App\\": "src/",
            "App\\Config\\": "config/"
        }
    }
}
```

---

## 3. Interface `Facturable`

L'interface définit le contrat formel pour toute entité du domaine nécessitant une facturation. Elle applique le principe **DIP** (Dependency Inversion) et **OCP** (Open/Closed), permettant d'ajouter de nouvelles entités facturables sans modifier la logique du service de facturation.

```php
<?php
declare(strict_types=1);

namespace App\Interfaces;

/**
 * Interface Facturable
 * Contrat à respecter par toute entité soumise à une facturation financière.
 */
interface Facturable
{
    /**
     * Calcule le montant à facturer selon les règles métier de l'entité.
     * @return float Le montant calculé
     */
    public function calculerMontant(): float;

    /**
     * Retourne le libellé de la base de calcul ("poids (kg)" ou "surface (m²)").
     * @return string
     */
    public function getBaseDeCalcul(): string;
}
```

---

## 4. Classe abstraite `Entity`

Classe mère de toutes les entités persistantes. Elle factorise l'identifiant commun (`id`) pour respecter le principe **DRY** (Don't Repeat Yourself) et définit un contrat de sérialisation.

```php
<?php
declare(strict_types=1);

namespace App\Abstracts;

/**
 * Classe abstraite Entity
 * Classe mère assurant l'unicité structurelle de chaque entité.
 */
abstract class Entity
{
    /**
     * Constructeur de base.
     * @param int|null $id Identifiant unique de l'entité (null si nouvelle entité)
     */
    public function __construct(
        protected ?int $id = null
    ) {}

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * Représente l'état de l'entité sous forme de tableau associatif.
     * @return array
     */
    abstract public function toArray(): array;
}
```

---

## 5. Énumérations (Enums PHP 8.1+)

L'usage des Enums élimine définitivement les chaînes de caractères arbitraires ("magic strings"), prévenant ainsi les erreurs de saisie et centralisant les valeurs autorisées directement dans le moteur PHP.

### A. Enum `TypeTransport`
```php
<?php
declare(strict_types=1);

namespace App\Enums;

/**
 * Enum TypeTransport
 * Représente les modes de transport légaux pris en charge par le système.
 */
enum TypeTransport: string
{
    case TERRESTRE   = 'terrestre';
    case AERIEN      = 'aerien';
    case FERROVIAIRE = 'ferroviaire';
    case MARITIME    = 'maritime';
}
```

### B. Enum `EtatMarchandise`
```php
<?php
declare(strict_types=1);

namespace App\Enums;

/**
 * Enum EtatMarchandise
 * Représente l'état d'avancement d'un transit de marchandise.
 */
enum EtatMarchandise: string
{
    case EN_ATTENTE = 'en attente';
    case EN_TRANSIT = 'en transit';
    case LIVRE      = 'livré';
}
```

---

## 6. Modèle `Pays`

Représente un pays géographique. Classe simple utilisant les propriétés modernes de PHP.

```php
<?php
declare(strict_types=1);

namespace App\Models;

use App\Abstracts\Entity;

/**
 * Classe Pays
 */
class Pays extends Entity
{
    public function __construct(
        private string $nom,
        ?int $id = null
    ) {
        parent::__construct($id);
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }

    public function toArray(): array
    {
        return [
            'id'  => $this->id,
            'nom' => $this->nom,
        ];
    }
}
```

---

## 7. Modèle `Ville`

Représente une ville rattachée à un pays. Ce modèle démontre le concept de **composition** (une ville CONTIENT un pays).

```php
<?php
declare(strict_types=1);

namespace App\Models;

use App\Abstracts\Entity;

/**
 * Classe Ville
 */
class Ville extends Entity
{
    public function __construct(
        private string $nom,
        private readonly Pays $pays,
        ?int $id = null
    ) {
        parent::__construct($id);
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function getPays(): Pays
    {
        return $this->pays;
    }

    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }

    public function toArray(): array
    {
        return [
            'id'   => $this->id,
            'nom'  => $this->nom,
            'pays' => $this->pays->toArray(),
        ];
    }
}
```

---

## 8. Modèle `Client`

Représente l'expéditeur ou propriétaire des marchandises. Le constructeur réalise des **validations strictes** sur le format des coordonnées.

```php
<?php
declare(strict_types=1);

namespace App\Models;

use App\Abstracts\Entity;
use InvalidArgumentException;

/**
 * Classe Client
 */
class Client extends Entity
{
    public function __construct(
        private string $nom,
        private string $email,
        private string $telephone,
        ?int $id = null
    ) {
        // Validation stricte du format email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("L'adresse email '$email' est au format invalide.");
        }

        if (empty(trim($telephone))) {
            throw new InvalidArgumentException("Le numéro de téléphone est obligatoire.");
        }

        parent::__construct($id);
    }

    public function getNom(): string { return $this->nom; }
    public function getEmail(): string { return $this->email; }
    public function getTelephone(): string { return $this->telephone; }

    public function setNom(string $nom): void { $this->nom = $nom; }

    public function setEmail(string $email): void
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("L'adresse email '$email' est au format invalide.");
        }
        $this->email = $email;
    }

    public function setTelephone(string $telephone): void
    {
        if (empty(trim($telephone))) {
            throw new InvalidArgumentException("Le numéro de téléphone ne peut être vide.");
        }
        $this->telephone = $telephone;
    }

    public function toArray(): array
    {
        return [
            'id'        => $this->id,
            'nom'       => $this->nom,
            'email'     => $this->email,
            'telephone' => $this->telephone,
        ];
    }
}
```

---

## 9. Modèle `ModeTransport`

Définit les modalités tarifaires applicables selon le mode sélectionné. Le type est strictement restreint via l'Enum `TypeTransport`.

```php
<?php
declare(strict_types=1);

namespace App\Models;

use App\Abstracts\Entity;
use App\Enums\TypeTransport;

/**
 * Classe ModeTransport
 */
class ModeTransport extends Entity
{
    public function __construct(
        private TypeTransport $type,
        private float $tarif,
        ?int $id = null
    ) {
        parent::__construct($id);
    }

    public function getType(): TypeTransport { return $this->type; }
    public function getTarif(): float { return $this->tarif; }

    public function setType(TypeTransport $type): void { $this->type = $type; }
    public function setTarif(float $tarif): void { $this->tarif = $tarif; }

    /**
     * Encapsule la règle métier (RG3) identifiant la facturation sur surface.
     * @return bool
     */
    public function estMaritime(): bool
    {
        return $this->type === TypeTransport::MARITIME;
    }

    public function toArray(): array
    {
        return [
            'id'    => $this->id,
            'type'  => $this->type->value,
            'tarif' => $this->tarif,
        ];
    }
}
```

---

## 10. Modèle `Marchandise`

Représente la charge physique transportée. Utilise la promotion de propriétés PHP 8 et intègre les validations de contraintes (CI2).

```php
<?php
declare(strict_types=1);

namespace App\Models;

use App\Abstracts\Entity;
use App\Enums\EtatMarchandise;
use InvalidArgumentException;

/**
 * Classe Marchandise
 */
class Marchandise extends Entity
{
    public function __construct(
        private string $designation,
        private float $poids,
        private float $surface,
        private EtatMarchandise $etat,
        private readonly Client $client,
        private Ville $villeActuelle,
        ?int $id = null
    ) {
        // Contrainte d'intégrité CI2 : poids > 0 et surface > 0
        if ($poids <= 0 || $surface <= 0) {
            throw new InvalidArgumentException(
                "Le poids (kg) et la surface (m²) doivent être strictement positifs."
            );
        }

        parent::__construct($id);
    }

    public function getDesignation(): string { return $this->designation; }
    public function getPoids(): float { return $this->poids; }
    public function getSurface(): float { return $this->surface; }
    public function getEtat(): EtatMarchandise { return $this->etat; }
    public function getClient(): Client { return $this->client; }
    public function getVilleActuelle(): Ville { return $this->villeActuelle; }

    public function setDesignation(string $designation): void { $this->designation = $designation; }

    public function setPoids(float $poids): void
    {
        if ($poids <= 0) {
            throw new InvalidArgumentException("Le poids doit être strictement positif.");
        }
        $this->poids = $poids;
    }

    public function setSurface(float $surface): void
    {
        if ($surface <= 0) {
            throw new InvalidArgumentException("La surface doit être strictement positive.");
        }
        $this->surface = $surface;
    }

    public function setEtat(EtatMarchandise $etat): void { $this->etat = $etat; }
    public function setVilleActuelle(Ville $ville): void { $this->villeActuelle = $ville; }

    public function toArray(): array
    {
        return [
            'id'            => $this->id,
            'designation'   => $this->designation,
            'poids'         => $this->poids,
            'surface'       => $this->surface,
            'etat'          => $this->etat->value,
            'client'        => $this->client->toArray(),
            'villeActuelle' => $this->villeActuelle->toArray(),
        ];
    }
}
```

---

## 11. Modèle `Transit` (Implémentant `Facturable`)

Le modèle `Transit` représente l'opération de transport physique. Il implémente désormais formellement l'interface `Facturable`, résolvant la faiblesse de découplage SOLID. Les dates sont immuables (`DateTimeImmutable`) pour prévenir toute mutation inattendue, et une validation chronologique a été ajoutée.

```php
<?php
declare(strict_types=1);

namespace App\Models;

use App\Abstracts\Entity;
use App\Interfaces\Facturable;
use App\Enums\EtatMarchandise;
use DateTimeImmutable;
use InvalidArgumentException;

/**
 * Classe Transit
 * Gère une expédition de marchandise et implémente le contrat Facturable.
 */
class Transit extends Entity implements Facturable
{
    public function __construct(
        private readonly Marchandise $marchandise,
        private readonly Ville $villeDepart,
        private readonly Ville $villeArrivee,
        private readonly ModeTransport $modeTransport,
        private readonly DateTimeImmutable $dateDepart,
        private ?DateTimeImmutable $dateArrivee = null,
        ?int $id = null
    ) {
        // Contrainte d'intégrité CI1 : ville départ ≠ ville arrivée
        if ($villeDepart->getId() === $villeArrivee->getId()) {
            throw new InvalidArgumentException(
                "La ville de départ ne peut pas être identique à la ville d'arrivée."
            );
        }

        // Validation temporelle de base
        if ($dateArrivee !== null && $dateArrivee < $dateDepart) {
            throw new InvalidArgumentException(
                "La date d'arrivée ne peut pas être antérieure à la date de départ."
            );
        }

        parent::__construct($id);
    }

    public function getMarchandise(): Marchandise { return $this->marchandise; }
    public function getVilleDepart(): Ville { return $this->villeDepart; }
    public function getVilleArrivee(): Ville { return $this->villeArrivee; }
    public function getModeTransport(): ModeTransport { return $this->modeTransport; }
    public function getDateDepart(): DateTimeImmutable { return $this->dateDepart; }
    public function getDateArrivee(): ?DateTimeImmutable { return $this->dateArrivee; }

    /**
     * Finalise le transit et met à jour l'état de la marchandise (traçabilité).
     * @param DateTimeImmutable $dateArrivee
     * @throws InvalidArgumentException
     */
    public function enregistrerArrivee(DateTimeImmutable $dateArrivee): void
    {
        if ($dateArrivee < $this->dateDepart) {
            throw new InvalidArgumentException(
                "La date d'arrivée enregistrée ne peut pas être antérieure à la date de départ."
            );
        }

        $this->dateArrivee = $dateArrivee;
        $this->marchandise->setVilleActuelle($this->villeArrivee);
        $this->marchandise->setEtat(EtatMarchandise::LIVRE);
    }

    /**
     * Calcule le montant conformément aux règles métier.
     * Contrat de l'interface Facturable (DIP/OCP).
     * @return float
     */
    public function calculerMontant(): float
    {
        $tarif = $this->modeTransport->getTarif();

        if ($this->modeTransport->estMaritime()) {
            // RG3 : maritime → surface × tarif au m²
            return $this->marchandise->getSurface() * $tarif;
        }

        // RG4 : terrestre / aérien / ferroviaire → poids × tarif au kg
        return $this->marchandise->getPoids() * $tarif;
    }

    /**
     * Retourne la base de calcul.
     * Contrat de l'interface Facturable (DIP/OCP).
     * @return string
     */
    public function getBaseDeCalcul(): string
    {
        return $this->modeTransport->estMaritime()
            ? 'surface (m²)'
            : 'poids (kg)';
    }

    public function toArray(): array
    {
        return [
            'id'           => $this->id,
            'marchandise'  => $this->marchandise->toArray(),
            'villeDepart'  => $this->villeDepart->toArray(),
            'villeArrivee' => $this->villeArrivee->toArray(),
            'modeTransport'=> $this->modeTransport->toArray(),
            'dateDepart'   => $this->dateDepart->format('Y-m-d H:i:s'),
            'dateArrivee'  => $this->dateArrivee?->format('Y-m-d H:i:s'),
        ];
    }
}
```

---

## 12. Service `FacturationService`

Totalement découplé de la classe concrète `Transit` grâce à l'inversion des dépendances. Il peut désormais calculer n'importe quelle entité implémentant l'interface `Facturable`.

```php
<?php
declare(strict_types=1);

namespace App\Services;

use App\Interfaces\Facturable;

/**
 * Classe FacturationService
 * Applique la logique métier globale et le calcul sur des interfaces (DIP).
 */
class FacturationService
{
    /**
     * Calcule le montant d'une entité facturable.
     * @param Facturable $entite
     * @return float
     */
    public function calculerMontant(Facturable $entite): float
    {
        return $entite->calculerMontant();
    }

    /**
     * Retourne le libellé de la base de calcul.
     * @param Facturable $entite
     * @return string
     */
    public function getBaseDeCalcul(Facturable $entite): string
    {
        return $entite->getBaseDeCalcul();
    }
}
```

---

## 13. Modèle `Facture` (Immuable)

La classe `Facture` est un document financier historique. Son constructeur n'appelle plus de service métier pour éviter le problème d'altération comptable lors de l'hydratation SQL (rechargement depuis la base de données). Le montant calculé est stocké comme une valeur brute immuable.

```php
<?php
declare(strict_types=1);

namespace App\Models;

use App\Abstracts\Entity;
use DateTimeImmutable;

/**
 * Classe Facture
 * Représente un enregistrement comptable historique et immuable.
 */
class Facture extends Entity
{
    public function __construct(
        private readonly Transit $transit,
        private readonly float $montant,
        private readonly string $baseDeCalcul,
        private readonly DateTimeImmutable $dateEmission,
        ?int $id = null
    ) {
        parent::__construct($id);
    }

    public function getTransit(): Transit { return $this->transit; }
    public function getMontant(): float { return $this->montant; }
    public function getBaseDeCalcul(): string { return $this->baseDeCalcul; }
    public function getDateEmission(): DateTimeImmutable { return $this->dateEmission; }

    /**
     * Affiche un résumé structuré de la facture.
     * @return string
     */
    public function afficher(): string
    {
        $t = $this->transit;
        return sprintf(
            "FACTURE #%d | Client : %s | Trajet : %s → %s | Mode : %s | Base : %s | Montant : %.2f € | Émise le : %s",
            $this->id ?? 0,
            $t->getMarchandise()->getClient()->getNom(),
            $t->getVilleDepart()->getNom(),
            $t->getVilleArrivee()->getNom(),
            $t->getModeTransport()->getType()->value,
            $this->baseDeCalcul,
            $this->montant,
            $this->dateEmission->format('Y-m-d H:i')
        );
    }

    public function toArray(): array
    {
        return [
            'id'           => $this->id,
            'transit_id'   => $this->transit->getId(),
            'montant'      => $this->montant,
            'baseDeCalcul' => $this->baseDeCalcul,
            'dateEmission' => $this->dateEmission->format('Y-m-d H:i:s'),
        ];
    }
}
```

---

## 14. Connexion Base de Données (`config/Database.php`)

Suppression du pattern Singleton rigide et sécurisation des identifiants (externalisés). La classe instancie et configure un objet PDO configurable, idéal pour l'injection de dépendances et les tests unitaires.

```php
<?php
declare(strict_types=1);

namespace App\Config;

use PDO;
use PDOException;

/**
 * Classe Database
 * Fournit une connexion PDO sécurisée et hautement testable.
 */
class Database
{
    private PDO $pdo;

    /**
     * Constructeur acceptant les paramètres de configuration (sans valeurs en dur).
     */
    public function __construct(
        string $dsn,
        string $username,
        string $password,
        array $options = []
    ) {
        $defaultOptions = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $this->pdo = new PDO($dsn, $username, $password, array_replace($defaultOptions, $options));
        } catch (PDOException $e) {
            throw new PDOException("Erreur de connexion à la base de données : " . $e->getMessage(), (int)$e->getCode());
        }
    }

    /**
     * Retourne l'instance brute de PDO prête à l'emploi.
     * @return PDO
     */
    public function getPdo(): PDO
    {
        return $this->pdo;
    }
}
```

---

## 15. Démonstration (`index.php`)

Démonstration moderne du système utilisant l'autoloader PSR-4, les dates immuables, les Enums et la logique de facturation découplée.

```php
<?php
declare(strict_types=1);

// Utilisation de l'autoloader généré par Composer
require_once __DIR__ . '/vendor/autoload.php';

use App\Models\Pays;
use App\Models\Ville;
use App\Models\Client;
use App\Models\Marchandise;
use App\Models\ModeTransport;
use App\Models\Transit;
use App\Models\Facture;
use App\Enums\TypeTransport;
use App\Enums\EtatMarchandise;
use App\Services\FacturationService;

try {
    // --- 1. Géographie ---
    $france  = new Pays('France', 1);
    $guinee  = new Pays('Guinée', 2);

    $paris   = new Ville('Paris', $france, 1);
    $conakry = new Ville('Conakry', $guinee, 2);

    // --- 2. Acteurs ---
    $client = new Client('Mamadou Diallo', 'mamadou@email.com', '+224 620 000 000', 1);

    // --- 3. Cargaison (500kg, 12m²) ---
    $marchandise = new Marchandise(
        'Équipements électroniques',
        500.0,
        12.0,
        EtatMarchandise::EN_ATTENTE,
        $client,
        $paris,
        1
    );

    // --- 4. Service de facturation ---
    $serviceFacturation = new FacturationService();

    // --- 5. TEST TRANSIT MARITIME (Facturation sur Surface) ---
    $modeMaritime = new ModeTransport(TypeTransport::MARITIME, 15.0, 1); // 15€ / m²
    $transitMaritime = new Transit(
        $marchandise,
        $paris,
        $conakry,
        $modeMaritime,
        new DateTimeImmutable('2025-06-01 08:00:00'),
        null,
        1
    );

    // Calcul en amont par le service
    $montantMaritime = $serviceFacturation->calculerMontant($transitMaritime);
    $baseMaritime    = $serviceFacturation->getBaseDeCalcul($transitMaritime);

    // Création d'une facture immuable historique
    $factureMaritime = new Facture(
        $transitMaritime,
        $montantMaritime,
        $baseMaritime,
        new DateTimeImmutable(),
        1
    );

    echo $factureMaritime->afficher();
    // Sortie attendue : → Montant = 12 m² × 15 €/m² = 180.00 €
    echo "\n";

    // --- 6. TEST TRANSIT AÉRIEN (Facturation sur Poids) ---
    $modeAerien = new ModeTransport(TypeTransport::AERIEN, 3.5, 2); // 3.5€ / kg
    $transitAerien = new Transit(
        $marchandise,
        $paris,
        $conakry,
        $modeAerien,
        new DateTimeImmutable('2025-06-05 10:00:00'),
        null,
        2
    );

    // Calcul en amont par le service
    $montantAerien = $serviceFacturation->calculerMontant($transitAerien);
    $baseAerien    = $serviceFacturation->getBaseDeCalcul($transitAerien);

    $factureAerienne = new Facture(
        $transitAerien,
        $montantAerien,
        $baseAerien,
        new DateTimeImmutable(),
        2
    );

    echo $factureAerienne->afficher();
    // Sortie attendue : → Montant = 500 kg × 3.5 €/kg = 1750.00 €
    echo "\n";

    // --- 7. Traçabilité : Enregistrement de l'arrivée ---
    echo "État initial de la marchandise : " . $marchandise->getEtat()->value . "\n";
    echo "Ville actuelle initiale : " . $marchandise->getVilleActuelle()->getNom() . "\n";

    // Simulation de l'arrivée
    $transitMaritime->enregistrerArrivee(new DateTimeImmutable('2025-06-15 14:30:00'));

    echo "Nouvel état de la marchandise : " . $marchandise->getEtat()->value . "\n";
    echo "Nouvelle ville actuelle : " . $marchandise->getVilleActuelle()->getNom() . "\n";

} catch (Exception $e) {
    echo "Erreur système : " . $e->getMessage() . "\n";
}
```

---

## 16. Récapitulatif des principes POO appliqués

| Concept POO | Application dans le projet moderne |
| :--- | :--- |
| **Encapsulation** | Tous les attributs sont `private` ou `protected` ; accès contrôlé uniquement via des getters/setters validants. |
| **Héritage** | `Pays`, `Ville`, `Client`, `Transit` et `Facture` héritent de la classe de base abstraite `Entity`. |
| **Abstraction** | Classe `Entity` abstraite avec méthode `toArray()` abstraite obligatoire pour toutes les classes filles. |
| **Interface (Contrat)** | L'interface `Facturable` définit le contrat de calcul des montants. |
| **Composition** | Une `Ville` contient un `Pays` ; une `Marchandise` contient un `Client` et une `Ville` ; un `Transit` contient ses entités liées. |
| **Enums (PHP 8.1+)** | `TypeTransport` et `EtatMarchandise` pour sécuriser absolument les valeurs autorisées au niveau du compilateur. |
| **Immuabilité** | Utilisation de `readonly`, de `DateTimeImmutable` et gel comptable direct dans le modèle `Facture`. |
| **Inversion de Dépendances (DIP)** | `FacturationService` ne dépend pas de la classe concrète `Transit` mais de l'interface `Facturable`. |
| **Single Responsibility (SRP)** | Le calcul financier est délégué à `FacturationService` ; les détails de persistance sont déconnectés. |
| **Promotion de Propriétés** | Syntaxe allégée PHP 8.2+ dans tous les constructeurs de modèles (zéro boilerplate). |
| **Contraintes d'intégrité** | Exceptions strictes de type `InvalidArgumentException` levées lors des violations de contraintes métiers (CI1, CI2). |

---

## 17. Spécifications de l'Interface Graphique (IHM UI/UX)

Pour assurer une expérience utilisateur moderne et fluide, le système de transit intègre un tableau de bord (Dashboard) visuel. L'esthétique générale s'inspire du **Design System IdentiGuinée**, standardisant l'affichage autour du composant haut de gamme **`DashboardCard`**.

### 17.1. Principes Esthétiques & Charte Graphique (Aesthetic Tokens)
- **Palette Monochromatique "Logistics Blue"** :
  - **Fonds / Surfaces** : Blanc pur et gris-bleu ultra-doux (`hsl(214, 32%, 98%)`) pour Light Mode / Bleu nuit ardoise sombre (`hsl(222, 47%, 11%)`) pour Dark Mode.
  - **Couleur de Base (Marque)** : Bleu Royal IdentiGuinée (`hsl(217, 91%, 60%)` / `rgb(59, 130, 246)`).
  - **Bleu Slate (Acier)** : Représente le fret et le tonnage (`hsl(215, 16%, 47%)` / `rgb(71, 85, 105)`).
  - **Bleu Cyan (Turquoise)** : Représente la réussite financière (`hsl(188, 86%, 43%)` / `rgb(6, 182, 212)`).
  - **Bleu Indigo (Électrique)** : Représente les actions rapides (`hsl(239, 84%, 67%)` / `rgb(99, 102, 241)`).
- **Typographie** : Utilisation exclusive des polices de caractères Google Fonts **Outfit** (pour les titres) et **Inter** (pour le texte courant).
- **Clean Border & Flat Look** : Abandon des contours lourds au profit de la bordure ultra-douce signature (`rgba(0, 0, 0, 0.03)`) d'IdentiGuinée, offrant un aspect épuré et haut de gamme.

---

### 17.2. Identité Visuelle : Emplacement & Spécification du Logo

Pour asseoir la légitimité de l'application, un espace réservé de premier choix est alloué au **Logo de la Marque** (baptisée **TransitPro**). Cet emplacement garantit une lisibilité maximale et une reconnaissance instantanée, que ce soit sur ordinateur ou sur mobile.

#### A. Emplacement Structurel dans la Mise en Page (Layout Pages)
- **Mise en page Desktop (Sidebar Layout)** : Le logo est ancré en **haut à gauche** dans l'en-tête de la barre de navigation latérale fixe (`.sidebar-header`). Il bénéficie d'une marge de respiration de `1.5rem` autour du bloc.
- **Mise en page Mobile (Header Layout)** : Le logo est positionné à **gauche** dans la barre supérieure de navigation (`height: 70px`). Un bouton menu hamburger se situe à l'opposé (à droite).

#### B. Structure HTML & Réservation d'Espace du Logo :
```html
<div class="brand-logo-container">
    <a href="index.php" class="brand-logo-link">
        <!-- Icône Logo stylisée (TransitPro Arrow/Cargo) -->
        <div class="brand-logo-mark">
            <svg viewBox="0 0 24 24" class="logo-svg">
                <path d="M4 15l8-8 8 8" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/>
                <path d="M4 19l8-8 8 8" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" opacity="0.5"/>
            </svg>
        </div>
        <!-- Typographie de marque en Outfit -->
        <span class="brand-logo-text">Transit<span class="text-accent">Flow</span></span>
    </a>
</div>
```

#### C. Spécifications CSS pour le Logo & Alignement :
```css
/* Conteneur principal du Logo */
.brand-logo-container {
    display: flex;
    align-items: center;
    padding: 1.5rem 1.75rem;
    height: 70px;
    border-bottom: 1px solid rgba(0, 0, 0, 0.03); /* Ligne de séparation très fine */
}

.brand-logo-link {
    display: flex;
    align-items: center;
    gap: 12px;
    text-decoration: none;
    transition: all 0.3s ease;
}

/* Le sigle graphique du logo (Le Mark) */
.brand-logo-mark {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 36px;
    height: 36px;
    border-radius: 10px;
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(59, 130, 246, 0.03) 100%);
    border: 1px solid rgba(59, 130, 246, 0.15);
    color: rgb(59, 130, 246); /* Bleu Royal Majeur */
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.logo-svg {
    width: 20px;
    height: 20px;
}

/* Typographie de marque */
.brand-logo-text {
    font-family: 'Outfit', sans-serif;
    font-size: 1.35rem;
    font-weight: 700;
    letter-spacing: -0.5px;
    color: #0f172a; /* Bleu Nuit sombre */
    transition: color 0.3s ease;
}

.brand-logo-text .text-accent {
    color: rgb(59, 130, 246); /* Accentuation Bleu Royal */
}

/* Micro-animations au survol du Logo */
.brand-logo-link:hover .brand-logo-mark {
    transform: scale(1.05) translateY(-1px);
    background: rgb(59, 130, 246);
    color: #ffffff;
    border-color: transparent;
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.2);
}

.brand-logo-link:hover .brand-logo-text {
    color: #1e293b;
}
```

---

### 17.3. Le Composant `DashboardCard` (Premium UI Component)


Le composant est le pilier visuel du tableau de bord. Il est conçu pour afficher des mesures de façon percutante ou fournir des points d'interaction rapides, avec des micro-animations haut de gamme lors du survol.

#### Structure HTML d'une `DashboardCard` :
```html
<div class="dashboard-card card-blue-royal">
    <div class="card-glow"></div>
    <div class="card-header">
        <div class="card-icon-container">
            <!-- Icône SVG modernisée -->
            <svg class="card-icon" ...></svg>
        </div>
        <span class="card-trend upward">+12%</span>
    </div>
    <div class="card-body">
        <h3 class="card-title">Transits Actifs</h3>
        <p class="card-value">1,482</p>
    </div>
    <div class="card-footer">
        <span class="card-meta">84 en cours de livraison</span>
    </div>
</div>
```

#### Styling CSS du composant `DashboardCard` :
```css
/* Container de la grille des cartes */
.dashboard-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1.5rem;
    padding: 1rem;
}

/* Le composant de base DashboardCard (Fidèle au design IdentiGuinée) */
.dashboard-card {
    position: relative;
    display: flex;
    flex-direction: column;
    padding: 1.75rem;
    border-radius: 16px;
    background: #ffffff; /* Fond blanc pur ultra-propre */
    border: 1px solid rgba(0, 0, 0, 0.03); /* Bordure ultra-douce signature d'IdentiGuinée */
    box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.02), 
                0 1px 3px 0 rgba(0, 0, 0, 0.01);
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    cursor: pointer;
}

/* Effet de lueur d'arrière-plan (lueur colorée ultra-subtile) */
.dashboard-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: radial-gradient(circle at 80% 20%, rgba(var(--card-accent-rgb), 0.06), transparent 50%);
    opacity: 0;
    transition: opacity 0.4s ease;
}

/* Hover Micro-animations (Effet de soulèvement doux et bordure colorée) */
.dashboard-card:hover {
    transform: translateY(-6px);
    border-color: rgba(var(--card-accent-rgb), 0.15); /* Bordure colorée très douce au survol */
    box-shadow: 0 20px 40px -15px rgba(var(--card-accent-rgb), 0.12),
                0 0 0 1px rgba(var(--card-accent-rgb), 0.04);
}

.dashboard-card:hover::before {
    opacity: 1;
}

/* Header de la carte */
.card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.25rem;
}

/* Conteneur d'icône premium en dégradé */
.card-icon-container {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 48px;
    height: 48px;
    border-radius: 12px;
    background: linear-gradient(135deg, rgba(var(--card-accent-rgb), 0.1) 0%, rgba(var(--card-accent-rgb), 0.03) 100%);
    border: 1px solid rgba(var(--card-accent-rgb), 0.15);
    color: rgb(var(--card-accent-rgb));
    transition: all 0.3s ease;
}

.dashboard-card:hover .card-icon-container {
    transform: scale(1.08) rotate(3deg);
    background: rgb(var(--card-accent-rgb));
    color: #ffffff;
    border-color: transparent;
}

/* Typographie et structure interne */
.card-title {
    font-family: 'Outfit', sans-serif;
    font-size: 0.95rem;
    font-weight: 500;
    color: #64748b;
    margin-bottom: 0.5rem;
}

.card-value {
    font-family: 'Outfit', sans-serif;
    font-size: 2.25rem;
    font-weight: 700;
    color: #0f172a;
    line-height: 1.1;
    margin-bottom: 0.75rem;
}

.card-meta {
    font-family: 'Inter', sans-serif;
    font-size: 0.8rem;
    color: #94a3b8;
}

/* Définition des variables monochromatiques de Bleu par carte */
.card-blue-royal {
    --card-accent-rgb: 59, 130, 246; /* Bleu Royal IdentiGuinée - Couleur Majeure */
}

.card-blue-slate {
    --card-accent-rgb: 71, 85, 105;  /* Bleu Acier / Slate */
}

.card-blue-cyan {
    --card-accent-rgb: 6, 182, 212;   /* Bleu Cyan / Turquoise */
}

.card-blue-indigo {
    --card-accent-rgb: 99, 102, 241;  /* Bleu Indigo / Électrique */
}
```

---

### 17.4. Rendu thématique des 4 Cartes de Transit (Déclinaisons de Bleu)

| Thème de la Carte | Nuance de Bleu & Classe | Contenu Métrique | Actions associées |
| :--- | :--- | :--- | :--- |
| **Suivi des expéditions** | **Bleu Royal** (`card-blue-royal`) | **Nombre de transits actifs** (ex: `12 En cours`) | Ouvre le tableau de suivi détaillé et la traçabilité en temps réel. |
| **Revenus globaux** | **Bleu Cyan** (`card-blue-cyan`) | **Total facturé accumulé** (ex: `18,450.00 €`) | Ouvre le grand livre des factures et l'analyse de rentabilité financière. |
| **Volume de fret** | **Bleu Slate** (`card-blue-slate`) | **Tonnage et volume actuel** (ex: `5,420 kg \| 124 m²`) | Permet de visualiser l'occupation spatiale selon les modes de transport. |
| **Actions Métiers** | **Bleu Indigo** (`card-blue-indigo`) | **Raccourcis Système** (ex: `Nouveau Transit \| Enregistrer Arrivée`) | Déclenche les modaux d'insertion rapide de données. |

---

### 17.5. Animations Subtiles & Fluidité (Intégration d'AOS & SwiperJS)

Pour offrir un ressenti premium sans surcharger visuellement l'interface, les animations de transition et les carrousels de cartes s'appuient sur deux bibliothèques légères et performantes : **AOS** (Animate On Scroll) et **SwiperJS**.

#### A. AOS (Animate On Scroll) : Entrées fluides au défilement
Pour éviter les effets brusques à l'affichage, les sections majeures et les cartes d'information entrent en scène de manière feutrée et progressive.
* **Directives d'initialisation JavaScript** :
  ```javascript
  // Initialisation globale de AOS
  AOS.init({
      duration: 600,             // Durée de l'animation en ms (subtile et rapide)
      easing: 'ease-out-cubic',  // Courbe d'atténuation fluide
      once: true,                // L'animation ne se joue qu'une seule fois
      offset: 50,                // Déclenchement à 50px de l'entrée dans le viewport
      delay: 50                  // Délai de départ par défaut
  });
  ```
* **Exemple d'intégration HTML (Effet de cascade progressif)** :
  ```html
  <div class="dashboard-grid">
      <div class="dashboard-card card-blue-royal" data-aos="fade-up" data-aos-delay="0">...</div>
      <div class="dashboard-card card-blue-cyan" data-aos="fade-up" data-aos-delay="100">...</div>
      <div class="dashboard-card card-blue-slate" data-aos="fade-up" data-aos-delay="200">...</div>
      <div class="dashboard-card card-blue-indigo" data-aos="fade-up" data-aos-delay="300">...</div>
  </div>
  ```

#### B. SwiperJS : Horizontabilité Tactile sur Mobile (Responsive)
Sur les écrans mobiles (< 768px), pour éviter que les 4 cartes principales ne s'empilent verticalement à l'infini (ce qui nuit à l'ergonomie), la grille CSS se convertit automatiquement en un carrousel horizontal fluide grâce à SwiperJS.

* **Structure HTML du Swiper Mobile** :
  ```html
  <div class="swiper-container dashboard-swiper">
      <div class="swiper-wrapper">
          <!-- Carte 1 -->
          <div class="swiper-slide">
              <div class="dashboard-card card-blue-royal">...</div>
          </div>
          <!-- Carte 2 -->
          <div class="swiper-slide">
              <div class="dashboard-card card-blue-cyan">...</div>
          </div>
          <!-- Carte 3 -->
          <div class="swiper-slide">
              <div class="dashboard-card card-blue-slate">...</div>
          </div>
          <!-- Carte 4 -->
          <div class="swiper-slide">
              <div class="dashboard-card card-blue-indigo">...</div>
          </div>
      </div>
      <!-- Pagination à puces fines et discrètes -->
      <div class="swiper-pagination"></div>
  </div>
  ```

* **Configuration JS (Momentum & Glissement naturel)** :
  ```javascript
  const dashboardSwiper = new Swiper('.dashboard-swiper', {
      slidesPerView: 'auto',       // Ajustement dynamique de la largeur selon l'écran
      spaceBetween: 16,            // Espace fin de 16px entre les cartes
      grabCursor: true,            // Curseur en main fermée pour inciter au drag
      centeredSlides: false,       // Aligné à gauche pour un parcours naturel
      freeMode: {
          enabled: true,           // Glissement fluide sans blocage magnétique strict
          sticky: true,
          momentumRatio: 0.8
      },
      pagination: {
          el: '.swiper-pagination',
          clickable: true,
          dynamicBullets: true     // Puces dynamiques (plus petites aux extrémités)
      },
      breakpoints: {
          // Au-delà de 768px, Swiper est désactivé au profit de la Grid standard
          768: {
              enabled: false,
              spaceBetween: 0
          }
      }
  });
  ```

* **CSS de support pour la pagination Swiper** :
  ```css
  /* Style des puces de pagination minimaliste */
  .swiper-pagination-bullet {
      background: rgba(59, 130, 246, 0.2);
      opacity: 1;
      transition: all 0.3s ease;
  }
  .swiper-pagination-bullet-active {
      background: rgb(59, 130, 246) !important;
      width: 16px !important; /* Puce active étirée élégamment */
      border-radius: 4px;
  }
  ```


