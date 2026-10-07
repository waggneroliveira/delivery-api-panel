@extends($theme->core('client'))

@section('content')
    <!-- Banner-Section-Start -->
    @if (isset($slides) && $slides->count())
      <section class="banner_section" id="home_sec">
          @foreach ($slides as $slide)
              <!-- hero bg -->
              <div id="hero" class="hero_bg">
                  <img src="{{ asset('storage/' . $slide->path_image) }}" alt="image">
              </div>

              <!-- container start -->
              <div class="container">
                  <!-- row start -->
                  <div class="row">
                  <div class="col-lg-7 col-md-12">
                      <!-- banner text -->
                      <div class="banner_text">
                          <span class="hero-badge mb-3 d-inline-block secondary-color">
                              <i class="bi bi-rocket-takeoff me-1"></i> Lançamento 2026
                          </span>
                          <!-- typed text -->
                          <div class="type-wrap">
                              <!-- add static words/sentences here (i.e. text that you don't want to be removed)-->
                              <span id="typed" style="white-space:pre;" class="typed secondary-color">
                              </span>
                          </div>
                          <!-- h1 -->
                          <h1 class="hero-title font-changa font-40 font-bold text-white"> {{$slide->title}} <span class="secondary-color">{{$slide->subtitle}}</span></h1>
                          <!-- p -->
                          <div class="description text-white">
                              {!! $slide->description !!}
                          </div>
                      </div>

                      <div class="mt-3 d-flex justify-content-center justify-content-lg-start flex-wrap gap-3">
                          @if ($slide->link <> null)                                    
                              <a href="{{$slide->link}}" class="rounded-1 d-flex align-items-center btn-one py-2 px-3 px-lg-5 btn-hero font-changa bg-button-one color-button-one font-15 font-medium text-decoration-none">
                                  {{$slide->btn_title}}
                                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right size-5"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg>  
                              </a>
                          @endif

                          <a href="#plans" class="btn d-flex align-items-center btn-outline-light px-lg-5 px-3 py-lg-3 py-1 font-15 font-medium">
                            Conhecer Planos
                          </a>
                      </div>

                      <div class="hero-stats">
                          <div class="hero-stats-item">
                              <div class="number text-white-50">Completo</div>
                              <div class="label">Site + hospedagem + suporte</div>
                          </div>

                          <div class="hero-stats-item">
                              <div class="number text-white-50">SEO</div>
                              <div class="label">Estrutura otimizada para o Google</div>
                          </div>

                          <div class="hero-stats-item">
                              <div class="number text-white-50">Fácil</div>
                              <div class="label">Gestão simplificada</div>
                          </div>
                      </div>
                  </div>

                  <!-- banner image start -->
                  <div class="col-lg-5 col-md-12 mt-4 mt-lg-0">
                      <div class="hero_img">
                        <img src="{{ asset('storage/' . $slide->path_image_mobile) }}" alt="image">
                      </div>
                  </div>
                  <!-- banner image end -->
                  <!-- row end -->
              </div>
              <!-- container end -->
          @endforeach
      </section>
    @endif
    <!-- Banner-Section-end -->
    @if ($topics->count() > 0)
      <!-- How it Works Section Start -->
      <section class="advance_feature_section white_text" id="how_sec">
          <div class="af_innner">

              <!-- background blure shapes -->
              <div class="blure_shape bg-secondary-color bs_1"> </div>
              <div class="blure_shape bg-secondary-color bs_2"> </div>

              <!-- container -->
              <div class="container">
                  <!-- listing -->
                  <div class="af_listing">
                      <!-- row -->
                      <div class="row">
                          <!-- collom -->
                          <div class="col-md-12">
                              <!-- inner section -->
                              <div class="row listing_inner align-items-center">
                                  <!-- blok -->
                                  @foreach ($topics as $topic)
                                      <div class="af_block col-lg-3 col-md-6 col-sm-6 p-1">
                                          <div class="text d-flex justify-content-center gap-3 align-items-start flex-column" style="min-height: 267px;">
                                              <div class="d-flex justify-content-between align-items-start flex-column mb-2">
                                                  
                                                  <a @if($topic->link) href="{{ $topic->link }}" target="_blank" rel="noopener noreferrer" @endif class="topic-item d-block">
                                                      @if ($topic->path_image)
                                                          <div class="bg-icon bg-secondary-color">
                                                              <img src="{{ asset('storage/' . $topic->path_image) }}" height="30" alt="{{ $topic->title }}" class="img-fluid d-block m-auto" loading="lazy">
                                                          </div>
                                                      @endif
                                                  </a>

                                                  <div class="h5 mt-2">{{ $topic->title }}</div>
                                              </div>
                                              <p>{{ $topic->description }}</p>
                                          </div>
                                      </div>
                                  @endforeach
                              </div>

                          </div>
                      </div>
                      <!-- row -->
                  </div>
                  <!-- listing -->

              </div>            
          </div>

          <!-- device image -->
          <div class="device">
              <img src="{{asset('build/client/images/themes/whi-web/device.png')}}" alt="image" height="250" loading="lazy">
          </div>

      </section>
      <!-- How it Works Section End -->
    @endif
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
              <div class="col-lg-6 col-md-12">
                <!-- why us new box left -->
                <div class="why_new_left_data">

                  <!-- block 1 -->
                  <div class="why_data_block">
                    <!-- icon -->
                    <div class="number text-white">
                    01                    
                    </div>
                    <!-- text -->
                    <div class="text col-12 col-md-10">
                        <div class="font-semibold font-15 font-changa">Definição do modelo do seu site</div>
                        <p>Nós recomendamos o modelo perfeito para o seu segmento ou você escolhe o seu favorito em nosso catálogo de templates.</p>
                    </div>
                  </div>

                  <!-- block 2 -->
                  <div class="why_data_block">
                    <!-- icon -->
                    <div class="number text-white">
                    02                    
                    </div>
                    <!-- text -->
                    <div class="text col-12 col-md-10">
                      <div class="font-semibold font-15 font-changa">Personalização com a sua identidade visual</div>
                      <p>Nossa equipe configura suas cores, logomarca, textos e informações para que o site reflita exatamente a identidade da sua empresa.</p>
                    </div>
                  </div>

                  <!-- block 3 -->
                  <div class="why_data_block">
                    <!-- number -->
                    <div class="number text-white">
                      03
                    </div>
                    <!-- text -->
                    <div class="text col-12 col-md-10">
                      <div class="font-semibold font-15 font-changa">Você aprova e nós publicamos!</div>
                      <p>Você valida o resultado e nós cuidamos de toda a parte técnica: publicação, hospedagem, certificado de segurança e presença no Google</p>
                    </div>
                  </div>

                  <!-- block 4 -->
                  <div class="why_data_block">
                    <!-- number -->
                    <div class="number text-white">
                      04
                    </div>
                    <!-- text -->
                    <div class="text col-12 col-md-10">
                      <div class="font-semibold font-15 font-changa">Autonomia total no painel</div>
                      <p>Você recebe seu login e tem total liberdade para alterar fotos, textos, serviços ou anúncios em tempo real, sempre que precisar.</p>
                    </div>
                  </div>

                </div>
              </div>

              <div class="col-lg-6 col-md-12 position-relative">
                <img src="{{asset('build/client/images/themes/whi-web/tablet.png')}}" class="position-absolute tablet" loading="lazy" alt="image" style="height: 250px; bottom: 15px; right: 11px;z-index: 1;">
                <img src="{{asset('build/client/images/themes/whi-web/phone-login.png')}}" class="position-absolute phone-img" loading="lazy" alt="image" style="height: 220px; bottom: 15px; left: 0px; z-index: 1;">
                <!-- why us new image -->
                <div class="why_us_new_img position-relative">
                  <img src="{{asset('build/client/images/themes/whi-web/gif-paine-one.gif')}}" loading="lazy" alt="image">
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
