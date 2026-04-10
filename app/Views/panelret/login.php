<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="<?=BASE_URL?>assets/images/favicon.ico" type="image/x-icon">

    <title>Registro Estatal de Turismo del Estado de Guanajuato</title>

    <link href="<?=BASE_URL?>assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?=BASE_URL?>assets/css/metisMenu.min.css" rel="stylesheet">
    <link href="<?=BASE_URL?>assets/css/sb-admin-2.css" rel="stylesheet">
    <link href="<?=BASE_URL?>assets/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <script type="text/javascript" src="https://www.google.com/recaptcha/api.js?render=<?=SITE_KEY?>"></script>
    <style>
        @font-face {
            font-family: 'Aller';
            src: url('<?=BASE_URL?>assets/fonts/Aller_Rg.ttf') format('truetype');
            font-weight: 400;
        }

        @font-face {
            font-family: 'Aller';
            src: url('<?=BASE_URL?>assets/fonts/AllerDisplay.ttf') format('truetype');
            font-weight: 700;
        }

        :root {
            --brand: #0f766e;
            --brand-dark: #0b4f4a;
            --text: #16323d;
            --muted: #607380;
            --surface: rgba(255, 255, 255, 0.92);
            --border: rgba(15, 118, 110, 0.12);
            --danger: #b91c1c;
            --success: #0f766e;
        }

        * {
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            margin: 0;
            font-family: 'Aller', 'Helvetica Neue', Arial, sans-serif;
            color: var(--text);
            background:
                radial-gradient(circle at top left, rgba(245, 158, 11, 0.32), transparent 34%),
                radial-gradient(circle at 85% 18%, rgba(15, 118, 110, 0.25), transparent 28%),
                linear-gradient(135deg, #f4f7f5 0%, #dcefe9 45%, #eef6f3 100%);
        }

        .auth-shell {
            position: relative;
            min-height: 100vh;
            overflow: hidden;
            padding: 28px 14px;
        }

        .auth-shell:before,
        .auth-shell:after {
            content: '';
            position: absolute;
            border-radius: 999px;
            filter: blur(4px);
            opacity: 0.55;
            z-index: 0;
        }

        .auth-shell:before {
            width: 340px;
            height: 340px;
            background: rgba(245, 158, 11, 0.16);
            top: -80px;
            left: -90px;
        }

        .auth-shell:after {
            width: 420px;
            height: 420px;
            background: rgba(15, 118, 110, 0.12);
            right: -120px;
            bottom: -120px;
        }

        .auth-stage {
            position: relative;
            z-index: 1;
            max-width: 1040px;
            margin: 0 auto;
            min-height: calc(100vh - 56px);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .auth-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.05fr) minmax(360px, 0.95fr);
            width: 100%;
            border-radius: 28px;
            overflow: hidden;
            box-shadow: 0 28px 60px rgba(22, 50, 61, 0.16);
            background: rgba(255, 255, 255, 0.52);
            backdrop-filter: blur(14px);
        }

        .auth-hero {
            position: relative;
            padding: 52px 48px;
            background:
                linear-gradient(160deg, rgba(11, 79, 74, 0.96), rgba(15, 118, 110, 0.92)),
                url('<?=BASE_URL?>static/images/Banner_pagina_web.jpeg');
            background-size: cover;
            background-position: center;
            color: #fff;
        }

        .auth-hero:before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(6, 38, 36, 0.16), rgba(6, 38, 36, 0.38));
        }

        .auth-hero-content {
            position: relative;
            z-index: 1;
            max-width: 460px;
        }

        .auth-chip {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 14px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.14);
            border: 1px solid rgba(255, 255, 255, 0.18);
            font-size: 12px;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .auth-title {
            margin: 22px 0 14px;
            font-size: 40px;
            line-height: 1.08;
            font-weight: 700;
        }

        .auth-copy {
            margin: 0;
            font-size: 17px;
            line-height: 1.7;
            color: rgba(255, 255, 255, 0.88);
        }

        .auth-points {
            margin: 30px 0 0;
            padding: 0;
            list-style: none;
        }

        .auth-points li {
            position: relative;
            margin-bottom: 14px;
            padding-left: 26px;
            font-size: 15px;
            color: rgba(255, 255, 255, 0.9);
        }

        .auth-points li:before {
            content: '';
            position: absolute;
            left: 0;
            top: 8px;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #fbbf24;
            box-shadow: 0 0 0 5px rgba(251, 191, 36, 0.18);
        }

        .auth-card {
            padding: 42px 38px 34px;
            background: var(--surface);
        }

        .brand-lockup {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 26px;
        }

        .brand-lockup img {
            width: 74px;
            height: auto;
        }

        .brand-lockup small {
            display: block;
            color: var(--muted);
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-bottom: 4px;
        }

        .brand-lockup strong {
            display: block;
            font-size: 20px;
            line-height: 1.25;
        }

        .auth-card h1 {
            margin: 0 0 8px;
            font-size: 30px;
            font-weight: 700;
            color: var(--brand-dark);
        }

        .lead-copy {
            margin: 0 0 28px;
            color: var(--muted);
            line-height: 1.6;
        }

        .status-box {
            display: none;
            margin-bottom: 18px;
            padding: 13px 15px;
            border-radius: 14px;
            font-size: 14px;
            line-height: 1.5;
        }

        .status-box.is-visible {
            display: block;
        }

        .status-error {
            background: rgba(185, 28, 28, 0.08);
            color: var(--danger);
            border: 1px solid rgba(185, 28, 28, 0.12);
        }

        .status-info {
            background: rgba(15, 118, 110, 0.08);
            color: var(--success);
            border: 1px solid rgba(15, 118, 110, 0.12);
        }

        .form-group {
            margin-bottom: 18px;
        }

        .field-label {
            display: block;
            margin-bottom: 8px;
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            color: var(--brand-dark);
        }

        .input-wrap {
            position: relative;
        }

        .input-icon {
            position: absolute;
            top: 50%;
            left: 16px;
            transform: translateY(-50%);
            color: #7c8f99;
            font-size: 16px;
        }

        .auth-input {
            height: 54px;
            padding: 14px 16px 14px 46px;
            border-radius: 16px;
            border: 1px solid var(--border);
            background: rgba(255, 255, 255, 0.92);
            box-shadow: none;
            font-size: 15px;
            transition: border-color 0.2s ease, box-shadow 0.2s ease, transform 0.2s ease;
        }

        .auth-input:focus {
            border-color: rgba(15, 118, 110, 0.55);
            box-shadow: 0 0 0 4px rgba(15, 118, 110, 0.12);
            transform: translateY(-1px);
        }

        .auth-actions {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            margin-top: 8px;
            margin-bottom: 20px;
        }

        .auth-link {
            color: var(--brand);
            font-size: 14px;
            font-weight: 700;
            text-decoration: none;
        }

        .auth-link:hover,
        .auth-link:focus {
            color: var(--brand-dark);
            text-decoration: none;
        }

        .auth-hint {
            margin: 0;
            color: var(--muted);
            font-size: 13px;
            line-height: 1.5;
        }

        .btn-login {
            position: relative;
            width: 100%;
            min-height: 56px;
            border: 0;
            border-radius: 18px;
            background: linear-gradient(135deg, #0f766e 0%, #12867d 55%, #0b4f4a 100%);
            color: #fff;
            font-size: 16px;
            font-weight: 700;
            letter-spacing: 0.02em;
            box-shadow: 0 18px 28px rgba(15, 118, 110, 0.22);
            transition: transform 0.2s ease, box-shadow 0.2s ease, opacity 0.2s ease;
        }

        .btn-login:hover,
        .btn-login:focus {
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 22px 32px rgba(15, 118, 110, 0.26);
        }

        .btn-login[disabled] {
            opacity: 0.92;
            cursor: wait;
            transform: none;
        }

        .btn-label,
        .btn-loading {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-loading {
            display: none;
        }

        .btn-login.is-loading .btn-label {
            display: none;
        }

        .btn-login.is-loading .btn-loading {
            display: inline-flex;
        }

        .spinner-dot {
            width: 18px;
            height: 18px;
            border-radius: 50%;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-top-color: #fff;
            animation: spin 0.7s linear infinite;
        }

        .auth-note {
            margin-top: 16px;
            font-size: 13px;
            color: var(--muted);
            text-align: center;
        }

        .auth-subtle-actions {
            margin-top: 18px;
            text-align: center;
        }

        .auth-back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 14px;
            border-radius: 999px;
            color: var(--muted);
            text-decoration: none;
            font-size: 13px;
            font-weight: 700;
            background: rgba(255, 255, 255, 0.7);
            border: 1px solid rgba(15, 118, 110, 0.12);
            transition: background 0.2s ease, color 0.2s ease, border-color 0.2s ease;
        }

        .auth-back-link:hover,
        .auth-back-link:focus {
            color: var(--brand-dark);
            text-decoration: none;
            background: rgba(15, 118, 110, 0.08);
            border-color: rgba(15, 118, 110, 0.22);
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        @media (max-width: 991px) {
            .auth-grid {
                grid-template-columns: 1fr;
            }

            .auth-hero,
            .auth-card {
                padding: 32px 24px;
            }

            .auth-title {
                font-size: 32px;
            }
        }

        @media (max-width: 575px) {
            .auth-shell {
                padding: 12px;
            }

            .auth-stage {
                min-height: auto;
            }

            .auth-grid {
                border-radius: 22px;
            }

            .auth-card h1 {
                font-size: 26px;
            }

            .auth-actions {
                display: block;
            }

            .auth-link {
                display: inline-block;
                margin-bottom: 8px;
            }
        }
    </style>
</head>

<body>
    <div class="auth-shell">
        <div class="auth-stage">
            <div class="auth-grid">
                <section class="auth-hero">
                    <div class="auth-hero-content">
                        <span class="auth-chip">
                            <i class="fa fa-shield"></i>
                            Acceso administrativo
                        </span>
                        <h2 class="auth-title">Panel de control del Registro Estatal de Turismo</h2>
                        <p class="auth-copy">
                            Ingresa para administrar solicitudes, revisar avances y dar seguimiento a los registros de manera mas clara y segura.
                        </p>
                        <ul class="auth-points">
                            <li>Acceso rapido a la operacion diaria del panel.</li>
                            <li>Experiencia de inicio mas clara mientras se valida el acceso.</li>
                            <li>Mensajes de apoyo para que la espera no se sienta detenida.</li>
                        </ul>
                    </div>
                </section>

                <section class="auth-card">
                    <div class="brand-lockup">
                        <img src="<?=BASE_URL?>assets/images/logo_ret.png" alt="Logo RET">
                        <div>
                            <small>Gobierno del Estado de Guanajuato</small>
                            <strong>Registro Estatal de Turismo</strong>
                        </div>
                    </div>

                    <h1>Bienvenido</h1>
                    <p class="lead-copy">Captura tus credenciales para entrar al panel. Cuando el acceso tarde unos segundos, te mostraremos el progreso para que el proceso se sienta acompanado.</p>

                    <div id="login-status" class="status-box" aria-live="polite"></div>

                    <form id="login_form" role="form" method="post" action="<?=BASE_URL?>panelauth/login/" novalidate>
                        <fieldset>
                            <div class="form-group">
                                <label class="field-label" for="email">Correo institucional</label>
                                <div class="input-wrap">
                                    <span class="input-icon"><i class="fa fa-envelope-o"></i></span>
                                    <input type="email" class="form-control auth-input" id="email" placeholder="correo@guanajuato.gob.mx" name="clave" style="text-transform: lowercase;" required autofocus autocomplete="username">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="field-label" for="password">Contrasena</label>
                                <div class="input-wrap">
                                    <span class="input-icon"><i class="fa fa-lock"></i></span>
                                    <input class="form-control auth-input" id="password" placeholder="Escribe tu contrasena" name="pass" type="password" value="" required autocomplete="current-password">
                                </div>
                            </div>

                            <div class="auth-actions">
                                <a class="auth-link" href="#" id="forgot-password-link">Olvide mi contrasena</a>
                                <p class="auth-hint">Tu acceso se valida con reCAPTCHA antes de entrar.</p>
                            </div>

                            <button id="login-submit" type="submit" class="btn btn-login">
                                <span class="btn-label">
                                    <i class="fa fa-sign-in"></i>
                                    Ingresar al panel
                                </span>
                                <span class="btn-loading">
                                    <span class="spinner-dot" aria-hidden="true"></span>
                                    Validando acceso...
                                </span>
                            </button>
                        </fieldset>
                    </form>

                    <p class="auth-note">Si el acceso tarda un poco, no cierres la ventana. El sistema esta verificando tus datos y preparando el panel.</p>
                    <div class="auth-subtle-actions">
                        <a href="<?=BASE_URL?>" class="auth-back-link">
                            <i class="fa fa-arrow-left"></i>
                            Regresar al sitio
                        </a>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <script src="<?=BASE_URL?>assets/js/jquery.min.js"></script>
    <script src="<?=BASE_URL?>assets/js/bootstrap.min.js"></script>
    <script src="<?=BASE_URL?>assets/js/metisMenu.min.js"></script>
    <script src="<?=BASE_URL?>assets/js/sb-admin-2.js"></script>

    <script>
        (function() {
            var form = $('#login_form');
            var submitButton = $('#login-submit');
            var statusBox = $('#login-status');
            var forgotPasswordLink = $('#forgot-password-link');

            function setStatus(message, type) {
                statusBox
                    .removeClass('status-error status-info is-visible')
                    .addClass('is-visible status-' + type)
                    .html(message);
            }

            function clearStatus() {
                statusBox.removeClass('status-error status-info is-visible').empty();
            }

            function setLoading(isLoading, message) {
                submitButton.prop('disabled', isLoading).toggleClass('is-loading', isLoading);

                if (isLoading && message) {
                    setStatus(message, 'info');
                }
            }

            function resolveErrorMessage(code) {
                if (code === 'validation') {
                    return 'Completa tu correo y contrasena antes de continuar.';
                }

                if (code === 'captcha') {
                    return 'No se pudo validar la seguridad del acceso. Intenta nuevamente.';
                }

                if (code === 'system') {
                    return 'El correo o la contrasena no son correctos.';
                }

                return 'No fue posible ingresar en este momento. Intenta nuevamente.';
            }

            forgotPasswordLink.on('click', function(event) {
                event.preventDefault();
                setStatus('Para restablecer tu contrasena, por favor contacta al administrador del sistema.', 'info');
            });

            form.on('submit', function(event) {
                event.preventDefault();

                var clave = $.trim($('#email').val());
                var passw = $('#password').val();

                clearStatus();

                if (!clave || !passw) {
                    setStatus('Necesitas capturar tu correo institucional y tu contrasena.', 'error');
                    return;
                }

                setLoading(true, 'Estamos validando tus credenciales y preparando tu acceso. Esto puede tardar unos segundos.');

                grecaptcha.ready(function() {
                    grecaptcha.execute('<?=SITE_KEY?>', { action: 'submit' }).then(function(token) {
                        $.post('<?=BASE_URL?>panelauth/login', { clave: clave, pass: passw, token: token }, function(result) {
                            if (result.alert) {
                                setStatus('Acceso correcto. Estamos entrando al panel...', 'info');
                                window.setTimeout(function() {
                                    window.location = '<?=BASE_URL?>paneldash';
                                }, 350);
                                return;
                            }

                            setLoading(false);
                            setStatus(resolveErrorMessage(result.msg), 'error');
                        }).fail(function() {
                            setLoading(false);
                            setStatus('No pudimos conectar con el servidor. Revisa tu conexion e intenta de nuevo.', 'error');
                        });
                    }).catch(function() {
                        setLoading(false);
                        setStatus('Ocurrio un problema al generar la validacion de seguridad. Intenta nuevamente.', 'error');
                    });
                });
            });
        })();
    </script>
</body>

</html>

