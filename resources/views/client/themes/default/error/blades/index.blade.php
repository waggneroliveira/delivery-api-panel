@extends($theme->core('client'))

@section('content')
    <style>
        #footer {
            display: none;
        }

        .error-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
            background: linear-gradient(135deg, #f8f9fc 0%, #ffffff 100%);
        }

        .error-content {
            width: 100%;
            max-width: 760px;
            text-align: center;
        }

        .error-icon {
            width: 110px;
            height: 110px;
            margin: 0 auto 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: rgba(255, 193, 7, 0.12);
            color: #ffc107;
            font-size: 3.2rem;
        }

        .error-number {
            margin: 0;
            font-size: clamp(7rem, 18vw, 12rem);
            line-height: .8;
            font-weight: 800;
            letter-spacing: -8px;
            color: #1f2937;
        }

        .error-title {
            margin: 30px 0 12px;
            font-size: clamp(1.6rem, 4vw, 2.4rem);
            font-weight: 700;
            color: #1f2937;
        }

        .error-description {
            max-width: 560px;
            margin: 0 auto 30px;
            color: #6b7280;
            font-size: 1.05rem;
            line-height: 1.7;
        }

        .error-button {
            min-width: 230px;
            min-height: 50px;
            padding: 13px 24px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            text-decoration: none;
            font-weight: 600;
            color: #fff;
            background: #198754;
            transition: all .25s ease;
        }

        .error-button:hover {
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(25, 135, 84, .25);
        }

        .error-button i {
            font-size: 1.2rem;
        }

        .error-help {
            margin-top: 35px;
            color: #9ca3af;
            font-size: .9rem;
        }

        @media (max-width: 576px) {
            .error-page {
                padding: 30px 18px;
            }

            .error-icon {
                width: 85px;
                height: 85px;
                font-size: 2.5rem;
                margin-bottom: 20px;
            }

            .error-number {
                letter-spacing: -5px;
            }

            .error-title {
                margin-top: 25px;
            }

            .error-description {
                font-size: .95rem;
            }

            .error-button {
                width: 100%;
                max-width: 290px;
            }
        }
    </style>

    <div class="error-page">
        <div class="error-content">

            <div class="error-icon">
                <i class="bi bi-exclamation-triangle-fill"></i>
            </div>

            <h1 class="error-number">404</h1>

            <h2 class="error-title">
                Página não encontrada
            </h2>

            <p class="error-description">
                Ops! A página que você está procurando não existe,
                foi movida ou o endereço informado está incorreto.
            </p>

            <a
                href="https://wa.me/5500000000000?text=Olá!%20Estou%20com%20um%20problema%20ao%20acessar%20o%20site."
                target="_blank"
                rel="noopener noreferrer"
                class="error-button"
            >
                <i class="bi bi-whatsapp"></i>
                Entrar em contato com o suporte
            </a>

            <div class="error-help">
                Se o problema persistir, entre em contato com nosso suporte.
            </div>

        </div>
    </div>
@endsection