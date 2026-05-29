# 🚚 TransitPro — Solution Intégrée de Gestion Logistique & Facturation

TransitPro est une plateforme modulaire conçue pour simplifier le suivi des flux de transit international et automatiser la facturation logistique. Ce projet illustre une architecture logicielle robuste en PHP natif, respectant les principes POO et le patron de conception MVC.

---

## 🌟 Fonctionnalités du Système

Le projet est divisé en deux sections distinctes offrant des expériences sur-mesure pour chaque type d'utilisateur.

### 🏢 Espace Administrateur (Gestion & Pilotage)
Le tableau de bord administrateur est le cœur opérationnel de TransitPro :
- **Pilotage de l'Activité** : Vue globale sur le nombre d'expéditions, les transits en cours et les arrivées prévues.
- **Gestion du Fret** : Création, modification et suppression de transits.
- **Cartographie Interactive** : Visualisation des itinéraires via Leaflet.js, calcul automatique des distances et suggestion intelligente de villes.
- **Facturation Automatisée** : Génération immédiate d'une facture PDF lors de l'enregistrement d'un nouveau transit, basée sur les tarifs officiels (GNF).
- **Formatage Professionnel** : Exportation de factures PDF ultra-précises avec logo, détails transporteur et totaux HT/TVA/TTC.

### 👤 Espace Client (Consultation & Transparence)
Une interface épurée permettant au client de suivre ses commandes en toute autonomie :
- **Suivi en Temps Réel** : Barre de progression dynamique simulant l'avancée du transit entre le départ et l'arrivée prévue.
- **Historique et Archives** : Consultation de la liste complète des expéditions passées et actuelles.
- **Téléchargement Autonome** : Accès direct au téléchargement des factures au format PDF à tout moment.
- **Statistiques Personnelles** : Résumé visuel de l'activité du client (total expéditions, colis livrés, colis en attente).

---

## 🏗️ Architecture Technique

TransitPro utilise une structure **MVC (Modèle-Vue-Contrôleur)** découplée, complétée par une couche **Repository** et **Service** pour garantir la scalabilité et la maintenabilité.

### Structure des Dossiers
```text
transit/
├── app/                      # Cœur applicatif
│   ├── Controllers/         # Orchestre les requêtes et les vues
│   ├── Models/              # Entités PHP (Client, Facture, Transit, etc.)
│   ├── Repositories/        # Couche d'accès aux données (Requêtes SQL & Hydratation)
│   ├── Services/            # Logique métier (Calculs, Validations, Initialisation)
│   └── Views/               # Fichiers PHP/HTML (Dashboard, Templates PDF, Partials)
├── config/                  # Configuration (Base de données, Constantes)
├── public/                  # Point d'entrée web (Index.php, Assets CSS/JS/Images)
├── routes/                  # Définition des URL et actions associées
└── vendor/                  # Autoloader PSR-4 personnalisé
```

---

## 🛡️ Guide pour les Développeurs & Collaborateurs

### Principes de Code
1. **Zéro SQL dans les Vues/Contrôleurs** : Toute requête doit passer par les `Repositories`. Toute logique métier complexe (calcul de prix, validation d'itinéraire) doit résider dans les `Services`.
2. **Hydratation des Objets** : Les données sortant de la base sont systématiquement converties en Objets (`Models`) par le Repository. Ne manipulez jamais de tableaux associatifs bruts dans la logique métier.
3. **Sécurité des Données** : Utilisez systématiquement les requêtes préparées via PDO pour prévenir les injections SQL.
4. **Design System** : L'interface utilise un système de design cohérent basé sur des variables CSS (`:root`) pour les couleurs et les espacements.

### Installation & Contribution
1. **Environnement** : Serveur PHP 8.0+ et MySQL 5.7+ (compatible WAMP, XAMPP, MAMP).
2. **Setup BDD** : L'application initialise sa propre base de données au premier lancement. Assurez-vous que les identifiants dans `config/Database.php` sont corrects.
3. **Ajout de Fonctionnalités** :
    - Pour une nouvelle entité : Créer le `Model`, puis son `Repository`, puis ajouter les méthodes nécessaires dans `TransitService`.
    - Pour une nouvelle vue : Ajouter la route dans `routes/` (ou le dispatcher index.php) et créer le fichier correspondant dans `app/Views/`.

---

## 💰 Logique de Tarification (GNF)
Les tarifs sont calculés automatiquement selon le mode de transport :
- **Aérien** : 450 000 GNF / kg
- **Maritime** : 125 000 GNF / m²
- **Terrestre** : 35 000 GNF / kg
- **Ferroviaire** : 18 000 GNF / kg
- **TVA** : 20% applicable sur tous les montants brut (HT).

---

© 2026 TransitPro Logistics. Conçu avec excellence pour l'Université de Labé, République de Guinée.
