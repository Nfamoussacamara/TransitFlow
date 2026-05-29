<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contactez-nous — TransitPro Global Logistics</title>

    <!-- Meta SEO -->
    <meta name="description"
        content="Contactez les experts de TransitPro pour vos besoins en logistique, transit international et suivi de marchandises. Nous sommes à votre écoute à Conakry et partout dans le monde.">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Outfit:wght@500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="/transit/public/css/style.css">

    <style>
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
            transition: 0.3s ease;
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
            transition: 0.3s ease;
        }

        .contact-hero {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            padding: 160px 5% 100px;
            color: #ffffff;
            text-align: center;
        }

        .section-tag {
            display: inline-block;
            background: rgba(4, 88, 224, 0.1);
            color: #0458e0;
            padding: 0.5rem 1.2rem;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 1.5rem;
        }

        .contact-grid {
            display: grid;
            grid-template-columns: 1fr 1.5fr;
            gap: 60px;
            max-width: 1200px;
            margin: 80px auto 100px;
            padding: 0 5%;
            position: relative;
            z-index: 10;
        }

        .contact-info-card {
            background: #ffffff;
            padding: 50px;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
        }

        .contact-form-card {
            background: #ffffff;
            padding: 50px;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
        }

        .info-item {
            display: flex;
            gap: 20px;
            margin-bottom: 40px;
        }

        .info-icon {
            width: 50px;
            height: 50px;
            background: #f1f5f9;
            color: #0458e0;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            font-size: 1.2rem;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-label {
            display: block;
            margin-bottom: 10px;
            font-weight: 600;
            color: #0f172a;
            font-size: 0.95rem;
        }

        .form-input {
            width: 100%;
            padding: 15px 20px;
            border-radius: 12px;
            border: 2px solid #f1f5f9;
            font-family: inherit;
            font-size: 1rem;
            transition: all 0.3s ease;
            box-sizing: border-box;
        }

        .form-input:focus {
            border-color: #0458e0;
            outline: none;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(4, 88, 224, 0.1);
        }

        .btn-submit {
            background: #0458e0;
            color: #ffffff;
            width: 100%;
            padding: 1.2rem;
            border-radius: 12px;
            border: none;
            font-family: var(--font-heading);
            font-weight: 700;
            font-size: 1.1rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-submit:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(4, 88, 224, 0.3);
            background: #0346b5;
        }

        @media (max-width: 968px) {
            .contact-grid {
                grid-template-columns: 1fr;
                margin-top: 40px;
            }
        }
    </style>
</head>

<body>

    <nav class="landing-top-nav">
        <a href="/transit/" class="landing-logo">
            TRANSIT<span class="accent">PRO</span>
        </a>
        <div class="nav-links">
            <a href="/transit/" class="nav-link">Accueil</a>
            <a href="/transit/about" class="nav-link">À Propos</a>
            <a href="/transit/contact" class="nav-link">Contact</a>
        </div>
        <div style="display: flex; justify-content: flex-end;">
            <a href="/transit/login" class="btn-login-white">Connexion</a>
        </div>
    </nav>

    <header style="min-height: 50vh; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; padding: 150px 5% 100px; background-image: linear-gradient(135deg, rgba(15, 23, 42, 0.85) 0%, rgba(15, 23, 42, 0.7) 100%), url('/transit/public/images/vitaly-gariev-lKEoyOfs0OM-unsplash.jpg'); background-size: cover; background-position: center; color: #ffffff;">
        <span class="section-tag" style="background: rgba(255,255,255,0.1); color: #ffffff;">Contactez nos
            experts</span>
        <h1
            style="font-family: var(--font-heading); font-size: clamp(2.5rem, 5vw, 4rem); font-weight: 800; margin-bottom: 1.5rem; letter-spacing: -2px;">
            À votre écoute, partout.</h1>
        <p style="font-size: 1.2rem; color: rgba(255,255,255,0.7); max-width: 600px; margin: 0 auto;">Questions sur un
            transit ? Devis personnalisé ? Nos équipes de Conakry sont disponibles 24/7 pour vous accompagner.</p>
    </header>

    <main class="contact-grid">
        <!-- Info Card -->
        <div class="contact-info-card">
            <h2
                style="font-family: var(--font-heading); font-size: 1.8rem; font-weight: 800; color: #0f172a; margin-bottom: 40px;">
                Nos coordonnées</h2>

            <div class="info-item">
                <div class="info-icon">📍</div>
                <div>
                    <h4 style="margin: 0 0 5px; color: #0f172a;">Siège Social</h4>
                    <p style="margin: 0; color: #64748b; line-height: 1.5;">Immeuble TransitPro, Kaloum<br>Conakry,
                        République de Guinée</p>
                </div>
            </div>

            <div class="info-item">
                <div class="info-icon">📞</div>
                <div>
                    <h4 style="margin: 0 0 5px; color: #0f172a;">Téléphone</h4>
                    <p style="margin: 0; color: #64748b;">+224 629 26 00 73</p>
                </div>
            </div>

            <div class="info-item">
                <div class="info-icon">📧</div>
                <div>
                    <h4 style="margin: 0 0 5px; color: #0f172a;">E-mail</h4>
                    <p style="margin: 0; color: #64748b;">camaranfamoussa199@gmail.com</p>
                </div>
            </div>

            <div class="info-item" style="margin-bottom: 0;">
                <div class="info-icon">🕒</div>
                <div>
                    <h4 style="margin: 0 0 5px; color: #0f172a;">Heures d'ouverture</h4>
                    <p style="margin: 0; color: #64748b;">Lun - Ven : 08h00 - 18h00</p>
                    <p style="margin: 0; color: #64748b;">Sam : 09h00 - 13h00</p>
                </div>
            </div>
        </div>

        <!-- Form Card -->
        <div class="contact-form-card">
            <h2
                style="font-family: var(--font-heading); font-size: 1.8rem; font-weight: 800; color: #0f172a; margin-bottom: 30px;">
                Envoyez un message</h2>
            <form action="#" method="POST">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div class="form-group">
                        <label class="form-label">Nom complet</label>
                        <input type="text" class="form-input" placeholder="Ex: n'famoussa camara" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">E-mail</label>
                        <input type="email" class="form-input" placeholder="camaranfamoussa199@gmail.com" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Objet</label>
                    <input type="text" class="form-input" placeholder="Sujet de votre message" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Message</label>
                    <textarea class="form-input" style="min-height: 150px; resize: vertical;"
                        placeholder="Comment pouvons-nous vous aider ?" required></textarea>
                </div>
                <button type="submit" class="btn-submit">Envoyer le message</button>
            </form>
        </div>
    </main>

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
                <ul style="list-style: none; display: flex; flex-direction: column; gap: 0.8rem; padding: 0;">
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
                <ul style="list-style: none; display: flex; flex-direction: column; gap: 0.8rem; padding: 0;">
                    <li><a href="/transit/about"
                            style="color: rgba(255,255,255,0.6); text-decoration: none; font-size: 0.9rem;">À Propos</a>
                    </li>
                    <li><a href="/transit/contact"
                            style="color: rgba(255,255,255,0.6); text-decoration: none; font-size: 0.9rem;">Contact</a>
                    </li>
                </ul>
            </div>
            <div>
                <h4 style="margin-bottom: 1.5rem; font-family: var(--font-heading);">Légal</h4>
                <ul style="list-style: none; display: flex; flex-direction: column; gap: 0.8rem; padding: 0;">
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

    <script>
        window.addEventListener('scroll', function () {
            const nav = document.querySelector('.landing-top-nav');
            if (window.scrollY > 50) {
                nav.classList.add('scrolled');
            } else {
                nav.classList.remove('scrolled');
            }
        });
    </script>
</body>

</html>