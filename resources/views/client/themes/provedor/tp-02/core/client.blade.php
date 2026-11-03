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

    <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100..900&display=swap" onload='this.onload=null,this.rel="stylesheet"'>

    <noscript>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100..900&display=swap">
    </noscript>


    {{-- ============================================================
    BIBLIOTECAS CSS
    ============================================================ --}}

    <link rel="preload" href="https://unpkg.com/aos@2.3.1/dist/aos.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css"></noscript>

    <link rel="preload" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css"></noscript>

    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"></noscript>

    <link href="{{ asset('build/client/lgpd/style.css') }}" rel="stylesheet" type="text/css">

    <link href="{{ asset('build/client/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">

    <link rel="preload" href="{{ asset('build/client/bootstrap-icons/bootstrap-icons.css') }}" as="style" onload="this.rel='stylesheet'">

    <link href="{{ asset('build/client/themes/provedor/tp-02/css/style.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('build/client/css/default.css') }}" rel="stylesheet" type="text/css">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

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

    @include('client/themes/provedor/tp-02/includes/lgpd/lgpd')

    @if (isset($contact) && $contact->whatsapp <> null)
        @php
            // Remove caracteres não numéricos do telefone
            $phone = preg_replace('/\D/', '', $contact->whatsapp);

            // Monta mensagem com ícones e quebras de linha
            $mensagem = "Olá! Encontrei seu site e gostaria de conhecer mais sobre os planos disponíveis.%0A";
        @endphp

        <a href="https://wa.me/55{{ $phone }}?text={{ $mensagem }}"
        class="whatsapp-floatt" target="_blank" rel="noopener noreferrer" aria-label="Fale conosco no WhatsApp">
            <i class="bi bi-whatsapp accent-color"></i>
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
        /* .primary-color {
            color: var(--primary-color);
        }

        .secondary-color {
            color: var(--secondary-color);
        } */

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
        .list-service ul li{
            font-size: 0.75rem;
        }
        .navbar-nav .nav-link.active, .navbar-nav .nav-link.show, .nav-link:focus, .nav-link:hover{
            color: var(--bg-button-one) !important;
        }
    </style>

    <header class="shadow-sm bg-header">
        <nav class="navbar navbar-expand-lg navbar-dark container py-2 px-3 px-lg-0">            
            <!-- Logo -->
            @php
                $logoPath = storage_path('app/public/' . $tenantTheme->path_image_logo_header);
                $dimensions = file_exists($logoPath) ? @getimagesize($logoPath) : null;
            @endphp
            <a class="navbar-brand d-flex align-items-center p-0 m-0" href="{{route('index')}}">
                <img loading="lazy" src="{{asset('storage/' .$tenantTheme->path_image_logo_header)}}" class="logo-header" alt="{{ $tenantTheme->name }}" width="{{ $dimensions[0] ?? 200 }}" height="{{ $dimensions[1] ?? 60 }}" style="height: 60px; width: auto;">
            </a>

            <!-- Toggle mobile -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false"  aria-label="Abrir menu de navegação">
                <span class="navbar-toggler-icon" aria-hidden="true"></span>
            </button>

            <!-- Menu -->
            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav mx-auto m-auto me-4 mb-2 mb-lg-0 gap-lg-2">
                    <li class="nav-item">
                        <a class="nav-link font-changa font-16 font-semibold font-header text-color-header active" href="{{route('index')}}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link font-changa font-16 font-semibold font-header text-color-header" href="{{route('index')}}#about">Quem Somos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link font-changa font-16 font-semibold font-header text-color-header" href="{{route('index')}}#services">Serviços</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link font-changa font-16 font-semibold font-header text-color-header" href="{{ request()->routeIs('index') ? '#benefit' : route('index') . '#benefit' }}">Benefícios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link font-changa font-16 font-semibold font-header text-color-header" href="{{route('index')}}#faq">FAQ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link font-changa font-16 font-semibold font-header text-color-header" href="{{route('index')}}#contato">Contato</a>
                    </li>
                </ul>

                <!-- Botão -->
                @if (isset($tenantTheme->link_header) && $tenantTheme->link_header <> null)                        
                    <div class="d-flex justify-content-center gap-2 align-items-center btn-header bg-button-one py-2 px-4 hover-zoom rounded-pill">                        
                        <a href="{{$tenantTheme->link_header}}" target="_blank" class="font-changa font-15 font-semibold text-decoration-none color-button-one">
                            {{$tenantTheme->btn_title_header}}
                        </a>
                        
                        <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M7.84588 3.60887e-08C7.68583 3.60887e-08 7.53988 0.10789 7.49757 0.270078C7.46444 0.397711 7.50462 0.528169 7.59205 0.615613C7.63577 0.659334 7.69147 0.692475 7.75563 0.709399L8.2365 0.834917L8.70043 0.983706L9.1545 1.15788L9.59869 1.35745L10.0309 1.58169L10.4497 1.82991L10.8544 2.10069L11.2429 2.39403L11.6145 2.70854L11.9677 3.0435L12.3005 3.39607L12.6143 3.76699L12.9055 4.15412L13.1748 4.55747L13.4216 4.97563L13.6451 5.40578L13.8439 5.84861L14.0174 6.30132L14.1662 6.7632L14.291 7.242C14.3079 7.30617 14.3403 7.36188 14.384 7.4056H14.3847C14.451 7.47259 14.5427 7.51208 14.6393 7.51208C14.6696 7.51208 14.6999 7.50785 14.7302 7.50009C14.9234 7.45002 15.0383 7.25328 14.9883 7.06007L14.8607 6.5714L14.855 6.55236L14.7006 6.07143L14.6943 6.05239L14.5131 5.58064L14.5053 5.5623L14.298 5.10113L14.2896 5.0835L14.0576 4.63501L14.0477 4.61738L13.7904 4.18229L13.7798 4.16537L13.4992 3.74509L13.4872 3.72888L13.1833 3.32552L13.1713 3.3093L12.8456 2.92358L12.8322 2.90877L12.4853 2.54138L12.4712 2.52727L12.1031 2.17822L12.0876 2.16482L11.7005 1.83763L11.685 1.82493L11.2803 1.5196L11.2641 1.50761L10.8424 1.22555L10.8255 1.21497L10.3891 0.956174L10.3715 0.946302L9.92161 0.712889L9.90328 0.704427L9.44075 0.496412L9.42242 0.488655L8.94932 0.306726L8.93028 0.30038L8.4473 0.145244L8.42827 0.139602L7.93753 0.0119685C7.9065 0.00350656 7.8762 3.60887e-08 7.84588 3.60887e-08ZM7.75422 2.90025C7.59276 2.90025 7.44611 3.00814 7.4038 3.17174C7.36996 3.30078 7.41015 3.43194 7.49828 3.51939C7.542 3.56381 7.5984 3.59695 7.66327 3.61388L7.94108 3.68651L8.20477 3.77113L8.46282 3.86985L8.71594 3.98409L8.96131 4.11101L9.19962 4.25205L9.43017 4.40648L9.65087 4.5736L9.86239 4.75271L10.0633 4.9424L10.253 5.14338L10.4307 5.35423L10.5964 5.57495L10.7501 5.80412L10.8904 6.04176L11.0173 6.28645L11.1308 6.53819L11.2295 6.79558L11.3141 7.0586L11.3861 7.33573C11.403 7.3999 11.4361 7.45632 11.4798 7.50004C11.5475 7.56773 11.6392 7.60651 11.7365 7.60651C11.7668 7.60651 11.7978 7.60299 11.8281 7.59523C12.022 7.54446 12.1384 7.34631 12.0876 7.1524L12.0129 6.86611L12.0072 6.84636L11.917 6.5643L11.9099 6.54526L11.8042 6.26884L11.7964 6.25051L11.6744 5.98043L11.666 5.9621L11.5299 5.69908L11.52 5.68145L11.3691 5.42618L11.3586 5.40925L11.1943 5.16315L11.1823 5.14693L11.0039 4.91L10.9912 4.89448L10.8009 4.66813L10.7868 4.65261L10.5837 4.43754L10.5696 4.42344L10.3538 4.21894L10.3383 4.20554L10.112 4.01304L10.0958 4.00034L9.85888 3.82123L9.84196 3.80995L9.59518 3.64424L9.57826 3.63366L9.32231 3.48205L9.30468 3.47218L9.04029 3.33538L9.02196 3.32621L8.75121 3.20492L8.73217 3.19646L8.45507 3.08998L8.43603 3.08364L8.1526 2.99267L8.13356 2.98703L7.84588 2.91228C7.81486 2.90382 7.78454 2.90025 7.75422 2.90025ZM3.39482 0.0422418L3.39411 0.0429472C3.39341 0.0422419 3.39341 0.0422418 3.3927 0.0422418H3.392C3.24111 0.0422418 3.08811 0.0626913 2.93653 0.105002C2.93089 0.107117 1.47773 0.521753 1.47773 0.521753C1.15905 0.616245 0.859382 0.789014 0.606973 1.04075L0.605562 1.04216C0.0760512 1.57174 -0.106559 2.31709 0.0591385 2.9954C0.0619586 3.00739 0.0683043 3.03066 0.0683043 3.03066C0.658445 5.27092 1.94026 7.61138 3.7882 9.67961L3.82134 9.71698C4.05048 9.97156 4.28317 10.2183 4.52924 10.4637L4.53276 10.4673C6.78972 12.7245 9.45984 14.2779 11.998 14.94L12.0072 14.9422C12.1672 14.9809 12.3294 15 12.493 15H12.4937C13.0147 15 13.5358 14.804 13.9377 14.4126C13.9504 14.3999 13.9574 14.3928 13.9574 14.3928C14.2042 14.146 14.3755 13.8527 14.4714 13.5417L14.8923 12.0658C15.0538 11.4918 14.9008 10.8896 14.5165 10.4644C14.4905 10.4362 14.4778 10.4221 14.4778 10.4221C14.4651 10.4094 14.4587 10.403 14.4587 10.403C14.3551 10.3001 14.2373 10.2091 14.1062 10.133L12.6093 9.26843C12.3491 9.11823 12.0551 9.04067 11.7597 9.04067V9.04137H11.7583H11.7576C11.6109 9.04137 11.4636 9.06041 11.3197 9.09919H11.319C11.0215 9.17888 10.7543 9.33754 10.542 9.55472C10.5364 9.56036 8.97466 11.1625 8.97466 11.1625C8.97184 11.166 8.96479 11.1724 8.96479 11.1724C8.93377 11.1991 8.89358 11.2147 8.85269 11.2147C8.84987 11.2147 8.84564 11.214 8.84564 11.214C8.8132 11.2125 8.78218 11.202 8.7568 11.1843H8.75609C7.83033 10.5581 6.92295 9.8135 6.05709 8.9475C6.05709 8.9475 6.05709 8.9468 6.05639 8.9468L6.05427 8.94468C6.05427 8.94398 6.05357 8.94398 6.05357 8.94398C5.80749 8.69717 5.5727 8.44966 5.34567 8.19722L5.29773 8.14362C4.76329 7.54424 4.28453 6.92863 3.85866 6.30592C3.83399 6.27066 3.8213 6.25091 3.8213 6.25091C3.80367 6.22341 3.78886 6.1938 3.78604 6.16065C3.78181 6.10988 3.80014 6.05982 3.83681 6.02385L5.4465 4.45487C5.66365 4.24262 5.82089 3.97678 5.90056 3.67849C6.01478 3.25186 5.95837 2.79774 5.74403 2.41273L4.86621 0.892397C4.80628 0.787328 4.73718 0.690014 4.65752 0.604682C4.6265 0.570128 4.61028 0.55391 4.60252 0.546153C4.59547 0.539102 4.59477 0.539102 4.59477 0.539102C4.27678 0.221078 3.84386 0.0419648 3.39474 0.0419648L3.39482 0.0422418Z" fill="var(--color-button-one)"/>
                        </svg>
                    </div>                    
                @endif
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
                    <img loading="lazy" src="{{asset('storage/' .$tenantTheme->path_image_logo_footer)}}" alt="{{ $tenantTheme->name }}" width="{{ $dimensions[0] ?? 200 }}" height="{{ $dimensions[1] ?? 60 }}" style="max-width:250px;height:auto;">
                    @if ($tenantTheme->link <> null)                        
                        <div class="mt-3 mt-lg-5">
                            <a href="{{ $tenantTheme->link }}" target="_blank" rel="noopener noreferrer" class="bg-button-two color-button-two px-4 py-2 font-changa font-16 font-medium text-decoration-none hover-zoom">
                                {{$tenantTheme->btn_title}}
                                <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    @endif
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
                                <li><a href="{{route('index')}}" class="text-color-footer font-changa font-16 font-regular text-decoration-none d-block mb-2">Início</a></li>
                                <li><a href="{{route('index')}}#about" class="text-color-footer font-changa font-16 font-regular text-decoration-none d-block mb-2">Quem Somos</a></li>
                                <li><a href="{{route('index')}}#services" class="text-color-footer font-changa font-16 font-regular text-decoration-none d-block mb-2">Serviços</a></li>
                            </ul>
                        </div>

                        <div class="col-6">
                            <ul class="list-unstyled">
                                <li><a href="{{ request()->routeIs('index') ? '#benefit' : route('index') . '#benefit' }}" class="text-color-footer font-changa font-16 font-regular text-decoration-none d-block mb-2">Benefícios</a></li>
                                <li><a href="{{ request()->routeIs('index') ? '#faq' : route('index') . '#faq' }}" class="text-color-footer font-changa font-16 font-regular text-decoration-none d-block mb-2">FAQ</a></li>
                                <li><a href="{{route('index')}}#contato" class="text-color-footer font-changa font-16 font-regular text-decoration-none d-block mb-2">Contato</a></li>
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
                                aria-label="TikTok">
                                    <i class="bi bi-tiktok" aria-hidden="true"></i>
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
                            <a href="javascript:void(0)" class="text-color-footer text-decoration-none" data-bs-toggle="modal" data-bs-target="#privacyModal">Política de Privacidade</a>
                            <span class="mx-1">|</span>
                        @endif
                        @if ($tenantTheme->terms_of_use <> null)                            
                            <a href="javascript:void(0)" class="text-color-footer text-decoration-none" data-bs-toggle="modal" data-bs-target="#termsModal">Termos de Uso</a>
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

    {{-- Scripts externos --}}
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js" defer></script>

     <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- Scripts do projeto --}}
    <script src="{{ asset('build/client/bootstrap/js/bootstrap.bundle.js') }}" defer></script>
    <script src="{{ asset('build/client/lgpd/script.js') }}" defer></script>
    <script src="{{ asset('build/client/themes/provedor/tp-02/js/default.js') }}" defer></script>
    <script src="{{ asset('build/client/js/default.js') }}" defer></script>

    {{-- Modais alert --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            AOS.init({
                duration: 800,
                once: true,
                offset: 40
            });
        });

    </script>

</body>
</html>