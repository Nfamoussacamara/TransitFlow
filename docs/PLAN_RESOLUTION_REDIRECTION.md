# Rapport d'Analyse : Problème de Redirection Systématique vers Login

## 1. État des Lieux
Actuellement, l'application **TransitPro** semble rediriger toutes les tentatives d'accès (même vers des pages supposées "publiques") vers la page de connexion (`/login`). 

Après analyse du code source, voici les mécanismes identifiés :

### Architecture de Sécurité Actuelle
Le filtrage des accès ne s'effectue pas au niveau du **Routeur**, mais dans les **Constructeurs** des contrôleurs :
*   **TransitController** : Protège toutes les routes vers le Dashboard, les Expéditions, les Factures et les Paramètres.
*   **ClientController** : Protège toutes les routes de l'Espace Client (nécessite le rôle 'client').
*   **AuthController** : Est le seul contrôleur **totalement public**.

### Points Critiques identifiés
1.  **Approche "Tout ou Rien"** : Dès qu'une route est associée au `TransitController` (comme la racine `/`), elle devient automatiquement protégée par son constructeur. Si vous souhaitiez que la page d'accueil soit publique, ce n'est pas possible dans la configuration actuelle.
2.  **Persistance de Session** : Si les identifiants sont corrects mais que la session ne "tient pas" (problème de cookie ou de configuration PHP), l'utilisateur sera redirigé vers `/login` dès la page suivante.

---

## 2. Plan d'Action pour la Résolution

### Phase 1 : Diagnostic Technique (Immédiat)
*   [ ] **Vérifier la persistance des sessions** : Utiliser le script `public/diag.php` (créé par mes soins) pour voir si le `session_id` change à chaque rechargement. Si oui, c'est un problème de configuration serveur (Wamp).
*   [ ] **Analyser les URLs concernées** : Lister précisément quelles pages "publiques" sont redirigées. Si c'est la page d'accueil (`/`), il faut modifier son contrôleur.

### Phase 2 : Refactorisation de la Sécurité
*   [ ] **Déplacer le filtre de sécurité** : Au lieu de mettre le bloc de redirection dans le `__construct()`, nous le placerons dans une méthode `checkAuth()` appelée uniquement par les actions qui le nécessitent.
*   [ ] **Créer une vraie section Publique** : Si une page "Vitrine" est nécessaire, nous créerons un `PublicController` séparé sans aucun filtre de session.

### Phase 3 : Optimisation du Routeur
*   [ ] **Supprimer les ambiguïtés de nettoyage d'URL** : S'assurer que le nettoyage des extensions `.php` et `index.php` ne crée pas de fausses correspondances vers la racine `/`.

---

## 3. Rapport de Débogage Préliminaire

| Symptôme | Cause Probable | Solution |
| :--- | :--- | :--- |
| **Redirection de `/` vers `/login`** | La route `/` est gérée par `TransitController` qui impose la connexion. | Déplacer l'action `dashboard` vers un contrôleur plus souple ou assouplir le constructeur. |
| **Boucle de redirection infinie** | Session non activée ou cookie bloqué. | Vérifier `session_start()` et les permissions du dossier `tmp` de PHP. |
| **Pages statiques (Images/CSS) redirigées** | Le fichier `.htaccess` est trop agressif et renvoie tout vers PHP. | Vérifier les conditions `RewriteCond %{REQUEST_FILENAME} !-f`. |

> [!IMPORTANT]
> **Action Recommandée :** Ouvrez votre navigateur sur `http://localhost/transit/diag.php` et dites-moi si vous voyez "Session persistence: YES". Cela confirmera si le bug est lié au code ou à la configuration de votre serveur PHP.
