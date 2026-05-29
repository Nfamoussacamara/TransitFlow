<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TransitPro - Tableau de Bord</title>
    <!-- CSS AOS & Swiper JS CDN -->
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css">
    <!-- Leaflet.js Cartographie -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <!-- Notre Design System local (avec cache-buster) -->
    <link rel="stylesheet" href="/transit/public/css/style.css?v=2.9">
</head>

<body>

    <div class="app-container">

        <!-- =========================================================================
       Sidebar Navigation & Brand Logo Space (Section 17.2)
       ========================================================================= -->
        <aside class="sidebar">
            <div class="brand-logo-container">
                <a href="/transit/" class="brand-logo-link">
                    <div class="brand-logo-mark">
                        <svg viewBox="0 0 24 24" class="logo-svg">
                            <path d="M4 15l8-8 8 8" fill="none" stroke="currentColor" stroke-width="2.5"
                                stroke-linecap="round" />
                            <path d="M4 19l8-8 8 8" fill="none" stroke="currentColor" stroke-width="1.5"
                                stroke-linecap="round" opacity="0.5" />
                        </svg>
                    </div>
                    <span class="brand-logo-text">Transit<span class="text-accent">Pro</span></span>
                </a>
            </div>

            <ul class="sidebar-menu">
                <li class="menu-item active">
                    <a href="/transit/dashboard">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path
                                d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                            </path>
                        </svg>
                        Dashboard
                    </a>
                </li>
                <li class="menu-item">
                    <a href="/transit/expeditions">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                            </path>
                        </svg>
                        Expéditions
                    </a>
                </li>
                <li class="menu-item">
                    <a href="/transit/factures">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                        Factures
                    </a>
                </li>
                <li class="menu-item">
                    <a href="/transit/settings">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                            </path>
                            <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Paramètres
                    </a>
                </li>
            </ul>

            <div class="sidebar-footer">
                <div class="menu-item">
                    <a href="/transit/" style="color: rgba(255, 255, 255, 0.75);">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                            </path>
                        </svg>
                        Retour au site
                    </a>
                </div>
            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="main-content">

            <!-- =========================================================================
           Top Navbar : Heure en direct + Avatar Profil
           ========================================================================= -->
            <nav class="top-navbar">
                <!-- Titre de la page active -->
                <div class="navbar-title">
                    <span>Tableau de Bord</span>
                </div>

                <!-- Actions à droite : Heure + Avatar -->
                <div class="navbar-actions">

                    <!-- Horloge en direct (mise à jour via JS) -->
                    <div class="navbar-clock">
                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="12 6 12 12 16 14"></polyline>
                        </svg>
                        <span id="live-clock">--:--:--</span>
                    </div>

                    <!-- Bulle de profil rouge -->
                    <div class="navbar-avatar" title="Profil Administrateur">
                        <span>A</span>
                    </div>

                    <!-- Bouton de déconnexion -->
                    <a href="/transit/logout" class="navbar-logout" title="Se déconnecter">
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5"
                            viewBox="0 0 24 24">
                            <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4M16 17l5-5-5-5M21 12H9" />
                        </svg>
                    </a>

                </div>
            </nav>

            <?php if (isset($_GET['success'])): ?>
                <!-- Bannière de succès après action -->
                <div class="flash-success" id="flash-msg">
                    <?php
                    if ($_GET['success'] === '1') {
                        echo "✅ &nbsp; Nouveau transit enregistré avec succès et facture générée automatiquement !";
                    } elseif ($_GET['success'] === '2') {
                        echo "✅ &nbsp; Le transit a été modifié avec succès et sa facture a été recalculée !";
                    } elseif ($_GET['success'] === 'delete') {
                        echo "🗑️ &nbsp; Le transit et tous ses enregistrements liés (marchandise, facture) ont été supprimés avec succès !";
                    }
                    ?>
                    <button onclick="document.getElementById('flash-msg').remove()"
                        style="background:none;border:none;color:inherit;cursor:pointer;font-size:1rem;margin-left:1rem;">✕</button>
                </div>
            <?php endif; ?>

            <!-- Header -->
            <header class="dashboard-header">
                <div class="header-title">
                    <h1>Logistics Hub</h1>
                    <p>Suivi en direct des expéditions de marchandises</p>
                </div>
                <!-- Bouton Nouveau Transit aligné à droite du titre -->
                <button id="btn-nouveau-transit" class="btn-nouveau-transit" onclick="openNewTransitModal()">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5"
                        viewBox="0 0 24 24">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    Nouveau Transit
                </button>
            </header>

            <!-- =========================================================================
           Dashboard Swiper for Mobile Viewports (< 768px)
           ========================================================================= -->
            <div class="swiper-container dashboard-swiper">
                <div class="swiper-wrapper">
                    <!-- Card 1 : Transits Actifs (Bleu Royal) -->
                    <div class="swiper-slide">
                        <div class="dashboard-card card-blue-royal" data-aos="fade-up" data-aos-delay="0">
                            <div class="card-header">
                                <div class="card-icon-container">
                                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z">
                                        </path>
                                        <path
                                            d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 011-1h2.392a1 1 0 01.737.327l2.824 3.106a1 1 0 00.737.327H20a1 1 0 001-1v-5a1 1 0 00-1-1h-3.936a1 1 0 01-.737-.327l-2.824-3.106A1 1 0 0011.764 5H11">
                                        </path>
                                    </svg>
                                </div>
                                <span class="card-trend">+10%</span>
                            </div>
                            <div class="card-body">
                                <h3 class="card-title">Transits Actifs</h3>
                                <p class="card-value"><?= $activeTransitsCount ?></p>
                            </div>
                            <div class="card-footer">
                                <span class="card-meta">En cours de routage</span>
                            </div>
                        </div>
                    </div>

                    <!-- Card 2 : Chiffre d'Affaires (Bleu Cyan) -->
                    <div class="swiper-slide">
                        <div class="dashboard-card card-blue-cyan" data-aos="fade-up" data-aos-delay="100">
                            <div class="card-header">
                                <div class="card-icon-container">
                                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                        </path>
                                    </svg>
                                </div>
                                <span class="card-trend">+18.4%</span>
                            </div>
                            <div class="card-body">
                                <h3 class="card-title">Volume d'Affaires</h3>
                                <p class="card-value"><?= number_format($totalRevenue, 0, ',', ' ') ?> GNF</p>
                            </div>
                            <div class="card-footer">
                                <span class="card-meta">Montant TTC historisé</span>
                            </div>
                        </div>
                    </div>

                    <!-- Card 3 : Volume Fret (Bleu Slate) -->
                    <div class="swiper-slide">
                        <div class="dashboard-card card-blue-slate" data-aos="fade-up" data-aos-delay="200">
                            <div class="card-header">
                                <div class="card-icon-container">
                                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4">
                                        </path>
                                    </svg>
                                </div>
                                <span class="card-trend">Stable</span>
                            </div>
                            <div class="card-body">
                                <h3 class="card-title">Fret Global</h3>
                                <p class="card-value"><?= number_format($totalWeight, 0, ',', ' ') ?> kg</p>
                            </div>
                            <div class="card-footer">
                                <span class="card-meta">Surface cumulée : <?= $totalSurface ?> m²</span>
                            </div>
                        </div>
                    </div>

                    <!-- Card 4 : Actions Rapides (Bleu Indigo) -->
                    <div class="swiper-slide">
                        <div class="dashboard-card card-blue-indigo" data-aos="fade-up" data-aos-delay="300">
                            <div class="card-header">
                                <div class="card-icon-container">
                                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"></path>
                                        <circle cx="9" cy="7" r="4"></circle>
                                        <path d="M23 21v-2a4 4 0 00-3-3.87"></path>
                                        <path d="M16 3.13a4 4 0 010 7.75"></path>
                                    </svg>
                                </div>
                                <span class="card-trend badge-blue">Partenaires</span>
                            </div>
                            <div class="card-body">
                                <h3 class="card-title">Clients Actifs</h3>
                                <p class="card-value"><?= count($listeClients) ?></p>
                            </div>
                            <div class="card-footer">
                                <span class="card-meta">Comptes enregistrés</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Pagination Swiper discrète -->
                <div class="swiper-pagination"></div>
            </div>

            <!-- =========================================================================
           Standard CSS Grid Layout for Desktop Viewports (Section 17.3)
           ========================================================================= -->
            <div class="dashboard-grid">
                <!-- Card 1 -->
                <div class="dashboard-card card-blue-royal" data-aos="fade-up" data-aos-delay="0">
                    <div class="card-header">
                        <div class="card-icon-container">
                            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                <path
                                    d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 011-1h2.392a1 1 0 01.737.327l2.824 3.106a1 1 0 00.737.327H20a1 1 0 001-1v-5a1 1 0 00-1-1h-3.936a1 1 0 01-.737-.327l-2.824-3.106A1 1 0 0011.764 5H11">
                                </path>
                            </svg>
                        </div>
                        <span class="card-trend">+10%</span>
                    </div>
                    <div class="card-body">
                        <h3 class="card-title">Transits Actifs</h3>
                        <p class="card-value"><?= $activeTransitsCount ?></p>
                    </div>
                    <div class="card-footer">
                        <span class="card-meta">En cours de routage</span>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="dashboard-card card-blue-cyan" data-aos="fade-up" data-aos-delay="100">
                    <div class="card-header">
                        <div class="card-icon-container">
                            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                </path>
                            </svg>
                        </div>
                        <span class="card-trend">+18.4%</span>
                    </div>
                    <div class="card-body">
                        <h3 class="card-title">Volume d'Affaires</h3>
                        <p class="card-value"><?= number_format($totalRevenue, 0, ',', ' ') ?> GNF</p>
                    </div>
                    <div class="card-footer">
                        <span class="card-meta">Montant TTC historisé</span>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="dashboard-card card-blue-slate" data-aos="fade-up" data-aos-delay="200">
                    <div class="card-header">
                        <div class="card-icon-container">
                            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                        <span class="card-trend">Stable</span>
                    </div>
                    <div class="card-body">
                        <h3 class="card-title">Fret Global</h3>
                        <p class="card-value"><?= number_format($totalWeight, 0, ',', ' ') ?> kg</p>
                    </div>
                    <div class="card-footer">
                        <span class="card-meta">Surface cumulée : <?= $totalSurface ?> m²</span>
                    </div>
                </div>

                <!-- Card 4 -->
                <div class="dashboard-card card-blue-indigo" data-aos="fade-up" data-aos-delay="300">
                    <div class="card-header">
                        <div class="card-icon-container">
                            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path d="M23 21v-2a4 4 0 00-3-3.87"></path>
                                <path d="M16 3.13a4 4 0 010 7.75"></path>
                            </svg>
                        </div>
                        <span class="card-trend badge-blue">Partenaires</span>
                    </div>
                    <div class="card-body">
                        <h3 class="card-title">Clients Actifs</h3>
                        <p class="card-value"><?= count($listeClients) ?></p>
                    </div>
                    <div class="card-footer">
                        <span class="card-meta">Comptes enregistrés</span>
                    </div>
                </div>
            </div>

            <!-- Listing section -->
            <section class="data-section" data-aos="fade-up" data-aos-delay="200">
                <div class="section-header">
                    <h2>Rapports Récentes de Transit</h2>
                    <span class="badge badge-blue"><?= count($transits) ?> Enregistrés</span>
                </div>

                <div class="table-responsive">
                    <table class="custom-table">
                        <thead>
                            <tr>
                                <th>Désignation Marchandise</th>
                                <th>Propriétaire (Client)</th>
                                <th>Trajet (Départ ➜ Arrivée)</th>
                                <th>Mode de Transport</th>
                                <th>Statut Transit</th>
                                <th>Facture N°</th>
                                <th>Montant TTC</th>
                                <th>Statut Facture</th>
                                <th style="text-align: center;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($transits as $item): ?>
                                <?php
                                $transitObj = $item['transit'];
                                $factureObj = $item['facture'];
                                $marchandiseObj = $transitObj->getMarchandise();
                                ?>
                                <tr>
                                    <td>
                                        <strong><?= htmlspecialchars($marchandiseObj->getDesignation()) ?></strong>
                                    </td>
                                    <td>
                                        <?= htmlspecialchars($marchandiseObj->getClient()->getNom()) ?>
                                    </td>
                                    <td>
                                        <?= htmlspecialchars($transitObj->getVilleDepart()->getNom()) ?>
                                        ➜
                                        <?= htmlspecialchars($transitObj->getVilleArrivee()->getNom()) ?>
                                    </td>
                                    <td>
                                        <span
                                            class="badge badge-blue"><?= $transitObj->getModeTransport()->getType() ?></span>
                                    </td>
                                    <td>
                                        <span
                                            class="badge <?= $transitObj->getStatutClass() ?>"><?= $transitObj->getStatut() ?></span>
                                    </td>
                                    <td>
                                        <?= $factureObj ? htmlspecialchars($factureObj->getNumero()) : '<em>Aucune</em>' ?>
                                    </td>
                                    <td>
                                        <strong>
                                            <?= $factureObj ? number_format($factureObj->getMontantTtc(), 0, ',', ' ') . ' GNF' : '-' ?>
                                        </strong>
                                    </td>
                                    <td>
                                        <?php if ($factureObj): ?>
                                            <span class="badge badge-cyan">Historisée & Gelée</span>
                                        <?php else: ?>
                                            <span class="badge badge-slate">En attente</span>
                                        <?php endif; ?>
                                    </td>
                                    <td style="text-align: center;">
                                        <button class="btn-action"
                                            style="background: rgb(var(--color-brand-cyan), 0.1); border: 1px solid rgb(var(--color-brand-cyan)); color: rgb(var(--color-brand-cyan)); padding: 6px 12px; border-radius: 6px; cursor: pointer; display: inline-flex; align-items: center; gap: 4px; font-size: 0.85rem; font-weight: 500;"
                                            onclick="openDetailsModal(<?= htmlspecialchars(json_encode([
                                                'id' => $transitObj->getId(),
                                                'designation' => $marchandiseObj->getDesignation(),
                                                'poids' => $marchandiseObj->getPoids(),
                                                'surface' => $marchandiseObj->getSurface(),
                                                'etat' => $marchandiseObj->getEtat(),
                                                'client_id' => $marchandiseObj->getClient()->getId(),
                                                'client_nom' => $marchandiseObj->getClient()->getNom(),
                                                'client_email' => $marchandiseObj->getClient()->getEmail(),
                                                'ville_depart_id' => $transitObj->getVilleDepart()->getId(),
                                                'ville_depart_nom' => $transitObj->getVilleDepart()->getNom(),
                                                'ville_depart_pays' => $transitObj->getVilleDepart()->getPays()->getNom(),
                                                'ville_arrivee_id' => $transitObj->getVilleArrivee()->getId(),
                                                'ville_arrivee_nom' => $transitObj->getVilleArrivee()->getNom(),
                                                'ville_arrivee_pays' => $transitObj->getVilleArrivee()->getPays()->getNom(),
                                                'mode_transport_id' => $transitObj->getModeTransport()->getId(),
                                                'mode_transport_nom' => $transitObj->getModeTransport()->getNom(),
                                                'mode_transport_type' => $transitObj->getModeTransport()->getType(),
                                                'mode_transport_tarif' => $transitObj->getModeTransport()->getTarifUnitaire(),
                                                'date_depart' => $transitObj->getDateDepart()->format('Y-m-d\TH:i'),
                                                'date_arrivee' => $transitObj->getDateArrivee()->format('Y-m-d\TH:i'),
                                                'date_depart_fr' => $transitObj->getDateDepart()->format('d/m/Y H:i'),
                                                'date_arrivee_fr' => $transitObj->getDateArrivee()->format('d/m/Y H:i'),
                                                'facture_num' => $factureObj ? $factureObj->getNumero() : null,
                                                'facture_brut' => $factureObj ? $factureObj->getMontantBrut() : 0,
                                                'facture_ttc' => $factureObj ? $factureObj->getMontantTtc() : 0,
                                                'statut' => $transitObj->getStatut(),
                                                'statut_class' => $transitObj->getStatutClass(),
                                            ])) ?>)">
                                            Gérer
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </section>

        </main>

    </div>

    <!-- JS AOS & Swiper JS CDNs -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

    <script>
        // Initialisation AOS (Animate on Scroll)
        AOS.init({
            duration: 600,
            easing: 'ease-out-cubic',
            once: true,
            offset: 50,
            delay: 50
        });

        // Initialisation Swiper pour Mobile
        const dashboardSwiper = new Swiper('.dashboard-swiper', {
            slidesPerView: 'auto',
            spaceBetween: 16,
            grabCursor: true,
            centeredSlides: false,
            freeMode: {
                enabled: true,
                sticky: true,
                momentumRatio: 0.8
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
                dynamicBullets: true
            },
            breakpoints: {
                768: {
                    enabled: false,
                    spaceBetween: 0
                }
            }
        });
    </script>

    <script>
        /* =========================================================
           Horloge en direct : mise à jour toutes les secondes
           ========================================================= */
        function updateClock() {
            const now = new Date();
            const h = String(now.getHours()).padStart(2, '0');
            const m = String(now.getMinutes()).padStart(2, '0');
            const s = String(now.getSeconds()).padStart(2, '0');
            document.getElementById('live-clock').textContent = `${h}:${m}:${s}`;
        }
        updateClock();                       // Affichage immédiat au chargement
        setInterval(updateClock, 1000);      // Mise à jour chaque seconde
    </script>

    <style>
        /* Structure Split Layout pour la modale Nouveau Transit */
        .split-modal-box {
            max-width: 1050px !important;
            width: 95% !important;
            max-height: 92vh !important;
            display: flex;
            flex-direction: column;
        }

        .split-modal-body {
            display: flex;
            flex-direction: row;
            flex: 1;
            overflow: hidden;
            /* Empêcher le débordement global */
        }

        .split-form-col {
            flex: 1 1 55%;
            padding: 1.5rem;
            overflow-y: auto;
            position: relative;
            z-index: 2;
        }

        .split-map-col {
            flex: 1 1 45%;
            display: flex;
            flex-direction: column;
            background: #f1f5f9;
            border-left: 1px solid var(--color-border-light);
            position: relative;
            z-index: 1;
        }

        @media (max-width: 768px) {
            .split-modal-body {
                flex-direction: column;
                overflow-y: auto;
            }

            .split-form-col {
                overflow-y: visible;
            }

            .split-map-col {
                min-height: 350px;
                border-left: none;
                border-top: 1px solid var(--color-border-light);
            }
        }

        /* Curseur personnalisé "Pin de localisation" pour la carte */
        .leaflet-container,
        .leaflet-grab {
            cursor: url("data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2228%22%20height%3D%2228%22%20viewBox%3D%220%200%2024%2024%22%3E%3Cpath%20fill%3D%22%23e03434%22%20stroke%3D%22white%22%20stroke-width%3D%221.5%22%20d%3D%22M12%202C8.13%202%205%205.13%205%209c0%205.25%207%2013%207%2013s7-7.75%207-13c0-3.87-3.13-7-7-7zm0%209.5c-1.38%200-2.5-1.12-2.5-2.5s1.12-2.5%202.5-2.5%202.5%201.12%202.5%202.5-1.12%202.5-2.5%202.5z%22%2F%3E%3C%2Fsvg%3E") 14 28, pointer !important;
        }

        .leaflet-dragging .leaflet-grab {
            cursor: grabbing !important;
        }

        .leaflet-interactive {
            cursor: pointer !important;
        }
    </style>

    <!-- =========================================================================
   Modale : Formulaire d'ajout d'un Nouveau Transit (avec carte Leaflet)
   ========================================================================= -->
    <div id="modal-transit" class="modal-overlay">
        <div class="modal-box split-modal-box">

            <!-- En-tête de la modale (Global) -->
            <div class="modal-header">
                <h2 class="modal-title">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5"
                        viewBox="0 0 24 24">
                        <path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        <path
                            d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 011-1h1m0 0a1 1 0 011 1v1m-3 0h3">
                        </path>
                    </svg>
                    Nouveau Transit
                </h2>
                <button type="button" class="modal-close" onclick="closeNewTransitModal()">&#215;</button>
            </div>

            <div class="split-modal-body">
                <!-- Colonne Gauche : Formulaire -->
                <form method="POST" action="?" class="split-form-col">
                    <input type="hidden" name="action" value="nouveau_transit">
                    <input type="hidden" name="distance" id="distance_hidden" value="0">

                    <!-- Section Marchandise -->
                    <div class="form-section-title">Marchandise</div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="designation">Désignation</label>
                            <input type="text" id="designation" name="designation" required
                                placeholder="ex: Équipement médical">
                        </div>
                        <div class="form-group">
                            <label for="etat">État</label>
                            <select id="etat" name="etat" required>
                                <option value="Neuf">Neuf</option>
                                <option value="Usagé">Usagé</option>
                                <option value="Périssable">Périssable</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="poids">Poids (kg)</label>
                            <input type="number" id="poids" name="poids" step="0.1" min="0" required
                                placeholder="ex: 1200">
                        </div>
                        <div class="form-group">
                            <label for="surface">Surface (m²)</label>
                            <input type="number" id="surface" name="surface" step="0.1" min="0" required
                                placeholder="ex: 15.5">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="client_nom">Nom du Client *</label>
                            <input type="text" id="client_nom" name="client_nom" required
                                placeholder="ex: KPC Logistics">
                        </div>
                        <div class="form-group">
                            <label for="client_email">Email du Client *</label>
                            <input type="email" id="client_email" name="client_email" required
                                placeholder="ex: contact@kpc.com">
                        </div>
                    </div>

                    <!-- Section Itinéraire -->
                    <div class="form-section-title" style="margin-top: 1.25rem;">Itinéraire & Transport</div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="ville_depart_id">Ville de départ</label>
                            <select id="ville_depart_id" name="ville_depart_id" required>
                                <option value="">-- Départ --</option>
                                <?php foreach ($listeVilles as $v): ?>
                                    <option value="<?= $v['id'] ?>" data-lat="<?= $v['latitude'] ?? '' ?>"
                                        data-lng="<?= $v['longitude'] ?? '' ?>"><?= htmlspecialchars($v['nom']) ?>
                                        (<?= htmlspecialchars($v['pays']) ?>)</option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="ville_arrivee_id">Ville d'arrivée</label>
                            <select id="ville_arrivee_id" name="ville_arrivee_id" required>
                                <option value="">-- Arrivée --</option>
                                <?php foreach ($listeVilles as $v): ?>
                                    <option value="<?= $v['id'] ?>" data-lat="<?= $v['latitude'] ?? '' ?>"
                                        data-lng="<?= $v['longitude'] ?? '' ?>"><?= htmlspecialchars($v['nom']) ?>
                                        (<?= htmlspecialchars($v['pays']) ?>)</option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="mode_transport_id">Mode de transport</label>
                        <select id="mode_transport_id" name="mode_transport_id" required>
                            <option value="">-- Sélectionner --</option>
                            <?php foreach ($listeModesTransport as $mt): ?>
                                <option value="<?= $mt['id'] ?>"><?= htmlspecialchars($mt['nom']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="date_depart">Date de départ</label>
                            <input type="datetime-local" id="date_depart" name="date_depart" required>
                        </div>
                        <div class="form-group">
                            <label for="date_arrivee">Date d'arrivée</label>
                            <input type="datetime-local" id="date_arrivee" name="date_arrivee" required>
                        </div>
                    </div>

                    <!-- Pied de la modale -->
                    <div class="modal-footer">
                        <button type="button" class="btn-cancel" onclick="closeNewTransitModal()">Annuler</button>
                        <button type="submit" class="btn-submit">
                            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5"
                                viewBox="0 0 24 24">
                                <polyline points="20 6 9 17 4 12"></polyline>
                            </svg>
                            Enregistrer & Facturer
                        </button>
                    </div>
                </form>

                <!-- Colonne Droite : Carte Leaflet -->
                <div class="split-map-col">
                    <!-- Badge distance flottant -->
                    <div id="distance-badge"
                        style="display:none; position:absolute; bottom:70px; left:50%; transform:translateX(-50%); z-index:1000; background: rgba(4,88,224,0.92); backdrop-filter:blur(8px); color:white; padding:0.5rem 1.2rem; border-radius:30px; font-weight:700; font-size:0.95rem; box-shadow:0 4px 20px rgba(4,88,224,0.4); white-space:nowrap; pointer-events: none;">
                        📍 <span id="distance-label">Calculer...</span>
                    </div>
                    <!-- Carte -->
                    <div id="transit-map" style="flex:1; min-height: 380px; border-radius: 0;"></div>
                    <!-- Légende -->
                    <div
                        style="padding: 0.75rem 1rem; background: white; border-top: 1px solid var(--color-border-light); display:flex; align-items:center; gap: 1rem; font-size: 0.8rem; color: var(--color-text-muted);">
                        <span style="display:flex;align-items:center;gap:5px;"><span
                                style="width:12px;height:12px;background:rgb(4,88,224);border-radius:50%;display:inline-block;"></span>
                            Départ</span>
                        <span style="display:flex;align-items:center;gap:5px;"><span
                                style="width:12px;height:12px;background:#e03434;border-radius:50%;display:inline-block;"></span>
                            Arrivée</span>
                        <span style="display:flex;align-items:center;gap:5px;"><span
                                style="width:30px;height:3px;background:rgb(4,88,224);display:inline-block;"></span>
                            Trajet</span>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- =========================================================================
   Modale de Détails, Modification & Suppression (Gérer)
   ========================================================================= -->
    <div id="modal-transit-details" class="modal-overlay">
        <div class="modal-box" style="max-width: 700px;">

            <!-- En-tête de la modale -->
            <div class="modal-header">
                <h2 class="modal-title">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5"
                        viewBox="0 0 24 24">
                        <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                        </path>
                    </svg>
                    Gestion du Fret <span id="det-title-id"
                        style="color: rgb(var(--color-brand-cyan)); font-weight: 700;"></span>
                </h2>
                <button class="modal-close" onclick="closeDetailsModal()">&times;</button>
            </div>

            <!-- Mode Lecture seule (Détails) -->
            <div id="details-view-mode" style="padding: 1.5rem;">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 25px;">
                    <!-- Bloc Marchandise -->
                    <div
                        style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08); padding: 15px; border-radius: 10px;">
                        <h3
                            style="color: rgb(var(--color-brand-cyan)); font-size: 1rem; border-bottom: 1px dashed rgba(255,255,255,0.1); padding-bottom: 5px; margin-bottom: 10px; display: flex; align-items: center; gap: 8px;">
                            📦 Marchandise
                        </h3>
                        <p style="margin: 6px 0;"><strong>Désignation :</strong> <span id="det-designation"></span></p>
                        <p style="margin: 6px 0;"><strong>État :</strong> <span id="det-etat" class="badge"></span></p>
                        <p style="margin: 6px 0;"><strong>Poids :</strong> <span id="det-poids"></span> kg</p>
                        <p style="margin: 6px 0;"><strong>Surface :</strong> <span id="det-surface"></span> m²</p>
                        <p style="margin: 6px 0;"><strong>Propriétaire :</strong> <span id="det-client-nom"></span></p>
                        <p style="margin: 6px 0; font-size: 0.85rem; color: var(--color-text-muted);"><span
                                id="det-client-email"></span></p>
                    </div>

                    <!-- Bloc Itinéraire & Dates -->
                    <div
                        style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08); padding: 15px; border-radius: 10px;">
                        <h3
                            style="color: rgb(var(--color-brand-blue-royal)); font-size: 1rem; border-bottom: 1px dashed rgba(255,255,255,0.1); padding-bottom: 5px; margin-bottom: 10px; display: flex; align-items: center; gap: 8px;">
                            📍 Logistique & Routage
                        </h3>
                        <p style="margin: 6px 0;"><strong>Départ :</strong> <span id="det-depart"></span></p>
                        <p style="margin: 6px 0;"><strong>Arrivée :</strong> <span id="det-arrivee"></span></p>
                        <p style="margin: 6px 0;"><strong>Date Départ :</strong> <span id="det-date-depart"></span></p>
                        <p style="margin: 6px 0;"><strong>Date Arrivée :</strong> <span id="det-date-arrivee"></span>
                        </p>
                        <p style="margin: 6px 0;"><strong>Transport :</strong> <span id="det-transport"></span></p>
                        <p style="margin: 6px 0; font-size: 0.85rem; color: var(--color-text-muted);">Tarif : <span
                                id="det-transport-tarif"></span></p>
                        <p style="margin: 6px 0;"><strong>Statut Transit :</strong> <span id="det-statut"
                                class="badge"></span></p>
                    </div>
                </div>

                <!-- Bloc Comptabilité (Facture) -->
                <div
                    style="background: rgba(var(--color-brand-cyan), 0.05); border: 1px solid rgb(var(--color-brand-cyan), 0.2); padding: 15px; border-radius: 10px; margin-bottom: 25px;">
                    <h3
                        style="color: rgb(var(--color-brand-cyan)); font-size: 1rem; display: flex; align-items: center; gap: 8px; margin-bottom: 10px;">
                        Facturation Légale (Gelée)
                    </h3>
                    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 15px;">
                        <div>
                            <small style="color: var(--color-text-muted); display: block;">N° Facture</small>
                            <strong id="det-facture-num"
                                style="font-size: 1.1rem; color: rgb(var(--color-brand-cyan));">-</strong>
                        </div>
                        <div>
                            <small style="color: var(--color-text-muted); display: block;">Montant HT (brut)</small>
                            <strong id="det-facture-brut">-</strong>
                        </div>
                        <div>
                            <small style="color: var(--color-text-muted); display: block;">Total TTC (TVA 20%)</small>
                            <strong id="det-facture-ttc" style="font-size: 1.1rem; color: #fff;">-</strong>
                        </div>
                    </div>
                </div>

                <!-- Pied de la modale (Actions) -->
                <div class="modal-footer"
                    style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid rgba(255,255,255,0.08); padding-top: 15px;">
                    <!-- Bouton Danger à gauche -->
                    <button type="button" class="btn-cancel"
                        style="background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.3); color: rgb(239, 68, 68); font-weight: 600; padding: 12px 24px; border-radius: 8px; font-size: 0.95rem; display: inline-flex; align-items: center; gap: 8px; cursor: pointer; transition: all 0.2s;"
                        onclick="triggerDelete()">
                        🗑️ Supprimer le Fret
                    </button>

                    <!-- Boutons à droite -->
                    <div style="display: flex; gap: 10px;">
                        <button type="button" class="btn-cancel"
                            style="padding: 12px 24px; border-radius: 8px; font-size: 0.95rem; display: inline-flex; align-items: center; gap: 8px; cursor: pointer; transition: all 0.2s;"
                            onclick="closeDetailsModal()">Fermer</button>
                        <button type="button" class="btn-submit"
                            style="background: rgb(var(--color-brand-cyan)); border-color: rgb(var(--color-brand-cyan)); padding: 12px 24px; border-radius: 8px; font-size: 0.95rem; display: inline-flex; align-items: center; gap: 8px; cursor: pointer; transition: all 0.2s;"
                            onclick="downloadAdminFacture(event)">
                            📥 Télécharger PDF
                        </button>
                        <button type="button" class="btn-submit"
                            style="padding: 12px 24px; border-radius: 8px; font-size: 0.95rem; display: inline-flex; align-items: center; gap: 8px; cursor: pointer; transition: all 0.2s;"
                            onclick="enableEditMode()">
                            ✏️ Modifier le Transit
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mode Modification (Formulaire interactif) -->
            <div id="details-edit-mode" style="display: none;">
                <form method="POST" action="?" class="modal-form">
                    <input type="hidden" name="action" value="modifier_transit">
                    <input type="hidden" id="edit-transit-id" name="transit_id">

                    <!-- Section Marchandise -->
                    <div class="form-section-title">Marchandise</div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="edit-designation">Désignation</label>
                            <input type="text" id="edit-designation" name="designation" required>
                        </div>
                        <div class="form-group">
                            <label for="edit-etat">État</label>
                            <select id="edit-etat" name="etat" required>
                                <option value="Neuf">Neuf</option>
                                <option value="Usagé">Usagé</option>
                                <option value="Périssable">Périssable</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="edit-poids">Poids (kg)</label>
                            <input type="number" id="edit-poids" name="poids" step="0.1" min="0" required>
                        </div>
                        <div class="form-group">
                            <label for="edit-surface">Surface (m²)</label>
                            <input type="number" id="edit-surface" name="surface" step="0.1" min="0" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="edit-client-nom">Nom du Client *</label>
                            <input type="text" id="edit-client-nom" name="client_nom" required>
                        </div>
                        <div class="form-group">
                            <label for="edit-client-email">Email du Client *</label>
                            <input type="email" id="edit-client-email" name="client_email" required>
                        </div>
                    </div>

                    <!-- Section Transit -->
                    <div class="form-section-title" style="margin-top: 1.25rem;">Itinéraire & Transport</div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="edit-ville-depart-id">Ville de départ</label>
                            <select id="edit-ville-depart-id" name="ville_depart_id" required>
                                <?php foreach ($listeVilles as $v): ?>
                                    <option value="<?= $v['id'] ?>"><?= htmlspecialchars($v['nom']) ?>
                                        (<?= htmlspecialchars($v['pays']) ?>)</option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit-ville-arrivee-id">Ville d'arrivée</label>
                            <select id="edit-ville-arrivee-id" name="ville_arrivee_id" required>
                                <?php foreach ($listeVilles as $v): ?>
                                    <option value="<?= $v['id'] ?>"><?= htmlspecialchars($v['nom']) ?>
                                        (<?= htmlspecialchars($v['pays']) ?>)</option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit-mode-transport-id">Mode de transport</label>
                        <select id="edit-mode-transport-id" name="mode_transport_id" required>
                            <?php foreach ($listeModesTransport as $mt): ?>
                                <option value="<?= $mt['id'] ?>"><?= htmlspecialchars($mt['nom']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="edit-date-depart">Date de départ</label>
                            <input type="datetime-local" id="edit-date-depart" name="date_depart" required>
                        </div>
                        <div class="form-group">
                            <label for="edit-date-arrivee">Date d'arrivée</label>
                            <input type="datetime-local" id="edit-date-arrivee" name="date_arrivee" required>
                        </div>
                    </div>

                    <!-- Pied de la modale -->
                    <div class="modal-footer">
                        <button type="button" class="btn-cancel" onclick="disableEditMode()">Retour aux Détails</button>
                        <button type="submit" class="btn-submit">
                            💾 Sauvegarder les modifications
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <script>
        let activeTransitData = null;

        function openDetailsModal(data) {
            activeTransitData = data;

            // Remplir les champs lecture seule
            document.getElementById('det-title-id').textContent = '#TR-' + String(data.id).padStart(4, '0');
            document.getElementById('det-designation').textContent = data.designation;

            const etatBadge = document.getElementById('det-etat');
            etatBadge.textContent = data.etat;
            etatBadge.className = 'badge';
            if (data.etat === 'Neuf') etatBadge.classList.add('badge-blue');
            else if (data.etat === 'Usagé') etatBadge.classList.add('badge-slate');
            else etatBadge.classList.add('badge-cyan');

            document.getElementById('det-poids').textContent = parseFloat(data.poids).toLocaleString('fr-FR');
            document.getElementById('det-surface').textContent = parseFloat(data.surface).toLocaleString('fr-FR');
            document.getElementById('det-client-nom').textContent = data.client_nom;
            document.getElementById('det-client-email').textContent = data.client_email;

            document.getElementById('det-depart').textContent = data.ville_depart_nom + ' (' + data.ville_depart_pays + ')';
            document.getElementById('det-arrivee').textContent = data.ville_arrivee_nom + ' (' + data.ville_arrivee_pays + ')';
            document.getElementById('det-date-depart').textContent = data.date_depart_fr;
            document.getElementById('det-date-arrivee').textContent = data.date_arrivee_fr;

            document.getElementById('det-transport').textContent = data.mode_transport_nom + ' (' + data.mode_transport_type + ')';
            document.getElementById('det-transport-tarif').textContent = parseInt(data.mode_transport_tarif).toLocaleString('fr-FR') + ' GNF';

            const statutBadge = document.getElementById('det-statut');
            statutBadge.textContent = data.statut;
            statutBadge.className = 'badge ' + data.statut_class;

            if (data.facture_num) {
                document.getElementById('det-facture-num').textContent = data.facture_num;
                document.getElementById('det-facture-brut').textContent = parseInt(data.facture_brut).toLocaleString('fr-FR') + ' GNF';
                document.getElementById('det-facture-ttc').textContent = parseInt(data.facture_ttc).toLocaleString('fr-FR') + ' GNF';
            } else {
                document.getElementById('det-facture-num').textContent = 'En attente';
                document.getElementById('det-facture-brut').textContent = '-';
                document.getElementById('det-facture-ttc').textContent = '-';
            }

            // Remplir les champs du formulaire d'édition
            document.getElementById('edit-transit-id').value = data.id;
            document.getElementById('edit-designation').value = data.designation;
            document.getElementById('edit-etat').value = data.etat;
            document.getElementById('edit-poids').value = data.poids;
            document.getElementById('edit-surface').value = data.surface;
            document.getElementById('edit-client-nom').value = data.client_nom;
            document.getElementById('edit-client-email').value = data.client_email;
            document.getElementById('edit-ville-depart-id').value = data.ville_depart_id;
            document.getElementById('edit-ville-arrivee-id').value = data.ville_arrivee_id;
            document.getElementById('edit-mode-transport-id').value = data.mode_transport_id;
            document.getElementById('edit-date-depart').value = data.date_depart;
            document.getElementById('edit-date-arrivee').value = data.date_arrivee;

            // Ouvrir la modale
            disableEditMode(); // S'assurer que le mode lecture seule est affiché en premier
            document.getElementById('modal-transit-details').classList.add('is-open');
        }

        function closeDetailsModal() {
            document.getElementById('modal-transit-details').classList.remove('is-open');
        }

        function enableEditMode() {
            document.getElementById('details-view-mode').style.display = 'none';
            document.getElementById('details-edit-mode').style.display = 'block';
        }

        function disableEditMode() {
            document.getElementById('details-view-mode').style.display = 'block';
            document.getElementById('details-edit-mode').style.display = 'none';
        }

        function triggerDelete() {
            if (activeTransitData && confirm("⚠️ Êtes-vous sûr de vouloir supprimer définitivement ce transit #" + String(activeTransitData.id).padStart(4, '0') + " et sa facture de la base de données ? Cette action est irréversible !")) {
                window.location.href = "index.php?action=supprimer_transit&id=" + activeTransitData.id;
            }
        }

        // --- NOUVEAU : Fonction de téléchargement de facture (Admin) ---
        window.downloadAdminFacture = function(e) {
            if(e) e.preventDefault();
            
            if (typeof html2pdf === 'undefined') {
                alert("La bibliothèque PDF n'est pas encore chargée. Réessayez dans un instant.");
                return;
            }

            if (!activeTransitData || !activeTransitData.facture_num) {
                alert("Impossible de générer une facture : aucune donnée de facturation associée.");
                return;
            }

            try {
                // Récupérer les éléments du template PDF
                document.getElementById('pdf-invoice-num').textContent = activeTransitData.facture_num;
                document.getElementById('pdf-invoice-date').textContent = 'Émise le : ' + activeTransitData.facture_date_fr;
                document.getElementById('pdf-client-name').textContent = activeTransitData.client_nom;
                document.getElementById('pdf-client-email').textContent = activeTransitData.client_email;
                document.getElementById('pdf-route').textContent = activeTransitData.ville_depart_nom + ' (' + activeTransitData.ville_depart_pays + ') ➜ ' + activeTransitData.ville_arrivee_nom + ' (' + activeTransitData.ville_arrivee_pays + ')';
                document.getElementById('pdf-transport').textContent = activeTransitData.mode_transport_nom + ' (' + activeTransitData.mode_transport_type + ')';
                document.getElementById('pdf-item-title').textContent = activeTransitData.designation;
                
                document.getElementById('pdf-row-item').textContent = activeTransitData.designation;
                document.getElementById('pdf-row-qty').textContent = parseFloat(activeTransitData.poids).toLocaleString('fr-FR') + ' kg / ' + parseFloat(activeTransitData.surface).toLocaleString('fr-FR') + ' m²';
                document.getElementById('pdf-row-price').textContent = parseInt(activeTransitData.mode_transport_tarif).toLocaleString('fr-FR') + ' GNF';
                document.getElementById('pdf-row-total').textContent = parseInt(activeTransitData.facture_brut).toLocaleString('fr-FR') + ' GNF';

                document.getElementById('pdf-summary-brut').textContent = parseInt(activeTransitData.facture_brut).toLocaleString('fr-FR') + ' GNF';
                
                // Calcul de la TVA (20%)
                const ht = parseInt(activeTransitData.facture_brut);
                const tva = Math.round(ht * 0.2);
                document.getElementById('pdf-summary-tva').textContent = tva.toLocaleString('fr-FR') + ' GNF';
                document.getElementById('pdf-summary-ttc').textContent = parseInt(activeTransitData.facture_ttc).toLocaleString('fr-FR') + ' GNF';

                // Afficher le template de manière isolée pour la capture
                const element = document.getElementById('invoice-pdf-template');
                element.style.opacity = '1';
                element.style.left = '0';
                element.style.top = '0';
                element.style.position = 'fixed';
                element.style.zIndex = '99999';

                const opt = {
                    margin:       0,
                    filename:     'Facture_' + activeTransitData.facture_num + '_TransitPro.pdf',
                    image:        { type: 'jpeg', quality: 0.98 },
                    html2canvas:  { 
                        scale: 2, 
                        useCORS: true, 
                        letterRendering: true, 
                        scrollY: 0, 
                        scrollX: 0,
                        backgroundColor: '#ffffff'
                    },
                    jsPDF:        { unit: 'mm', format: 'a4', orientation: 'portrait' }
                };

                setTimeout(() => {
                    html2pdf().set(opt).from(element).save().then(() => {
                        element.style.opacity = '0';
                        element.style.left = '-9999px';
                        element.style.position = 'absolute';
                    });
                }, 500);
            } catch (err) {
                console.error(err);
                alert("Erreur lors de la génération du PDF.");
            }
        };
    </script>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        /* =========================================================
           Carte Leaflet – Calcul de distance entre deux villes
           ========================================================= */
        let transitMap = null;
        let routeLine = null;
        let allCityMarkers = [];

        const iconDepart = L.divIcon({
            html: '<div style="width:16px;height:16px;border-radius:50%;background:rgb(4,88,224);border:3px solid white;box-shadow:0 2px 8px rgba(4,88,224,0.7);"></div>',
            className: '', iconAnchor: [8, 8]
        });
        const iconArrivee = L.divIcon({
            html: '<div style="width:16px;height:16px;border-radius:50%;background:#e03434;border:3px solid white;box-shadow:0 2px 8px rgba(224,52,52,0.7);"></div>',
            className: '', iconAnchor: [8, 8]
        });
        const iconDefault = L.divIcon({
            html: '<div style="width:12px;height:12px;border-radius:50%;background:#94a3b8;border:2px solid white;box-shadow:0 2px 5px rgba(0,0,0,0.3); cursor:pointer; transition: transform 0.2s;"></div>',
            className: '', iconAnchor: [6, 6]
        });

        function haversineKm(lat1, lng1, lat2, lng2) {
            const R = 6371;
            const dLat = (lat2 - lat1) * Math.PI / 180;
            const dLng = (lng2 - lng1) * Math.PI / 180;
            const a = Math.sin(dLat / 2) ** 2 + Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) * Math.sin(dLng / 2) ** 2;
            return Math.round(R * 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a)));
        }

        function initTransitMap() {
            if (transitMap) return;
            transitMap = L.map('transit-map', { zoomControl: true, attributionControl: false })
                .setView([15, 0], 3);
            L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
                maxZoom: 18
            }).addTo(transitMap);

            // Liste de toutes les villes disponibles depuis PHP
            const villes = <?= json_encode($listeVilles) ?>;

            villes.forEach(v => {
                if (v.latitude && v.longitude) {
                    const marker = L.marker([v.latitude, v.longitude], { icon: iconDefault }).addTo(transitMap);
                    marker.bindTooltip(v.nom + ' (' + v.pays + ')', { direction: 'top', offset: [0, -6] });

                    // Interaction directe sur le marqueur
                    marker.on('click', function (e) {
                        L.DomEvent.stopPropagation(e); // Empêche le clic global de la carte de se déclencher
                        selectCity(v.id);
                    });

                    allCityMarkers.push({ id: v.id, marker: marker });
                }
            });

            // Clic global sur la carte pour sélectionner n'importe où sur le globe
            transitMap.on('click', function (e) {
                const lat = e.latlng.lat;
                const lng = e.latlng.lng;

                // Appel à l'API Nominatim (OpenStreetMap) pour le reverse geocoding
                fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=10`)
                    .then(response => response.json())
                    .then(data => {
                        if (data && data.address) {
                            const ville = data.address.city || data.address.town || data.address.village || data.address.state || "Inconnu";
                            const pays = data.address.country || "Inconnu";

                            // Chercher si la ville existe déjà dans nos options
                            let exists = false;
                            let existingId = null;
                            const selD = document.getElementById('ville_depart_id');

                            Array.from(selD.options).forEach(opt => {
                                if (opt.text.includes(ville) && opt.text.includes(pays)) {
                                    exists = true;
                                    existingId = opt.value;
                                }
                            });

                            if (exists) {
                                selectCity(existingId);
                            } else {
                                // Créer une nouvelle ville dynamique pour le backend
                                const newVal = `NEW|${ville}|${pays}|${lat}|${lng}`;
                                const newText = `${ville} (${pays})`;

                                // Ajouter l'option aux deux select
                                const optD = new Option(newText, newVal);
                                optD.dataset.lat = lat;
                                optD.dataset.lng = lng;
                                document.getElementById('ville_depart_id').add(optD);

                                const optA = new Option(newText, newVal);
                                optA.dataset.lat = lat;
                                optA.dataset.lng = lng;
                                document.getElementById('ville_arrivee_id').add(optA);

                                // Créer un marqueur visuel pour cette nouvelle ville
                                const newMarker = L.marker([lat, lng], { icon: iconDefault }).addTo(transitMap);
                                newMarker.bindTooltip(newText, { direction: 'top', offset: [0, -6] });
                                newMarker.on('click', function (ev) {
                                    L.DomEvent.stopPropagation(ev);
                                    selectCity(newVal);
                                });

                                allCityMarkers.push({ id: newVal, marker: newMarker });

                                // Sélectionner cette nouvelle ville
                                selectCity(newVal);
                            }
                        }
                    })
                    .catch(err => console.error("Erreur géocodage:", err));
            });

            setTimeout(() => transitMap.invalidateSize(), 200);
        }

        // Fonction commune de sélection
        function selectCity(cityId) {
            const selD = document.getElementById('ville_depart_id');
            const selA = document.getElementById('ville_arrivee_id');

            if (!selD.value) {
                selD.value = cityId;
            } else if (selD.value && !selA.value && selD.value != cityId) {
                selA.value = cityId;
            } else {
                // Reset si les deux sont remplis ou même sélection
                selD.value = cityId;
                selA.value = '';
            }
            updateMap();
        }

        function updateMap() {
            const selD = document.getElementById('ville_depart_id');
            const selA = document.getElementById('ville_arrivee_id');
            if (!selD || !selA) return;

            const valD = selD.value;
            const valA = selA.value;

            // Réinitialiser tous les marqueurs
            allCityMarkers.forEach(cm => {
                cm.marker.setIcon(iconDefault);
                if (cm.marker.getPopup()) cm.marker.unbindPopup();
                cm.marker.setZIndexOffset(0);
            });

            let latD = null, lngD = null, latA = null, lngA = null;

            // Marqueur Départ
            if (valD) {
                const cm = allCityMarkers.find(c => c.id == valD);
                if (cm) {
                    cm.marker.setIcon(iconDepart);
                    cm.marker.bindPopup('<b>Départ :</b> ' + selD.options[selD.selectedIndex].text).openPopup();
                    cm.marker.setZIndexOffset(1000);
                    latD = cm.marker.getLatLng().lat;
                    lngD = cm.marker.getLatLng().lng;
                }
            }

            // Marqueur Arrivée
            if (valA) {
                const cm = allCityMarkers.find(c => c.id == valA);
                if (cm) {
                    cm.marker.setIcon(iconArrivee);
                    cm.marker.bindPopup('<b>Arrivée :</b> ' + selA.options[selA.selectedIndex].text).openPopup();
                    cm.marker.setZIndexOffset(1000);
                    latA = cm.marker.getLatLng().lat;
                    lngA = cm.marker.getLatLng().lng;
                }
            }

            // Tracé + calcul de distance précis
            if (routeLine) transitMap.removeLayer(routeLine);

            if (latD !== null && lngD !== null && latA !== null && lngA !== null) {
                // Afficher temporairement le badge en mode calcul
                document.getElementById('distance-label').textContent = 'Calcul de l\'itinéraire...';
                document.getElementById('distance-badge').style.display = 'block';

                // Appel de l'API de routage OSRM pour obtenir la distance routière exacte
                fetch(`https://router.project-osrm.org/route/v1/driving/${lngD},${latD};${lngA},${latA}?overview=full&geometries=geojson`)
                    .then(response => response.json())
                    .then(data => {
                        if (data && data.routes && data.routes.length > 0) {
                            const route = data.routes[0];
                            const distanceMeters = route.distance;
                            const km = Math.round(distanceMeters / 1000);

                            // Enregistrer la distance routière réelle et précise
                            document.getElementById('distance_hidden').value = km;
                            document.getElementById('distance-label').textContent = km.toLocaleString('fr-FR') + ' km (Itinéraire routier)';
                            document.getElementById('distance-badge').style.display = 'block';

                            // Dessiner le tracé routier précis sur la carte
                            if (routeLine) transitMap.removeLayer(routeLine);
                            const coords = route.geometry.coordinates.map(coord => [coord[1], coord[0]]);

                            routeLine = L.polyline(coords, {
                                color: 'rgb(4,88,224)',
                                weight: 3.5,
                                opacity: 0.9,
                                lineJoin: 'round'
                            }).addTo(transitMap);

                            const bounds = L.latLngBounds(coords);
                            transitMap.fitBounds(bounds, { padding: [50, 50] });
                        } else {
                            throw new Error('Aucun itinéraire trouvé');
                        }
                    })
                    .catch(err => {
                        console.warn("Échec du routage précis OSRM, repli sur Haversine :", err);

                        // Calcul Haversine avec +15% de coefficient d'ajustement routier réaliste
                        const straightKm = haversineKm(latD, lngD, latA, lngA);
                        const estimatedRoadKm = Math.round(straightKm * 1.15);

                        document.getElementById('distance_hidden').value = estimatedRoadKm;
                        document.getElementById('distance-label').textContent = estimatedRoadKm.toLocaleString('fr-FR') + ' km (Estimé)';
                        document.getElementById('distance-badge').style.display = 'block';

                        if (routeLine) transitMap.removeLayer(routeLine);
                        routeLine = L.polyline([[latD, lngD], [latA, lngA]], {
                            color: 'rgb(4,88,224)', weight: 2.5, opacity: 0.85, dashArray: '8 5'
                        }).addTo(transitMap);

                        const bounds = L.latLngBounds([[latD, lngD], [latA, lngA]]);
                        transitMap.fitBounds(bounds, { padding: [50, 50] });
                    });
            } else {
                document.getElementById('distance_hidden').value = '0';
                document.getElementById('distance-badge').style.display = 'none';
            }
        }

        function openNewTransitModal() {
            document.getElementById('modal-transit').classList.add('is-open');
            setTimeout(() => {
                initTransitMap();
                transitMap.invalidateSize();
                updateMap(); // Mettre à jour au cas où les selects ont déjà des valeurs
            }, 150);
        }

        function closeNewTransitModal() {
            document.getElementById('modal-transit').classList.remove('is-open');
        }

        document.addEventListener('DOMContentLoaded', () => {
            const btnNouveau = document.getElementById('btn-nouveau-transit');
            if (btnNouveau) btnNouveau.addEventListener('click', openNewTransitModal);

            const selD = document.getElementById('ville_depart_id');
            const selA = document.getElementById('ville_arrivee_id');
            if (selD) selD.addEventListener('change', updateMap);
            if (se    <!-- =========================================================================
       Template Professionnel de Facture PDF (TransitPro Global)
       ========================================================================= -->
    <div id="invoice-pdf-template" style="position: absolute; left: -9999px; top: -9999px; opacity: 0; width: 210mm; height: 297mm; padding: 25mm; background: #fff; color: #1e293b; font-family: 'Inter', system-ui, sans-serif; box-sizing: border-box;">
        
        <!-- En-tête : Logo & Type de Document -->
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 60px;">
            <div>
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 8px;">
                    <svg viewBox="0 0 24 24" width="32" height="32" style="color: #0458e0;">
                        <path d="M4 15l8-8 8 8" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round"/>
                        <path d="M4 19l8-8 8 8" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" opacity="0.4"/>
                    </svg>
                    <h1 style="font-family: 'Outfit', sans-serif; font-size: 34px; font-weight: 800; color: #0458e0; margin: 0; letter-spacing: -1px;">TRANSIT<span style="color: #06b6d4;">PRO</span></h1>
                </div>
                <p style="margin: 0; font-size: 11px; text-transform: uppercase; letter-spacing: 2px; color: #64748b; font-weight: 700;">Expertise Logistique Mondiale</p>
                <p style="margin: 5px 0 0; font-size: 10px; color: #94a3b8; font-style: italic;">Née à l'Université de Labé, République de Guinée</p>
            </div>
            <div style="text-align: right;">
                <h2 style="font-size: 28px; font-weight: 900; text-transform: uppercase; margin: 0; color: #0f172a; letter-spacing: 1px;">Facture</h2>
                <div style="margin-top: 10px;">
                    <p style="margin: 0; font-size: 14px; font-weight: 700; color: #0458e0;" id="pdf-invoice-num">#FAC-0000</p>
                    <p style="margin: 2px 0; font-size: 11px; color: #64748b;" id="pdf-invoice-date">---</p>
                </div>
            </div>
        </div>

        <!-- Blocs d'informations Émetteur / Destinataire -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 60px; margin-bottom: 50px;">
            <div style="border-left: 3px solid #0458e0; padding-left: 20px;">
                <h3 style="font-size: 10px; text-transform: uppercase; letter-spacing: 1.5px; color: #94a3b8; margin-bottom: 15px; font-weight: 800;">Émis par</h3>
                <p style="margin: 0; font-weight: 800; font-size: 16px; color: #1e293b;">TransitPro Logistics SAS</p>
                <p style="margin: 4px 0; font-size: 12px; color: #64748b; line-height: 1.5;">
                    Quartier Pounthioun, Labé<br>
                    République de Guinée<br>
                    support@transitpro.gn
                </p>
            </div>
            <div style="border-left: 3px solid #e2e8f0; padding-left: 20px;">
                <h3 style="font-size: 10px; text-transform: uppercase; letter-spacing: 1.5px; color: #94a3b8; margin-bottom: 15px; font-weight: 800;">Facturé à</h3>
                <p style="margin: 0; font-weight: 800; font-size: 16px; color: #1e293b;" id="pdf-client-name">---</p>
                <p style="margin: 4px 0; font-size: 12px; color: #64748b; line-height: 1.5;" id="pdf-client-email">---</p>
                <p style="margin: 4px 0; font-size: 12px; color: #64748b;">République de Guinée</p>
            </div>
        </div>

        <!-- Détails Logistiques (Contexte) -->
        <div style="background: #f8fafc; border-radius: 12px; padding: 25px; margin-bottom: 40px; border: 1px solid #e2e8f0;">
            <h3 style="font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #0458e0; margin-bottom: 15px; font-weight: 800; border-bottom: 1px solid #cbd5e1; padding-bottom: 8px;">Détails de l'Expédition</h3>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div>
                    <p style="margin: 0; font-size: 10px; color: #94a3b8; text-transform: uppercase; font-weight: 700;">Itinéraire</p>
                    <p style="margin: 4px 0; font-size: 13px; font-weight: 700; color: #1e293b;" id="pdf-route">---</p>
                </div>
                <div>
                    <p style="margin: 0; font-size: 10px; color: #94a3b8; text-transform: uppercase; font-weight: 700;">Moyen de Transport</p>
                    <p style="margin: 4px 0; font-size: 13px; font-weight: 700; color: #1e293b;" id="pdf-transport">---</p>
                </div>
            </div>
        </div>

        <!-- Tableau des Postes -->
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 40px;">
            <thead>
                <tr style="border-bottom: 2px solid #0f172a;">
                    <th style="padding: 12px 10px; font-size: 11px; text-transform: uppercase; text-align: left; color: #64748b;">Description du Service</th>
                    <th style="padding: 12px 10px; font-size: 11px; text-transform: uppercase; text-align: center; color: #64748b;">Quantité / Spéc.</th>
                    <th style="padding: 12px 10px; font-size: 11px; text-transform: uppercase; text-align: right; color: #64748b;">Prix Unitaire</th>
                    <th style="padding: 12px 10px; font-size: 11px; text-transform: uppercase; text-align: right; color: #64748b;">Total HT</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="padding: 25px 10px; border-bottom: 1px solid #e2e8f0; vertical-align: top;">
                        <p style="margin: 0; font-weight: 800; font-size: 14px; color: #0f172a;" id="pdf-item-title">---</p>
                        <p style="margin: 6px 0 0; font-size: 11px; color: #64748b; line-height: 1.4;">Frais de transit international, manutention, et acheminement vers destination finale. Assurance logistique standard incluse.</p>
                    </td>
                    <td style="padding: 25px 10px; border-bottom: 1px solid #e2e8f0; text-align: center; font-size: 13px; font-weight: 600; color: #1e293b;" id="pdf-row-qty">---</td>
                    <td style="padding: 25px 10px; border-bottom: 1px solid #e2e8f0; text-align: right; font-size: 13px; font-weight: 600; color: #1e293b;" id="pdf-row-price">---</td>
                    <td style="padding: 25px 10px; border-bottom: 1px solid #e2e8f0; text-align: right; font-size: 14px; font-weight: 800; color: #0f172a;" id="pdf-row-total">---</td>
                </tr>
            </tbody>
        </table>

        <!-- Pied de Facture : Totaux -->
        <div style="display: flex; justify-content: flex-end;">
            <div style="width: 250px;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 10px; padding: 0 10px;">
                    <span style="font-size: 12px; color: #64748b; font-weight: 600;">Sous-total HT</span>
                    <span style="font-size: 13px; color: #1e293b; font-weight: 700;" id="pdf-summary-brut">---</span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 15px; padding: 0 10px;">
                    <span style="font-size: 12px; color: #64748b; font-weight: 600;">TVA (20%)</span>
                    <span style="font-size: 13px; color: #16a34a; font-weight: 700;" id="pdf-summary-tva">---</span>
                </div>
                <div style="background: #0458e0; border-radius: 8px; padding: 15px; display: flex; justify-content: space-between; align-items: center; color: #fff; box-shadow: 0 4px 12px rgba(4, 88, 224, 0.2);">
                    <span style="font-size: 11px; text-transform: uppercase; font-weight: 800; letter-spacing: 0.5px;">Net à Payer</span>
                    <span style="font-size: 20px; font-weight: 900;" id="pdf-summary-ttc">---</span>
                </div>
                <p style="margin-top: 12px; font-size: 9px; color: #94a3b8; text-align: right; font-style: italic;">Montants exprimés en Francs Guinéens (GNF)</p>
            </div>
        </div>

        <!-- Informations Bancaires & Signature -->
        <div style="margin-top: 80px; display: grid; grid-template-columns: 1.5fr 1fr; gap: 40px; align-items: end;">
            <div>
                <h4 style="font-size: 11px; text-transform: uppercase; color: #1e293b; margin-bottom: 10px; font-weight: 800;">Notes & Instructions</h4>
                <p style="margin: 0; font-size: 10px; color: #64748b; line-height: 1.6;">
                    Veuillez libeller votre chèque à l'ordre de **TransitPro Logistics**. <br>
                    Le paiement est exigible sous 30 jours à compter de la date d'émission. <br>
                    Pour tout virement, veuillez rappeler le numéro de facture en référence.
                </p>
            </div>
            <div style="text-align: center; border-top: 1px solid #e2e8f0; padding-top: 15px;">
                <p style="margin: 0 0 40px; font-size: 10px; color: #94a3b8; text-transform: uppercase; font-weight: 700; letter-spacing: 1px;">Cachet & Signature Électronique</p>
                <div style="font-family: 'Dancing Script', cursive; font-size: 22px; color: #0458e0; opacity: 0.8; transform: rotate(-3deg);">TransitPro Official</div>
            </div>
        </div>

        <!-- Bas de page (Mention légale) -->
        <div style="position: absolute; bottom: 25mm; left: 25mm; right: 25mm; border-top: 1px solid #f1f5f9; padding-top: 20px; display: flex; justify-content: space-between; align-items: center;">
            <p style="margin: 0; font-size: 9px; color: #cbd5e1; font-weight: 600; text-transform: uppercase; letter-spacing: 1px;">TransitPro Global Web Portal – v2.0</p>
            <p style="margin: 0; font-size: 10px; color: #cbd5e1;">Page 1 sur 1</p>
        </div>
    </div>
</body>
</html>