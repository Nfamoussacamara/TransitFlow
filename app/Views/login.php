<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TransitPro - Connexion</title>
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Outfit:wght@500;600;700;800&display=swap">
    <!-- Style global -->
    <link rel="stylesheet" href="public/css/style.css?v=2.9">
    <style>
        /* Remise à zéro et plein écran complet */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body.login-body {
            width: 100vw;
            height: 100vh;
            min-height: 100vh;
            overflow: hidden;
            font-family: 'Inter', sans-serif;
            background: #ffffff;
        }

        /* Conteneur principal de type Split Panel prenant tout l'écran */
        .login-container {
            display: flex;
            width: 100vw;
            height: 100vh;
            overflow: hidden;
        }

        /* Panneau de gauche (Image & Slogan) en Plein Écran */
        .login-panel-left {
            flex: 1.3;
            position: relative;
            background: url('public/images/login_backdrop.jpg') no-repeat center center;
            background-size: cover;
            display: flex;
            align-items: flex-end;
            padding: 5rem 4.5rem;
            color: #ffffff;
            overflow: hidden;
        }

        /* Overlay dégradé de haute qualité sur le panneau gauche pour la lisibilité */
        .panel-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(4, 88, 224, 0.8) 0%, rgba(99, 102, 241, 0.85) 50%, rgba(6, 182, 212, 0.9) 100%);
            mix-blend-mode: multiply;
            z-index: 1;
        }

        /* Effet d'ombrage progressif pour donner de la profondeur */
        .login-panel-left::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to top, rgba(15, 23, 42, 0.95) 0%, rgba(15, 23, 42, 0.1) 70%);
            z-index: 2;
        }

        .panel-content {
            position: relative;
            z-index: 10;
            max-width: 520px;
        }

        .brand-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.25);
            padding: 6px 14px;
            border-radius: 100px;
            font-family: var(--font-heading);
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 1.75rem;
        }

        .brand-badge svg {
            width: 16px;
            height: 16px;
        }

        .panel-content h1 {
            font-family: var(--font-heading);
            font-size: 2.6rem;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 1.25rem;
            letter-spacing: -1px;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
        }

        .panel-content p {
            font-family: var(--font-body);
            font-size: 1rem;
            line-height: 1.6;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 2.5rem;
        }

        .feature-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }

        .tag {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 6px 14px;
            border-radius: 8px;
            font-family: var(--font-body);
            font-size: 0.85rem;
            font-weight: 500;
            backdrop-filter: blur(4px);
        }

        .tag-dot {
            width: 6px;
            height: 6px;
            background: rgb(6, 182, 212);
            border-radius: 50%;
            display: inline-block;
        }

        /* Panneau de droite (Formulaire) prenant le reste de l'écran */
        .login-panel-right {
            flex: 0.9;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 4rem;
            background: #ffffff;
            position: relative;
        }

        .login-form-container {
            width: 100%;
            max-width: 380px;
        }

        .login-logo-container {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 2.5rem;
            text-decoration: none;
        }

        .login-logo-mark {
            width: 44px;
            height: 44px;
            background: rgb(var(--color-brand-royal));
            color: #ffffff;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(4, 88, 224, 0.3);
        }

        .login-logo-text {
            font-family: var(--font-heading);
            font-size: 1.75rem;
            font-weight: 800;
            color: var(--color-text-dark);
            letter-spacing: -0.5px;
        }

        .login-logo-text .text-accent {
            color: rgb(var(--color-brand-royal));
        }

        .login-header {
            text-align: left;
            margin-bottom: 2.25rem;
            width: 100%;
        }

        .login-header h2 {
            font-family: var(--font-heading);
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--color-text-dark);
            margin-bottom: 0.5rem;
        }

        .login-header p {
            font-family: var(--font-body);
            font-size: 0.9rem;
            color: var(--color-text-muted);
        }

        /* Formulaire de connexion */
        .login-form {
            width: 100%;
        }

        .form-group {
            margin-bottom: 1.5rem;
            width: 100%;
        }

        .form-label {
            display: block;
            font-family: var(--font-heading);
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--color-text-dark);
            margin-bottom: 0.5rem;
        }

        .form-input-wrapper {
            position: relative;
        }

        .form-input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--color-text-muted);
            pointer-events: none;
            display: flex;
            align-items: center;
        }

        .form-input {
            width: 100%;
            padding: 0.85rem 1rem 0.85rem 2.75rem;
            border: 1px solid rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            background: #f8fafc;
            font-family: var(--font-body);
            font-size: 0.95rem;
            color: var(--color-text-dark);
            transition: var(--transition-smooth);
        }

        .form-input:focus {
            outline: none;
            border-color: rgb(var(--color-brand-royal));
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(4, 88, 224, 0.12);
        }

        .btn-login {
            width: 100%;
            padding: 0.9rem;
            background: rgb(var(--color-brand-royal));
            color: #ffffff;
            border: none;
            border-radius: 10px;
            font-family: var(--font-heading);
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: var(--transition-smooth);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-top: 2rem;
            box-shadow: 0 4px 14px rgba(4, 88, 224, 0.25);
        }

        .btn-login:hover {
            background: rgba(var(--color-brand-royal), 0.9);
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(4, 88, 224, 0.35);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        /* Erreurs de connexion */
        .login-error {
            background: rgba(239, 68, 68, 0.08);
            border: 1px solid rgba(239, 68, 68, 0.18);
            color: #dc2626;
            padding: 0.85rem 1.1rem;
            border-radius: 10px;
            font-family: var(--font-body);
            font-size: 0.875rem;
            margin-bottom: 1.75rem;
            width: 100%;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .login-error svg {
            flex-shrink: 0;
        }

        /* Footer */
        .login-footer {
            margin-top: 2.5rem;
            font-family: var(--font-body);
            font-size: 0.75rem;
            color: var(--color-text-muted);
            text-align: left;
        }

        /* Adaptabilité Responsive */
        @media (max-width: 992px) {
            .login-panel-left {
                padding: 4rem 3rem;
            }
            .panel-content h1 {
                font-size: 2.2rem;
            }
        }

        @media (max-width: 868px) {
            .login-panel-left {
                display: none;
            }
            .login-panel-right {
                flex: 1;
                padding: 3rem 2rem;
            }
            .login-header {
                text-align: center;
            }
            .login-logo-container {
                justify-content: center;
            }
            .login-footer {
                text-align: center;
            }
        }
    </style>
</head>
<body class="login-body">

    <div class="login-container">
        <!-- Panneau de gauche : Image et Branding (Plein Écran) -->
        <div class="login-panel-left">
            <div class="panel-overlay"></div>
            <div class="panel-content">
                <div class="brand-badge">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" style="width: 16px; height: 16px;">
                        <path d="M4 15l8-8 8 8"/>
                        <path d="M4 19l8-8 8 8" opacity="0.5"/>
                    </svg>
                    <span>TransitPro Global</span>
                </div>
                <h1>Simplifiez vos flux de transit internationaux.</h1>
                <p>Une plateforme intelligente et intégrée pour le pilotage en temps réel, la facturation automatique et la gestion de vos expéditions logistiques.</p>
                <div class="feature-tags">
                    <span class="tag"><i class="tag-dot"></i> Suivi Temps Réel</span>
                    <span class="tag"><i class="tag-dot"></i> Factures Automatisées</span>
                    <span class="tag"><i class="tag-dot"></i> Multi-modal</span>
                </div>
            </div>
        </div>

        <!-- Panneau de droite : Formulaire de connexion (Plein Écran) -->
        <div class="login-panel-right">
            <div class="login-form-container">
                <!-- Logo principal -->
                <div class="login-logo-container">
                    <div class="login-logo-mark">
                        <svg viewBox="0 0 24 24" style="width: 24px; height: 24px;">
                            <path d="M4 15l8-8 8 8" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/>
                            <path d="M4 19l8-8 8 8" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" opacity="0.5"/>
                        </svg>
                    </div>
                    <span class="login-logo-text">Transit<span class="text-accent">Pro</span></span>
                </div>

                <div class="login-header">
                    <h2>Espace Logistique</h2>
                    <p>Connectez-vous pour accéder au tableau de bord</p>
                </div>

                <?php if (isset($_GET['error'])): ?>
                    <div class="login-error">
                        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="8" x2="12" y2="12"></line>
                            <line x1="12" y1="16" x2="12.01" y2="16"></line>
                        </svg>
                        <span>
                            <?php 
                            if ($_GET['error'] === '1') {
                                echo "Identifiant ou mot de passe incorrect.";
                            } else {
                                echo htmlspecialchars($_GET['error']);
                            }
                            ?>
                        </span>
                    </div>
                <?php endif; ?>

                <!-- Formulaire de Connexion -->
                <form class="login-form" action="index.php?url=login" method="POST">
                    <div class="form-group">
                        <label class="form-label" for="username">Identifiant</label>
                        <div class="form-input-wrapper">
                            <span class="form-input-icon">
                                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                            </span>
                            <input class="form-input" type="text" id="username" name="username" placeholder="Entrez votre identifiant" required autofocus autocomplete="username">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="password">Mot de passe</label>
                        <div class="form-input-wrapper">
                            <span class="form-input-icon">
                                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                    <path d="M7 11V7a5 5 0 0110 0v4"></path>
                                </svg>
                            </span>
                            <input class="form-input" type="password" id="password" name="password" placeholder="••••••••" required autocomplete="current-password">
                        </div>
                    </div>

                    <button class="btn-login" type="submit">
                        <span>Se connecter</span>
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                            <polyline points="12 5 19 12 12 19"></polyline>
                        </svg>
                    </button>
                </form>

                <div class="login-footer">
                    <p>&copy; <?= date('Y') ?> TransitPro. Tous droits réservés.</p>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
