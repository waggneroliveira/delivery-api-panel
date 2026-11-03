<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site não encontrado</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            background: #f8f9fa;
            color: #10131c;
        }

        .error-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }

        .error-content {
            max-width: 980px;
            text-align: center;
        }

        .illustration {
            position: relative;
            width: 220px;
            height: 180px;
            margin: 0 auto 35px;
        }

        .illustration-window {
            position: absolute;
            left: 25px;
            top: 20px;
            width: 170px;
            height: 125px;
            background: #fff;
            border: 2px solid #dee2e6;
            border-radius: 18px;
            box-shadow: 0 20px 45px rgba(16, 19, 28, .08);
            overflow: hidden;
        }

        .window-header {
            height: 30px;
            border-bottom: 1px solid #edf0f2;
            display: flex;
            align-items: center;
            gap: 5px;
            padding: 0 12px;
        }

        .window-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #dee2e6;
        }

        .window-body {
            height: calc(100% - 30px);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            gap: 8px;
        }

        .window-icon {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: #fff1e8;
            color: #ff7a1d;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 21px;
        }

        .window-line {
            width: 70px;
            height: 6px;
            border-radius: 10px;
            background: #e9ecef;
        }

        .window-line.small {
            width: 45px;
        }

        .magnifier {
            position: absolute;
            right: 3px;
            bottom: 12px;
            width: 72px;
            height: 72px;
            border: 10px solid #10131c;
            border-radius: 50%;
            background: #fff;
            box-shadow: 0 12px 30px rgba(16, 19, 28, .16);
        }

        .magnifier::after {
            content: "";
            position: absolute;
            width: 35px;
            height: 10px;
            background: #10131c;
            border-radius: 10px;
            right: -27px;
            bottom: -12px;
            transform: rotate(45deg);
        }

        .magnifier::before {
            content: "?";
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            font-weight: 700;
            color: #ff7a1d;
        }

        .floating-icon {
            position: absolute;
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 17px;
        }

        .floating-icon.one {
            top: 8px;
            right: 5px;
            background: #10131c;
            color: #cbff4d;
            transform: rotate(8deg);
        }

        .floating-icon.two {
            bottom: 10px;
            left: 5px;
            background: #cbff4d;
            color: #10131c;
            transform: rotate(-8deg);
        }

        .badge-error {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 7px 12px;
            border-radius: 50px;
            background: #fff1e8;
            color: #d95f0b;
            font-size: .8rem;
            font-weight: 600;
            margin-bottom: 18px;
        }

        .error-title {
            font-size: clamp(2rem, 5vw, 3rem);
            font-weight: 700;
            letter-spacing: -.04em;
            margin-bottom: 16px;
        }

        .error-description {
            max-width: 980px;
            margin: 0 auto;
            color: #6c757d;
            font-size: 1.05rem;
            line-height: 1.7;
        }

        .support-box {
            margin: 0 auto;
            max-width: 680px;
            margin-top: 30px;
            padding: 18px 20px;
            border: 1px solid #e9ecef;
            border-radius: 16px;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            text-align: start;
        }

        .support-icon {
            flex: 0 0 44px;
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: #10131c;
            color: #cbff4d;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .btn-support {
            background: #10131c;
            border-color: #10131c;
            color: #fff;
            padding: 11px 18px;
            border-radius: 10px;
            font-weight: 600;
            white-space: nowrap;
        }

        .btn-support:hover {
            background: #252936;
            border-color: #252936;
            color: #fff;
        }

        .brand {
            margin-top: 35px;
            color: #adb5bd;
            font-size: .8rem;
            font-weight: 600;
            letter-spacing: .08em;
            text-transform: uppercase;
        }

        .brand span {
            color: #ff7a1d;
        }

        @media (max-width: 575.98px) {
            .support-box {
                flex-direction: column;
                align-items: stretch;
            }

            .support-info {
                display: flex;
                align-items: center;
            }

            .btn-support {
                width: 100%;
            }
        }
    </style>
</head>

<body>

    <main class="error-wrapper">
        <div class="error-content">

            <div class="illustration">

                <div class="illustration-window">
                    <div class="window-header">
                        <span class="window-dot"></span>
                        <span class="window-dot"></span>
                        <span class="window-dot"></span>
                    </div>

                    <div class="window-body">
                        <div class="window-icon">
                            <i class="bi bi-globe2"></i>
                        </div>

                        <div class="window-line"></div>
                        <div class="window-line small"></div>
                    </div>
                </div>

                <div class="magnifier"></div>

                <div class="floating-icon one">
                    <i class="bi bi-link-45deg"></i>
                </div>

                <div class="floating-icon two">
                    <i class="bi bi-search"></i>
                </div>

            </div>

            <div class="badge-error">
                <i class="bi bi-exclamation-circle"></i>
                Domínio não encontrado
            </div>

            <h1 class="error-title">
                Este site não está cadastrado em nossa plataforma
            </h1>

            <p class="error-description">
                Não encontramos nenhum site cadastrado para este endereço em nossa plataforma. Verifique se o domínio foi digitado corretamente ou entre em contato com nosso suporte para obter mais informações.
            </p>

            <div class="support-box">

                <div class="support-info d-flex align-items-center gap-3">
                    <div class="support-icon">
                        <i class="bi bi-headset"></i>
                    </div>

                    <div>
                        <div class="fw-semibold mb-1">
                            Precisa de ajuda?
                        </div>

                        <div class="text-muted small">
                            Nossa equipe pode verificar este endereço.
                        </div>
                    </div>
                </div>

                @php
                    $mensagem = "*Plataforma WHI WEB*%0A%0AOlá! Tentei acessar um site, mas apareceu uma mensagem informando que o endereço não está disponível. Gostaria de verificar se o domínio está cadastrado e obter mais informações sobre como ativá-lo.";
                @endphp

                <a href="https://wa.me/557192768360?text={{ $mensagem }}"
                target="_blank"
                class="btn btn-support">
                    <i class="bi bi-whatsapp me-2"></i>
                    Falar com suporte
                </a>

            </div>

            <div class="brand">
                Desenvolvido pela <span><a href="https://www.whi.dev.br/" target="_blank" rel="noopener noreferrer">Agência WHI</a></span>
            </div>

        </div>
    </main>

</body>

</html>

