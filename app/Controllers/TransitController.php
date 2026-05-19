<?php
// "declare(strict_types=1)" active le typage strict en PHP.
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;              // Classe de base des contrôleurs.
use App\Config\Database;              // Connexion PDO pour charger les listes statiques simples.
use App\Services\TransitService;      // Service gérant la logique et les accès complexes.
use Exception;                        // Gestion des erreurs.

/**
 * TransitFlow - TransitController
 * 
 * Contrôleur principal allégé. Il orchestre les requêtes HTTP,
 * délègue la logique métier à TransitService et appelle les vues.
 */
class TransitController extends Controller
{
    private TransitService $transitService;

    public function __construct()
    {
        $this->transitService = new TransitService();
    }

    /**
     * Action principale : Affiche le tableau de bord (dashboard).
     */
    public function dashboard(): void
    {
        // Initialisation automatique du schéma physique de la base si nécessaire.
        try {
            $this->transitService->initializeDatabase();
        } catch (Exception $e) {
            die($e->getMessage());
        }

        // --- SECTION : INTERCEPTEUR DE SUPPRESSION ---
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
        $dbConfig = new Database();
        $pdo = $dbConfig->getConnection();
        $listeClients        = $pdo->query("SELECT id, nom FROM clients ORDER BY nom")->fetchAll();
        $listeVilles         = $pdo->query("SELECT v.id, v.nom, p.nom AS pays FROM villes v JOIN pays p ON v.pays_id = p.id ORDER BY v.nom")->fetchAll();
        $listeModesTransport = $pdo->query("SELECT id, nom, type FROM modes_transport ORDER BY nom")->fetchAll();

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
        $dbConfig = new Database();
        $pdo = $dbConfig->getConnection();
        
        $listeClients        = $pdo->query("SELECT id, nom FROM clients ORDER BY nom")->fetchAll();
        $listeVilles         = $pdo->query("SELECT v.id, v.nom, p.nom AS pays FROM villes v JOIN pays p ON v.pays_id = p.id ORDER BY v.nom")->fetchAll();
        $listeModesTransport = $pdo->query("SELECT id, nom, type FROM modes_transport ORDER BY nom")->fetchAll();

        try {
            $transits = $this->transitService->getExpeditionsData();
        } catch (Exception $e) {
            die("Erreur de chargement des expéditions : " . $e->getMessage());
        }
        
        require_once __DIR__ . '/../Views/expeditions.php';
    }

    /**
     * Affiche l'écran Registre des Factures.
     */
    public function factures(): void
    {
        $dbConfig = new Database();
        $pdo = $dbConfig->getConnection();
        
        $listeClients        = $pdo->query("SELECT id, nom FROM clients ORDER BY nom")->fetchAll();
        $listeVilles         = $pdo->query("SELECT v.id, v.nom, p.nom AS pays FROM villes v JOIN pays p ON v.pays_id = p.id ORDER BY v.nom")->fetchAll();
        $listeModesTransport = $pdo->query("SELECT id, nom, type FROM modes_transport ORDER BY nom")->fetchAll();

        try {
            $data = $this->transitService->getFacturesData();
        } catch (Exception $e) {
            die("Erreur de chargement des factures : " . $e->getMessage());
        }
        
        $factures = $data['factures'];
        $totalTtc  = $data['totalTtc'];
        $totalHt   = $data['totalHt'];

        require_once __DIR__ . '/../Views/factures.php';
    }
}
