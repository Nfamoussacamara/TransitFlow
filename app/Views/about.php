<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>À Propos — TransitPro Global Logistics</title>
    
    <!-- Meta SEO -->
    <meta name="description" content="Découvrez l'histoire, la mission et les valeurs de TransitPro, votre partenaire de confiance pour le transit international de marchandises.">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Outfit:wght@500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    <link rel="stylesheet" href="/transit/public/css/style.css">
    
    <style>
        .about-hero {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            padding: 120px 5% 80px;
            color: #ffffff;
            text-align: center;
        }

        .about-hero h1 {
            font-family: var(--font-heading);
            font-size: clamp(2.5rem, 5vw, 3.5rem);
            font-weight: 800;
            margin-bottom: 1.5rem;
        }

        .about-hero p {
            font-size: 1.2rem;
            color: rgba(255, 255, 255, 0.7);
            max-width: 700px;
            margin: 0 auto;
        }

        .content-section {
            padding: 80px 5%;
            max-width: 1200px;
            margin: 0 auto;
        }

        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
        }

        .image-box {
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 20px 50px rgba(0,0,0,0.1);
        }

        .image-box img {
            width: 100%;
            height: auto;
            display: block;
        }

        .text-content h2 {
            font-family: var(--font-heading);
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            color: #0f172a;
        }

        .text-content p {
            font-size: 1.1rem;
            color: #475569;
            line-height: 1.7;
            margin-bottom: 1.5rem;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 30px;
            margin-top: 50px;
            text-align: center;
        }

        .stat-item {
            padding: 30px;
            background: #f8fafc;
            border-radius: 20px;
        }

        .stat-number {
            display: block;
            font-size: 2.5rem;
            font-weight: 800;
            color: #0458e0;
            font-family: var(--font-heading);
            margin-bottom: 5px;
        }

        .stat-label {
            font-size: 0.9rem;
            color: #64748b;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .values-section {
            background: #f1f5f9;
            padding: 100px 5%;
            text-align: center;
        }

        .values-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            margin-top: 50px;
        }

        .value-card {
            background: #ffffff;
            padding: 40px;
            border-radius: 24px;
            transition: transform 0.3s ease;
        }

        .value-card:hover {
            transform: translateY(-10px);
        }

        .value-icon {
            font-size: 2.5rem;
            margin-bottom: 20px;
            display: block;
        }

        .value-card h3 {
            font-family: var(--font-heading);
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .cta-section {
            padding: 100px 5%;
            text-align: center;
            background: linear-gradient(135deg, #0458e0 0%, #6366f1 100%);
            color: #ffffff;
        }

        .btn-white {
            background: #ffffff;
            color: #0458e0;
            padding: 1.2rem 2.5rem;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 700;
            font-size: 1.1rem;
            display: inline-block;
            margin-top: 2rem;
            transition: all 0.3s ease;
        }

        .btn-white:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }

        @media (max-width: 768px) {
            .grid-2 { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

    <nav class="landing-top-nav" style="background: rgba(15, 23, 42, 0.9); backdrop-filter: blur(10px); position: fixed; top: 0; width: 100%;">
        <a href="/transit/" class="landing-logo">
            TRANSIT<span class="accent">PRO</span>
        </a>
        <div class="nav-links">
            <a href="/transit/" class="nav-link">Accueil</a>
            <a href="/transit/about" class="nav-link">À Propos</a>
            <a href="/transit/login" class="btn-login-white">Connexion</a>
        </div>
    </nav>

    <header class="about-hero">
        <h1>Redéfinir le Transit Mondial</h1>
        <p>Plus qu'une simple entreprise de logistique, nous sommes le moteur technologique de vos échanges internationaux.</p>
    </header>

    <section class="content-section">
        <div class="grid-2">
            <div class="image-box">
                <img src="https://images.unsplash.com/photo-1577416416829-d436813b8606?auto=format&fit=crop&q=80&w=1200" alt="Logistique Moderne">
            </div>
            <div class="text-content">
                <h2>Notre Mission</h2>
                <p>Fondée en 2026, TransitPro est née d'une vision simple : éliminer les barrières de la logistique internationale grâce à l'innovation technologique.</p>
                <p>Nous combinons une expertise terrain éprouvée avec une plateforme numérique de pointe pour offrir une transparence totale, une efficacité maximale et une tranquillité d'esprit absolue à nos clients dans le monde entier.</p>
                
                <div class="stats-grid">
                    <div class="stat-item">
                        <span class="stat-number">120+</span>
                        <span class="stat-label">Pays desservis</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">5M+</span>
                        <span class="stat-label">Tonnes livrées</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="values-section">
        <span class="section-tag">Ce qui nous anime</span>
        <h2 class="section-title" style="margin-bottom: 2rem;">Nos Valeurs Fondamentales</h2>
        <div class="values-grid">
            <div class="value-card">
                <span class="value-icon">⚡</span>
                <h3>Agilité</h3>
                <p>Nous nous adaptons en temps réel aux défis de la supply chain mondiale pour garantir des délais records.</p>
            </div>
            <div class="value-card">
                <span class="value-icon">🔍</span>
                <h3>Transparence</h3>
                <p>De la facturation au suivi GPS, chaque étape de votre transit est visible et documentée.</p>
            </div>
            <div class="value-card">
                <span class="value-icon">🌐</span>
                <h3>Durabilité</h3>
                <p>Nous optimisons chaque trajet pour réduire l'empreinte carbone globale du transit international.</p>
            </div>
        </div>
    </section>

    <section class="cta-section">
        <h2>Prêt à transformer votre logistique ?</h2>
        <p>Rejoignez les milliers d'entreprises qui font confiance à TransitPro pour leur expansion mondiale.</p>
        <a href="/transit/login" class="btn-white">Démarrer maintenant</a>
    </section>

    <footer style="padding: 4rem 5%; background: #0f172a; color: #ffffff; text-align: center;">
        <p>&copy; 2026 TransitPro — Tous droits réservés.</p>
    </footer>

</body>
</html>
