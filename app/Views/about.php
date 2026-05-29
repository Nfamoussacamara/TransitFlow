<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>À Propos — TransitPro Global Logistics</title>

    <!-- Meta SEO -->
    <meta name="description"
        content="Découvrez l'histoire, la mission et les valeurs de TransitPro, votre partenaire de confiance pour le transit international de marchandises.">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Outfit:wght@500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="/transit/public/css/style.css">

    <style>
        /* Shared Navigation Styles */
        .landing-top-nav {
            display: grid;
            grid-template-columns: 1fr auto 1fr;
            align-items: center;
            padding: 1.5rem 5%;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
            background: transparent;
            border-bottom: 1px solid transparent;
            transition: all 0.3s ease;
            box-sizing: border-box;
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

        .about-hero {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            padding: 160px 5% 100px;
            /* Augmentation padding pour compenser nav fixe */
            color: #ffffff;
            text-align: center;
        }

        .about-hero h1 {
            font-family: var(--font-heading);
            font-size: clamp(2.5rem, 5vw, 4.5rem);
            font-weight: 800;
            margin-bottom: 1.5rem;
            letter-spacing: -2px;
        }

        .about-hero p {
            font-size: 1.25rem;
            color: rgba(255, 255, 255, 0.7);
            max-width: 750px;
            margin: 0 auto;
            line-height: 1.6;
        }

        .section-tag {
            display: inline-block;
            background: rgba(4, 88, 224, 0.1);
            color: #0458e0;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 1.5rem;
        }

        .section-title {
            font-family: var(--font-heading);
            font-size: 2.5rem;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 3rem;
            letter-spacing: -1px;
        }

        /* ... reste des styles conservés ... */
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
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.1);
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
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .btn-cta {
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

        .btn-cta:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        @media (max-width: 768px) {
            .grid-2 {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

    <nav class="landing-top-nav">
        <a href="/transit/" class="landing-logo">
            TRANSIT<span class="accent">PRO</span>
        </a>
        <div class="nav-links" style="display: flex; gap: 2rem; align-items: center; justify-content: center;">
            <a href="/transit/" class="nav-link">Accueil</a>
            <a href="/transit/about" class="nav-link">À Propos</a>
        </div>
        <div style="display: flex; justify-content: flex-end;">
            <a href="/transit/login" class="btn-login-white">Connexion</a>
        </div>
    </nav>

    <!-- Hero About -->
    <header class="about-hero"
        style="min-height: 60vh; display: flex; align-items: center; justify-content: center; text-align: center; padding: 150px 5% 100px; background-image: linear-gradient(135deg, rgba(15, 23, 42, 0.8) 0%, rgba(15, 23, 42, 0.6) 100%), url('/transit/public/images/UL.jpg'); background-size: cover; background-position: center;">
        <div>
            <span class="section-tag"
                style="background: rgba(255,255,255,0.15); color: #ffffff; margin-bottom: 1.5rem; display: inline-block;">🇬🇳
                Entreprise Guinéenne — Conakry, Guinée</span>
            <h1
                style="font-family: var(--font-heading); font-size: clamp(2.5rem, 5vw, 4rem); font-weight: 800; color: #ffffff; margin-bottom: 1.5rem; letter-spacing: -2px;">
                Redéfinir le Transit Mondial</h1>
            <p
                style="font-size: 1.2rem; color: rgba(255,255,255,0.8); max-width: 700px; margin: 0 auto; line-height: 1.7;">
                Plus qu'une simple entreprise de logistique, nous sommes le moteur technologique des échanges
                internationaux, fièrement ancré à Conakry, en République de Guinée.</p>
        </div>
    </header>

    <!-- Mission Section -->
    <section style="padding: 100px 5%; background: #ffffff;">
        <div
            style="max-width: 1200px; margin: 0 auto; display: grid; grid-template-columns: 1fr 1fr; gap: 80px; align-items: center;">
            <div>
                <span class="section-tag">Notre ADN</span>
                <h2
                    style="font-family: var(--font-heading); font-size: 2.2rem; font-weight: 800; color: #0f172a; margin: 1rem 0 1.5rem; letter-spacing: -1px;">
                    Notre Mission</h2>
                <p style="font-size: 1.05rem; color: #475569; line-height: 1.8; margin-bottom: 1.2rem;">Née en 2026 dans
                    les couloirs de l'<strong>Université de Labé</strong>, en République de Guinée, TransitPro est le
                    fruit d'une ambition estudiantine : faire de la Guinée un hub logistique de référence en Afrique de
                    l'Ouest grâce à l'innovation technologique.</p>
                <p style="font-size: 1.05rem; color: #475569; line-height: 1.8;">En tant qu'entreprise guinéenne, nous
                    combinons l'expertise terrain locale avec une plateforme numérique de pointe pour offrir une
                    transparence totale et une efficacité maximale à nos clients dans le monde entier.</p>
                <div
                    style="margin-top: 1.5rem; display: flex; align-items: center; gap: 12px; background: #f8fafc; border: 2px solid #e2e8f0; border-radius: 12px; padding: 14px 18px;">
                    <span style="font-size: 1.5rem;">🎓</span>
                    <div>
                        <div style="font-weight: 700; color: #0f172a; font-size: 0.95rem;">Université de Labé</div>
                        <div style="font-size: 0.82rem; color: #64748b;">Labé, République de Guinée — Berceau de
                            TransitPro</div>
                    </div>
                </div>
            </div>
            <div style="border-radius: 24px; overflow: hidden; box-shadow: 0 20px 60px rgba(4,88,224,0.15);">
                <img src="/transit/public/images/UL.jpg" alt="Université de Labé — Berceau de TransitPro"
                    style="width:100%; height:400px; object-fit:cover; display:block;">
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section style="padding: 80px 5%; background: #f8fafc; text-align: center;">
        <span class="section-tag">TransitPro en Chiffres</span>
        <h2 class="section-title">Notre Impact Mondial</h2>
        <div style="display: flex; justify-content: center; gap: 30px; flex-wrap: wrap; margin-top: 50px;">
            <div class="dashboard-card card-blue-royal" style="width: 220px; padding: 24px; text-align: left;">
                <div class="card-header">
                    <span class="card-badge">+8%</span>
                </div>
                <div class="card-body">
                    <div class="card-value">120+</div>
                    <div class="card-label">PAYS DESSERVIS</div>
                    <span class="card-meta">Réseau logistique global</span>
                </div>
            </div>
            <div class="dashboard-card card-blue-cyan" style="width: 220px; padding: 24px; text-align: left;">
                <div class="card-header">
                    <span class="card-badge">+22%</span>
                </div>
                <div class="card-body">
                    <div class="card-value">5M+</div>
                    <div class="card-label">TONNES LIVRÉES</div>
                    <span class="card-meta">Volume annuel certifié</span>
                </div>
            </div>
            <div class="dashboard-card card-blue-indigo" style="width: 220px; padding: 24px; text-align: left;">
                <div class="card-header">
                    <span class="card-badge">99.9%</span>
                </div>
                <div class="card-body">
                    <div class="card-value">99.8%</div>
                    <div class="card-label">TAUX DE SUCCÈS</div>
                    <span class="card-meta">Fiabilité opérationnelle</span>
                </div>
            </div>
            <div class="dashboard-card" style="width: 220px; padding: 24px; text-align: left;">
                <div class="card-header">
                    <span class="card-badge">Leader</span>
                </div>
                <div class="card-body">
                    <div class="card-value">10+</div>
                    <div class="card-label">ANS D'EXPERTISE</div>
                    <span class="card-meta">Savoir-faire historique</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Values Section -->
    <section style="padding: 100px 5%; background: #ffffff; text-align: center;">
        <span class="section-tag">Ce qui nous anime</span>
        <h2 class="section-title">Nos Valeurs Fondamentales</h2>
        <div
            style="display: grid; grid-template-columns: repeat(auto-fit, 323px); justify-content: center; gap: 30px; margin-top: 50px;">
            <div class="dashboard-card card-blue-royal" style="width: 323px; height: 193px; padding: 24px;">
                <div class="card-header">
                </div>
                <div class="card-body">
                    <h3 class="card-title"
                        style="font-size: 1.1rem; color: #0f172a; margin-bottom: 0.5rem; text-transform: none;">Agilité
                    </h3>
                    <p style="color: #64748b; font-size: 0.9rem;">Nous nous adaptons en temps réel aux défis de la
                        supply chain mondiale pour garantir des délais records.</p>
                </div>
            </div>
            <div class="dashboard-card card-blue-cyan" style="width: 323px; height: 193px; padding: 24px;">
                <div class="card-header">
                </div>
                <div class="card-body">
                    <h3 class="card-title"
                        style="font-size: 1.1rem; color: #0f172a; margin-bottom: 0.5rem; text-transform: none;">
                        Transparence</h3>
                    <p style="color: #64748b; font-size: 0.9rem;">De la facturation au suivi GPS, chaque étape de votre
                        transit est visible et documentée.</p>
                </div>
            </div>
            <div class="dashboard-card card-blue-indigo" style="width: 323px; height: 193px; padding: 24px;">
                <div class="card-header">
                </div>
                <div class="card-body">
                    <h3 class="card-title"
                        style="font-size: 1.1rem; color: #0f172a; margin-bottom: 0.5rem; text-transform: none;">
                        Durabilité</h3>
                    <p style="color: #64748b; font-size: 0.9rem;">Nous optimisons chaque trajet pour réduire l'empreinte
                        carbone globale du transit international.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section
        style="padding: 100px 5%; background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); color: #ffffff; text-align: center;">
        <h2 style="font-family: var(--font-heading); font-size: 2.5rem; font-weight: 800; margin-bottom: 1.5rem;">Prêt à
            transformer votre logistique ?</h2>
        <p style="font-size: 1.2rem; color: rgba(255,255,255,0.7); max-width: 700px; margin: 0 auto 3rem;">
            Rejoignez les milliers d'entreprises qui font confiance à TransitPro pour leur expansion mondiale.
        </p>
        <a href="/transit/login" class="btn-cta">Démarrer maintenant</a>
    </section>

    <!-- Footer complet -->
    <footer style="padding: 5rem 5% 2rem; background: #0f172a; color: #ffffff;">
        <div
            style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 40px; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 4rem; margin-bottom: 2rem;">
            <div>
                <a href="/transit/" class="landing-logo" style="margin-bottom: 1.5rem; display:block;">TRANSIT<span
                        class="accent">PRO</span></a>
                <p style="color: rgba(255,255,255,0.6); line-height: 1.6; font-size: 0.9rem;">Entreprise guinéenne
                    fondée à Conakry. Votre partenaire de confiance pour le transit international en Afrique et dans le
                    monde.</p>
            </div>
            <div>
                <h4 style="margin-bottom: 1.5rem; font-family: var(--font-heading);">Solutions</h4>
                <ul style="list-style: none; display: flex; flex-direction: column; gap: 0.8rem;">
                    <li><a href="#" style="color: rgba(255,255,255,0.6); text-decoration: none; font-size: 0.9rem;">Fret
                            Aérien</a></li>
                    <li><a href="#"
                            style="color: rgba(255,255,255,0.6); text-decoration: none; font-size: 0.9rem;">Transport
                            Maritime</a></li>
                    <li><a href="#"
                            style="color: rgba(255,255,255,0.6); text-decoration: none; font-size: 0.9rem;">Logistique
                            Routière</a></li>
                </ul>
            </div>
            <div>
                <h4 style="margin-bottom: 1.5rem; font-family: var(--font-heading);">Compagnie</h4>
                <ul style="list-style: none; display: flex; flex-direction: column; gap: 0.8rem;">
                    <li><a href="/transit/about"
                            style="color: rgba(255,255,255,0.6); text-decoration: none; font-size: 0.9rem;">À Propos</a>
                    </li>
                    <li><a href="#" style="color: rgba(255,255,255,0.6); text-decoration: none; font-size: 0.9rem;">Nos
                            Partenaires</a></li>
                    <li><a href="#"
                            style="color: rgba(255,255,255,0.6); text-decoration: none; font-size: 0.9rem;">Contact</a>
                    </li>
                </ul>
            </div>
            <div>
                <h4 style="margin-bottom: 1.5rem; font-family: var(--font-heading);">Légal</h4>
                <ul style="list-style: none; display: flex; flex-direction: column; gap: 0.8rem;">
                    <li><a href="#"
                            style="color: rgba(255,255,255,0.6); text-decoration: none; font-size: 0.9rem;">Mentions
                            Légales</a></li>
                    <li><a href="#"
                            style="color: rgba(255,255,255,0.6); text-decoration: none; font-size: 0.9rem;">Confidentialité</a>
                    </li>
                </ul>
            </div>
        </div>
        <div style="text-align: center; color: rgba(255,255,255,0.4); font-size: 0.85rem;">
            <p>&copy; 2026 TransitPro Global Logistics — Tous droits réservés.</p>
        </div>
    </footer>

    <!-- Bouton Retour en Haut -->
    <button id="backToTop" onclick="window.scrollTo({top: 0, behavior: 'smooth'})" title="Retour en haut"
        style="position: fixed; bottom: 40px; right: 40px; width: 52px; height: 52px; border-radius: 50%; background: linear-gradient(135deg, #0458e0, #06b6d4); color: #ffffff; border: none; cursor: pointer; font-size: 1.3rem; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 25px rgba(4, 88, 224, 0.4); opacity: 0; transform: translateY(20px); transition: opacity 0.3s ease, transform 0.3s ease; z-index: 9999; pointer-events: none;">↑</button>

    <script>
        const backToTopBtn = document.getElementById('backToTop');
        window.addEventListener('scroll', function () {
            const nav = document.querySelector('.landing-top-nav');
            if (window.scrollY > 50) {
                nav.classList.add('scrolled');
            } else {
                nav.classList.remove('scrolled');
            }
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
    </script>
</body>

</html>
</body>

</html>