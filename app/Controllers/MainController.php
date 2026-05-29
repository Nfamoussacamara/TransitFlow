<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;

/**
 * MainController - Gère les pages publiques de l'application (Vitrine).
 */
class MainController extends Controller
{
    /**
     * Affiche la page d'accueil publique (Landing Page).
     * GET /
     */
    public function index(): void
    {
        $this->startSession();

        // Si déjà connecté, on peut proposer un bouton "Aller au Dashboard" 
        // ou rediriger automatiquement, mais une landing page reste utile.
        $this->view('home');
    }

    /**
     * Affiche la page "À Propos".
     * GET /about
     */
    public function about(): void
    {
        $this->startSession();
        $this->view('about');
    }

    /**
     * Affiche la page "Contact".
     * GET /contact
     */
    public function contact(): void
    {
        $this->startSession();
        $this->view('contact');
    }
}
