@extends($theme->core('client'))

@section('content')
    <!-- Banner-Section-Start -->
    @if (isset($slides) && $slides->count())
      <section class="banner_section hero-sales-section position-relative overflow-hidden py-5" id="home_sec">
          <!-- Background Glow & Mesh Gradient -->
          <div class="hero-bg-glow"></div>

          <div class="container position-relative z-2 py-lg-4">
              <div class="row align-items-center gy-5" style="height: 100vh">
                  <!-- COLUNA DA ESQUERDA: COPY DE ALTO IMPACTO -->
                  @foreach ($slides as $slide)
                    <div class="col-lg-6 text-center text-lg-start">
                        <!-- Título Principal com Tipografia Forte -->
                        <h1 class="hero-main-title font-changa font-semibold text-white font-medium mb-3">
                            {{$slide->title}}
                            <span class="d-block text-gradient-accent secondary-color font-bold">{{$slide->subtitle}}</span>
                        </h1>

                        <!-- Subtítulo Persuasivo -->
                        <div class="hero-subtext text-white-50 font-18 mb-4 pe-lg-4">
                            {!!$slide->description!!}
                        </div>

                        <!-- CTAs de Conversão -->
                        <div class="d-flex flex-column flex-sm-row justify-content-center justify-content-lg-start gap-3 mb-4">
                            <a
                                href="#plans"
                                class="rounded-1 d-flex align-items-center justify-content-center btn-one py-2 px-3 px-lg-5 btn-hero font-changa bg-button-one color-button-one font-15 font-bold text-decoration-none"
                            >
                                <span class="">Começar Agora por R$ 59,90</span>
                                <i class="ms-2 bi bi-arrow-right font-20"></i>
                            </a>
                            @if (isset($contact) && $contact->whatsapp <> null)
                              @php
                                  // Remove caracteres não numéricos do telefone
                                  $phone = preg_replace('/\D/', '', $contact->whatsapp);

                                  // Monta mensagem com ícones e quebras de linha
                                  $mensagem = "Olá! Encontrei seu site e gostaria de conhecer mais sobre os planos disponíveis.%0A";
                              @endphp
                              <a
                                  href="https://wa.me/55{{ $phone }}?text={{ $mensagem }}"
                                  target="_blank"
                                  class="btn d-flex align-items-center justify-content-center btn-outline-light py-2 px-3 px-lg-5 font-15 font-medium"
                              >
                                  <i class="bi bi-whatsapp color-whatsapp me-2 font-16"></i>
                                  <span>Falar no WhatsApp</span>
                              </a>
                            @endif
                        </div>

                        <!-- Social Proof & Garantias -->
                        <div
                            class="d-flex align-items-center justify-content-center justify-content-lg-start gap-4 pt-2 text-white-50 font-13"
                        >
                            <div class="d-flex align-items-center gap-1.5">
                                <i class="bi bi-check-circle-fill text-success me-2"></i> Site + hospedagem + suporte
                            </div>
                            <div class="d-flex align-items-center gap-1.5">
                                <i class="bi bi-check-circle-fill text-success me-2"></i> Estrutura otimizada para o Google
                            </div>
                            <div class="d-flex align-items-center gap-1.5">
                                <i class="bi bi-check-circle-fill text-success me-2"></i> Setup Rápido
                            </div>
                        </div>
                    </div>

                    <!-- COLUNA DA DIREITA: MOCKUP INTERATIVO REPLICADO EM HTML/CSS -->
                    <div class="col-lg-6 m-0 mt-3 mt-lg-0">
                        <div class="hero-mockup-wrapper position-relative mx-auto">
                            <!-- TABLET CONTAINER (REPLICAÇÃO DA IMAGEM) -->
                            <div class="tablet-device shadow-lg">
                                <!-- Tablet Top Bar -->
                                <div class="tablet-header d-flex align-items-center justify-content-between flex-column gap-2 px-3 py-2">
                                    <div class="col-12 d-flex align-items-center justify-content-between">
                                      <span class="tablet-time font-11 text-white-50">agosto quinta-feira às 19:04</span>
                                      <div class="tablet-status font-11 text-white-50">
                                        <i class="bi bi-wifi me-1"></i> 100% <i class="bi bi-battery-full ms-1"></i>
                                      </div>
                                    </div>
                                    <div class="col-12 d-flex align-items-center justify-content-center gap-1">
                                      <svg xmlns="http://www.w3.org/2000/svg"
                                          class="text-white-50"
                                          width="20"
                                          height="20"
                                          viewBox="0 0 24 24"
                                          fill="none"
                                          stroke="currentColor"
                                          stroke-width="1.8"
                                          stroke-linecap="round"
                                          stroke-linejoin="round"
                                          aria-label="Página inicial">
                                          <path d="M3 11.5L12 4l9 7.5"/>
                                          <path d="M5 10v10h14V10"/>
                                      </svg>
                                      <div class="tablet-browser-bar d-flex align-items-center px-2 py-0.5 rounded-3 col-10">
                                          <i class="bi bi-lock-fill font-10 text-success me-1"></i>
                                          <span class="font-11 text-white-50">whiweb.com.br</span>
                                      </div>
                                      <span class="border-white-50 text-white-50 font-10 rounded-1 px-1">1</span>
                                      <div class="points">
                                          <span></span>
                                          <span></span>
                                          <span></span>
                                      </div>
                                    </div>
                                </div>
  
                                <!-- Tablet Screen / Admin Dashboard -->
                                <div class="tablet-body py-2 px-3">
                                    <!-- App Top Bar -->
                                    <div
                                        class="app-navbar d-flex align-items-center justify-content-between p-2 rounded-3 mb-3"
                                    >
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="app-logo fw-bold text-white-50">W</div>
                                            <i class="bi bi-list text-white font-18 ms-2"></i>
                                        </div>
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="bi bi-search text-white-50 font-10 me-1"></i>
                                            <div class="position-relative">
                                                <i class="bi bi-bell text-white-50 font-10 me-1"></i>
                                                <span class="badge-dot">2</span>
                                            </div>
                                            <i class="bi bi-moon text-white-50 font-10 me-1"></i>
                                            <div class="d-flex align-items-center gap-1 text-white-50 font-10 fw-medium">                                              
                                                Wagner Oliveira <i class="bi bi-chevron-down" style="font-size: 0.375rem !important;"></i>
                                            </div>
                                            <i class="bi bi-gear text-white-50 font-10"></i>
                                        </div>
                                    </div>
  
                                    <!-- Dashboard Title -->
                                    <div class="mb-3 text-start">
                                        <h5 class="fw-bold text-dark mb-0 font-16 d-flex align-items-center gap-2">
                                            <i class="bi bi-grid-fill text-primary"></i> Painel Gerenciador
                                        </h5>
                                        <p class="text-muted font-10 mb-0">Gerencie todos os módulos do seu site</p>
                                    </div>
  
                                    <!-- Dashboard Grid Modules -->
                                    <div class="dashboard-grid">
                                        <div class="module-card">
                                            <i class="bi bi-image text-primary font-16"></i>
                                            <span class="font-10">Sliders</span>
                                            <i class="bi bi-chevron-right font-8 text-muted ms-auto"></i>
                                        </div>
                                        <div class="module-card">
                                            <i class="bi bi-list-ul text-primary font-16"></i>
                                            <span class="font-10">Tópicos</span>
                                            <i class="bi bi-chevron-right font-8 text-muted ms-auto"></i>
                                        </div>
                                        <div class="module-card">
                                            <i class="bi bi-person-lines-fill text-primary font-16"></i>
                                            <span class="font-10">Serviços</span>
                                            <i class="bi bi-chevron-right font-8 text-muted ms-auto"></i>
                                        </div>
                                        <div class="module-card">
                                            <i class="bi bi-images text-primary font-16"></i>
                                            <span class="font-10">Galeria</span>
                                            <i class="bi bi-chevron-right font-8 text-muted ms-auto"></i>
                                        </div>
                                        <div class="module-card">
                                            <i class="bi bi-question-circle-fill text-primary font-16"></i>
                                            <span class="font-10">Sobre Nós</span>
                                            <i class="bi bi-chevron-right font-8 text-muted ms-auto"></i>
                                        </div>
                                        <div class="module-card">
                                            <i class="bi bi-display text-primary font-16"></i>
                                            <span class="font-10">Contato</span>
                                            <i class="bi bi-chevron-right font-8 text-muted ms-auto"></i>
                                        </div>
                                        <div class="module-card">
                                            <i class="bi bi-person-badge-fill text-primary font-16"></i>
                                            <span class="font-10">Lead Contato</span>
                                            <i class="bi bi-chevron-right font-8 text-muted ms-auto"></i>
                                        </div>
                                    </div>
  
                                    <!-- Config Section Title -->
                                    <div class="section-title-sm text-start mt-2 mb-1 text-muted font-10 fw-bold">
                                        <i class="bi bi-envelope-gear"></i> Configuração SMTP
                                    </div>
                                    <div class="module-card mb-2">
                                        <i class="bi bi-envelope text-primary font-16"></i>
                                        <span class="font-10">Configuração de e-mail</span>
                                        <i class="bi bi-chevron-right font-8 text-muted ms-auto"></i>
                                    </div>
  
                                    <div class="section-title-sm text-start mt-2 mb-1 text-muted font-10 fw-bold">
                                        <i class="bi bi-shield-lock"></i> Segurança e Controle de Acesso
                                    </div>
                                    <div class="row g-2">
                                        <div class="col-6">
                                            <div class="module-card">
                                                <i class="bi bi-clipboard-data text-primary font-16"></i>
                                                <span class="font-10">Auditoria</span>
                                                <i class="bi bi-chevron-right font-8 text-muted ms-auto"></i>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="module-card">
                                                <i class="bi bi-people-fill text-primary font-16"></i>
                                                <span class="font-10">Grupos de permissões</span>
                                                <i class="bi bi-chevron-right font-8 text-muted ms-auto"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
  
                            <!-- CARDS FLUTUANTES COM EFEITO DE HOVER/FLUTUAÇÃO (Skins Flutuantes da Imagem) -->
                            <div class="floating-badge badge-seo shadow-lg animate-float-1">
                                <div class="icon-wrap bg-primary-soft d-none d-lg-block">
                                    <i class="bi bi-rocket-takeoff-fill text-primary font-22"></i>
                                </div>
                                <div class="text-start">
                                    <strong class="d-block font-10 text-dark">SEO Google Otimizado</strong>
                                    <small class="text-muted font-10">Apareça no topo</small>
                                </div>
                            </div>
  
                            <div class="floating-badge badge-templates shadow-lg animate-float-2">
                                <div class="icon-wrap bg-primary-soft d-none d-lg-block">
                                    <i class="bi bi-bar-chart-line-fill text-primary font-22"></i>
                                </div>
                                <div class="text-start">
                                    <strong class="d-block font-10 text-dark">Templates Otimizados</strong>
                                    <small class="text-muted font-10">Layouts de alta conversão</small>
                                </div>
                            </div>
  
                            <div class="floating-badge badge-audit shadow-lg animate-float-3">
                                <div class="icon-wrap bg-primary-soft d-none d-lg-block">
                                    <i class="bi bi-shield-check text-primary font-22"></i>
                                </div>
                                <div class="text-start">
                                    <strong class="d-block font-10 text-dark">Auditoria Completa</strong>
                                    <small class="text-muted font-10">Segurança em tempo real</small>
                                </div>
                            </div>
  
                            <div class="floating-badge badge-permissions shadow-lg animate-float-4">
                                <div class="icon-wrap bg-primary-soft d-none d-lg-block">
                                    <i class="bi bi-people-fill text-primary font-22"></i>
                                </div>
                                <div class="text-start">
                                    <strong class="d-block font-10 text-dark">Grupos & Permissões</strong>
                                    <small class="text-muted font-10">Gestão de equipe</small>
                                </div>
                            </div>
                        </div>
                    </div>
                  @endforeach
              </div>
          </div>
      </section>
    @endif
    <!-- Banner-Section-end -->

    <!-- How it Works Section Start -->
    <section class="advance_feature_section white_text" id="how_sec" style="background: #0B0F19;">
        <div class="af_innner">

        </div>

        <!-- device image -->
        <div class="device">
            <img src="{{asset('build/client/images/themes/whi-web/device.png')}}" alt="image" height="250" loading="lazy">
        </div>

    </section>
    <!-- How it Works Section End -->


    @if ($topics->count() > 0)
      <!-- why us new section start -->
      <section class="why_new_section bg-white position-relative" id="why_sec">
          <!-- inner section start -->
          <div class="why_new_section_inner">
          <!-- container start -->
          <div class="container">
            <!-- row start -->
            <div class="row justify-content-center">

              <!-- section title -->
              <div class="section_title">
                  <span class="title_badge">Personalize do seu jeito</span>
                  <h2 class="trhee-step">A forma mais rápida de colocar <br><span>seu negócio no ar</span></h2>
              </div>

              <div class="dtat_box">
                <div class="col-lg-12">
                  <!-- why us new box left -->
                  <div class="why_new_left_data row g-3">

                    @foreach ($topics as $index => $topic)
                    {{-- {{dd($index)}} --}}
                      <!-- block 1 -->
                      <div class="col-12 col-lg-3">
                        <div class="why_data_block p-3 rounded-3">
                          <!-- icon -->
                          <div class="number text-white">
                          {{$index + 1}}                   
                          </div>
                          <!-- text -->
                          <div class="text col-12 mt-2">
                              <div class="font-semibold font-15 font-changa mb-2">{{$topic->title}}</div>
                              <p> {{$topic->description}} </p>
                          </div>
                        </div>
                      </div>
                    @endforeach
                  </div>
                </div>
              </div>

            </div>
            <!-- row end -->
          </div>
          <!-- container end -->
        </div>
        
      </section>
      <!-- why us new section end -->
    @endif


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Changa:wght@400;600;700;800&family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<section class="whiweb-showcase-section container-fluid mx-auto" aria-labelledby="whiweb-showcase-title">
    <div class="ww-glow"></div>
    <header class="position-relative text-center mb-4">
        <div class="ww-kicker"><span class="ww-live-dot"></span>Sistema WhiWeb 2026 • Live Interactive Demo</div>
        <h2 id="whiweb-showcase-title" class="ww-title">
            Gerenciamento Multiplataforma <span class="ww-gradient-text">Centralizado</span>
        </h2>
        <p class="ww-intro">
            Veja a interação simulada entre MacBook, iPhone e Tablet do
            ecossistema WhiWeb.
        </p>
    </header>

    <div class="ww-controls ww-glass d-flex align-items-center justify-content-between gap-2">
        <button type="button" id="btnToggleAnim" class="ww-control-btn primary">
            <i id="animIcon" class="bi bi-pause-fill"></i><span id="animStatusText">Pausar Animações</span>
        </button>
        <div class="d-flex align-items-center gap-2">
            <button type="button" id="btnTriggerToast" class="ww-control-btn">
                <i class="bi bi-bell-fill text-success"></i>Disparar Login
            </button>
            <button
                type="button"
                id="btnReset"
                class="ww-control-btn"
                title="Reiniciar fluxo"
                aria-label="Reiniciar fluxo"
            >
                <i class="bi bi-arrow-clockwise"></i>
            </button>
        </div>
    </div>

    <div class="ww-scene">
        <div class="ww-macbook">
            <div class="ww-laptop-bezel">
                <span class="ww-webcam"></span>
                <div class="ww-screen">
                    <div class="ww-cursor" aria-hidden="true">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                            <path
                                d="M3 3L10.07 19.97L12.58 12.58L19.97 10.07L3 3Z"
                                fill="#6366F1"
                                stroke="#fff"
                                stroke-width="2"
                                stroke-linejoin="round"
                            />
                        </svg>
                    </div>
                    <div class="ww-browserbar">
                        <div class="ww-dots"><i></i><i></i><i></i></div>
                        <div class="d-flex align-items-center gap-2 flex-grow-1 justify-content-center">
                            <div class="d-flex gap-2 text-secondary">
                                <i class="bi bi-chevron-left"></i><i class="bi bi-chevron-right"></i
                                ><i class="bi bi-sidebar-reverse"></i>
                            </div>
                            <div class="ww-url">
                                <i class="bi bi-lock-fill text-success"></i><span>whiweb.com.br</span
                                ><i class="bi bi-arrow-clockwise ms-auto text-secondary"></i>
                            </div>
                        </div>
                        <div class="ww-browser-icons">
                            <i class="bi bi-share"></i><i class="bi bi-plus-lg"></i><i class="bi bi-square-stack"></i>
                        </div>
                    </div>
                    <div class="ww-app">
                        <aside class="ww-sidebar">
                            <div class="ww-sidebar-bg">
                                <div class="ww-brand-row justify-content-center">
                                    <img src="{{asset('build/client/images/themes/whi-web/whi-black-horizontal.png')}}" alt="Whi web" height="40">
                                </div>
                                <div class="ww-nav-label">Listagem</div>
                                <a href="#" class="ww-nav-link active"
                                    ><span><i class="bi bi-house-door-fill me-2"></i>Home</span><span>3</span></a
                                >
                                <a href="#" class="ww-nav-link"
                                    ><span><i class="bi bi-info-circle me-2"></i>Sobre Nós</span><span>3</span></a
                                >
                                <a href="#" class="ww-nav-link"
                                    ><span><i class="bi bi-envelope me-2"></i>Contato</span><span>2</span></a
                                >
                                <div class="ww-nav-label">Segurança e Acesso</div>
                                <a href="#" class="ww-nav-link"
                                    ><span><i class="bi bi-shield-check me-2"></i>Controle</span><span>2</span></a
                                >
                            </div>
                        </aside>
                        <main class="ww-dashboard">
                            <div>
                                <div
                                    class="app-navbar d-flex align-items-center justify-content-between p-2 rounded-1 mb-3"
                                >
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="bi bi-list text-white font-18 ms-2"></i>
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="bi bi-search text-white-50 font-10 me-1"></i>
                                        <div class="position-relative">
                                            <i class="bi bi-bell text-white-50 font-10 me-1"></i>
                                            <span class="badge-dot" style="top: -4px">2</span>
                                        </div>
                                        <i class="bi bi-moon text-white-50 font-10 me-1"></i>
                                        <div class="d-flex align-items-center gap-1 text-white-50 font-10 fw-medium">
                                            Wagner Oliveira
                                            <i class="bi bi-chevron-down" style="font-size: 0.375rem !important"></i>
                                        </div>
                                        <i class="bi bi-gear text-white-50 font-10"></i>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <div>
                                        <div class="fw-bold text-dark">Módulos do Sistema</div>
                                        <small class="text-secondary">Gerencie o conteúdo da sua plataforma</small>
                                    </div>
                                    <span class="badge text-bg-primary">Visão geral</span>
                                </div>
                                <section class="mb-3">
                                    <h3 class="ww-section-title">
                                        <i class="bi bi-grid-fill text-primary me-1"></i>Conteúdo do Site
                                    </h3>
                                    <div class="ww-dashboard-grid">
                                        <div class="ww-dash-card ww-module-slider">
                                            <span class="ww-card-icon"><i class="bi bi-images"></i></span>
                                            <div>
                                                <h4 class="ww-card-title">Sliders</h4>
                                            </div>
                                            <i class="bi bi-chevron-right text-primary ms-auto"></i>
                                        </div>
                                        <div class="ww-dash-card">
                                            <span class="ww-card-icon"><i class="bi bi-list-ul"></i></span>
                                            <div>
                                                <h4 class="ww-card-title">Tópicos</h4>
                                            </div>
                                            <i class="bi bi-chevron-right text-secondary ms-auto"></i>
                                        </div>
                                        <div class="ww-dash-card">
                                            <span class="ww-card-icon"><i class="bi bi-person-lines-fill"></i></span>
                                            <div>
                                                <h4 class="ww-card-title">Serviços</h4>
                                            </div>
                                            <i class="bi bi-chevron-right text-secondary ms-auto"></i>
                                        </div>
                                        <div class="ww-dash-card">
                                            <span class="ww-card-icon"><i class="bi bi-grid-fill"></i></span>
                                            <div>
                                                <h4 class="ww-card-title">Galeria</h4>
                                            </div>
                                            <i class="bi bi-chevron-right text-secondary ms-auto"></i>
                                        </div>
                                        <div class="ww-dash-card">
                                            <span class="ww-card-icon"><i class="bi bi-question-circle-fill"></i></span>
                                            <div>
                                                <h4 class="ww-card-title">Sobre Nós</h4>
                                            </div>
                                            <i class="bi bi-chevron-right text-secondary ms-auto"></i>
                                        </div>
                                        <div class="ww-dash-card">
                                            <span class="ww-card-icon"><i class="bi bi-display"></i></span>
                                            <div>
                                                <h4 class="ww-card-title">Contato</h4>
                                            </div>
                                            <i class="bi bi-chevron-right text-secondary ms-auto"></i>
                                        </div>
                                    </div>
                                </section>
                                <section class="mb-3">
                                    <h3 class="ww-section-title">
                                        <i class="bi bi-shield-lock text-primary me-1"></i>Segurança e Controle de
                                        Acesso
                                    </h3>
                                    <div class="ww-dashboard-grid">
                                        <div class="ww-dash-card">
                                            <span class="ww-card-icon"><i class="bi bi-people-fill"></i></span>
                                            <div>
                                                <h4 class="ww-card-title">Usuários</h4>
                                            </div>
                                            <i class="bi bi-chevron-right text-secondary ms-auto"></i>
                                        </div>
                                    </div>
                                </section>
                                <section>
                                    <h3 class="ww-section-title">
                                        <i class="bi bi-palette-fill text-primary me-1"></i>Configuração do Tema
                                    </h3>
                                    <div class="ww-dashboard-grid">
                                        <div class="ww-dash-card ww-module-theme">
                                            <span class="ww-card-icon"><i class="bi bi-paint-bucket"></i></span>
                                            <div>
                                                <h4 class="ww-card-title">Configuração do Tema</h4>
                                            </div>
                                            <i class="bi bi-chevron-right text-primary ms-auto"></i>
                                        </div>
                                    </div>
                                </section>
                            </div>
                            <div id="macToast" class="ww-toast">
                                <span class="rounded-circle bg-white bg-opacity-25 px-2 py-1"
                                    ><i class="bi bi-check-lg"></i></span
                                ><span
                                    ><strong class="d-block">Sucesso</strong
                                    ><small>Login realizado com sucesso!</small></span
                                >
                            </div>
                        </main>
                    </div>
                </div>
            </div>
            <div class="ww-laptop-base">
                <span class="ww-hinge"></span><span class="ww-laptop-name">MacBook Air</span>
            </div>
        </div>

        <div class="ww-phone d-none d-lg-block">
            <div class="ww-device-frame">
                <div class="ww-device-screen">
                    <div class="ww-notch">
                        <span>12:16</span
                        ><span><i class="bi bi-wifi"></i> <i class="bi bi-battery-full text-success"></i></span>
                    </div>
                    <div class="ww-login-card">
                        <div class="d-flex align-items-center justify-content-center gap-2 mb-2">
                            <div class="justify-content-center">
                                <img src="{{asset('build/client/images/themes/whi-web/whi-black-horizontal.png')}}" alt="Whi web" height="40">
                            </div>
                        </div>
                        <strong class="d-block">Acessar conta</strong
                        ><small class="text-secondary font-8">Informe seus dados para continuar</small>
                        <div class="my-3">
                            <label class="ww-login-label">E-mail</label>
                            <div class="ww-login-field"><span class="ww-typing-email">seu@email.com</span></div>
                        </div>
                        <div class="mb-3">
                            <label class="ww-login-label">Senha</label>
                            <div class="ww-login-field d-flex justify-content-between">
                                <span class="ww-typing-pass">••••••••</span><i class="bi bi-eye"></i>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mb-3 text-secondary">
                            <span class="font-8">☑ Manter conectado</span>
                            <a href="#" class="text-primary text-decoration-none font-8">Esqueceu a senha?</a>
                        </div>
                        <button class="ww-login-button">Entrar <i class="bi bi-arrow-right"></i></button>
                        <div class="ww-success">
                            <i class="bi bi-check-circle-fill fs-3"></i><strong>Login Efetuado!</strong
                            ><small>Redirecionando ao painel...</small>
                        </div>
                        <div class="mt-3 text-secondary font-8">
                            <i class="bi bi-shield-lock-fill text-success"></i> Ambiente seguro
                        </div>
                    </div>
                    <div class="ww-phonebar">
                        <span>whiweb.com.br</span
                        ><span><i class="bi bi-book me-2"></i><i class="bi bi-square-stack"></i></span>
                    </div>
                    <span
                        class="d-block mx-auto mt-2 bg-secondary rounded-pill"
                        style="width: 4rem; height: 4px"
                    ></span>
                </div>
            </div>
        </div>

        <div class="ww-tablet d-none d-lg-block">
            <div class="ww-tablet-frame">
              <div class="ww-browserbar flex-column gap-0 p-0 rounded-3 overflow-hidden">
                <div class="ww-tablet-screen w-100 d-flex justify-content-between align-items-center p-2 gap-1" style="min-height: inherit;border-radius:12px 12px 0 0;">
                      <div class="ww-dots tablet gap-1"><i></i><i></i><i></i></div>
                        <div class="d-flex align-items-center gap-1 flex-grow-1 justify-content-center">
                            <div class="ww-url">
                                <i class="bi bi-lock-fill text-success"></i><span>whiweb.com.br</span
                                ><i class="bi bi-arrow-clockwise ms-auto text-secondary"></i>
                            </div>
                        </div>
                        <div class="ww-browser-icons tablet gap-1">
                            <i class="bi bi-share font-8 mx-1"></i><i class="bi bi-plus-lg"></i><i class="bi bi-square-stack"></i>
                        </div>
                    </div> 
                     
                    <div class="ww-tablet-content w-100" style="border-radius: 0px 0px 12px 12px">
                        <div
                            class="app-navbar d-flex align-items-center justify-content-between py-1 px-2 rounded-1 mb-2"
                        >
                            <div class="ww-tabletbar p-0 d-flex align-items-center gap-2">
                              <img src="{{asset('build/client/images/themes/whi-web/favicon-whi.png')}}" alt="Whi web" height="20">
                                <i class="bi bi-list text-white font-18 ms-2"></i>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-search text-white-50 font-10 me-1"></i>
                                <div class="position-relative">
                                    <i class="bi bi-bell text-white-50 font-10 me-1"></i>
                                    <span class="badge-dot" style="top:3px">2</span>
                                </div>
                                <i class="bi bi-moon text-white-50 font-10 me-1"></i>
                                <i class="bi bi-gear text-white-50 font-10"></i>
                            </div>
                        </div>
                        <div class="mb-2">
                            <div class="d-flex flex-column">
                                <strong class="col-12 font-10">Módulos do Sistema</strong>
                                <small class="col-12 text-secondary font-8">Visão otimizada em Tablet</small>
                            </div>
                        </div>
                        <small class="d-block text-dark fw-bold mb-1 font-8"><i class="bi bi-grid-fill text-primary me-1"></i>Conteúdo do Site</small>

                        <div class="ww-mini-grid mb-2">
                            <div class="ww-mini-card"><i class="bi bi-images text-primary"></i>Sliders</div>
                            <div class="ww-mini-card"><i class="bi bi-list-ul text-primary"></i>Tópicos</div>
                            <div class="ww-mini-card"><i class="bi bi-person-lines-fill text-primary"></i>Serviços</div>
                            <div class="ww-mini-card"><i class="bi bi-grid-fill text-primary"></i>Galeria</div>
                            <div class="ww-mini-card">
                                <i class="bi bi-question-circle-fill text-primary"></i>Sobre Nós
                            </div>
                            <div class="ww-mini-card"><i class="bi bi-display text-primary"></i>Contato</div>
                        </div>
                        <small class="d-block text-dark fw-bold mb-1 font-8"><i class="bi bi-shield-lock text-primary me-1"></i>Segurança e controle de acesso</small>
                        <div class="ww-mini-grid mb-2">
                            <div class="ww-mini-card"><i class="bi bi-clipboard-data text-primary"></i>Auditoria</div>
                            <div class="ww-mini-card"><i class="bi bi-people-fill text-primary"></i>Permissões</div>
                        </div>
                        <div class="ww-mini-card bg-primary-subtle border-primary-subtle text-primary-emphasis">
                            <i class="bi bi-paint-bucket text-primary"></i>Configuração do Tema
                        </div>
                    </div>
                    <span
                        class="d-block mx-auto mt-0 bg-secondary rounded-pill"
                        style="width: 5rem; height: 4px"
                    ></span>
                </div>
            </div>
        </div>
    </div>

    <footer class="ww-footer ww-glass">
        <div class="row g-4 text-center text-md-start">
            <div class="col-12 col-md-4 d-flex align-items-start gap-3">
                <span class="ww-feature-icon text-primary bg-primary bg-opacity-10"><i class="bi bi-laptop"></i></span>
                <div>
                    <h3 class="h6 fw-bold text-white">Totalmente Responsivo</h3>
                    <p class="small text-secondary mb-0">
                        Layout adapta-se a qualquer resolução de tela mantendo a mesma facilidade de uso.
                    </p>
                </div>
            </div>
            <div class="col-12 col-md-4 d-flex align-items-start gap-3">
                <span class="ww-feature-icon text-info bg-info bg-opacity-10"
                    ><i class="bi bi-lightning-charge-fill"></i
                ></span>
                <div>
                    <h3 class="h6 fw-bold text-white">Animações de Navegação</h3>
                    <p class="small text-secondary mb-0">
                        Simulação interativa de cliques, digitação e avisos com transição suave.
                    </p>
                </div>
            </div>
            <div class="col-12 col-md-4 d-flex align-items-start gap-3">
                <span class="ww-feature-icon text-success bg-success bg-opacity-10"
                    ><i class="bi bi-shield-check"></i
                ></span>
                <div>
                    <h3 class="h6 fw-bold text-white">Painel WhiWeb 2026</h3>
                    <p class="small text-secondary mb-0">
                        Pronto para ser integrado à sua landing page ou documentação de produto.
                    </p>
                </div>
            </div>
        </div>
    </footer>
</section>

<script>
(() => {
  const section = document.querySelector('.whiweb-showcase-section');
  if (!section) return;

  const toggleButton = section.querySelector('#btnToggleAnim');
  const icon = section.querySelector('#animIcon');
  const status = section.querySelector('#animStatusText');
  const toast = section.querySelector('#macToast');
  let isAnimated = true;

  toggleButton.addEventListener('click', () => {
    isAnimated = !isAnimated;
    section.classList.toggle('is-paused', !isAnimated);
    icon.className = isAnimated ? 'bi bi-pause-fill' : 'bi bi-play-fill';
    status.textContent = isAnimated ? 'Pausar Animações' : 'Retomar Animações';
  });

  section.querySelector('#btnTriggerToast').addEventListener('click', () => {
    toast.style.animation = 'none';
    void toast.offsetHeight;
    toast.style.animation = '';
  });

  section.querySelector('#btnReset').addEventListener('click', () => {
    section.classList.remove('is-paused');
    isAnimated = true;
    icon.className = 'bi bi-pause-fill';
    status.textContent = 'Pausar Animações';
    section.querySelectorAll('.ww-toast,.ww-cursor,.ww-module-theme,.ww-module-slider,.ww-success,.ww-login-button').forEach((element) => {
      element.style.animation = 'none';
      void element.offsetHeight;
      element.style.animation = '';
    });
  });
})();
</script>



    @if (isset($advantages) && $advantages->count())
      <!-- Service Section Start -->
      <section class="row_am service_section position-relative overflow-hidden" id="feature_sec">
          <!-- background blure shapes -->       
          <div class="blure_shape bg-secondary-color bs_2"> </div>

          <div class="container position-relative">
              @php
                  $logoPath = storage_path('app/public/' . $tenantTheme->path_image_logo_header);
                  $dimensions = file_exists($logoPath) ? @getimagesize($logoPath) : null;
              @endphp
              <!-- section title -->
              <div class="section_title">
                  <span class="title_badge text-white">VANTAGENS</span>
                  <h2 class="trhee-step text-white">O que você ganha com<br> a <span>WHI Web</span></h2>
              </div>     

              @foreach($advantages as $advantage)
                  @php
                      // Verifica se a iteração é par ou ímpar para alternar os lados do layout
                      $isEven = $loop->iteration % 2 === 0;
                  @endphp

                  <div class="row service_blocks {{ !$isEven ? 'flex-row-reverse' : '' }} {{ $loop->last ? 'no_bottom_padding' : '' }}">
                      
                      <!-- Coluna de Texto -->
                      <div class="col-md-6">
                          <div class="service_text {{ !$isEven ? 'right_side' : '' }}">

                              @if(!empty($advantage->tag))
                                  <span class="title_badge">{{ $advantage->tag }}</span>
                              @endif

                              <h3 class="text-white">{{ $advantage->title }}</h3>
                              <p class="text-white">{{ $advantage->description }}</p>

                              @if(!empty($advantage->text))
                                @php
                                    $content = $advantage->text;
                                    // Verifica se o texto vindo do CMS contém tags <ul> ou <li>
                                    $hasListTags = preg_match('/<\/?(ul|li)[^>]*>/i', $content);
                                @endphp

                                @if($hasListTags)
                                    {{-- Caso o CMS envie HTML com <ul>/<li> (Editor WYSIWYG) --}}
                                    @php
                                        // Adiciona a classe do seu layout à tag <ul>
                                        $formattedHtml = preg_replace('/<ul([^>]*)>/i', '<ul$1 class="design_block py-3 px-0">', $content);
                                        
                                        // Adiciona os ícones e as classes Bootstrap às tags <li>
                                        $formattedHtml = preg_replace(
                                            '/<li([^>]*)>(.*?)<\/li>/is', 
                                            '<li$1 class="d-flex gap-2 justify-content-start align-items-center"><i class="bi bi-check-circle"></i> $2</li>', 
                                            $formattedHtml
                                        );
                                    @endphp

                                    {!! $formattedHtml !!}

                                    @else
                                        {{-- Caso seja texto simples digitado linha por linha --}}
                                        @php
                                            $items = array_filter(array_map('trim', explode("\n", $content)));
                                        @endphp

                                        @if(!empty($items))
                                            <ul class="design_block py-3 px-0">
                                                @foreach($items as $item)
                                                    <li class="d-flex gap-2 justify-content-start align-items-center">
                                                        <i class="bi bi-check-circle"></i>
                                                        {{ $item }}
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    @endif
                                @endif

                              <div class="btn_block">
                                  <a href="{{ $advantage->button_url ?? '#plans' }}" class="bg-button-two color-button-two px-3 py-2 rounded-3">
                                      <span>
                                          {{ $advantage->button_text ?? 'Começar agora' }}
                                          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right size-5">
                                              <path d="M5 12h14"></path>
                                              <path d="m12 5 7 7-7 7"></path>
                                          </svg>
                                      </span> 
                                  </a>
                              </div>

                          </div>
                      </div>

                      <!-- Coluna de Imagem -->
                      <div class="col-md-6">
                          <div class="inner_block {{ !$isEven ? 'dark_bg rotate_right' : '' }}">
                              <div class="img">
                                  <img src="{{ asset('storage/' . $advantage->path_image) }}" 
                                      alt="{{ $advantage->title }}" 
                                      loading="lazy" 
                                      width="{{ $dimensions[0] ?? 200 }}" 
                                      height="{{ $dimensions[1] ?? 60 }}" 
                                      style="max-width:100%;height:auto;">
                              </div>
                          </div>
                      </div>

                  </div>
              @endforeach
          </div>

          <div class="blure_shape bg-secondary-color bs_1"> </div> 
      </section>
      <!-- Service Section End -->
    @endif

    <section id="templates" class="tpl-modal-sec">
      <div class="container">
        <!-- Div de topo (Sem tag header para não colidir) -->
        <div class="tpl-header-block">
          <div class="tpl-header-left col-12 col-lg-8">
            <div class="tpl-badge">
              <i class="bi bi-intersect"></i> Modelos Prontos
            </div>
            <h2>Modelos prontos pensados para o seu segmento. <br><span>Adaptados com a cara do seu negócio. </span></h2>
          </div>

          <div class="tpl-header-right col-12 col-lg-4">
            <p>Escolha a estrutura ideal para sua empresa ou deixe que nossa equipe recomende o modelo perfeito. Navegue pelos cards para ver os detalhes de cada um.</p>
            <a href="{{ route('templates') }}">
            <div class="tpl-scroll-hint">
                Ver todos os templates<i class="bi bi-arrow-right"></i>
              </div>
            </a>
          </div>
        </div>

        <!-- Trilho de Rolagem -->
        <div class="tpl-scroll-track">

          <!-- Item 1 -->
          @foreach($templateThemes as $templateTheme)
            @php
                $preview = $templateTheme['preview'] ?? null;

                if (is_string($preview)) {
                    $previews = json_decode($preview, true) ?? [];
                } elseif (is_array($preview)) {
                    $previews = $preview;
                } else {
                    $previews = [];
                }

                $previewImage = $previews[0] ?? null;
                $countPreviews = count($previews);
            @endphp
            <article class="tpl-card">
              <div class="tpl-card-topbar">
                <div class="tpl-dots"><span></span><span></span><span></span></div>
                <span class="tpl-tag">                  
                  {{ match ($templateTheme->layout_type) {
                      'onepage' => 'Página Única',
                      'multipage' => 'Múltiplas Páginas',
                      default => $templateThemeInner->layout_type,
                  } }}
                </span>
              </div>
              <div class="tpl-preview">
                <img src="{{ asset('storage') .'/'. $previewImage }}" alt="{{ $templateTheme->name }}" loading="lazy">
                <div class="tpl-overlay">
                  <a href="{{ route('template', ['slug' => $templateTheme->slug, 'templateVariation' => $templateTheme->template_variation]) }}" class="tpl-btn-preview bg-secondary"><i data-lucide="eye" style="width: 14px; height: 14px;"></i> Ver Detalhe</a>
                </div>
              </div>
              <div class="tpl-card-body">
                <div>
                    <span class="tpl-category">{{ is_object($templateTheme) ? $templateTheme->title : $templateTheme['title'] }}</span>
                    <div class="d-flex align-items-center gap-2 text-secondary" style="font-size: 0.75rem;">
                        @if ($countPreviews )                          
                          <span class="d-flex align-items-center gap-1">
                              <i data-lucide="layers" style="width: 14px; height: 14px;"></i>
                              {{ $countPreviews }} Páginas
                          </span>
                        @endif
                        @if ($templateTheme->technology <> null)                          
                          <span class="d-flex align-items-center gap-1 d-none">
                              <i data-lucide="code-2" style="width: 14px; height: 14px;"></i>
                              {{ strtoupper($templateTheme->technology ?? '') }}
                          </span>
                        @endif
                    </div>
                </div>
                <div class="tpl-arrow"><i class="bi bi-arrow-up-right"></i></div>
              </div>
            </article>
          @endforeach

        </div>

        <!-- Banner Inferior -->
        <div class="tpl-cta">
          <div class="tpl-cta-text">
            <h4>Sua empresa precisa de um site sob medida do zero?</h4>
            <p>Conheça os serviços de desenvolvimento exclusivo da Agência WHI e crie um projeto único para o seu negócio.</p>
          </div>
          @php
              $phone = preg_replace('/\D/', '', $contact->whatsapp);
              $mensagem = "Olá! Encontrei seu site e gostaria de conhecer mais sobre as condições para projetos exclusivos.";
          @endphp
          <a href="https://wa.me/55{{ $phone }}?text={{ $mensagem }}" target="_blank" rel="noopener noreferrer" class="tpl-cta-btn">Solicitar Projeto Exclusivo</a>
        </div>

      </div>
    </section>

    @if (!empty($videos) && $videos->count() > 0)
      <section class="video-section">
        <div class="container">
          <div class="row video-card-container g-0">
            
            <!-- Lista Lateral (Esquerda) -->
            <div class="col-lg-5 p-2 p-lg-4 video-sidebar">
              <div class="video-sidebar-header">
                <h2 class="video-sidebar-title">Playlist de Vídeos</h2>
                <span class="video-count-badge">{{ $videos->count() }} vídeos</span>
              </div>

              <div class="video-list">
                @foreach($videos as $video)
                  <div class="video-item" data-video="{{ $video->link }}">
                    <div class="video-thumb-wrapper">
                      <!-- Thumbnail dinâmica gerada via JS -->
                      <img class="video-thumb-img" src="" alt="Thumbnail" loading="lazy">
                      <div class="play-icon-overlay">
                        <svg viewBox="0 0 24 24">
                          <path d="M8 5v14l11-7z"/>
                        </svg>
                      </div>
                    </div>
                    <h3 class="video-title">
                      {{ $video->title ?? 'Vídeo ' . ($loop->iteration) }}
                    </h3>
                  </div>
                @endforeach
              </div>
            </div>

            <!-- Player de Vídeo (Direita) -->
            <div class="col-lg-7 video-player-wrapper">
              <iframe id="videoPlayer" class="video-player-iframe"
                      src=""
                      title="Player de Vídeo"
                      allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                      allowfullscreen></iframe>
            </div>

          </div>
        </div>
      </section>
    @endif
    
    @if ((isset($sections['testimonial']) && $sections <> null) ||
      (!empty($depoiments) && count($depoiments) > 0))
      <section class="testimonials-section" id="review_sec">
        <div class="container position-relative z-1">
          
          <!-- Cabeçalho -->
          <div class="row justify-content-center text-center mb-5">
            <div class="col-lg-8">
              <span class="testimonials-badge">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                {{ $sections['testimonial']->tag }}
              </span>
              <h2 class="testimonials-title">{{ $sections['testimonial']->title }}</h2>
            </div>
          </div>

          <!-- Estatísticas de Impacto (Novidade Visual) -->
          @if (isset($benefitTopics) && $benefitTopics->count())
            <div class="row metrics-banner align-items-center text-center mb-5">
              @foreach($benefitTopics as $parametro)            
                <div class="col-6 col-md-3 mb-3 mb-md-0">
                  <div class="metric-number">{{$parametro->number}}</div>
                  <p class="metric-label">{{$parametro->title}}</p>
                </div>
              @endforeach
            </div>
          @endif

          <!-- Slider de Depoimentos (Swiper) -->
          @if (isset($depoiments) && $depoiments->count())
            <div class="swiper testimonialSwiper mb-5">
              <div class="swiper-wrapper py-3">

                <!-- Card 1 -->
                @foreach ($depoiments as $depoiment)
                  <div class="swiper-slide">
                    <div class="testimonial-card">
                      <svg class="testimonial-quote-icon" viewBox="0 0 24 24"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/></svg>
                      <div class="rating-stars">★★★★★</div>
                      <div class="testimonial-text">
                          {!!$depoiment->text!!}
                      </div>
                      <div class="author-wrapper">
                        @if ($depoiment->path_image <> null) 
                          <img src="{{asset('storage/' . $depoiment->path_image)}}" alt="{{$depoiment->name}}" class="author-avatar" loading="lazy">
                        @endif
                        <div>
                          <h3 class="author-name">{{$depoiment->name}}</h3>
                          <p class="author-role">{{$depoiment->function}}</p>
                        </div>
                      </div>
                    </div>
                  </div>
                @endforeach

              </div>
            </div>
          @endif

          <!-- Chamada para Ação CTA -->
          <div class="btn_block text-center">
              <a href="#plans" class="bg-button-two color-button-two px-3 py-2 rounded-3 ">
                <span>
                  Começar agora
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right size-5"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg>
                </span>
              </a>
          </div>

        </div>
      </section>
    @endif

    @if (isset($contractedPlans) && $contractedPlans->count())
      <section class="pricing-section" id="plans">
        <div class="container">
          
          <!-- Cabeçalho -->
          <div class="row justify-content-center text-center">
            <div class="col-lg-8">
              <span class="pricing-badge">Planos e Preços</span>
              <h2 class="pricing-title">Escolha o plano ideal para escalar o seu negócio</h2>
              <p class="pricing-subtitle mb-5">Um serviço completo, com preço transparente, sem taxas escondidas e condições claras de contratação.</p>
              
              <!-- Toggle Mensal / Anual (Desabilitado) -->
              <div class="pricing-toggle-wrapper flex-wrap opacity-75 opacity-100-hover d-none">
                <span class="toggle-label text-muted" id="label-monthly" style="cursor: not-allowed;">Cobrança Mensal</span>
                <div class="form-check form-switch p-0 m-0">
                  <input 
                    class="form-check-input pricing-switch" 
                    type="checkbox" 
                    id="pricingToggle"
                    aria-labelledby="label-monthly label-yearly"
                    checked 
                    disabled
                  >
                </div>
                <span class="toggle-label active" id="label-yearly" style="cursor: default;">
                  Cobrança Anual
                  <span class="discount-badge d-none">-20% OFF</span>
                </span>
              </div>
            </div>
          </div>

          <!-- Cards de Planos -->
          <div class="row g-4 align-items-stretch justify-content-center">

            @foreach($contractedPlans as $plan)
                @php
                    $phone = preg_replace('/\D/', '', $contact->whatsapp);
                    
                    // 1. Converte entidades HTML (&aacute;, &eacute;, etc.) de volta para caracteres acentuados
                    $textDecodificado = html_entity_decode($plan->text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
                    
                    // 2. Extrai os itens <li> e formata como tópicos com hífem
                    $featuresLimpo = str_replace(["\r", "\n"], '', $textDecodificado);
                    $featuresLimpo = str_replace('<li>', "\n- ", str_replace('</li>', '', $featuresLimpo));
                    $featuresLimpo = strip_tags($featuresLimpo); // Remove a tag <ul> restante

                    // 3. Converte também eventuais acentos no nome do plano
                    $nomePlano = html_entity_decode($plan->name, ENT_QUOTES | ENT_HTML5, 'UTF-8');

                    // 4. Monta a mensagem final sem caracteres estranhos
                    $textoMensagem = "*WHI WEB | Suporte ao Cliente*". "\n\n"
                                  ."Olá! Tenho interesse no plano *" . $nomePlano . "* (R$ " . number_format($plan->price, 2, ',', '.') . "/mês).\n\n"
                                  . "*Recursos incluídos:*" . $featuresLimpo . "\n\n"
                                  . "Gostaria de obter mais informações sobre como assinar.";
                                  
                    $mensagemUrl = urlencode($textoMensagem);
                    $precoMensal = number_format((float) $plan->monthly_price, 2, ',', '.');
                    $precoAnual = number_format((float) $plan->price, 2, ',', '.');
                @endphp

                <div class="col-lg-4 col-md-6">
                  <div class="plan-card px-4 {{ $plan->popular == 1 ? 'popular' : '' }}">
                    @if ($plan->popular == 1)                  
                      <span class="popular-badge">Mais Popular</span>
                    @endif
                    
                    <div>
                      <h3 class="plan-name">{{ $plan->name }}</h3>
                      <div class="plan-description">{{ $plan->description }}</div>
                      
                      <div class="plan-price-wrapper">
                        <span class="currency">R$</span>
                        <span class="amount" data-monthly="{{ $precoMensal }}" data-yearly="{{ $precoAnual }}">{{ $precoAnual }}</span>
                        <span class="period">/mês</span>
                      </div>

                      <div class="plan-features">
                        {!! $plan->text !!}
                      </div>
                    </div>

                    <a href="https://wa.me/55{{ $phone }}?text={{ $mensagemUrl }}" 
                      target="_blank" 
                      rel="noopener noreferrer" 
                      class="btn-plan {{ $plan->popular == 1 ? 'btn-plan-primary' : 'btn-plan-outline' }}">
                      Assinar {{ $plan->name }}
                    </a>
                  </div>
                </div>
            @endforeach

          </div>
        </div>
      </section>
    @endif

    @if (isset($sessaoFaq) && $sessaoFaq <> null || isset($faqs) && $faqs->count())
      <section class="faq-section" id="faq">
        <div class="container">
          
          <div class="row g-5">
            
            @if (isset($sessaoFaq) && $sessaoFaq <> null)
              @php $isFull = !(isset($faqs) && $faqs->count()); @endphp

              <div class="{{ $isFull ? 'col-lg-12 text-center mx-auto' : 'col-lg-4' }}">
                <span class="faq-badge">{{$sessaoFaq->tag}}</span>
                <h2 class="faq-title">{{$sessaoFaq->title}}</h2>
                <div class="faq-subtitle mb-4">{!!$sessaoFaq->description!!}</div>

                <div class="support-card {{ $isFull ? 'mx-auto' : 'd-none d-lg-block' }}" style="{{ $isFull ? 'max-width: 450px;' : '' }}">
                  <div class="support-icon {{ $isFull ? 'm-auto mb-2' : 'm-0 mb-2' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                  </div>
                  <h3 class="support-title">{{$sessaoFaq->title_box}}</h3>
                  <div class="support-text">{{$sessaoFaq->description_box}}</div>
                  <a href="{{$sessaoFaq->link}}" target="_blank" class="btn-faq-cta w-100 justify-content-center">
                    {{$sessaoFaq->btn_title}}
                  </a>
                </div>
              </div>
            @endif

            @if (isset($faqs) && $faqs->count())
              <div class="{{ (isset($sessaoFaq) && $sessaoFaq <> null) ? 'col-lg-8' : 'col-lg-12' }}">
                <div class="faq-accordion">

                  @foreach($faqs as $faq)                
                    <div class="faq-card">
                      <button class="faq-header">
                        <span>{{$faq->question}}</span>
                        <span class="faq-toggle-icon">
                          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
                        </span>
                      </button>
                      <div class="faq-body">
                        {!! $faq->answer !!}
                      </div>
                    </div>
                  @endforeach

                </div>

                <div class="text-center mt-5">
                  <a href="#plans" class="btn-faq-cta">
                    Começar agora
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg>
                  </a>
                </div>

              </div>
            @endif
          </div>
        </div>
      </section>
    @endif

@endsection
