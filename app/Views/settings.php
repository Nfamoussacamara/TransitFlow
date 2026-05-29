<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TransitPro - Configuration & Paramètres</title>
    <!-- CSS AOS CDN -->
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css">
    <!-- Notre Design System local -->
    <link rel="stylesheet" href="/transit/public/css/style.css?v=2.9">
</head>
<body>

<div class="app-container">

    <!-- =========================================================================
       Sidebar Navigation & Brand Logo Space
       ========================================================================= -->
    <aside class="sidebar">
        <div class="brand-logo-container">
            <a href="/transit/" class="brand-logo-link">
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
                <a href="/transit/dashboard">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    Dashboard
                </a>
            </li>
            <li class="menu-item">
                <a href="/transit/expeditions">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    Expéditions
                </a>
            </li>
            <li class="menu-item">
                <a href="/transit/factures">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Factures
                </a>
            </li>
            <li class="menu-item active">
                <a href="/transit/settings">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    Paramètres
                </a>
            </li>
        </ul>
        
        <div class="sidebar-footer">
            <div class="menu-item">
                <a href="/transit/" style="color: rgba(255, 255, 255, 0.75);">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
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
            <div class="navbar-title">
                <span>Configuration & Paramètres</span>
            </div>

            <div class="navbar-actions">
                <div class="navbar-clock">
                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polyline points="12 6 12 12 16 14"></polyline>
                    </svg>
                    <span id="live-clock">--:--:--</span>
                </div>

                <div class="navbar-avatar" title="Profil Administrateur">
                    <span>A</span>
                </div>

                <!-- Bouton de déconnexion -->
                <a href="/transit/logout" class="navbar-logout" title="Se déconnecter">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4M16 17l5-5-5-5M21 12H9"/>
                    </svg>
                </a>
            </div>
        </nav>

        <?php if (isset($_GET['success'])): ?>
        <div class="flash-success" id="flash-msg">
            ✅ &nbsp; Paramètres et tarifs mis à jour avec succès ! Les futurs calculs de facturation appliqueront ces valeurs.
            <button onclick="document.getElementById('flash-msg').remove()" style="background:none;border:none;color:inherit;cursor:pointer;font-size:1rem;margin-left:1rem;">✕</button>
        </div>
        <?php endif; ?>

        <?php if (isset($_GET['error'])): ?>
        <div class="flash-error" id="flash-msg-err" style="background:#ef4444;color:white;padding:1rem;border-radius:12px;margin-bottom:1.5rem;display:flex;justify-content:between;align-items:center;">
            ❌ &nbsp; Erreur : <?= htmlspecialchars($_GET['error']) ?>
            <button onclick="document.getElementById('flash-msg-err').remove()" style="background:none;border:none;color:inherit;cursor:pointer;font-size:1rem;margin-left:1rem;">✕</button>
        </div>
        <?php endif; ?>

        <!-- =========================================================================
           Settings Layout
           ========================================================================= -->
        <div class="data-section" data-aos="fade-up" style="margin-top: 2rem;">
            
            <h2 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 2rem; color: var(--color-text-dark); display: flex; align-items: center; gap: 0.5rem;">
                <svg width="24" height="24" fill="none" stroke="rgb(var(--color-brand-royal))" stroke-width="2" viewBox="0 0 24 24"><path d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
                Ajustement des Tarifs & Taxes
            </h2>

            <form action="/transit/settings" method="POST">
                
                <!-- SECTION TAXES -->
                <div style="margin-bottom: 2.5rem;">
                    <h3 style="font-size: 1.1rem; font-weight: 600; color: var(--color-text-dark); margin-bottom: 1rem; border-bottom: 1px solid var(--color-border-light); padding-bottom: 0.5rem;">Taxes et Règlements</h3>
                    <div class="form-group" style="max-width: 300px;">
                        <label for="tva_rate">Taux de TVA (%)</label>
                        <input type="number" id="tva_rate" name="tva_rate" step="0.1" min="0" max="100" value="<?= (float)($tvaRate * 100) ?>" required style="width: 100%;">
                    </div>
                </div>

                <!-- SECTION MODES DE TRANSPORT -->
                <div style="margin-bottom: 2.5rem;">
                    <h3 style="font-size: 1.1rem; font-weight: 600; color: var(--color-text-dark); margin-bottom: 1.5rem; border-bottom: 1px solid var(--color-border-light); padding-bottom: 0.5rem;">Tarifs des Modes de Transport</h3>
                    
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1.5rem;">
                        <?php foreach ($modes as $m): ?>
                            <div style="background: rgba(0, 0, 0, 0.02); border: 1px solid var(--color-border-light); padding: 1.5rem; border-radius: 12px;">
                                <div style="font-weight: 600; color: var(--color-text-dark); margin-bottom: 0.25rem; font-size: 1rem;">
                                    <?= htmlspecialchars($m['nom']) ?>
                                </div>
                                <div style="font-size: 0.85rem; color: var(--color-text-muted); margin-bottom: 1rem;">
                                    Base : <?= $m['type'] === 'Maritime' ? 'Surface (m²)' : 'Poids (kg)' ?>
                                </div>
                                <div class="form-group" style="margin: 0;">
                                    <label for="tarif_<?= $m['id'] ?>">Tarif unitaire (GNF)</label>
                                    <input type="number" id="tarif_<?= $m['id'] ?>" name="tarifs[<?= $m['id'] ?>]" min="0" value="<?= (float)$m['tarif_unitaire'] ?>" required style="width: 100%;">
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- BOUTON ENREGISTRER -->
                <div style="text-align: right; margin-top: 2rem;">
                    <button type="submit" class="btn-nouveau-transit" style="padding: 0.8rem 2.5rem; display: inline-flex; border: none; font-size: 1rem;">
                        Enregistrer les Paramètres
                    </button>
                </div>

            </form>

        </div>

    </main>

</div>

<!-- CDN AOS JS -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({ duration: 800, once: true });

    // Mise à jour de l'horloge en temps réel
    function updateClock() {
        const now = new Date();
        const timeString = now.toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
        document.getElementById('live-clock').textContent = timeString;
    }
    setInterval(updateClock, 1000);
    updateClock();
</script>
</body>
</html>
