# TransitFlow — Gestion de Transits et Facturation

Ce projet est une application web de gestion des flux logistiques (transits de marchandises) et de leur facturation. Il a été conçu avec une architecture modulaire et découplée pour faciliter le travail en équipe.

---

## 🏗️ Architecture du Projet

Le projet suit les principes de conception orientée objet en PHP, structuré autour du patron de conception **MVC (Modèle-Vue-Contrôleur)** complété par une **couche Service** et un **Repository**.

### Organisation des Répertoires

```text
transit/
├── app/                      # Code applicatif principal
│   ├── Controllers/          # Contrôleurs : gèrent les requêtes HTTP et le rendu des vues
│   │   └── TransitController.php
│   ├── Core/                 # Noyau : routeur, contrôleur de base, classe modèle mère
│   ├── Models/               # Entités/Modèles du domaine (sans SQL, purs objets PHP)
│   │   ├── Client.php, Marchandise.php, Transit.php, Facture.php, Pays.php, Ville.php
│   ├── Repositories/         # Couche d'accès aux données (SQL brut, requêtes préparées et hydratation)
│   │   └── TransitRepository.php
│   ├── Services/             # Logique métier pure, orchestration et validations
│   │   ├── TransitService.php, FacturationService.php, DatabaseInitializer.php
│   └── Views/                # Vues (fichiers HTML/CSS/JS/PHP pour le rendu visuel)
│       ├── dashboard.php, expeditions.php, factures.php
├── config/                   # Configuration de l'application (connexion BDD)
│   └── Database.php
├── public/                   # Point d'entrée web public (assets, CSS, JS)
│   └── index.php
├── routes/                   # Fichier de définition des routes de l'application
├── vendor/                   # Chargeur de classes PSR-4 personnalisé
└── README.md                 # Ce fichier de documentation
```

---

## 🧩 Responsabilités des Couches

Pour garantir la propreté du code et éviter que les fichiers ne deviennent trop lourds ("bloated"), les responsabilités ont été strictement divisées :

### 1. Les Vues (`app/Views/`)
*   Responsables uniquement du rendu visuel de l'interface utilisateur.
*   Elles reçoivent les variables injectées par le contrôleur et les affichent de manière élégante.
*   **Règle** : Pas de requêtes SQL ni de logique métier complexe dans les vues.

### 2. Le Contrôleur (`app/Controllers/TransitController.php`)
*   Il sert uniquement de passerelle d'aiguillage.
*   Il intercepte les requêtes POST/GET, extrait les données, délègue tout le travail métier au **Service** (`TransitService`), puis redirige vers la bonne vue.
*   **Règle** : Pas de requêtes SQL directes ici.

### 3. Le Service Métier (`app/Services/TransitService.php`)
*   Il contient l'intelligence de l'application.
*   Il effectue les validations (ex: vérifier que le poids est positif, que les villes de départ et d'arrivée sont distinctes).
*   Il collabore avec `FacturationService` pour générer automatiquement les factures à l'ajout d'un transit.
*   **Règle** : Pas de SQL. Il passe par le **Repository** pour lire ou écrire dans la base de données.

### 4. Le Dépôt (`app/Repositories/TransitRepository.php`)
*   C'est la seule et unique classe autorisée à écrire des requêtes SQL et à communiquer avec la base de données PDO.
*   Elle lit les tables SQL et convertit les lignes de résultats en objets du modèle PHP (processus d'**hydratation**).

### 5. Les Modèles (`app/Models/`)
*   Ce sont des objets en lecture seule représentant les entités de notre domaine (un Client, une Marchandise, un Transit). Ils encapsulent les données et leurs accesseurs (Getters).

---

## 🛠️ Configuration et Installation en Local

### 1. Prérequis
*   Avoir installé **WampServer** (ou XAMPP).
*   MySQL actif sur le port `3306` (sans mot de passe pour l'utilisateur `root` par défaut).

### 2. Initialisation de la Base de Données
La création de la base de données `transit` ainsi que des tables requises est automatisée. 
Lors du premier chargement du tableau de bord dans le navigateur, l'application appelle la classe `DatabaseInitializer` qui :
1. Crée les tables nécessaires (si elles n'existent pas).
2. Alimente les référentiels de base (les pays, les villes correspondantes, ainsi que les modes de transport avec leurs tarifs unitaires).

*Note : Les tables opérationnelles (Clients, Marchandises, Transits, Factures) sont laissées vides par défaut pour vous permettre d'enregistrer vos propres données.*

### 3. Lancer l'Application
Placez le dossier du projet dans votre répertoire de publication (ex: `c:\wamp64\www\transit`) et rendez-vous sur :
`http://localhost/transit/`
