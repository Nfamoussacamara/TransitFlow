<?php
// Calcul dynamique du statut d'un transit selon les dates
function getStatutTransit(\DateTimeImmutable $depart, \DateTimeImmutable $arrivee): array
{
    $now = new \DateTimeImmutable();
    if ($now < $depart) {
        return ['label' => 'En attente', 'pct' => 0,   'color' => '#94a3b8', 'class' => 'badge-slate', 'icon' => '⏳'];
    } elseif ($now <= $arrivee) {
        $total   = $arrivee->getTimestamp() - $depart->getTimestamp();
        $elapsed = $now->getTimestamp()     - $depart->getTimestamp();
        $pct     = $total > 0 ? min(99, (int)(($elapsed / $total) * 100)) : 50;
        return ['label' => 'En transit', 'pct' => $pct, 'color' => '#0458e0', 'class' => 'badge-blue',  'icon' => '🚚'];
    }
    return ['label' => 'Livré', 'pct' => 100, 'color' => '#16a34a', 'class' => 'badge-green', 'icon' => '✅'];
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Espace Client – TransitPro</title>
    <meta name="description" content="Espace client TransitPro : suivez vos expéditions et consultez vos factures en temps réel.">
    <!-- CSS AOS -->
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css">
    <!-- Design System (même feuille de style que l'admin) -->
    <link rel="stylesheet" href="/transit/public/css/style.css?v=3.1">
    <style>
        /* ── Layout sans sidebar ── */
        .app-container {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .main-content {
            flex: 1;
            margin-left: 0;
            width: 100%;
            padding: 0;
        }

        /* ── Navbar améliorée ── */
        .top-navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 2.5rem;
            height: 70px;
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.06);
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .navbar-title {
            font-family: 'Outfit', sans-serif;
            font-size: 1rem;
            font-weight: 700;
            color: #0f172a;
        }

        .navbar-nav-links {
            display: flex;
            gap: 2rem;
            align-items: center;
            flex: 1;
            justify-content: center;
            margin: 0 3rem;
        }

        .navbar-nav-links a {
            color: #64748b;
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: 500;
            transition: color 0.3s ease;
            position: relative;
        }

        .navbar-nav-links a:hover {
            color: rgb(4, 88, 224) !important;
        }

        .navbar-nav-links a::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            right: 0;
            height: 2px;
            background: rgb(4, 88, 224);
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .navbar-nav-links a:hover::after {
            transform: scaleX(1);
        }

        /* ── Header centré ── */
        .dashboard-header {
            margin-bottom: 2rem;
            padding: 2.5rem 2.5rem 1.5rem;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            text-align: center;
        }

        .header-title {
            width: 100%;
        }

        .header-title h1 {
            font-family: 'Outfit', sans-serif;
            font-size: clamp(1.75rem, 2.5vw + 0.5rem, 2.5rem);
            font-weight: 700;
            letter-spacing: -0.5px;
            margin-bottom: 0.5rem;
        }

        .header-title p {
            color: #64748b;
            font-size: 0.95rem;
        }

        /* ── Grid de KPI cartes ── */
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1.25rem;
            margin-bottom: 2.5rem;
            padding: 0 2.5rem;
            max-width: 1400px;
            margin-left: auto;
            margin-right: auto;
            width: calc(100% - 5rem);
        }

        /* ── Badge vert manquant dans le design system ── */
        .badge-green {
            background: rgba(22, 163, 74, 0.1);
            color: #16a34a;
        }

        /* ── Section Expéditions ── */
        .transit-card {
            background: #fff;
            border: 1px solid rgba(0,0,0,0.08);
            border-radius: 14px;
            padding: 1.4rem 1.6rem;
            margin-bottom: 1rem;
            transition: box-shadow 0.25s ease, transform 0.25s ease;
        }
        .transit-card:hover {
            box-shadow: 0 8px 28px -6px rgba(4, 88, 224, 0.12);
            transform: translateY(-2px);
        }
        .transit-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.85rem;
            flex-wrap: wrap;
            gap: .5rem;
        }
        .transit-route {
            font-family: 'Outfit', sans-serif;
            font-size: 1.05rem;
            font-weight: 700;
            color: #0f172a;
        }
        .transit-route .arrow {
            color: rgb(4, 88, 224);
            margin: 0 6px;
        }
        .transit-mode {
            font-size: 0.78rem;
            color: #64748b;
            background: #f1f5f9;
            border-radius: 6px;
            padding: 4px 12px;
            font-weight: 500;
        }
        .transit-meta {
            font-size: 0.82rem;
            color: #64748b;
            margin-bottom: .6rem;
            display: flex;
            flex-wrap: wrap;
            gap: 1.25rem;
        }
        .transit-meta span {
            display: flex;
            align-items: center;
            gap: 5px;
        }
        /* ── Timeline ── */
        .timeline-wrap { margin-top: .75rem; }
        .timeline-labels {
            display: flex;
            justify-content: space-between;
            font-size: 0.72rem;
            color: #94a3b8;
            margin-bottom: .35rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .4px;
        }
        .timeline-track {
            background: #e2e8f0;
            border-radius: 99px;
            height: 8px;
            overflow: hidden;
        }
        .timeline-fill {
            height: 100%;
            border-radius: 99px;
            transition: width .6s cubic-bezier(.4,0,.2,1);
        }
        .timeline-status {
            font-size: 0.8rem;
            font-weight: 700;
            margin-top: .45rem;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        /* ── Factures table ── */
        .facture-table thead th { background: #f8fafc; }
        .facture-table tbody tr:hover td {
            background: rgba(4, 88, 224, 0.025);
        }
        /* ── Empty state ── */
        .empty-state {
            text-align: center;
            padding: 3.5rem 2rem;
            color: #94a3b8;
        }
        .empty-state .empty-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: .6;
        }
        .empty-state p { font-size: .9rem; }

        /* ── Avatar Client ── */
        .navbar-avatar-client {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: rgb(4, 88, 224);
            color: #ffffff;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Outfit', sans-serif;
            font-size: 0.85rem;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 0 0 3px rgba(4, 88, 224, 0.15);
            transition: all 0.25s ease;
        }
        .navbar-avatar-client:hover {
            transform: scale(1.08);
            box-shadow: 0 0 0 5px rgba(4, 88, 224, 0.2);
        }

        /* ── Section wrapper ── */
        .client-content {
            padding: 0 2.5rem 3rem;
            max-width: 1400px;
            margin-left: auto;
            margin-right: auto;
            width: calc(100% - 5rem);
        }
        .client-section {
            background: #fff;
            border-radius: 16px;
            border: 1px solid rgba(0,0,0,0.07);
            box-shadow: 0 4px 24px -6px rgba(0,0,0,0.04);
            padding: 1.75rem;
            margin-bottom: 2rem;
        }
        .client-section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }
        .client-section-title {
            font-family: 'Outfit', sans-serif;
            font-size: 1.1rem;
            font-weight: 700;
            color: #0f172a;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* ── Modale Facture ── */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
            animation: fadeIn 0.3s ease;
        }

        .modal-overlay.active {
            display: flex;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .modal-content {
            background: white;
            border-radius: 24px;
            padding: 2.5rem;
            max-width: 600px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            animation: slideUp 0.3s ease;
            position: relative;
        }

        @keyframes slideUp {
            from {
                transform: translateY(30px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.08);
        }

        .modal-title {
            font-family: 'Outfit', sans-serif;
            font-size: 1.25rem;
            font-weight: 700;
            color: #0f172a;
        }

        .modal-close {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: #64748b;
            transition: color 0.3s ease;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-close:hover {
            color: #0f172a;
        }

        .modal-section {
            margin-bottom: 1.5rem;
        }

        .modal-section-label {
            font-size: 0.75rem;
            color: #94a3b8;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.5rem;
        }

        .modal-section-value {
            font-size: 1rem;
            font-weight: 600;
            color: #0f172a;
        }

        .modal-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .modal-footer {
            display: flex;
            gap: 1rem;
            padding-top: 1.5rem;
            border-top: 1px solid rgba(0, 0, 0, 0.08);
            margin-top: 1.5rem;
        }

        .btn-modal {
            flex: 1;
            padding: 0.75rem 1.25rem;
            border-radius: 12px;
            border: 1px solid rgba(0, 0, 0, 0.1);
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            font-family: 'Outfit', sans-serif;
        }

        .btn-modal.primary {
            background: rgb(4, 88, 224);
            color: white;
            border-color: rgb(4, 88, 224);
        }

        .btn-modal.primary:hover {
            background: #0347b8;
            box-shadow: 0 4px 12px rgba(4, 88, 224, 0.3);
        }

        .btn-modal.secondary {
            background: #f1f5f9;
            color: #0f172a;
            border-color: #e2e8f0;
        }

        .btn-modal.secondary:hover {
            background: #e2e8f0;
        }

        .facture-row:hover {
            background: rgba(4, 88, 224, 0.02) !important;
        }

        .btn-voir-facture:hover {
            background: #0347b8 !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(4, 88, 224, 0.3);
        }

        /* ── Scrollbar très fine pour la modale ── */
        .modal-content::-webkit-scrollbar {
            width: 6px;
        }

        .modal-content::-webkit-scrollbar-track {
            background: transparent;
            margin-top: 10px;
            margin-bottom: 10px;
        }

        .modal-content::-webkit-scrollbar-thumb {
            background-color: rgba(0, 0, 0, 0.15);
            border-radius: 10px;
        }

        .modal-content::-webkit-scrollbar-thumb:hover {
            background-color: rgba(0, 0, 0, 0.3);
        }
    </style>
</head>
<body>

<div class="app-container">

    <!-- =========================================================
         MAIN CONTENT
         ========================================================= -->
    <main class="main-content">

        <!-- TOP NAVBAR -->
        <nav class="top-navbar">
            <div class="navbar-title">
                <a href="/transit/client" style="display: flex; align-items: center; gap: 8px; text-decoration: none; color: inherit;">
                    <svg viewBox="0 0 24 24" width="24" height="24" style="color: rgb(4, 88, 224);">
                        <path d="M4 15l8-8 8 8" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/>
                        <path d="M4 19l8-8 8 8" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" opacity="0.5"/>
                    </svg>
                    <span>Transit<span style="color: rgb(4, 88, 224); font-weight: 700;">Pro</span></span>
                </a>
            </div>
            <div class="navbar-nav-links" style="display: flex; gap: 1.5rem; align-items: center;">
                <a href="#expeditions" style="color: #64748b; text-decoration: none; font-size: 0.95rem; font-weight: 500; transition: color 0.3s;">
                    Expéditions
                </a>
                <a href="#factures" style="color: #64748b; text-decoration: none; font-size: 0.95rem; font-weight: 500; transition: color 0.3s;">
                    Factures
                </a>
            </div>
            <div class="navbar-actions">
                <!-- Horloge en direct -->
                <div class="navbar-clock">
                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polyline points="12 6 12 12 16 14"></polyline>
                    </svg>
                    <span id="live-clock">--:--:--</span>
                </div>
                <!-- Avatar Client (initiale du nom d'utilisateur) -->
                <div class="navbar-avatar-client" title="Mon profil">
                    <span><?= strtoupper(substr(htmlspecialchars($username), 0, 1)) ?></span>
                </div>
                <!-- Déconnexion -->
                <a href="/transit/logout" class="navbar-logout" title="Se déconnecter">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4M16 17l5-5-5-5M21 12H9"/>
                    </svg>
                </a>
            </div>
        </nav>

        <!-- HEADER -->
        <header class="dashboard-header" data-aos="fade-down">
            <div class="header-title">
                <h1>Bienvenue, <?= htmlspecialchars(explode('@', $username)[0]) ?> 👋</h1>
                <p>Suivez vos expéditions et consultez vos factures en temps réel</p>
            </div>
        </header>

        <!-- =====================================================
             KPI CARDS – 4 cartes identiques au design admin
             ===================================================== -->
        <div class="dashboard-grid">
            <!-- Card 1 : Expéditions totales -->
            <div class="dashboard-card card-blue-royal" data-aos="fade-up" data-aos-delay="0">
                <div class="card-header">
                    <div class="card-icon-container">
                        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/><path d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 011-1h2.392a1 1 0 01.737.327l2.824 3.106A1 1 0 0020 19H20a1 1 0 001-1v-5a1 1 0 00-1-1h-3.936a1 1 0 01-.737-.327l-2.824-3.106A1 1 0 0011.764 5H11"/></svg>
                    </div>
                    <span class="card-trend"><?= count($transits) ?> total</span>
                </div>
                <div class="card-body">
                    <h3 class="card-title">Expéditions</h3>
                    <p class="card-value"><?= count($transits) ?></p>
                </div>
                <div class="card-footer">
                    <span class="card-meta">Tous statuts confondus</span>
                </div>
            </div>

            <!-- Card 2 : En attente -->
            <div class="dashboard-card card-blue-slate" data-aos="fade-up" data-aos-delay="100">
                <div class="card-header">
                    <div class="card-icon-container">
                        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    </div>
                    <span class="card-trend">En attente</span>
                </div>
                <div class="card-body">
                    <h3 class="card-title">En Attente</h3>
                    <p class="card-value"><?= $attente ?></p>
                </div>
                <div class="card-footer">
                    <span class="card-meta">Départ non encore atteint</span>
                </div>
            </div>

            <!-- Card 3 : En transit -->
            <div class="dashboard-card card-blue-cyan" data-aos="fade-up" data-aos-delay="200">
                <div class="card-header">
                    <div class="card-icon-container">
                        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    </div>
                    <span class="card-trend">En cours</span>
                </div>
                <div class="card-body">
                    <h3 class="card-title">En Transit</h3>
                    <p class="card-value"><?= $enCours ?></p>
                </div>
                <div class="card-footer">
                    <span class="card-meta">En cours de routage</span>
                </div>
            </div>

            <!-- Card 4 : Livrés -->
            <div class="dashboard-card card-blue-indigo" data-aos="fade-up" data-aos-delay="300">
                <div class="card-header">
                    <div class="card-icon-container">
                        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <span class="card-trend">Terminés</span>
                </div>
                <div class="card-body">
                    <h3 class="card-title">Livrées</h3>
                    <p class="card-value"><?= $livres ?></p>
                </div>
                <div class="card-footer">
                    <span class="card-meta">Expéditions réceptionnées</span>
                </div>
            </div>
        </div>

        <!-- =====================================================
             SECTION : MES EXPÉDITIONS
             ===================================================== -->
        <div class="client-content">

            <section class="client-section" id="expeditions" data-aos="fade-up" data-aos-delay="100">
                <div class="client-section-header">
                    <h2 class="client-section-title">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/><path d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 011-1h1m0 0a1 1 0 011 1v1m-3 0h3"/></svg>
                        Mes Expéditions
                    </h2>
                    <span class="badge badge-blue"><?= count($transits) ?> enregistrée<?= count($transits) > 1 ? 's' : '' ?></span>
                </div>

                <?php if (empty($transits)): ?>
                    <div class="empty-state">
                        <div class="empty-icon">📦</div>
                        <p>Aucune expédition enregistrée pour votre compte pour le moment.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($transits as $transit):
                        $statut = getStatutTransit($transit->getDateDepart(), $transit->getDateArrivee());
                    ?>
                    <div class="transit-card">
                        <div class="transit-header">
                            <span class="transit-route">
                                <?= htmlspecialchars($transit->getVilleDepart()->getNom()) ?>
                                <span class="arrow">→</span>
                                <?= htmlspecialchars($transit->getVilleArrivee()->getNom()) ?>
                            </span>
                            <span class="transit-mode">
                                <?= htmlspecialchars($transit->getModeTransport()->getNom()) ?>
                            </span>
                        </div>

                        <div class="transit-meta">
                            <span>
                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                <?= htmlspecialchars($transit->getMarchandise()->getDesignation()) ?>
                                — <?= number_format($transit->getMarchandise()->getPoids(), 2) ?> kg
                            </span>
                            <span>
                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                Départ : <?= $transit->getDateDepart()->format('d/m/Y') ?>
                            </span>
                            <span>
                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                Arrivée prévue : <?= $transit->getDateArrivee()->format('d/m/Y') ?>
                            </span>
                        </div>

                        <!-- Barre de progression timeline -->
                        <div class="timeline-wrap" data-id="<?= $transit->getId() ?>" data-depart="<?= $transit->getDateDepart()->getTimestamp() ?>" data-arrivee="<?= $transit->getDateArrivee()->getTimestamp() ?>" data-servertime="<?= (new DateTimeImmutable())->getTimestamp() ?>">
                            <div class="timeline-labels">
                                <span><?= $transit->getVilleDepart()->getNom() ?></span>
                                <span><?= $transit->getVilleArrivee()->getNom() ?></span>
                            </div>
                            <div class="timeline-track">
                                <div class="timeline-fill" data-id="<?= $transit->getId() ?>"
                                     style="width: <?= $statut['pct'] ?>%; background: <?= $statut['color'] ?>;"></div>
                            </div>
                            <div class="timeline-status" style="color: <?= $statut['color'] ?>;" data-status="<?= $transit->getId() ?>">
                                <span data-icon="<?= $transit->getId() ?>"><?= $statut['icon'] ?></span>
                                <span class="badge <?= $statut['class'] ?>" data-label="<?= $transit->getId() ?>"><?= $statut['label'] ?></span>
                                <span style="font-size:.75rem; color: #94a3b8; font-weight: 500;" data-pct="<?= $transit->getId() ?>">
                                    — <?= $statut['pct'] ?>% achevé
                                </span>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </section>

            <!-- =====================================================
                 SECTION : MES FACTURES
                 ===================================================== -->
            <section class="client-section" id="factures" data-aos="fade-up" data-aos-delay="150">
                <div class="client-section-header">
                    <h2 class="client-section-title">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Mes Factures
                    </h2>
                    <span class="badge badge-cyan"><?= count($factures) ?> facture<?= count($factures) > 1 ? 's' : '' ?></span>
                </div>

                <?php if (empty($factures)): ?>
                    <div class="empty-state">
                        <div class="empty-icon">🧾</div>
                        <p>Aucune facture disponible pour le moment.</p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="custom-table facture-table">
                            <thead>
                                <tr>
                                    <th>N° Facture</th>
                                    <th>Date d'émission</th>
                                    <th>Montant HT</th>
                                    <th>Montant TTC</th>
                                    <th>Statut</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($factures as $f): 
                                    $transit = $f->getTransit();
                                    $marchandise = $transit->getMarchandise();
                                    $client = $marchandise->getClient();
                                    $tva = $f->getMontantTtc() - $f->getMontantBrut();
                                ?>
                                <tr class="facture-row" 
                                    data-facture-id="<?= htmlspecialchars($f->getNumero()) ?>"
                                    data-transit-id="<?= $transit->getId() ?>"
                                    data-facture-date="<?= $f->getDateFacturation()->format('d/m/Y H:i') ?>"
                                    data-facture-montant-ht="<?= $f->getMontantBrut() ?>"
                                    data-facture-montant-ttc="<?= $f->getMontantTtc() ?>"
                                    data-facture-tva="<?= $tva ?>"
                                    data-client-nom="<?= htmlspecialchars($client->getNom()) ?>"
                                    data-client-email="<?= htmlspecialchars($client->getEmail()) ?>"
                                    data-marchandise-designation="<?= htmlspecialchars($marchandise->getDesignation()) ?>"
                                    data-marchandise-poids="<?= $marchandise->getPoids() ?>"
                                    data-marchandise-surface="<?= $marchandise->getSurface() ?>"
                                    data-marchandise-etat="<?= htmlspecialchars($marchandise->getEtat()) ?>"
                                    data-ville-depart="<?= htmlspecialchars($transit->getVilleDepart()->getNom()) ?>"
                                    data-ville-depart-pays="<?= htmlspecialchars($transit->getVilleDepart()->getPays()->getNom()) ?>"
                                    data-ville-arrivee="<?= htmlspecialchars($transit->getVilleArrivee()->getNom()) ?>"
                                    data-ville-arrivee-pays="<?= htmlspecialchars($transit->getVilleArrivee()->getPays()->getNom()) ?>"
                                    data-date-depart="<?= $transit->getDateDepart()->format('d/m/Y H:i') ?>"
                                    data-date-arrivee="<?= $transit->getDateArrivee()->format('d/m/Y H:i') ?>"
                                    data-transport="<?= htmlspecialchars($transit->getModeTransport()->getNom()) ?>"
                                    data-transport-type="<?= htmlspecialchars($transit->getModeTransport()->getType()) ?>"
                                    data-transport-tarif="<?= $transit->getTarifUnitaire() ?>">
                                    <td><strong style="color: rgb(4,88,224);"><?= htmlspecialchars($f->getNumero()) ?></strong></td>
                                    <td><?= $f->getDateFacturation()->format('d/m/Y') ?></td>
                                    <td><?= number_format($f->getMontantBrut(), 0, ',', ' ') ?> GNF</td>
                                    <td><strong><?= number_format($f->getMontantTtc(), 0, ',', ' ') ?> GNF</strong></td>
                                    <td><span class="badge badge-cyan">Historisée &amp; Gelée</span></td>
                                    <td><button class="btn-voir-facture" onclick="openFactureModal(this)" style="background: rgb(4, 88, 224); color: white; border: none; padding: 6px 12px; border-radius: 12px; cursor: pointer; font-size: 0.85rem; font-weight: 500; transition: all 0.3s;">Voir détails</button></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </section>

        </div><!-- /client-content -->

    </main>
</div>

<!-- MODALE DÉTAILS FACTURE -->
<div class="modal-overlay" id="factureModal">
    <div class="modal-content" style="max-width: 750px;">
        <div class="modal-header">
            <h2 class="modal-title">📄 Détails de la Facture</h2>
            <button class="modal-close" onclick="closeFactureModal()">&times;</button>
        </div>
        
        <!-- Section Facture -->
        <div class="modal-section" style="background: rgba(4, 88, 224, 0.05); padding: 1.25rem; border-radius: 16px; border: 1px solid rgba(4, 88, 224, 0.2); margin-bottom: 1.5rem;">
            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem;">
                <div>
                    <div class="modal-section-label">N° Facture</div>
                    <div class="modal-section-value" id="modalFactureNumero" style="color: rgb(4, 88, 224); font-size: 1.1rem;">--</div>
                </div>
                <div>
                    <div class="modal-section-label">Date d'émission</div>
                    <div class="modal-section-value" id="modalFactureDate">--</div>
                </div>
                <div>
                    <div class="modal-section-label">Statut</div>
                    <div style="margin-top: 0.5rem;"><span class="badge badge-cyan">Historisée &amp; Gelée</span></div>
                </div>
            </div>
        </div>

        <!-- Section Marchandise -->
        <div class="modal-section" style="background: #f8fafc; padding: 1.25rem; border-radius: 16px; border: 1px solid rgba(0, 0, 0, 0.08); margin-bottom: 1.5rem;">
            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 1rem;">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                <div class="modal-section-label" style="margin: 0;">📦 Marchandise</div>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div>
                    <div class="modal-section-label">Désignation</div>
                    <div class="modal-section-value" id="modalMarchandiseDesignation">--</div>
                </div>
                <div>
                    <div class="modal-section-label">État</div>
                    <div class="modal-section-value"><span class="badge" id="modalMarchandiseEtat" style="background: #e2e8f0; color: #64748b;">--</span></div>
                </div>
                <div>
                    <div class="modal-section-label">Poids</div>
                    <div class="modal-section-value" id="modalMarchandisePoids">-- kg</div>
                </div>
                <div>
                    <div class="modal-section-label">Surface</div>
                    <div class="modal-section-value" id="modalMarchandiseSurface">-- m²</div>
                </div>
            </div>
        </div>

        <!-- Section Client -->
        <div class="modal-section" style="background: #f8fafc; padding: 1.25rem; border-radius: 16px; border: 1px solid rgba(0, 0, 0, 0.08); margin-bottom: 1.5rem;">
            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 1rem;">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M13 16a4 4 0 11-8 0 4 4 0 018 0z"></path><path d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div class="modal-section-label" style="margin: 0;">👤 Client</div>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div>
                    <div class="modal-section-label">Nom</div>
                    <div class="modal-section-value" id="modalClientNom">--</div>
                </div>
                <div>
                    <div class="modal-section-label">Email</div>
                    <div class="modal-section-value" id="modalClientEmail" style="font-size: 0.9rem; word-break: break-all;">--</div>
                </div>
            </div>
        </div>

        <!-- Section Logistique -->
        <div class="modal-section" style="background: #f8fafc; padding: 1.25rem; border-radius: 16px; border: 1px solid rgba(0, 0, 0, 0.08); margin-bottom: 1.5rem;">
            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 1rem;">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"></path><path d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 011-1h1m0 0a1 1 0 011 1v1m-3 0h3"></path></svg>
                <div class="modal-section-label" style="margin: 0;">📍 Itinéraire &amp; Transport</div>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                <div>
                    <div class="modal-section-label">Départ</div>
                    <div class="modal-section-value" id="modalVilleDepart">--</div>
                </div>
                <div>
                    <div class="modal-section-label">Arrivée</div>
                    <div class="modal-section-value" id="modalVilleArrivee">--</div>
                </div>
                <div>
                    <div class="modal-section-label">Date Départ</div>
                    <div class="modal-section-value" id="modalDateDepart">--</div>
                </div>
                <div>
                    <div class="modal-section-label">Date Arrivée</div>
                    <div class="modal-section-value" id="modalDateArrivee">--</div>
                </div>
            </div>
            <div>
                <div class="modal-section-label">Mode de Transport</div>
                <div class="modal-section-value" id="modalTransport">--</div>
                <div class="modal-section-label" style="margin-top: 0.5rem; font-size: 0.8rem;">Tarif Unitaire</div>
                <div style="font-size: 0.9rem; color: #64748b;" id="modalTransportTarif">--</div>
            </div>
        </div>

        <!-- Section Comptabilité -->
        <div class="modal-section" style="background: rgba(4, 88, 224, 0.08); padding: 1.25rem; border-radius: 16px; border: 1px solid rgba(4, 88, 224, 0.2); margin-bottom: 1.5rem;">
            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 1rem;">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <div class="modal-section-label" style="margin: 0;">💰 Facturation Légale (Gelée)</div>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem;">
                <div style="background: white; padding: 1rem; border-radius: 12px; border: 1px solid rgba(4, 88, 224, 0.15);">
                    <div class="modal-section-label">Montant HT</div>
                    <div class="modal-section-value" id="modalFactureMontantHT" style="color: rgb(4, 88, 224); font-size: 1.1rem;">-- GNF</div>
                </div>
                <div style="background: white; padding: 1rem; border-radius: 12px; border: 1px solid rgba(4, 88, 224, 0.15);">
                    <div class="modal-section-label">TVA (20%)</div>
                    <div class="modal-section-value" id="modalFactureTVA" style="color: #16a34a; font-size: 1.1rem;">-- GNF</div>
                </div>
                <div style="background: white; padding: 1rem; border-radius: 12px; border: 1px solid rgba(4, 88, 224, 0.15);">
                    <div class="modal-section-label">Total TTC</div>
                    <div class="modal-section-value" id="modalFactureMontantTTC" style="color: rgb(4, 88, 224); font-size: 1.1rem; font-weight: 800;">-- GNF</div>
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <button class="btn-modal secondary" onclick="closeFactureModal()">Fermer</button>
            <button class="btn-modal primary" onclick="downloadFacture()" style="background: rgb(4, 88, 224); color: white;">📥 Télécharger PDF</button>
        </div>
    </div>
</div>

<!-- AOS JS -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    // Initialisation AOS
    AOS.init({ duration: 550, easing: 'ease-out-cubic', once: true, offset: 40 });

    // Horloge en direct
    function updateClock() {
        const now = new Date();
        const pad = n => String(n).padStart(2, '0');
        document.getElementById('live-clock').textContent =
            `${pad(now.getHours())}:${pad(now.getMinutes())}:${pad(now.getSeconds())}`;
    }
    updateClock();
    setInterval(updateClock, 1000);

    // Smooth scroll pour les ancres sidebar
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });

    // Gestion de la modale facture
    function openFactureModal(button) {
        const row = button.closest('.facture-row');
        const numero = row.dataset.factureId;
        const montantHT = row.dataset.factureMontantHt;
        const montantTTC = row.dataset.factureMontantTtc;
        const tva = row.dataset.factureTva;
        const date = row.dataset.factureDate;
        
        const clientNom = row.dataset.clientNom;
        const clientEmail = row.dataset.clientEmail;
        
        const marchandiseDesignation = row.dataset.marchandiseDesignation;
        const marchandisePoids = row.dataset.marchandisePoids;
        const marchandiseSurface = row.dataset.marchandiseSurface;
        const marchandiseEtat = row.dataset.marchandiseEtat;
        
        const villeDepart = row.dataset.villeDepart;
        const villeDepartPays = row.dataset.villeDepartPays;
        const villeArrivee = row.dataset.villeArrivee;
        const villeArriveePays = row.dataset.villeArriveePays;
        const dateDepart = row.dataset.dateDepart;
        const dateArrivee = row.dataset.dateArrivee;
        
        const transport = row.dataset.transport;
        const transportType = row.dataset.transportType;
        const transportTarif = row.dataset.transportTarif;
        
        // Remplir la modale
        document.getElementById('modalFactureNumero').textContent = numero;
        document.getElementById('modalFactureDate').textContent = date;
        document.getElementById('modalFactureMontantHT').textContent = 
            new Intl.NumberFormat('fr-FR', { style: 'decimal', minimumFractionDigits: 0, maximumFractionDigits: 0 }).format(montantHT) + ' GNF';
        document.getElementById('modalFactureTVA').textContent = 
            new Intl.NumberFormat('fr-FR', { style: 'decimal', minimumFractionDigits: 0, maximumFractionDigits: 0 }).format(tva) + ' GNF';
        document.getElementById('modalFactureMontantTTC').textContent = 
            new Intl.NumberFormat('fr-FR', { style: 'decimal', minimumFractionDigits: 0, maximumFractionDigits: 0 }).format(montantTTC) + ' GNF';
        
        // Marchandise
        document.getElementById('modalMarchandiseDesignation').textContent = marchandiseDesignation;
        document.getElementById('modalMarchandisePoids').textContent = parseFloat(marchandisePoids).toLocaleString('fr-FR') + ' kg';
        document.getElementById('modalMarchandiseSurface').textContent = parseFloat(marchandiseSurface).toLocaleString('fr-FR') + ' m²';
        document.getElementById('modalMarchandiseEtat').textContent = marchandiseEtat;
        document.getElementById('modalMarchandiseEtat').className = 'badge';
        if (marchandiseEtat === 'Neuf') {
            document.getElementById('modalMarchandiseEtat').style.background = 'rgba(4, 88, 224, 0.1)';
            document.getElementById('modalMarchandiseEtat').style.color = 'rgb(4, 88, 224)';
        } else if (marchandiseEtat === 'Usagé') {
            document.getElementById('modalMarchandiseEtat').style.background = 'rgba(100, 116, 139, 0.1)';
            document.getElementById('modalMarchandiseEtat').style.color = '#64748b';
        } else {
            document.getElementById('modalMarchandiseEtat').style.background = 'rgba(6, 182, 212, 0.1)';
            document.getElementById('modalMarchandiseEtat').style.color = '#06b6d4';
        }
        
        // Client
        document.getElementById('modalClientNom').textContent = clientNom;
        document.getElementById('modalClientEmail').textContent = clientEmail;
        
        // Logistique
        document.getElementById('modalVilleDepart').textContent = villeDepart + ' (' + villeDepartPays + ')';
        document.getElementById('modalVilleArrivee').textContent = villeArrivee + ' (' + villeArriveePays + ')';
        document.getElementById('modalDateDepart').textContent = dateDepart;
        document.getElementById('modalDateArrivee').textContent = dateArrivee;
        document.getElementById('modalTransport').textContent = transport + ' (' + transportType + ')';
        document.getElementById('modalTransportTarif').textContent = 
            new Intl.NumberFormat('fr-FR', { style: 'decimal', minimumFractionDigits: 0, maximumFractionDigits: 0 }).format(transportTarif) + ' GNF';
        
        document.getElementById('factureModal').classList.add('active');
    }

    function closeFactureModal() {
        document.getElementById('factureModal').classList.remove('active');
    }

    function downloadFacture() {
        alert('Téléchargement du PDF en cours...');
        // Ajouter la logique de téléchargement PDF ici
    }

    // Fermer la modale en cliquant en dehors
    document.getElementById('factureModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeFactureModal();
        }
    });

    // Fermer avec la touche Échap
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeFactureModal();
        }
    });

    // Mise à jour automatique des barres de progression en temps réel
    // Garder les références de temps lors du chargement
    const initialTime = Math.floor(Date.now() / 1000);

    const STATUS_CONFIG = {
        waiting: { pct: 0, label: 'En attente', color: '#94a3b8', icon: '⏳', class: 'badge-slate' },
        transit: { label: 'En transit', color: '#0458e0', icon: '🚚', class: 'badge-blue' },
        delivered: { pct: 100, label: 'Livré', color: '#16a34a', icon: '✅', class: 'badge-green' }
    };

    function getStatus(now, departTs, arriveeTs) {
        if (now < departTs) return STATUS_CONFIG.waiting;
        if (now <= arriveeTs) {
            const total = arriveeTs - departTs;
            const elapsed = now - departTs;
            const pct = Math.min(99, Math.floor((elapsed / total) * 100));
            return { ...STATUS_CONFIG.transit, pct };
        }
        return STATUS_CONFIG.delivered;
    }

    function updateTransitProgress() {
        const elapsed = Math.floor(Date.now() / 1000) - initialTime;

        document.querySelectorAll('.timeline-wrap').forEach(timeline => {
            const id = timeline.getAttribute('data-id');
            const now = parseInt(timeline.getAttribute('data-servertime')) + elapsed;
            const status = getStatus(now, parseInt(timeline.getAttribute('data-depart')), parseInt(timeline.getAttribute('data-arrivee')));

            // Mettre à jour tous les éléments en une seule opération
            timeline.querySelector(`.timeline-fill[data-id="${id}"]`).style.cssText = `width: ${status.pct}%; background: ${status.color};`;
            timeline.querySelector(`.timeline-status[data-status="${id}"]`).style.color = status.color;
            timeline.querySelector(`[data-icon="${id}"]`).textContent = status.icon;
            
            const label = timeline.querySelector(`[data-label="${id}"]`);
            label.textContent = status.label;
            label.className = 'badge ' + status.class;
            
            timeline.querySelector(`[data-pct="${id}"]`).textContent = `— ${status.pct}% achevé`;
        });
    }

    updateTransitProgress();
    setInterval(updateTransitProgress, 1000);
</script>

</body>
</html>
