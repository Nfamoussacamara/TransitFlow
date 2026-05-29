<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TransitPro — Solutions Logistiques & Transit de Marchandises</title>
    
    <!-- Meta SEO -->
    <meta name="description" content="TransitPro est la solution leader pour la gestion simplifiée de vos flux logistiques, transits internationaux et facturation automatisée.">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Outfit:wght@500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    <link rel="stylesheet" href="/transit/public/css/style.css">
    
    <style>
        /* Styles spécifiques à la Landing Page pour un effet WOW immédiat */
        :root {
            --hero-gradient: linear-gradient(135deg, #0458e0 0%, #6366f1 100%);
        }

        .landing-top-nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem 5%;
            position: absolute;
            width: 100%;
            z-index: 100;
        }

        .landing-logo {
            font-family: var(--font-heading);
            font-size: 1.5rem;
            font-weight: 800;
            color: #ffffff;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .landing-logo .accent {
            color: #06b6d4;
        }

        .nav-links {
            display: flex;
            gap: 2rem;
            align-items: center;
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.95rem;
            transition: var(--transition-smooth);
        }

        .nav-link:hover {
            color: #ffffff;
        }

        .btn-login-white {
            background: #ffffff;
            color: #0458e0;
            padding: 0.6rem 1.5rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 700;
            font-family: var(--font-heading);
            transition: var(--transition-smooth);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .btn-login-white:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        /* Hero Section */
        .hero {
            position: relative;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            padding: 0 5%;
            color: #ffffff;
            overflow: hidden;
            background-color: #0f172a;
        }

        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.9) 0%, rgba(15, 23, 42, 0.6) 100%);
            z-index: 1;
        }

        .hero-content {
            position: relative;
            max-width: 900px;
            text-align: left;
            z-index: 10;
            padding-top: 60px;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 0.6rem 1.2rem;
            border-radius: 50px;
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 2rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
            animation: slideDown 0.8s ease forwards;
        }

        .hero h1 {
            font-family: var(--font-heading);
            font-size: clamp(2.5rem, 6vw, 4.5rem);
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 1.5rem;
            letter-spacing: -2px;
            animation: fadeInUp 0.8s ease 0.2s forwards;
            opacity: 0;
            color: #ffffff;
        }

        .hero p {
            font-size: 1.25rem;
            color: rgba(255, 255, 255, 0.8);
            line-height: 1.6;
            margin-bottom: 3rem;
            max-width: 650px;
            animation: fadeInUp 0.8s ease 0.4s forwards;
            opacity: 0;
        }

        .hero-features-bar {
            display: flex;
            gap: 1.5rem;
            flex-wrap: wrap;
            animation: fadeInUp 0.8s ease 0.5s forwards;
            opacity: 0;
            margin-bottom: 3rem;
        }

        .feature-tag {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 0.8rem 1.5rem;
            border-radius: 12px;
            color: #fff;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.95rem;
        }

        .feature-tag .dot {
            width: 8px;
            height: 8px;
            background: #06b6d4;
            border-radius: 50%;
            box-shadow: 0 0 10px rgba(6, 182, 212, 0.5);
        }

        .hero-actions {
            display: flex;
            gap: 1.5rem;
            animation: fadeInUp 0.8s ease 0.6s forwards;
            opacity: 0;
        }

        .btn-cta {
            background: #ffffff;
            color: #0458e0;
            padding: 1.2rem 2.5rem;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 700;
            font-size: 1.1rem;
            transition: var(--transition-smooth);
        }

        .btn-cta-outline {
            background: rgba(255, 255, 255, 0.1);
            color: #ffffff;
            padding: 1.2rem 2.5rem;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 700;
            font-size: 1.1rem;
            border: 1px solid rgba(255, 255, 255, 0.3);
            transition: var(--transition-smooth);
            backdrop-filter: blur(10px);
        }

        .btn-cta:hover { transform: translateY(-3px); box-shadow: 0 10px 30px rgba(0,0,0,0.2); }
        .btn-cta-outline:hover { background: rgba(255, 255, 255, 0.2); border-color: #ffffff; }

        /* Features Section */
        .features {
            padding: 100px 5%;
            background: #ffffff;
        }

        .section-tag {
            text-align: center;
            color: #0458e0;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-size: 0.8rem;
            margin-bottom: 1rem;
            display: block;
        }

        .section-title {
            text-align: center;
            font-family: var(--font-heading);
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 4rem;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .feature-card {
            padding: 2.5rem;
            border-radius: 20px;
            background: hsl(var(--color-bg-light));
            transition: var(--transition-smooth);
            border: 1px solid transparent;
        }

        .feature-card:hover {
            background: #ffffff;
            border-color: rgba(4, 88, 224, 0.15);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.05);
            transform: translateY(-10px);
        }

        .feature-icon {
            width: 50px;
            height: 50px;
            background: #0458e0;
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            font-size: 1.5rem;
        }

        .feature-card h3 {
            font-family: var(--font-heading);
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .feature-card p {
            color: var(--color-text-muted);
            font-size: 0.95rem;
        }

        /* Animations */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 768px) {
            .nav-links { display: none; }
            .hero-actions { flex-direction: column; }
        }
    </style>
</head>
<body>
    
    <nav class="landing-top-nav">
        <a href="/transit/" class="landing-logo">
            TRANSIT<span class="accent">PRO</span>
        </a>
        <div class="nav-links">
            <a href="#services" class="nav-link">Services</a>
            <a href="/transit/about" class="nav-link">À Propos</a>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="/transit/login" class="btn-login-white">Accéder à mon espace</a>
            <?php else: ?>
                <a href="/transit/login" class="btn-login-white">Connexion</a>
            <?php endif; ?>
        </div>
    </nav>

    <main>
        <!-- Hero Section -->
        <section class="hero" style="background-image: url('/transit/public/images/hero-bg.jpg'); background-size: cover; background-position: center; background-repeat: no-repeat;">
            <div class="hero-overlay"></div>
            
            <div class="hero-content">
                <div class="hero-badge">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 15l7-7 7 7"></path></svg>
                    TransitPro Global
                </div>

                <h1>Simplifiez vos flux de transit internationaux.</h1>

                <p>
                    Une plateforme intelligente et intégrée pour le pilotage en temps réel, la facturation automatique et la gestion de vos expéditions logistiques.
                </p>

                <div class="hero-features-bar">
                    <div class="feature-tag">
                        <span class="dot"></span>
                        Suivi Temps Réel
                    </div>
                    <div class="feature-tag">
                        <span class="dot"></span>
                        Factures Automatisées
                    </div>
                    <div class="feature-tag">
                        <span class="dot"></span>
                        Multi-modal
                    </div>
                </div>

                <div class="hero-actions">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="/transit/login" class="btn-cta">Accéder à mon espace</a>
                    <?php else: ?>
                        <a href="/transit/login" class="btn-cta">Démarrer maintenant</a>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="features" id="services">
            <span class="section-tag">Pourquoi nous choisir ?</span>
            <h2 class="section-title">Une expertise logistique complète</h2>
            
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">🚢</div>
                    <h3>Multi-Modal Solutions</h3>
                    <p>Que ce soit par voie maritime, aérienne, terrestre ou ferroviaire, nous optimisons vos trajets pour une efficacité maximale.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">📄</div>
                    <h3>Facturation Automatisée</h3>
                    <p>Générez vos factures instantanément selon les tarifs réglementés et envoyez-les directement à vos clients.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🛡️</div>
                    <h3>Espace Client Sécurisé</h3>
                    <p>Offrez à vos clients un accès transparent à leurs expéditions et documents comptables dans un espace dédié.</p>
                </div>
            </div>
        </section>
    </main>

    <footer style="padding: 4rem 5%; background: #0f172a; color: #ffffff; text-align: center;">
        <p>&copy; 2026 TransitPro — Tous droits réservés.</p>
    </footer>

</body>
</html>
