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
    <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link rel="stylesheet"
            href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap">
    </noscript>

    {{-- ============================================================
    BIBLIOTECAS CSS
    ============================================================ --}}

    <link href="{{ asset('build/client/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('build/client/themes/ecommerce/tp-02/css/style.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('build/client/css/default.css') }}" rel="stylesheet" type="text/css">
    <link rel="preload" href="{{ asset('build/client/lgpd/style.css') }}" as="style"  onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link rel="stylesheet"  href="{{ asset('build/client/lgpd/style.css') }}">
    </noscript>

    <link rel="preload" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css"></noscript>

    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"></noscript>

    <link rel="preload" href="{{ asset('build/client/bootstrap-icons/bootstrap-icons.css') }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="{{ asset('build/client/bootstrap-icons/bootstrap-icons.css') }}"></noscript>

    <link rel="preload" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css"></noscript>


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

    @include('client/themes/ecommerce/tp-02/includes/lgpd/lgpd')

    @if (isset($contact) && $contact->whatsapp <> null)
        @php
            // Remove caracteres não numéricos do telefone
            $phone = preg_replace('/\D/', '', $contact->whatsapp);

            // Monta mensagem com ícones e quebras de linha
            $mensagem = "Olá! Encontrei seu site e gostaria de conhecer mais sobre os planos disponíveis.%0A";
        @endphp

        <a href="https://wa.me/55{{ $phone }}?text={{ $mensagem }}" class="whatsapp-float" aria-label="Fale conosco no WhatsApp" target="_blank" rel="noopener noreferrer">
            <!-- Ícone SVG do WhatsApp -->
            <svg viewBox="0 0 32 32" aria-hidden="true">
                <path d="M19.11 17.27c-.23-.12-1.37-.67-1.58-.75-.21-.08-.36-.12-.52.12-.16.23-.6.74-.74.89-.14.15-.27.17-.5.06-.23-.12-.97-.36-1.85-1.12-.68-.6-1.14-1.34-1.27-1.57-.13-.23-.01-.35.1-.47.1-.1.23-.27.35-.4.12-.13.16-.23.24-.39.08-.16.04-.3-.02-.42-.06-.12-.52-1.25-.71-1.72-.19-.46-.38-.4-.52-.4h-.45c-.16 0-.42.06-.64.3-.22.23-.84.82-.84 2 0 1.18.86 2.32.98 2.48.12.16 1.69 2.58 4.1 3.61.57.25 1.01.4 1.35.52.57.18 1.1.16 1.52.1.46-.07 1.37-.56 1.57-1.1.19-.54.19-1 .13-1.1-.06-.1-.21-.16-.44-.27zM16 3.2c-7.06 0-12.8 5.73-12.8 12.8 0 2.26.61 4.36 1.67 6.17L3.2 28.8l6.78-1.6c1.74.95 3.74 1.5 5.87 1.5 7.07 0 12.8-5.73 12.8-12.8S23.07 3.2 16 3.2zm0 22.94c-1.98 0-3.81-.58-5.35-1.57l-.38-.24-4.02.95.95-3.92-.25-.4a10.58 10.58 0 0 1-1.64-5.62c0-5.86 4.77-10.62 10.63-10.62S26.62 9.38 26.62 15.24 21.86 26.14 16 26.14z"/>
            </svg>
        </a>
    @endif
    
    <style>
        :root {
            /* Cores Gerais */
            --primary-color: {{ $tenantTheme->primary_color ?: '#10513D' }};
            --secondary-color: {{ $tenantTheme->secondary_color ?: '#FDC20C' }};
            --accent-color: {{ $tenantTheme->accent_color ?: 'rgba(16, 81, 61, 0.5)' }};
            --text-color: {{ $tenantTheme->text_color ?: '#565656' }};

            /* Cores Neutras */
            --white: #FFFFFF;
            --black: #000000;
            --grey-light: #E9E9E9;
            --grey-background: #F8F9FA;

            /* Header */
            --text-color-header: {{ $tenantTheme->text_color_header ?: '#FFFFFF' }};
            --bg-header: {{ $tenantTheme->bg_header ?: '#10513D' }};

            /* Footer */
            --text-color-footer: {{ $tenantTheme->text_color_footer ?: '#FFFFFF' }};
            --bg-footer: {{ $tenantTheme->bg_footer ?: '#10513D' }};

            /* Scroll */
            --bg-scroll: {{ $tenantTheme->bg_scroll ?: '#F8F9FA' }};

            /* Botão 1 */
            --color-button-one: {{ $tenantTheme->color_button_one ?: '#FFF' }};
            --text-button-one: "{{ $tenantTheme->text_button_one ?: 'Botão 1' }}";
            --bg-button-one: {{ $tenantTheme->bg_button_one ?: '#10513D' }};

            /* Botão 2 */
            --color-button-two: {{ $tenantTheme->color_button_two ?: '#000' }};
            --text-button-two: "{{ $tenantTheme->text_button_two ?: 'Botão 2' }}";
            --bg-button-two: {{ $tenantTheme->bg_button_two ?: '#FDC20C' }};

            /* Copyright */
            --copyright-text: "{{ $tenantTheme->copyright ?: '© 2024 Todos os direitos reservados' }}";
        }

        #lgpd-banner{
            background: #000000;
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

        .bg-yellow {
            background: var(--primary-color);
        }
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

        .about li::after {
            color: var(--primary-color);
        }
        .about li::before {
            color: var(--primary-color);
        }

        .bg-grey-light {
            background: var(--grey-light);
        }

        .testimonial-swiper .swiper-pagination-bullet {
            background: var(--primary-color);
        }
        .main-swiper .swiper-pagination-bullet-active {
            background: var(--primary-color);
        }

        #lgpd-banner button {
            background: var(--primary-color);
        }

        .list-service ul li::before {
            color: var(--primary-color);
        }

        .border-warning {
            border-color: var(--primary-color) !important;
        }
        .border-color-footer {
            border-color: var(--text-color-footer) !important;
        }

        .z-index-10 {
            z-index: 10;
        }

        .line-firu {
            height: 0.1px;
            width: 80px;
            background: var(--primary-color);
            display: inline-block;
            margin-left: 10px;
        }

        .btn-filter {
            color: var(--white);
            border-color: var(--white);
        }
        .btn-filter.active {
            background: var(--white);
            border-color: var(--white);
            color: var(--primary-color);
        }

        .service-bg::after {
            content: '';
            height: 100%;
            width: 100%;
            position: absolute;
            left: 0;
            top: 0;
            background: var(--secondary-color);
            opacity: 0.8;
        }

        @supports (background: color-mix(in srgb, red 50%, transparent)) {
            .service-bg::after {
                background: color-mix(in srgb, var(--secondary-color) 80%, transparent);
                opacity: 1;
            }
        }

        .scroll-top:hover {
            background: var(--secondary-color);
        }
    </style>

    <header id="header" class="shadow-sm position w-100">
        <nav class="navbar navbar-expand-lg navbar-light container py-1 py-lg-3 px-3 px-lg-0">         
            {{-- Pegar tamanho/proporção da logo --}}
            @php
                $logoPath = storage_path('app/public/' . $tenantTheme->path_image_logo_header);
                $dimensions = file_exists($logoPath) ? @getimagesize($logoPath) : null;
            @endphp
            <!-- Logo -->
            <a class="navbar-brand d-flex align-items-center" href="{{ route('index') }}">
                <img src="{{ asset('storage/' . $tenantTheme->path_image_logo_header) }}" alt="{{ $tenantTheme->name }}" width="{{ $dimensions[0] ?? 200 }}" height="{{ $dimensions[1] ?? 60 }}" style="max-width:100%;height:auto;">
            </a>

            <!-- Toggle mobile -->
            <button class="navbar-toggler navbar navbar-expand-lg navbar-dark" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Abrir menu de navegação">
                <span class="navbar-toggler-icon" aria-hidden="true"></span>
            </button>

            <!-- Menu -->
            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav justify-content-center align-items-center gap-4 w-100 mt-0">
                    <li class="nav-item">
                        <a class="font-changa font-18 font-medium font-header text-color-header active" href="{{route('index')}}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="font-changa font-18 font-medium font-header text-color-header" href="{{ request()->routeIs('index') ? '#about' : route('index') . '#about' }}">Sobre Nós</a>
                    </li>
                    <li class="nav-item">
                        <a class="font-changa font-18 font-medium font-header text-color-header" href="{{route('products')}}">Produtos</a>
                    </li>
                    <li class="nav-item">
                        <a class="font-changa font-18 font-medium font-header text-color-header" href="{{ request()->routeIs('index') ? '#faq' : route('index') . '#faq' }}">FAQ</a>
                    </li>
                    <li class="nav-item">
                        <a class="font-changa font-18 font-medium font-header text-color-header" href="{{ request()->routeIs('index') ? '#depoiment' : route('index') . '#depoiment' }}">Depoimentos</a>
                    </li>                    
                </ul>

                <!-- Botão -->
                @if ($tenantTheme->link_header <> null)                    
                    <div class="col-auto d-flex justify-content-center gap-2 align-items-center btn-header bg-button-one rounded-2 py-3 px-4 hover-zoom">
                        
                        <a href="{{$tenantTheme->link_header}}" target="_blank" rel="noopener noreferrer" class="bg-button-one color-button-one font-changa font-15 font-medium text-decoration-none color-button-one">
                            {{ $tenantTheme->btn_title_header }}
                        </a>

                        <svg width="11" height="9" viewBox="0 0 11 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M5.77699 8.90909L5.01136 8.15341L8.16335 5.00142H0V3.90767H8.16335L5.01136 0.765624L5.77699 -7.15256e-07L10.2315 4.45454L5.77699 8.90909Z" fill="var(--color-button-one)"/>
                        </svg>

                    </div>
                @endif
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
                <div class="col-lg-4 mb-4 mb-lg-0">
                    {{-- Pegar tamanho/proporção da logo --}}
                    @php
                        $logoPath = storage_path('app/public/' . $tenantTheme->path_image_logo_footer);
                        $dimensions = file_exists($logoPath) ? @getimagesize($logoPath) : null;
                    @endphp
                    <img src="{{ asset('storage/' . $tenantTheme->path_image_logo_footer) }}" alt="{{ $tenantTheme->name }}" width="{{ $dimensions[0] ?? 200 }}" height="{{ $dimensions[1] ?? 60 }}" style="max-width:100%;height:auto;">
                    
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
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <div class="font-changa text-color-footer font-16 font-bold mb-3 position-relative d-inline-block font-changa font-16 font-medium">
                        Mapa do Site
                        <span class="d-block bg-yellow mt-1" style="height:3px; width:40px;"></span>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <ul class="list-unstyled">
                                <li><a href="{{route('index')}}" class="text-color-footer font-changa font-16 font-regular text-decoration-none d-block mb-2">Início</a></li>
                                <li><a href="{{ request()->routeIs('index') ? '#about' : route('index') . '#about' }}" class="text-color-footer font-changa font-16 font-regular text-decoration-none d-block mb-2">Sobre Nós</a></li>
                                <li><a href="{{route('products')}}" class="text-color-footer font-changa font-16 font-regular text-decoration-none d-block mb-2">Produtos</a></li>
                            </ul>
                        </div>

                        <div class="col-6">
                            <ul class="list-unstyled">
                                <li><a href="{{ request()->routeIs('index') ? '#faq' : route('index') . '#faq' }}" class="text-color-footer font-changa font-16 font-regular text-decoration-none d-block mb-2">FAQ</a></li>
                                <li><a href="{{ request()->routeIs('index') ? '#depoiment' : route('index') . '#depoiment' }}" class="text-color-footer font-changa font-16 font-regular text-decoration-none d-block mb-2">Depoimentos</a></li>
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

            <!-- Linha inferior -->
            <hr class="border-light opacity-25 my-4">

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

    <a href="#" id="scroll-top" class="scroll-top bg-scroll d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
    
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.15/dist/gsap.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.15/dist/ScrollTrigger.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" defer></script>
    <script src="{{ asset('build/client/bootstrap/js/bootstrap.bundle.js') }}" defer></script>
    <script src="{{ asset('build/client/lgpd/script.js') }}" defer></script>
    <script src="{{ asset('build/client/themes/ecommerce/tp-02/js/default.js') }}" defer></script>
    <script src="{{ asset('build/client/js/default.js') }}" defer></script>
    <script src="{{ asset('build/client/themes/ecommerce/tp-02/js/gsap-efect.js') }}" defer></script>

    <script defer>
        document.addEventListener('DOMContentLoaded', function () {
            new Swiper('.testimonial-swiper', {
                loop: true,
                spaceBetween: 24,
                pagination: {
                el: '.swiper-pagination',
                clickable: true,
                },
                breakpoints: {
                0: {
                    slidesPerView: 1.2,
                },
                768: {
                    slidesPerView: 2,
                },
                1200: {
                    slidesPerView: 3,
                }
                }
            });
        });
    </script>

    <script defer>
        const buttons = document.querySelectorAll('.btn-filter');
        const products = document.querySelectorAll('.product');

        buttons.forEach(btn => {
            btn.addEventListener('click', () => {
            buttons.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            const filter = btn.dataset.filter;

            products.forEach(product => {
                product.classList.toggle(
                'd-none',
                filter !== 'all' && !product.classList.contains(filter)
                );
            });
            });
        });
    </script>

    <script defer>
        // ===========================
        // Helpers
        // ===========================

        function norm(url) {
            if (!url) return "";
            return url.startsWith("//") ? window.location.protocol + url : url;
        }

        function toEmbed(rawUrl) {
            const urlStr = norm(rawUrl);

            if (!urlStr) return "";

            let u;

            try {
                u = new URL(urlStr);
            } catch {
                return urlStr;
            }

            const host = u.hostname.replace(/^www\./, "");

            // YouTube
            if (host.includes("youtube.com") || host.includes("youtu.be")) {

                if (u.pathname.startsWith("/embed/")) {
                    return u.toString();
                }

                if (host === "youtu.be") {
                    const id = u.pathname.split("/")[1];

                    if (id) {
                        return `https://www.youtube.com/embed/${id}`;
                    }
                }

                if (u.pathname.startsWith("/shorts/")) {
                    const id = u.pathname.split("/")[2];

                    if (id) {
                        return `https://www.youtube.com/embed/${id}`;
                    }
                }

                const v = u.searchParams.get("v");

                if (v) {
                    return `https://www.youtube.com/embed/${v}`;
                }
            }

            // Vimeo
            if (host.includes("vimeo.com")) {

                if (host === "player.vimeo.com") {
                    return u.toString();
                }

                const id = u.pathname.split("/").filter(Boolean).pop();

                if (/^\d+$/.test(id)) {
                    return `https://player.vimeo.com/video/${id}`;
                }
            }

            return urlStr;
        }

        function getYouTubeId(url) {
            try {
                const u = new URL(norm(url));
                const host = u.hostname.replace(/^www\./, "");

                if (host === "youtu.be") {
                    return u.pathname.split("/")[1] || null;
                }

                if (u.pathname.startsWith("/shorts/")) {
                    return u.pathname.split("/")[2] || null;
                }

                if (u.pathname.startsWith("/embed/")) {
                    return u.pathname.split("/")[2] || null;
                }

                return u.searchParams.get("v");
            } catch {
                return null;
            }
        }

        function getAutoplayUrl(url) {
            try {
                const u = new URL(url);

                u.searchParams.set("autoplay", "1");

                return u.toString();
            } catch {
                return url;
            }
        }

        // ===========================
        // DOM Ready
        // ===========================

        document.addEventListener("DOMContentLoaded", function () {

            // ===========================
            // Vídeo
            // ===========================

            const playBtn = document.querySelector(".video-play-btn");

            if (playBtn) {
                playBtn.addEventListener("click", function () {

                    const container = this.closest(".video-container");

                    if (!container) return;

                    const embedUrl = toEmbed(container.dataset.video);

                    if (!embedUrl) return;

                    const autoplayUrl = getAutoplayUrl(embedUrl);

                    container.innerHTML = `
                        <iframe
                            src="${autoplayUrl}"
                            frameborder="0"
                            allow="autoplay; encrypted-media; picture-in-picture"
                            allowfullscreen
                            style="width:100%;height:100%;border:0;">
                        </iframe>
                    `;
                });
            }

            // ===========================
            // Thumbnail do vídeo
            // ===========================

            const videoContainer = document.querySelector(".video-container");

            if (videoContainer) {

                const img = videoContainer.querySelector(".video-thumb");

                if (img) {

                    const loadThumbnail = function () {

                        if (img.dataset.loaded) return;

                        const id = getYouTubeId(videoContainer.dataset.video);

                        if (!id) return;

                        img.src = `https://img.youtube.com/vi/${id}/maxresdefault.jpg`;

                        img.dataset.loaded = "true";
                    };

                    if ("IntersectionObserver" in window) {

                        const observer = new IntersectionObserver(function (entries) {

                            entries.forEach(function (entry) {

                                if (entry.isIntersecting) {

                                    loadThumbnail();

                                    observer.unobserve(entry.target);
                                }
                            });

                        }, {
                            rootMargin: "300px 0px"
                        });

                        observer.observe(videoContainer);

                    } else {

                        loadThumbnail();
                    }
                }
            }

            // ===========================
            // MVW
            // ===========================

            const section = document.getElementById("mvwSection");

            if (!section) return;

            const cards = section.querySelectorAll(".mvw-card");

            if (!cards.length) return;

            function changeBackground(card) {

                const bg = card.dataset.bg;

                if (!bg) return;

                section.style.backgroundImage = `url("${bg}")`;

                cards.forEach(c => c.classList.remove("active"));

                card.classList.add("active");
            }

            // imagem inicial
            changeBackground(cards[0]);

            cards.forEach(card => {

                // Desktop
                card.addEventListener("mouseenter", function () {

                    if (window.innerWidth > 768) {
                        changeBackground(this);
                    }
                });

                // Mobile
                card.addEventListener("click", function () {

                    if (window.innerWidth <= 768) {
                        changeBackground(this);
                    }
                });
            });
        });
    </script>

    {{-- Modais alert --}}
    <script defer>
        document.addEventListener('DOMContentLoaded', function () {

            let successMessage = @json(session('success'));
            let errorMessage = @json(session('error'));

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
</body>
</html>