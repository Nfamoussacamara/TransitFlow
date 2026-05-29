# 🚚 TransitPro — Système de Gestion Logistique & Facturation

TransitPro est une application web métier de haute performance conçue pour digitaliser l'intégralité de la chaîne logistique de transit. Du pilotage des flux à la génération automatique des factures, la plateforme offre une solution clé en main pour les transitaires et une visibilité totale pour les clients.

---

## 🌟 Fonctionnalités Détaillées

### 🏢 Espace Administrateur (Pilotage Central)
L'interface administrateur est un véritable tableau de bord opérationnel :
- **Dashboard Analytique** : Statistiques en temps réel sur le volume de fret, les revenus potentiels et les statuts de livraison.
- **Gestion Avancée du Transit** : 
    - Création de fiches de transit avec liaison dynamique client/marchandise.
    - Modification à la volée des informations de transport (coût, dates, itinéraire).
- **Moteur de Cartographie (Leaflet.js)** :
    - Visualisation interactive du trajet sur une mappemonde.
    - Géocodage inversé (Nominatim API) : cliquez sur la carte pour définir une ville de départ/arrivée.
    - Calcul de distance automatique pour l'estimation logistique.
- **Système de Facturation PDF** :
    - Génération instantanée conforme aux normes comptables en GNF.
    - Capture haute précision isolée pour éviter les erreurs de rendu navigateur.

### 👤 Espace Client (Expérience Utilisateur)
Une interface moderne pensée pour la transparence :
- **Tracking Dynamique** : Une barre de progression intelligente calcule l'avancée du colis en fonction de l'heure actuelle du serveur, du départ et de l'arrivée estimée.
- **Portefeuille de Factures** : Accès à l'historique complet des documents comptables gelés (non modifiables par le client pour garantir l'intégrité).
- **Statistiques de Flux** : Visualisation rapide du nombre de conteneurs réceptionnés vs en attente.

---

## 🏗️ Architecture Technique (Standard Entreprise)

TransitPro repose sur une architecture PHP 8.1+ découplée, suivant les principes du Clean Code.

### Patron de Conception : MVC + Service + Repository
1. **Modèles (`app/Models/`)** : Objets PHP purs (Entities) représentant les données métier (Facture, Transit, Client). Ils ne contiennent aucune logique de base de données.
2. **Repositories (`app/Repositories/`)** : La seule couche autorisée à manipuler le SQL. Utilise PDO avec requêtes préparées pour une sécurité totale contre les injections.
3. **Services (`app/Services/`)** : L'intelligence de l'application. Orchestre les calculs de prix, les validations de dates et l'initialisation automatique du système.
4. **Contrôleurs (`app/Controllers/`)** : Passerelles légères gérant l'aiguillage des requêtes HTTP.

### Structure du Code
```text
transit/
├── app/
│   ├── Core/                # Noyau du framework (Router, Base Model, Controller)
│   ├── Models/              # Objets métier (POPO - Plain Old PHP Objects)
│   ├── Repositories/        # Couche d'Accès aux Données (DAL)
│   ├── Services/            # Logique métier et orchestrations
│   └── Views/               # Rendus UI et Templates PDF
├── config/                  # Configuration BDD et Paramètres Globaux
├── public/                  # Point d'entrée unique (Rewrite standard Apache)
└── database/                # Scripts SQL (si nécessaire) et log d'initialisation
```

---

## ⚙️ Initialisation Automatisée (`DatabaseInitializer`)

L'application est conçue pour être déployée sans effort. Au premier lancement :
1. **Création des Tables** : Les tables `pays`, `villes`, `clients`, `marchandises`, `modes_transport`, `transits` et `factures` sont générées automatiquement.
2. **Alimentation des Référentiels** : Le système injecte les données géographiques de base et configure les tarifs unitaires par défaut.
3. **Préparation de la Facturation** : Les triggers et procédures de calcul (en PHP) sont prêts à l'emploi.

---

## 💰 Logique Comptable & Calculs (GNF)

La facturation est basée sur une grille tarifaire dynamique :
- **Aérien** : `450 000 GNF` par kg (Basé sur le **Poids**).
- **Maritime** : `125 000 GNF` par m² (Basé sur la **Surface**).
- **Terrestre** : `35 000 GNF` par kg.
- **Ferroviaire** : `18 000 GNF` par kg.

**Formule de Calcul :**
- **Montant HT** : $Base\ (Poids\ ou\ Surface) \times Tarif\ Unitaire$.
- **TVA (20%)** : $Montant\ HT \times 0.20$.
- **Total TTC** : $Montant\ HT + TVA$.

---

## 🛠️ Guide du Développeur (Collaborateurs)

### Recommandations de Codage
- **Indépendance des Vues** : Ne jamais appeler une méthode du Repository dans une vue. Utilisez les variables transmises par le contrôleur.
- **Extensions Logistiques** : Pour ajouter un nouveau mode de transport, modifiez simplement le `DatabaseInitializer` et la logique de calcul dans `FacturationService`.
- **Système de Design** : L'interface utilise CSS Grid et Flexbox avec des variables de couleurs centralisées dans `public/index.php` (ou assets liés).

### Installation Locale
1. Clonez le dépôt dans votre dossier `www` ou `htdocs`.
2. Configurez vos accès MySQL dans `config/Database.php`.
3. Lancez votre navigateur sur `localhost/transit` : le système s'initialise seul.

---

© 2026 TransitPro — Excellence Logistique. Développé pour la République de Guinée.
