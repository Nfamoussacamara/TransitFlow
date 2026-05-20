<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TransitPro - À Propos</title>
    <!-- CSS AOS -->
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css">
    <!-- Notre Design System local (avec cache-buster) -->
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
                <a href="index.php?url=accueil">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                    Accueil
                </a>
            </li>
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
            <li class="menu-item">
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
            <li class="menu-item active">
                <a href="index.php?url=apropos">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                    À Propos
                </a>
            </li>
        </ul>
    </aside>

    <main class="main-content">
        <nav class="top-navbar">
            <div class="navbar-title">
                <span>À Propos de nous</span>
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
                <a href="index.php?url=logout" class="navbar-logout" title="Se déconnecter">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4M16 17l5-5-5-5M21 12H9"/>
                    </svg>
                </a>
            </div>
        </nav>

        <header class="dashboard-header" data-aos="fade-in">
            <div class="header-title">
                <h1>L'Histoire de TransitPro</h1>
                <p>Né d'une volonté de moderniser l'infrastructure logistique de la Guinée.</p>
            </div>
        </header>

        <section class="data-section" data-aos="fade-up" data-aos-delay="100">
            <div class="dashboard-grid">
                <div class="dashboard-card card-blue-slate" style="grid-column: 1 / -1;">
                    <div class="card-header">
                        <h3 class="card-title">Notre Vision</h3>
                    </div>
                    <div class="card-body">
                        <p style="color: var(--color-text-body); font-size: 1rem; line-height: 1.6; margin-top: 10px;">
                            Nous croyons que l'avenir du commerce en Guinée passe par une chaîne logistique optimisée, transparente et rapide. TransitPro est conçu pour éliminer la complexité des calculs de fret, réduire la paperasse et offrir aux entreprises une vue claire sur leurs expéditions.
                        </p>
                        <hr style="border: 0; border-top: 1px dashed rgba(255,255,255,0.1); margin: 15px 0;">
                        <h4 style="color: #fff; margin-bottom: 5px;">Contactez-nous</h4>
                        <p style="color: var(--color-text-body); font-size: 0.95rem; line-height: 1.6;">
                            📍 Adresse : Conakry, République de Guinée<br>
                            ✉️ Email : contact@transitpro.gn<br>
                            📞 Téléphone : +224 600 00 00 00
                        </p>
                    </div>
                </div>
            </div>
        </section>

    </main>
</div>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({ duration: 600, easing: 'ease-out-cubic', once: true });
    function updateClock() {
        const now = new Date();
        document.getElementById('live-clock').textContent = 
            String(now.getHours()).padStart(2, '0') + ':' + 
            String(now.getMinutes()).padStart(2, '0') + ':' + 
            String(now.getSeconds()).padStart(2, '0');
    }
    updateClock();
    setInterval(updateClock, 1000);
</script>
</body>
</html>
