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

    <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Merriweather:wght@300;400;700;900&display=swap" onload='this.onload=null;this.rel="stylesheet"'>

    <noscript>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Merriweather:wght@300;400;700;900&display=swap">
    </noscript>


    {{-- ============================================================
    BIBLIOTECAS CSS
    ============================================================ --}}

    <link rel="preload" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css"></noscript>

    <link rel="preload" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css"></noscript>

    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"></noscript>

    <link href="{{ asset('build/client/lgpd/style.css') }}" rel="stylesheet" type="text/css">

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <link href="{{ asset('build/client/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">

    <link rel="preload" href="{{ asset('build/client/bootstrap-icons/bootstrap-icons.css') }}" as="style" onload="this.rel='stylesheet'">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css">

    <link href="{{ asset('build/client/themes/blog/tp-01/css/style.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('build/client/themes/blog/tp-01/css/themify-icons.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('build/client/themes/blog/tp-01/css/responsivo.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('build/client/css/default.css') }}" rel="stylesheet" type="text/css">


    {{-- ============================================================
    SCHEMA.ORG
    ============================================================ --}}

    <script type="application/ld+json">
    {!! json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>
</head>

<body class="bg-primary-color">
    <div id="organization" hidden></div>

    @include('client/script-seo-google/script-body-nocript')

    @include('client/themes/blog/tp-01/includes/lgpd/lgpd')

     @if (isset($contact) && $contact->phone_one <> null)
        @php
            // Remove caracteres não numéricos do telefone
            $phone = preg_replace('/\D/', '', $contact->phone_one);

            // Monta mensagem com ícones e quebras de linha
            $mensagem = "Olá! Encontrei seu site e gostaria de conhecer mais sobre os planos disponíveis.%0A";
        @endphp

        <a
            href="https://wa.me/55{{ $phone }}?text={{ $mensagem }}"
            class="whatsapp-float"
            aria-label="Fale conosco no WhatsApp"
            target="_blank"
            rel="noopener noreferrer"
            >
            <!-- Ícone SVG do WhatsApp -->
            <svg viewBox="0 0 32 32" aria-hidden="true">
                <path d="M19.11 17.27c-.23-.12-1.37-.67-1.58-.75-.21-.08-.36-.12-.52.12-.16.23-.6.74-.74.89-.14.15-.27.17-.5.06-.23-.12-.97-.36-1.85-1.12-.68-.6-1.14-1.34-1.27-1.57-.13-.23-.01-.35.1-.47.1-.1.23-.27.35-.4.12-.13.16-.23.24-.39.08-.16.04-.3-.02-.42-.06-.12-.52-1.25-.71-1.72-.19-.46-.38-.4-.52-.4h-.45c-.16 0-.42.06-.64.3-.22.23-.84.82-.84 2 0 1.18.86 2.32.98 2.48.12.16 1.69 2.58 4.1 3.61.57.25 1.01.4 1.35.52.57.18 1.1.16 1.52.1.46-.07 1.37-.56 1.57-1.1.19-.54.19-1 .13-1.1-.06-.1-.21-.16-.44-.27zM16 3.2c-7.06 0-12.8 5.73-12.8 12.8 0 2.26.61 4.36 1.67 6.17L3.2 28.8l6.78-1.6c1.74.95 3.74 1.5 5.87 1.5 7.07 0 12.8-5.73 12.8-12.8S23.07 3.2 16 3.2zm0 22.94c-1.98 0-3.81-.58-5.35-1.57l-.38-.24-4.02.95.95-3.92-.25-.4a10.58 10.58 0 0 1-1.64-5.62c0-5.86 4.77-10.62 10.63-10.62S26.62 9.38 26.62 15.24 21.86 26.14 16 26.14z"/>
            </svg>
        </a>
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
        .about li::after{
            color: var(--primary-color);
        }
        .bg-grey-light{
            background: #E9E9E9;
        }
        .testimonial-swiper .swiper-pagination-bullet{
            background: var(--primary-color);
        }
        #lgpd-banner button{
            background: var(--primary-color);
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
        .border-end-1 {
            border-right: 1px solid #ffffff30 !important;
        }

        .site-navigation.ul .subcategorylist:hover {
            background-color: var(--primary-color);            
            transition: all 0.3s ease;
        }
        .site-navigation.ul li:hover a, .header-top li:hover a{
            color: var(--accent-color);
        }
        .w-20{
            width: 20%;
        }
        .swiper-button-prev.news:hover,
        .swiper-button-next.news:hover,
        .btn.bg-button-one.color-button-one:hover {
            background: #272a33 !important; 
        }
        .btn.bg-button-one.color-button-one:hover{
            color: var(--color-button-one);
        }
        .swiper-button-prev.news::after,
        .swiper-button-next.news::after {
            color: var(--primary-color); 
        }
        .tab01 .nav-link.active::after {
            background: var(--primary-color);
        }
    </style>

    <div id="newsMediaOrganization" hidden></div>

    <header id="header" class="w-100 d-flex flex-column position p-0">   
        <div class="w-100 py-0">
            <div class="header-top py-0 mb-0 bg-header">
                <div class="container d-flex flex-wrap justify-content-center justify-content-lg-between align-items-center">    
                    <div class="logo-img d-block d-lg-none px-0 py-2 rounded-2 d-flex justify-content-start align-items-center w-auto">
                        <a class="navbar-brand logo-header" href="{{ route('index') }}" style="max-width: 200px;">
                            @if(!empty($tenantTheme->path_image_logo_header))
                                {{-- Pegar tamanho/proporção da logo --}}
                                @php
                                    $logoPath = storage_path('app/public/' . $tenantTheme->path_image_logo_header);
                                    $dimensions = file_exists($logoPath) ? @getimagesize($logoPath) : null;
                                @endphp

                                <img src="{{ asset('storage/' . $tenantTheme->path_image_logo_header) }}" alt="{{ $tenantTheme->name }}" width="{{ $dimensions[0] ?? 200 }}" height="{{ $dimensions[1] ?? 60 }}" style="max-width:100%;height:auto;">
                            @else
                                <span class="fw-bold">{{ $seoGoogle->organization_name ?? config('app.name') }}</span>
                            @endif
                        </a>
                    </div>

                    <nav class="navbar navbar-expand-sm p-0 mb-0 col-12 col-lg-6">
                        <ul class="navbar-nav ml-n2">

                            <li class="nav-item border-right border-end-1">
                                <a class="nav-link text-color-header font-14 poppins-regular" href="#">
                                    {{ ucfirst(\Carbon\Carbon::now()->translatedFormat('l, j \d\e F \d\e Y')) }}
                                </a>
                            </li>

                            <li class="nav-item border-right border-end-1">
                                <a class="nav-link text-color-header font-14 poppins-regular" href="{{route('client.event')}}">
                                    Eventos
                                </a>
                            </li>

                            <li class="nav-item border-right border-end-1">
                                <a class="nav-link text-color-header font-14 poppins-regular" href="{{route('contact')}}">
                                    Contato
                                </a>
                            </li>

                            @if (!Auth::guard('client')->check())

                                {{-- LOGIN --}}
                                <li class="nav-item">
                                    <a class="nav-link text-color-header font-14 poppins-regular"
                                    href="#"
                                    data-bs-toggle="modal"
                                    data-bs-target="#loginModal">
                                        Login
                                    </a>
                                </li>

                            @else

                                {{-- USUÁRIO LOGADO --}}
                                @php
                                    $user = Auth::guard('client')->user();
                                    $firstName = collect(explode(' ', $user->name))
                                        ->filter()
                                        ->first();
                                @endphp

                                <li class="nav-item dropdown">
                                    <a class="nav-link text-color-header font-14 poppins-regular dropdown-toggle"
                                    href="#"
                                    role="button"
                                    data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                        Olá, {{ $firstName }}
                                    </a>

                                    <ul class="dropdown-menu dropdown-menu-end">

                                        <li>
                                            <a class="dropdown-item"
                                            href="#"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editClientModal-{{ $user->id }}">
                                                <i class="bi bi-gear me-2"></i>
                                                Minha conta
                                            </a>
                                        </li>

                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>

                                        <li>
                                            <a class="dropdown-item"
                                            href="{{ route('client.user.logout') }}">
                                                <i class="bi bi-box-arrow-right me-2"></i>
                                                Sair
                                            </a>
                                        </li>

                                    </ul>
                                </li>

                            @endif

                        </ul>
                    </nav>
                
                    <div class="col-12 col-lg-6 text-center d-none d-lg-block"> 
                        <div class="d-flex flex-wrap justify-content-center justify-content-lg-end align-items-center">
                            <div class="p-0">
                                <nav class="site-navigation position-relative redes-sociais">
                                    <ul class="p-0 d-flex justify-content-center gap-3 flex-row mb-0">
                                        @if (isset($contact) && $contact->link_insta)
                                            <li class="li d-flex justify-content-center align-items-center rounded-circle">
                                                <a href="{{ $contact->link_insta }}" rel="nofollow noopener noreferrer" target="_blank">
                                                    <i class="bi bi-instagram text-color-header"></i>
                                                </a>
                                            </li>
                                        @endif

                                        @if (isset($contact) && $contact->link_x)
                                            <li class="li d-flex justify-content-center align-items-center rounded-circle">
                                                <a href="{{ $contact->link_x }}" rel="nofollow noopener noreferrer" target="_blank">
                                                    <i class="bi bi-twitter-x text-color-header"></i>
                                                </a>
                                            </li>
                                        @endif

                                        @if (isset($contact) && $contact->link_youtube)
                                            <li class="li d-flex justify-content-center align-items-center rounded-circle">
                                                <a href="{{ $contact->link_youtube }}" rel="nofollow noopener noreferrer" target="_blank">
                                                    <i class="bi bi-youtube text-color-header"></i>
                                                </a>
                                            </li>
                                        @endif

                                        @if (isset($contact) && $contact->link_face)
                                            <li class="li d-flex justify-content-center align-items-center rounded-circle">
                                                <a href="{{ $contact->link_face }}" rel="nofollow noopener noreferrer" target="_blank">
                                                    <i class="bi bi-facebook text-color-header"></i>
                                                </a>
                                            </li>
                                        @endif

                                        @if (isset($contact) && $contact->link_tik_tok)
                                            <li class="li d-flex justify-content-center align-items-center rounded-circle">
                                                <a href="{{ $contact->link_tik_tok }}" rel="nofollow noopener noreferrer" target="_blank">
                                                    <i class="bi bi-tiktok text-color-header"></i>
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container m-auto d-none d-lg-flex align-items-center justify-content-between flex-column">
                <div class="d-flex col-12 justify-content-between align-items-center wrap-logo-and-login">
                    <div class="logo-img px-0 py-2 rounded-2 d-flex justify-content-start align-items-center w-auto">
                        <a class="navbar-brand logo-header" href="{{ route('index') }}" style="max-width: 200px;">
                            @if(!empty($tenantTheme->path_image_logo_header))
                                {{-- Pegar tamanho/proporção da logo --}}
                                @php
                                    $logoPath = storage_path('app/public/' . $tenantTheme->path_image_logo_header);
                                    $dimensions = file_exists($logoPath) ? @getimagesize($logoPath) : null;
                                @endphp

                                <img src="{{ asset('storage/' . $tenantTheme->path_image_logo_header) }}" alt="{{ $tenantTheme->name }}" width="{{ $dimensions[0] ?? 200 }}" height="{{ $dimensions[1] ?? 60 }}" style="max-width:100%;height:auto;">
                            @else
                                <span class="fw-bold">{{ $seoGoogle->organization_name ?? config('app.name') }}</span>
                            @endif
                        </a>
                    </div>
                    
                    @if (isset($announcements['top-right']) && $announcements['top-right']->isNotEmpty())
                        <div class="col-9 ad-container mb-0 overflow-hidden bg-transparent border-0 m-0 py-3">
                            <div class="ad-placeholder bg-transparent top-right">
                                <!-- Espaço para Banner Adsense -->
                                @includeIf('client.components.announcement.all-announcement', [
                                        'announcements' => $announcements['top-right'] ?? collect()
                                    ]
                                )
                            </div>
                        </div>
                    @endif
                </div>       
            </div>
            <div class="container-fluid bg-header mt-0 h-60 d-flex align-items-center py-0">
                <div class="container d-flex justify-content-between align-items-center w-100 h-100">
                    <div class="social-links d-flex justify-content-start align-items-center gap-4 text-center col-12 col-lg-8">
                        <nav class="none site-navigation ul position-relative text-end width-75 h-60">
                            <ul class="d-flex flex-row justify-content-start align-items-center gap-2 mb-0 list-unstyled h-100">
                                <li class="h-100 d-flex align-items-center px-2"><a href="{{route('index')}}" class="nav-link text-color-header poppins-bold text-center font-12 text-uppercase">Home</a></li>                                                   
                                <li class="h-100 d-flex align-items-center px-2"><a href="{{route('about')}}" class="nav-link text-color-header poppins-bold text-center font-12 text-uppercase">Sobre</a></li>                                                   
                                <li class="h-100 d-flex align-items-center px-2"><a href="{{route('blogAll')}}" class="nav-link text-color-header poppins-bold text-center font-12 text-uppercase">Todas Notícias </a></li>                                                   

                                <script>
                                    document.addEventListener('DOMContentLoaded', function () {
                                        const menuItems = document.querySelectorAll('.mega-menu-item');

                                        menuItems.forEach(function (menuItem) {
                                            const menu = menuItem.querySelector('.mega-menu-content');
                                            const categoryLink = menuItem.querySelector('.mega-category-link');

                                            if (!menu || !categoryLink) return;

                                            const subcategories = menu.querySelectorAll('.mega-subcategory');
                                            const blogCards = menu.querySelectorAll('.mega-blog-card');
                                            const emptyMessage = menu.querySelector('.mega-no-blogs');

                                            function filterBlogs(subcategoryId) {
                                                let visibleCount = 0;

                                                blogCards.forEach(function (card) {
                                                    const blogSubcategory = card.dataset.blogSubcategory;

                                                    const show = subcategoryId === 'all'
                                                    ? blogSubcategory === 'all'
                                                    : blogSubcategory === String(subcategoryId);

                                                    card.classList.toggle('d-none', !show);

                                                    if (show) visibleCount++;
                                                });

                                                if (emptyMessage) {
                                                    emptyMessage.classList.toggle('d-none', visibleCount > 0);
                                                }
                                            }

                                            function selectSubcategory(selected) {
                                                subcategories.forEach(function (subcategory) {
                                                    subcategory.classList.remove('active');
                                                });

                                                selected.classList.add('active');
                                                filterBlogs(selected.dataset.subcategoryId);
                                            }

                                            function openMenu() {
                                                menuItems.forEach(function (item) {
                                                    item.classList.remove('is-open');

                                                    const link = item.querySelector('.mega-category-link');

                                                    if (link) {
                                                        link.setAttribute('aria-expanded', 'false');
                                                    }
                                                });

                                                menuItem.classList.add('is-open');
                                                categoryLink.setAttribute('aria-expanded', 'true');

                                                const allSubcategory = menu.querySelector(
                                                    '.mega-subcategory[data-subcategory-id="all"]'
                                                );

                                                if (allSubcategory) {
                                                    selectSubcategory(allSubcategory);
                                                }
                                            }

                                            menuItem.addEventListener('mouseenter', openMenu);

                                            menuItem.addEventListener('focusin', openMenu);

                                            menuItem.addEventListener('mouseleave', function () {
                                                menuItem.classList.remove('is-open');
                                                categoryLink.setAttribute('aria-expanded', 'false');
                                            });

                                            subcategories.forEach(function (subcategory) {
                                                subcategory.addEventListener('mouseenter', function () {
                                                    selectSubcategory(this);
                                                });

                                                subcategory.addEventListener('focus', function () {
                                                    selectSubcategory(this);
                                                });
                                            });
                                        });
                                    });
                                </script>

                                @if ($blogCategoriesHeader->count())
                                    @foreach ($blogCategoriesHeader as $category)
                                        <li class="mega-menu-item h-100 d-flex align-items-center px-2"
                                            data-category-id="{{ $category->id }}">

                                            {{-- CATEGORIA PRINCIPAL --}}
                                            <a class="nav-link poppins-bold text-center text-color-header font-12 text-uppercase mega-category-link"
                                            href="{{ route('blog', ['category' => $category->slug]) }}#news"
                                            aria-expanded="false">
                                                {{ $category->title }}
                                                {{-- <i class="bi bi-chevron-down"></i> --}}
                                            </a>

                                            {{-- MEGA MENU DA CATEGORIA --}}
                                            <div class="mega-menu-content bg-white shadow"
                                                data-mega-category="{{ $category->id }}">

                                                <div class="row g-0 h-100" style="min-height: 295px;">

                                                    {{-- COLUNA ESQUERDA: SUBCATEGORIAS --}}
                                                    <div class="col-2 border-end mega-subcategories">

                                                        <ul class="list-unstyled mb-0 text-start d-flex flex-column justify-content-star py-4 h-100">

                                                            {{-- MOSTRAR TODOS OS BLOGS DA CATEGORIA --}}
                                                            <li class="subcategorylist">
                                                                <a href="{{ route('blog', ['category' => $category->slug]) }}#news"
                                                                class="mega-subcategory active text-dark poppins-semibold font-15"
                                                                data-subcategory-id="all">
                                                                    Todas
                                                                </a>
                                                            </li>

                                                            @foreach ($category->subcategories as $subCategory)
                                                                <li class="subcategorylist">
                                                                    <a href="{{ route('blog', ['category' => $category->slug]) }}#news"
                                                                    class="mega-subcategory poppins-semibold font-15 text-dark"
                                                                    data-subcategory-id="{{ $subCategory->id }}">
                                                                        {{ $subCategory->name }}
                                                                    </a>
                                                                </li>
                                                            @endforeach

                                                        </ul>
                                                    </div>

                                                    {{-- COLUNA DIREITA: BLOGS --}}
                                                    <div class="col-10 mega-blogs">
                                                        <div class="row g-4 h-100 justify-content-start align-items-start">
                                                            <h3 class="poppins-semibold text-start pt-3 font-15">Notícias mais recentes</h3>
                                                            {{-- 4 BLOGS DA CATEGORIA --}}
                                                            @foreach ($category->blogs as $blog)
                                                                <div class="w-20 mega-blog-card mt-0"
                                                                    data-blog-subcategory="all">

                                                                    <a href="#"
                                                                    class="mega-blog-link text-decoration-none">
                                                                        <img
                                                                            src="{{ $blog->path_image
                                                                                ? asset('storage/' . $blog->path_image)
                                                                                : 'https://placehold.co/600x400?text=Sem+imagem&font=poppins' }}"
                                                                            alt="{{ $blog->title }}"
                                                                            class="mega-blog-image"
                                                                            width="200"
                                                                            height="133"
                                                                            loading="lazy">

                                                                        <h5 class="mega-blog-title text-dark poppins-regular font-12 text-start border-bottom pb-3">
                                                                            {{ $blog->title }}
                                                                        </h5>
                                                                    </a>

                                                                    <div class="mega-blog-meta poppins-regular font-10 text-start">
                                                                        {{ ucfirst(\Carbon\Carbon::parse($blog->date)->locale('pt_BR')->translatedFormat('M')) . \Carbon\Carbon::parse($blog->date)->format(' d') }}
                                                                    </div>
                                                                </div>
                                                            @endforeach

                                                            {{-- 4 BLOGS DE CADA SUBCATEGORIA --}}
                                                            @foreach ($category->subcategories as $subCategory)
                                                                @foreach ($subCategory->blogs as $blog)
                                                                    <div class="w-20 mega-blog-card d-none mt-0"
                                                                        data-blog-subcategory="{{ $subCategory->id }}">

                                                                        <a href="#"
                                                                        class="mega-blog-link text-decoration-none">
                                                                            <img
                                                                                src="{{ $blog->path_image
                                                                                    ? asset('storage/' . $blog->path_image)
                                                                                    : 'https://placehold.co/600x400?text=Sem+imagem&font=poppins' }}"
                                                                                alt="{{ $blog->title }}"
                                                                                class="mega-blog-image"
                                                                                width="200"
                                                                                height="133"
                                                                                loading="lazy">

                                                                            <h5 class="mega-blog-title text-dark poppins-regular font-12 text-start border-bottom pb-3">
                                                                                {{ $blog->title }}
                                                                            </h5>
                                                                        </a>

                                                                        <div class="mega-blog-meta poppins-regular font-10 text-start">
                                                                            <span>{{ $subCategory->name }}</span>
                                                                            <span class="mx-1">-</span>
                                                                            {{ ucfirst(\Carbon\Carbon::parse($blog->date)->locale('pt_BR')->translatedFormat('M')) . \Carbon\Carbon::parse($blog->date)->format(' d') }}
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            @endforeach

                                                            {{-- MENSAGEM QUANDO NÃO EXISTIR BLOG --}}                                                            
                                                            <div class="col-12 mega-no-blogs d-none">
                                                                <div class="d-flex flex-column align-items-center justify-content-center py-4 text-center">
                                                                    <i class="bi bi-newspaper font-30 text-secondary mb-3"></i>
                                                                    <p class="poppins-regular font-12 mb-0">
                                                                        Nenhuma notícia encontrada nesta subcategoria.
                                                                    </p>
                                                                </div>
                                                            </div>

                                                            <div class="view-more col-12 mb-3">
                                                                <a class="nav-link poppins-bold text-start text-dark font-12 text-uppercase mega-category-link"
                                                                href="{{ route('blog', ['category' => $category->slug]) }}#news">
                                                                    Ver mais

                                                                    <svg class="ms-2" width="5" height="9" viewBox="0 0 9 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path d="M1.78794 12.474L8.02494 6.237L1.78794 -1.90735e-06L0.02079 1.76715L4.46985 6.237L0 10.7068L1.78794 12.474Z" fill="#0E523E"></path>
                                                                    </svg>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>                      
                        </nav>

                        <div class="d-flex justify-content-between gap-3 flex-wrap align-items-center d-lg-none">
                           <form action="{{route('blog-search')}}#news" class="search col-12 col-lg-10" method="post">
                              @csrf
                              <div class="input-group input-group-lg">
                                 <input type="search" name="search" class="rounded-0 form-control border-end-0 text-color poppins-regular bg-white py-0" placeholder="Pesquise aqui">
                                 <button type="submit" title="search" class="btn-reset input-group-text bg-white border rounded-0">
                                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M6.99989 0C3.13331 0 0 3.13427 0 6.99979C0 10.8663 3.13351 14.0004 6.99989 14.0004C8.49916 14.0004 9.88877 13.5285 11.0281 12.7252L15.9512 17.6491C16.4199 18.117 17.1798 18.117 17.6485 17.6491C18.1172 17.1804 18.1172 16.4205 17.6485 15.9518L12.7254 11.0288C13.5279 9.88936 13.9998 8.4997 13.9998 6.99983C13.9998 3.13411 10.8655 0 6.99989 0ZM2.39962 6.99979C2.39962 4.45981 4.45907 2.40019 6.99989 2.40019C9.54072 2.40019 11.6002 4.45961 11.6002 6.99979C11.6002 9.54058 9.54072 11.6 6.99989 11.6C4.45907 11.6 2.39962 9.54058 2.39962 6.99979Z" fill="#31404B"/>
                                    </svg>                                    
                                 </button>
                              </div>
                           </form>
                        </div>
                        <!-- Botão menu sandwich -->
                        <button id="menu-toggle" class="d-lg-none btn btn-link p-0 ms-2" aria-label="Abrir menu" type="button">
                            <span class="menu-icon" style="display:inline-block;width:32px;height:32px;">
                                <span class="d-block w-100 rounded-1" style="height:4px;background:#FFF;margin:6px 0;"></span>
                                <span class="d-block w-100 rounded-1" style="height:4px;background:#FFF;margin:6px 0;"></span>
                                <span class="d-block w-100 rounded-1" style="height:4px;background:#FFF;margin:6px 0;"></span>
                            </span>
                        </button>                        
                    </div>

                    <div class="d-none d-lg-flex d-flex justify-content-end align-items-center gap-2 login-desktop col-auto col-lg-3">   
                        <div class="d-flex justify-content-between gap-3 flex-wrap align-items-center col-11">
                           <form action="{{route('blog-search')}}#news" class="search col-12" method="post">
                              @csrf
                              <div class="input-group input-group-lg">
                                 <input type="search" name="search" class="rounded-0 form-control border-end-0 text-color poppins-regular bg-white py-0" placeholder="Pesquisar" height="50">
                                 <button type="submit" title="search" class="btn-reset input-group-text bg-white border rounded-0 py-0 px-2">
                                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg" style="width: 15px">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M6.99989 0C3.13331 0 0 3.13427 0 6.99979C0 10.8663 3.13351 14.0004 6.99989 14.0004C8.49916 14.0004 9.88877 13.5285 11.0281 12.7252L15.9512 17.6491C16.4199 18.117 17.1798 18.117 17.6485 17.6491C18.1172 17.1804 18.1172 16.4205 17.6485 15.9518L12.7254 11.0288C13.5279 9.88936 13.9998 8.4997 13.9998 6.99983C13.9998 3.13411 10.8655 0 6.99989 0ZM2.39962 6.99979C2.39962 4.45981 4.45907 2.40019 6.99989 2.40019C9.54072 2.40019 11.6002 4.45961 11.6002 6.99979C11.6002 9.54058 9.54072 11.6 6.99989 11.6C4.45907 11.6 2.39962 9.54058 2.39962 6.99979Z" fill="#31404B"/>
                                    </svg>                                    
                                 </button>
                              </div>
                           </form>
                        </div>  
                    </div>   
                </div>
            </div>
        </div>     
        
    </header>
    <!-- Modal de Login -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-0 overflow-hidden">

                <!-- Header Clean com Fundo Suave -->
                <div class="modal-header border-0 pb-0 px-4 pt-4">
                    <div>
                        <h4 class="modal-title poppins-medium font-24 fw-bold text-dark mb-1" id="loginModalLabel">Bem-vindo de volta!</h4>
                        <p class="text-muted font-14 mb-0">Entre com sua conta para continuar.</p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>

                <!-- Body -->
                <div class="modal-body p-4 pt-3">
                    <form action="{{ route('client.user.authenticate') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label poppins-medium font-14 text-dark mb-1">E-mail</label>
                            <input type="email" class="form-control poppins-regular font-15 py-2 px-3 bg-light border-light rounded-0" id="email" name="email" placeholder="seu@email.com" required>
                        </div>

                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <label for="password" class="form-label poppins-medium font-14 text-dark mb-0">Senha</label>
                                <a href="#" 
                                class="font-13 text-muted text-decoration-none hover-primary"
                                data-bs-dismiss="modal"
                                data-bs-toggle="modal"
                                data-bs-target="#forgotPasswordModal">
                                    Esqueceu a senha?
                                </a>
                            </div>
                            <input type="password" class="form-control poppins-regular font-15 py-2 px-3 bg-light border-light rounded-0" id="password" name="password" placeholder="••••••••" required>
                        </div>

                        <div class="d-grid my-4">
                            <button type="submit" class="btn bg-button-one color-button-one py-2.5 rounded-0 fw-semibold poppins-medium font-15 shadow-sm border-0">
                                Entrar na conta
                            </button>
                        </div>

                        <div class="text-center pt-2 border-top">
                            <p class="poppins-regular font-14 text-muted mb-0">
                                Ainda não tem uma conta? 
                                <a href="#"
                                    class="text-primary text-decoration-none fw-semibold ms-1"
                                    data-bs-dismiss="modal"
                                    data-bs-toggle="modal"
                                    data-bs-target="#registerModal">
                                    Registre-se agora
                                </a>
                            </p>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>

    
    <!-- Modal de Cadastro -->
    <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-0 overflow-hidden">

                <!-- Header Clean com Fundo Suave -->
                <div class="modal-header border-0 pb-0 px-4 pt-4">
                    <div>
                        <h4 class="modal-title poppins-medium font-24 fw-bold text-dark mb-1" id="registerModalLabel">Crie sua conta</h4>
                        <p class="text-muted font-14 mb-0">Preencha os dados abaixo para começar.</p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>

                <!-- Body -->
                <div class="modal-body p-4 pt-3">
                    <form action="{{ route('register-client') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label poppins-medium font-14 text-dark mb-1">Nome Completo</label>
                            <input type="text" class="form-control poppins-regular font-15 py-2 px-3 bg-light border-light rounded-0" id="name" name="name" placeholder="Seu nome" required>
                        </div>

                        <div class="mb-3">
                            <label for="emailRegister" class="form-label poppins-medium font-14 text-dark mb-1">E-mail</label>
                            <input type="email" class="form-control poppins-regular font-15 py-2 px-3 bg-light border-light rounded-0" id="emailRegister" name="email" placeholder="seu@email.com" required>
                        </div>

                        <div class="mb-3">
                            <label for="passwordRegister" class="form-label poppins-medium font-14 text-dark mb-1">Senha</label>
                            <input type="password" class="form-control poppins-regular font-15 py-2 px-3 bg-light border-light rounded-0" id="passwordRegister" name="password" placeholder="••••••••" required>
                        </div>

                        <div class="d-grid my-4">
                            <button type="submit" class="btn bg-button-one color-button-one py-2.5 rounded-0 fw-semibold poppins-medium font-15 shadow-sm border-0">
                                Cadastrar conta
                            </button>
                        </div>

                        <div class="text-center pt-2 border-top">
                            <p class="poppins-regular font-14 text-muted mb-0">
                                Já tem uma conta? 
                                <a href="#"
                                    class="text-primary text-decoration-none fw-semibold ms-1"
                                    data-bs-dismiss="modal"
                                    data-bs-toggle="modal"
                                    data-bs-target="#loginModal">
                                    Fazer login
                                </a>
                            </p>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>


    @if (Auth::guard('client')->check())
        @php
            $user = Auth::guard('client')->user();
            $defaultImage = $user && $user->path_image ? url('storage/'.$user->path_image) : '';
        @endphp
        <!-- Modal de Edição -->
        <div class="modal fade" id="editClientModal-{{ Auth::guard('client')->user()->id }}" tabindex="-1" aria-labelledby="editClientModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <!-- Header -->
                    <div class="modal-header background-red text-white">
                        <h5 class="modal-title poppins-medium font-22" id="editClientModalLabel">Editar Informações</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <!-- Body -->
                    <div class="modal-body">
                        <form action="{{ route('client.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="name" class="form-label title-blue poppins-medium font-15">Nome</label>
                                <input type="text" class="form-control poppins-regular font-15" id="name" name="name" value="{{ Auth::guard('client')->user()->name }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="emailRegister" class="form-label title-blue poppins-medium font-15">E-mail</label>
                                <input type="email" class="form-control poppins-regular font-15" id="emailRegister" name="email" value="{{ Auth::guard('client')->user()->email }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="passwordRegister" class="form-label title-blue poppins-medium font-15">Senha</label>
                                <input type="password" class="form-control poppins-regular font-15" id="passwordRegister" name="password">
                            </div>

                            <div class="mb-3">
                                <label class="form-label poppins-medium title-blue font-15">Imagem de perfil</label>
                                <input 
                                    type="file" 
                                    name="path_image" 
                                    data-plugins="dropify" 
                                    data-default-file="{{ $defaultImage }}"
                                >
                                <p class="poppins-regular text-muted font-12 mt-2 mb-0">
                                    {{ __('dashboard.text_img_size') }} <b class="text-danger">2 MB</b>.
                                </p>
                            </div>

                            <!-- Footer -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger poppins-medium font-15" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn background-red text-white px-4 poppins-medium font-15">Salvar alterações</button>
                            </div>

                        </form>
                    </div>

                </div>
            </div>
        </div>

    @endif

    <div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-labelledby="forgotPasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-0 overflow-hidden">

                <!-- Header Clean com Cantos Retos -->
                <div class="modal-header border-0 pb-0 px-4 pt-4">
                    <div>
                        <h4 class="modal-title poppins-medium font-24 fw-bold text-dark mb-1" id="forgotPasswordModalLabel">Recuperar Senha</h4>
                        <p class="text-muted font-14 mb-0">Digite seu e-mail para receber o link de redefinição.</p>
                    </div>
                    <button type="button" class="btn-close rounded-0" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>

                <!-- Body -->
                <div class="modal-body p-4 pt-3">
                    <form action="{{ route('client.password.email') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="recover_email" class="form-label poppins-medium font-14 text-dark mb-1">E-mail cadastrado</label>
                            <input type="email" class="form-control poppins-regular font-15 py-2 px-3 bg-light border-light rounded-0" id="recover_email" name="email" placeholder="seu@email.com" required>
                        </div>

                        <div class="d-grid my-4">
                            <button type="submit" class="btn bg-button-one color-button-one py-2.5 rounded-0 fw-semibold poppins-medium font-15 shadow-sm border-0">
                                Enviar link de recuperação
                            </button>
                        </div>

                        <div class="text-center pt-2 border-top">
                            <p class="poppins-regular font-14 text-muted mb-0">
                                Lembrou a senha? 
                                <a href="#"
                                    class="text-primary text-decoration-none fw-semibold ms-1"
                                    data-bs-dismiss="modal"
                                    data-bs-toggle="modal"
                                    data-bs-target="#loginModal">
                                    Voltar para o login
                                </a>
                            </p>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>

    <div id="menu-mobile" class="menu-mobile d-flex flex-column justify-content-start align-items-center">
        <div class="d-flex justify-content-end align-items-start w-100">    
            <button id="menu-close" aria-label="Fechar menu" class="col-2 btn-close-menu p-0 bg-transparent" type="button">&times;</button>
        </div>
        <div class="col-10 logo-img p-0 mb-2 rounded-2 d-flex justify-content-center align-items-center">
            <img src="" alt="Expresso Vida Nova" title="Expresso Vida Nova" class="img-fluid" style="width: 100px;">
        </div>
        <div class="row justify-content-center gap-5">
            <nav class="mt-3">
                <ul class="list-unstyled text-center">
                    <li class="poppins-regular font-18 mb-3 font-mob"><a href="{{route('index')}}" class="text-white">Home</a></li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle poppins-regular font-18 font-mob mb-3 text-white" 
                            href="{{ route('blog') }}" 
                            id="noticiasDropdown" 
                            role="button" 
                            data-bs-toggle="dropdown" 
                            aria-expanded="false">
                            Notícias <i class="bi bi-chevron-down"></i>
                        </a>

                        <ul class="dropdown-menu" aria-labelledby="noticiasDropdown">
                            {{-- @if ($blogCategories->count())
                                @foreach ($blogCategories as $category)
                                    <li class="m-0">
                                        <a class="dropdown-item poppins-regular font-15 font-mob" 
                                        href="{{ route('blog', ['category' => $category->slug]) }}#news">
                                            {{ $category->title }}
                                        </a>
                                    </li>
                                @endforeach
                            @endif --}}
                        </ul>
                    </li>
                    <li class="poppins-regular font-18 mb-3 font-mob"><a href="{{route('contact')}}" class="text-white">Contato</a></li>
                    <li class="poppins-regular font-18 mb-3 font-mob"><a href="https://policies.google.com/privacy?hl=pt-BR" target="_blank" rel="noopener noreferrer" class="text-white">Política de Privacidade</a></li>
                </ul>
            </nav>
            <div class="d-none justify-content-center align-items-center gap-2 mt-0 login-middle-mobile">                        
                @if (!Auth::guard('client')->check())                            
                    <div class="d-flex justify-content-start align-items-center gap-2">
                        <svg width="20" height="20" viewBox="0 0 96 96" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M46.793 8.62893C44.5547 8.62893 42.7344 6.81253 42.7344 4.57423C42.7344 2.33593 44.5547 0.519531 46.793 0.519531L80.57 0.503906C88.8044 0.503906 95.5 7.20311 95.5 15.4339V80.5789C95.5 88.8055 88.8008 95.5089 80.57 95.5089H46.793C44.5469 95.5089 42.7266 93.6847 42.7266 91.4386C42.7266 89.1886 44.5469 87.3683 46.793 87.3683H80.57C84.3083 87.3683 87.3591 84.3136 87.3591 80.5831V15.4311C87.3591 11.7006 84.3083 8.63031 80.57 8.63031L46.793 8.62893ZM49.6914 68.2459L66.5504 51.0619C67.398 50.3158 67.9332 49.2181 67.9332 47.9994C67.9332 46.7807 67.398 45.683 66.5504 44.9408L49.6914 27.7568C48.1133 26.1591 45.543 26.1357 43.9492 27.71C42.3515 29.2803 42.3281 31.8545 43.9062 33.4522L54.1792 43.9322L4.5742 43.9283C2.3281 43.9283 0.5 45.7525 0.5 47.9986C0.5 50.2486 2.3281 52.0689 4.5742 52.0689H54.1762L43.9032 62.5459C42.3251 64.1436 42.3524 66.7138 43.9462 68.288C45.5439 69.8583 48.1103 69.8389 49.6884 68.2412L49.6914 68.2459Z" fill="white"/>
                        </svg>

                        <h2 class="off-login m-0 poppins-medium font-14 text-start" style="cursor:pointer;" data-bs-toggle="modal" data-bs-target="#loginModal">Login</h2>
                    </div>
                @else
                    @php
                        $user = Auth::guard('client')->user();
                        $defaultImage = $user && $user->path_image ? url($user->path_image) : '';
                    @endphp
                    <div class="image-profile">
                        <picture>
                            <source srcset="{{ isset($defaultImage) && $defaultImage <> null ?$defaultImage:asset('build/client/images/user.jpg') }}" type="image/svg+xml">
                            <img src="{{ isset($defaultImage) && $defaultImage <> null ?$defaultImage:asset('build/client/images/user.jpg') }}"
                                alt="Imagem de Login"
                                class="img-fluid rounded-circle">
                        </picture>
                    </div>
                    <div class="d-flex flex-column align-items-start gap-1">
                        <div class="d-flex justify-content-start align-items-center gap-2 lh-0">
                            <h2 class="loginOn m-0 poppins-medium font-10 text-start">Bem vindo,</h2>   
                            <h3 class="m-0 poppins-medium font-12 text-start">{{$names = collect(explode(' ', Auth::guard('client')->user()->name))->slice(0, 1)->implode(' ')}}!</h3>      
                            <a class="nav-link waves-effect waves-light" href="#" data-bs-toggle="modal" data-bs-target="#editClientModal-{{Auth::guard('client')->user()->id}}">
                                <i class="bi bi-gear font-15"></i>
                            </a>                 
                        </div>  
                        <a href="{{route('client.user.logout')}}" class="d-flex justify-content-start align-items-center gap-2 text-decoration-none lh-0">
                            <i class="bi bi-box-arrow-right font-15"></i>
                            <h4 class="poppins-medium font-12 m-0">Sair</h4>
                        </a>                                               
                    </div>
                @endif
            </div> 
            <nav class="site-navigation position-relative text-end w-auto redes-sociais">
                <ul class="p-0 d-flex justify-content-start gap-4 flex-row mb-0">
                    @if (isset($contact) && $contact->link_insta)
                        <li class="li d-flex justify-content-start align-items-center rounded-circle">
                            <a href="{{$contact->link_insta}}" rel="nofollow noopener noreferrer" target="_blank">
                                <img src="" alt="Instagram">
                            </a>
                        </li>
                    @endif
                    @if (isset($contact) && $contact->link_x)
                        <li class="li d-flex justify-content-start align-items-center rounded-circle">
                            <a href="{{$contact->link_x}}" rel="nofollow noopener noreferrer" target="_blank">
                                <img src="" alt="X">
                            </a>
                        </li>
                    @endif
                    @if (isset($contact) && $contact->link_youtube)
                        <li class="li d-flex justify-content-start align-items-center rounded-circle">
                            <a href="{{$contact->link_youtube}}" rel="nofollow noopener noreferrer" target="_blank">
                                <img src="" alt="Youtube">
                            </a>
                        </li>
                    @endif
                    @if (isset($contact) && $contact->link_face)
                        <li class="li d-flex justify-content-start align-items-center rounded-circle">
                            <a href="{{$contact->link_face}}" rel="nofollow noopener noreferrer" target="_blank">
                                <img src="" alt="Facebook">
                            </a>
                        </li>
                    @endif
                    @if (isset($contact) && $contact->link_tik_tok)
                        <li class="li d-flex justify-content-start align-items-center rounded-circle">
                            <a href="{{$contact->link_tik_tok}}a" rel="nofollow noopener noreferrer" target="_blank">
                                <img src="" alt="Tiktok">
                            </a>
                        </li>
                    @endif
                </ul> 
            </nav>
        </div>
    </div>

    <main>
        @yield('content') 
    </main>

    
    {{-- Footer --}}
    <footer class="bg-footer pt-3 pt-lg-5 pb-3">
        @if (isset($contact) && ($contact->link_face || $contact->link_x || $contact->link_insta || $contact->link_youtube))
            <!-- Seção de Redes Sociais Start -->
            <div class="social-networks-section pt-0 mt-0">
                <div class="container-fluid p-0">
                    <div class="social-card-wrapper position-relative overflow-hidden p-4 p-md-5 pt-md-0 text-center">
                        
                        {{-- Elementos decorativos de fundo (Glow Effects) --}}
                        <div class="social-glow glow-1"></div>
                        <div class="social-glow glow-2"></div>
    
                        <div class="position-relative z-2">
                            {{-- Título e Subtítulo --}}
                            <div class="row justify-content-center mb-4">
                                <div class="col-lg-8">
                                    <span class="badge bg-accent-color text-dark rounded-0 px-3 py-2 font-12 fw-bold text-uppercase mb-2">
                                        <i class="bi bi-share-fill me-1"></i> Conecte-se Conosco
                                    </span>
                                    <h3 class="poppins-bold font-28 text-color-footer mb-2">
                                        Siga-nos nas redes sociais
                                    </h3>
                                    <p class="text-color-footer poppins-regular font-14 mb-0">
                                        Acompanhe as notícias, bastidores e atualizações de toda a cidade em tempo real através das nossas plataformas oficiais.
                                    </p>
                                </div>
                            </div>
    
                            {{-- Grid de Redes Sociais --}}
                            <div class="d-flex flex-wrap justify-content-center align-items-center gap-3 mt-4">
                                
                                {{-- Facebook --}}
                                @if ($contact->link_face)
                                    <a href="{{ $contact->link_face }}" rel="nofollow noopener noreferrer" target="_blank" class="social-box facebook" title="Siga no Facebook">
                                        <div class="social-icon">
                                            <i class="bi bi-facebook"></i>
                                        </div>
                                        <div class="social-text">
                                            <span class="social-name">Facebook</span>
                                            <span class="social-action">Curtir página</span>
                                        </div>
                                        <i class="bi bi-arrow-up-right-short social-arrow"></i>
                                    </a>
                                @endif
    
                                {{-- Instagram --}}
                                @if ($contact->link_insta)
                                    <a href="{{ $contact->link_insta }}" rel="nofollow noopener noreferrer" target="_blank" class="social-box instagram" title="Siga no Instagram">
                                        <div class="social-icon">
                                            <i class="bi bi-instagram"></i>
                                        </div>
                                        <div class="social-text">
                                            <span class="social-name">Instagram</span>
                                            <span class="social-action">Seguir perfil</span>
                                        </div>
                                        <i class="bi bi-arrow-up-right-short social-arrow"></i>
                                    </a>
                                @endif
    
                                {{-- X (Twitter) --}}
                                @if ($contact->link_x)
                                    <a href="{{ $contact->link_x }}" rel="nofollow noopener noreferrer" target="_blank" class="social-box twitter-x" title="Siga no X">
                                        <div class="social-icon">
                                            <i class="bi bi-twitter-x"></i>
                                        </div>
                                        <div class="social-text">
                                            <span class="social-name">X / Twitter</span>
                                            <span class="social-action">Acompanhar</span>
                                        </div>
                                        <i class="bi bi-arrow-up-right-short social-arrow"></i>
                                    </a>
                                @endif
    
                                {{-- YouTube --}}
                                @if ($contact->link_youtube)
                                    <a href="{{ $contact->link_youtube }}" rel="nofollow noopener noreferrer" target="_blank" class="social-box youtube" title="Inscreva-se no YouTube">
                                        <div class="social-icon">
                                            <i class="bi bi-youtube"></i>
                                        </div>
                                        <div class="social-text">
                                            <span class="social-name">YouTube</span>
                                            <span class="social-action">Inscrever-se</span>
                                        </div>
                                        <i class="bi bi-arrow-up-right-short social-arrow"></i>
                                    </a>
                                @endif
    
                            </div>
                        </div>
    
                    </div>
                </div>
            </div>
            <!-- Seção de Redes Sociais End -->
        @endif
    
        <hr class="opacity-50 my-0 pb-4 mb-4 border-color-footer">
        
        <div class="container">

            <!-- Linha principal -->
            <div class="row align-items-start justify-content-between">

                <!-- Logo + botão -->
                <div class="col-lg-3 mb-4 mb-lg-0">
                    {{-- Pegar tamanho/proporção da logo --}}
                    @php
                        $logoPath = storage_path('app/public/' . $tenantTheme->path_image_logo_footer);
                        $dimensions = file_exists($logoPath) ? @getimagesize($logoPath) : null;
                    @endphp

                    <img src="{{asset('storage/' .$tenantTheme->path_image_logo_footer)}}" alt="{{ $tenantTheme->name }}" width="{{ $dimensions[0] ?? 200 }}" height="{{ $dimensions[1] ?? 60 }}" loading="lazy" style="max-width:100%;height:auto;">

                    @if ($tenantTheme->link <> null)                        
                        <div class="mt-3 mt-lg-5">
                            <a href="{{ $tenantTheme->link }}" target="_blank" rel="noopener noreferrer" class="bg-button-two color-button-two px-4 py-2 poppins-regular font-16 font-medium text-decoration-none hover-zoom">
                                {{$tenantTheme->btn_title}}
                                <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Mapa do site -->
                <div class="col-lg-4 mb-4 mb-0 text-start">
                    <div class="text-color-footer mb-3 position-relative d-inline-block poppins-regular font-16 font-bold map-footer">
                        Mapa do Site
                        <span class="d-block bg-accent-color mt-1" style="height:3px; width:40px;"></span>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <ul class="list-unstyled">
                                <li><a href="{{route('index')}}" class="text-start text-color-footer poppins-regular font-16 font-regular text-decoration-none d-block mb-2">Início</a></li>
                                <li><a href="{{route('index')}}#why_sec" class="text-start text-color-footer poppins-regular font-16 font-regular text-decoration-none d-block mb-2">Como funciona</a></li>
                                <li><a href="{{route('index')}}#plans" class="text-start text-color-footer poppins-regular font-16 font-regular text-decoration-none d-block mb-2">Planos</a></li>
                            </ul>
                        </div>

                        <div class="col-6">
                            <ul class="list-unstyled">
                                <li><a href="{{route('index')}}#templates" class="text-start text-color-footer poppins-regular font-16 font-regular text-decoration-none d-block mb-2">Modelos</a></li>
                                <li><a href="{{ request()->routeIs('index') ? '#depoiment' : route('index') . '#depoiment' }}" class="text-start text-color-footer poppins-regular font-16 font-regular text-decoration-none d-block mb-2">Depoimentos</a></li>
                                <li><a href="{{ request()->routeIs('index') ? '#faq' : route('index') . '#faq' }}" class="text-start text-color-footer poppins-regular font-16 font-regular text-decoration-none d-block mb-2">FAQ</a></li>
                                <li><a href="{{route('index')}}#contact_sec" class="text-start text-color-footer poppins-regular font-16 font-regular text-decoration-none d-block mb-2">Contato</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6 col-12 text-start">

                    <!-- Todas as emergências em um único bloco -->
                    @include('client.themes.blog.tp-01.includes.public-interest')

                </div>
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

                    <div class="col-12 col-lg-4 m-0 p-0">
                        <div class="d-flex justify-content-center justify-content-lg-end align-items-center gap-3">
                            <a href="http://whiweb.com.br/" target="_blank" rel="noopener noreferrer" class="text-color-footer text-decoration-none d-flex align-items-center gap-2">
                                <span class="font-13">Sistema</span>
                                <img src="{{asset('build/client/themes/default/images/whi-web.png')}}" title="Whi Web" alt="WHI Web" height="50" class="logo-system" loading="lazy">
                            </a>

                            <span class="text-color-footer opacity-50">|</span>

                            <a href="https://www.whi.dev.br/" target="_blank" rel="noopener noreferrer" class="text-color-footer text-decoration-none d-flex align-items-center gap-2">
                                <span class="font-13">Desenvolvido por</span>
                                <img src="{{asset('build/client/themes/default/images/whi.png')}}" title="Agência WHI" alt="WHI" height="25" class="logo-system" loading="lazy">
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const currentYear = new Date().getFullYear();
            const footerText = document.getElementById('footer-text');

            if (footerText) {
                footerText.innerHTML = `© ${currentYear} <span>{{ $tenantTheme->copyright }} - Todos os direitos reservados{{ $cnpj ? ' | ' . $cnpj : '' }}.</span>`;
            }
        });
    </script>

    <script src="https://cdn.ckeditor.com/4.22.1/basic/ckeditor.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('build/client/bootstrap/js/bootstrap.bundle.js') }}"></script>
    <script src="{{ asset('build/client/lgpd/script.js') }}"></script>
    <script src="{{ asset('build/client/themes/blog/tp-01/js/default.js') }}"></script>
    <script src="{{ asset('build/client/js/default.js') }}"></script>

    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

    <script>
        $(document).ready(function () {

            $('.video-items-active').slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                arrows: false,
                fade: true,
                asNavFor: '.testmonial-nav'
            });

            $('.testmonial-nav').slick({
                slidesToShow: 4,
                slidesToScroll: 1,
                asNavFor: '.video-items-active',
                dots: false,

                prevArrow: '<button type="button" class="slick-prev"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></button>',

                nextArrow: '<button type="button" class="slick-next"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M9 18L15 12L9 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></button>',

                centerMode: true,
                focusOnSelect: true,
                centerPadding: '0px',

                responsive: [
                    {
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 3,
                            infinite: true,
                            dots: false
                        }
                    },
                    {
                        breakpoint: 991,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    }
                ]
            });

        });
    </script>

    {{-- <script>
        document.addEventListener('DOMContentLoaded', function () {

            document.querySelectorAll('.tab01').forEach(function (categoryContainer) {

                const filters = categoryContainer.querySelectorAll('.category-filter');
                const featuredBlogs = categoryContainer.querySelectorAll('.featured-blog');
                const blogItems = categoryContainer.querySelectorAll('.blog-item');

                filters.forEach(function (filter) {

                    filter.addEventListener('click', function (e) {
                        e.preventDefault();

                        const subcategoryId = this.dataset.subcategoryId;

                        // Ativa o botão
                        filters.forEach(function (item) {
                            item.classList.remove('active');
                        });

                        this.classList.add('active');


                        // =========================
                        // DESTAQUE
                        // =========================

                        featuredBlogs.forEach(function (blog) {
                            blog.classList.add('d-none');
                        });

                        const matchingFeatured = Array.from(featuredBlogs).find(function (blog) {

                            if (!subcategoryId) {
                                return true;
                            }

                            return blog.dataset.subcategoryId === subcategoryId;
                        });

                        if (matchingFeatured) {
                            matchingFeatured.classList.remove('d-none');
                        }


                        // =========================
                        // LISTA
                        // =========================

                        blogItems.forEach(function (blog) {

                            const blogSubcategoryId = blog.dataset.subcategoryId;

                            if (!subcategoryId) {
                                blog.classList.remove('d-none');
                                return;
                            }

                            if (blogSubcategoryId === subcategoryId) {
                                blog.classList.remove('d-none');
                            } else {
                                blog.classList.add('d-none');
                            }
                        });

                    });

                });

            });

        });
    </script> --}}

    {{-- Modais alert --}}
    <script>
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