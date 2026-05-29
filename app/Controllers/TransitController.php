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
        // On initialise le service métier.
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
        $this->startSession();

        // Si c'est un client, on le redirige vers sa zone dédiée sans passer par le login
        if (isset($_SESSION['role']) && $_SESSION['role'] === 'client') {
            $this->redirect('/client');
            exit;
        }

        // Sinon, on vérifie que c'est bien un admin (redirige vers /login si non connecté)
        $this->checkAuth('admin');

        // --- INTERCEPTION DE LA SUPPRESSION D'UN TRANSIT ---
        // Si l'URL contient ?action=supprimer_transit&id=X, on supprime le transit avant d'afficher la page.
        if (isset($_GET['action']) && $_GET['action'] === 'supprimer_transit' && isset($_GET['id'])) {
            try {
                $this->transitService->deleteTransit((int)$_GET['id']);
                $this->redirect('/dashboard?success=delete');
                exit;
            } catch (Exception $e) {
                $this->redirect('/dashboard?error=' . urlencode($e->getMessage()));
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
        $this->checkAuth('admin');
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
                
                $redirectTo = !empty($_POST['redirect_to']) ? $_POST['redirect_to'] : '/dashboard?success=2';
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
        $this->checkAuth('admin');
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
        $this->checkAuth('admin');
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
        $this->checkAuth('admin');
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
        $this->checkAuth('admin');
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
}
