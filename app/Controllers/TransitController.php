<?php

// Définition de l'espace de noms (namespace) du contrôleur.
// Cela place cette classe dans le sous-dossier App\Controllers.
namespace App\Controllers;

// Importation des classes nécessaires au fonctionnement du contrôleur.
use App\Core\Controller;              // Classe de base des contrôleurs (gère le rendu des vues).
use App\Config\Database;              // Classe gérant la connexion PDO à la BDD.
use App\Models\Pays;                  // Modèle représentant un pays.
use App\Models\Ville;                 // Modèle représentant une ville.
use App\Models\Client;                // Modèle représentant un client.
use App\Models\ModeTransport;         // Modèle représentant un mode de transport.
use App\Models\Marchandise;           // Modèle représentant une marchandise.
use App\Models\Transit;               // Modèle représentant un transit.
use App\Models\Facture;               // Modèle représentant une facture.
use App\Services\FacturationService; // Service de calcul financier (brut et TTC).
use DateTimeImmutable;                // Pour manipuler des dates et des heures de façon sécurisée (immuable).
use Exception;                        // Classe de base pour la gestion des erreurs (exceptions).

// Déclaration de notre contrôleur de transit qui hérite du contrôleur de base Core\Controller.
class TransitController extends Controller {

    /**
     * Action principale : Affiche le tableau de bord (dashboard).
     * Gère aussi l'intercepteur de suppression et l'initialisation automatique de la BDD.
     */
    public function dashboard() {
        // Connexion à la base de données.
        $dbConfig = new Database();
        $pdo = $dbConfig->getConnection();
        
        // --- SECTION : INTERCEPTEUR DE SUPPRESSION ---
        // Si l'utilisateur a cliqué sur le lien de suppression (qui passe l'action 'supprimer_transit' dans l'URL) :
        if (isset($_GET['action']) && $_GET['action'] === 'supprimer_transit' && isset($_GET['id'])) {
            $transitId = (int)$_GET['id']; // Sécurisation en forçant la conversion du paramètre ID en entier (int).
            
            // 1. Récupération de l'ID de la marchandise liée à ce transit pour pouvoir la supprimer aussi.
            $stmt = $pdo->prepare("SELECT marchandise_id FROM transits WHERE id = :id");
            $stmt->execute([':id' => $transitId]);
            $marchandiseId = $stmt->fetchColumn(); // Récupère la valeur unique retournée par la requête SQL.
            
            // 2. Suppression de la facture liée au transit.
            // On utilise des requêtes préparées avec des paramètres (:tid) pour éviter les failles par injection SQL.
            $stmtF = $pdo->prepare("DELETE FROM factures WHERE transit_id = :tid");
            $stmtF->execute([':tid' => $transitId]);
            
            // 3. Suppression du transit lui-même.
            $stmtT = $pdo->prepare("DELETE FROM transits WHERE id = :id");
            $stmtT->execute([':id' => $transitId]);
            
            // 4. Suppression de la marchandise.
            if ($marchandiseId) {
                $stmtM = $pdo->prepare("DELETE FROM marchandises WHERE id = :id");
                $stmtM->execute([':id' => $marchandiseId]);
            }
            
            // Redirection vers le dashboard avec un message de succès.
            $this->redirect('index.php?success=delete');
            exit; // Arrêt de l'exécution du script pour valider la redirection.
        }
        
        // --- SECTION : INITIALISATION DE LA BASE DE DONNÉES ---
        // Vérification sommaire si les tables existent en faisant une requête sur la table "clients".
        try {
            $pdo->query("SELECT 1 FROM clients LIMIT 1");
            $tableExists = true;
        } catch (Exception $e) {
            $tableExists = false;
        }

        // Si la table n'existe pas, on lance le script de création et d'alimentation en données fictives (seeders).
        if (!$tableExists) {
            try {
                // Création du schéma physique de la base de données.
                $pdo->exec("
                    CREATE TABLE IF NOT EXISTS pays (id INT AUTO_INCREMENT PRIMARY KEY, nom VARCHAR(255) NOT NULL);
                    CREATE TABLE IF NOT EXISTS villes (id INT AUTO_INCREMENT PRIMARY KEY, nom VARCHAR(255) NOT NULL, pays_id INT NOT NULL);
                    CREATE TABLE IF NOT EXISTS clients (id INT AUTO_INCREMENT PRIMARY KEY, nom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL);
                    CREATE TABLE IF NOT EXISTS modes_transport (id INT AUTO_INCREMENT PRIMARY KEY, nom VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, tarif_unitaire DOUBLE NOT NULL);
                    CREATE TABLE IF NOT EXISTS marchandises (id INT AUTO_INCREMENT PRIMARY KEY, designation VARCHAR(255) NOT NULL, poids DOUBLE NOT NULL, surface DOUBLE NOT NULL, etat VARCHAR(255) NOT NULL, client_id INT NOT NULL);
                    CREATE TABLE IF NOT EXISTS transits (id INT AUTO_INCREMENT PRIMARY KEY, ville_depart_id INT NOT NULL, ville_arrivee_id INT NOT NULL, date_depart DATETIME NOT NULL, date_arrivee DATETIME NOT NULL, marchandise_id INT NOT NULL, mode_transport_id INT NOT NULL);
                    CREATE TABLE IF NOT EXISTS factures (id INT AUTO_INCREMENT PRIMARY KEY, numero VARCHAR(100) NOT NULL UNIQUE, montant_brut DOUBLE NOT NULL, montant_ttc DOUBLE NOT NULL, base_calcul DOUBLE NOT NULL, date_facturation DATETIME NOT NULL, transit_id INT NOT NULL);
                ");
                
                // Insertion des données structurelles uniquement. Les transits, marchandises et factures seront créés par l'utilisateur.
                $pdo->exec("
                    INSERT INTO pays (nom) VALUES ('Guinée'), ('Sénégal'), ('Mali'), ('Côte d''Ivoire');
                    INSERT INTO villes (nom, pays_id) VALUES ('Conakry', 1), ('Kamsar', 1), ('Boké', 1), ('Kankan', 1), ('Dakar', 2), ('Bamako', 3), ('Abidjan', 4);
                    INSERT INTO clients (nom, email) VALUES ('Sylla Logistique S.A.', 'contact@syllalog.gn'), ('Diallo & Frères Import', 'import@diallo.com'), ('Sogui Transit Guinee', 'operations@sogui.gn'), ('Pharmacie Centrale GN', 'info@pcg.gn');
                    INSERT INTO modes_transport (nom, type, tarif_unitaire) VALUES ('Cargo Maritime Océan', 'Maritime', 125000), ('Air France Cargo', 'Aérien', 450000), ('Camion Lourd Fret', 'Terrestre', 35000), ('Train Express CBG', 'Ferroviaire', 18000);
                ");
            } catch (Exception $e) {
                die("Erreur d'initialisation BDD MySQL : " . $e->getMessage());
            }
        }


        // --- SECTION : CHARGEMENT DES REQUÊTES POUR LES FORMULAIRES ---
        // Liste de tous les clients triés par nom.
        $listeClients        = $pdo->query("SELECT id, nom FROM clients ORDER BY nom")->fetchAll();
        // Liste de toutes les villes avec le nom de leur pays associé (via une jointure JOIN).
        $listeVilles         = $pdo->query("SELECT v.id, v.nom, p.nom AS pays FROM villes v JOIN pays p ON v.pays_id = p.id ORDER BY v.nom")->fetchAll();
        // Liste de tous les modes de transport triés par nom commercial.
        $listeModesTransport = $pdo->query("SELECT id, nom, type FROM modes_transport ORDER BY nom")->fetchAll();

        // Tableaux et accumulateurs de statistiques pour le Dashboard.
        $transits = [];
        $totalRevenue = 0.0;
        $totalWeight = 0.0;
        $totalSurface = 0.0;

        // --- SECTION : HYDRATATION DES MODÈLES PHP ---
        try {
            // Requête SQL complexe joignant toutes les tables pour tout charger en une seule opération (optimisation).
            $query = "
                SELECT 
                    t.id AS transit_id, t.date_depart, t.date_arrivee,
                    vd.id AS vd_id, vd.nom AS vd_nom, pd.id AS pd_id, pd.nom AS pd_nom,
                    va.id AS va_id, va.nom AS va_nom, pa.id AS pa_id, pa.nom AS pa_nom,
                    m.id AS m_id, m.designation AS m_des, m.poids AS m_pds, m.surface AS m_surf, m.etat AS m_etat,
                    c.id AS c_id, c.nom AS c_nom, c.email AS c_email,
                    mt.id AS mt_id, mt.nom AS mt_nom, mt.type AS mt_type, mt.tarif_unitaire AS mt_tarif,
                    f.id AS f_id, f.numero AS f_num, f.montant_brut AS f_brut, f.montant_ttc AS f_ttc, f.date_facturation AS f_date
                FROM transits t
                JOIN villes vd ON t.ville_depart_id = vd.id
                JOIN pays pd ON vd.pays_id = pd.id
                JOIN villes va ON t.ville_arrivee_id = va.id
                JOIN pays pa ON va.pays_id = pa.id
                JOIN marchandises m ON t.marchandise_id = m.id
                JOIN clients c ON m.client_id = c.id
                JOIN modes_transport mt ON t.mode_transport_id = mt.id
                LEFT JOIN factures f ON f.transit_id = t.id
            ";

            $stmt = $pdo->query($query);
            $rows = $stmt->fetchAll();

            // Parcourt chaque ligne de résultat retournée par MySQL.
            foreach ($rows as $row) {
                // Instanciation manuelle des objets (mapping relationnel-objet).
                $paysDepart = new Pays($row['pd_nom'], (int)$row['pd_id']);
                $villeDepart = new Ville($row['vd_nom'], $paysDepart, (int)$row['vd_id']);

                $paysArrivee = new Pays($row['pa_nom'], (int)$row['pa_id']);
                $villeArrivee = new Ville($row['va_nom'], $paysArrivee, (int)$row['va_id']);

                $client = new Client($row['c_nom'], $row['c_email'], (int)$row['c_id']);
                $marchandise = new Marchandise(
                    $row['m_des'], (float)$row['m_pds'], (float)$row['m_surf'], 
                    $row['m_etat'], $client, (int)$row['m_id']
                );

                $modeTransport = new ModeTransport(
                    $row['mt_nom'], $row['mt_type'], (float)$row['mt_tarif'], (int)$row['mt_id']
                );

                $transit = new Transit(
                    $villeDepart, $villeArrivee,
                    new DateTimeImmutable($row['date_depart']), new DateTimeImmutable($row['date_arrivee']),
                    $marchandise, $modeTransport, (int)$row['transit_id']
                );

                // Si une facture existe pour ce transit, on l'instancie et on la lie.
                $factureObj = null;
                if ($row['f_id'] !== null) {
                    $factureObj = new Facture(
                        $row['f_num'], (float)$row['f_brut'], (float)$row['f_ttc'],
                        $transit->getBaseCalcul(), new DateTimeImmutable($row['f_date']),
                        $transit, (int)$row['f_id']
                    );
                    $transit->setFacture($factureObj);
                    
                    // Accumulation des revenus réels (les factures émises).
                    $totalRevenue += $factureObj->getMontantTtc();
                }

                // Ajout à notre collection de données de transits.
                $transits[] = [
                    'transit' => $transit,
                    'facture' => $factureObj
                ];

                // Cumul des statistiques physiques (poids global et surface globale).
                $totalWeight += $marchandise->getPoids();
                $totalSurface += $marchandise->getSurface();
            }
        } catch (Exception $e) {
            die("Erreur d'hydratation des modèles PHP : " . $e->getMessage());
        }

        $activeTransitsCount = count($transits);

        // Appel du moteur de rendu du Core\Controller pour inclure la vue dashboard.php.
        // On lui transmet le tableau de variables que la vue pourra utiliser directement.
        $this->view('dashboard', [
            'listeClients' => $listeClients,
            'listeVilles' => $listeVilles,
            'listeModesTransport' => $listeModesTransport,
            'transits' => $transits,
            'totalRevenue' => $totalRevenue,
            'totalWeight' => $totalWeight,
            'totalSurface' => $totalSurface,
            'activeTransitsCount' => $activeTransitsCount
        ]);
    }

    /**
     * Traite la soumission des formulaires en méthode POST (Ajout & Modification).
     */
    public function storeTransit() {
        // --- CASE 1 : NOUVEAU TRANSIT ---
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'nouveau_transit') {
            $dbConfig = new Database();
            $pdo = $dbConfig->getConnection();
            $facturationService = new FacturationService(); // Appel de notre service de calcul de taxes.

            try {
                // 1. Validation de sécurité : Empêcher que la ville de départ soit identique à la ville d'arrivée.
                if ((int)$_POST['ville_depart_id'] === (int)$_POST['ville_arrivee_id']) {
                    throw new Exception("La ville de départ et de destination doivent être différentes.");
                }

                // Validation : Poids et surface doivent être positifs.
                if ((float)$_POST['poids'] <= 0 || (float)$_POST['surface'] <= 0) {
                    throw new Exception("Le poids et la surface doivent être supérieurs à 0.");
                }

                // Validation : Cohérence temporelle des dates.
                if (strtotime($_POST['date_depart']) >= strtotime($_POST['date_arrivee'])) {
                    throw new Exception("La date d'arrivée doit être après la date de départ.");
                }

                // Vérifier si le client existe déjà (par email)
                $email = htmlspecialchars(trim($_POST['client_email']));
                $nom   = htmlspecialchars(trim($_POST['client_nom']));
                
                $stmtC = $pdo->prepare("SELECT id FROM clients WHERE email = :email LIMIT 1");
                $stmtC->execute([':email' => $email]);
                $clientId = $stmtC->fetchColumn();

                if ($clientId) {
                    // Client existant : mise à jour du nom si nécessaire
                    $stmtCUp = $pdo->prepare("UPDATE clients SET nom = :nom WHERE id = :id");
                    $stmtCUp->execute([':nom' => $nom, ':id' => (int)$clientId]);
                    $clientId = (int)$clientId;
                } else {
                    // Nouveau client : insertion
                    $stmtCIns = $pdo->prepare("INSERT INTO clients (nom, email) VALUES (:nom, :email)");
                    $stmtCIns->execute([':nom' => $nom, ':email' => $email]);
                    $clientId = (int)$pdo->lastInsertId();
                }

                // Insertion physique de la marchandise dans la BDD.
                $stmtM = $pdo->prepare("
                    INSERT INTO marchandises (designation, poids, surface, etat, client_id)
                    VALUES (:designation, :poids, :surface, :etat, :client_id)
                ");
                $stmtM->execute([
                    ':designation' => htmlspecialchars(trim($_POST['designation'])),
                    ':poids'        => (float)$_POST['poids'],
                    ':surface'      => (float)$_POST['surface'],
                    ':etat'         => $_POST['etat'],
                    ':client_id'    => $clientId,
                ]);
                $marchandiseId = (int)$pdo->lastInsertId(); // Récupère l'ID généré automatiquement.

                // Insertion physique du transit dans la BDD.
                $stmtT = $pdo->prepare("
                    INSERT INTO transits (ville_depart_id, ville_arrivee_id, date_depart, date_arrivee, marchandise_id, mode_transport_id)
                    VALUES (:vd, :va, :dd, :da, :mid, :mtid)
                ");
                $stmtT->execute([
                    ':vd'   => (int)$_POST['ville_depart_id'],
                    ':va'   => (int)$_POST['ville_arrivee_id'],
                    ':dd'   => date('Y-m-d H:i:s', strtotime($_POST['date_depart'])),
                    ':da'   => date('Y-m-d H:i:s', strtotime($_POST['date_arrivee'])),
                    ':mid'  => $marchandiseId,
                    ':mtid' => (int)$_POST['mode_transport_id'],
                ]);
                $transitId = (int)$pdo->lastInsertId();

                // 2. Hydratation temporaire des modèles pour calculer la facture avec précision en PHP.
                $mt = $pdo->prepare("SELECT * FROM modes_transport WHERE id = ?");
                $mt->execute([(int)$_POST['mode_transport_id']]);
                $mtRow = $mt->fetch();

                $modeObj      = new ModeTransport($mtRow['nom'], $mtRow['type'], (float)$mtRow['tarif_unitaire'], (int)$mtRow['id']);
                $clientTmp    = new Client('tmp', 'tmp@tmp.com');
                $marchandiseObj = new Marchandise(
                    htmlspecialchars(trim($_POST['designation'])),
                    (float)$_POST['poids'],
                    (float)$_POST['surface'],
                    $_POST['etat'],
                    $clientTmp,
                    $marchandiseId
                );
                
                // Récupération des noms des villes pour le constructeur.
                $vdRow = $pdo->query("SELECT v.*, p.nom AS pays_nom, p.id AS pays_id FROM villes v JOIN pays p ON v.pays_id = p.id WHERE v.id = " . (int)$_POST['ville_depart_id'])->fetch();
                $vaRow = $pdo->query("SELECT v.*, p.nom AS pays_nom, p.id AS pays_id FROM villes v JOIN pays p ON v.pays_id = p.id WHERE v.id = " . (int)$_POST['ville_arrivee_id'])->fetch();

                $transitObj = new Transit(
                    new Ville($vdRow['nom'], new Pays($vdRow['pays_nom'], $vdRow['pays_id']), $vdRow['id']),
                    new Ville($vaRow['nom'], new Pays($vaRow['pays_nom'], $vaRow['pays_id']), $vaRow['id']),
                    new DateTimeImmutable($_POST['date_depart']),
                    new DateTimeImmutable($_POST['date_arrivee']),
                    $marchandiseObj,
                    $modeObj,
                    $transitId
                );

                // 3. Calcul & initialisation de la facture légale.
                $montantBrut = $facturationService->calculerMontantBrut($transitObj);
                $montantTtc  = $facturationService->calculerMontantTtc($transitObj);
                // Génération automatique d'un numéro de facture structuré.
                $numero      = 'FAC-' . date('Y') . '-' . str_pad((string)($transitId + 10), 4, '0', STR_PAD_LEFT);

                // Insertion de la facture dans la base de données.
                $stmtF = $pdo->prepare("
                    INSERT INTO factures (numero, montant_brut, montant_ttc, base_calcul, date_facturation, transit_id)
                    VALUES (:num, :brut, :ttc, :base, :date, :tid)
                ");
                $stmtF->execute([
                    ':num'  => $numero,
                    ':brut' => $montantBrut,
                    ':ttc'  => $montantTtc,
                    ':base' => $transitObj->getBaseCalcul(),
                    ':date' => (new DateTimeImmutable())->format('Y-m-d H:i:s'),
                    ':tid'  => $transitId,
                ]);

                // Redirection vers le dashboard avec un message de succès (1 = ajout).
                $this->redirect('?success=1');

            } catch (Exception $e) {
                // En cas d'erreur de validation ou SQL, on redirige en passant l'erreur dans l'URL.
                $this->redirect('?error=' . urlencode($e->getMessage()));
            }
            
        // --- CASE 2 : MODIFICATION D'UN TRANSIT ---
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'modifier_transit') {
            $dbConfig = new Database();
            $pdo = $dbConfig->getConnection();
            $transitId = (int)$_POST['transit_id'];
            
            try {
                // Validation de sécurité sur les villes.
                if ((int)$_POST['ville_depart_id'] === (int)$_POST['ville_arrivee_id']) {
                    throw new Exception("La ville de départ et de destination doivent être différentes.");
                }

                // Validation : Poids et surface doivent être positifs.
                if ((float)$_POST['poids'] <= 0 || (float)$_POST['surface'] <= 0) {
                    throw new Exception("Le poids et la surface doivent être supérieurs à 0.");
                }

                // Validation : Cohérence temporelle des dates.
                if (strtotime($_POST['date_depart']) >= strtotime($_POST['date_arrivee'])) {
                    throw new Exception("La date d'arrivée doit être après la date de départ.");
                }

                // 1. Récupération de l'ID de la marchandise.
                $stmt = $pdo->prepare("SELECT marchandise_id FROM transits WHERE id = :id");
                $stmt->execute([':id' => $transitId]);
                $marchandiseId = $stmt->fetchColumn();
                
                // Vérifier si le client existe déjà (par email)
                $email = htmlspecialchars(trim($_POST['client_email']));
                $nom   = htmlspecialchars(trim($_POST['client_nom']));
                
                $stmtC = $pdo->prepare("SELECT id FROM clients WHERE email = :email LIMIT 1");
                $stmtC->execute([':email' => $email]);
                $clientId = $stmtC->fetchColumn();

                if ($clientId) {
                    // Client existant : mise à jour du nom si nécessaire
                    $stmtCUp = $pdo->prepare("UPDATE clients SET nom = :nom WHERE id = :id");
                    $stmtCUp->execute([':nom' => $nom, ':id' => (int)$clientId]);
                    $clientId = (int)$clientId;
                } else {
                    // Nouveau client : insertion
                    $stmtCIns = $pdo->prepare("INSERT INTO clients (nom, email) VALUES (:nom, :email)");
                    $stmtCIns->execute([':nom' => $nom, ':email' => $email]);
                    $clientId = (int)$pdo->lastInsertId();
                }

                // 2. Mise à jour de la table marchandises.
                $stmtM = $pdo->prepare("
                    UPDATE marchandises 
                    SET designation = :designation, poids = :poids, surface = :surface, etat = :etat, client_id = :client_id
                    WHERE id = :id
                ");
                $stmtM->execute([
                    ':designation' => htmlspecialchars(trim($_POST['designation'])),
                    ':poids'        => (float)$_POST['poids'],
                    ':surface'      => (float)$_POST['surface'],
                    ':etat'         => $_POST['etat'],
                    ':client_id'    => $clientId,
                    ':id'           => $marchandiseId
                ]);
                
                // 3. Mise à jour de la table transits.
                $stmtT = $pdo->prepare("
                    UPDATE transits 
                    SET ville_depart_id = :vd, ville_arrivee_id = :va, date_depart = :dd, date_arrivee = :da, mode_transport_id = :mtid
                    WHERE id = :id
                ");
                $stmtT->execute([
                    ':vd'   => (int)$_POST['ville_depart_id'],
                    ':va'   => (int)$_POST['ville_arrivee_id'],
                    ':dd'   => date('Y-m-d H:i:s', strtotime($_POST['date_depart'])),
                    ':da'   => date('Y-m-d H:i:s', strtotime($_POST['date_arrivee'])),
                    ':mtid' => (int)$_POST['mode_transport_id'],
                    ':id'   => $transitId
                ]);
                
                // Note IMPORTANTE : Pas de recalcul automatique de la facture ! 
                // Pour des raisons légales et fiscales, une facture émise historique ne doit jamais être modifiée automatiquement.
                
                // Redirection vers la page appropriée (dashboard ou expéditions).
                $redirectTo = !empty($_POST['redirect_to']) ? $_POST['redirect_to'] : '?success=2';
                $this->redirect($redirectTo);
                exit;

            } catch (Exception $e) {
                $redirectTo = !empty($_POST['redirect_to']) ? $_POST['redirect_to'] : '?';
                $separator = (str_contains($redirectTo, '?')) ? '&' : '?';
                $this->redirect($redirectTo . $separator . 'error=' . urlencode($e->getMessage()));
            }
        }
    }

    /**
     * Affiche l'écran Liste des Expéditions.
     */
    public function expeditions() {
        $dbConfig = new Database();
        $pdo = $dbConfig->getConnection();
        
        // Chargement des listes pour alimenter le formulaire d'édition.
        $listeClients        = $pdo->query("SELECT id, nom FROM clients ORDER BY nom")->fetchAll();
        $listeVilles         = $pdo->query("SELECT v.id, v.nom, p.nom AS pays FROM villes v JOIN pays p ON v.pays_id = p.id ORDER BY v.nom")->fetchAll();
        $listeModesTransport = $pdo->query("SELECT id, nom, type FROM modes_transport ORDER BY nom")->fetchAll();

        $transits = [];
        try {
            // Requête pour charger tous les transits, triés par date de départ décroissante.
            $query = "
                SELECT 
                    t.id AS transit_id, t.date_depart, t.date_arrivee,
                    vd.id AS vd_id, vd.nom AS vd_nom, pd.id AS pd_id, pd.nom AS pd_nom,
                    va.id AS va_id, va.nom AS va_nom, pa.id AS pa_id, pa.nom AS pa_nom,
                    m.id AS m_id, m.designation AS m_des, m.poids AS m_pds, m.surface AS m_surf, m.etat AS m_etat,
                    c.id AS c_id, c.nom AS c_nom, c.email AS c_email,
                    mt.id AS mt_id, mt.nom AS mt_nom, mt.type AS mt_type, mt.tarif_unitaire AS mt_tarif,
                    f.id AS f_id, f.numero AS f_num, f.montant_brut AS f_brut, f.montant_ttc AS f_ttc, f.date_facturation AS f_date
                FROM transits t
                JOIN villes vd ON t.ville_depart_id = vd.id
                JOIN pays pd ON vd.pays_id = pd.id
                JOIN villes va ON t.ville_arrivee_id = va.id
                JOIN pays pa ON va.pays_id = pa.id
                JOIN marchandises m ON t.marchandise_id = m.id
                JOIN clients c ON m.client_id = c.id
                JOIN modes_transport mt ON t.mode_transport_id = mt.id
                LEFT JOIN factures f ON f.transit_id = t.id
                ORDER BY t.date_depart DESC
            ";

            $stmt = $pdo->query($query);
            $rows = $stmt->fetchAll();

            foreach ($rows as $row) {
                // Instanciation de nos objets métier PHP 8.2+.
                $paysDepart = new Pays($row['pd_nom'], (int)$row['pd_id']);
                $villeDepart = new Ville($row['vd_nom'], $paysDepart, (int)$row['vd_id']);

                $paysArrivee = new Pays($row['pa_nom'], (int)$row['pa_id']);
                $villeArrivee = new Ville($row['va_nom'], $paysArrivee, (int)$row['va_id']);

                $client = new Client($row['c_nom'], $row['c_email'], (int)$row['c_id']);
                $marchandise = new Marchandise(
                    $row['m_des'], (float)$row['m_pds'], (float)$row['m_surf'], 
                    $row['m_etat'], $client, (int)$row['m_id']
                );

                $modeTransport = new ModeTransport(
                    $row['mt_nom'], $row['mt_type'], (float)$row['mt_tarif'], (int)$row['mt_id']
                );

                $transit = new Transit(
                    $villeDepart, $villeArrivee,
                    new DateTimeImmutable($row['date_depart']), new DateTimeImmutable($row['date_arrivee']),
                    $marchandise, $modeTransport, (int)$row['transit_id']
                );

                if ($row['f_id'] !== null) {
                    $factureObj = new Facture(
                        $row['f_num'], (float)$row['f_brut'], (float)$row['f_ttc'],
                        $transit->getBaseCalcul(), new DateTimeImmutable($row['f_date']),
                        $transit, (int)$row['f_id']
                    );
                    $transit->setFacture($factureObj);
                }

                $transits[] = $transit;
            }
        } catch (Exception $e) {
            die("Erreur d'hydratation des transits : " . $e->getMessage());
        }
        
        // Rendu de la vue expeditions.php.
        require_once __DIR__ . '/../Views/expeditions.php';
    }

    /**
     * Affiche l'écran Registre des Factures.
     */
    public function factures() {
        $dbConfig = new Database();
        $pdo = $dbConfig->getConnection();
        
        // Chargement des listes pour le formulaire d'édition.
        $listeClients        = $pdo->query("SELECT id, nom FROM clients ORDER BY nom")->fetchAll();
        $listeVilles         = $pdo->query("SELECT v.id, v.nom, p.nom AS pays FROM villes v JOIN pays p ON v.pays_id = p.id ORDER BY v.nom")->fetchAll();
        $listeModesTransport = $pdo->query("SELECT id, nom, type FROM modes_transport ORDER BY nom")->fetchAll();

        $factures = [];
        $totalTtc = 0.0;
        $totalHt = 0.0;
        
        try {
            // Requête SQL pour récupérer l'historique complet des factures triées de la plus récente à la plus ancienne.
            $query = "
                SELECT 
                    f.id AS f_id, f.numero AS f_num, f.montant_brut AS f_brut, f.montant_ttc AS f_ttc, f.base_calcul AS f_base, f.date_facturation AS f_date,
                    t.id AS transit_id, t.date_depart, t.date_arrivee,
                    vd.id AS vd_id, vd.nom AS vd_nom, pd.id AS pd_id, pd.nom AS pd_nom,
                    va.id AS va_id, va.nom AS va_nom, pa.id AS pa_id, pa.nom AS pa_nom,
                    m.id AS m_id, m.designation AS m_des, m.poids AS m_pds, m.surface AS m_surf, m.etat AS m_etat,
                    c.id AS c_id, c.nom AS c_nom, c.email AS c_email,
                    mt.id AS mt_id, mt.nom AS mt_nom, mt.type AS mt_type, mt.tarif_unitaire AS mt_tarif
                FROM factures f
                JOIN transits t ON f.transit_id = t.id
                JOIN villes vd ON t.ville_depart_id = vd.id
                JOIN pays pd ON vd.pays_id = pd.id
                JOIN villes va ON t.ville_arrivee_id = va.id
                JOIN pays pa ON va.pays_id = pa.id
                JOIN marchandises m ON t.marchandise_id = m.id
                JOIN clients c ON m.client_id = c.id
                JOIN modes_transport mt ON t.mode_transport_id = mt.id
                ORDER BY f.date_facturation DESC
            ";

            $stmt = $pdo->query($query);
            $rows = $stmt->fetchAll();

            foreach ($rows as $row) {
                // Instanciation de la structure d'objets métier PHP.
                $paysDepart = new Pays($row['pd_nom'], (int)$row['pd_id']);
                $villeDepart = new Ville($row['vd_nom'], $paysDepart, (int)$row['vd_id']);

                $paysArrivee = new Pays($row['pa_nom'], (int)$row['pa_id']);
                $villeArrivee = new Ville($row['va_nom'], $paysArrivee, (int)$row['va_id']);

                $client = new Client($row['c_nom'], $row['c_email'], (int)$row['c_id']);
                $marchandise = new Marchandise(
                    $row['m_des'], (float)$row['m_pds'], (float)$row['m_surf'], 
                    $row['m_etat'], $client, (int)$row['m_id']
                );

                $modeTransport = new ModeTransport(
                    $row['mt_nom'], $row['mt_type'], (float)$row['mt_tarif'], (int)$row['mt_id']
                );

                $transit = new Transit(
                    $villeDepart, $villeArrivee,
                    new DateTimeImmutable($row['date_depart']), new DateTimeImmutable($row['date_arrivee']),
                    $marchandise, $modeTransport, (int)$row['transit_id']
                );

                $factureObj = new Facture(
                    $row['f_num'], (float)$row['f_brut'], (float)$row['f_ttc'],
                    (float)$row['f_base'], new DateTimeImmutable($row['f_date']),
                    $transit, (int)$row['f_id']
                );

                // Lie la facture à son transit.
                $transit->setFacture($factureObj);
                $factures[] = $factureObj;
                
                // Calcul des statistiques globales du registre.
                $totalTtc += $factureObj->getMontantTtc();
                $totalHt += $factureObj->getMontantBrut();
            }
        } catch (Exception $e) {
            die("Erreur d'hydratation des factures : " . $e->getMessage());
        }
        
        // Rendu de la vue factures.php.
        require_once __DIR__ . '/../Views/factures.php';
    }
}
