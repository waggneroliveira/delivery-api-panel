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

                                            <h1 class="hero-title font-changa font-40 font-bold mb-3" data-aos="fade-up" data-aos-delay="300">
                                                {{$slide->title}}
                                            </h1>

                                            <span class="hero-subtitle font-changa font-15 font-regular" data-aos="fade-up" data-aos-delay="200">
                                                {!!$slide->description!!}
                                            </span>                                        

                                            <div class="hero-actions d-flex mt-5" data-aos="fade-up" data-aos-delay="400">
                                                @if ($slide->link <> null)                                    
                                                    <a href="{{$slide->link}}" target="_blank" rel="noopener noreferrer" class="btn-one rounded-pill col-auto py-1 py-lg-2 px-3 px-lg-5 btn-hero font-changa bg-button-one color-button-one font-15 font-semibold text-decoration-none hover-zoom">
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

    @if ($benefitTopics->count())
        <section id="stats-section" class="stats-section position-relative w-100 d-flex">

            <div class="container">
                <div class="row row-cols-2 row-cols-md-3 row-cols-lg-5 text-center g-4 py-3">
                    @foreach ($benefitTopics as $parametro)
                        <div class="col">
                            <div class="stat-item">
                                <div class="stat-number text-secondary font-changa font-bold font-44 mb-0"
                                    data-target="{{ $parametro->number }}">0</div>

                                <p class="font-changa font-bold font-16 text-secondary">
                                    {{ $parametro->title }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if (isset($sections['service']) && $sections <> null || $services->count()) 
        <section id="services" class="services-section py-5 position-relative">
            <img src="{{asset('build/client/images/themes/provedor/provedor-left-tp-02.png')}}" alt="Firula Left" class="z-index-0 position-absolute start-0 top-0" loading="lazy">
            <img src="{{asset('build/client/images/themes/provedor/provedor-right-tp-02.png')}}" alt="Firula Right" class="z-index-0 position-absolute end-0 top-0" loading="lazy">
            
            <div class="container-fluid px-3 px-lg-4 z-index-1 position-relative">
                @if (isset($sections['service']) && $sections <> null) 
                    <!-- Cabeçalho -->
                    <div class="row justify-content-center text-center mb-4">
                        <div class="col-12 col-lg-8 text-start text-lg-center">
                            <span class="services-badge border rounded-pill text-secondary font-15 font-semibold py-2 px-3">
                                <svg class="me-1" width="6" height="6" viewBox="0 0 6 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M3 5.78362C4.65685 5.78362 6 4.48891 6 2.89181C6 1.29471 4.65685 0 3 0C1.34315 0 0 1.29471 0 2.89181C0 4.48891 1.34315 5.78362 3 5.78362Z" fill="var(--accent-color)"/>
                                </svg>

                                {{ $sections['service']->tag }}
                            </span>
                            <h2 class="services-title font-38 font-bold mt-3 mb-2 col-12 col-lg-10 m-auto text-start text-lg-center">{{ $sections['service']->title }} <span class="services-subtitle font-38 font-bold accent-color">{{ $sections['service']->subtitle }}</span></h2>
                            <p class="font-15 font-regular text-secondary text-start text-lg-center">{{ $sections['service']->description }}</p>
                        </div>
                    </div>
                @endif

                @if ($services->count())
                    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-5 text-center g-4 py-3">

                        <!-- Card 01 -->
                        @foreach($services as $index => $service)                    
                            <div class="col px-2">
                                <div class="service-card rounded-3">
                                    <div class="service-content align-items-start">
                                        <div class="font-changa font-bold font-18 text-uppercase mb-3">{{$service->title}}</div>

                                        <div class="service-list">
                                            {!!$service->text!!}
                                        </div>

                                        <div class="service-number w-100 text-start font-50 font-bold">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</div>
                                    </div>

                                    <div class="service-image">
                                        <img
                                            src="{{asset('storage/' . $service->path_image)}}"
                                            alt="{{$service->title}}"
                                        >

                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                @endif
            </div>
        </section>
    @endif

    @if ($topics->count() > 0 || (isset($sections['pilar']) && $sections['pilar'] !== null))
        @php
            $hasPilar = isset($sections['pilar']) && $sections['pilar'] !== null;
            $hasTopics = $topics->count() > 0;
        @endphp

        <section id="benefit" class="topics py-5 bg-primary-color">
            <div class="container">
                <div class="row justify-content-center align-items-center">

                    {{-- Conteúdo da esquerda --}}
                    @if ($hasPilar)
                        <div class="content-left {{ $hasTopics ? 'col-12 col-lg-6' : 'col-12' }}">
                            <h2 class="about-title font-changa text-center text-lg-start font-40 font-bold text-white mb-3">
                                {{ $sections['pilar']->title }}
                            </h2>

                            @if ($sections['pilar']->link != null)
                                <div class="step-actions gap-3 d-flex mt-4 flex-wrap justify-content-center justify-content-lg-start">
                                    <a href="{{ $sections['pilar']->link }}"
                                    class="rounded-pill py-2 px-4 hover-zoom btn-hero font-changa bg-button-one color-button-one font-15 font-bold text-decoration-none"
                                    rel="noopener noreferrer">

                                        {{ $sections['pilar']->btn_title }}

                                        <svg class="ms-2"
                                            width="31"
                                            height="13"
                                            viewBox="0 0 31 13"
                                            fill="none"
                                            xmlns="http://www.w3.org/2000/svg">

                                            <path d="M24.1708 12.4741L30.4078 6.23712L24.1708 0.000120163L22.4036 1.76727L26.8527 6.23712L22.3828 10.707L24.1708 12.4741Z"
                                                fill="var(--color-button-one)"/>

                                            <path d="M0 5H27V7.2H0V5Z"
                                                fill="var(--color-button-one)"/>
                                        </svg>
                                    </a>
                                </div>
                            @endif
                        </div>
                    @endif

                    {{-- Conteúdo da direita --}}
                    @if ($hasTopics)
                        <div class="content-right mt-4 mt-lg-0 {{ $hasPilar ? 'col-12 col-lg-6' : 'col-12' }}">
                            <div class="row g-2 justify-content-start">

                                @foreach ($topics as $topic)
                                    <div class="{{ $hasPilar ? 'col-12 col-lg-4' : 'col-6 col-md-4 col-lg' }} mb-2">

                                        @if ($topic->link != null)
                                            <a href="{{ $topic->link }}"
                                            class="topic-item d-block"
                                            rel="noopener noreferrer">

                                                <img src="{{ asset('storage/' . $topic->path_image) }}"
                                                    alt="Tópico"
                                                    class="img-fluid d-block m-auto"
                                                    loading="lazy">
                                            </a>
                                        @else
                                            <div class="topic-item d-block">
                                                <img src="{{ asset('storage/' . $topic->path_image) }}"
                                                    alt="Tópico"
                                                    class="img-fluid d-block m-auto"
                                                    loading="lazy">
                                            </div>
                                        @endif

                                    </div>
                                @endforeach

                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </section>
    @endif

    @if (isset($statute))
        <section class="step-to-step">
            <div class="container py-5">
                <div class="row flex-column-reverse flex-lg-row">
                    <div class="left-content col-12 col-lg-5 z-3 d-flex flex-column align-items-center justify-content-center py-3 py-lg-5">
                        @if (isset($statute) && $statute->path_file <> null)                    
                            <div class="image about-image position-relative">
                                <div class="spa d-none d-lg-block"></div>
                                <img src="{{asset('storage/' . $statute->path_file)}}" alt="Passo a passo" class="w-100 step-image img-contain rounded-2">
                            </div>
                        @endif
                    </div>
                    @if (isset($statute) && $statute->title || isset($statute) && $statute->subtitle || isset($statute) && $statute->description || isset($statute) && $statute->btn_number)
                        <div class="right-content col-11 m-auto col-lg-7 py-2 py-lg-5 px-2 px-md-3 px-lg-4">
                            <span class="services-badge border rounded-pill text-secondary font-15 font-semibold py-2 px-3">
                                <svg class="me-1" width="6" height="6" viewBox="0 0 6 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M3 5.78362C4.65685 5.78362 6 4.48891 6 2.89181C6 1.29471 4.65685 0 3 0C1.34315 0 0 1.29471 0 2.89181C0 4.48891 1.34315 5.78362 3 5.78362Z" fill="var(--accent-color)"/>
                                </svg>

                                {{$statute->text_atend}}
                            </span>
                
                            <h2 class="about-title font-changa font-38 font-semibold primary-color mt-3 mb-0">
                                {{$statute->title}}
                            </h2>
                            <h3 class="font-changa font-38 font-semibold primary-color accent-color">{{$statute->subtitle}}</h3>

                            <div class="list-unstyled list-step mt-5 position-relative">
                                {!!$statute->description!!}
                            </div>
                            @if ($statute->btn_number <> null)                    
                                <div class="step-actions mt-5 d-flex justify-content-center justify-content-lg-start">
                                    <a href="{{$statute->btn_number}}"
                                    class="rounded-pill py-2 px-4 hover-zoom btn-hero font-changa bg-button-one color-button-one font-15 font-bold text-decoration-none"
                                    rel="noopener noreferrer">

                                        {{$statute->btn_title}}

                                        <svg class="ms-2"
                                            width="31"
                                            height="13"
                                            viewBox="0 0 31 13"
                                            fill="none"
                                            xmlns="http://www.w3.org/2000/svg">

                                            <path d="M24.1708 12.4741L30.4078 6.23712L24.1708 0.000120163L22.4036 1.76727L26.8527 6.23712L22.3828 10.707L24.1708 12.4741Z"
                                                fill="var(--color-button-one)"/>

                                            <path d="M0 5H27V7.2H0V5Z"
                                                fill="var(--color-button-one)"/>
                                        </svg>
                                    </a>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </section>
    @endif

    @if (isset($abouts) && $abouts->count())
        <section id="about" class="about bg-dark py-4 px-3">
            <div class="container-fluid position-relative">
                <svg class="position-absolute top-0 start-0" width="69" height="67" viewBox="0 0 69 67" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M8.75 56.6583V8.46143H58.75" stroke-width="3" stroke-linecap="round" stroke="#84CC16"/>
                <path d="M0.75 66.2977V0.75H68.75" stroke-width="1.5" stroke="#4D7C0F"/>
                <path d="M14.75 8.46143H8.75V14.245H14.75V8.46143Z" fill="#84CC16"/>
                </svg>
                @foreach($abouts as $about)                    
                    <div class="row col-11 col-lg-12 m-auto align-items-center justify-content-center py-4">

                        @if (isset($about->path_image) && $about->path_image <> null)                    
                            <!-- IMAGEM (fora do container) -->
                            <div class="col-12 col-lg-5 p-0 about-image" data-aos="fade-left" data-aos-delay="100">
                                <div class="rounded-2 overflow-hidden img-contain m-auto">
                                    <img
                                    src="{{asset('storage/'.$about->path_image)}}"
                                    alt="{{$about->title}}"
                                    class="img-fluid w-100"
                                    loading="lazy"
                                    >
                                </div>
                            </div>
                        @endif

                        <!-- TEXTO (dentro do container) -->
                        <div class="col-12 col-lg-7 mt-4 mt-lg-0 z-3 p-0" data-aos="fade-right" data-aos-delay="100">
                            <div class="col-12 col-lg-11 position-relative">
                                <h3 class="about-title font-changa font-38 font-bold mt-2 mt-lg-3 mb-3 text-white text-start">
                                    {{$about->title}}
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

                    </div>
                @endforeach
                <svg class="position-absolute bottom-0 end-0" width="69" height="67" viewBox="0 0 69 67" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M60 9.6394V57.8363H10" stroke-width="3" stroke-linecap="round" stroke="#84CC16"/>
                <path d="M68 0V65.5477H0" stroke-width="1.5" stroke="#4D7C0F"/>
                <path d="M60 52.0525H54V57.8361H60V52.0525Z" fill="#84CC16"/>
                </svg>
            </div>
        </section>
    @endif

    @if (isset($sessaoFaq) && $sessaoFaq <> null || isset($faqs) && $faqs->count())
        <section id="faq" class="faq-section pt-5 bg-grey-light pb-4 pb-lg-0 position-relative">
            <div class="faq-image absolute mt-4 position-absolute start-0 bottom-0 d-none d-lg-block">
                <img loading="lazy" src="{{asset('storage/' . $sessaoFaq->path_file)}}" alt="Entrega" class="img-fluid">
            </div>
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
                                    <a href="{{$sessaoFaq->btn_number}}" class="bg-button-one color-button-one rounded-pill btn-product py-1 py-lg-2 px-4 font-15 hover-zoom">
                                        {{$sessaoFaq->btn_title}}
                                        <svg class="ms-2" width="9" height="13" viewBox="0 0 9 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1.78794 12.474L8.02494 6.237L1.78794 -1.90735e-06L0.02079 1.76715L4.46985 6.237L0 10.7068L1.78794 12.474Z" fill="var(--color-button-one)"/>
                                        </svg>
                                    </a>
                                </div>
                            @endif     
                            
                            <div class="faq-image mt-4 d-block d-lg-none">
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
                                        <div class="accordion-header">
                                            <button class="accordion-button collapsed font-changa font-16 font-medium"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#faq-{{$faq->id}}">
                                                {{$faq->question}}
                                            </button>
                                        </div>
                                        <div id="faq-{{$faq->id}}" class="accordion-collapse collapse"
                                        data-bs-parent="#faqAccordion">
                                            <div class="accordion-body font-changa font-15 font-regular">
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
    
    <section id="contato" class="contact mb-0 mt-4">
        <div class="container py-5">
            <div class="row">
                @if (isset($contact))
                    <!-- Infos -->
                    <div class="col-12 col-lg-5">
                        <span class="services-badge border rounded-pill text-secondary font-15 font-semibold py-2 px-3">
                            <svg class="me-1" width="6" height="6" viewBox="0 0 6 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M3 5.78362C4.65685 5.78362 6 4.48891 6 2.89181C6 1.29471 4.65685 0 3 0C1.34315 0 0 1.29471 0 2.89181C0 4.48891 1.34315 5.78362 3 5.78362Z" fill="var(--accent-color)"></path>
                            </svg>

                            {{$contact->maps}}
                        </span>

                        @php
                            $words = explode(' ', trim($contact->name_section));
                            $lastWord = array_pop($words);
                        @endphp

                        <div class="d-flex gap-2 mt-2 mb-3">
                            <h3 class="faq-title font-changa font-40 font-bold">
                                {{ implode(' ', $words) }}                            
                            </h3>

                            <h4 class="font-changa font-40 font-bold" style="color: var(--accent-color);"> {{ $lastWord }}</h4>
                        </div>

                        <p class="faq-text color-grey font-changa font-16 font-regular text-center text-lg-start">
                            {{$contact->text}}
                        </p>
        
                        <ul class="list-unstyled">
                            <li class="d-flex mb-3">
                                <div class="me-3 text-success fs-4">
                                    <i class="bi bi-geo-alt-fill accent-color"></i>
                                </div>
                                <div>
                                    <span class="color-green font-changa font-16 font-semibold">Endereço</span>
                                    <p class="color-grey font-changa font-16 font-regular col-12 col-lg-10">
                                        {{$contact->address_one}}
                                    </p>
                                </div>
                            </li>
        
                            <li class="d-flex mb-3">
                                <div class="me-3 text-success fs-4">
                                    <i class="bi bi-telephone-fill accent-color"></i>
                                </div>
                                <div>
                                    <span class="color-green font-changa font-16 font-semibold">Telefone</span>
                                    <p class="color-grey font-changa font-16 font-regular">{{$contact->phone_one}}</p>
                                </div>
                            </li>
        
                            <li class="d-flex">
                                <div class="me-3 text-success fs-4">
                                    <i class="bi bi-envelope-fill accent-color"></i>
                                </div>
                                <div>
                                    <span class="color-green font-changa font-16 font-semibold">E-mail</span>
                                    <p class="color-grey font-changa font-16 font-regular">{{$contact->name_one}}</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                @endif
                
                <div class="col-lg-7">
                    <!-- Formulário e Mapa -->
                    <div class="row g-4 mt-4">
                        <div class="col-12">
                            <form id="contactForm">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <input type="text" required id="nome" name="name" class="poppins-regular font-15 text-color form-control" placeholder="Nome Completo">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="email" required id="email" name="email" class="poppins-regular font-15 text-color form-control" placeholder="E-mail">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" required id="phone" name="phone" class="poppins-regular font-15 text-color form-control" placeholder="Whatsapp para contato">
                                    </div>
                                    <div class="col-md-12">
                                        <input type="text" required id="subject" name="subject" class="poppins-regular font-15 text-color form-control" placeholder="Assunto">
                                    </div>
                                    <div class="col-md-12">
                                        <textarea id="text" required name="text" class="form-control poppins-regular font-15 text-color" rows="4" placeholder="Digite aqui...."></textarea>
                                    </div>
                                    <div class="col-12 d-flex align-items-center flex-wrap">
                                        <div class="form-check me-3">
                                            <input
                                                class="form-check-input"
                                                required
                                                id="term_privacy"
                                                name="term_privacy"
                                                type="checkbox"
                                                value="1">

                                            <label
                                                class="form-check-label small poppins-regular font-14 text-color"
                                                for="term_privacy">
                                                Concordo com a política de privacidade e autorizo a comunicações por e-mail e WhatsApp.
                                            </label>
                                        </div>
                                        <button type="submit" class="bt-hover border font-changa font-bold font-14 bg-button-one color-button-one rounded-pill ms-auto py-2 px-4 mt-4 hover-zoom">
                                            Garanta sua consultoria agora
                                            <svg class="ms-2"
                                            width="31"
                                            height="13"
                                            viewBox="0 0 31 13"
                                            fill="none"
                                            xmlns="http://www.w3.org/2000/svg">

                                            <path d="M24.1708 12.4741L30.4078 6.23712L24.1708 0.000120163L22.4036 1.76727L26.8527 6.23712L22.3828 10.707L24.1708 12.4741Z"
                                                fill="var(--color-button-one)"/>

                                            <path d="M0 5H27V7.2H0V5Z"
                                                fill="var(--color-button-one)"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>    

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            /*
            * ==========================================================
            * MÁSCARA DE TELEFONE
            * ==========================================================
            */

            const phoneInput = document.querySelector('#phone');

            if (phoneInput && !phoneInput.dataset.masked) {

                phoneInput.addEventListener('input', function (event) {

                    let value = event.target.value.replace(/\D/g, '');

                    // Permite apagar completamente
                    if (!value) {
                        event.target.value = '';
                        return;
                    }

                    // Limita a 11 dígitos
                    value = value.slice(0, 11);

                    let formatted = '';

                    if (value.length > 0) {
                        formatted = '(' + value.slice(0, 2);
                    }

                    if (value.length >= 3) {
                        formatted += ') ' + value.slice(2, 3);
                    }

                    if (value.length >= 4) {
                        formatted += ' ' + value.slice(3, 7);
                    }

                    if (value.length >= 8) {
                        formatted += '-' + value.slice(7, 11);
                    }

                    event.target.value = formatted;

                });

                phoneInput.dataset.masked = 'true';
            }

        });
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#contactForm').on('submit', function(e) {
                e.preventDefault();

                const formData = $(this).serialize();

                $.ajax({
                    url: '{{ route("send-contact") }}',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        if (typeof Swal !== 'undefined') {
                            Swal.fire({
                                title: 'Sucesso!',
                                text: response.message,
                                icon: 'success',
                                timer: 2000,
                                showConfirmButton: false,
                                heightAuto: false
                            });
                        }
                        $('#contactForm')[0].reset();
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;
                            let errorMessages = '';
                            for (let field in errors) {
                                errorMessages += errors[field][0] + '\n';
                            }

                            if (typeof Swal !== 'undefined') {
                                Swal.fire({
                                    title: 'Erro',
                                    text: errorMessages,
                                    icon: 'error',
                                    confirmButtonText: 'OK',
                                    heightAuto: false
                                });
                            }
                        } else {
                            if (typeof Swal !== 'undefined') {
                                Swal.fire({
                                    title: 'Erro',
                                    text: 'Ocorreu um erro ao enviar a mensagem. Por favor, tente novamente.',
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            }
                        }
                    }
                });
            });
        });
    </script>
@endsection
