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
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
            background: transparent;
            border-bottom: 1px solid transparent;
            transition: all 0.3s ease;
        }

        .landing-top-nav.scrolled {
            background: rgba(15, 23, 42, 0.9);
            backdrop-filter: blur(12px);
            padding: 1rem 5%;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
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

        /* Generic Section Styles */
        .section-tag {
            text-align: center;
            color: #0458e0;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-size: 0.85rem;
            margin-bottom: 1rem;
            display: block;
            background: rgba(4, 88, 224, 0.05);
            width: fit-content;
            margin: 0 auto 1.5rem;
            padding: 0.5rem 1.2rem;
            border-radius: 50px;
        }

        .section-title {
            text-align: center;
            font-family: var(--font-heading);
            font-size: clamp(2rem, 4vw, 2.8rem);
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 3.5rem;
            letter-spacing: -1px;
        }

        /* Stats Section */
        .stats-section {
            padding: 100px 5%;
            background: #ffffff;
            text-align: center;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 25px;
            margin-top: 50px;
            text-align: left; /* Alignement interne des cartes comme au dashboard */
        }

        /* Réajustement tailles pour le contexte Landing Page public */
        .stats-grid .dashboard-card {
            padding: 1.5rem;
            min-height: 160px;
        }

        .stats-grid .card-value {
            font-size: 2.2rem;
            margin: 0.5rem 0;
        }

        .stats-grid .card-title {
            font-size: 0.85rem;
            letter-spacing: 1px;
        }

        /* Process Section */
        .process-section {
            padding: 100px 5%;
            background: #f1f5f9;
            text-align: center;
        }

        .process-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 40px;
            margin-top: 60px;
        }

        .step-icon {
            width: 80px;
            height: 80px;
            background: #ffffff;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin: 0 auto 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            color: #0458e0;
        }

        .process-step h3 {
            font-family: var(--font-heading);
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .process-step p {
            color: #64748b;
            line-height: 1.6;
        }

        /* Testimonials Section */
        .testimonials-section {
            padding: 100px 5%;
            background: #ffffff;
            text-align: center;
        }

        .testimonials-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 30px;
            margin-top: 60px;
        }

        .testimonial-card {
            text-align: left;
            padding: 40px;
            background: #ffffff;
            border-radius: 24px;
            border: 1px solid #e2e8f0;
            position: relative;
        }

        .testimonial-text {
            font-style: italic;
            color: #334155;
            font-size: 1.1rem;
            line-height: 1.7;
            margin-bottom: 2rem;
        }

        .testimonial-author {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .author-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: #0458e0;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: 700;
        }

        .author-info h4 {
            font-weight: 700;
            color: #0f172a;
            font-size: 1rem;
        }

        .author-info p {
            font-size: 0.85rem;
            color: #64748b;
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

        <!-- Partners Scrolling Bar -->
        <section class="partners-bar" style="background: #ffffff; padding: 40px 0; border-bottom: 2px solid #e2e8f0; overflow: hidden; position: relative;">
            <style>
                @keyframes marquee {
                    0% { transform: translateX(0); }
                    100% { transform: translateX(-50%); }
                }
                .marquee-track {
                    display: flex;
                    width: max-content;
                    animation: marquee 30s linear infinite;
                    gap: 80px;
                }
                .partner-item {
                    font-weight: 800;
                    color: #94a3b8;
                    font-size: 1.2rem;
                    letter-spacing: 3px;
                    white-space: nowrap;
                    display: flex;
                    align-items: center;
                    gap: 10px;
                    transition: color 0.3s ease;
                }
                .partner-item:hover {
                    color: #0458e0;
                }
                .partner-tag {
                    font-size: 0.7rem;
                    background: #f1f5f9;
                    padding: 2px 8px;
                    border-radius: 4px;
                    letter-spacing: 0;
                    font-weight: 600;
                }
            </style>
            <div class="marquee-track">
                <!-- Original Content -->
                <div class="partner-item">PAC <span class="partner-tag">GUINÉE</span></div>
                <div class="partner-item">MAERSK <span class="partner-tag">GLOBAL</span></div>
                <div class="partner-item">CBG <span class="partner-tag">MINES</span></div>
                <div class="partner-item">UMS <span class="partner-tag">LOGISTICS</span></div>
                <div class="partner-item">MSC <span class="partner-tag">SHIPPING</span></div>
                <div class="partner-item">ALPORT <span class="partner-tag">CONAKRY</span></div>
                <div class="partner-item">CGC <span class="partner-tag">GUINÉE</span></div>
                <div class="partner-item">BOLLORÉ <span class="partner-tag">AFRICA</span></div>
                <div class="partner-item">ANAM <span class="partner-tag">GUINÉE</span></div>
                
                <!-- Duplicate for seamless loop -->
                <div class="partner-item">PAC <span class="partner-tag">GUINÉE</span></div>
                <div class="partner-item">MAERSK <span class="partner-tag">GLOBAL</span></div>
                <div class="partner-item">CBG <span class="partner-tag">MINES</span></div>
                <div class="partner-item">UMS <span class="partner-tag">LOGISTICS</span></div>
                <div class="partner-item">MSC <span class="partner-tag">SHIPPING</span></div>
                <div class="partner-item">ALPORT <span class="partner-tag">CONAKRY</span></div>
                <div class="partner-item">CGC <span class="partner-tag">GUINÉE</span></div>
                <div class="partner-item">BOLLORÉ <span class="partner-tag">AFRICA</span></div>
                <div class="partner-item">ANAM <span class="partner-tag">GUINÉE</span></div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="features" id="services">
            <span class="section-tag">Pourquoi nous choisir ?</span>
            <h2 class="section-title">Une expertise logistique complète</h2>
            
            <div class="features-grid">
                <div class="dashboard-card card-blue-royal">
                    <div class="card-header">
                        <div class="card-icon-container">🚢</div>
                    </div>
                    <div class="card-body">
                        <h3 class="card-title" style="font-size: 1.1rem; color: #0f172a; margin-bottom: 1rem;">Multi-Modal Solutions</h3>
                        <p style="color: #64748b; font-size: 0.95rem; line-height: 1.6;">Que ce soit par voie maritime, aérienne, terrestre ou ferroviaire, nous optimisons vos trajets pour une efficacité maximale.</p>
                    </div>
                </div>
                <div class="dashboard-card card-blue-cyan">
                    <div class="card-header">
                        <div class="card-icon-container">📄</div>
                    </div>
                    <div class="card-body">
                        <h3 class="card-title" style="font-size: 1.1rem; color: #0f172a; margin-bottom: 1rem;">Facturation Automatisée</h3>
                        <p style="color: #64748b; font-size: 0.95rem; line-height: 1.6;">Générez vos factures instantanément selon les tarifs réglementés et envoyez-les directement à vos clients.</p>
                    </div>
                </div>
                <div class="dashboard-card card-blue-indigo">
                    <div class="card-header">
                        <div class="card-icon-container">🛡️</div>
                    </div>
                    <div class="card-body">
                        <h3 class="card-title" style="font-size: 1.1rem; color: #0f172a; margin-bottom: 1rem;">Espace Client Sécurisé</h3>
                        <p style="color: #64748b; font-size: 0.95rem; line-height: 1.6;">Offrez à vos clients un accès transparent à leurs expéditions et documents comptables dans un espace dédié.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Stats Section -->
        <section class="stats-section" style="background: #f8fafc;">
            <span class="section-tag">Performance Mondiale</span>
            <h2 class="section-title">TransitPro en Chiffres</h2>
            <div class="stats-grid">
                <!-- Card 1 : Expéditions -->
                <div class="dashboard-card card-blue-royal">
                    <div class="card-header">
                        <div class="card-icon-container">🚢</div>
                        <span class="card-trend">+12%</span>
                    </div>
                    <div class="card-body">
                        <p class="card-value">25k+</p>
                        <h3 class="card-title">Expéditions / An</h3>
                    </div>
                    <div class="card-footer">
                        <span class="card-meta">Volume annuel certifié</span>
                    </div>
                </div>

                <!-- Card 2 : Pays -->
                <div class="dashboard-card card-blue-cyan">
                    <div class="card-header">
                        <div class="card-icon-container">🌍</div>
                    </div>
                    <div class="card-body">
                        <p class="card-value">120+</p>
                        <h3 class="card-title">Pays Couverts</h3>
                    </div>
                    <div class="card-footer">
                        <span class="card-meta">Réseau logistique global</span>
                    </div>
                </div>

                <!-- Card 3 : Succès -->
                <div class="dashboard-card card-blue-indigo">
                    <div class="card-header">
                        <div class="card-icon-container">✅</div>
                        <span class="card-trend">99.9%</span>
                    </div>
                    <div class="card-body">
                        <p class="card-value">99.8%</p>
                        <h3 class="card-title">Taux de Succès</h3>
                    </div>
                    <div class="card-footer">
                        <span class="card-meta">Fiabilité opérationnelle</span>
                    </div>
                </div>

                <!-- Card 4 : Expertise -->
                <div class="dashboard-card card-blue-slate">
                    <div class="card-header">
                        <div class="card-icon-container">🏆</div>
                    </div>
                    <div class="card-body">
                        <p class="card-value">10+</p>
                        <h3 class="card-title">Ans d'Expertise</h3>
                    </div>
                    <div class="card-footer">
                        <span class="card-meta">Savoir-faire historique</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Testimonials Section -->
        <section class="testimonials-section" style="padding: 100px 5%; text-align: center; background: #ffffff;">
            <span class="section-tag">Preuve Sociale</span>
            <h2 class="section-title">La confiance de nos partenaires</h2>
            
            <div class="testimonials-container" style="overflow: hidden; padding: 40px 0; position: relative; width: 100%; margin-top: 40px;">
                <div class="testimonials-track" id="testimonialTrack" style="display: flex; gap: 30px; transition: transform 0.6s ease-in-out;">
                    <!-- Card 1 : Amadou Barry -->
                    <div class="dashboard-card" style="min-width: 323px; width: 323px; height: 193px; flex-shrink: 0; padding: 24px;">
                        <div class="card-body">
                            <p style="font-style: italic; color: #334155; font-size: 0.95rem; line-height: 1.5; margin-bottom: 24px;">"TransitPro a révolutionné notre gestion import-export à Conakry. La transparence est clé."</p>
                            <div class="testimonial-author" style="display: flex; align-items: center; gap: 15px;">
                                <div class="author-avatar" style="width:45px;height:45px;border-radius:50%;overflow:hidden;border:2px solid #0458e0;">
                                    <img src="/transit/public/images/testimonials/man-guinea.jpg" alt="Amadou Barry" style="width:100%;height:100%;object-fit:cover;">
                                </div>
                                <div class="author-info">
                                    <h4 style="font-weight: 700; color: #0f172a; font-size: 0.95rem;">Amadou Barry</h4>
                                    <p style="font-size: 0.8rem; color: #64748b;">Directeur, GuineaTrade</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card 2 : Marc Lefebvre -->
                    <div class="dashboard-card" style="min-width: 323px; width: 323px; height: 193px; flex-shrink: 0; padding: 24px;">
                        <div class="card-body">
                            <p style="font-style: italic; color: #334155; font-size: 0.95rem; line-height: 1.5; margin-bottom: 24px;">"The automated billing and tracking transparency is world-class. Seamless and trust-based."</p>
                            <div class="testimonial-author" style="display: flex; align-items: center; gap: 15px;">
                                <div class="author-avatar" style="width:45px;height:45px;border-radius:50%;overflow:hidden;border:2px solid #06b6d4;">
                                    <img src="/transit/public/images/testimonials/man-europe.jpg" alt="Marc Lefebvre" style="width:100%;height:100%;object-fit:cover;">
                                </div>
                                <div class="author-info">
                                    <h4 style="font-weight: 700; color: #0f172a; font-size: 0.95rem;">Marc Lefebvre</h4>
                                    <p style="font-size: 0.8rem; color: #64748b;">Logistics, EuroLogix</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card 3 : Fatoumata Diallo -->
                    <div class="dashboard-card" style="min-width: 323px; width: 323px; height: 193px; flex-shrink: 0; padding: 24px;">
                        <div class="card-body">
                            <p style="font-style: italic; color: #334155; font-size: 0.95rem; line-height: 1.5; margin-bottom: 24px;">"En tant qu'entrepreneuse, j'ai besoin de fiabilité. TransitPro m'offre cette sécurité."</p>
                            <div class="testimonial-author" style="display: flex; align-items: center; gap: 15px;">
                                <div class="author-avatar" style="width:45px;height:45px;border-radius:50%;overflow:hidden;border:2px solid #6366f1;">
                                    <img src="/transit/public/images/testimonials/woman-guinea.jpg" alt="Fatoumata Diallo" style="width:100%;height:100%;object-fit:cover;">
                                </div>
                                <div class="author-info">
                                    <h4 style="font-weight: 700; color: #0f172a; font-size: 0.95rem;">Fatoumata Diallo</h4>
                                    <p style="font-size: 0.8rem; color: #64748b;">Fondctrice, Conakry Mode</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card 4 : Ousmane Bah -->
                    <div class="dashboard-card" style="min-width: 323px; width: 323px; height: 193px; flex-shrink: 0; padding: 24px;">
                        <div class="card-body">
                            <p style="font-style: italic; color: #334155; font-size: 0.95rem; line-height: 1.5; margin-bottom: 24px;">"Un service exemplaire. La rapidité du traitement des documents est impressionnante."</p>
                            <div class="testimonial-author" style="display: flex; align-items: center; gap: 15px;">
                                <div class="author-avatar" style="width:45px;height:45px;border-radius:50%;overflow:hidden;border:2px solid #f59e0b;">
                                    <img src="/transit/public/images/testimonials/man-guinea-2.jpg" alt="Ousmane Bah" style="width:100%;height:100%;object-fit:cover;">
                                </div>
                                <div class="author-info">
                                    <h4 style="font-weight: 700; color: #0f172a; font-size: 0.95rem;">Ousmane Bah</h4>
                                    <p style="font-size: 0.8rem; color: #64748b;">Importateur, Bah & Fils</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card 5 : Sarah Wilson -->
                    <div class="dashboard-card" style="min-width: 323px; width: 323px; height: 193px; flex-shrink: 0; padding: 24px;">
                        <div class="card-body">
                            <p style="font-style: italic; color: #334155; font-size: 0.95rem; line-height: 1.5; margin-bottom: 24px;">"TransitPro provides the most reliable dashboard I've used for trade operations."</p>
                            <div class="testimonial-author" style="display: flex; align-items: center; gap: 15px;">
                                <div class="author-avatar" style="width:45px;height:45px;border-radius:50%;overflow:hidden;border:2px solid #ec4899;">
                                    <img src="/transit/public/images/testimonials/woman-uk.jpg" alt="Sarah Wilson" style="width:100%;height:100%;object-fit:cover;">
                                </div>
                                <div class="author-info">
                                    <h4 style="font-weight: 700; color: #0f172a; font-size: 0.95rem;">Sarah Wilson</h4>
                                    <p style="font-size: 0.8rem; color: #64748b;">Manager, UK Global Freight</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card 6 : Mamadou Diallo -->
                    <div class="dashboard-card" style="min-width: 323px; width: 323px; height: 193px; flex-shrink: 0; padding: 24px;">
                        <div class="card-body">
                            <p style="font-style: italic; color: #334155; font-size: 0.95rem; line-height: 1.5; margin-bottom: 24px;">"L'interface est intuitive et le support client est exceptionnel. Un vrai partenaire."</p>
                            <div class="testimonial-author" style="display: flex; align-items: center; gap: 15px;">
                                <div class="author-avatar" style="width:45px;height:45px;border-radius:50%;overflow:hidden;border:2px solid #10b981;">
                                    <img src="/transit/public/images/testimonials/man-guinea-3.jpg" alt="Mamadou Diallo" style="width:100%;height:100%;object-fit:cover;">
                                </div>
                                <div class="author-info">
                                    <h4 style="font-weight: 700; color: #0f172a; font-size: 0.95rem;">Mamadou Diallo</h4>
                                    <p style="font-size: 0.8rem; color: #64748b;">CEO, WestAfrica Logistics</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Process Section -->
        <section class="process-section" style="background: #f1f5f9;">
            <span class="section-tag">Notre Méthode</span>
            <h2 class="section-title">Comment ça marche ?</h2>
            <div class="process-grid" style="display: grid; grid-template-columns: repeat(auto-fit, 323px); justify-content: center; gap: 30px;">
                <div class="dashboard-card card-blue-royal" style="width: 323px; height: 193px; padding: 24px;">
                    <div class="card-header">
                        <div class="card-icon-container">📝</div>
                    </div>
                    <div class="card-body">
                        <h3 class="card-title" style="font-size: 1.1rem; color: #0f172a; margin-bottom: 0.5rem; text-transform: none;">1. Réservation</h3>
                        <p style="color: #64748b; font-size: 0.9rem;">Enregistrez vos marchandises et choisissez votre transport en quelques clics.</p>
                    </div>
                </div>
                <div class="dashboard-card card-blue-cyan" style="width: 323px; height: 193px; padding: 24px;">
                    <div class="card-header">
                        <div class="card-icon-container">🚚</div>
                    </div>
                    <div class="card-body">
                        <h3 class="card-title" style="font-size: 1.1rem; color: #0f172a; margin-bottom: 0.5rem; text-transform: none;">2. Transit</h3>
                        <p style="color: #64748b; font-size: 0.9rem;">Nous prenons en charge la logistique et vous suivez l'avancement en temps réel.</p>
                    </div>
                </div>
                <div class="dashboard-card card-blue-indigo" style="width: 323px; height: 193px; padding: 24px;">
                    <div class="card-header">
                        <div class="card-icon-container">🏁</div>
                    </div>
                    <div class="card-body">
                        <h3 class="card-title" style="font-size: 1.1rem; color: #0f172a; margin-bottom: 0.5rem; text-transform: none;">3. Livraison</h3>
                        <p style="color: #64748b; font-size: 0.9rem;">Vos marchandises arrivent à destination. Facturation automatique.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Final CTA Section -->
        <section style="padding: 100px 5%; background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); color: #ffffff; text-align: center;">
            <h2 style="font-family: var(--font-heading); font-size: 2.5rem; font-weight: 800; margin-bottom: 1.5rem;">Prêt à propulser votre logistique ?</h2>
            <p style="font-size: 1.2rem; color: rgba(255,255,255,0.7); max-width: 700px; margin: 0 auto 3rem;">
                Rejoignez les leaders du marché qui font confiance à TransitPro pour la gestion de leurs flux mondiaux.
            </p>
            <a href="/transit/login" class="btn-cta">Commencer l'aventure</a>
        </section>

    </main>

    <footer style="padding: 5rem 5% 2rem; background: #0f172a; color: #ffffff;">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 40px; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 4rem; margin-bottom: 2rem;">
            <div>
                <a href="/transit/" class="landing-logo" style="margin-bottom: 1.5rem;">
                    TRANSIT<span class="accent">PRO</span>
                </a>
                <p style="color: rgba(255,255,255,0.6); line-height: 1.6; font-size: 0.9rem;">
                    Votre partenaire de confiance pour le transit international. Technologie, rapidité et sécurité au service de votre croissance.
                </p>
            </div>
            <div>
                <h4 style="margin-bottom: 1.5rem; font-family: var(--font-heading);">Solutions</h4>
                <ul style="list-style: none; display: flex; flex-direction: column; gap: 0.8rem;">
                    <li><a href="#" style="color: rgba(255,255,255,0.6); text-decoration: none; font-size: 0.9rem;">Fret Aérien</a></li>
                    <li><a href="#" style="color: rgba(255,255,255,0.6); text-decoration: none; font-size: 0.9rem;">Transport Maritime</a></li>
                    <li><a href="#" style="color: rgba(255,255,255,0.6); text-decoration: none; font-size: 0.9rem;">Logistique Routière</a></li>
                </ul>
            </div>
            <div>
                <h4 style="margin-bottom: 1.5rem; font-family: var(--font-heading);">Compagnie</h4>
                <ul style="list-style: none; display: flex; flex-direction: column; gap: 0.8rem;">
                    <li><a href="/transit/about" style="color: rgba(255,255,255,0.6); text-decoration: none; font-size: 0.9rem;">À Propos</a></li>
                    <li><a href="#" style="color: rgba(255,255,255,0.6); text-decoration: none; font-size: 0.9rem;">Nos Partenaires</a></li>
                    <li><a href="#" style="color: rgba(255,255,255,0.6); text-decoration: none; font-size: 0.9rem;">Contact</a></li>
                </ul>
            </div>
            <div>
                <h4 style="margin-bottom: 1.5rem; font-family: var(--font-heading);">Légal</h4>
                <ul style="list-style: none; display: flex; flex-direction: column; gap: 0.8rem;">
                    <li><a href="#" style="color: rgba(255,255,255,0.6); text-decoration: none; font-size: 0.9rem;">Mentions Légales</a></li>
                    <li><a href="#" style="color: rgba(255,255,255,0.6); text-decoration: none; font-size: 0.9rem;">Confidentialité</a></li>
                </ul>
            </div>
        </div>
        <div style="text-align: center; color: rgba(255,255,255,0.4); font-size: 0.85rem;">
            <p>&copy; 2026 TransitPro Global Logistics — Tous droits réservés.</p>
        </div>
    </footer>

    <!-- Bouton Retour en Haut -->
    <button id="backToTop" onclick="window.scrollTo({top: 0, behavior: 'smooth'})" title="Retour en haut" style="
        position: fixed;
        bottom: 40px;
        right: 40px;
        width: 52px;
        height: 52px;
        border-radius: 50%;
        background: linear-gradient(135deg, #0458e0, #06b6d4);
        color: #ffffff;
        border: none;
        cursor: pointer;
        font-size: 1.3rem;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 8px 25px rgba(4, 88, 224, 0.4);
        opacity: 0;
        transform: translateY(20px);
        transition: opacity 0.3s ease, transform 0.3s ease;
        z-index: 9999;
        pointer-events: none;
    ">↑</button>


    <script>
        // Gestion du changement de style de la navbar + bouton retour en haut
        const backToTopBtn = document.getElementById('backToTop');
        window.addEventListener('scroll', function() {
            const nav = document.querySelector('.landing-top-nav');
            if (window.scrollY > 50) {
                nav.classList.add('scrolled');
            } else {
                nav.classList.remove('scrolled');
            }
            // Afficher/masquer le bouton retour en haut
            if (window.scrollY > 400) {
                backToTopBtn.style.opacity = '1';
                backToTopBtn.style.transform = 'translateY(0)';
                backToTopBtn.style.pointerEvents = 'auto';
            } else {
                backToTopBtn.style.opacity = '0';
                backToTopBtn.style.transform = 'translateY(20px)';
                backToTopBtn.style.pointerEvents = 'none';
            }
        });

        // Effet hover sur le bouton
        if (backToTopBtn) {
            backToTopBtn.addEventListener('mouseenter', () => {
                backToTopBtn.style.transform = 'translateY(-4px) scale(1.1)';
                backToTopBtn.style.boxShadow = '0 12px 35px rgba(4, 88, 224, 0.55)';
            });
            backToTopBtn.addEventListener('mouseleave', () => {
                backToTopBtn.style.transform = 'translateY(0) scale(1)';
                backToTopBtn.style.boxShadow = '0 8px 25px rgba(4, 88, 224, 0.4)';
            });
        }

        // Carrousel Auto Infini pour les témoignages
        const track = document.getElementById('testimonialTrack');
        if (track) {
            const cards = Array.from(track.children);
            const totalCards = cards.length;
            const gap = 30;
            const cardWidth = 323;
            
            // Cloner les cartes pour un défilement infini fluide
            cards.forEach(card => {
                const clone = card.cloneNode(true);
                track.appendChild(clone);
            });

            let index = 0;
            function autoScroll() {
                index++;
                track.style.transition = "transform 0.6s ease-in-out";
                const offset = index * (cardWidth + gap);
                track.style.transform = `translateX(-${offset}px)`;

                // Reset discret quand on arrive à la fin des cartes originales
                if (index === totalCards) {
                    setTimeout(() => {
                        track.style.transition = "none";
                        index = 0;
                        track.style.transform = `translateX(0)`;
                    }, 600);
                }
            }

            setInterval(autoScroll, 4000); // Change toutes les 4 secondes
        }
    </script>
</body>
</html>
