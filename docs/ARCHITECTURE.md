# 🏛️ Architecture MVC de TransitFlow

Ce document explique la structure des dossiers de l'application TransitFlow. L'architecture repose sur le patron de conception **Modèle-Vue-Contrôleur (MVC)** et suit les standards de l'industrie (similaire à Laravel ou Symfony) pour garantir une **sécurité absolue** et une **séparation des rôles**.

## 📁 Arborescence du Projet

```text
transit/
├── app/            # 🧠 Le Cerveau de l'application (Logique métier)
├── config/         # ⚙️ Les Réglages (Base de données, variables globales)
├── public/         # 🛡️ La Vitrine (Seul dossier exposé à internet)
├── routes/         # 🔀 L'Aiguilleur (Définition des URLs)
├── storage/        # 📦 L'Entrepôt (Fichiers générés, logs, BDD SQLite)
└── vendor/         # 📚 Les Bibliothèques externes (Autoloader)
```

## 🔍 Explication Détaillée des Dossiers

### 1. `public/` : La Vitrine (Sécurité)
C'est le **seul** dossier exposé à Internet. Le serveur Web (Apache/WAMP) est configuré pour que le site "commence et s'arrête" dans ce dossier.
- **Contenu :** Le `index.php` d'accueil (Front Controller), le CSS, le JavaScript et les images.
- **Pourquoi ?** Si un pirate essaie d'accéder à `monsite.com/config/Database.php`, il recevra une erreur 404 (Introuvable). Puisque le serveur Web pointe uniquement sur le dossier `public/`, tous les autres dossiers (`app`, `config`, `storage`) sont physiquement situés "en-dessous" de la racine du site. Ils sont donc **invisibles et inaccessibles** depuis l'extérieur. C'est le principe de sécurité fondamental des applications modernes.

### 2. `app/` : L'Usine Secrète (Logique Métier)
Ce dossier est protégé derrière le mur de sécurité. Il contient tout le code "intelligent" de l'application :
- **`Controllers/` (Les chefs d'orchestre) :** Ils reçoivent les requêtes du visiteur (via le routeur), demandent des données aux Modèles, et envoient le résultat à la Vue.
- **`Models/` (Les experts métier) :** Ils s'occupent exclusivement de la logique des données et de la communication avec la base de données.
- **`Views/` (L'interface visuelle) :** Le code HTML brut et les templates qui seront renvoyés à l'utilisateur.
- **`Core/` (Le moteur interne) :** Les classes fondamentales (Routeur, Contrôleur de base) qui font tourner l'application.

### 3. `config/` & `routes/` : Le Tableau de Bord
Ces dossiers sont séparés du cœur de l'application pour faciliter la maintenance :
- **`routes/web.php` :** C'est le standardiste. Il liste toutes les URLs valides (ex: `/factures`) et indique quel Contrôleur doit s'en occuper.
- **`config/` :** Contient les réglages sensibles (identifiants de la base de données). Un ingénieur réseau ou un administrateur système peut ainsi modifier ces réglages sur le serveur sans jamais avoir besoin de fouiller ou de comprendre le code source PHP complexe (`app/`).

### 4. `storage/` : L'Entrepôt (Droits d'écriture)
C'est ici que l'application stocke les fichiers qu'elle génère de manière dynamique :
- La base de données `database.sqlite`.
- Les journaux d'erreurs (`logs/`).
- Les futurs PDFs générés ou les exports Excel.
- **Pourquoi le séparer ?** Sur un serveur de production en ligne, les bonnes pratiques exigent de verrouiller le code source (`app`, `public`, `config`) en **lecture seule** pour bloquer toute falsification par un script malveillant. Le **seul** dossier qui reçoit l'autorisation système "d'être écrit/modifié" par PHP est le dossier `storage/`.

## 🔄 Le Flux d'une Requête (Le Cheminement)
Pour bien comprendre comment tout s'articule, voici ce qu'il se passe quand vous chargez une page :
1. L'utilisateur tape l'URL et "cogne" à la porte de **`public/index.php`**.
2. Ce guichetier interroge **`routes/web.php`** pour savoir où diriger la demande.
3. Le **`Router`** réveille le bon **`Controller`** dans le dossier `app/`.
4. Le **`Controller`** lit les réglages dans **`config/`** et demande les informations au **`Model`**.
5. Le **`Model`** pioche la donnée dans **`storage/database/database.sqlite`**.
6. Le **`Controller`** insère les données récupérées dans la **`View`** HTML et envoie la page terminée à l'écran du visiteur !
