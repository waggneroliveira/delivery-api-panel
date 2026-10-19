@extends($theme->core('client'))
@section('content')
    @if (isset($slides) && $slides->count() > 0)
        <section class="hero">
        <div class="swiper main-swiper">

            <div class="swiper-wrapper">
                @foreach ($slides as $slide)
                    <!-- Slide -->
                    <div class="swiper-slide">
                        <div class="hero-slide">

                            <!-- Imagem full -->
                            <div class="hero-bg">
                                <picture>
                                    <source srcset="{{ asset('storage/' . $slide->path_image_mobile) }}" media="(max-width: 530px)">
                                    <img src="{{ asset('storage/' . $slide->path_image) }}" alt="Distribuição PET" title="Distribuição PET">
                                </picture>
                            </div>

                            <!-- Conteúdo -->
                            <div class="hero-content mt-0">
                                <div class="container">
                                <div class="row">
                                    <div class="col-lg-6">

                                        <span class="hero-subtitle font-changa font-15 font-regular" data-aos="fade-up" data-aos-delay="200">
                                            {!!$slide->description!!}
                                        </span>

                                        <h1 class="hero-title font-changa font-40 font-bold" data-aos="fade-up" data-aos-delay="300">
                                            {{$slide->title}}
                                        </h1>

                                        <div class="hero-actions d-flex" data-aos="fade-up" data-aos-delay="400">
                                            @if ($slide->link <> null)                                    
                                                <a href="{{$slide->link}}" target="_blank" rel="noopener noreferrer" class="btn-one col-auto py-1 py-lg-2 px-3 px-lg-5 btn-hero font-changa bg-button-one color-button-one font-15 font-medium text-decoration-none hover-zoom">
                                                    {{$slide->btn_title}}
                                                    <svg class="ms-2" width="9" height="13" viewBox="0 0 9 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M1.78794 12.474L8.02494 6.237L1.78794 -1.90735e-06L0.02079 1.76715L4.46985 6.237L0 10.7068L1.78794 12.474Z" fill="var(--color-button-one)"/>
                                                    </svg>
                                                </a>
                                            @endif
                                        </div>

                                    </div>
                                </div>
                                </div>
                            </div>
                            <div class="overlay"></div>
                        </div>
                    </div>
                @endforeach

            </div>

            <!-- Paginação -->
            <div class="swiper-pagination news"></div>
        </div>
        </section>
    @endif

    @if (isset($abouts) && $abouts->count())
        <section id="about" class="about bg-light">
            <div class="container-fluid">
                @foreach($abouts as $about)                    
                    <div class="row align-items-center justify-content-center">
                        <!-- TEXTO (dentro do container) -->
                        <div class="col-12 col-lg-5 mt-4 mt-md-4 z-3 p-0" data-aos="fade-right" data-aos-delay="100">
                            <div class="container position-relative">
                                <span class="rounded-2 col-5 col-lg-4 px-3 m-lg-0 py-2 text-dark text-center font-changa font-16 font-bold d-block badge bg-white shadow-sm">
                                    Quem Somos?
                                </span>

                                <h3 class="about-title font-changa font-40 font-bold mt-2 mt-lg-3 mb-3 text-black text-start">
                                    {{$about->title}} <span class="primary-color">{{$about->subtitle}}</span>
                                </h3>

                                <!-- Conteúdo adicional opcional -->
                                <div class="description">
                                    {!! $about->text !!}
                                </div>

                                @if ($about->link <> null)                        
                                    <div class="btn-about my-4 d-flex justify-content-center justify-content-lg-start">
                                        <a href="{{$about->link}}" class="py-1 py-lg-2 px-3 px-lg-5 font-changa bg-button-two color-button-two font-15 font-medium text-decoration-none hover-zoom" rel="noopener noreferrer">
                                            Conheça
                                            <svg class="ms-2" width="9" height="13" viewBox="0 0 9 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1.78794 12.474L8.02494 6.237L1.78794 -1.90735e-06L0.02079 1.76715L4.46985 6.237L0 10.7068L1.78794 12.474Z" fill="var(--color-button-two)"></path>
                                            </svg>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>

                        @if (isset($about->path_image) && $about->path_image <> null)                    
                            <!-- IMAGEM (fora do container) -->
                            <div class="col-12 col-lg-6 p-0 about-image" data-aos="fade-left" data-aos-delay="100">
                                <img
                                src="{{asset('storage/'.$about->path_image)}}"
                                alt="Sobre a Girollato"
                                class="img-fluid w-100"
                                loading="lazy"
                                >
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    <section id="services" class="py-5 service-bg position-relative {{ empty($sections['service']->path_image) ? 'bg-secondary-color' : '' }}"
        @if (!empty($sections['service']->path_image))
            style="background-image: url('{{ asset('storage/' . $sections['service']->path_image) }}');"
        @endif>

        <div class="container">
            @if (isset($sections['service']) && $sections <> null) 
                <!-- Cabeçalho -->
                <div class="row align-items-end mb-4 position-relative z-index-10" data-aos="fade" data-aos-delay="200">

                    <div class="col-lg-4">
                        <span class="rounded-2 col-5 col-lg-4 px-2 m-lg-0 py-2 text-dark text-center font-changa font-16 font-bold d-block badge bg-white shadow-sm">
                            {{$sections['service']->tag}}
                        </span>

                        <h2 class="text-white fw-bold mt-3 font-changa">
                            {{$sections['service']->title}}
                        </h2>
                    </div>

                    <div class="col-lg-5 mt-3 mt-lg-0">
                        <p class="text-white small mb-0 font-changa">
                            {{$sections['service']->description}}
                        </p>
                    </div>

                    <div class="col-lg-3 mt-3 mt-lg-0">
                        <div class="d-flex justify-content-lg-end gap-2">
                            <button class="btn btn-outline-light rounded-circle swiper-button-prev-custom"
                                    type="button">
                                <i class="bi bi-chevron-left"></i>
                            </button>

                            <button class="btn btn-outline-light rounded-circle swiper-button-next-custom"
                                    type="button">
                                <i class="bi bi-chevron-right"></i>
                            </button>
                        </div>
                    </div>

                </div>
            @endif

            <!-- Swiper -->
            <div class="swiper servicesSwiper">
                <div class="swiper-wrapper">

                    <!-- Serviço 1 -->
                    @foreach ($services as $index => $service)
                        <div class="swiper-slide">
                            <div class="card h-100 border-0 rounded-4 overflow-hidden" data-aos="fade-left" data-aos-delay="{{ ($index + 1) * 100 }}">

                                @if ($service->path_image <> null)                                    
                                    <div class="p-3">
                                        <img loading="lazy" src="{{asset('storage/' . $service->path_image)}}"
                                            class="card-img-top rounded-4"
                                            alt="{{$service->title}}" height="200">
                                    </div>
                                @endif

                                <div class="card-body d-flex flex-column pt-0 px-4">
                                    @if ($service->path_icon <> null)                                        
                                        <div class="mb-2 position-relative">
                                            <span class="position-absolute icon-service d-inline-flex align-items-center justify-content-center bg-primary-color rounded-3 p-2">
                                                <img loading="lazy" src="{{asset('storage/' . $service->path_icon)}}"
                                                class="card-img-top rounded-4"
                                                alt="{{$service->title}}" height="25">
                                            </span>
                                        </div>
                                    @endif

                                    <h3 class="fw-bold mb-2 {{ $service->path_icon != null ? 'mt-3' : 'mt-1' }}">
                                        {{ $service->title }}
                                    </h3>

                                    <p class="text-muted small flex-grow-1">
                                        {{substr(strip_tags($service->description), 0, 100)}}...
                                    </p>

                                    <button type="button"
                                            class="btn btn-outline-dark rounded-pill w-100 d-flex align-items-center justify-content-between service-modal-btn"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalServico"
                                            data-servico-titulo="{{ $service->title }}"
                                            data-servico-desc="{{ $service->text ?? '' }}"
                                            data-servico-link="{{ $service->link ?? '' }}"
                                            data-servico-scroll="{{ $service->scroll_section ?? '' }}"
                                            data-servico-icon="{{ $service->path_icon ? asset('storage/' . $service->path_icon) : '' }}">
                                        <span>Explore Mais</span>
                                        <i class="bi bi-chevron-right"></i>
                                    </button>

                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>

        </div>
    </section>

    <!-- Modal Serviço -->
    <div class="modal fade" id="modalServico" tabindex="-1" aria-labelledby="modalServicoLabel">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content rounded-4 border-0 shadow">

                <div class="modal-header bg-warning bg-opacity-10 border-0">

                    <div class="d-flex align-items-center">

                        <span class="d-inline-flex align-items-center justify-content-center bg-primary-color rounded-3 p-2 me-2">
                            <img loading="lazy"
                                id="modalIcon"
                                src=""
                                alt=""
                                class="d-none"
                                height="25"
                            >
                        </span>

                        <h5 class="modal-title fw-bold" id="modalServicoLabel">
                            <span id="modalTitulo">Serviço</span>
                        </h5>

                    </div>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Fechar">
                    </button>

                </div>

                <div class="modal-body">

                    <div id="modalDescricao" class="fs-6 text-secondary"></div>

                </div>

                <div class="modal-footer bg-light">

                    <a
                        href="#"
                        id="modalSolicitar"
                        class="btn btn-warning bg-button-two color-button-two rounded-pill px-4 d-none"
                    >
                        Solicitar serviço
                    </a>

                    <button
                        type="button"
                        class="btn btn-outline-secondary rounded-pill"
                        data-bs-dismiss="modal"
                    >
                        Fechar
                    </button>

                </div>

            </div>
        </div>
    </div>

    @if (isset($sessaoFaq) && $sessaoFaq <> null || isset($faqs) && $faqs->count())
        <section id="faq" class="faq-section pt-5 bg-grey-light pb-4 pb-lg-0">
            <div class="container">
                <div class="row align-items-start g-5">
                    @if (isset($sessaoFaq) && $sessaoFaq <> null)
                        <!-- COLUNA ESQUERDA -->
                        <div class="col-lg-5" data-aos="fade-right" data-aos-delay="100">
                            <!-- Header -->
                            <div class="mb-4">
                                <h3 class="faq-title font-changa font-40 font-bold color-grey mb-3 text-start">
                                    {{$sessaoFaq->title}} <span class="primary-color">{{$sessaoFaq->subtitle}}</span>
                                </h3>
                            </div>

                            @if ($sessaoFaq->btn_title <> null && $sessaoFaq->btn_number <> null)                
                                <div class="d-flex justify-content-lg-start align-items-center">
                                    <a href="{{$sessaoFaq->btn_number}}" class="bg-button-two color-button-two btn-product py-1 py-lg-2 px-4 font-15 hover-zoom">
                                        {{$sessaoFaq->btn_title}}
                                        <svg class="ms-2" width="9" height="13" viewBox="0 0 9 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1.78794 12.474L8.02494 6.237L1.78794 -1.90735e-06L0.02079 1.76715L4.46985 6.237L0 10.7068L1.78794 12.474Z" fill="var(--color-button-one)"/>
                                        </svg>
                                    </a>
                                </div>
                            @endif

                            <div class="faq-image mt-4">
                                <img loading="lazy" src="{{asset('storage/' . $sessaoFaq->path_file)}}" alt="Entrega" class="img-fluid">
                            </div>
                        </div>
                    @endif

                    @if (isset($faqs) && $faqs->count())
                        <!-- COLUNA DIREITA -->
                        <div class="col-lg-7 mt-0 mt-lg-5" data-aos="fade-left" data-aos-delay="100">
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
                    @endif

                </div>
            </div>
        </section>
    @endif

    @if (isset($depoiments) && $depoiments->count())
        <section id="depoiment" class="depoiment py-5 position-relative bg-secondary-color" data-aos="fade-up" data-aos-delay="100">
            <div class="container">
                <div class="row justify-content-center justify-content-lg-between align-items-start">
                    @if (isset($sections['testimonial']) && $sections <> null)    
                        <div class="col-lg-5 d-table text-start">
                            <span class="rounded-2 col-5 col-lg-4 px-3 py-1 bg-white text-dark text-center font-changa font-16 font-bold d-block mb-2">
                                {{$sections['testimonial']->tag}}
                            </span>
        
                            <h2 class="font-changa font-40 title font-bold text-white text-start mb-3">
                                {{$sections['testimonial']->title}}
                            </h2>
                            <p class="font-regular text-white mb-0 font-changa font-18">{{$sections['testimonial']->description}}</p>
                        </div>
                    @endif
                    <div class="col-lg-6 mt-lg-0 mt-5">
                        <div class="swiper testimonial-swiper">
                            <div class="swiper-wrapper">
        
                                <!-- Slide -->
                                @foreach ($depoiments as $depoiment)                    
                                    <div class="swiper-slide">
                                        <div class="testimonial-card position-relative">
                                            <svg width="127" height="21" viewBox="0 0 127 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M10.7957 15.7848L4.08407 20.6321L6.72967 12.7486L0.000266403 7.88357H8.2389L10.7957 4.30346e-05L13.3525 7.88357H21.5912L14.8618 12.7486L17.5074 20.6321L10.7957 15.7848ZM36.9432 15.7848L30.2315 20.6321L32.8771 12.7486L26.1477 7.88357H34.3864L36.9432 4.30346e-05L39.5 7.88357H47.7386L41.0092 12.7486L43.6548 20.6321L36.9432 15.7848ZM63.0906 15.7848L56.379 20.6321L59.0246 12.7486L52.2952 7.88357H60.5338L63.0906 4.30346e-05L65.6475 7.88357H73.8861L67.1567 12.7486L69.8023 20.6321L63.0906 15.7848ZM89.2381 15.7848L82.5265 20.6321L85.1721 12.7486L78.4426 7.88357H86.6813L89.2381 4.30346e-05L91.7949 7.88357H100.034L93.3042 12.7486L95.9498 20.6321L89.2381 15.7848ZM115.386 15.7848L108.674 20.6321L111.32 12.7486L104.59 7.88357H112.829L115.386 4.30346e-05L117.942 7.88357H126.181L119.452 12.7486L122.097 20.6321L115.386 15.7848Z" fill="var(--primary-color)"/>
                                            </svg>

                                            <div class="text color-grey font-changa font-16 font-regular text-start mt-4">
                                                {!!$depoiment->text!!}
                                            </div>
        
                                            <div class="author">
                                                <div class="text-dark font-changa font-24 title font-medium mb-0 mt-3">{{$depoiment->name}}</div>
                                                <span class="text-dark font-changa font-16 font-regular">{{$depoiment->function}}</span>
                                            </div>

                                            <div class="position-absolute firula-testimonial">
                                                <svg width="102" height="102" viewBox="0 0 102 102" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M51 102C79.1665 102 102 79.1665 102 51C102 22.8335 79.1665 0 51 0C22.8335 0 0 22.8335 0 51C0 79.1665 22.8335 102 51 102Z" fill="white"/>
                                                <path d="M51 94C74.7482 94 94 74.7482 94 51C94 27.2518 74.7482 8 51 8C27.2518 8 8 27.2518 8 51C8 74.7482 27.2518 94 51 94Z" fill="var(--primary-color"/>
                                                <path d="M33.5778 38.5V33.5142C33.5778 32.0985 33.8548 30.652 34.4087 29.1747C34.9627 27.6974 35.6937 26.3048 36.6016 24.9968C37.5095 23.6888 38.4943 22.5962 39.5561 21.7191L43.8956 24.2812C43.0339 25.6354 42.326 27.0511 41.772 28.5284C41.2334 30.0057 40.9641 31.6522 40.9641 33.468V38.5H33.5778ZM45.2344 38.5V33.5142C45.2344 32.0985 45.5114 30.652 46.0653 29.1747C46.6193 27.6974 47.3503 26.3048 48.2582 24.9968C49.1661 23.6888 50.1509 22.5962 51.2127 21.7191L55.5522 24.2812C54.6905 25.6354 53.9826 27.0511 53.4286 28.5284C52.89 30.0057 52.6207 31.6522 52.6207 33.468V38.5H45.2344Z" fill="black"/>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
        
                            </div>
        
                            <!-- Dots -->
                            <div class="swiper-pagination mt-4 position-relative d-flex justify-content-center align-items-center"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    @if (isset($serviceLocation))
        <section id="coverage-section" class="coverage-section py-5 position-relative bg-light" data-aos="fade-down" data-aos-delay="100">
            <div class="container">
                <div class="row align-items-start gy-4">
                    <!-- MAPA -->
                    <div class="col-12 col-lg-6">
                        <div class="mb-4 col-12 col-lg-11">
                            <span class="rounded-2 col-5 col-lg-4 px-3 m-lg-0 py-2 bg-primary-color text-dark text-center font-changa font-16 font-bold d-block">
                                Cobertura
                            </span>

                            <h3 class="about-title text-start font-changa font-40 font-bold text-dark my-3 position-relative">                            
                                {{$serviceLocation->title}}
                            </h3>
                        </div>
                        
                        <!-- BAHIA -->
                        <div class="state-block mb-4">
                            <div class="row list-service col-12 m-auto">
                                {!! $serviceLocation->description !!}
                            </div>
                        </div>
                    </div>
                    <!-- LISTAS -->
                    <div class="col-12 col-lg-6 mt-0 text-center">
                        <!-- BAHIA -->
                        <img loading="lazy"  
                            src="{{asset('storage/' .$serviceLocation->path_image)}}" 
                            alt="Mapa de cobertura"
                            class="img-fluid coverage-map"
                            >
                    </div>
                </div>
            </div>
        </section>
    @endif
    
    @if (isset($contact) && $contact <> null)
        <section class="contact-section bg-light" data-aos="fade" data-aos-delay="100">
            <!-- Título -->
            <div class="container text-center py-3">
                <span class="rounded-2 px-4 m-auto m-lg-0 py-2 text-dark text-center font-changa font-16 font-bold badge bg-white shadow-sm">
                    Contato
                </span>

                <h2 class="font-changa font-40 font-bold my-3 text-black text-center">
                    {{$contact->name_section}} <span class="primary-color">{{$contact->text}}</span>
                </h2>
            </div>
            <div id="contato"></div>
            <!-- Informações de contato -->
            <div class="container-fluid px-0">
                <div class="bg-secondary-color border-bottom border-3 border-warning">
                    <div class="container">
                        <div class="row align-items-center justify-content-center">

                            <!-- Telefone -->
                            @if ($contact->phone_one)                            
                                <div class="col-md-4 py-3 px-4">
                                    <div class="d-flex align-items-center justify-content-center gap-3">
                                        <i class="bi bi-telephone fs-3 text-white"></i>

                                        <span class="text-white fw-semibold small font-changa">
                                            {{$contact->phone_one}}
                                        </span>
                                    </div>
                                </div>
                            @endif

                            <!-- Endereço -->
                            @if ($contact->address_one)                            
                                <div class="col-md-4 py-3 px-4 border-start border-end border-light border-opacity-50">
                                    <div class="d-flex align-items-center justify-content-center gap-3">
                                        <i class="bi bi-geo-alt fs-3 text-white"></i>

                                        <span class="text-white fw-semibold small font-changa">
                                            {{$contact->address_one}}
                                        </span>
                                    </div>
                                </div>
                            @endif

                            <!-- E-mail -->
                            @if ($contact->name_one)                            
                                <div class="col-md-4 py-3 px-4">
                                    <div class="d-flex align-items-center justify-content-center gap-3">
                                        <i class="bi bi-envelope fs-3 text-white"></i>

                                        <span class="text-white fw-semibold small font-changa">
                                            {{$contact->name_one}}
                                        </span>
                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            /*
            * ==========================================================
            * CONFIGURAÇÃO GERAL
            * ==========================================================
            */

            const hasSwiper = typeof Swiper !== 'undefined';
            const hasBootstrap = typeof bootstrap !== 'undefined';


            /*
            * ==========================================================
            * SWIPER - SERVIÇOS
            * ==========================================================
            */

            const servicesSwiper = document.querySelector('.servicesSwiper');

            if (hasSwiper && servicesSwiper) {

                new Swiper(servicesSwiper, {
                    slidesPerView: 1,
                    spaceBetween: 12,

                    navigation: {
                        nextEl: '.swiper-button-next-custom',
                        prevEl: '.swiper-button-prev-custom'
                    },

                    breakpoints: {
                        576: {
                            slidesPerView: 2,
                            spaceBetween: 12
                        },

                        992: {
                            slidesPerView: 4,
                            spaceBetween: 12
                        }
                    }
                });

            }


            /*
            * ==========================================================
            * SWIPER - BLOG
            * ==========================================================
            */

            const blogSwiper = document.querySelector('.blog-swiper');

            if (hasSwiper && blogSwiper) {

                new Swiper(blogSwiper, {
                    spaceBetween: 24,

                    pagination: {
                        el: '.swiper-pagination-blog',
                        clickable: true
                    },

                    breakpoints: {
                        0: {
                            slidesPerView: 1.3
                        },

                        576: {
                            slidesPerView: 2
                        },

                        992: {
                            slidesPerView: 4,
                            allowTouchMove: false
                        }
                    }
                });

            }


            /*
            * ==========================================================
            * SWIPER - DEPOIMENTOS
            * ==========================================================
            */

            const testimonialSwiper = document.querySelector('.testimonial-swiper');

            if (hasSwiper && testimonialSwiper) {

                new Swiper(testimonialSwiper, {
                    loop: true,
                    spaceBetween: 24,

                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true
                    },

                    breakpoints: {
                        0: {
                            slidesPerView: 1
                        },

                        768: {
                            slidesPerView: 1
                        }
                    }
                });

            }


            /*
            * ==========================================================
            * MODAL DE SERVIÇOS - serviceModal
            * ==========================================================
            */

            const serviceModal = document.getElementById('serviceModal');

            if (serviceModal && hasBootstrap) {

                serviceModal.addEventListener('show.bs.modal', function (event) {

                    const button = event.relatedTarget;

                    if (!button) {
                        return;
                    }

                    const title =
                        button.dataset.title || 'Serviço';

                    const icon =
                        button.dataset.icon || '';

                    const description =
                        button.dataset.description || '';

                    const modalTitle =
                        document.getElementById('serviceModalLabel');

                    const modalDescription =
                        document.getElementById('serviceModalDescription');

                    const modalIcon =
                        document.getElementById('serviceModalIcon');


                    /*
                    * TÍTULO
                    */

                    if (modalTitle) {
                        modalTitle.textContent = title;
                    }


                    /*
                    * DESCRIÇÃO
                    */

                    if (modalDescription) {
                        modalDescription.textContent = description;
                    }


                    /*
                    * ÍCONE
                    */

                    if (modalIcon) {

                        /*
                        * Remove classes de ícone anteriores
                        */
                        modalIcon.className = '';

                        /*
                        * Adiciona as classes padrão
                        */
                        modalIcon.classList.add('bi', 'fs-5');

                        /*
                        * Adiciona o ícone informado
                        */
                        if (icon) {
                            modalIcon.classList.add(...icon.split(' '));
                        }

                    }

                });

            }


            /*
            * ==========================================================
            * MODAL DE SERVIÇOS - modalServico
            * ==========================================================
            */

            const modalServico = document.getElementById('modalServico');

            if (modalServico && hasBootstrap) {

                /*
                * ------------------------------------------------------
                * ABRIR MODAL
                * ------------------------------------------------------
                */

                modalServico.addEventListener('show.bs.modal', function (event) {

                    const serviceCard = event.relatedTarget;

                    if (!serviceCard) {
                        return;
                    }


                    /*
                    * DADOS DO SERVIÇO
                    */

                    const titulo =
                        serviceCard.dataset.servicoTitulo || 'Serviço';

                    const descricao =
                        serviceCard.dataset.servicoDesc || '';

                    const link =
                        serviceCard.dataset.servicoLink || '';

                    const scroll =
                        serviceCard.dataset.servicoScroll || '';

                    const icon =
                        serviceCard.dataset.servicoIcon || '';


                    /*
                    * ELEMENTOS DO MODAL
                    */

                    const modalTitulo =
                        modalServico.querySelector('#modalTitulo');

                    const modalDescricao =
                        modalServico.querySelector('#modalDescricao');

                    const modalSolicitar =
                        modalServico.querySelector('#modalSolicitar');

                    const modalIcon =
                        modalServico.querySelector('#modalIcon');


                    /*
                    * --------------------------------------------------
                    * TÍTULO
                    * --------------------------------------------------
                    */

                    if (modalTitulo) {
                        modalTitulo.textContent = titulo;
                    }


                    /*
                    * --------------------------------------------------
                    * DESCRIÇÃO
                    * --------------------------------------------------
                    */

                    if (modalDescricao) {
                        modalDescricao.innerHTML = descricao;
                    }


                    /*
                    * --------------------------------------------------
                    * ÍCONE / IMAGEM
                    * --------------------------------------------------
                    */

                    if (modalIcon) {

                        if (icon) {

                            modalIcon.src = icon;
                            modalIcon.alt = titulo;
                            modalIcon.classList.remove('d-none');

                        } else {

                            modalIcon.removeAttribute('src');
                            modalIcon.alt = '';
                            modalIcon.classList.add('d-none');

                        }

                    }


                    /*
                    * --------------------------------------------------
                    * BOTÃO
                    * --------------------------------------------------
                    */

                    if (!modalSolicitar) {
                        return;
                    }


                    /*
                    * RESET DO BOTÃO
                    */

                    modalSolicitar.classList.add('d-none');
                    modalSolicitar.href = '#';

                    modalSolicitar.removeAttribute('target');
                    modalSolicitar.removeAttribute('rel');

                    modalSolicitar.onclick = null;


                    /*
                    * --------------------------------------------------
                    * LINK EXTERNO
                    * --------------------------------------------------
                    */

                    if (link) {

                        modalSolicitar.href = link;
                        modalSolicitar.target = '_blank';
                        modalSolicitar.rel = 'noopener noreferrer';

                        modalSolicitar.classList.remove('d-none');

                        return;
                    }


                    /*
                    * --------------------------------------------------
                    * SCROLL PARA SEÇÃO
                    * --------------------------------------------------
                    */

                    if (scroll) {

                        modalSolicitar.href = '#' + scroll;
                        modalSolicitar.classList.remove('d-none');


                        modalSolicitar.onclick = function (event) {

                            event.preventDefault();


                            /*
                            * Verifica se o Bootstrap possui
                            * a instância atual do modal.
                            */

                            const modalInstance =
                                bootstrap.Modal.getInstance(modalServico);


                            /*
                            * Função responsável pelo scroll
                            */

                            const scrollToTarget = function () {

                                const target =
                                    document.getElementById(scroll);

                                if (!target) {
                                    return;
                                }

                                target.scrollIntoView({
                                    behavior: 'smooth',
                                    block: 'start'
                                });

                            };


                            /*
                            * Fecha o modal antes do scroll
                            */

                            if (modalInstance) {

                                modalServico.addEventListener(
                                    'hidden.bs.modal',
                                    scrollToTarget,
                                    { once: true }
                                );

                                modalInstance.hide();

                            } else {

                                setTimeout(scrollToTarget, 150);

                            }

                        };

                        return;
                    }


                    /*
                    * --------------------------------------------------
                    * SEM AÇÃO
                    * --------------------------------------------------
                    */

                    modalSolicitar.classList.add('d-none');
                    modalSolicitar.href = '#';

                });


                /*
                * ------------------------------------------------------
                * MODAL FECHADO
                * ------------------------------------------------------
                */

                modalServico.addEventListener('hidden.bs.modal', function () {

                    /*
                    * Remove o foco do elemento ativo
                    */

                    if (
                        document.activeElement &&
                        typeof document.activeElement.blur === 'function'
                    ) {
                        document.activeElement.blur();
                    }


                    /*
                    * Elementos
                    */

                    const modalSolicitar =
                        modalServico.querySelector('#modalSolicitar');

                    const modalIcon =
                        modalServico.querySelector('#modalIcon');


                    /*
                    * RESET DO BOTÃO
                    */

                    if (modalSolicitar) {

                        modalSolicitar.href = '#';

                        modalSolicitar.removeAttribute('target');
                        modalSolicitar.removeAttribute('rel');

                        modalSolicitar.classList.add('d-none');

                        modalSolicitar.onclick = null;

                    }


                    /*
                    * RESET DO ÍCONE
                    */

                    if (modalIcon) {

                        modalIcon.removeAttribute('src');
                        modalIcon.alt = '';

                        modalIcon.classList.add('d-none');

                    }

                });

            }


            /*
            * ==========================================================
            * MÁSCARA DE TELEFONE
            * ==========================================================
            */

            const phoneInput =
                document.querySelector('#phone');


            if (
                phoneInput &&
                !phoneInput.dataset.masked
            ) {

                phoneInput.addEventListener('input', function (event) {

                    let value =
                        event.target.value.replace(/\D/g, '');


                    /*
                    * Permite apagar o campo completamente
                    */

                    if (!value) {

                        event.target.value = '';

                        return;
                    }


                    /*
                    * Força o DDD 71
                    */

                    if (!value.startsWith('71')) {
                        value = '71' + value;
                    }


                    /*
                    * Limita a 11 dígitos
                    */

                    value = value.slice(0, 11);


                    /*
                    * Monta a máscara
                    *
                    * (71) 9 9999-9999
                    */

                    let formatted =
                        '(' + value.slice(0, 2) + ')';


                    if (value.length > 2) {
                        formatted += ' ' + value.slice(2, 3);
                    }


                    if (value.length > 3) {
                        formatted += ' ' + value.slice(3, 7);
                    }


                    if (value.length > 7) {
                        formatted += '-' + value.slice(7);
                    }


                    event.target.value = formatted;

                });


                /*
                * Evita registrar o listener novamente
                */

                phoneInput.dataset.masked = 'true';

            }

        });
    </script>

@endsection
