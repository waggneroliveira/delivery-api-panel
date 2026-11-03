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

    <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Changa:wght@200..800&display=swap" onload='this.onload=null,this.rel="stylesheet"'>

    <noscript>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Changa:wght@200..800&display=swap">
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

    <link href="{{ asset('build/client/themes/petshop/tp-01/css/style.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('build/client/themes/petshop/tp-01/css/responsivo.css') }}" rel="stylesheet" type="text/css">
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

    @include('client/themes/petshop/tp-01/includes/lgpd/lgpd')

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
    </style>

    <header class="shadow-sm bg-header">
        <nav class="navbar navbar-expand-lg navbar-light container py-3 px-3 px-lg-0">            
            <!-- Logo -->
            <a class="navbar-brand d-flex align-items-center" href="{{route('index')}}">
                <img src="{{asset('storage/' .$tenantTheme->path_image_logo_header)}}" alt="{{ config('app.name') }}" height="40">
            </a>

            <!-- Toggle mobile -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Menu -->
            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav mx-auto m-auto me-4 mb-2 mb-lg-0 gap-lg-3">
                    <li class="nav-item">
                        <a class="nav-link font-changa font-18 font-semibold font-header text-color-header active" href="{{route('index')}}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link font-changa font-18 font-semibold font-header text-color-header" href="{{route('about')}}">Sobre Nós</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link font-changa font-18 font-semibold font-header text-color-header" href="{{ request()->routeIs('index') ? '#depoiment' : route('index') . '#depoiment' }}">Depoimentos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link font-changa font-18 font-semibold font-header text-color-header" href="{{ request()->routeIs('about') ? '#team-section' : route('about') . '#team-section' }}">Representantes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link font-changa font-18 font-semibold font-header text-color-header" href="{{route('products')}}">Produtos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link font-changa font-18 font-semibold font-header text-color-header" href="{{route('contact')}}">Contato</a>
                    </li>
                </ul>

                <!-- Botão -->
                <div class="d-flex justify-content-center gap-2 align-items-center btn-header bg-button-one rounded-pill py-2 px-4 hover-zoom">
                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M11.6741 10.0755C11.5016 9.96226 11.3291 9.90566 11.1565 10.1321L10.4665 11.0377C10.2939 11.1509 10.1789 11.2075 9.94888 11.0943C9.08626 10.6415 7.87859 10.1321 6.84345 8.43396C6.78594 8.20755 6.90096 8.09434 7.01597 7.98113L7.53355 7.18868C7.64856 7.07547 7.59105 6.96226 7.53355 6.84906L6.84345 5.20755C6.67093 4.75472 6.4984 4.81132 6.32588 4.81132H5.86581C5.7508 4.81132 5.52077 4.86792 5.29073 5.09434C4.02556 6.33962 4.54313 8.09434 5.46326 9.22642C5.63578 9.45283 6.78594 11.4906 9.25879 12.566C11.099 13.3585 11.5016 13.2453 12.0192 13.1321C12.6518 13.0755 13.2843 12.566 13.5719 12.0566C13.6294 11.8868 13.9169 11.1509 13.6869 11.0377M9.14377 16.3585C6.78594 16.3585 5.00319 15.1132 5.00319 15.1132L2.1853 15.8491L2.8754 13.1321C2.8754 13.1321 1.72524 11.3774 1.72524 9.16981C1.72524 5.09434 5.11821 1.69811 9.31629 1.69811C13.2268 1.69811 16.5623 4.69811 16.5623 8.88679C16.5623 12.9623 13.2268 16.3019 9.14377 16.3585ZM0 18L4.77316 16.6981C6.15555 17.3947 7.69626 17.7309 9.24823 17.6747C10.8002 17.6184 12.3116 17.1715 13.6382 16.3768C14.9648 15.582 16.0622 14.4658 16.8259 13.1347C17.5895 11.8037 17.9937 10.3022 18 8.77359C18 3.90566 14.0895 0 9.14377 0C7.55639 0.00399723 5.99777 0.417245 4.62313 1.19859C3.24848 1.97993 2.10579 3.10211 1.30885 4.45336C0.511907 5.80461 0.0885224 7.33778 0.0808596 8.9002C0.0731969 10.4626 0.481524 11.9997 1.26518 13.3585" fill="var(--color-button-one)"/>
                    </svg>

                    <a class="font-changa font-15 font-medium text-decoration-none color-button-one">
                        {{ $tenantTheme->text_button_one ?? 'Botão 1' }}
                    </a>
                </div>
            </div>
        </nav>
    </header>

    <div class="modal fade" id="modalDownloadFicha" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">

                <form id="formDownloadFicha">
                    @csrf

                    <div class="modal-header flex-column">
                        <div class="d-flex justify-content-end col-12">
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <img src="{{asset('build/client/themes/petshop/tp-01/images/girollato-footer.svg')}}" alt="{{ config('app.name') }}" height="40">
                        <h5 class="modal-title text-white font-changa font-20 font-medium mt-3">Preencha o formulário para baixar o arquivo</h5>
                    </div>

                    <div class="modal-body">

                        <div class="mb-3">
                            <label class="form-label text-white font-changa font-15 font-regular">Nome</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>

                        <div class="row">
                            <div class="mb-3 col-12 col-lg-6">
                                <label class="form-label text-white font-changa font-15 font-regular">CNPJ</label>
                                <input type="text" inputmode="numeric" name="cnpj" id="cnpj" class="form-control" required>
                            </div>
    
                            <div class="mb-3 col-12 col-lg-6">
                                <label class="form-label text-white font-changa font-15 font-regular">Telefone</label>
                                <input type="text" inputmode="numeric" name="phone" id="phone" class="form-control" required>
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn bg-yellow border">
                            Baixar arquivo
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const modal = new bootstrap.Modal(document.getElementById('modalDownloadFicha'));
            const form = document.getElementById('formDownloadFicha');

            let currentFile = null;

            document.querySelectorAll('.btn-download-ficha').forEach(button => {

                button.addEventListener('click', function(e){

                    e.preventDefault();

                    currentFile = this.getAttribute('href');

                    modal.show();

                });

            });

            form.addEventListener('submit', function(e){

                e.preventDefault();

                const formData = new FormData(form);

                fetch("{{ route('download.ficha.store') }}", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('input[name=_token]').value
                    },
                    body: formData
                })
                .then(res => res.json())
                .then(res => {

                    if(res.success){

                        modal.hide();

                        // FORÇA DOWNLOAD
                        const link = document.createElement('a');
                        link.href = currentFile;
                        link.setAttribute('download', '');
                        document.body.appendChild(link);
                        link.click();
                        document.body.removeChild(link);

                        form.reset();

                    }

                });

            });

        });

        // mascara CNPJ
        function maskCNPJ(value) {

            value = value.replace(/\D/g, '');

            value = value.replace(/^(\d{2})(\d)/, '$1.$2');
            value = value.replace(/^(\d{2})\.(\d{3})(\d)/, '$1.$2.$3');
            value = value.replace(/\.(\d{3})(\d)/, '.$1/$2');
            value = value.replace(/(\d{4})(\d)/, '$1-$2');

            return value.substring(0, 18);
        }


        // mascara celular
        function maskPhone(value) {

            value = value.replace(/\D/g, '');

            value = value.replace(/^(\d{2})(\d)/g, '($1) $2');
            value = value.replace(/(\d{5})(\d)/, '$1-$2');

            return value.substring(0, 15);
        }


        // aplicar máscaras
        document.addEventListener('DOMContentLoaded', function () {

            const cnpj = document.getElementById('cnpj');
            const phone = document.getElementById('phone');

            if(cnpj){
                cnpj.addEventListener('input', function(){
                    this.value = maskCNPJ(this.value);
                });
            }

            if(phone){
                phone.addEventListener('input', function(){
                    this.value = maskPhone(this.value);
                });
            }

        });
    </script>

    <main>
        @yield('content') 
    </main>

    <footer class="bg-footer text-white pt-5 pb-3">
        <div class="container">

            <!-- Linha principal -->
            <div class="row align-items-start">

                <!-- Logo + botão -->
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <img src="{{asset('storage/' .$tenantTheme->path_image_logo_footer)}}" alt="{{ config('app.name') }}" height="40">

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
                    <h6 class="font-changa text-color-footer font-16 font-bold mb-3 position-relative d-inline-block font-changa font-16 font-medium">
                        Mapa do Site
                        <span class="d-block bg-yellow mt-1" style="height:3px; width:40px;"></span>
                    </h6>

                    <div class="row">
                        <div class="col-6">
                            <ul class="list-unstyled">
                                <li><a href="{{route('index')}}" class="text-color-footer font-changa font-16 font-regular text-decoration-none d-block mb-2">Início</a></li>
                                <li><a href="{{route('about')}}" class="text-color-footer font-changa font-16 font-regular text-decoration-none d-block mb-2">Quem Somos</a></li>
                                <li><a href="{{ request()->routeIs('index') ? '#stats-section' : route('index') . '#stats-section' }}" class="text-color-footer font-changa font-16 font-regular text-decoration-none d-block mb-2">Diferenciais</a></li>
                                <li><a href="{{route('blogAll')}}" class="text-color-footer font-changa font-16 font-regular text-decoration-none d-block mb-2">Blog</a></li>
                                <li><a href="{{route('products')}}" class="text-color-footer font-changa font-16 font-regular text-decoration-none d-block mb-2">Produtos</a></li>
                            </ul>
                        </div>

                        <div class="col-6">
                            <ul class="list-unstyled">
                                <li><a href="{{ request()->routeIs('index') ? '#depoiment' : route('index') . '#depoiment' }}" class="text-color-footer font-changa font-16 font-regular text-decoration-none d-block mb-2">Depoimentos</a></li>
                                <li><a href="{{ request()->routeIs('index') ? '#faq' : route('index') . '#faq' }}" class="text-color-footer font-changa font-16 font-regular text-decoration-none d-block mb-2">FAQ</a></li>
                                <li><a href="{{route('contact')}}" class="text-color-footer font-changa font-16 font-regular text-decoration-none d-block mb-2">Contato</a></li>
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
                            @if ($contact->link_insta <> null)                            
                                <a href="{{$contact->link_insta}}" target="_blank" rel="noopener noreferrer" class="text-color-footer fs-5">
                                    <i class="bi bi-instagram"></i>
                                </a>
                            @endif
                            @if ($contact->link_face <> null)                            
                                <a href="{{$contact->link_face}}" target="_blank" rel="noopener noreferrer" class="text-color-footer fs-5">
                                    <i class="bi bi-facebook"></i>
                                </a>
                            @endif
                            @if ($contact->link_tik_tok <> null)                            
                                <a href="{{$contact->link_tik_tok}}" target="_blank" rel="noopener noreferrer" class="text-color-footer fs-5">
                                    <i class="bi bi-linkedin"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                @endif

            </div>

            <!-- Linha inferior -->
            <hr class="border-light opacity-25 my-4">

            <div class="row align-items-center">

                <div class="col-md-10 small">
                    <div class="d-flex flex-wrap col-12 font-changa font-16 font-regular text-center text-lg-end justify-content-center justify-content-lg-end">
                        <p id="footer-text" class="text-color-footer"></p>                        
                    </div>

                    <script defer>
                        const currentYeaar = (new Date).getFullYear();
                        document.getElementById("footer-text").innerHTML = `© ${currentYeaar} <span> {{$tenantTheme->copyright}}
                    Todos os direitos reservados.</span> <a href="https://policies.google.com/privacy?hl=pt-BR" target="_blank" class="text-color-footer font-semibold">| Política de Privacidade</a>`
                    </script>
                </div>

                <div class="col-12 col-md-2 text-center text-md-end mt-3 mt-md-0">
                    <a href="http://www.whi.dev.br" target="_blank" rel="noopener noreferrer">
                        <img src="{{asset('build/client/themes/petshop/tp-01/images/whi.svg')}}" alt="Agência WHI" style="height:35px;">
                    </a>
                </div>

            </div>

        </div>
    </footer>

    <a href="#" id="scroll-top" class="scroll-top bg-scroll d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
    
    <script src="https://cdn.ckeditor.com/4.22.1/basic/ckeditor.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('build/client/bootstrap/js/bootstrap.bundle.js') }}"></script>
    <script src="{{ asset('build/client/lgpd/script.js') }}"></script>
    <script src="{{ asset('build/client/themes/petshop/tp-01/js/default.js') }}"></script>
    <script src="{{ asset('build/client/js/default.js') }}"></script>

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