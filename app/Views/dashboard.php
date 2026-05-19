<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TransitFlow - Tableau de Bord</title>
    <!-- CSS AOS & Swiper JS CDN -->
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css">
    <!-- Notre Design System local (avec cache-buster) -->
    <link rel="stylesheet" href="public/css/style.css?v=2.9">
</head>
<body>

<div class="app-container">

    <!-- =========================================================================
       Sidebar Navigation & Brand Logo Space (Section 17.2)
       ========================================================================= -->
    <aside class="sidebar">
        <div class="brand-logo-container">
            <a href="index.php" class="brand-logo-link">
                <div class="brand-logo-mark">
                    <svg viewBox="0 0 24 24" class="logo-svg">
                        <path d="M4 15l8-8 8 8" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/>
                        <path d="M4 19l8-8 8 8" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" opacity="0.5"/>
                    </svg>
                </div>
                <span class="brand-logo-text">Transit<span class="text-accent">Flow</span></span>
            </a>
        </div>
        
        <ul class="sidebar-menu">
            <li class="menu-item active">
                <a href="index.php">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    Dashboard
                </a>
            </li>
            <li class="menu-item">
                <a href="index.php?url=expeditions">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    Expéditions
                </a>
            </li>
            <li class="menu-item">
                <a href="index.php?url=factures">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Factures
                </a>
            </li>
        </ul>
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
                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polyline points="12 6 12 12 16 14"></polyline>
                    </svg>
                    <span id="live-clock">--:--:--</span>
                </div>

                <!-- Bulle de profil rouge -->
                <div class="navbar-avatar" title="Profil Administrateur">
                    <span>A</span>
                </div>

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
            <button onclick="document.getElementById('flash-msg').remove()" style="background:none;border:none;color:inherit;cursor:pointer;font-size:1rem;margin-left:1rem;">✕</button>
        </div>
        <?php endif; ?>

        <!-- Header -->
        <header class="dashboard-header">
            <div class="header-title">
                <h1>Logistics Hub</h1>
                <p>Suivi en direct des expéditions de marchandises</p>
            </div>
            <!-- Bouton Nouveau Transit aligné à droite du titre -->
            <button id="btn-open-modal" class="btn-nouveau-transit" onclick="document.getElementById('modal-transit').classList.add('is-open')">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
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
                                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"></path><path d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 011-1h2.392a1 1 0 01.737.327l2.824 3.106a1 1 0 00.737.327H20a1 1 0 001-1v-5a1 1 0 00-1-1h-3.936a1 1 0 01-.737-.327l-2.824-3.106A1 1 0 0011.764 5H11"></path></svg>
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
                                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
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
                                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
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
                                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 00-3-3.87"></path><path d="M16 3.13a4 4 0 010 7.75"></path></svg>
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
                        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"></path><path d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 011-1h2.392a1 1 0 01.737.327l2.824 3.106a1 1 0 00.737.327H20a1 1 0 001-1v-5a1 1 0 00-1-1h-3.936a1 1 0 01-.737-.327l-2.824-3.106A1 1 0 0011.764 5H11"></path></svg>
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
                        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
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
                        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
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
                        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 00-3-3.87"></path><path d="M16 3.13a4 4 0 010 7.75"></path></svg>
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
                                    <span class="badge badge-blue"><?= $transitObj->getModeTransport()->getType() ?></span>
                                </td>
                                <td>
                                    <span class="badge <?= $transitObj->getStatutClass() ?>"><?= $transitObj->getStatut() ?></span>
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
                                    <button class="btn-action" style="background: rgb(var(--color-brand-cyan), 0.1); border: 1px solid rgb(var(--color-brand-cyan)); color: rgb(var(--color-brand-cyan)); padding: 6px 12px; border-radius: 6px; cursor: pointer; display: inline-flex; align-items: center; gap: 4px; font-size: 0.85rem; font-weight: 500;" onclick="openDetailsModal(<?= htmlspecialchars(json_encode([
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

<!-- =========================================================================
   Modale : Formulaire d'ajout d'un Nouveau Transit
   ========================================================================= -->
<div id="modal-transit" class="modal-overlay">
    <div class="modal-box">

        <!-- En-tête de la modale -->
        <div class="modal-header">
            <h2 class="modal-title">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"></path><path d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 011-1h1m0 0a1 1 0 011 1v1m-3 0h3"></path></svg>
                Nouveau Transit
            </h2>
            <button class="modal-close" onclick="document.getElementById('modal-transit').classList.remove('is-open')">&times;</button>
        </div>

        <!-- Formulaire POST -->
        <form method="POST" action="?" class="modal-form">
            <input type="hidden" name="action" value="nouveau_transit">

            <!-- Section Marchandise -->
            <div class="form-section-title">Marchandise</div>
            <div class="form-row">
                <div class="form-group">
                    <label for="designation">Désignation</label>
                    <input type="text" id="designation" name="designation" required placeholder="ex: Équipement médical">
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
                    <input type="number" id="poids" name="poids" step="0.1" min="0" required placeholder="ex: 1200">
                </div>
                <div class="form-group">
                    <label for="surface">Surface (m²)</label>
                    <input type="number" id="surface" name="surface" step="0.1" min="0" required placeholder="ex: 15.5">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="client_nom">Nom du Client *</label>
                    <input type="text" id="client_nom" name="client_nom" required placeholder="ex: KPC Logistics">
                </div>
                <div class="form-group">
                    <label for="client_email">Email du Client *</label>
                    <input type="email" id="client_email" name="client_email" required placeholder="ex: contact@kpc.com">
                </div>
            </div>

            <!-- Section Transit -->
            <div class="form-section-title" style="margin-top: 1.25rem;">Itinéraire & Transport</div>
            <div class="form-row">
                <div class="form-group">
                    <label for="ville_depart_id">Ville de départ</label>
                    <select id="ville_depart_id" name="ville_depart_id" required>
                        <option value="">-- Départ --</option>
                        <?php foreach ($listeVilles as $v): ?>
                            <option value="<?= $v['id'] ?>"><?= htmlspecialchars($v['nom']) ?> (<?= htmlspecialchars($v['pays']) ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="ville_arrivee_id">Ville d'arrivée</label>
                    <select id="ville_arrivee_id" name="ville_arrivee_id" required>
                        <option value="">-- Arrivée --</option>
                        <?php foreach ($listeVilles as $v): ?>
                            <option value="<?= $v['id'] ?>"><?= htmlspecialchars($v['nom']) ?> (<?= htmlspecialchars($v['pays']) ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="mode_transport_id">Mode de transport</label>
                <select id="mode_transport_id" name="mode_transport_id" required>
                    <option value="">-- Sélectionner --</option>
                    <?php foreach ($listeModesTransport as $mt): ?>
                        <option value="<?= $mt['id'] ?>"><?= htmlspecialchars($mt['nom']) ?> — <?= $mt['type'] ?></option>
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
                <button type="button" class="btn-cancel" onclick="document.getElementById('modal-transit').classList.remove('is-open')">Annuler</button>
                <button type="submit" class="btn-submit">
                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    Enregistrer & Facturer
                </button>
            </div>
        </form>

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
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                Gestion du Fret <span id="det-title-id" style="color: rgb(var(--color-brand-cyan)); font-weight: 700;"></span>
            </h2>
            <button class="modal-close" onclick="closeDetailsModal()">&times;</button>
        </div>

        <!-- Mode Lecture seule (Détails) -->
        <div id="details-view-mode" style="padding: 1.5rem;">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 25px;">
                <!-- Bloc Marchandise -->
                <div style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08); padding: 15px; border-radius: 10px;">
                    <h3 style="color: rgb(var(--color-brand-cyan)); font-size: 1rem; border-bottom: 1px dashed rgba(255,255,255,0.1); padding-bottom: 5px; margin-bottom: 10px; display: flex; align-items: center; gap: 8px;">
                        📦 Marchandise
                    </h3>
                    <p style="margin: 6px 0;"><strong>Désignation :</strong> <span id="det-designation"></span></p>
                    <p style="margin: 6px 0;"><strong>État :</strong> <span id="det-etat" class="badge"></span></p>
                    <p style="margin: 6px 0;"><strong>Poids :</strong> <span id="det-poids"></span> kg</p>
                    <p style="margin: 6px 0;"><strong>Surface :</strong> <span id="det-surface"></span> m²</p>
                    <p style="margin: 6px 0;"><strong>Propriétaire :</strong> <span id="det-client-nom"></span></p>
                    <p style="margin: 6px 0; font-size: 0.85rem; color: var(--color-text-muted);"><span id="det-client-email"></span></p>
                </div>

                <!-- Bloc Itinéraire & Dates -->
                <div style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08); padding: 15px; border-radius: 10px;">
                    <h3 style="color: rgb(var(--color-brand-blue-royal)); font-size: 1rem; border-bottom: 1px dashed rgba(255,255,255,0.1); padding-bottom: 5px; margin-bottom: 10px; display: flex; align-items: center; gap: 8px;">
                        📍 Logistique & Routage
                    </h3>
                    <p style="margin: 6px 0;"><strong>Départ :</strong> <span id="det-depart"></span></p>
                    <p style="margin: 6px 0;"><strong>Arrivée :</strong> <span id="det-arrivee"></span></p>
                    <p style="margin: 6px 0;"><strong>Date Départ :</strong> <span id="det-date-depart"></span></p>
                    <p style="margin: 6px 0;"><strong>Date Arrivée :</strong> <span id="det-date-arrivee"></span></p>
                    <p style="margin: 6px 0;"><strong>Transport :</strong> <span id="det-transport"></span></p>
                    <p style="margin: 6px 0; font-size: 0.85rem; color: var(--color-text-muted);">Tarif : <span id="det-transport-tarif"></span></p>
                    <p style="margin: 6px 0;"><strong>Statut Transit :</strong> <span id="det-statut" class="badge"></span></p>
                </div>
            </div>

            <!-- Bloc Comptabilité (Facture) -->
            <div style="background: rgba(var(--color-brand-cyan), 0.05); border: 1px solid rgb(var(--color-brand-cyan), 0.2); padding: 15px; border-radius: 10px; margin-bottom: 25px;">
                <h3 style="color: rgb(var(--color-brand-cyan)); font-size: 1rem; display: flex; align-items: center; gap: 8px; margin-bottom: 10px;">
                    Facturation Légale (Gelée)
                </h3>
                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 15px;">
                    <div>
                        <small style="color: var(--color-text-muted); display: block;">N° Facture</small>
                        <strong id="det-facture-num" style="font-size: 1.1rem; color: rgb(var(--color-brand-cyan));">-</strong>
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
            <div class="modal-footer" style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid rgba(255,255,255,0.08); padding-top: 15px;">
                <!-- Bouton Danger à gauche -->
                <button type="button" class="btn-cancel" style="background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.3); color: rgb(239, 68, 68); font-weight: 600; padding: 12px 24px; border-radius: 8px; font-size: 0.95rem; display: inline-flex; align-items: center; gap: 8px; cursor: pointer; transition: all 0.2s;" onclick="triggerDelete()">
                    🗑️ Supprimer le Fret
                </button>
                
                <!-- Boutons à droite -->
                <div style="display: flex; gap: 10px;">
                    <button type="button" class="btn-cancel" style="padding: 12px 24px; border-radius: 8px; font-size: 0.95rem; display: inline-flex; align-items: center; gap: 8px; cursor: pointer; transition: all 0.2s;" onclick="closeDetailsModal()">Fermer</button>
                    <button type="button" class="btn-submit" style="padding: 12px 24px; border-radius: 8px; font-size: 0.95rem; display: inline-flex; align-items: center; gap: 8px; cursor: pointer; transition: all 0.2s;" onclick="enableEditMode()">
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
                                <option value="<?= $v['id'] ?>"><?= htmlspecialchars($v['nom']) ?> (<?= htmlspecialchars($v['pays']) ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit-ville-arrivee-id">Ville d'arrivée</label>
                        <select id="edit-ville-arrivee-id" name="ville_arrivee_id" required>
                            <?php foreach ($listeVilles as $v): ?>
                                <option value="<?= $v['id'] ?>"><?= htmlspecialchars($v['nom']) ?> (<?= htmlspecialchars($v['pays']) ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="edit-mode-transport-id">Mode de transport</label>
                    <select id="edit-mode-transport-id" name="mode_transport_id" required>
                        <?php foreach ($listeModesTransport as $mt): ?>
                            <option value="<?= $mt['id'] ?>"><?= htmlspecialchars($mt['nom']) ?> — <?= $mt['type'] ?></option>
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
</script>

</body>
</html>

