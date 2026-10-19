<!DOCTYPE html>
<html lang="pt-BR">
<head>
    @php
        $seoTitle = $seoGoogle->title ?? '';
        $seoDescription = $seoGoogle->description ?? '';
        $seoKeywords = $seoGoogle->keywords ?? '';

        $socialImage = !empty($seoGoogle->social_image) ? asset('storage/' . $seoGoogle->social_image) : null;
        $organizationLogo = !empty($seoGoogle->organization_logo) ? asset('storage/' . $seoGoogle->organization_logo) : null;
        $favicon = !empty($seoGoogle->favicon) ? asset('storage/' . $seoGoogle->favicon) : null;

        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            '@id' => '#organization',
        ];

        if (!empty($seoGoogle->organization_name)) $schema['name'] = $seoGoogle->organization_name;
        if (!empty($seoGoogle->legal_name)) $schema['legalName'] = $seoGoogle->legal_name;
        if (!empty($seoGoogle->organization_url)) $schema['url'] = $seoGoogle->organization_url;

        if ($organizationLogo) {
            $schema['logo'] = $organizationLogo;
            $schema['image'] = $organizationLogo;
        } elseif ($socialImage) {
            $schema['logo'] = $socialImage;
            $schema['image'] = $socialImage;
        }

        if (!empty($seoGoogle->organization_description)) $schema['description'] = $seoGoogle->organization_description;

        if (!empty($seoGoogle->founding_date)) {
            $schema['foundingDate'] = $seoGoogle->founding_date instanceof \Carbon\Carbon ? $seoGoogle->founding_date->format('Y-m-d') : $seoGoogle->founding_date;
        }

        if (!empty($seoGoogle->email)) $schema['email'] = $seoGoogle->email;
        if (!empty($seoGoogle->telephone)) $schema['telephone'] = $seoGoogle->telephone;

        $address = [];

        if (!empty($seoGoogle->street_address)) $address['streetAddress'] = $seoGoogle->street_address;
        if (!empty($seoGoogle->address_locality)) $address['addressLocality'] = $seoGoogle->address_locality;
        if (!empty($seoGoogle->address_region)) $address['addressRegion'] = $seoGoogle->address_region;
        if (!empty($seoGoogle->postal_code)) $address['postalCode'] = $seoGoogle->postal_code;
        if (!empty($seoGoogle->address_country)) $address['addressCountry'] = $seoGoogle->address_country;

        if (!empty($address)) $schema['address'] = array_merge(['@type' => 'PostalAddress'], $address);

        $contactPoint = [];

        if (!empty($seoGoogle->telephone)) $contactPoint['telephone'] = $seoGoogle->telephone;
        if (!empty($seoGoogle->contact_type)) $contactPoint['contactType'] = $seoGoogle->contact_type;
        if (!empty($seoGoogle->email)) $contactPoint['email'] = $seoGoogle->email;
        if (!empty($seoGoogle->area_served)) $contactPoint['areaServed'] = $seoGoogle->area_served;

        if (!empty($seoGoogle->available_languages)) {
            $languages = is_array($seoGoogle->available_languages) ? $seoGoogle->available_languages : array_map('trim', explode(',', $seoGoogle->available_languages));
            $languages = array_values(array_filter($languages));
            if (!empty($languages)) $contactPoint['availableLanguage'] = $languages;
        }

        if (!empty($contactPoint)) $schema['contactPoint'] = array_merge(['@type' => 'ContactPoint'], $contactPoint);

        if (!empty($seoGoogle->opening_hours)) {
            $openingHours = $seoGoogle->opening_hours;

            if (is_string($openingHours)) {
                $decodedOpeningHours = json_decode($openingHours, true);
                if (json_last_error() === JSON_ERROR_NONE) $openingHours = $decodedOpeningHours;
            }

            if (!empty($openingHours)) $schema['openingHoursSpecification'] = $openingHours;
        }

        if (!empty($seoGoogle->slogan)) $schema['slogan'] = $seoGoogle->slogan;

        if (!empty($seoGoogle->organization_keywords)) {
            $organizationKeywords = is_array($seoGoogle->organization_keywords) ? $seoGoogle->organization_keywords : array_map('trim', explode(',', $seoGoogle->organization_keywords));
            $organizationKeywords = array_values(array_filter($organizationKeywords));
            if (!empty($organizationKeywords)) $schema['keywords'] = $organizationKeywords;
        }
    @endphp

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

        @elseif(isset($templateThemeInner))

            @php
                $templateImage = !empty($templateThemeInner->preview[0])
                    ? asset('storage/' . $templateThemeInner->preview[0])
                    : $socialImage;

                $templateTitle = $templateThemeInner->title ?? $seoTitle;
                $templateDescription = $templateThemeInner->description ? $templateThemeInner->description : 'Confira este template na plataforma Whi Web.';        
            @endphp

            <meta name="description" content="{{ $templateDescription }}">

            <meta property="og:url" content="{{ url()->current() }}">
            <meta property="og:type" content="website">
            <meta property="og:title" content="{{ $templateTitle }}">
            <meta property="og:description" content="{{ $templateDescription }}">

            @if($templateImage)
                <meta property="og:image" content="{{ $templateImage }}">
            @endif

            <meta name="twitter:card" content="summary_large_image">
            <meta name="twitter:url" content="{{ url()->current() }}">
            <meta name="twitter:title" content="{{ $templateTitle }}">
            <meta name="twitter:description" content="{{ $templateDescription }}">

            @if($templateImage)
                <meta name="twitter:image" content="{{ $templateImage }}">
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
    
    <link rel="canonical" href="{{ url()->current() }}">
    <meta name="copyright" content="Direitos reservados WHI">
    <meta name="author" content="WHI">

    @if($favicon)
        <link rel="shortcut icon" href="{{ $favicon }}">
    @endif

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@200..800&display=swap" onload="this.onload=null;this.rel='stylesheet'">

    <noscript>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@200..800&display=swap">
    </noscript>

    <link href="{{ asset('build/client/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('build/client/themes/whi-web/tp-01/css/style.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('build/client/css/default.css') }}" rel="stylesheet" type="text/css">
    <link rel="preload" href="{{ asset('build/client/lgpd/style.css') }}" as="style"  onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link rel="stylesheet"  href="{{ asset('build/client/lgpd/style.css') }}">
    </noscript>

    <link rel="preload" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css"></noscript>

    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"></noscript>

    <link href="{{ asset('build/client/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link rel="preload" href="{{ asset('build/client/bootstrap-icons/bootstrap-icons.css') }}" as="style" onload="this.rel='stylesheet'">

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <script type="application/ld+json">{!! json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}</script>
</head>

<body>

    <div id="organization" hidden></div>

    @include('client/script-seo-google/script-body-nocript')

    @include('client/themes/whi-web/tp-01/includes/lgpd/lgpd')

    {{-- Preloader --}}
    <div id="preloader">
        <div id="loader"></div>
    </div>

    {{-- WhatsApp --}}
    @if(isset($contact) && $contact->whatsapp <> null)
        @php
            $phone = preg_replace('/\D/', '', $contact->whatsapp);
            $mensagem = "Olá! Encontrei seu site e gostaria de conhecer mais sobre os planos disponíveis.%0A";
        @endphp

        <a href="https://wa.me/55{{ $phone }}?text={{ $mensagem }}" class="whatsapp-floatt" target="_blank" rel="noopener noreferrer" aria-label="Fale conosco no WhatsApp">
            <i class="bi bi-whatsapp"></i>
        </a>
    @endif

    <style>
        :root {
            --primary-color: {{ $tenantTheme->primary_color ?: '#10513D' }};
            --secondary-color: {{ $tenantTheme->secondary_color ?: '#FDC20C' }};
            --accent-color: {{ $tenantTheme->accent_color ?: 'rgba(16, 81, 61, 0.5)' }};
            --text-color: {{ $tenantTheme->text_color ?: '#565656' }};
            --text-color-header: {{ $tenantTheme->text_color_header ?: '#FFFFFF' }};
            --bg-header: {{ $tenantTheme->bg_header ?: '#10513D' }};
            --text-color-footer: {{ $tenantTheme->text_color_footer ?: '#FFFFFF' }};
            --bg-footer: {{ $tenantTheme->bg_footer ?: '#10513D' }};
            --bg-scroll: {{ $tenantTheme->bg_scroll ?: '#F8F9FA' }};
            --color-button-one: {{ $tenantTheme->color_button_one ?: '#FFF' }};
            --color-button-two: {{ $tenantTheme->color_button_two ?: '#000' }};
            --text-button-one: {{ $tenantTheme->text_button_one ?: 'Botão 1' }};
            --bg-button-one: {{ $tenantTheme->bg_button_one ?: '#10513D' }};
            --text-button-two: {{ $tenantTheme->text_button_two ?: 'Botão 2' }};
            --bg-button-two: {{ $tenantTheme->bg_button_two ?: '#FDC20C' }};
            --copyright-text: {{ $tenantTheme->copyright ?: '© 2024 Todos os direitos reservados' }};
        }
        body{ background: #021127 !important }
        .bg-yellow{ background: var(--secondary-color)}
        .tpl-modal-sec .tpl-badge{
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.12);
            color: var(--secondary-color) !important;
        }
        .tpl-modal-sec .tpl-scroll-hint, .tpl-modal-sec .tpl-category{
            color: var(--secondary-color)
        }
        .bg-button-two.color-button-two.px-3.py-2.rounded-3 {
            position: relative;
            overflow: hidden;
            z-index: 1;
            font-weight: 600;
            font-size: 16px;
            isolation: isolate;
        }

        .bg-button-two.color-button-two.px-3.py-2.rounded-3::before {
            content: "";
            position: absolute;
            inset: 0;
            width: 0;
            height: 100%;
            background: var(--bg-button-one);
            border-radius: 6px;
            transition: width .6s ease;
            z-index: 0;
        }

        .bg-button-two.color-button-two.px-3.py-2.rounded-3:hover::before {
            width: 100%;
        }

        .bg-button-two.color-button-two.px-3.py-2.rounded-3:hover {
            color: var(--color-button-one);
        }
        .bg-button-two.color-button-two.px-3.py-2.rounded-3 span {
            position: relative;
            z-index: 1;
        }
        .testimonial-card:hover{
            border-color: color-mix(in srgb, var(--secondary-color) 40%, transparent);
        }
        .author-avatar{
            border: 2px solid var(--secondary-color);
        }
        .tpl-modal-sec .tpl-card:hover .tpl-arrow, .tpl-modal-sec .tpl-btn-preview, .tpl-modal-sec .tpl-card:hover .tpl-arrow{background: var(--secondary-color) !important;}
        .why_new_section .why_new_section_inner .why_new_left_data .why_data_block .number{background: var(--primary-color);}
        .why_new_section .why_new_section_inner .why_new_left_data .why_data_block{background: color-mix(in srgb, var(--secondary-color) 10%, transparent);;border: solid 1px var(--secondary-color);}
        .title_badge{color: var(--secondary-color); border:1px solid var(--secondary-color)}
        .primary-color { color: var(--primary-color); }
        .secondary-color { color: var(--secondary-color); }
        .accent-color { color: var(--accent-color); }
        .text-color { color: var(--text-color); }
        .text-color-header { color: var(--text-color-header); }
        .text-color-footer { color: var(--text-color-footer); }
        .color-button-one { color: var(--color-button-one); }
        .color-button-two { color: var(--color-button-two); }
        .bg-primary-color { background: var(--primary-color); }
        .bg-secondary-color { background: var(--secondary-color); }
        .bg-accent-color { background: var(--accent-color); }
        .bg-header { background: var(--bg-header); }
        .bg-footer { background: var(--bg-footer); }
        .bg-scroll { background: var(--bg-scroll); }
        .bg-button-one { background: var(--bg-button-one); }
        .bg-button-two { background: var(--bg-button-two); }
    </style>

    {{-- Header --}}
    <header>
        <div class="container">
            <nav class="navbar navbar-expand-lg mt-0 justify-content-center justify-content-md-start">
                <a class="navbar-brand logo-header" href="{{ route('index') }}">
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

                @if(isset($tenantTheme->link_header) && $tenantTheme->link_header <> null)
                    <a href="{{ $tenantTheme->link_header }}" target="_blank" rel="noopener noreferrer" class="bg-button-one color-button-one ms-auto px-4 py-2">
                        <i class="bi bi-box-arrow-in-right"></i> {{ $tenantTheme->btn_title_header }}
                    </a>
                @endif
            </nav>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    @if (isset($contact) && $contact <> null)
      <section class="cta-pro-section" id="contact_sec">
        <!-- Glows de Iluminação em Camadas -->
        <div class="cta-glow-1"></div>
        <div class="cta-glow-2"></div>

        <div class="container">
          <div class="cta-glass-card p-3 p-lg-4">
            <div class="row align-items-center">
              
              <!-- Conteúdo Principal -->
              <div class="col-lg-6 mb-4 mb-lg-0">
                <div class="cta-status-badge">
                  <span class="status-dot"></span>
                  Equipe Online Agora
                </div>
                <h2 class="cta-title">{{$contact->name_section}}</h2>
                <div class="cta-subtitle">{!!$contact->text!!}</div>

                <!-- Seletor de Assuntos (Interativo) -->
                <div class="cta-topics-label">Sobre o que deseja falar?</div>
                <div class="cta-topics-group justify-content-center justify-content-lg-start">
                  <span class="topic-chip active" data-subject="Orçamento & Prazos">Orçamento</span>
                  <span class="topic-chip" data-subject="Dúvidas Técnicas">Dúvidas Técnicas</span>
                  <span class="topic-chip" data-subject="Contratar Plano">Contratar Plano</span>
                  <span class="topic-chip" data-subject="Suporte">Suporte</span>
                </div>
              </div>

              <!-- Canais Rápidos de Contato -->
              <div class="col-lg-6">
                <div class="d-flex flex-column gap-3">

                  <!-- Canal 1: WhatsApp Direto -->
                  @if(isset($contact) && $contact->whatsapp <> null)
                    @php
                        $phone = preg_replace('/\D/', '', $contact->whatsapp);
                        $mensagem = "Olá! Encontrei seu site e gostaria de conhecer mais sobre os planos disponíveis.%0A";
                    @endphp
                    <div class="contact-channel-card justify-content-start justify-content-lg-between p-2 p-lg-4">
                      <div class="channel-info">
                        <div class="channel-icon">
                          <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                        </div>
                        <div class="channel-details">
                          <div class="h4">Atendimento Telefônico / WhatsApp</div>
                          <p class="d-flex justify-content-start">{{$contact->whatsapp}}</p>
                        </div>
                      </div>
                      <div class="d-flex gap-2 w-100-mobile">
                        <button class="btn-channel-action" onclick="copyToClipboard('{{$contact->whatsapp}}', 'Telefone copiado!')" title="Copiar Número">
                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="14" height="14" x="8" y="8" rx="2" ry="2"/><path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"/></svg>
                        </button>
                        <a href="https://wa.me/55{{ $phone }}?text={{ $mensagem }}" id="whatsapp-btn" target="_blank" class="btn-channel-action btn-channel-primary">
                          Conversar
                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                        </a>
                      </div>
                    </div>
                  @endif

                  <!-- Canal 2: E-mail -->
                  @if (isset($contact->name_one) && $contact->name_one <> null)                  
                    <div class="contact-channel-card justify-content-start justify-content-lg-between p-2 p-lg-4">
                      <div class="channel-info">
                        <div class="channel-icon">
                          <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                        </div>
                        <div class="channel-details">
                          <div class="h4">Envie uma mensagem por e-mail</div>
                          <p class="d-flex justify-content-star">{{$contact->name_one}}</p>
                        </div>
                      </div>
                      <div class="d-flex gap-2 w-100-mobile">
                        <button class="btn-channel-action" onclick="copyToClipboard('{{$contact->name_one}}', 'E-mail copiado!')" title="Copiar E-mail">
                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="14" height="14" x="8" y="8" rx="2" ry="2"/><path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"/></svg>
                        </button>
                        <a href="mailto:{{$contact->name_one}}" class="btn-channel-action">
                          Escrever
                        </a>
                      </div>
                    </div>
                  @endif

                </div>
              </div>

            </div>
          </div>
        </div>
      </section>
    @endif

    @if (isset($contact) && ($contact->link_insta || $contact->link_face || $contact->link_tik_tok))
        <section class="social-section-light">
            <div class="container">
            <div class="social-wrapper-card shadow-sm">
                <div class="row align-items-center">
                
                <!-- Lado Esquerdo: Chamada Institucional -->
                <div class="col-lg-5 mb-3 mb-lg-0">
                    <span class="social-badge">
                    <i class="bi bi-share-fill"></i> Conecte-se Conosco
                    </span>
                    <h3 class="social-title">Siga a WHI nas redes sociais</h3>
                </div>

                <!-- Lado Direito: Botoes Interativos de Redes Sociais -->
                <div class="col-lg-7">
                    <div class="social-links-container justify-content-lg-end">
                    
                    <!-- Instagram -->
                    @if ($contact->link_insta != null)
                        <a href="{{ $contact->link_insta }}" target="_blank" rel="noopener noreferrer" class="social-pill-btn insta">
                        <i class="bi bi-instagram"></i>
                        <span>Instagram</span>
                        </a>
                    @endif

                    <!-- Facebook -->
                    @if ($contact->link_face != null)
                        <a href="{{ $contact->link_face }}" target="_blank" rel="noopener noreferrer" class="social-pill-btn face">
                        <i class="bi bi-facebook"></i>
                        <span>Facebook</span>
                        </a>
                    @endif

                    <!-- TikTok / LinkedIn -->
                    @if ($contact->link_tik_tok != null)
                        <a href="{{ $contact->link_tik_tok }}" target="_blank" rel="noopener noreferrer" class="social-pill-btn tiktok">
                        <i class="bi bi-tiktok"></i>
                        <span>TikTok</span>
                        </a>
                    @endif

                    </div>
                </div>

                </div>
            </div>
            </div>
        </section>
    @endif
    
    <!-- Toast de Notificação -->
    <div id="cta-toast" class="cta-toast">
      <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
      <span id="toast-message">Copiado com sucesso!</span>
    </div>

    {{-- Footer --}}
    <footer class="bg-footer border-top pt-3 pt-lg-5 pb-3">
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
                            <a href="{{ $tenantTheme->link }}" target="_blank" rel="noopener noreferrer" class="bg-button-two color-button-two px-4 py-2 font-changa font-16 font-medium text-decoration-none hover-zoom">
                                {{$tenantTheme->btn_title}}
                                <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Mapa do site -->
                <div class="col-lg-4 mb-4 mb-0 text-start">
                    <div class="text-color-footer mb-3 position-relative d-inline-block font-changa font-16 font-bold map-footer">
                        Mapa do Site
                        <span class="d-block bg-yellow mt-1" style="height:3px; width:40px;"></span>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <ul class="list-unstyled">
                                <li><a href="{{route('index')}}" class="text-start text-color-footer font-changa font-16 font-regular text-decoration-none d-block mb-2">Início</a></li>
                                <li><a href="{{route('index')}}#why_sec" class="text-start text-color-footer font-changa font-16 font-regular text-decoration-none d-block mb-2">Como funciona</a></li>
                                <li><a href="{{route('index')}}#plans" class="text-start text-color-footer font-changa font-16 font-regular text-decoration-none d-block mb-2">Planos</a></li>
                            </ul>
                        </div>

                        <div class="col-6">
                            <ul class="list-unstyled">
                                <li><a href="{{route('index')}}#templates" class="text-start text-color-footer font-changa font-16 font-regular text-decoration-none d-block mb-2">Modelos</a></li>
                                <li><a href="{{ request()->routeIs('index') ? '#depoiment' : route('index') . '#depoiment' }}" class="text-start text-color-footer font-changa font-16 font-regular text-decoration-none d-block mb-2">Depoimentos</a></li>
                                <li><a href="{{ request()->routeIs('index') ? '#faq' : route('index') . '#faq' }}" class="text-start text-color-footer font-changa font-16 font-regular text-decoration-none d-block mb-2">FAQ</a></li>
                                <li><a href="{{route('index')}}#contact_sec" class="text-start text-color-footer font-changa font-16 font-regular text-decoration-none d-block mb-2">Contato</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6 col-12 text-start">

                    <div class="h5 text-color-footer mb-1 font-changa font-16 font-bold map-footer">Newsletter</div>
                    <div class="news_letter">
                        <p class="text-color-footer font-15">Inscreva-se e seja o primeiro a receber promoções incríveis</p>
                        
                        <form id="newsletter-form" action="{{ route('send-newsletter') }}" method="POST">
                            @csrf

                            <div class="form-group">
                                <input type="email" id="email" name="email" class="form-control" placeholder="Informe seu email" required>

                                <button type="submit" class="btn" aria-label="subscribe">
                                    <i class="bi bi-send-fill"></i>
                                </button>
                            </div>

                            <label class="text-color-footer font-12 d-flex justify-content-start gap-1 align-items-center mt-2">
                                <input name="term_privacy" type="checkbox" id="privacy-policy" required>
                                Concordo com a Política de Privacidade da Whiweb.
                            </label>
                        </form>
                    </div>

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

    <script defer src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/gsap@3.15/dist/gsap.min.js"></script>
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
    <script defer src="{{ asset('build/client/bootstrap/js/bootstrap.bundle.js') }}"></script>
    <script defer src="{{ asset('build/client/lgpd/script.js') }}"></script>
    <script defer src="{{ asset('build/client/themes/whi-web/tp-01/js/jquery.js') }}"></script>
    <script defer src="{{ asset('build/client/themes/whi-web/tp-01/js/typed.min.js') }}"></script>
    <script defer src="{{ asset('build/client/themes/whi-web/tp-01/js/functions-site.js') }}"></script>
    <script defer src="{{ asset('build/client/themes/whi-web/tp-01/js/gsap-efect.js') }}"></script>
    <script defer src="{{ asset('build/client/themes/whi-web/tp-01/js/main.js') }}"></script>
    <script defer src="{{ asset('build/client/js/default.js') }}"></script>

    @php
        if (isset($slide)) {
            
            $slide = $slides->first();
        }
    @endphp

    @if (isset($slide))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const typedStrings = @json($slide->typed ?? '')
                    .split(',')
                    .map(item => item.trim())
                    .filter(item => item !== '');

                if (
                    typeof jQuery !== 'undefined' &&
                    typeof jQuery.fn.typed === 'function' &&
                    typedStrings.length > 0
                ) {
                    jQuery('#typed').typed({
                        strings: typedStrings,
                        typeSpeed: 100,
                        startDelay: 0,
                        backSpeed: 60,
                        backDelay: 2000,
                        loop: true,
                        cursorChar: '|',
                        contentType: 'html'
                    });
                }
            });
        </script>
    @endif

    <script>
        document.getElementById('newsletter-form').addEventListener('submit', async function (event) {
            event.preventDefault();

            const form = this;
            const button = form.querySelector('button[type="submit"]');

            button.disabled = true;

            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: new FormData(form)
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    showToast(data.message);
                    form.reset();
                } else {
                    showToast(data.message ?? 'Não foi possível realizar o cadastro.');
                }
            } catch (error) {
                showToast('Ocorreu um erro. Tente novamente.');
            } finally {
                button.disabled = false;
            }
        });
    </script>

</body>
</html>