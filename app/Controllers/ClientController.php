<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Repositories\TransitRepository;

/**
 * ClientController - Espace Client Sécurisé
 *
 * Accessible uniquement aux utilisateurs connectés avec le rôle 'client'.
 * Affiche les transits et factures propres au client connecté.
 */
class ClientController extends Controller
{
    private TransitRepository $repository;

    public function __construct()
    {
        $this->repository = new TransitRepository();
    }

    /**
     * Affiche le tableau de bord du client connecté.
     * GET /client
     */
    public function dashboard(): void
    {
        $this->checkAuth('client');
        $clientId = (int)($_SESSION['client_id'] ?? 0);

        // Récupérer uniquement les données de ce client
        $transits = $this->repository->findTransitsByClientId($clientId);
        $factures = $this->repository->findFacturesByClientId($clientId);

        // Calculer les statistiques simples
        $now      = new \DateTimeImmutable();
        $enCours  = 0;
        $livres   = 0;
        $attente  = 0;

        foreach ($transits as $transit) {
            $depart  = $transit->getDateDepart();
            $arrivee = $transit->getDateArrivee();

            if ($now < $depart) {
                $attente++;
            } elseif ($now >= $depart && $now <= $arrivee) {
                $enCours++;
            } else {
                $livres++;
            }
        }

        $this->view('client/dashboard', [
            'transits'  => $transits,
            'factures'  => $factures,
            'enCours'   => $enCours,
            'livres'    => $livres,
            'attente'   => $attente,
            'username'  => $_SESSION['username'] ?? 'Client',
        ]);
    }
}
