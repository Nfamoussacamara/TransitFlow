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
            display: flex;
            align-items: center;
        }

        .form-input {
            width: 100%;
            padding: 0.85rem 1.25rem;
            border: 1px solid rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            background: #f8fafc;
            font-family: var(--font-body);
            font-size: 0.95rem;
            color: var(--color-text-dark);
            transition: var(--transition-smooth);
        }

        .form-input-password {
            padding-right: 2.75rem !important;
        }

        .password-toggle {
            position: absolute;
            right: 14px;
            background: none;
            border: none;
            color: var(--color-text-muted);
            cursor: pointer;
            display: flex;
            align-items: center;
            padding: 0;
            transition: var(--transition-smooth);
        }

        .password-toggle:hover {
            color: rgb(var(--color-brand-royal));
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

                <?php
                // Messages d'erreur lisibles
                $errorMessages = [
                    '1'              => 'Identifiant ou mot de passe incorrect.',
                    'email_vide'     => 'Veuillez saisir votre adresse e-mail.',
                    'email_inconnu'  => 'Aucune marchandise enregistrée pour cet e-mail.',
                    'deja_actif'     => 'Un compte existe déjà pour cet e-mail. Connectez-vous normalement.',
                    'mdp_diff'       => 'Les mots de passe ne correspondent pas.',
                    'champs_manquants' => 'Veuillez remplir tous les champs.',
                ];
                $errorMsg = $errorMessages[$error] ?? ($error !== '' ? htmlspecialchars($error) : '');
                ?>
                <?php if ($errorMsg !== ''): ?>
                    <div class="login-error">
                        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="8" x2="12" y2="12"></line>
                            <line x1="12" y1="16" x2="12.01" y2="16"></line>
                        </svg>
                        <span><?= $errorMsg ?></span>
                    </div>
                <?php endif; ?>

                <?php if ($step === 'set_password'): ?>
                    <!-- ÉTAPE 2 : Définir le mot de passe -->
                    <div class="login-header">
                        <h2>Créer votre mot de passe</h2>
                        <p>Compte pour : <strong><?= htmlspecialchars($email) ?></strong></p>
                    </div>
                    <form class="login-form" action="/transit/login?action=activate" method="POST">
                        <input type="hidden" name="email" value="<?= htmlspecialchars($email) ?>">
                        <div class="form-group">
                            <label class="form-label" for="password">Nouveau mot de passe</label>
                            <div class="form-input-wrapper">
                                <input class="form-input form-input-password" type="password" id="password" name="password" placeholder="Minimum 6 caractères" required>
                                <button type="button" class="password-toggle" onclick="togglePasswordVisibility('password', this)">
                                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="password_confirm">Confirmer le mot de passe</label>
                            <div class="form-input-wrapper">
                                <input class="form-input form-input-password" type="password" id="password_confirm" name="password_confirm" placeholder="••••••••" required>
                                <button type="button" class="password-toggle" onclick="togglePasswordVisibility('password_confirm', this)">
                                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <button class="btn-login" type="submit">
                            <span>Activer mon compte</span>
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <polyline points="20 6 9 17 4 12"></polyline>
                            </svg>
                        </button>
                    </form>
                    <div style="text-align:center;margin-top:1rem;">
                        <a href="/transit/login" style="font-size:.8rem;color:#64748b;">← Retour à la connexion</a>
                    </div>

                <?php elseif ($step === 'activate'): ?>
                    <!-- ÉTAPE 1 : Saisir l'email pour l'activation -->
                    <div class="login-header">
                        <h2>Première connexion</h2>
                        <p>Saisissez l'e-mail utilisé lors de l'enregistrement de vos marchandises.</p>
                    </div>
                    <form class="login-form" action="/transit/login?action=check_email" method="POST">
                        <div class="form-group">
                            <label class="form-label" for="email">Votre adresse e-mail</label>
                            <div class="form-input-wrapper">
                                <input class="form-input" type="email" id="email" name="email" placeholder="votre@email.com" required autofocus>
                            </div>
                        </div>
                        <button class="btn-login" type="submit">
                            <span>Vérifier mon e-mail</span>
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                                <polyline points="12 5 19 12 12 19"></polyline>
                            </svg>
                        </button>
                    </form>
                    <div style="text-align:center;margin-top:1rem;">
                        <a href="/transit/login" style="font-size:.8rem;color:#64748b;">← Retour à la connexion</a>
                    </div>

                <?php else: ?>
                    <!-- ÉTAPE 0 : Connexion standard (admin ou client déjà actif) -->
                    <div class="login-header">
                        <h2>Espace Logistique</h2>
                        <p>Connectez-vous pour accéder à votre tableau de bord</p>
                    </div>
                    <form class="login-form" action="/transit/login" method="POST">
                        <div class="form-group">
                            <label class="form-label" for="username">Identifiant</label>
                            <div class="form-input-wrapper">
                                <input class="form-input" type="text" id="username" name="username" placeholder="Identifiant ou e-mail" required autofocus autocomplete="username">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="password">Mot de passe</label>
                            <div class="form-input-wrapper">
                                <input class="form-input form-input-password" type="password" id="password" name="password" placeholder="••••••••" required autocomplete="current-password">
                                <button type="button" class="password-toggle" onclick="togglePasswordVisibility('password', this)">
                                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                </button>
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

                    <!-- Lien première connexion client -->
                    <div style="text-align:center;margin-top:1.5rem;padding-top:1rem;border-top:1px solid #e2e8f0;">
                        <p style="font-size:.8rem;color:#94a3b8;margin-bottom:.5rem;">Client ? Première visite ?</p>
                        <a href="/transit/login?step=activate"
                           style="font-size:.85rem;font-weight:600;color:#0458e0;text-decoration:none;">
                            ⭐ Activer mon espace client
                        </a>
                    </div>
                <?php endif; ?>

                <div class="login-footer">
                    <p>&copy; <?= date('Y') ?> TransitPro. Tous droits réservés.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Script de visibilité de mot de passe -->
    <script>
        function togglePasswordVisibility(inputId, button) {
            const input = document.getElementById(inputId);
            if (input.type === "password") {
                input.type = "text";
                button.innerHTML = `
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                        <line x1="1" y1="1" x2="23" y2="23"></line>
                    </svg>
                `;
            } else {
                input.type = "password";
                button.innerHTML = `
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                        <circle cx="12" cy="12" r="3"></circle>
                    </svg>
                `;
            }
        }
    </script>

</body>
</html>
