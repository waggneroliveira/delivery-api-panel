<!DOCTYPE html>
<html lang="pt-BR">
<head>
    @php
        // ============================================================
        // SEO BÁSICO
        // ============================================================
        $seoTitle = $seoGoogle->title ?? '';
        $seoDescription = $seoGoogle->description ?? '';
        $seoKeywords = $seoGoogle->keywords ?? '';

        // ============================================================
        // IMAGENS
        // ============================================================
        $socialImage = !empty($seoGoogle->social_image) ? asset('storage/' . $seoGoogle->social_image) : null;
        $organizationLogo = !empty($seoGoogle->organization_logo) ? asset('storage/' . $seoGoogle->organization_logo) : null;
        $favicon = !empty($seoGoogle->favicon) ? asset('storage/' . $seoGoogle->favicon) : null;

        // ============================================================
        // SCHEMA.ORG
        // ============================================================
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            '@id' => '#organization',
        ];

        // Identidade
        if (!empty($seoGoogle->organization_name)) {
            $schema['name'] = $seoGoogle->organization_name;
        }

        if (!empty($seoGoogle->legal_name)) {
            $schema['legalName'] = $seoGoogle->legal_name;
        }

        if (!empty($seoGoogle->organization_url)) {
            $schema['url'] = $seoGoogle->organization_url;
        }

        if ($organizationLogo) {
            $schema['logo'] = $organizationLogo;
            $schema['image'] = $organizationLogo;
        } elseif ($socialImage) {
            $schema['logo'] = $socialImage;
            $schema['image'] = $socialImage;
        }

        if (!empty($seoGoogle->organization_description)) {
            $schema['description'] = $seoGoogle->organization_description;
        }

        if (!empty($seoGoogle->founding_date)) {
            $schema['foundingDate'] = $seoGoogle->founding_date instanceof \Carbon\Carbon
                ? $seoGoogle->founding_date->format('Y-m-d')
                : $seoGoogle->founding_date;
        }

        // Contato
        if (!empty($seoGoogle->email)) {
            $schema['email'] = $seoGoogle->email;
        }

        if (!empty($seoGoogle->telephone)) {
            $schema['telephone'] = $seoGoogle->telephone;
        }

        // Endereço
        $address = [];

        if (!empty($seoGoogle->street_address)) {
            $address['streetAddress'] = $seoGoogle->street_address;
        }

        if (!empty($seoGoogle->address_locality)) {
            $address['addressLocality'] = $seoGoogle->address_locality;
        }

        if (!empty($seoGoogle->address_region)) {
            $address['addressRegion'] = $seoGoogle->address_region;
        }

        if (!empty($seoGoogle->postal_code)) {
            $address['postalCode'] = $seoGoogle->postal_code;
        }

        if (!empty($seoGoogle->address_country)) {
            $address['addressCountry'] = $seoGoogle->address_country;
        }

        if (!empty($address)) {
            $schema['address'] = array_merge(['@type' => 'PostalAddress'], $address);
        }

        // Contact Point
        $contactPoint = [];

        if (!empty($seoGoogle->telephone)) {
            $contactPoint['telephone'] = $seoGoogle->telephone;
        }

        if (!empty($seoGoogle->contact_type)) {
            $contactPoint['contactType'] = $seoGoogle->contact_type;
        }

        if (!empty($seoGoogle->email)) {
            $contactPoint['email'] = $seoGoogle->email;
        }

        if (!empty($seoGoogle->area_served)) {
            $contactPoint['areaServed'] = $seoGoogle->area_served;
        }

        // Idiomas
        if (!empty($seoGoogle->available_languages)) {
            $languages = is_array($seoGoogle->available_languages)
                ? $seoGoogle->available_languages
                : array_map('trim', explode(',', $seoGoogle->available_languages));

            $languages = array_values(array_filter($languages));

            if (!empty($languages)) {
                $contactPoint['availableLanguage'] = $languages;
            }
        }

        if (!empty($contactPoint)) {
            $schema['contactPoint'] = array_merge(['@type' => 'ContactPoint'], $contactPoint);
        }

        // Horário de funcionamento
        if (!empty($seoGoogle->opening_hours)) {
            $openingHours = $seoGoogle->opening_hours;

            if (is_string($openingHours)) {
                $decodedOpeningHours = json_decode($openingHours, true);

                if (json_last_error() === JSON_ERROR_NONE) {
                    $openingHours = $decodedOpeningHours;
                }
            }

            if (!empty($openingHours)) {
                $schema['openingHoursSpecification'] = $openingHours;
            }
        }

        // Institucional
        if (!empty($seoGoogle->slogan)) {
            $schema['slogan'] = $seoGoogle->slogan;
        }

        // Palavras-chave da organização
        if (!empty($seoGoogle->organization_keywords)) {
            $organizationKeywords = is_array($seoGoogle->organization_keywords)
                ? $seoGoogle->organization_keywords
                : array_map('trim', explode(',', $seoGoogle->organization_keywords));

            $organizationKeywords = array_values(array_filter($organizationKeywords));

            if (!empty($organizationKeywords)) {
                $schema['keywords'] = $organizationKeywords;
            }
        }
    @endphp


    {{-- ============================================================
    SEO
    ============================================================ --}}

    <title>{{ isset($blogInner) && !empty($blogInner->title) ? $blogInner->title : $seoTitle }}</title>
    <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
    
    @include('client/script-seo-google/script-head')

    @if(isset($blogInner))

        @php
            $blogDescription = Str::limit(strip_tags($blogInner->text ?? $seoDescription), 150);
            $blogImage = !empty($blogInner->path_image_thumbnail) ? asset('storage/' . $blogInner->path_image_thumbnail) : $socialImage;
        @endphp

        @if(!empty($blogDescription))
            <meta name="description" content="{{ $blogDescription }}">
        @endif

        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:type" content="article">
        <meta property="og:title" content="{{ $blogInner->title ?? $seoTitle }}">
        <meta property="og:description" content="{{ $blogDescription }}">

        @if($blogImage)
            <meta property="og:image" content="{{ $blogImage }}">
        @endif

        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:url" content="{{ url()->current() }}">
        <meta name="twitter:title" content="{{ $blogInner->title ?? $seoTitle }}">
        <meta name="twitter:description" content="{{ $blogDescription }}">

        @if($blogImage)
            <meta name="twitter:image" content="{{ $blogImage }}">
        @endif

    @else

        @if(!empty($seoDescription))
            <meta name="description" content="{{ $seoDescription }}">
        @endif

        @if(!empty($seoKeywords))
            <meta name="keywords" content="{{ $seoKeywords }}">
        @endif

        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:type" content="website">
        <meta property="og:title" content="{{ $seoTitle }}">
        <meta property="og:description" content="{{ $seoDescription }}">

        @if($socialImage)
            <meta property="og:image" content="{{ $socialImage }}">
        @elseif($organizationLogo)
            <meta property="og:image" content="{{ $organizationLogo }}">
        @endif

        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:url" content="{{ url()->current() }}">
        <meta name="twitter:title" content="{{ $seoTitle }}">
        <meta name="twitter:description" content="{{ $seoDescription }}">

        @if($socialImage)
            <meta name="twitter:image" content="{{ $socialImage }}">
        @elseif($organizationLogo)
            <meta name="twitter:image" content="{{ $organizationLogo }}">
        @endif

    @endif


    {{-- ============================================================
    META GERAIS
    ============================================================ --}}

    <link rel="canonical" href="{{ url()->current() }}">
    <meta name="copyright" content="Direitos reservados WHI">
    <meta name="author" content="WHI">

    @if($favicon)
        <link rel="shortcut icon" href="{{ $favicon }}">
    @endif


    {{-- ============================================================
    FONTES
    ============================================================ --}}

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" onload='this.onload=null,this.rel="stylesheet"'>

    <noscript>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap">
    </noscript>


    {{-- ============================================================
    BIBLIOTECAS CSS
    ============================================================ --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">

    <link rel="preload" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css"></noscript>

    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"></noscript>

    <link href="{{ asset('build/client/lgpd/style.css') }}" rel="stylesheet" type="text/css">

    <link href="{{ asset('build/client/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">

    <link rel="preload" href="{{ asset('build/client/bootstrap-icons/bootstrap-icons.css') }}" as="style" onload="this.rel='stylesheet'">

    <link href="{{ asset('build/client/themes/whi-web/tp-03/css/style.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('build/client/css/default.css') }}" rel="stylesheet" type="text/css">


    {{-- ============================================================
    SCHEMA.ORG
    ============================================================ --}}

    <script type="application/ld+json">
    {!! json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>
</head>

<body>
    <div id="organization" hidden></div>

    @include('client/script-seo-google/script-body-nocript')

    @include('client/themes/whi-web/tp-03/includes/lgpd/lgpd')

    <style>
        :root {
            /* Cores Gerais */
            --primary-color: {{ $tenantTheme->primary_color ? $tenantTheme->primary_color : '#10513D' }};
            --secondary-color: {{ $tenantTheme->secondary_color ? $tenantTheme->secondary_color : '#FDC20C' }};
            --accent-color: {{ $tenantTheme->accent_color ? $tenantTheme->accent_color : 'rgba(16, 81, 61, 0.5)' }};
            --text-color: {{ $tenantTheme->text_color ? $tenantTheme->text_color : '#565656' }};
            
            /* Header */
            --text-color-header: {{ $tenantTheme->text_color_header ? $tenantTheme->text_color_header : '#FFFFFF' }};
            --bg-header: {{ $tenantTheme->bg_header ? $tenantTheme->bg_header : '#10513D' }};

            /* Footer */
            --text-color-footer: {{ $tenantTheme->text_color_footer ? $tenantTheme->text_color_footer : '#FFFFFF' }};
            --bg-footer: {{ $tenantTheme->bg_footer ? $tenantTheme->bg_footer : '#10513D' }};
            
            /* Footer */
            --bg-scroll: {{ $tenantTheme->bg_scroll ? $tenantTheme->bg_scroll : '#F8F9FA' }};
            
            /* Botões */
            --color-button-one: {{ $tenantTheme->color_button_one ? $tenantTheme->color_button_one : "#FFF" }};
            --color-button-two: {{ $tenantTheme->color_button_two ? $tenantTheme->color_button_two : '#000' }};
            --text-button-one: {{ $tenantTheme->text_button_one ? $tenantTheme->text_button_one : 'Botão 1' }};
            --bg-button-one: {{ $tenantTheme->bg_button_one ? $tenantTheme->bg_button_one : '#10513D' }};
            --text-button-two: {{ $tenantTheme->text_button_two ? $tenantTheme->text_button_two : 'Botão 2' }};
            --bg-button-two: {{ $tenantTheme->bg_button_two ? $tenantTheme->bg_button_two : '#FDC20C' }};
            
            /* Copyright */
            --copyright-text: {{ $tenantTheme->copyright ? $tenantTheme->copyright  : '© 2024 Todos os direitos reservados' }};
        }
        body{
            background: var(--primary-color);
        }
        /* ===== CORES (Text Colors) ===== */
        .primary-color {
            color: var(--primary-color);
        }

        .secondary-color {
            color: var(--secondary-color);
        }

        .accent-color {
            color: var(--accent-color);
        }

        .text-color {
            color: var(--text-color);
        }
        .text-grey{
            color: #565656;
        }
        .text-color-header {
            color: var(--text-color-header);
        }
        .text-color-footer {
            color: var(--text-color-footer);
        }
        .color-button-one {
            color: var(--color-button-one);
        }
        .color-button-two {
            color: var(--color-button-two);
        }
        .border-primary{
            color: var(--primary-color) !important;
        }
        /* ===== BACKGROUNDS ===== */
        .bg-primary-color {
            background: var(--primary-color);
        }

        .bg-secondary-color {
            background: var(--secondary-color);
        }

        .bg-accent-color {
            background: var(--accent-color);
        }

        .bg-header {
            background: var(--bg-header);
        }

        .bg-footer {
            background: var(--bg-footer);
        }

        .bg-scroll {
            background: var(--bg-scroll);
        }

        .bg-button-one {
            background: var(--bg-button-one);
        }

        .bg-button-two {
            background: var(--bg-button-two);
        }
        .bg-grey-light{
            background: #E9E9E9;
        }
        .testimonial-swiper .swiper-pagination-bullet{
            background: var(--primary-color);
        }
        #lgpd-banner button{
            background: var(--bg-button-one);
        }
        .list-service ul li::before {
            color: var(--primary-color);
        }
        .border-warning{
            border-color: var(--primary-color) !important;
        }
        .z-index-10{
            z-index: 4;
        }
        .service-bg::after{
            content: '';
            height: 100%;
            width: 100%;
            position: absolute;
            left: 0;
            top: 0;
            background: color-mix(in srgb, var(--secondary-color) 80%, transparent);
        }
        .main-swiper .swiper-pagination-bullet-active{
            background: var(--primary-color);
        }
        .scroll-top:hover{
            background: var(--secondary-color);
        }
        .border-color-footer{
            border-color: var(--text-color-footer) !important;
        }
    </style>

    <header class="shadow-sm bg-header fixed-top">
        <nav class="navbar navbar-expand-lg navbar-light container py-3 px-3 px-lg-0">
            <!-- Brand -->
            <a class="navbar-brand" href="{{route('index')}}">
                @if ($tenantTheme->path_image_logo_header <> null)
                    <img src="{{asset('storage/' .$tenantTheme->path_image_logo_header)}}" alt="{{ config('app.name') }}" height="65" loading="lazy">
                    @else
                    <div class="d-flex align-items-center">
                        <div class="brand-icon-wrapper me-2">
                            <i class="bi bi-tools"></i>
                        </div>
                        <div>
                            <span class="brand-name">Gerar<span>Fácil</span></span>
                            <small class="brand-tagline d-none d-sm-block">Ferramentas Profissionais</small>
                        </div>
                    </div>
                @endif
            </a>


            <!-- Toggle mobile -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="Abrir menu de navegação">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Menu -->
            <div class="collapse navbar-collapse" id="navbarMain">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <button type="button" class="nav-link active" data-category="all">
                            <i class="bi bi-grid-3x3-gap-fill me-1"></i> Todos
                        </button>
                    </li>

                    <li class="nav-item">
                        <button type="button" class="nav-link" data-category="calculadoras">
                            <i class="bi bi-calculator-fill me-1"></i> Calculadoras
                        </button>
                    </li>

                    <li class="nav-item">
                        <button type="button" class="nav-link" data-category="geradores">
                            <i class="bi bi-dice-6-fill me-1"></i> Geradores
                        </button>
                    </li>

                    <li class="nav-item">
                        <button type="button" class="nav-link" data-category="validadores">
                            <i class="bi bi-shield-check-fill me-1"></i> Validadores
                        </button>
                    </li>

                    <li class="nav-item">
                        <button type="button" class="nav-link" data-category="conversores">
                            <i class="bi bi-arrow-repeat me-1"></i> Conversores
                        </button>
                    </li>
                </ul>

                <div class="status-badge">
                    <i class="bi bi-wifi-off"></i>
                    <span>100% Offline</span>
                    <i class="bi bi-dot"></i>
                    <span>15+ Tools</span>
                </div>
            </div>
        </nav>
    </header>

    <main>
        @yield('content') 
    </main>

    <footer class="bg-footer text-white pt-5 pb-3">
        <div class="container">

            <!-- Linha principal -->
            <div class="row align-items-start">

                <!-- Logo + botão -->
                <div class="col-lg-3 mb-4 mb-lg-0">
                    {{-- Pegar tamanho/proporção da logo --}}
                    @php
                        $logoPath = storage_path('app/public/' . $tenantTheme->path_image_logo_footer);
                        $dimensions = file_exists($logoPath) ? @getimagesize($logoPath) : null;
                    @endphp

                    @if ($tenantTheme->path_image_logo_footer <> null)
                        <img src="{{ asset('storage/' . $tenantTheme->path_image_logo_footer) }}" alt="{{ $tenantTheme->name }}" width="{{ $dimensions[0] ?? 200 }}" height="{{ $dimensions[1] ?? 60 }}" style="max-width:100%;height:auto;">
                        @else
                        <a class="footer-title-modern" href="#">
                            <div class="d-flex align-items-center">
                                <div class="brand-icon-wrapper me-2">
                                    <i class="bi bi-tools"></i>
                                </div>
                                <div>
                                    <span class="brand-name">Gerar<span>Fácil</span></span>
                                    <small class="brand-tagline d-none d-sm-block">Ferramentas Profissionais</small>
                                </div>
                            </div>
                        </a>
                    @endif
                    
                    @if ($tenantTheme->link <> null)                        
                        <div class="mt-3 mt-lg-5">
                            <a href="{{ $tenantTheme->link }}" target="_blank" rel="noopener noreferrer" class="bg-button-one color-button-one px-4 py-2 font-changa font-16 font-medium text-decoration-none hover-zoom">
                                {{$tenantTheme->btn_title}}
                                <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Mapa do site -->
                <div class="col-lg-5 mb-4 mb-lg-0">
                    <div class="footer-title-modern text-color-footer">Ferramentas em Destaque</div>

                    <div class="row">
                        <div class="col-6">
                            <ul class="footer-list-modern">
                                <li><a href="{{route('index')}}" class="text-color-footer font-changa font-16 font-regular text-decoration-none d-block mb-2">Calculadora Financiamento</a></li>
                                <li><a href="{{route('index')}}" class="text-color-footer font-changa font-16 font-regular text-decoration-none d-block mb-2">Validador CPF</a></li>
                                <li><a href="{{route('index')}}" class="text-color-footer font-changa font-16 font-regular text-decoration-none d-block mb-2">Gerador de Senhas</a></li>
                            </ul>

                        </div>

                        <div class="col-6">
                            <ul class="footer-list-modern">
                                <li><a href="{{route('about')}}" class="text-color-footer font-changa font-16 font-regular text-decoration-none d-block mb-2">Sobre Nós</a></li>
                                <li><a href="{{route('privacy-police')}}" class="text-color-footer font-changa font-16 font-regular text-decoration-none d-block mb-2">Política de privacidade</a></li>
                                <li><a href="{{route('use-term')}}" class="text-color-footer font-changa font-16 font-regular text-decoration-none d-block mb-2">Termos de uso</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <!-- Coluna 3 - Sobre -->
                <div class="col-lg-4">
                    <div class="footer-title-modern text-color-footer">Sobre</div>
                    <p class="footer-text-modern">
                    Todas as ferramentas são processadas localmente no seu navegador. Seus dados não são enviados para nossos servidores.
                    </p>
                    <!-- Redes sociais -->
                    @if (isset($contact) && (
                    $contact->link_insta ||
                    $contact->link_face ||
                    $contact->link_tik_tok
                    ))                    
                        <div class="col-12 text-lg-end">
                            <div class="d-flex gap-3 justify-content-lg-end">
                                @if ($contact->link_insta)
                                    <a href="{{ $contact->link_insta }}" target="_blank" rel="noopener noreferrer" class="text-color-footer fs-5" aria-label="Visite nosso Instagram">
                                        <i class="bi bi-instagram" aria-hidden="true"></i>
                                    </a>
                                @endif

                                @if ($contact->link_face)
                                    <a href="{{ $contact->link_face }}" target="_blank" rel="noopener noreferrer" class="text-color-footer fs-5" aria-label="Visite nosso Facebook">
                                        <i class="bi bi-facebook" aria-hidden="true"></i>
                                    </a>
                                @endif

                                @if ($contact->link_tik_tok)
                                    <a href="{{ $contact->link_tik_tok }}" target="_blank" rel="noopener noreferrer" class="text-color-footer fs-5" aria-label="Visite nosso TikTok">
                                        <i class="bi bi-tiktok" aria-hidden="true"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Linha inferior -->
            <hr class="border-primary opacity-25 my-4">

            <div class="row align-items-center">
                @php
                    $cnpj = !empty($tenantTheme->cnpj) ? preg_replace('/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})$/', '$1.$2.$3/$4-$5', preg_replace('/\D/', '', $tenantTheme->cnpj)) : '';
                @endphp

                <div class="row align-items-center g-4 m-0">
                    <div class="col-12 col-lg-5 text-center text-lg-start small text-color-footer m-0 p-0">
                        <p id="footer-text" class="mb-0 text-color-footer font-13"></p>
                    </div>

                    <div class="col-12 col-lg-3 text-center small text-color-footer mt-0">
                        @if ($tenantTheme->privacy_policy <> null)                            
                            <a href="#" class="text-color-footer text-decoration-none d-none" data-bs-toggle="modal" data-bs-target="#privacyModal">Política de Privacidade</a>
                            <span class="mx-1 d-none">|</span>
                        @endif
                        @if ($tenantTheme->terms_of_use <> null)                            
                            <a href="#" class="text-color-footer text-decoration-none d-none" data-bs-toggle="modal" data-bs-target="#termsModal">Termos de Uso</a>
                        @endif
                    </div>

                    <div class="col-12 col-lg-4 m-0 p-0">
                        <div class="d-flex justify-content-center justify-content-lg-end align-items-center gap-3">
                            <a href="http://whiweb.com.br/" target="_blank" rel="noopener noreferrer" class="text-color-footer text-decoration-none d-flex align-items-center gap-2">
                                <span class="font-13">Sistema</span>
                                <img src="{{asset('build/client/themes/default/images/whi-web.png')}}" title="Whi Web" alt="WHI Web" width="89" height="50" class="logo-system" loading="lazy">
                            </a>

                            <span class="text-color-footer opacity-50">|</span>

                            <a href="https://www.whi.dev.br/" target="_blank" rel="noopener noreferrer" class="text-color-footer text-decoration-none d-flex align-items-center gap-2">
                                <span class="font-13">Desenvolvido por</span>
                                <img src="{{asset('build/client/themes/default/images/whi.png')}}" title="Agência WHI" alt="WHI" width="44" height="25" class="logo-system" loading="lazy">
                            </a>
                        </div>
                    </div>
                </div>

                <script defer>
                    document.addEventListener('DOMContentLoaded', function () {
                        const currentYear = new Date().getFullYear();
                        const footerText = document.getElementById('footer-text');

                        if (footerText) {
                            footerText.innerHTML = `© ${currentYear} <span>{{ $tenantTheme->copyright }} - Todos os direitos reservados{{ $cnpj ? ' | ' . $cnpj : '' }}.</span>`;
                        }
                    });
                </script>
            </div>

        </div>
    </footer>

    <a href="#" id="scroll-top" class="scroll-top bg-scroll d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
     
    <script>
        // ========== AVISO LEGAL ==========

        function avisoLegal(tipo) {
            if (tipo === 'cpf') {
                return '<div class="legal-warning"><i class="bi bi-exclamation-triangle-fill me-1"></i> <strong>Aviso Legal:</strong> Este gerador cria números aleatórios APENAS para testes e simulações. Os CPFs gerados NÃO são reais e NÃO correspondem a pessoas físicas existentes. É expressamente proibido usar para fraudes ou se passar por terceiros.</div>';
            }

            if (tipo === 'cnpj') {
                return '<div class="legal-warning"><i class="bi bi-exclamation-triangle-fill me-1"></i> <strong>Aviso Legal:</strong> Este gerador cria números aleatórios APENAS para testes. Os CNPJs gerados NÃO são reais e NÃO correspondem a empresas existentes. Uso para fraudes é proibido.</div>';
            }

            if (tipo === 'cartao') {
                return '<div class="legal-warning"><i class="bi bi-exclamation-triangle-fill me-1"></i> <strong>Aviso Legal:</strong> Os números de cartão gerados seguem o algoritmo Luhn mas NÃO são cartões reais ativos. Use APENAS para testes de desenvolvimento.</div>';
            }

            return '';
        }


        // ========== FUNÇÕES UTILITÁRIAS ==========

        function copyClip(text, btn) {
            navigator.clipboard.writeText(text).then(function () {
                if (btn) {
                    var orig = btn.innerHTML;

                    btn.innerHTML = '<i class="bi bi-check-lg"></i> Copiado!';

                    setTimeout(function () {
                        btn.innerHTML = orig;
                    }, 1500);
                }
            });
        }


        function gerarCPF() {

            function n() {
                return Math.floor(Math.random() * 10);
            }

            function calc(d, p) {
                var s = 0;

                for (var i = 0; i < d.length; i++) {
                    s += d[i] * (p - i);
                }

                var r = s % 11;

                return r < 2 ? 0 : 11 - r;
            }

            var base = [];

            for (var i = 0; i < 9; i++) {
                base.push(n());
            }

            var d1 = calc(base, 10);
            var d2 = calc(base.concat(d1), 11);

            var cpf = base.concat([d1, d2]);
            var cpfStr = cpf.join('');

            return cpfStr.replace(
                /(\d{3})(\d{3})(\d{3})(\d{2})/,
                '$1.$2.$3-$4'
            );
        }


        function validarCPF(cpfStr) {

            var clean = cpfStr.replace(/\D/g, '');

            if (clean.length !== 11 || /^(\d)\1+$/.test(clean)) {
                return false;
            }

            var d = clean.split('').map(Number);

            function calc(digits, p) {

                var s = 0;

                for (var i = 0; i < digits.length; i++) {
                    s += digits[i] * (p - i);
                }

                var r = s % 11;

                return r < 2 ? 0 : 11 - r;
            }

            var d1 = calc(d.slice(0, 9), 10);

            if (d1 !== d[9]) {
                return false;
            }

            var d2 = calc(d.slice(0, 10), 11);

            return d2 === d[10];
        }


        function gerarCNPJ() {

            function n(min, max) {
                return Math.floor(Math.random() * (max - min + 1) + min);
            }

            var base = [];

            for (var i = 0; i < 8; i++) {
                base.push(n(0, 9));
            }

            base.push(0, 0, 0, 1);

            function calc(dig, m) {

                var s = 0;
                var peso = m;

                for (var i = 0; i < dig.length; i++) {

                    s += dig[i] * peso;

                    peso--;

                    if (peso < 2) {
                        peso = 9;
                    }
                }

                var r = s % 11;

                return r < 2 ? 0 : 11 - r;
            }

            var d1 = calc(base, 5);
            var d2 = calc(base.concat([d1]), 6);

            var cnpj = base.concat([d1, d2]);
            var cnpjStr = cnpj.join('');

            return cnpjStr.replace(
                /^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/,
                '$1.$2.$3/$4-$5'
            );
        }


        function gerarCartaoLuhn() {

            var prefixo = '4532';
            var corpo = '';

            for (var i = 0; i < 12; i++) {
                corpo += Math.floor(Math.random() * 10);
            }

            var cartao = prefixo + corpo;
            var digitos = cartao.split('').map(Number);

            var soma = 0;
            var alternar = false;

            for (var i = digitos.length - 1; i >= 0; i--) {

                var d = digitos[i];

                if (alternar) {
                    d *= 2;

                    if (d > 9) {
                        d -= 9;
                    }
                }

                soma += d;
                alternar = !alternar;
            }

            var digitoVerif = (10 - (soma % 10)) % 10;
            var cartaoFinal = cartao + digitoVerif;

            var formatado = cartaoFinal
                .replace(/(\d{4})/g, '$1 ')
                .trim();

            return {
                numero: formatado,
                validade:
                    Math.floor(Math.random() * 12) +
                    1 +
                    '/' +
                    (Math.floor(Math.random() * 5) + 25),
                cvv: Math.floor(Math.random() * 900 + 100)
            };
        }


        function gerarUUID() {

            return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(
                /[xy]/g,
                function (c) {

                    var r = Math.random() * 16 | 0;
                    var v = c == 'x'
                        ? r
                        : (r & 0x3 | 0x8);

                    return v.toString(16);
                }
            );
        }


        function formatJSON(str) {

            try {
                return JSON.stringify(
                    JSON.parse(str),
                    null,
                    2
                );
            } catch (e) {
                return '❌ JSON inválido: ' + e.message;
            }
        }


        function qrUrl(txt) {
            return 'https://quickchart.io/qr?size=160&text=' +
                encodeURIComponent(txt);
        }


        function gerarSenhaCustom(tamanho, opts) {

            var chars = '';

            if (opts.minuscula) {
                chars += 'abcdefghijklmnopqrstuvwxyz';
            }

            if (opts.maiuscula) {
                chars += 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            }

            if (opts.numeros) {
                chars += '0123456789';
            }

            if (opts.especiais) {
                chars += '!@#$%^&*()_+[]{}<>?';
            }

            if (chars === '') {
                chars = 'abcdefghijklmnopqrstuvwxyz';
            }

            var pwd = '';

            for (var i = 0; i < tamanho; i++) {
                pwd += chars[
                    Math.floor(Math.random() * chars.length)
                ];
            }

            return pwd;
        }


        function converterMoeda(valor, de, para) {

            var taxas = {
                BRL: 1,
                USD: 0.19,
                EUR: 0.18,
                GBP: 0.15,
                ARS: 75
            };

            var emBRL = valor / taxas[de];

            return (
                emBRL * taxas[para]
            ).toFixed(2);
        }


        function calcFinanciamento(
            valor,
            taxaAnual,
            meses,
            tipo
        ) {

            var taxaMensal = taxaAnual / 100 / 12;

            if (tipo === 'price') {

                var prestacao =
                    valor *
                    (
                        taxaMensal *
                        Math.pow(
                            1 + taxaMensal,
                            meses
                        )
                    ) /
                    (
                        Math.pow(
                            1 + taxaMensal,
                            meses
                        ) - 1
                    );

                var total = prestacao * meses;

                return {
                    prestacao: prestacao.toFixed(2),
                    total: total.toFixed(2),
                    juros: (total - valor).toFixed(2)
                };

            } else {

                var amort = valor / meses;
                var saldo = valor;
                var totalPago = 0;

                for (var i = 1; i <= meses; i++) {

                    var juros = saldo * taxaMensal;
                    var prest = amort + juros;

                    totalPago += prest;
                    saldo -= amort;
                }

                var primeiraParcela =
                    amort +
                    (valor * taxaMensal);

                return {
                    prestacao: primeiraParcela.toFixed(2),
                    total: totalPago.toFixed(2),
                    juros: (totalPago - valor).toFixed(2)
                };
            }
        }


        function converterUnidades(val, de, para) {

            var metros = {
                m: 1,
                cm: 0.01,
                mm: 0.001,
                km: 1000,
                ft: 0.3048,
                in: 0.0254
            };

            var emMetros = val * metros[de];

            return (
                emMetros / metros[para]
            ).toFixed(4);
        }


        function descSEO(titulo, texto) {

            return '<div class="descricao-seo">' +
                '<i class="bi bi-info-circle-fill text-primary me-1"></i> ' +
                '<strong>Sobre esta ferramenta:</strong> ' +
                texto +
                '</div>';
        }


        // ========== RENDER FERRAMENTAS ==========

        function renderTool(toolId) {

            var html = '';

            if (toolId === 'calc-juros') {

                html =
                    '<div class="tool-header">' +
                        '<h2><i class="bi bi-percent"></i> Calculadora Juros</h2>' +
                    '</div>' +

                    '<div class="mb-2">' +
                        '<label for="capJ">Capital (R$)</label>' +
                        '<input type="number" id="capJ" class="form-control" value="1000">' +
                    '</div>' +

                    '<div class="mb-2">' +
                        '<label for="taxJ">Taxa % mês</label>' +
                        '<input type="number" id="taxJ" step="any" class="form-control" value="2">' +
                    '</div>' +

                    '<div class="mb-2">' +
                        '<label for="mesJ">Meses</label>' +
                        '<input type="number" id="mesJ" class="form-control" value="12">' +
                    '</div>' +

                    '<div class="mb-2">' +
                        '<label for="tipoJ">Tipo de juros</label>' +
                        '<select id="tipoJ" class="form-select">' +
                            '<option value="simples">Simples</option>' +
                            '<option value="composto">Composto</option>' +
                        '</select>' +
                    '</div>' +

                    '<button type="button" class="btn btn-primary w-100 mb-2" id="calcJBtn">' +
                        'Calcular' +
                    '</button>' +

                    '<div id="resJ" class="result-area">Aguardando</div>'

                    descSEO(
                        'Juros',
                        'Simule juros simples/compostos para investimentos e empréstimos.'
                    );
            }

            else if (toolId === 'calc-porcentagem') {

                html = `
                    <div class="tool-header">
                        <h2>
                            <i class="bi bi-calculator-fill"></i>
                            Calculadora de Porcentagem Avançada
                        </h2>
                    </div>

                    <p class="text-muted">
                        Oito operações essenciais: descontos, aumentos, regras de proporção e mais.
                    </p>

                    <div class="row g-3">

                        <div class="col-12">
                            <div class="card p-3 shadow-sm border-0 bg-light">
                                <h6>1️⃣ Quanto é X% de Y?</h6>

                                <div class="row g-2">
                                    <div class="col-4">
                                        <input type="number" id="perc1" class="form-control" placeholder="X (%)">
                                    </div>

                                    <div class="col-4">
                                        <input type="number" id="total1" class="form-control" placeholder="Y">
                                    </div>

                                    <div class="col-4">
                                        <button class="btn btn-sm btn-primary w-100" id="calc1Btn">
                                            Calcular
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div id="res1" class="alert alert-info mt-2 small d-none"></div>
                        </div>


                        <div class="col-12">
                            <div class="card p-3 shadow-sm border-0 bg-light">
                                <h6>2️⃣ X é qual porcentagem de Y?</h6>

                                <div class="row g-2">
                                    <div class="col-4">
                                        <input type="number" id="val2" class="form-control" placeholder="X">
                                    </div>

                                    <div class="col-4">
                                        <input type="number" id="tot2" class="form-control" placeholder="Y">
                                    </div>

                                    <div class="col-4">
                                        <button class="btn btn-sm btn-primary w-100" id="calc2Btn">
                                            Calcular
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div id="res2" class="alert alert-info mt-2 small d-none"></div>
                        </div>


                        <div class="col-12">
                            <div class="card p-3 shadow-sm border-0 bg-light">
                                <h6>3️⃣ Valor aumentou de X para Y. Percentual de aumento?</h6>

                                <div class="row g-2">
                                    <div class="col-4">
                                        <input type="number" id="ini3" class="form-control" placeholder="Inicial">
                                    </div>

                                    <div class="col-4">
                                        <input type="number" id="fim3" class="form-control" placeholder="Final">
                                    </div>

                                    <div class="col-4">
                                        <button class="btn btn-sm btn-primary w-100" id="calc3Btn">
                                            Calcular
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div id="res3" class="alert alert-info mt-2 small d-none"></div>
                        </div>


                        <div class="col-12">
                            <div class="card p-3 shadow-sm border-0 bg-light">
                                <h6>4️⃣ Valor X sobre Y = quantos %?</h6>

                                <div class="row g-2">
                                    <div class="col-4">
                                        <input type="number" id="val4" class="form-control" placeholder="Valor X">
                                    </div>

                                    <div class="col-4">
                                        <input type="number" id="tot4" class="form-control" placeholder="Valor Y">
                                    </div>

                                    <div class="col-4">
                                        <button class="btn btn-sm btn-primary w-100" id="calc4Btn">
                                            Calcular
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div id="res4" class="alert alert-info mt-2 small d-none"></div>
                        </div>


                        <div class="col-12">
                            <div class="card p-3 shadow-sm border-0 bg-light">
                                <h6>5️⃣ Aumentar valor X em Y%</h6>

                                <div class="row g-2">
                                    <div class="col-4">
                                        <input type="number" id="val5" class="form-control" placeholder="Valor">
                                    </div>

                                    <div class="col-4">
                                        <input type="number" id="pct5" class="form-control" placeholder="% aumento">
                                    </div>

                                    <div class="col-4">
                                        <button class="btn btn-sm btn-primary w-100" id="calc5Btn">
                                            Calcular
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div id="res5" class="alert alert-info mt-2 small d-none"></div>
                        </div>


                        <div class="col-12">
                            <div class="card p-3 shadow-sm border-0 bg-light">
                                <h6>6️⃣ Diminuir valor X em Y%</h6>

                                <div class="row g-2">
                                    <div class="col-4">
                                        <input type="number" id="val6" class="form-control" placeholder="Valor">
                                    </div>

                                    <div class="col-4">
                                        <input type="number" id="pct6" class="form-control" placeholder="% desconto">
                                    </div>

                                    <div class="col-4">
                                        <button class="btn btn-sm btn-primary w-100" id="calc6Btn">
                                            Calcular
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div id="res6" class="alert alert-info mt-2 small d-none"></div>
                        </div>


                        <div class="col-12">
                            <div class="card p-3 shadow-sm border-0 bg-light">
                                <h6>7️⃣ Valor inicial aumentou X% e virou Y. Qual era?</h6>

                                <div class="row g-2">
                                    <div class="col-4">
                                        <input type="number" id="pct7" class="form-control" placeholder="% aumento">
                                    </div>

                                    <div class="col-4">
                                        <input type="number" id="final7" class="form-control" placeholder="Valor final">
                                    </div>

                                    <div class="col-4">
                                        <button class="btn btn-sm btn-primary w-100" id="calc7Btn">
                                            Calcular
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div id="res7" class="alert alert-info mt-2 small d-none"></div>
                        </div>


                        <div class="col-12">
                            <div class="card p-3 shadow-sm border-0 bg-light">
                                <h6>8️⃣ Valor inicial diminuiu X% e resultou em Y. Qual era?</h6>

                                <div class="row g-2">
                                    <div class="col-4">
                                        <input type="number" id="pct8" class="form-control" placeholder="% redução">
                                    </div>

                                    <div class="col-4">
                                        <input type="number" id="final8" class="form-control" placeholder="Valor final">
                                    </div>

                                    <div class="col-4">
                                        <button class="btn btn-sm btn-primary w-100" id="calc8Btn">
                                            Calcular
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div id="res8" class="alert alert-info mt-2 small d-none"></div>
                        </div>

                    </div>
                ` +
                descSEO(
                    'Porcentagem',
                    '8 tipos de cálculo: percentual de valor, aumento, desconto, regressão e relação numérica. Ferramenta essencial para finanças e comércio.'
                );
            }

            else if (toolId === 'calc-financiamento') {

                html =
                    '<div class="tool-header">' +
                        '<h2><i class="bi bi-house"></i> Financiamento Price/SAC</h2>' +
                    '</div>' +

                    '<div>' +
                        '<label>Valor R$</label>' +
                        '<input type="number" id="fv" class="form-control" value="100000">' +
                    '</div>' +

                    '<div>' +
                        '<label>Taxa anual (%)</label>' +
                        '<input type="number" id="ftax" step="any" class="form-control" value="10">' +
                    '</div>' +

                    '<div>' +
                        '<label>Meses</label>' +
                        '<input type="number" id="fmes" class="form-control" value="120">' +
                    '</div>' +

                    '<select id="ftipo" class="form-select my-2">' +
                        '<option value="price">Tabela Price</option>' +
                        '<option value="sac">SAC</option>' +
                    '</select>' +

                    '<button class="btn btn-primary w-100" id="calcFinBtn">' +
                        'Simular' +
                    '</button>' +

                    '<div id="resFin" class="result-area mt-2"></div>' +

                    descSEO(
                        'Financiamento',
                        'Calcule prestações Price e SAC para imóveis e veículos.'
                    );
            }

            else if (toolId === 'format-json') {

                html =
                    '<div class="tool-header">' +
                        '<h2><i class="bi bi-braces"></i> Formatador JSON</h2>' +
                    '</div>' +

                    '<textarea id="jsonInp" rows="5" class="form-control" placeholder=\'{"site":"GerarFácil"}\'></textarea>' +

                    '<button class="btn btn-success mt-2 me-2" id="fmtJson">' +
                        'Formatar' +
                    '</button>' +

                    '<button class="btn btn-secondary mt-2" id="clrJson">' +
                        'Limpar' +
                    '</button>' +

                    '<pre id="jsonOut" class="result-area mt-2">Aguardando</pre>' +

                    descSEO(
                        'JSON',
                        'Valide e formate códigos JSON de forma legível.'
                    );
            }

            else if (toolId === 'gerar-cartao') {

                html =
                    '<div class="tool-header">' +
                        '<h2><i class="bi bi-credit-card"></i> Gerar Cartão</h2>' +
                    '</div>' +

                    '<button class="btn btn-primary w-100 mb-2" id="genCardBtn">' +
                        'Gerar (Luhn válido)' +
                    '</button>' +

                    '<div id="cardRes" class="result-area">Clique</div>' +

                    descSEO(
                        'Cartão',
                        'Gere números de cartão com algoritmo Luhn para testes.'
                    ) +

                    avisoLegal('cartao');
            }

            else if (toolId === 'gerar-cpf') {

                html =
                    '<div class="tool-header">' +
                        '<h2><i class="bi bi-person-badge"></i> Gerar CPF</h2>' +
                    '</div>' +

                    '<button class="btn btn-primary w-100 mb-2" id="genCpfBtn">' +
                        'Gerar CPF Válido' +
                    '</button>' +

                    '<div class="d-flex justify-content-between align-items-center result-area">' +
                        '<span id="cpfSpan">---</span>' +
                        '<button class="btn-copy" id="copyCpfBtn">Copiar</button>' +
                    '</div>' +

                    descSEO(
                        'CPF',
                        'Gere números de CPF com dígitos verificadores reais.'
                    ) +

                    avisoLegal('cpf');
            }

            else if (toolId === 'validar-cpf') {

                html =
                    '<div class="tool-header">' +
                        '<h2><i class="bi bi-check-circle"></i> Validar CPF</h2>' +
                    '</div>' +

                    '<input type="text" id="cpfValidar" class="form-control mb-2" placeholder="Digite o CPF (ex: 123.456.789-09)">' +

                    '<button class="btn btn-primary w-100" id="validarCpfBtn">' +
                        'Validar' +
                    '</button>' +

                    '<div id="validaRes" class="result-area mt-2">' +
                        'Aguardando' +
                    '</div>' +

                    descSEO(
                        'Validador CPF',
                        'Verifique se um CPF é verdadeiro com base nos dígitos.'
                    );
            }

            else if (toolId === 'gerar-cnpj') {

                html =
                    '<div class="tool-header">' +
                        '<h2><i class="bi bi-building"></i> Gerar CNPJ</h2>' +
                    '</div>' +

                    '<button class="btn btn-primary w-100 mb-2" id="genCnpjBtn">' +
                        'Gerar CNPJ Válido' +
                    '</button>' +

                    '<div class="d-flex justify-content-between result-area">' +
                        '<span id="cnpjSpan">---</span>' +
                        '<button class="btn-copy" id="copyCnpjBtn">Copiar</button>' +
                    '</div>' +

                    descSEO(
                        'CNPJ',
                        'Gere números de CNPJ aleatórios com validação de dígitos.'
                    ) +

                    avisoLegal('cnpj');
            }

            else if (toolId === 'gerar-senhas') {

                html =
                    '<div class="tool-header">' +
                        '<h2><i class="bi bi-lock-fill"></i> Gerador Senhas Customizável</h2>' +
                    '</div>' +

                    '<div>' +
                        '<label>Tamanho: ' +
                            '<input type="number" id="senhaLen" value="12" class="form-control w-50 d-inline">' +
                        '</label>' +
                    '</div>' +

                    '<div class="my-2 checkbox-group">' +

                        '<label>' +
                            '<input type="checkbox" id="optMinus" checked> ' +
                            'Minúsculas (a-z)' +
                        '</label>' +

                        '<label>' +
                            '<input type="checkbox" id="optMaius" checked> ' +
                            'Maiúsculas (A-Z)' +
                        '</label>' +

                        '<label>' +
                            '<input type="checkbox" id="optNum" checked> ' +
                            'Números (0-9)' +
                        '</label>' +

                        '<label>' +
                            '<input type="checkbox" id="optEsp" checked> ' +
                            'Especiais (!@#)' +
                        '</label>' +

                    '</div>' +

                    '<button class="btn btn-primary w-100 mb-2" id="genSenhaCustomBtn">' +
                        'Gerar Senha' +
                    '</button>' +

                    '<div class="d-flex justify-content-between result-area">' +
                        '<span id="senhaFinal">********</span>' +
                        '<button class="btn-copy" id="copySenhaCustomBtn">Copiar</button>' +
                    '</div>' +

                    descSEO(
                        'Senhas',
                        'Crie senhas fortes escolhendo quais caracteres incluir.'
                    );
            }

            else if (toolId === 'gerar-uuid') {

                html =
                    '<div class="tool-header">' +
                        '<h2><i class="bi bi-hash"></i> Gerador UUID</h2>' +
                    '</div>' +

                    '<button class="btn btn-primary w-100 mb-2" id="genUuidBtn">' +
                        'Gerar UUID v4' +
                    '</button>' +

                    '<div class="d-flex justify-content-between result-area">' +
                        '<span id="uuidSpan">---</span>' +
                        '<button class="btn-copy" id="copyUuidBtn">Copiar</button>' +
                    '</div>' +

                    descSEO(
                        'UUID',
                        'Identificadores únicos universais para sistemas.'
                    );
            }

            else if (toolId === 'conversor-moedas') {

                html =
                    '<div class="tool-header">' +
                        '<h2><i class="bi bi-currency-dollar"></i> Conversor Moedas (offline)</h2>' +
                    '</div>' +

                    '<div>' +
                        '<label>Valor</label>' +
                        '<input type="number" id="moedaVal" class="form-control" value="100">' +
                    '</div>' +

                    '<select id="moedaDe" class="form-select mt-2">' +
                        '<option value="BRL">Real BRL</option>' +
                        '<option value="USD">Dólar USD</option>' +
                        '<option value="EUR">Euro EUR</option>' +
                        '<option value="GBP">Libra GBP</option>' +
                        '<option value="ARS">Peso ARS</option>' +
                    '</select>' +

                    '<select id="moedaPara" class="form-select mt-1">' +
                        '<option value="USD">Dólar USD</option>' +
                        '<option value="BRL">Real BRL</option>' +
                    '</select>' +

                    '<button class="btn btn-primary w-100 mt-2" id="convMoedaBtn">' +
                        'Converter' +
                    '</button>' +

                    '<div id="moedaRes" class="result-area mt-2">' +
                        'Resultado' +
                    '</div>' +

                    descSEO(
                        'Moedas',
                        'Taxas aproximadas offline (valores referenciais).'
                    );
            }

            else if (toolId === 'contador-palavras') {

                html =
                    '<div class="tool-header">' +
                        '<h2><i class="bi bi-text-paragraph"></i> Contador Palavras/Caracteres</h2>' +
                    '</div>' +

                    '<textarea id="textoContar" rows="6" class="form-control" placeholder="Digite seu texto aqui..."></textarea>' +

                    '<div id="statsContador" class="result-area mt-2">' +
                        'Palavras: 0 | Caracteres: 0' +
                    '</div>' +

                    descSEO(
                        'Contador',
                        'Ferramenta para redatores e SEO, conta palavras e caracteres.'
                    );
            }

            else if (toolId === 'sorteador-numeros') {

                html =
                    '<div class="tool-header">' +
                        '<h2><i class="bi bi-dice-6"></i> Sorteador de Números</h2>' +
                    '</div>' +

                    '<div class="row">' +

                        '<div class="col-6">' +
                            '<label>Mínimo</label>' +
                            '<input type="number" id="minSorte" value="1" class="form-control">' +
                        '</div>' +

                        '<div class="col-6">' +
                            '<label>Máximo</label>' +
                            '<input type="number" id="maxSorte" value="100" class="form-control">' +
                        '</div>' +

                    '</div>' +

                    '<div class="mt-2">' +
                        '<label>Quantidade</label>' +
                        '<input type="number" id="qtdSorte" value="1" class="form-control">' +
                    '</div>' +

                    '<button class="btn btn-primary w-100 mt-2" id="sortearBtn">' +
                        'Sortear' +
                    '</button>' +

                    '<div id="sorteRes" class="result-area mt-2">---</div>' +

                    descSEO(
                        'Sorteador',
                        'Sorteie números aleatórios para rifas ou jogos.'
                    );
            }

            else if (toolId === 'conversor-unidades') {

                html =
                    '<div class="tool-header">' +
                        '<h2><i class="bi bi-rulers"></i> Conversor Unidades (comprimento)</h2>' +
                    '</div>' +

                    '<input type="number" id="unidVal" class="form-control" placeholder="Valor">' +

                    '<select class="form-select mt-1" id="unidDe">' +
                        '<option value="m">Metros</option>' +
                        '<option value="cm">Centímetros</option>' +
                        '<option value="mm">Milímetros</option>' +
                        '<option value="km">Quilômetros</option>' +
                        '<option value="ft">Pés</option>' +
                        '<option value="in">Polegadas</option>' +
                    '</select>' +

                    '<select class="form-select mt-1" id="unidPara">' +
                        '<option value="cm">Centímetros</option>' +
                        '<option value="m">Metros</option>' +
                    '</select>' +

                    '<button class="btn btn-primary w-100 mt-2" id="convUnidBtn">' +
                        'Converter' +
                    '</button>' +

                    '<div id="unidRes" class="result-area mt-2">---</div>' +

                    descSEO(
                        'Unidades',
                        'Converta metros, centímetros, pés e polegadas rapidamente.'
                    );
            }

            else if (toolId === 'gerador-qr') {

                html =
                    '<div class="tool-header">' +
                        '<h2><i class="bi bi-qr-code"></i> Gerador QR Code</h2>' +
                    '</div>' +

                    '<input type="text" id="qrTexto" class="form-control mb-2" placeholder="URL ou texto" value="https://GerarFácil.com">' +

                    '<button class="btn btn-primary w-100 mb-2" id="gerarQrBtn">' +
                        'Gerar QR' +
                    '</button>' +

                    '<div class="text-center">' +
                        '<img id="qrImg" style="max-width:150px" class="shadow rounded">' +
                    '</div>' +

                    descSEO(
                        'QR Code',
                        'Códigos QR para links e textos.'
                    );
            }

            return '<div>' + html + '</div>';
        }


        // ========== BIND DE EVENTOS ==========

        function bindEvents(toolId) {

            if (toolId === 'calc-juros') {

                var btn = document.getElementById('calcJBtn');

                if (btn) {

                    btn.addEventListener('click', function () {

                        var cap =
                            parseFloat(
                                document.getElementById('capJ').value
                            ) || 0;

                        var taxa =
                            parseFloat(
                                document.getElementById('taxJ').value
                            ) || 0;

                        var mes =
                            parseInt(
                                document.getElementById('mesJ').value
                            ) || 0;

                        var tipo =
                            document.getElementById('tipoJ').value;

                        var res;

                        if (tipo === 'simples') {

                            res =
                                cap *
                                (
                                    1 +
                                    (taxa / 100) * mes
                                );

                        } else {

                            res =
                                cap *
                                Math.pow(
                                    1 + taxa / 100,
                                    mes
                                );
                        }

                        document.getElementById('resJ').innerHTML =
                            'Montante: R$ ' +
                            res.toFixed(2) +
                            '<br>Juros: R$ ' +
                            (res - cap).toFixed(2);
                    });
                }
            }

            else if (toolId === 'calc-porcentagem') {

                function showResult(id, val) {

                    var el = document.getElementById(id);

                    if (el) {
                        el.classList.remove('d-none');
                        el.innerText = val;
                    }
                }


                var btn1 = document.getElementById('calc1Btn');

                if (btn1) {
                    btn1.onclick = function () {

                        var a =
                            parseFloat(
                                document.getElementById('perc1').value
                            ) || 0;

                        var b =
                            parseFloat(
                                document.getElementById('total1').value
                            ) || 0;

                        showResult(
                            'res1',
                            a + '% de ' + b + ' = ' +
                            (a * b / 100).toFixed(2)
                        );
                    };
                }


                var btn2 = document.getElementById('calc2Btn');

                if (btn2) {
                    btn2.onclick = function () {

                        var a =
                            parseFloat(
                                document.getElementById('val2').value
                            ) || 0;

                        var b =
                            parseFloat(
                                document.getElementById('tot2').value
                            ) || 0;

                        showResult(
                            'res2',
                            a + ' é ' +
                            (a / b * 100).toFixed(2) +
                            '% de ' +
                            b
                        );
                    };
                }


                var btn3 = document.getElementById('calc3Btn');

                if (btn3) {
                    btn3.onclick = function () {

                        var a =
                            parseFloat(
                                document.getElementById('ini3').value
                            ) || 0;

                        var b =
                            parseFloat(
                                document.getElementById('fim3').value
                            ) || 0;

                        showResult(
                            'res3',
                            'Aumento de ' +
                            (((b - a) / a) * 100).toFixed(2) +
                            '%'
                        );
                    };
                }


                var btn4 = document.getElementById('calc4Btn');

                if (btn4) {
                    btn4.onclick = function () {

                        var a =
                            parseFloat(
                                document.getElementById('val4').value
                            ) || 0;

                        var b =
                            parseFloat(
                                document.getElementById('tot4').value
                            ) || 0;

                        showResult(
                            'res4',
                            a + ' sobre ' +
                            b + ' = ' +
                            (a / b * 100).toFixed(2) +
                            '%'
                        );
                    };
                }


                var btn5 = document.getElementById('calc5Btn');

                if (btn5) {
                    btn5.onclick = function () {

                        var a =
                            parseFloat(
                                document.getElementById('val5').value
                            ) || 0;

                        var b =
                            parseFloat(
                                document.getElementById('pct5').value
                            ) || 0;

                        showResult(
                            'res5',
                            'Resultado: ' +
                            (a * (1 + b / 100)).toFixed(2)
                        );
                    };
                }


                var btn6 = document.getElementById('calc6Btn');

                if (btn6) {
                    btn6.onclick = function () {

                        var a =
                            parseFloat(
                                document.getElementById('val6').value
                            ) || 0;

                        var b =
                            parseFloat(
                                document.getElementById('pct6').value
                            ) || 0;

                        showResult(
                            'res6',
                            'Resultado: ' +
                            (a * (1 - b / 100)).toFixed(2)
                        );
                    };
                }


                var btn7 = document.getElementById('calc7Btn');

                if (btn7) {
                    btn7.onclick = function () {

                        var a =
                            parseFloat(
                                document.getElementById('pct7').value
                            ) || 0;

                        var b =
                            parseFloat(
                                document.getElementById('final7').value
                            ) || 0;

                        showResult(
                            'res7',
                            'Valor inicial: ' +
                            (b / (1 + a / 100)).toFixed(2)
                        );
                    };
                }


                var btn8 = document.getElementById('calc8Btn');

                if (btn8) {
                    btn8.onclick = function () {

                        var a =
                            parseFloat(
                                document.getElementById('pct8').value
                            ) || 0;

                        var b =
                            parseFloat(
                                document.getElementById('final8').value
                            ) || 0;

                        showResult(
                            'res8',
                            'Valor inicial: ' +
                            (b / (1 - a / 100)).toFixed(2)
                        );
                    };
                }
            }

            else if (toolId === 'calc-financiamento') {

                var btnFin =
                    document.getElementById('calcFinBtn');

                if (btnFin) {

                    btnFin.addEventListener('click', function () {

                        var v =
                            parseFloat(
                                document.getElementById('fv').value
                            ) || 0;

                        var tx =
                            parseFloat(
                                document.getElementById('ftax').value
                            ) || 0;

                        var m =
                            parseInt(
                                document.getElementById('fmes').value
                            ) || 1;

                        var tipo =
                            document.getElementById('ftipo').value;

                        var res =
                            calcFinanciamento(
                                v,
                                tx,
                                m,
                                tipo
                            );

                        document.getElementById('resFin').innerHTML =
                            'Parcela ~R$ ' +
                            res.prestacao +
                            '<br>Total R$ ' +
                            res.total +
                            '<br>Juros R$ ' +
                            res.juros;
                    });
                }
            }

            else if (toolId === 'format-json') {

                var fmtBtn =
                    document.getElementById('fmtJson');

                if (fmtBtn) {

                    fmtBtn.onclick = function () {

                        var txt =
                            document.getElementById('jsonInp').value;

                        document.getElementById('jsonOut').innerText =
                            formatJSON(txt);
                    };
                }


                var clrBtn =
                    document.getElementById('clrJson');

                if (clrBtn) {

                    clrBtn.onclick = function () {

                        document.getElementById('jsonInp').value = '';

                        document.getElementById('jsonOut').innerText =
                            'Aguardando';
                    };
                }
            }

            else if (toolId === 'gerar-cartao') {

                var cardBtn =
                    document.getElementById('genCardBtn');

                if (cardBtn) {

                    cardBtn.addEventListener('click', function () {

                        var c = gerarCartaoLuhn();

                        document.getElementById('cardRes').innerHTML =
                            c.numero +
                            '<br>Val: ' +
                            c.validade +
                            ' CVV: ' +
                            c.cvv;
                    });
                }
            }

            else if (toolId === 'gerar-cpf') {

                var spanCpf =
                    document.getElementById('cpfSpan');

                var genCpf =
                    document.getElementById('genCpfBtn');

                var copyCpf =
                    document.getElementById('copyCpfBtn');


                if (genCpf) {

                    genCpf.onclick = function () {

                        if (spanCpf) {
                            spanCpf.innerText = gerarCPF();
                        }
                    };
                }


                if (copyCpf) {

                    copyCpf.onclick = function () {

                        if (
                            spanCpf &&
                            spanCpf.innerText !== '---'
                        ) {
                            copyClip(
                                spanCpf.innerText,
                                copyCpf
                            );
                        }
                    };
                }


                if (genCpf) {
                    genCpf.click();
                }
            }

            else if (toolId === 'validar-cpf') {

                var valBtn =
                    document.getElementById('validarCpfBtn');

                if (valBtn) {

                    valBtn.addEventListener('click', function () {

                        var cpf =
                            document.getElementById('cpfValidar').value;

                        var valido =
                            validarCPF(cpf);

                        document.getElementById('validaRes').innerHTML =
                            valido
                                ? '✅ CPF VÁLIDO!'
                                : '❌ CPF INVÁLIDO!';
                    });
                }
            }

            else if (toolId === 'gerar-cnpj') {

                var spanCnpj =
                    document.getElementById('cnpjSpan');

                var genCnpj =
                    document.getElementById('genCnpjBtn');

                var copyCnpj =
                    document.getElementById('copyCnpjBtn');


                if (genCnpj) {

                    genCnpj.onclick = function () {

                        if (spanCnpj) {
                            spanCnpj.innerText = gerarCNPJ();
                        }
                    };
                }


                if (copyCnpj) {

                    copyCnpj.onclick = function () {

                        if (
                            spanCnpj &&
                            spanCnpj.innerText !== '---'
                        ) {
                            copyClip(
                                spanCnpj.innerText,
                                copyCnpj
                            );
                        }
                    };
                }


                if (genCnpj) {
                    genCnpj.click();
                }
            }

            else if (toolId === 'gerar-senhas') {

                var spanSenha =
                    document.getElementById('senhaFinal');

                var genSenha =
                    document.getElementById('genSenhaCustomBtn');

                var copySenha =
                    document.getElementById('copySenhaCustomBtn');


                function atualizarSenha() {

                    var len =
                        parseInt(
                            document.getElementById('senhaLen').value
                        ) || 8;

                    var opts = {

                        minuscula:
                            document.getElementById('optMinus').checked,

                        maiuscula:
                            document.getElementById('optMaius').checked,

                        numeros:
                            document.getElementById('optNum').checked,

                        especiais:
                            document.getElementById('optEsp').checked
                    };

                    if (spanSenha) {
                        spanSenha.innerText =
                            gerarSenhaCustom(
                                len,
                                opts
                            );
                    }
                }


                if (genSenha) {
                    genSenha.onclick = atualizarSenha;
                }


                if (copySenha) {

                    copySenha.onclick = function () {

                        if (spanSenha) {
                            copyClip(
                                spanSenha.innerText,
                                copySenha
                            );
                        }
                    };
                }


                atualizarSenha();
            }

            else if (toolId === 'gerar-uuid') {

                var spanUuid =
                    document.getElementById('uuidSpan');

                var genUuid =
                    document.getElementById('genUuidBtn');

                var copyUuid =
                    document.getElementById('copyUuidBtn');


                if (genUuid) {

                    genUuid.onclick = function () {

                        if (spanUuid) {
                            spanUuid.innerText =
                                gerarUUID();
                        }
                    };
                }


                if (copyUuid) {

                    copyUuid.onclick = function () {

                        if (spanUuid) {
                            copyClip(
                                spanUuid.innerText,
                                copyUuid
                            );
                        }
                    };
                }


                if (genUuid) {
                    genUuid.click();
                }
            }

            else if (toolId === 'conversor-moedas') {

                var convMoeda =
                    document.getElementById('convMoedaBtn');

                if (convMoeda) {

                    convMoeda.addEventListener(
                        'click',
                        function () {

                            var val =
                                parseFloat(
                                    document.getElementById('moedaVal').value
                                ) || 0;

                            var de =
                                document.getElementById('moedaDe').value;

                            var para =
                                document.getElementById('moedaPara').value;

                            var res =
                                converterMoeda(
                                    val,
                                    de,
                                    para
                                );

                            document.getElementById('moedaRes').innerHTML =
                                val +
                                ' ' +
                                de +
                                ' = ' +
                                res +
                                ' ' +
                                para;
                        }
                    );
                }
            }

            else if (toolId === 'contador-palavras') {

                var textarea =
                    document.getElementById('textoContar');


                function updateContador() {

                    if (!textarea) {
                        return;
                    }

                    var txt =
                        textarea.value;

                    var words =
                        txt.trim()
                            ? txt.trim().split(/\s+/).length
                            : 0;

                    var chars =
                        txt.length;

                    var semEspacos =
                        txt.replace(/\s/g, '').length;

                    var stats =
                        document.getElementById('statsContador');

                    if (stats) {

                        stats.innerHTML =
                            'Palavras: ' +
                            words +
                            ' | Caracteres: ' +
                            chars +
                            ' | (sem espaços: ' +
                            semEspacos +
                            ')';
                    }
                }


                if (textarea) {
                    textarea.addEventListener(
                        'input',
                        updateContador
                    );

                    updateContador();
                }
            }

            else if (toolId === 'sorteador-numeros') {

                var sortear =
                    document.getElementById('sortearBtn');

                if (sortear) {

                    sortear.addEventListener(
                        'click',
                        function () {

                            var min =
                                parseInt(
                                    document.getElementById('minSorte').value
                                ) || 0;

                            var max =
                                parseInt(
                                    document.getElementById('maxSorte').value
                                ) || 100;

                            var qtd =
                                parseInt(
                                    document.getElementById('qtdSorte').value
                                ) || 1;

                            var nums = [];

                            for (var i = 0; i < qtd; i++) {

                                nums.push(
                                    Math.floor(
                                        Math.random() *
                                        (max - min + 1) +
                                        min
                                    )
                                );
                            }

                            document.getElementById('sorteRes').innerHTML =
                                'Números sorteados: ' +
                                nums.join(', ');
                        }
                    );
                }
            }

            else if (toolId === 'conversor-unidades') {

                var convUnid =
                    document.getElementById('convUnidBtn');

                if (convUnid) {

                    convUnid.addEventListener(
                        'click',
                        function () {

                            var val =
                                parseFloat(
                                    document.getElementById('unidVal').value
                                ) || 0;

                            var de =
                                document.getElementById('unidDe').value;

                            var para =
                                document.getElementById('unidPara').value;

                            var res =
                                converterUnidades(
                                    val,
                                    de,
                                    para
                                );

                            document.getElementById('unidRes').innerHTML =
                                val +
                                ' ' +
                                de +
                                ' = ' +
                                res +
                                ' ' +
                                para;
                        }
                    );
                }
            }

            else if (toolId === 'gerador-qr') {

                var genQr =
                    document.getElementById('gerarQrBtn');

                if (genQr) {

                    genQr.addEventListener(
                        'click',
                        function () {

                            var txt =
                                document.getElementById('qrTexto').value;

                            var qrImg =
                                document.getElementById('qrImg');

                            if (txt && qrImg) {
                                qrImg.src = qrUrl(txt);
                            }
                        }
                    );
                }


                if (genQr) {
                    genQr.click();
                }
            }
        }


        // ========== NAVEGAÇÃO ==========

        var contentDiv =
            document.getElementById('toolContent');


        function loadTool(toolId, withFade) {

            // O JS é global e pode estar sendo carregado
            // em páginas que não possuem o #toolContent.
            if (!contentDiv) {
                return;
            }

            if (withFade !== false) {
                contentDiv.style.opacity = '0';
            }

            setTimeout(function () {

                // Verifica novamente caso o elemento tenha
                // sido removido antes do timeout.
                if (!contentDiv) {
                    return;
                }

                contentDiv.innerHTML =
                    renderTool(toolId);

                bindEvents(toolId);

                if (withFade !== false) {
                    contentDiv.style.opacity = '1';
                }

            }, 130);
        }


        /*
        * IMPORTANTE:
        * Todo o código abaixo só é inicializado quando
        * #toolContent existir na página.
        *
        * Dessa forma, o mesmo JS pode ficar no footer
        * de todas as páginas sem gerar erros em:
        *
        * /sobre
        * /contato
        * /blog
        * etc.
        */

        if (contentDiv) {


            // ========== SIDEBAR NAVIGATION ==========

            var navLinks =
                document.querySelectorAll(
                    '#toolsNav .nav-link'
                );


            for (var i = 0; i < navLinks.length; i++) {

                navLinks[i].addEventListener(
                    'click',
                    function (e) {

                        e.preventDefault();

                        var tool =
                            this.getAttribute('data-tool');

                        if (tool) {

                            for (
                                var j = 0;
                                j < navLinks.length;
                                j++
                            ) {
                                navLinks[j].classList.remove('active');
                            }

                            this.classList.add('active');

                            loadTool(
                                tool,
                                true
                            );
                        }
                    }
                );
            }


            // ========== HEADER CATEGORY FILTER ==========

            var headerLinks =
                document.querySelectorAll(
                    '.navbar-nav .nav-link'
                );


            for (
                var i = 0;
                i < headerLinks.length;
                i++
            ) {

                headerLinks[i].addEventListener(
                    'click',
                    function (e) {

                        var category =
                            this.getAttribute(
                                'data-category'
                            );

                        if (!category) {
                            return;
                        }

                        for (
                            var j = 0;
                            j < headerLinks.length;
                            j++
                        ) {
                            headerLinks[j].classList.remove(
                                'active'
                            );
                        }

                        this.classList.add('active');


                        var sidebarItems =
                            document.querySelectorAll(
                                '#toolsNav .tool-item'
                            );

                        var firstVisible = null;


                        for (
                            var k = 0;
                            k < sidebarItems.length;
                            k++
                        ) {

                            var itemCat =
                                sidebarItems[k].getAttribute(
                                    'data-cat'
                                );


                            if (
                                category === 'all' ||
                                itemCat === category
                            ) {

                                sidebarItems[k].style.display =
                                    'block';

                                if (!firstVisible) {
                                    firstVisible =
                                        sidebarItems[k];
                                }

                            } else {

                                sidebarItems[k].style.display =
                                    'none';
                            }
                        }


                        if (
                            firstVisible &&
                            category !== 'all'
                        ) {

                            firstVisible.click();

                        } else if (
                            category === 'all'
                        ) {

                            var defaultTool =
                                document.querySelector(
                                    '#toolsNav .tool-item[data-tool="calc-juros"]'
                                );

                            if (defaultTool) {
                                defaultTool.click();
                            }
                        }
                    }
                );
            }


            // ========== FOOTER NAVIGATION ==========

            var footerLinks =
                document.querySelectorAll(
                    '[data-nav-ferramenta]'
                );


            for (
                var i = 0;
                i < footerLinks.length;
                i++
            ) {

                footerLinks[i].addEventListener(
                    'click',
                    function (e) {

                        e.preventDefault();

                        var tool =
                            this.getAttribute(
                                'data-nav-ferramenta'
                            );

                        if (tool) {

                            loadTool(
                                tool,
                                true
                            );


                            for (
                                var j = 0;
                                j < navLinks.length;
                                j++
                            ) {

                                if (
                                    navLinks[j].getAttribute(
                                        'data-tool'
                                    ) === tool
                                ) {

                                    navLinks[j].classList.add(
                                        'active'
                                    );

                                } else {

                                    navLinks[j].classList.remove(
                                        'active'
                                    );
                                }
                            }
                        }
                    }
                );
            }


            // ========== FERRAMENTA INICIAL ==========

            loadTool(
                'calc-juros',
                false
            );
        }

    </script>

    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js" defer></script>

    <script src="{{ asset('build/client/bootstrap/js/bootstrap.bundle.js') }}" defer></script>
    <script src="{{ asset('build/client/lgpd/script.js') }}" defer></script>
    <script src="{{ asset('build/client/themes/whi-web/tp-03/js/default.js') }}" defer></script>
    <script src="{{ asset('build/client/js/default.js') }}" defer></script>
</body>
</html>