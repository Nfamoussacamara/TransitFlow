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
    - Géocodage inversé (Nominatim API).
- **Système de Facturation PDF** : Génération instantanée conforme aux normes GNF.

### 👤 Espace Client (Expérience Utilisateur)
Une interface moderne pensée pour la transparence :
- **Tracking Dynamique** : Une barre de progression intelligente calculée en temps réel.
- **Portefeuille de Factures** : Accès à l'historique complet des documents comptables.

---

## 🎬 Scénario de Démonstration (Pas-à-pas)

Voici comment utiliser TransitPro pour un flux complet, du départ à la livraison :

### Étape 1 : Connexion Administrateur
1. Rendez-vous sur la page d'accueil.
2. Identifiez-vous en tant qu'administrateur pour accéder au **Dashboard global**.
3. Vous y verrez les statistiques de la flotte et la carte du monde interactive.

### Étape 2 : Création d'un Nouveau Transit
1. Cliquez sur le bouton **"Ajouter un Transit"**.
2. **Choix du Client** : Sélectionnez un client existant (ou laissez le système en utiliser un par défaut).
3. **Détails Marchandise** : Saisissez la nature du colis (ex: "Équipements Informatiques"), son poids et sa surface.
4. **Configuration Logistique** :
    - Cliquez sur la carte pour définir la **Ville de Départ** (ex: Conakry).
    - Cliquez à nouveau pour définir la **Ville d'Arrivée** (ex: Labé).
    - Sélectionnez le **Mode de Transport** (ex: Aérien).
    - Définissez une date de départ (ex: aujourd'hui) et une date d'arrivée (ex: dans 3 jours).
5. Appuyez sur **"Enregistrer"**. Le système calcule automatiquement le prix et génère la facture.

### Étape 3 : Suivi côté Client
1. Déconnectez-vous et connectez-vous avec l'email du client concerné.
2. Sur le **Dashboard Client**, vous verrez votre nouvelle expédition apparaître.
3. Observez la **Barre de Progression** : elle avance toute seule en temps réel au fil des heures.
4. Cliquez sur **"Voir Détails"** puis sur **"Télécharger PDF"** pour récupérer votre facture officielle instantanément.

### Étape 4 : Fin de Transit (Automatisée)
- Une fois que la date d'arrivée est dépassée, le statut du transit passera automatiquement à **"Livré"** (Vert) sur les deux interfaces, sans aucune action manuelle requise.

---

## 🏗️ Architecture Technique (Standard Entreprise)

TransitPro repose sur une architecture PHP 8.1+ découplée (MVC + Service + Repository).

### Structure des Dossiers
```text
transit/
├── app/                      # Code source (Controllers, Models, Repositories, Services)
├── config/                   # Paramètres BDD
├── public/                   # Point d'entrée unique (Index, CSS, JS)
└── vendor/                   # Autoloader PSR-4 personnalisé
```

---

## 💰 Logique de Tarification (GNF)
Les tarifs sont basés sur le mode de transport :
- **Aérien** : 450 000 GNF / kg
- **Maritime** : 125 000 GNF / m²
- **Terrestre** : 35 000 GNF / kg
- **Ferroviaire** : 18 000 GNF / kg

---

## ⚙️ Initialisation Automatisée
Au premier chargement, `DatabaseInitializer` :
1. Crée la base de données et toutes les tables.
2. Injecte les pays, villes et tarifs de base.

---

© 2026 TransitPro — Excellence Logistique. Développé pour la République de Guinée.
