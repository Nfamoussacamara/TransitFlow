# 🔧 Guide des Concepts Non-Vanilles dans TransitPro

Ce document identifie les **concepts avancés** utilisés dans ce projet et explique pourquoi ils sont là.

---

## 1. **Namespaces** (Espaces de noms)

### ❌ Pas vanille
```php
namespace App\Controllers;
use App\Core\Controller;
```

### ✅ Vanille équivalent
```php
// Pas de namespace, toutes les classes dans le même dossier
```

### Pourquoi on l'utilise ?
- Organiser les classes
- Éviter les collisions de noms (ex: deux classes `User`)
- Respect de la norme PSR-4

### Pour débutants
**Pense-le comme des dossiers virtuels.** `App\Controllers\TransitController` = le fichier est dans `app/Controllers/TransitController.php`

---

## 2. **Héritage et Classes Abstraites**

### ❌ Pas vanille
```php
abstract class Entity {
    protected ?int $id;
    abstract public function toArray(): array;
}

class Client extends Entity {
    public function toArray(): array { ... }
}
```

### ✅ Vanille équivalent
```php
class Client {
    public $id;
    public function toArray() { ... }
}
```

### Pourquoi on l'utilise ?
- Éviter la duplication de code (`getId()`, `setId()` partagés)
- Forcer les classes enfants à implémenter certaines méthodes
- Sécurité (propriétés `protected` au lieu de `public`)

### Pour débutants
**`extends` = "hérite de"** — `Client extends Entity` signifie "Client reçoit tous les pouvoirs d'Entity"

---

## 3. **Type Hints (Typage strict)**

### ❌ Pas vanille
```php
declare(strict_types=1);

public function getId(): ?int { ... }
public function setName(string $name): void { ... }
```

### ✅ Vanille équivalent
```php
// Pas de types, PHP accepte n'importe quoi
public function getId() { ... }
public function setName($name) { ... }
```

### Pourquoi on l'utilise ?
- Détecter les erreurs à la compilation
- Documenter ce qu'on attend
- Sécurité renforcée

### Symboles courants
| Symbole | Signification |
|---------|--------------|
| `?int` | Un entier OU null |
| `: string` | Retourne toujours une string |
| `: void` | Ne retourne rien |
| `int\|string` | Un entier OU une string |

---

## 4. **Pattern: Repository**

### ❌ Pas vanille
```php
class TransitController {
    private TransitRepository $repository;
    
    public function __construct() {
        $this->repository = new TransitRepository();
    }
    
    public function store() {
        $this->repository->create($transit);
    }
}
```

### ✅ Vanille équivalent
```php
// Tout le SQL directement dans le contrôleur
class TransitController {
    public function store() {
        $db->query("INSERT INTO transits ...");
    }
}
```

### Pourquoi on l'utilise ?
- **Séparation des responsabilités** — Le contrôleur ne sait pas comment faire un INSERT
- **Réutilisabilité** — `TransitRepository` peut être utilisé partout
- **Facilite les tests** — On peut "mocker" le repository

### Pour débutants
**Repository = coffre-fort** — Tout ce qui touche la base de données passe par le Repository

---

## 5. **Pattern: Service Layer**

### ❌ Pas vanille
```php
class TransitController {
    public function store() {
        $transit = new Transit($_POST);
        
        // Logique métier directement ici
        if ($transit->validate()) {
            $this->repository->create($transit);
            $this->generateInvoice($transit);
        }
    }
}
```

### ✅ Vanille équivalent (déjà minimaliste)

### ✅ TransitPro (avec Service)
```php
class TransitController {
    private TransitService $service;
    
    public function store() {
        $transit = new Transit($_POST);
        $this->service->createTransit($transit);  // Tout le travail ici
    }
}
```

### Pourquoi on l'utilise ?
- **Logique métier centralisée** — Si 2 contrôleurs créent un transit, pas de duplication
- **Plus facile à maintenir** — Changer la validation ? Une seule place
- **Testable** — On teste la logique séparément

### Pour débutants
**Service = chef** — Le chef (Service) organise le travail, le contrôleur (serveur) prend les commandes

---

## 6. **Injection de Dépendances**

### ❌ Pas vanille
```php
class TransitController {
    public function __construct() {
        $this->service = new TransitService();  // Crée l'objet ici
    }
}
```

### ✅ Meilleure pratique (avec DI)
```php
class TransitController {
    public function __construct(TransitService $service) {
        $this->service = $service;  // On reçoit l'objet en paramètre
    }
}
```

### Pourquoi on l'utilise ?
- **Flexibilité** — Facile de changer `TransitService` pour une version test
- **Découplage** — Le contrôleur ne dépend pas de `new TransitService()`

### Pour débutants
**Injection = recevoir plutôt que créer** — Reçois l'outil plutôt que de le construire

---

## 7. **Propriétés typées et initialisées**

### ❌ Pas vanille
```php
class Transit {
    public $id;
    public $numero;
    public $date;
}
```

### ✅ Moderne (TransitPro)
```php
class Transit extends Entity {
    private string $numero;
    private DateTimeImmutable $date;
    private int $client_id;
    
    public function __construct(?int $id = null) { ... }
}
```

### Pourquoi on l'utilise ?
- **Type safety** — Impossible d'assigner une string à `$client_id`
- **Clarté** — On voit exactement quelles données l'objet contient
- **Moins de bugs** — PHP refuse les erreurs de type

---

## 8. **Visibility: private, protected, public**

### ❌ Pas vanille
```php
class User {
    public $password;  // TRÈS dangereux !
}
```

### ✅ Vanille sécurisé
```php
class User {
    private $password;
    
    public function verifyPassword($input) {
        return password_verify($input, $this->password);
    }
}
```

### Niveaux de visibilité

| Visibilité | Accessible depuis | Usage |
|-----------|-----------------|-------|
| `public` | Partout | API externe, getters |
| `protected` | Classe + enfants | Pour les classes abstraites |
| `private` | Classe seule | Données sensibles |

---

## 9. **Const et Static**

### ❌ Pas vanille
```php
$statut = 'PENDING';
```

### ✅ Vanille avec constants
```php
const STATUS_PENDING = 'PENDING';
const STATUS_CONFIRMED = 'CONFIRMED';

// Usage
if ($transit->status === self::STATUS_PENDING) { ... }
```

### Pourquoi on l'utilise ?
- **Pas de typos** — `STATUS_PANDING` sera détecté
- **Centralisation** — Tous les statuts au même endroit

---

## 10. **Interfaces**

### ❌ Pas vanille
```php
class Invoice {
    public function calculate() { ... }
}

class Quote {
    public function calculate() { ... }
}
```

### ✅ Avec interface
```php
interface Facturable {
    public function calculate(): float;
}

class Invoice implements Facturable {
    public function calculate(): float { ... }
}

class Quote implements Facturable {
    public function calculate(): float { ... }
}
```

### Pourquoi on l'utilise ?
- **Contrat** — On garantit que toute classe `Facturable` a une méthode `calculate()`
- **Polymorphisme** — On peut traiter Invoice et Quote de la même façon

---

## 📊 Résumé : Vanille vs TransitPro

| Concept | Vanille | TransitPro | Complexité |
|---------|---------|------------|-----------|
| Structure fichiers | Simple | MVC + Services | ⭐⭐⭐ |
| Namespaces | Non | Oui | ⭐ |
| Classes abstraites | Non | Oui | ⭐⭐ |
| Héritage | Rare | Oui | ⭐⭐ |
| Type hints | Non | Oui (strict) | ⭐ |
| Repository pattern | Non | Oui | ⭐⭐⭐ |
| Service layer | Non | Oui | ⭐⭐⭐ |
| Interfaces | Rare | Oui | ⭐⭐ |

---

## 🎯 Pour simplifier pour des débutants

### Option 1 : Ajouter des commentaires détaillés
Dans chaque fichier, expliquer le "pourquoi" (déjà en partie fait !)

### Option 2 : Créer des fichiers "vanille" équivalents
`docs/VANILLE_EQUIVALENTS/` — montrer comment écrire la même logique en PHP simple

### Option 3 : Un tutoriel progressif
- **Semaine 1** : PHP vanille simple
- **Semaine 2** : Ajouter les classes
- **Semaine 3** : Namespaces
- **Semaine 4** : Patterns (Repository, Service)

Laquelle préfères-tu ? 🚀
