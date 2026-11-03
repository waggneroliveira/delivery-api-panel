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


    <link rel="preload" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css"></noscript>

    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"></noscript>

    <link href="{{ asset('build/client/lgpd/style.css') }}" rel="stylesheet" type="text/css">

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <link href="{{ asset('build/client/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">

    <link rel="preload" href="{{ asset('build/client/bootstrap-icons/bootstrap-icons.css') }}" as="style" onload="this.rel='stylesheet'">

    <link href="{{ asset('build/client/themes/whi-web/tp-02/css/style.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('build/client/css/default.css') }}" rel="stylesheet" type="text/css">


    {{-- ============================================================
    SCHEMA.ORG
    ============================================================ --}}

    <script type="application/ld+json">
    {!! json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>

    <script src="https://cdn.jsdelivr.net/npm/gsap@3.15/dist/gsap.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.15/dist/ScrollTrigger.min.js" defer></script>
</head>

<body>
    <div id="organization" hidden></div>

    @include('client/script-seo-google/script-body-nocript')

    @include('client/themes/whi-web/tp-02/includes/lgpd/lgpd')

     @if (isset($contact) && $contact->whatsapp <> null)
        @php
            // Remove caracteres não numéricos do telefone
            $phone = preg_replace('/\D/', '', $contact->whatsapp);

            // Monta mensagem com ícones e quebras de linha
            $mensagem = "Olá! Encontrei seu site e gostaria de conhecer mais sobre os planos disponíveis.%0A";
        @endphp

        <!-- Container do WhatsApp Flutuante com ID para GSAP -->
        <div id="whatsapp-floating-container" class="wa-float-wrapper">
            <!-- Tooltip / Balão de Mensagem Impactante -->
            <div class="wa-tooltip">
                <span class="wa-tooltip-status"></span>
                <div class="wa-tooltip-text">
                    <strong>Precisa de ajuda?</strong>
                    <small>Fale conosco no WhatsApp</small>
                </div>
            </div>

            <!-- Botão Principal -->
            <a href="https://wa.me/55{{ $phone }}?text={{ $mensagem }}" 
            class="wa-float-btn" 
            aria-label="Fale conosco no WhatsApp" 
            target="_blank" 
            rel="noopener noreferrer">
            
                <!-- Anel de Pulso / Efeito de Onda -->
                <span class="wa-pulse-ring"></span>
                <span class="wa-pulse-ring delay"></span>

                <!-- Ícone SVG -->
                <svg class="wa-icon" viewBox="0 0 32 32" aria-hidden="true">
                    <path d="M19.11 17.27c-.23-.12-1.37-.67-1.58-.75-.21-.08-.36-.12-.52.12-.16.23-.6.74-.74.89-.14.15-.27.17-.5.06-.23-.12-.97-.36-1.85-1.12-.68-.6-1.14-1.34-1.27-1.57-.13-.23-.01-.35.1-.47.1-.1.23-.27.35-.4.12-.13.16-.23.24-.39.08-.16.04-.3-.02-.42-.06-.12-.52-1.25-.71-1.72-.19-.46-.38-.4-.52-.4h-.45c-.16 0-.42.06-.64.3-.22.23-.84.82-.84 2 0 1.18.86 2.32.98 2.48.12.16 1.69 2.58 4.1 3.61.57.25 1.01.4 1.35.52.57.18 1.1.16 1.52.1.46-.07 1.37-.56 1.57-1.1.19-.54.19-1 .13-1.1-.06-.1-.21-.16-.44-.27zM16 3.2c-7.06 0-12.8 5.73-12.8 12.8 0 2.26.61 4.36 1.67 6.17L3.2 28.8l6.78-1.6c1.74.95 3.74 1.5 5.87 1.5 7.07 0 12.8-5.73 12.8-12.8S23.07 3.2 16 3.2zm0 22.94c-1.98 0-3.81-.58-5.35-1.57l-.38-.24-4.02.95.95-3.92-.25-.4a10.58 10.58 0 0 1-1.64-5.62c0-5.86 4.77-10.62 10.63-10.62S26.62 9.38 26.62 15.24 21.86 26.14 16 26.14z"/>
                </svg>

                <!-- Selo de Notificação "1" -->
                <span class="wa-badge">1</span>
            </a>
        </div>
    @endif

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
        @media (max-width: 575.98px) {
            .hero-title.font-50{
                font-size: 1.3rem !important
            }
            .font-45{
                font-size: 1.8125rem !important;
            }
        }
        .feature-card p{
            font-size: 0.95rem;
        }
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

    <header class="shadow-sm bg-header">
        <nav class="navbar navbar-expand-lg navbar-light container py-3 px-3 px-lg-0">            
            <!-- Logo -->
            <a class="navbar-brand d-flex align-items-center" href="{{route('index')}}">
                <img src="{{asset('storage/' .$tenantTheme->path_image_logo_header)}}" alt="{{ config('app.name') }}" height="65" loading="lazy">
            </a>

            <!-- Toggle mobile -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Abrir menu de navegação">
                <span class="navbar-toggler-icon" aria-hidden="true"></span>
            </button>

            <!-- Menu -->
            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav mx-auto m-auto mb-2 mb-lg-0 gap-lg-2">
                    <li class="nav-item">
                        <a class="nav-link font-changa font-18 p-1 font-semibold font-header text-color-header active" href="{{ route('index') }}" aria-label="Página inicial">
                            <svg
                                width="26"
                                height="26"
                                viewBox="0 0 26 26"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg"
                                aria-hidden="true"
                                focusable="false"
                            >
                                <path
                                    d="M25.7104 13.5748C26.0965 13.1943 26.0965 12.5817 25.7104 12.2011L13.6222 0.285425C13.2361 -0.0951416 12.6147 -0.0951416 12.2286 0.285425L0.289558 12.054C-0.0965193 12.4346 -0.0965193 13.0472 0.289558 13.4277C0.675635 13.8083 1.29705 13.8083 1.68314 13.4277L1.88771 13.2261V25.0296C1.88771 25.5648 2.32917 26 2.87213 26H9.60635H9.62634H16.3787H16.3987H23.1282C23.6711 26 24.1126 25.5648 24.1126 25.0296V13.3732L24.3171 13.5748C24.5094 13.7644 24.7617 13.8584 25.0139 13.8584C25.2662 13.8584 25.5182 13.7659 25.7104 13.5748ZM15.3926 24.0548H10.6091V17.3744H15.3926V24.0548ZM22.1421 24.0548H17.3614V16.404C17.3614 15.8688 16.9199 15.4337 16.377 15.4337H9.62464C9.08168 15.4337 8.64023 15.8688 8.64023 16.404V24.0548H3.85949V11.2809L12.9284 2.34148L22.1465 11.428V24.0548H22.1421Z"
                                    fill="#2E2E2E"
                                />
                            </svg>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link font-changa font-18 font-semibold font-header text-color-header font-md" href="{{ request()->routeIs('index') ? '#about-us' : route('index') . '#about-us' }}">Sobre o Ecossistema</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link font-changa font-18 font-semibold font-header text-color-header font-md" href="{{ request()->routeIs('index') ? '#pilar' : route('index') . '#pilar' }}">Pilares</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link font-changa font-18 font-semibold font-header text-color-header font-md" href="{{ request()->routeIs('index') ? '#our-exhibitions' : route('index') . '#our-exhibitions' }}">Para você</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link font-changa font-18 font-semibold font-header text-color-header font-md" href="{{ request()->routeIs('index') ? '#solutions-section' : route('index') . '#solutions-section' }}">Para empresas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link font-changa font-18 font-semibold font-header text-color-header font-md" href="{{ request()->routeIs('index') ? '#depoiment' : route('index') . '#depoiment' }}">Depoimentos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link font-changa font-18 font-semibold font-header text-color-header font-md" href="{{ request()->routeIs('index') ? '#contact' : route('index') . '#contact' }}">Contato</a>
                    </li>
                </ul>

                <!-- Botão -->
                <div class="d-flex justify-content-center gap-2 align-items-center btn-header bg-button-one rounded-pill py-2 px-3 px-lg-3 px-xl-4 hover-zoom">
                    <a href="{{$tenantTheme->link_header}}" target="_blank" rel="noopener noreferrer" class="font-changa font-15 font-medium text-decoration-none color-button-one">
                        {{ $tenantTheme->btn_title_header }}
                    </a>

                    <svg width="9" height="13" viewBox="0 0 9 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M1.78794 12.474L8.02494 6.237L1.78794 0L0.02079 1.76715L4.46985 6.237L0 10.7069L1.78794 12.474Z" fill="var(--color-button-one)"/>
                    </svg>

                </div>
            </div>
        </nav>
    </header>

    <main>
        @yield('content') 
    </main>

    <footer class="bg-footer pt-3 pt-lg-5 pb-3">
        <div class="container">

            <!-- Linha principal -->
            <div class="row align-items-start">

                <!-- Logo + botão -->
                <div class="col-lg-4 mb-4 mb-lg-0">
                    @php
                        $logoPath = storage_path('app/public/' . $tenantTheme->path_image_logo_footer);
                        $dimensions = file_exists($logoPath) ? @getimagesize($logoPath) : null;
                    @endphp
                    <img loading="lazy" src="{{asset('storage/' .$tenantTheme->path_image_logo_footer)}}" alt="{{ $tenantTheme->name }}" width="{{ $dimensions[0] ?? 200 }}" height="{{ $dimensions[1] ?? 60 }}" style="max-width:100%;height:auto;">
                </div>

                <!-- Mapa do site -->
                <div class="col-lg-6 mb-4 mb-0">
                    <div class="font-changa text-color-footer font-16 font-bold mb-3 position-relative d-inline-block font-changa font-16 font-medium">
                        Mapa do Site
                        <span class="d-block bg-accent-color mt-1" style="height:3px; width:40px;"></span>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <ul class="list-unstyled">
                                <li><a href="{{ request()->routeIs('index') ? '#about-us' : route('index') . '#about-us' }}" class="text-color-footer font-changa font-16 font-regular text-decoration-none d-block mb-2">Quem Somos</a></li>
                                <li><a href="{{ request()->routeIs('index') ? '#pilar' : route('index') . '#pilar' }}" class="text-color-footer font-changa font-16 font-regular text-decoration-none d-block mb-2">Pilares</a></li>
                                <li><a href="{{ request()->routeIs('index') ? '#our-exhibitions' : route('index') . '#our-exhibitions' }}" class="text-color-footer font-changa font-16 font-regular text-decoration-none d-block mb-2">Para você</a></li>
                            </ul>
                        </div>

                        <div class="col-6">
                            <ul class="list-unstyled">
                                <li><a href="{{ request()->routeIs('index') ? '#solutions-section' : route('index') . '#solutions-section' }}" class="text-color-footer font-changa font-16 font-regular text-decoration-none d-block mb-2">Para empresas</a></li>
                                <li><a href="{{ request()->routeIs('index') ? '#depoiment' : route('index') . '#depoiment' }}" class="text-color-footer font-changa font-16 font-regular text-decoration-none d-block mb-2">Depoimentos</a></li>
                                <li><a href="{{ request()->routeIs('index') ? '#contact' : route('index') . '#contact' }}" class="text-color-footer font-changa font-16 font-regular text-decoration-none d-block mb-2">Contato</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Redes sociais -->
                @if (isset($contact) && (
                $contact->link_insta ||
                $contact->link_face ||
                $contact->link_tik_tok
                ))                    
                    <div class="col-lg-2 text-lg-end">
                        <div class="d-flex gap-3 justify-content-lg-end">
                            @if ($contact->link_insta != null)
                                <a href="{{ $contact->link_insta }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="text-color-footer fs-5"
                                aria-label="Instagram">
                                    <i class="bi bi-instagram" aria-hidden="true"></i>
                                </a>
                            @endif

                            @if ($contact->link_face != null)
                                <a href="{{ $contact->link_face }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="text-color-footer fs-5"
                                aria-label="Facebook">
                                    <i class="bi bi-facebook" aria-hidden="true"></i>
                                </a>
                            @endif

                            @if ($contact->link_tik_tok != null)
                                <a href="{{ $contact->link_tik_tok }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="text-color-footer fs-5"
                                aria-label="LinkedIn">
                                    <i class="bi bi-linkedin" aria-hidden="true"></i>
                                </a>
                            @endif


                        </div>
                    </div>
                @endif

            </div>

            <!-- Linha inferior -->
            <hr class="border-light opacity-25 my-0 mb-3 my-lg-4 border-color-footer">

            <div class="row align-items-center">
                @php
                    $cnpj = !empty($tenantTheme->cnpj) ? preg_replace('/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})$/', '$1.$2.$3/$4-$5', preg_replace('/\D/', '', $tenantTheme->cnpj)) : '';
                @endphp

                <div class="row align-items-center g-4 m-0">
                    <div class="col-12 col-lg-5 text-center text-lg-start small text-color-footer m-0 p-0">
                        <p id="footer-text" class="mb-0 text-color-footer"></p>
                    </div>

                    <div class="col-12 col-lg-3 text-center small text-color-footer mt-0">
                        @if ($tenantTheme->privacy_policy <> null)                            
                            <a href="#" class="text-color-footer text-decoration-none" data-bs-toggle="modal" data-bs-target="#privacyModal">Política de Privacidade</a>
                            <span class="mx-1">|</span>
                        @endif
                        @if ($tenantTheme->terms_of_use <> null)                            
                            <a href="#" class="text-color-footer text-decoration-none" data-bs-toggle="modal" data-bs-target="#termsModal">Termos de Uso</a>
                        @endif
                    </div>

                    <!-- Modal Política de Privacidade -->
                    <div class="modal fade" id="privacyModal" tabindex="-1" aria-labelledby="privacyModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="privacyModalLabel">Política de Privacidade</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                                </div>
                                <div class="modal-body">
                                    {!! $tenantTheme->privacy_policy !!}
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Termos de Uso -->
                    <div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="termsModalLabel">Termos de Uso</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                                </div>
                                <div class="modal-body">
                                    {!! $tenantTheme->terms_of_use !!}
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-4 m-0 p-0">
                        <div class="d-flex justify-content-center justify-content-lg-end align-items-center gap-3">
                            <a href="http://whiweb.com.br/" target="_blank" rel="noopener noreferrer" class="text-color-footer text-decoration-none d-flex align-items-center gap-2">
                                <span class="font-13">Sistema</span>
                                <img loading="lazy" src="{{asset('build/client/themes/default/images/whi-web.png')}}" title="Whi Web" alt="WHI Web" height="50" class="logo-system">
                            </a>

                            <span class="text-color-footer opacity-50">|</span>

                            <a href="https://www.whi.dev.br/" target="_blank" rel="noopener noreferrer" class="text-color-footer text-decoration-none d-flex align-items-center gap-2">
                                <span class="font-13">Desenvolvido por</span>
                                <img loading="lazy" src="{{asset('build/client/themes/default/images/whi.png')}}" title="Agência WHI" alt="WHI" height="25" class="logo-system">
                            </a>
                        </div>
                    </div>
                </div>

                <script>
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
     
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" defer></script>

    <script src="{{ asset('build/client/bootstrap/js/bootstrap.bundle.js') }}" defer></script>
    <script src="{{ asset('build/client/lgpd/script.js') }}" defer></script>
    <script src="{{ asset('build/client/themes/whi-web/tp-02/js/default.js') }}" defer></script>
    <script src="{{ asset('build/client/themes/whi-web/tp-02/js/gsap-efect.js') }}" defer></script>
    <script src="{{ asset('build/client/js/default.js') }}" defer></script>

    {{-- Modais alert --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof Swal === 'undefined') return;

            const successMessage = @json(session('success'));
            const errorMessage = @json(session('error'));

            if (!successMessage && !errorMessage) return;

            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timerProgressBar: true,
                timer: 3000,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer);
                    toast.addEventListener('mouseleave', Swal.resumeTimer);
                }
            });

            if (successMessage) {
                Toast.fire({
                    icon: 'success',
                    title: successMessage,
                    background: '#f0fdf4',
                    color: '#166534',
                    iconColor: '#22c55e'
                });
            }

            if (errorMessage) {
                Toast.fire({
                    icon: 'error',
                    title: errorMessage,
                    background: '#fef2f2',
                    color: '#991b1b',
                    iconColor: '#ef4444'
                });
            }
        });
    </script>

    {{-- WhatsApp --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (typeof gsap === 'undefined') return;

            const waContainer = document.querySelector('#whatsapp-floating-container');

            if (!waContainer) return;

            const waBtn = waContainer.querySelector('.wa-float-btn');
            const waIcon = waContainer.querySelector('.wa-icon');
            const waTooltip = waContainer.querySelector('.wa-tooltip');
            const waBadge = waContainer.querySelector('.wa-badge');

            if (!waBtn || !waIcon) return;

            // Entrada principal
            const tlEntry = gsap.timeline({
                defaults: {
                    ease: 'back.out(1.7)',
                    duration: 0.8
                }
            });

            tlEntry.from(waContainer, {
                scale: 0,
                opacity: 0,
                y: 40,
                delay: 1
            });

            if (waTooltip) {
                tlEntry.from(waTooltip, {
                    x: 30,
                    opacity: 0,
                    scale: 0.8,
                    duration: 0.6
                }, '-=0.3');
            }

            if (waBadge) {
                tlEntry.from(waBadge, {
                    scale: 0,
                    duration: 0.4
                }, '-=0.4');
            }

            // Animação periódica do ícone
            gsap.to(waIcon, {
                rotation: 15,
                duration: 0.1,
                repeat: 5,
                yoyo: true,
                repeatDelay: 6,
                ease: 'power1.inOut'
            });

            // Hover
            waBtn.addEventListener('mouseenter', () => {
                gsap.to(waBtn, {
                    scale: 1.1,
                    duration: 0.3,
                    ease: 'power2.out'
                });

                gsap.to(waIcon, {
                    scale: 1.15,
                    rotate: -10,
                    duration: 0.3,
                    ease: 'power2.out'
                });

                if (waTooltip) {
                    gsap.to(waTooltip, {
                        x: -5,
                        duration: 0.3,
                        ease: 'power2.out'
                    });
                }
            });

            waBtn.addEventListener('mouseleave', () => {
                gsap.to(waBtn, {
                    scale: 1,
                    duration: 0.3,
                    ease: 'power2.out'
                });

                gsap.to(waIcon, {
                    scale: 1,
                    rotate: 0,
                    duration: 0.3,
                    ease: 'power2.out'
                });

                if (waTooltip) {
                    gsap.to(waTooltip, {
                        x: 0,
                        duration: 0.3,
                        ease: 'power2.out'
                    });
                }
            });
        });
    </script>
</body>
</html>