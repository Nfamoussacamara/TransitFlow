# 🚚 TransitPro — Système de Gestion Logistique & Facturation

TransitPro est une application web métier de haute performance conçue pour digitaliser l'intégralité de la chaîne logistique de transit. Du pilotage des flux à la génération automatique des factures, la plateforme offre une solution clé en main pour les transitaires et une visibilité totale pour les clients.

---

## 🌟 Fonctionnalités Détaillées

### 🏢 Espace Administrateur (Pilotage Central)
L'interface administrateur est un véritable tableau de bord opérationnel :
- **Dashboard Analytique** : Statistiques en temps réel sur le volume de fret et les statuts.
- **Gestion Avancée du Transit** : Création de fiches de transit avec liaison dynamique client/marchandise.
- **Moteur de Cartographie** : Visualisation interactive et calcul de distance.
- **Facturation PDF** : Génération instantanée conforme en GNF.

### 👤 Espace Client (Expérience Utilisateur)
Une interface moderne pensée pour la transparence :
- **Tracking Dynamique** : Une barre de progression intelligente calculée en temps réel.
- **Portefeuille de Factures** : Accès à l'historique complet des documents.

---

## ⚙️ Workflows Opérationnels (Cycle de vie complet)

### 1. Création du Client (Côté Administrateur)
Dans TransitPro, l'administrateur ne crée pas les clients sur une page séparée, il les intègre directement dans le flux de travail :
- **Création Implicite** : Lors de l'ajout d'un nouveau transit, l'administrateur saisit le **Nom** et l'**Email** du client. 
- **Logique intelligente** : Si l'email est inconnu, le système crée automatiquement un profil client dans la base de données. S'il est connu, il rattache simplement le nouveau fret au compte existant.
- **Sécurité** : À ce stade, le compte client n'a pas encore de mot de passe ; il est en attente d'activation.

### 2. Activation du Compte (Côté Client)
Le client prend possession de son espace via un processus d'auto-activation sécurisé :
- **Lien d'E-mail** : Le client se rend sur la page de connexion et clique sur **"Première connexion"**.
- **Vérification** : Il saisit son adresse e-mail. Le système vérifie qu'une marchandise ou un transit est bien rattaché à cet email.
- **Initialisation du Mot de Passe** : Si l'email est valide, le client est invité à définir son propre mot de passe.
- **Finalisation** : Une fois le mot de passe enregistré, le compte est considéré comme **Actif** et le client peut accéder à son dashboard personnel.

### 3. Création de Marchandise & Transit
Tout se passe dans une seule interface unifiée pour l'administrateur :
1.  **Marchandise** : Définition de la nature, de l'état (neuf, usagé), du poids et de la surface.
2.  **Transit** : Sélection des villes sur la carte Leaflet et choix du mode de transport.
3.  **Facturation** : Le `FacturationService` traite les données en fond, calcule les totaux en GNF et fige les tarifs au moment de la validation.

### 4. Cycle de Vie Automatisé
- **En attente** : Avant le départ.
- **En transit** : La barre de progression client s'anime selon le temps écoulé entre le départ et l'arrivée.
- **Livré** : Le système archive automatiquement le transit à la date prévue.

---

## 🏗️ Architecture Technique (Standard Entreprise)

TransitPro repose sur une architecture PHP 8.1+ découplée (MVC + Service + Repository).

---

## 💰 Logique de Tarification (GNF)
Les tarifs sont basés sur le mode de transport (Aérien, Maritime, Terrestre, Ferroviaire).

---

## ⚙️ Initialisation Automatisée
Le système s'installe seul au premier chargement (`DatabaseInitializer`).

---

© 2026 TransitPro — Excellence Logistique. Développé pour la République de Guinée.
