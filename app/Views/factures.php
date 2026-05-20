<?php
declare(strict_types=1);

/**
 * TransitPro - Vue Factures (Grand Livre Comptable)
 * 
 * Affiche l'ensemble des factures immuables enregistrées en base
 * avec leurs calculs financiers et s'intègre au layout TransitPro.
 */
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TransitPro - Grand Livre Comptable</title>
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css">
    <link rel="stylesheet" href="public/css/style.css?v=2.9">
</head>
<body>

<div class="app-container">

    <!-- Sidebar Navigation -->
    <aside class="sidebar">
        <div class="brand-logo-container">
            <a href="index.php" class="brand-logo-link">
                <div class="brand-logo-mark">
                    <svg viewBox="0 0 24 24" class="logo-svg">
                        <path d="M4 15l8-8 8 8" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/>
                        <path d="M4 19l8-8 8 8" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" opacity="0.5"/>
                    </svg>
                </div>
                <span class="brand-logo-text">Transit<span class="text-accent">Pro</span></span>
            </a>
        </div>
        
        <ul class="sidebar-menu">
            <li class="menu-item">
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
            <li class="menu-item active">
                <a href="index.php?url=factures">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Factures
                </a>
            </li>
            <li class="menu-item">
                <a href="index.php?url=settings">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    Paramètres
                </a>
            </li>
        </ul>
    </aside>

    <!-- Main Content Area -->
    <main class="main-content">

        <!-- Top Navbar -->
        <nav class="top-navbar">
            <div class="navbar-title"><span>Factures</span></div>
            <div class="navbar-actions">
                <div class="navbar-clock">
                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polyline points="12 6 12 12 16 14"></polyline>
                    </svg>
                    <span id="live-clock">--:--:--</span>
                </div>
                <div class="navbar-avatar" title="Profil Administrateur"><span>A</span></div>
                <!-- Bouton de déconnexion -->
                <a href="index.php?url=logout" class="navbar-logout" title="Se déconnecter">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4M16 17l5-5-5-5M21 12H9"/>
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
            <button onclick="document.getElementById('flash-msg').remove()" style="background:none;border:none;color:inherit;cursor:pointer;font-size:1rem;margin-left:1rem;">✕</button>
        </div>
        <?php endif; ?>

        <!-- Header -->
        <header class="dashboard-header">
            <div class="header-title" data-aos="fade-right">
                <h1>Grand Livre des Factures</h1>
                <p>Historique financier gelé et comptabilité légale des transits de marchandises</p>
            </div>
        </header>

        <!-- KPI Summary Cards -->
        <div class="dashboard-grid" style="margin-bottom: 2rem;">
            <div class="dashboard-card card-blue-royal" data-aos="fade-up" data-aos-delay="0">
                <div class="card-header">
                    <div class="card-icon-container">
                        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <span class="card-trend badge-blue">TTC</span>
                </div>
                <div class="card-body">
                    <h3 class="card-title">Chiffre d'Affaires Global</h3>
                    <p class="card-value"><?= number_format($totalTtc, 0, ',', ' ') ?> GNF</p>
                </div>
                <div class="card-footer">
                    <span class="card-meta">Montant total avec taxes</span>
                </div>
            </div>

            <div class="dashboard-card card-blue-cyan" data-aos="fade-up" data-aos-delay="100">
                <div class="card-header">
                    <div class="card-icon-container">
                        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"></path><path d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 011-1h2.392a1 1 0 01.737.327l2.824 3.106a1 1 0 00.737.327H20a1 1 0 001-1v-5a1 1 0 00-1-1h-3.936a1 1 0 01-.737-.327l-2.824-3.106A1 1 0 0011.764 5H11"></path></svg>
                    </div>
                    <span class="card-trend badge-blue">HT</span>
                </div>
                <div class="card-body">
                    <h3 class="card-title">Volume Net Hors Taxes</h3>
                    <p class="card-value"><?= number_format($totalHt, 0, ',', ' ') ?> GNF</p>
                </div>
                <div class="card-footer">
                    <span class="card-meta">Total net de taxes de transit</span>
                </div>
            </div>

            <div class="dashboard-card card-blue-slate" data-aos="fade-up" data-aos-delay="200">
                <div class="card-header">
                    <div class="card-icon-container">
                        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"></path></svg>
                    </div>
                    <span class="card-trend badge-blue">Taxe (20%)</span>
                </div>
                <div class="card-body">
                    <h3 class="card-title">TVA Collectée</h3>
                    <p class="card-value"><?= number_format($totalTtc - $totalHt, 0, ',', ' ') ?> GNF</p>
                </div>
                <div class="card-footer">
                    <span class="card-meta">Total de la taxe reversable</span>
                </div>
            </div>

            <div class="dashboard-card card-blue-indigo" data-aos="fade-up" data-aos-delay="300">
                <div class="card-header">
                    <div class="card-icon-container">
                        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    </div>
                    <span class="card-trend badge-blue">Factures</span>
                </div>
                <div class="card-body">
                    <h3 class="card-title">Factures Émises</h3>
                    <p class="card-value"><?= count($factures) ?></p>
                </div>
                <div class="card-footer">
                    <span class="card-meta">Nombre de pièces éditées</span>
                </div>
            </div>
        </div>

        <!-- Listing Section -->
        <section class="data-section" data-aos="fade-up" data-aos-delay="200">
            <div class="section-header">
                <h2>Registre des Factures</h2>
                <span class="badge badge-cyan"><?= count($factures) ?> Enregistrées</span>
            </div>
            
            <div class="table-responsive">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>N° Facture</th>
                            <th>Client Débiteur</th>
                            <th>Transit Lié</th>
                            <th>Date de Facturation</th>
                            <th>Montant HT</th>
                            <th>TVA (20%)</th>
                            <th>Montant TTC</th>
                            <th>Statut Légal</th>
                            <th style="text-align: center;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($factures as $facture): ?>
                            <?php 
                            $transit = $facture->getTransit();
                            $marchandise = $transit->getMarchandise();
                            $tva = $facture->getMontantTtc() - $facture->getMontantBrut();
                            ?>
                            <tr>
                                <td><strong style="color: rgb(var(--color-brand-cyan));"><?= htmlspecialchars($facture->getNumero()) ?></strong></td>
                                <td>
                                    <strong><?= htmlspecialchars($marchandise->getClient()->getNom()) ?></strong>
                                </td>
                                <td>
                                    #TR-<?= str_pad((string)$transit->getId(), 4, '0', STR_PAD_LEFT) ?> 
                                </td>
                                <td><?= $facture->getDateFacturation()->format('d/m/Y H:i') ?></td>
                                <td><?= number_format($facture->getMontantBrut(), 0, ',', ' ') ?> GNF</td>
                                <td><?= number_format($tva, 0, ',', ' ') ?> GNF</td>
                                <td><strong style="font-size: 1rem;"><?= number_format($facture->getMontantTtc(), 0, ',', ' ') ?> GNF</strong></td>
                                <td>
                                    <span class="badge badge-cyan">Gelé & Historisé</span>
                                </td>
                                <td style="text-align: center;">
                                     <button class="btn-submit" 
                                             style="padding: 6px 12px; font-size: 0.8rem; border-radius: 6px; background: rgb(var(--color-brand-indigo)); display: inline-flex; align-items: center; gap: 4px; border: none; cursor: pointer; color: #fff;" 
                                             onclick="openDetailsModal(<?= htmlspecialchars(json_encode([
                                                 'id' => $transit->getId(),
                                                 'designation' => $marchandise->getDesignation(),
                                                 'poids' => $marchandise->getPoids(),
                                                 'surface' => $marchandise->getSurface(),
                                                 'etat' => $marchandise->getEtat(),
                                                 'client_id' => $marchandise->getClient()->getId(),
                                                 'client_nom' => $marchandise->getClient()->getNom(),
                                                 'client_email' => $marchandise->getClient()->getEmail(),
                                                 'ville_depart_id' => $transit->getVilleDepart()->getId(),
                                                 'ville_depart_nom' => $transit->getVilleDepart()->getNom(),
                                                 'ville_depart_pays' => $transit->getVilleDepart()->getPays()->getNom(),
                                                 'ville_arrivee_id' => $transit->getVilleArrivee()->getId(),
                                                 'ville_arrivee_nom' => $transit->getVilleArrivee()->getNom(),
                                                 'ville_arrivee_pays' => $transit->getVilleArrivee()->getPays()->getNom(),
                                                 'mode_transport_id' => $transit->getModeTransport()->getId(),
                                                 'mode_transport_nom' => $transit->getModeTransport()->getNom(),
                                                 'mode_transport_type' => $transit->getModeTransport()->getType(),
                                                 'mode_transport_tarif' => $transit->getTarifUnitaire(),
                                                 'date_depart' => $transit->getDateDepart()->format('Y-m-d\TH:i'),
                                                 'date_depart_fr' => $transit->getDateDepart()->format('d/m/Y H:i'),
                                                 'date_arrivee' => $transit->getDateArrivee()->format('Y-m-d\TH:i'),
                                                 'date_arrivee_fr' => $transit->getDateArrivee()->format('d/m/Y H:i'),
                                                 'facture_num' => $transit->getFacture() ? $transit->getFacture()->getNumero() : null,
                                                 'facture_brut' => $transit->getFacture() ? $transit->getFacture()->getMontantBrut() : null,
                                                 'facture_ttc' => $transit->getFacture() ? $transit->getFacture()->getMontantTtc() : null,
                                                 'statut' => $transit->getStatut(),
                                                 'statut_class' => $transit->getStatutClass(),
                                             ], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP), ENT_QUOTES, 'UTF-8') ?>)">
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
        <div id="details-view-mode" style="padding: 1.5rem; overflow-y: auto; flex-grow: 1; display: flex; flex-direction: column;">
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
        <div id="details-edit-mode" style="display: none; flex-direction: column; overflow: hidden; flex-grow: 1;">
            <form method="POST" action="index.php" class="modal-form">
                <input type="hidden" name="action" value="modifier_transit">
                <input type="hidden" id="edit-transit-id" name="transit_id">
                <input type="hidden" name="redirect_to" value="?url=factures">

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

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({ duration: 600, easing: 'ease-out-cubic', once: true });
    /* Horloge en direct */
    function updateClock() {
        const now = new Date();
        const h = String(now.getHours()).padStart(2, '0');
        const m = String(now.getMinutes()).padStart(2, '0');
        const s = String(now.getSeconds()).padStart(2, '0');
        document.getElementById('live-clock').textContent = `${h}:${m}:${s}`;
    }
    updateClock();
    setInterval(updateClock, 1000);

    // Variables globales modale
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
        document.getElementById('details-edit-mode').style.display = 'flex';
    }

    function disableEditMode() {
        document.getElementById('details-view-mode').style.display = 'flex';
        document.getElementById('details-edit-mode').style.display = 'none';
    }

    function triggerDelete() {
        if (activeTransitData && confirm("⚠️ Êtes-vous sûr de vouloir supprimer définitivement ce transit #" + String(activeTransitData.id).padStart(4, '0') + " et sa facture de la base de données ? Cette action est irréversible !")) {
            window.location.href = "index.php?action=supprimer_transit&id=" + activeTransitData.id + "&redirect_to=" + encodeURIComponent("?url=factures");
        }
    }
</script>
</body>
</html>
