@extends($theme->core('client'))
@section('content')
    @if(isset($slides) && count($slides) > 0)
        <section class="hero">
            <div class="swiper main-swiper">
                <div class="swiper-wrapper">
                    @foreach ($slides as $slide)
                        <div class="swiper-slide">
                            <div class="hero-slide">
                                <!-- Imagem full -->
                                <div class="hero-bg">
                                    <picture>
                                        <source srcset="{{ asset('storage/' . $slide->path_image_mobile) }}" media="(max-width: 530px)">
                                        <img src="{{ asset('storage/' . $slide->path_image) }}" alt="Distribuição PET" title="Distribuição PET">
                                    </picture>
                                </div>

                                <!-- Overlay -->
                                <div class="overflow"></div>

                                <!-- Conteúdo -->
                                <div class="hero-content mt-5 mt-lg-0">
                                    <div class="container">
                                        <div class="row justify-content-between vh">
                                            <div class="col-lg-5 mt-150">
                                                <span class="font-changa font-15 font-semibold text-uppercase color-green">Encontre o imóvel perfeito</span>
                                                <h1 class="hero-title font-changa font-60 font-bold mb-1 mt-3">
                                                    {{ $slide->title }}
                                                </h1>

                                                <h2 class="hero-subtitle font-changa font-40 font-bold">
                                                    começa aqui!
                                                </h1>

                                                <span class="description font-changa font-15 font-regular">
                                                    {!! $slide->description !!}
                                                </span>


                                                <div class="hero-actions d-flex">
                                                    @if ($slide->link != null)                                    
                                                        <a href="{{ $slide->link }}" target="_blank" rel="noopener noreferrer" class="btn-one rounded-3 px-4 btn-hero btn font-changa bg-yellow color-green font-15 font-medium text-decoration-none">
                                                            Conheça
                                                            <svg class="ms-2" width="9" height="13" viewBox="0 0 9 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M1.78794 12.474L8.02494 6.237L1.78794 -1.90735e-06L0.02079 1.76715L4.46985 6.237L0 10.7068L1.78794 12.474Z" fill="var(--green-color)"/>
                                                            </svg>
                                                        </a>
                                                    @endif
                                                    
                                                    <a href="" rel="noopener noreferrer" class="btn-download-ficha btn-two rounded-3 px-4 btn-hero btn font-changa bg-yellow color-green font-15 font-medium text-decoration-none">
                                                        Fale com um especialista
                                                        <svg class="ms-2" width="9" height="13" viewBox="0 0 9 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M1.78794 12.474L8.02494 6.237L1.78794 -1.90735e-06L0.02079 1.76715L4.46985 6.237L0 10.7068L1.78794 12.474Z" fill="var(--green-color)"/>
                                                        </svg>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-lg-5 d-flex justify-content-end align-items-center mt-150">
                                                <div class="card border-0 rounded-4 overflow-hidden position-relative text-white shadow-sm" style="max-width: 350px; background: linear-gradient(180deg, rgba(8,36,74,.95) 0%, rgba(4,26,57,.98) 100%);">
                                                    <div class="card-body p-4">

                                                        <small class="text-warning fw-semibold text-uppercase d-block mb-3" style="letter-spacing:.5px;">
                                                            Lançamento Exclusivo
                                                        </small>

                                                        <h3 class="fw-bold mb-3">
                                                            Residencial Vista Azul
                                                        </h3>

                                                        <p class="text-light opacity-75 mb-4">
                                                            Apartamentos na planta com vista definitiva para o mar.
                                                        </p>

                                                        <small class="d-block text-light opacity-75">
                                                            A partir de
                                                        </small>

                                                        <div class="display-6 fw-bold lh-1 mb-4">
                                                            R$ 620.000<span style="font-size:.55em;">*</span>
                                                        </div>

                                                        <a href="#" class="btn btn-info text-dark fw-semibold rounded-2 px-4 py-2">
                                                            Conheça o empreendimento
                                                        </a>

                                                        <small class="d-block text-light opacity-50 mt-3">
                                                            *Consulte condições
                                                        </small>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Paginação -->
                <div class="swiper-pagination news"></div>
            </div>
        </section>
    @endif
    
    <section id="search" class="col-8 position-relative bg-white shadow-lg mt-negative rounded-3">
        <div class="property-search p-3">
            <div class="row align-items-center g-0">
        
                <!-- Tipo -->
                <div class="col-lg-3 col-md-6">
                    <div class="property-search__item d-flex justify-content-center align-items-center gap-0">
        
                        <div class="property-search__icon">
                            <i class="bi bi-building font-30"></i>
                        </div>
        
                        <div class="property-search__content">
                            <small class="label-imovel font-changa font-15 font-regular">Tipo de imóvel</small>
        
                            <select class="form-select border-0 shadow-none pt-0">
                                <option class="font-changa font-15 font-regular">Todos</option>
                                <option class="font-changa font-15 font-regular">Apartamento</option>
                                <option class="font-changa font-15 font-regular">Casa</option>
                                <option class="font-changa font-15 font-regular">Terreno</option>
                                <option class="font-changa font-15 font-regular">Sala Comercial</option>
                            </select>
                        </div>
        
                    </div>
                </div>
        
                <!-- Cidade -->
                <div class="col-lg-3 col-md-6">
                    <div class="property-search__item d-flex justify-content-center align-items-center gap-0">
        
                        <div class="property-search__icon">
                            <i class="bi bi-geo-alt font-30"></i>
                        </div>
        
                        <div class="property-search__content">
                            <small class="label-imovel font-changa font-15 font-regular">Cidade / Bairro</small>
        
                            <select class="form-select border-0 shadow-none pt-0">
                                <option class="font-changa font-15 font-regular">Selecione</option>
                            </select>
                        </div>
        
                    </div>
                </div>
        
                <!-- Faixa de preço -->
                <div class="col-lg-3 col-md-6">
                    <div class="property-search__item d-flex justify-content-center align-items-center gap-0">
        
                        <div class="property-search__icon">
                            <i class="bi bi-currency-dollar font-30"></i>
                        </div>
        
                        <div class="property-search__content">
                            <small class="label-imovel font-changa font-15 font-regular">Faixa de preço</small>
        
                            <select class="form-select border-0 shadow-none pt-0">
                                <option class="font-changa font-15 font-regular">Selecione</option>
                            </select>
                        </div>
        
                    </div>
                </div>
        
                <!-- Botão -->
                <div class="col-lg-3 col-md-6 d-flex justify-content-center">
                    <div class="property-search__button w-100">
        
                        <button type="submit" class="btn-search rounded-3 py-2 px-4 w-100 text-white text-center font-changa font-15 font-regular">
                            Buscar imóveis
                            <i class="bi bi-search ms-2"></i>
                        </button>
        
                    </div>
                </div>
        
            </div>
        </div>
    </section>

    @if ($topics->count() > 0)
        <section id="topic" class="topics pt-5">
            <div class="container">
                <div class="row g-4 justify-content-center">
                    @foreach ($topics as $topic)   
                        <div class="col-6 col-md-4 col-lg-2 topic-col">
                            @if ($topic->link <> null)
                                <a href="{{$topic->link}}" class="topic-item d-block" rel="noopener noreferrer">
                                    <img src="{{asset('storage/'.$topic->path_image)}}" alt="Tópico 1" class="img-fluid d-block m-auto" loading="lazy">
                                </a>
                                @else
                                <a class="topic-item d-block">
                                    <img src="{{asset('storage/'.$topic->path_image)}}" alt="Tópico 1" class="img-fluid d-block m-auto" loading="lazy">
                                </a>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <section class="featured-banner py-5">
        <div class="container">

            <a href="#" class="d-block position-relative rounded-4 featured-banner__card">

                <!-- Imagem -->
                <img
                    src="{{asset('build/client/themes/corretora/tp-01/images/slide.jpg')}}"
                    class="featured-banner__image"
                    alt="Marina Vista">

                <!-- Overlay -->
                <div class="featured-banner__overlay">

                    <div class="row align-items-center h-100 position-relative z-3">

                        <div class="col-lg-4">

                            <span class="featured-banner__tag d-block font-changa font-15 font-semibold text-uppercase color-yellow p-0 text-start mb-3">
                                Lançamento
                            </span>

                            <h2 class="featured-banner__title font-changa font-24 font-semibold text-white">
                                Viva o extraordinário todos os dias
                            </h2>

                            <p class="featured-banner__description font-changa font-15 font-regular">
                                Apartamentos na planta com lazer completo,
                                localização privilegiada e condições especiais.
                            </p>

                            <button class="btn featured-banner__button font-15 font-regular bg-yellow color-green rounded-2 px-3">
                                Quero saber mais
                            </button>

                        </div>

                        <div class="col-lg-4 text-center">

                            <img
                                src="{{asset('build/client/themes/corretora/tp-01/images/lg.png')}}"
                                class="featured-banner__logo"
                                alt="Marina Vista">

                        </div>

                        <div class="col-lg-4">

                            <!-- Espaço vazio para destacar a imagem -->
                        </div>

                    </div>

                </div>

            </a>

        </div>
    </section>

    <!-- IMÓVEIS EM DESTAQUE / DIVULGAÇÃO -->
    <section id="imoveis" class="section-padding">
        <div class="container">
            <div class="text-start mb-5">
                <span class="font-changa font-18 font-semibold color-green mb-2 text-uppercase">
                Destaques
                </span>
                <h2 class="font-changa font-40 font-bold mb-2 color-yellow section-title">Empreendimentos em Destaque</h2>
                <p class="font-changa font-15 font-regular text-muted text-start section-subtitle">Confira nossos empreendimentos mais procurados com as melhores oportunidades do mercado</p>
            </div>
            <div class="row g-4">
                <!-- Card 1 -->
                @for($i = 0; $i < 4; $i++)              
                    <div class="col-md-6 col-lg-3">
                        <div class="card bg-transparent border-1 shadow-sm card-shadow h-100">
                            <div class="image position-relative">
                                <div class="status d-flex justify-content-between align-items-start position-absolute">
                                    <span class="badge badge-featured rounded-2 text-uppercase font-changa font-12 font-semibold color-yellow"></i> Lançamento</span>
                                </div>
                                <img src="{{asset('build/client/themes/corretora/tp-01/images/slide.jpg')}}" class="card-img-top property-img" alt="Apartamento moderno">
                            </div>
                            <div class="card-body bg-transparent">
                                <h5 class="card-title font-changa font-15 font-semibold color-yellow my-0">Apê Alto Padrão – Vila Nova</h5>
                                <p class="card-text text-muted small"> R. das Acácias, 455</p>
                                <div class="d-flex gap-3 mb-3 small">
                                    <span><i class="bi bi-arrows-expand"></i> 84m²</span>
                                    <span><i class="bi bi-bed"></i> 3</span>
                                    <span><i class="bi bi-car-front"></i> 2 vagas</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-end">
                                    <div class="d-flex flex-column">
                                        <small>a partir de</small>
                                        <span class="font-changa font-20 font-semibold color-yellow text-accent">R$ 250.000</span>
                                    </div>
                                    <a href="#" class="btn btn-sm btn-outline-dark rounded-pill px-3">Detalhes <i class="bi bi-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
            <!-- chamada extra -->
            <div class="text-center mt-5">
                <a href="#" class="btn bg-yellow border text-white border-white px-5 py-3 rounded-3 font-changa font-16 font-semibold">Ver todos os imóveis <i class="bi bi-chevron-right"></i></a>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row align-items-center g-4">

                <!-- Conteúdo -->
                <div class="col-lg-8">
                    <h2 class="font-changa font-28 font-bold mb-5">
                        Por que investir na planta?
                    </h2>

                    <div class="row g-4">

                        <div class="col-6 col-md-3">
                            <div class="text-center text-md-start">
                                <div class="mb-3">
                                    <i class="fa-solid fa-hand-holding-dollar fa-2x text-info"></i>
                                </div>
                                <h6 class="font-changa font-16 font-bold mb-2">
                                    Melhores preços
                                </h6>
                                <p class="text-muted font-changa font-15 font-regular small mb-0">
                                    Condições especiais durante a construção.
                                </p>
                            </div>
                        </div>

                        <div class="col-6 col-md-3">
                            <div class="text-center text-md-start">
                                <div class="mb-3">
                                    <i class="fa-solid fa-chart-line fa-2x text-info"></i>
                                </div>
                                <h6 class="font-changa font-16 font-bold mb-2">
                                    Valorização garantida
                                </h6>
                                <p class="text-muted font-changa font-15 font-regular small mb-0">
                                    Seu investimento cresce durante a obra.
                                </p>
                            </div>
                        </div>

                        <div class="col-6 col-md-3">
                            <div class="text-center text-md-start">
                                <div class="mb-3">
                                    <i class="fa-solid fa-hammer fa-2x text-info"></i>
                                </div>
                                <h6 class="font-changa font-16 font-bold mb-2">
                                    Personalização
                                </h6>
                                <p class="text-muted font-changa font-15 font-regular small mb-0">
                                    Opções de acabamento que combinam com você.
                                </p>
                            </div>
                        </div>

                        <div class="col-6 col-md-3">
                            <div class="text-center text-md-start">
                                <div class="mb-3">
                                    <i class="fa-solid fa-wallet fa-2x text-info"></i>
                                </div>
                                <h6 class="font-changa font-16 font-bold mb-2">
                                    Facilidade de pagamento
                                </h6>
                                <p class="text-muted font-changa font-15 font-regular small mb-0">
                                    Planos flexíveis que cabem no seu bolso.
                                </p>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Card -->
                <div class="col-lg-4">
                    <div class="rounded-4 p-4 text-white h-100"
                        style="background:linear-gradient(135deg,#25C5E6,#17B6D5);">

                        <h3 class="font-changa font-24 font-bold mb-2">
                            Simule seu financiamento
                        </h3>

                        <p class="mb-4 font-changa font-15 font-regular opacity-75">
                            Descubra as melhores condições para o seu perfil.
                        </p>

                        <a href="#" class="btn bg-yellow px-4 font-changa font-14 font-regular text-white rounded-3">
                            Simular agora
                        </a>

                    </div>
                </div>

            </div>
        </div>
    </section>

    <section class="position-relative overflow-hidden"
    style="
        background: 
            linear-gradient(90deg, rgba(8,30,55,.92) 0%, rgba(8,30,55,.88) 35%, rgba(8,30,55,.45) 60%, rgba(8,30,55,.15) 100%),
            url('{{asset('build/client/themes/corretora/tp-01/images/slide.jpg')}}') center center / cover fixed no-repeat;
        min-height:280px;">

        <div class="container h-100">
            <div class="row align-items-center h-100" style="min-height:280px;">

                <div class="col-lg-5 col-md-7 py-5 text-white">

                    <span class="text-uppercase font-changa font-15 font-semibold small text-info d-block mb-2">
                        Invista com segurança
                    </span>

                    <h2 class="font-changa font-32 font-bold mb-3">
                        Construímos mais que imóveis,<br>
                        realizamos sonhos
                    </h2>

                    <p class="mb-4 font-changa font-15 font-regular text-white-50">
                        Há mais de 15 anos transformamos terrenos em lares e
                        investimentos sólidos. Qualidade, transparência e confiança
                        em cada projeto.
                    </p>

                    <a href="#" class="btn btn-info font-changa font-15 font-semibold px-4 py-2 rounded-3">
                        Conheça nossa história
                    </a>

                </div>

            </div>
        </div>

    </section>

    <section id="faq" class="faq-section pt-5 bg-grey-light">
        <div class="container">
            <div class="row align-items-start g-5">
            @if (isset($sessaoFaq) && $sessaoFaq <> null)
                <!-- COLUNA ESQUERDA -->
                <div class="col-lg-5">
                    <!-- Header -->
                    <div class="mb-4">
                        <span class="about-subtitle faq-eyebrow color-yellow font-changa font-16 font-bold d-block mb-2 text-start m-0 z-3 position-relative">
                            Conheça Aqui!
                        </span>

                        <h3 class="faq-title font-changa font-50 font-bold color-green mb-3">
                            {{$sessaoFaq->title}} <span class="color-grey">{{$sessaoFaq->subtitle}}</span>
                        </h3>
                    </div>

                    <div class="faq-text color-grey font-changa font-16 font-regular text-center text-lg-start">
                        {!!$sessaoFaq->description!!}
                    </div>

                    @if ($sessaoFaq->btn_title <> null && $sessaoFaq->btn_number <> null)                
                        <div class="d-flex justify-content-center justify-content-lg-start align-items-center">
                            <a href="{{$sessaoFaq->btn_number}}" class="btn btn-faq btn-product bg-green rounded-pill px-4 text-white">
                                {{$sessaoFaq->btn_title}}
                                <svg class="ms-2" width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12.4451 4.325e-05C9.23037 4.325e-05 6.01638 1.22269 3.56813 3.67104V3.6769C-0.397625 7.64665 -1.07437 13.7219 1.62183 18.5939L0.752675 23.3312H0.753652C0.705799 23.586 0.786854 23.8468 0.970449 24.0294C1.15307 24.213 1.4138 24.2931 1.66772 24.2462L6.40497 23.3771C11.277 26.0743 17.3572 25.3976 21.327 21.4307C26.2245 16.5343 26.2245 8.5675 21.327 3.67C18.8787 1.22272 15.6599 4.325e-05 12.4451 4.325e-05ZM12.4451 1.55669C15.2556 1.55669 18.0671 2.63482 20.2166 4.78319C24.5144 9.08019 24.5144 16.0214 20.2166 20.3194C16.6259 23.9064 11.0554 24.5744 6.72337 21.9298H6.7224C6.55834 21.8292 6.36205 21.7921 6.1726 21.8263L2.5016 22.4972L3.17445 18.8262C3.2096 18.6367 3.17445 18.4404 3.07484 18.2754C0.430339 13.9434 1.09144 8.37415 4.67934 4.78315C6.82779 2.6347 9.63534 1.55665 12.4458 1.55665L12.4451 1.55669ZM12.4451 5.11919C9.69512 5.11919 7.45288 7.37504 7.45288 10.1339H7.45385C7.45483 10.5646 7.80443 10.9132 8.2351 10.9152C8.44311 10.9162 8.64233 10.8341 8.79078 10.6877C8.93824 10.5412 9.02125 10.342 9.02222 10.134C9.02222 8.21793 10.5486 6.6877 12.445 6.6877C14.3413 6.6877 15.866 8.21798 15.866 10.134C15.866 11.7336 14.7898 13.0665 13.3405 13.463C12.4694 13.7012 11.6569 14.4376 11.6569 15.4903V17.0304H11.6578C11.6569 17.2393 11.7399 17.4395 11.8873 17.588C12.0348 17.7354 12.236 17.8184 12.445 17.8175C12.653 17.8165 12.8522 17.7335 12.9987 17.586C13.1452 17.4376 13.2272 17.2384 13.2262 17.0304V15.4903C13.2262 15.2979 13.4342 15.0626 13.7536 14.9757H13.7594C15.8825 14.3946 17.4304 12.4377 17.4304 10.1339C17.4304 7.37515 15.195 5.11919 12.4451 5.11919ZM12.4217 18.5019C11.9539 18.5137 11.5672 18.9062 11.5672 19.374C11.5672 19.8486 11.9676 20.2471 12.4451 20.2471C12.9226 20.2471 13.3172 19.8486 13.3172 19.374C13.3172 18.8994 12.9227 18.5019 12.4451 18.5019H12.4217Z" fill="#10513D"/>
                                </svg>
                            </a>
                        </div>
                    @endif

                    <div class="faq-image mt-0">
                        <img src="{{asset('storage/' . $sessaoFaq->path_file)}}" alt="Entrega" class="img-fluid">
                    </div>
                </div>
            @endif
            
            <!-- COLUNA DIREITA -->
            <div class="col-lg-7">
                <div class="accordion" id="faqAccordion">

                    <!-- ITEM ATIVO -->

                    @foreach ($faqs as $faq)     
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                            <button class="accordion-button collapsed font-changa font-16 font-regular"
                                data-bs-toggle="collapse"
                                data-bs-target="#faq-{{$faq->id}}">
                                {{$faq->question}}
                            </button>
                            </h2>
                            <div id="faq-{{$faq->id}}" class="accordion-collapse collapse"
                            data-bs-parent="#faqAccordion">
                                <div class="accordion-body font-changa font-16 font-regular">
                                    {!! $faq->answer !!}
                                </div>
                            </div>
                        </div>    
                    @endforeach

                </div>
            </div>

            </div>
        </div>
    </section>

    <section class="py-0">
        <div class="container-fluid px-0" style="background:linear-gradient(90deg,#22C6E8 0%, #35D0EC 50%, #22C6E8 100%);">

            <div class="col-12 col-lg-8 m-auto">
                <div class="d-flex flex-column flex-lg-row align-items-center justify-content-between gap-4 px-0 py-4">

                    <!-- Conteúdo -->
                    <div class="d-flex align-items-center text-center text-lg-start">
        
                        <div class="me-3 flex-shrink-0">
                            <div class="rounded-circle bg-wpp rounded-full d-flex align-items-center justify-content-center"
                                style="width:38px;height:38px;">
                                <i class="fab fa-whatsapp font-44 text-white"></i>
                            </div>
                        </div>
        
                        <div class="text-white">
                            <h3 class="font-changa font-28 font-bold mb-1">
                                Fale agora com um especialista
                            </h3>
        
                            <p class="mb-0 font-changa font-15 font-regular text-white-50">
                                Tire suas dúvidas e receba atendimento personalizado.
                            </p>
                        </div>
        
                    </div>
        
                    <!-- Botão -->
                    <div class="text-center">
                        <a href="#"
                        class="btn bg-yellow border text-white border-white px-4 py-3 rounded-3 font-changa font-16 font-semibold">
                            Conversar no WhatsApp
                            <i class="fab fa-whatsapp text-white font-18 ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </section>

@endsection
