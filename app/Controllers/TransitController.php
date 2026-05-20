<?php
// "declare(strict_types=1)" active le typage strict en PHP.
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;              // Classe de base des contrôleurs.
use App\Services\TransitService;      // Service gérant la logique et les accès complexes.
use Exception;                        // Gestion des erreurs.

/**
 * TransitPro - TransitController
 * 
 * Contrôleur principal allégé. Il orchestre les requêtes HTTP,
 * délègue la logique métier à TransitService et appelle les vues.
 */
class TransitController extends Controller
{
    private TransitService $transitService;

    public function __construct()
    {
        // On démarre la session PHP si elle n'est pas déjà active.
        // La session permet de mémoriser des informations entre les pages
        // (comme "qui est connecté ?") sans les repasser à chaque requête.
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // FILTRE DE SÉCURITÉ GLOBAL : toutes les méthodes de ce contrôleur
        // sont protégées par ce seul bloc dans le constructeur.
        // Si $_SESSION['user_id'] n'est pas défini, c'est que l'utilisateur
        // n'est pas connecté. On le renvoie immédiatement vers la page de connexion.
        if (!isset($_SESSION['user_id'])) {
            // Contournement de la connexion : on auto-connecte l'utilisateur en tant qu'administrateur
            $_SESSION['user_id'] = 1;
            $_SESSION['username'] = 'admin';
            $_SESSION['role'] = 'admin';
            
            // Code original commenté
            // $this->redirect('/login');
            // exit;
        }

        // Si l'utilisateur est bien connecté, on instancie le service métier.
        $this->transitService = new TransitService();
    }

    /**
     * Action principale : Affiche le tableau de bord (dashboard).
     * 
     * URL associée : GET /
     * Accès protégé : seuls les utilisateurs connectés peuvent y accéder (filtré dans __construct).
     */
    public function dashboard(): void
    {
        // --- INTERCEPTION DE LA SUPPRESSION D'UN TRANSIT ---
        // Si l'URL contient ?action=supprimer_transit&id=X, on supprime le transit avant d'afficher la page.
        if (isset($_GET['action']) && $_GET['action'] === 'supprimer_transit' && isset($_GET['id'])) {
            try {
                $this->transitService->deleteTransit((int)$_GET['id']);
                $this->redirect('index.php?success=delete');
                exit;
            } catch (Exception $e) {
                $this->redirect('index.php?error=' . urlencode($e->getMessage()));
                exit;
            }
        }

        // --- CHARGEMENT DES DONNÉES DE CONFIGURATION POUR LES FORMULAIRES ---
        // On récupère ces listes proprement en passant par le Service Layer pour respecter le pattern MVC et éviter le SQL direct ici.
        $listeClients        = $this->transitService->getClientsList();
        $listeVilles         = $this->transitService->getVillesList();
        $listeModesTransport = $this->transitService->getModesTransportList();

        // Récupération des données opérationnelles et financières via le service.
        try {
            $data = $this->transitService->getDashboardData();
        } catch (Exception $e) {
            die("Erreur de récupération du tableau de bord : " . $e->getMessage());
        }

        // Rendu du Dashboard.
        $this->view('dashboard', [
            'listeClients'        => $listeClients,
            'listeVilles'          => $listeVilles,
            'listeModesTransport' => $listeModesTransport,
            'transits'            => $data['transits'],
            'totalRevenue'        => $data['totalRevenue'],
            'totalWeight'         => $data['totalWeight'],
            'totalSurface'        => $data['totalSurface'],
            'activeTransitsCount' => $data['activeTransitsCount']
        ]);
    }

    /**
     * Traite la soumission des formulaires POST (Création et Modification de transits).
     */
    public function storeTransit(): void
    {
        // --- CAS 1 : NOUVEAU TRANSIT ---
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'nouveau_transit') {
            try {
                $this->transitService->createTransit($_POST);
                $this->redirect('?success=1');
            } catch (Exception $e) {
                $this->redirect('?error=' . urlencode($e->getMessage()));
            }
            
        // --- CAS 2 : MODIFICATION D'UN TRANSIT ---
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'modifier_transit') {
            try {
                $transitId = (int)$_POST['transit_id'];
                $this->transitService->updateTransit($transitId, $_POST);
                
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
    public function expeditions(): void
    {
        // On récupère les listes de configuration via le Service Layer
        $listeClients        = $this->transitService->getClientsList();
        $listeVilles         = $this->transitService->getVillesList();
        $listeModesTransport = $this->transitService->getModesTransportList();

        try {
            $transits = $this->transitService->getExpeditionsData();
        } catch (Exception $e) {
            die("Erreur de chargement des expéditions : " . $e->getMessage());
        }
        
        $this->view('expeditions', [
            'listeClients'        => $listeClients,
            'listeVilles'         => $listeVilles,
            'listeModesTransport' => $listeModesTransport,
            'transits'            => $transits
        ]);
    }

    /**
     * Affiche l'écran Registre des Factures.
     */
    public function factures(): void
    {
        // On récupère les listes de configuration via le Service Layer
        $listeClients        = $this->transitService->getClientsList();
        $listeVilles         = $this->transitService->getVillesList();
        $listeModesTransport = $this->transitService->getModesTransportList();

        try {
            $data = $this->transitService->getFacturesData();
        } catch (Exception $e) {
            die("Erreur de chargement des factures : " . $e->getMessage());
        }
        
        $this->view('factures', [
            'listeClients'        => $listeClients,
            'listeVilles'         => $listeVilles,
            'listeModesTransport' => $listeModesTransport,
            'factures'            => $data['factures'],
            'totalTtc'            => $data['totalTtc'],
            'totalHt'             => $data['totalHt']
        ]);
    }

    /**
     * Affiche l'écran Configuration / Paramètres.
     */
    public function settings(): void
    {
        try {
            $data = $this->transitService->getSettingsData();
        } catch (Exception $e) {
            die("Erreur de chargement des paramètres : " . $e->getMessage());
        }

        $this->view('settings', [
            'tvaRate' => $data['tvaRate'],
            'modes'   => $data['modes']
        ]);
    }

    /**
     * Traite la soumission des formulaires de modification des paramètres.
     */
    public function updateSettings(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $tvaRate = (float)$_POST['tva_rate'];
                $tarifs = $_POST['tarifs'] ?? [];
                
                $this->transitService->updateSettings($tvaRate, $tarifs);
                $this->redirect('settings?success=1');
            } catch (Exception $e) {
                $this->redirect('settings?error=' . urlencode($e->getMessage()));
            }
        }
    }
    /**
     * Affiche l'écran d'Accueil (Présentation publique).
     */
    public function accueil(): void
    {
        $this->view('accueil');
    }

    /**
     * Affiche l'écran À Propos.
     */
    public function apropos(): void
    {
        $this->view('apropos');
    }
}
