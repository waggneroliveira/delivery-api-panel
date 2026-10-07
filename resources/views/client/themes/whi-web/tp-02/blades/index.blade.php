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
                                    <img src="{{ asset('storage/' . $slide->path_image) }}" alt="{{$slide->title}}" title="{{$slide->title}}">
                                </picture>
                            </div>

                            <!-- Conteúdo -->
                            <div class="hero-content mt-0 align-items-center">
                                <div class="container">
                                <div class="row">
                                    <div class="col-lg-6">

                                        <h1 class="hero-title font-changa font-50 font-bold mb-3">
                                            {{$slide->title}}
                                        </h1>

                                        <span class="hero-subtitle font-changa font-15 font-regular">
                                            {!!$slide->description!!}
                                        </span>


                                        <div class="hero-actions d-flex mt-4">
                                            @if ($slide->link <> null)                                    
                                                <a href="{{$slide->link}}" target="_blank" rel="noopener noreferrer" class="btn-one rounded-pill py-2 px-3 px-lg-4 btn-hero font-changa bg-button-one color-button-one font-15 font-medium text-decoration-none hover-zoom">
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

                            </div>
                        </div>
                    @endforeach

                </div>

                <!-- Paginação -->
                <div class="swiper-pagination news"></div>
            </div>
        </section>
    @endif
    @if ($topics->count() > 0)
        <section id="topic" class="topics py-3 py-lg-5">
            <div class="container">
                <div class="row g-4 justify-content-center mt-2 col-12 col-lg-10 m-auto">
                    @foreach ($topics as $topic)   
                        <div class="col-6 col-md-4 col-lg-2 topic-col m-auto">
                            <div class="d-flex justify-content-center align-items-center gap-2 mb-2 mb-lg-0">
                                <svg class="col-1" width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="7.5" cy="7.5" r="7.5" fill="#A93F08"/>
                                </svg>
    
                                <h2 class="font-changa font-20 font-semiBold text-center text-grey text-uppercase mb-0">{{$topic->title}}</h2>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
    @if (isset($abouts) && $abouts->count())
        <section id="about-us" class="about mt-4 pb-5">
            <div class="container p-0">
                @foreach($abouts as $about)                
                    <div class="row align-items-start justify-content-center">
                        @if (isset($about->path_image) && $about->path_image <> null)                    
                            <!-- IMAGEM (fora do container) -->
                            <div class="col-12 col-lg-5 p-0 about-image text-center">
                                <img
                                src="{{asset('storage/'.$about->path_image)}}"
                                alt="Sobre a Girollato"
                                class="img-fluid w-auto"
                                loading="lazy"
                                >
                            </div>
                        @endif
                        <!-- TEXTO (dentro do container) -->
                        <div class="col-12 col-lg-7 mt-4 mt-lg-0 z-3">
                            <div class="container position-relative">
                                <h2 class="about-title font-changa font-45 font-semiBold mb-3 text-grey text-start">
                                    {{$about->title}} <span class="accent-color">{{$about->subtitle}}</span>
                                </h2>

                                <!-- Conteúdo adicional opcional -->
                                <div class="description">
                                    {!! $about->text !!}
                                </div>

                                @if ($about->link <> null)                        
                                    <div class="btn-about my-4 d-flex justify-content-center justify-content-lg-start">
                                        <a href="{{$about->link}}" class="rounded-pill py-2 px-3 px-lg-5 font-changa bg-button-one color-button-one font-18 font-medium text-decoration-none hover-zoom" rel="noopener noreferrer">
                                            Faça parte agora
                                            <svg class="ms-2" width="9" height="13" viewBox="0 0 9 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1.78794 12.474L8.02494 6.237L1.78794 -1.90735e-06L0.02079 1.76715L4.46985 6.237L0 10.7068L1.78794 12.474Z" fill="var(--color-button-one)"/>
                                            </svg>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>                
                @endforeach
                <div class="linha-do-tempo">
                    <div class="row col-12 col-lg-11 m-auto me-lg-4">

                        <div class="col-lg-6">
                            @foreach($lineOfTimes as $index => $lineOfTime)
                                @if($index % 2 === 1)
                                    <div class="works-main-widget-area">
                                        
                                        <div class="space50 d-lg-block d-none"></div>
                                        <div class="space20 d-lg-none d-block"></div>

                                        <div class="text-end">
                                            <div class="icons">
                                                <img src="{{ asset('storage/' .$lineOfTime->path_image) }}" alt="{{ $lineOfTime->title }}" loading="lazy">
                                            </div>
                                        </div>

                                        <div class="space50 one d-lg-block d-none"></div>
                                        <div class="space20 d-lg-none d-block"></div>

                                        <div class="works8-boxarea">
                                            <a href="" class="font-changa font-18 text-grey font-semibold">
                                                {{ $lineOfTime->title }}
                                            </a>

                                            <div class="space16"></div>

                                            <p class="mb-0 h-scroll">{{ $lineOfTime->text }}</p>

                                            <h5>{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</h5>
                                        </div>

                                    </div>
                                @endif
                            @endforeach
                        </div>

                        <div class="col-lg-6">

                            <div class="space20 d-lg-none d-block"></div>

                            @foreach($lineOfTimes as $index => $lineOfTime)
                                @if($index % 2 === 0)
                                    <div class="works-main-widget-area2">

                                        <div class="works8-boxarea">
                                            <a href="" class="font-changa font-18 text-grey font-semibold">
                                                {{ $lineOfTime->title }}
                                            </a>

                                            <div class="space16"></div>

                                            <p class="mb-0 h-scroll">{{ $lineOfTime->text }}</p>

                                            <h5>{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</h5>
                                        </div>

                                        <div class="space50 d-lg-block d-none"></div>
                                        <div class="space20 d-lg-none d-block"></div>

                                        <div class="text-start">
                                            <div class="icons">
                                                <img src="{{ asset('storage/' .$lineOfTime->path_image) }}" alt="{{ $lineOfTime->title }}" loading="lazy">
                                            </div>
                                        </div>

                                        <div class="space50 d-lg-block d-none"></div>
                                        <div class="space20 d-lg-none d-block"></div>

                                    </div>
                                @endif
                            @endforeach

                        </div>

                    </div>
                </div>
            </div>
            <img src="{{asset('build/client/images/themes/whi-web/firula-linha-do-tempo.png')}}" alt="firula linha do tempo" class="position-absolute start-0 bottom-0" loading="lazy">
        </section>
    @endif

    @if($impactSections->isNotEmpty())
        <section id="pilar" class="section-container position-relative">

            <div class="container">

                @if ((isset($sections['pilar']) && $sections <> null))
                    <!-- Cabeçalho -->
                    <div class="row mb-5 align-items-center">
                        <div class="col-lg-6 mb-3 mb-lg-0">
                            <h2 class="font-changa font-45 font-bold text-grey">
                                {{$sections['pilar']->title}} <span class="accent-color">{{$sections['pilar']->tag}}</span> {{$sections['pilar']->subtitle}}
                            </h2>
                        </div>

                        <div class="col-lg-6">
                            <p class="font-changa font-20 font-medium text-grey mb-0">
                                {{$sections['pilar']->description}}
                            </p>
                        </div>
                    </div>
                @endif

                <!-- Navegação / Seletores -->
                <div class="row g-3 mb-4 col-12 col-lg-11">
                    @foreach($impactSections as $index => $impactSection)
                        <div class="col-md-4 pe-lg-0">
                            <button
                                type="button"
                                class="pillar-card {{ $index === 0 ? 'active' : '' }}"
                                onclick="changeTab('impact-section-{{ $impactSection->id }}', this)"
                            >
                                <div class="pillar-icon-box bg-accent-color">
                                    @if(!empty($impactSection->path_icon))
                                        <img
                                            src="{{ asset('storage/' . $impactSection->path_icon) }}"
                                            alt="{{ $impactSection->title }}"
                                            class="img-fluid"
                                            loading="lazy"
                                        >
                                    @else
                                        <i class="bi bi-bar-chart-fill"></i>
                                    @endif
                                </div>

                                <span class="pilar-title font-changa font-16 font-medium">
                                    {{ $impactSection->title }}
                                </span>
                            </button>
                        </div>
                    @endforeach
                </div>

                <!-- Conteúdos Dinâmicos -->
                <div class="tab-content-container col-12 col-lg-11">

                    @foreach($impactSections as $index => $impactSection)
                        <div
                            id="impact-section-{{ $impactSection->id }}"
                            class="row align-items-center g-4 tab-pane {{ $index === 0 ? 'active' : '' }}"
                        >

                            <div class="col-lg-6">

                                @if(!empty($impactSection->content_title))
                                    <h3 class="font-changa font-26 font-bold mb-2">
                                        {{ $impactSection->content_title }}
                                    </h3>
                                @endif

                                @if(!empty($impactSection->content_text))
                                    <p class="font-changa font-15 font-medium text-grey mb-4">
                                        {!! $impactSection->content_text !!}
                                    </p>
                                @endif

                                @if($impactSection->metrics->isNotEmpty())
                                    @foreach($impactSection->metrics as $metric)
                                        <div class="progress-container me-lg-4 mb-3">
                                            <div class="progress-label-group font-changa font-14 font-bold text-grey mb-1">
                                                <span>{{ $metric->title }}</span>
                                                <span>{{ rtrim(rtrim(number_format((float) str_replace(',', '.', $metric->value), 2, '.', ''), '0'), '.') }}%</span>
                                            </div>

                                            <div class="custom-progress">
                                                <div
                                                    class="custom-progress-bar"
                                                    style="width: {{ min((float) str_replace(',', '.', $metric->value), 100) }}%;"
                                                ></div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif

                            </div>

                            <div class="col-lg-6">
                                @if(!empty($impactSection->path_image))
                                    <img
                                        src="{{ asset('storage/' . $impactSection->path_image) }}"
                                        alt="{{ $impactSection->content_title ?: $impactSection->title }}"
                                        class="content-image"
                                        loading="lazy"
                                    >
                                @endif
                            </div>

                        </div>
                    @endforeach

                </div>

            </div>

            <img
                src="{{ asset('build/client/images/themes/whi-web/firula-pilares.png') }}"
                alt="firula pilares"
                class="d-none d-lg-block position-absolute end-0 top-0 w-auto"
                height="100%"
                loading="lazy"
            >

        </section>
    @endif

    <!-- Our Exhibitions Section Start -->
    <section id="our-exhibitions" class="our-exhibitions bg-secondary-color position-relative py-5">
        <div class="container">
            @if ((isset($sections['advantages_persona']) && $sections <> null))
                <div class="row section-row mb-5">
                    <div class="col-xl-12 text-center">
                        <!-- Section Title Start -->
                        <div class="section-title section-title-center">
                            <h2 class="text-anime-style-3 text-white fw-light fs-1" data-cursor="-opaque">
                                {{ $sections['advantages_persona']->title }}<br><span class="fw-bold">{{ $sections['advantages_persona']->subtitle }}</span>
                            </h2>
                            @if ($sections['advantages_persona']->link && $sections['advantages_persona']->btn_title)                                
                                <div class="btn-about my-4 d-flex justify-content-center">
                                    <a href="{{ $sections['advantages_persona']->link }}" target="_blank" rel="noopener noreferrer" class="rounded-pill py-2 px-3 px-lg-4 font-changa bg-button-one color-button-one font-18 font-medium text-decoration-none hover-zoom" rel="noopener noreferrer">
                                        {{ $sections['advantages_persona']->btn_title }}
                                        <svg class="ms-2" width="9" height="13" viewBox="0 0 9 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1.78794 12.474L8.02494 6.237L1.78794 -1.90735e-06L0.02079 1.76715L4.46985 6.237L0 10.7068L1.78794 12.474Z" fill="var(--color-button-one)"></path>
                                        </svg>
                                    </a>
                                </div>
                            @endif
                        </div>
                        <!-- Section Title End -->
                    </div>
                </div>
            @endif

            <!-- Swiper Carousel Start -->
            <div class="swiper exhibition-swiper col-11 col-lg-10">
                <div class="swiper-wrapper">
                    @foreach($benefitForPersonas as $index => $benefit)
                        <div class="swiper-slide">
                            <div class="exhibition-item {{ $index % 2 !== 0 ? 'reverse' : '' }}" data-wow-delay="{{ $index * 0.2 }}s">

                                @if($index % 2 !== 0)
                                    {{-- Imagem no topo --}}
                                    <div class="exhibition-item-image">
                                        <figure class="image-anime m-0">
                                            @if(!empty($benefit->path_image))
                                                <img src="{{ url('storage/' . $benefit->path_image) }}" alt="{{ $benefit->title }}" loading="lazy">
                                            @endif
                                        </figure>
                                    </div>
                                @endif

                                <div class="exhibition-item-header bg-secondary-color">
                                    <div class="icon-box mb-3">
                                        @if(!empty($benefit->path_icon))
                                            <img src="{{ url('storage/' . $benefit->path_icon) }}" alt="{{ $benefit->title }}" loading="lazy">
                                        @endif
                                    </div>

                                    <div class="exhibition-item-content">
                                        <h3>{{ $benefit->title }}</h3>
                                        <div>{!! $benefit->text !!}</div>
                                    </div>
                                </div>

                                @if($index % 2 === 0)
                                    {{-- Imagem embaixo --}}
                                    <div class="exhibition-item-image">
                                        <figure class="image-anime m-0">
                                            @if(!empty($benefit->path_image))
                                                <img src="{{ url('storage/' . $benefit->path_image) }}" alt="{{ $benefit->title }}" loading="lazy">
                                            @endif
                                        </figure>
                                    </div>
                                @endif

                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Navegação Swiper (Botões Circulares) -->
                <div class="swiper-navigation-wrapper mt-5 d-flex justify-content-center gap-3">
                    <div class="swiper-button-prev-custom">
                        <i class="bi bi-arrow-left"></i>
                    </div>
                    <div class="swiper-button-next-custom">
                        <i class="bi bi-arrow-right"></i>
                    </div>
                </div>
            </div>
            <!-- Swiper Carousel End -->
        </div>
        <img src="{{asset('build/client/images/themes/whi-web/firula-exhibition-1.png')}}" alt="firula exhibition" class="position-absolute start-0 top-0 w-auto" height="100%" loading="lazy">
    </section>
    <!-- Our Exhibitions Section End -->

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Garante que o objeto Swiper existe no escopo global
            if (typeof Swiper !== 'undefined') {
                const exhibitionSwiper = new Swiper('.exhibition-swiper', {
                    slidesPerView: 1,
                    spaceBetween: 24,
                    loop: true,
                    navigation: {
                        nextEl: '.swiper-button-next-custom',
                        prevEl: '.swiper-button-prev-custom',
                    },
                    breakpoints: {
                        768: {
                            slidesPerView: 2,
                        },
                        1200: {
                            slidesPerView: 3,
                        }
                    }
                });
            } else {
                console.error('Swiper JS não foi carregado corretamente.');
            }
        });
    </script>

    <!-- Enterprise Solutions Section Start -->
    <section id="solutions-section" class="solutions-section py-5">
        <div class="container">
            <svg class="firula-svg" width="810" height="54" viewBox="0 0 810 54" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g clip-path="url(#clip0_4758_2798)">
            <path d="M0.03125 25.1997H324.031" stroke="url(#paint0_linear_4758_2798)" stroke-width="1.8"/>
            <path opacity="0.6" d="M45.0312 18H306.031" stroke="url(#paint1_linear_4758_2798)" stroke-dasharray="4 4"/>
            <path d="M405.031 25.1997C405.031 -6.30029 369.031 -6.30029 369.031 25.1997C369.031 56.6997 405.031 56.6997 405.031 25.1997ZM405.031 25.1997C405.031 56.6997 441.031 56.6997 441.031 25.1997C441.031 -6.30029 405.031 -6.30029 405.031 25.1997Z" stroke="#E5A00D" stroke-width="2"/>
            <path d="M405.031 25.1997C405.031 7.19971 382.531 7.19971 382.531 25.1997C382.531 43.1997 405.031 43.1997 405.031 25.1997ZM405.031 25.1997C405.031 43.1997 427.531 43.1997 427.531 25.1997C427.531 7.19971 405.031 7.19971 405.031 25.1997Z" stroke="#C1440E" stroke-width="1.2"/>
            <path d="M369.032 28.8001C371.02 28.8001 372.632 27.1883 372.632 25.2001C372.632 23.2119 371.02 21.6001 369.032 21.6001C367.043 21.6001 365.432 23.2119 365.432 25.2001C365.432 27.1883 367.043 28.8001 369.032 28.8001Z" fill="#C1440E"/>
            <path d="M441.032 28.8001C443.02 28.8001 444.632 27.1883 444.632 25.2001C444.632 23.2119 443.02 21.6001 441.032 21.6001C439.043 21.6001 437.432 23.2119 437.432 25.2001C437.432 27.1883 439.043 28.8001 441.032 28.8001Z" fill="#124330"/>
            <path d="M405.032 3.5999C407.02 3.5999 408.632 1.98813 408.632 -9.77516e-05C408.632 -1.98832 407.02 -3.6001 405.032 -3.6001C403.043 -3.6001 401.432 -1.98832 401.432 -9.77516e-05C401.432 1.98813 403.043 3.5999 405.032 3.5999Z" fill="#E5A00D"/>
            <path d="M405.032 53.9998C407.02 53.9998 408.632 52.388 408.632 50.3998C408.632 48.4116 407.02 46.7998 405.032 46.7998C403.043 46.7998 401.432 48.4116 401.432 50.3998C401.432 52.388 403.043 53.9998 405.032 53.9998Z" fill="#231815"/>
            <path d="M486.031 25.1997H810.031" stroke="url(#paint2_linear_4758_2798)" stroke-width="1.8"/>
            <path opacity="0.6" d="M504.031 18H765.031" stroke="url(#paint3_linear_4758_2798)" stroke-dasharray="4 4"/>
            </g>
            <defs>
            <linearGradient id="paint0_linear_4758_2798" x1="0.03125" y1="25.1997" x2="324.031" y2="25.1997" gradientUnits="userSpaceOnUse">
            <stop stop-color="#C1440E" stop-opacity="0"/>
            <stop offset="0.5" stop-color="#C1440E" stop-opacity="0.8"/>
            <stop offset="1" stop-color="#E5A00D"/>
            </linearGradient>
            <linearGradient id="paint1_linear_4758_2798" x1="45.0312" y1="18" x2="306.031" y2="18" gradientUnits="userSpaceOnUse">
            <stop stop-color="#C1440E" stop-opacity="0"/>
            <stop offset="0.5" stop-color="#C1440E" stop-opacity="0.8"/>
            <stop offset="1" stop-color="#E5A00D"/>
            </linearGradient>
            <linearGradient id="paint2_linear_4758_2798" x1="486.031" y1="25.1997" x2="810.031" y2="25.1997" gradientUnits="userSpaceOnUse">
            <stop stop-color="#E5A00D"/>
            <stop offset="0.5" stop-color="#124330" stop-opacity="0.8"/>
            <stop offset="1" stop-color="#124330" stop-opacity="0"/>
            </linearGradient>
            <linearGradient id="paint3_linear_4758_2798" x1="504.031" y1="18" x2="765.031" y2="18" gradientUnits="userSpaceOnUse">
            <stop stop-color="#E5A00D"/>
            <stop offset="0.5" stop-color="#124330" stop-opacity="0.8"/>
            <stop offset="1" stop-color="#124330" stop-opacity="0"/>
            </linearGradient>
            <clipPath id="clip0_4758_2798">
            <rect width="810" height="54" fill="white"/>
            </clipPath>
            </defs>
            </svg>

            @if ((isset($sections['advantages_enterprise']) && $sections <> null))
                <!-- Section Header -->
                <div class="row align-items-end mt-3 mb-5">
                    <div class="col-12 col-lg-8">
                        <span class="font-changa font-40 font-medium accent-color">{{ $sections['advantages_enterprise']->title }}</span>
                        <h2 class="main-title font-changa font-40 font-bold mb-0 text-grey">{{ $sections['advantages_enterprise']->subtitle }}</h2>
                    </div>
                    @if ($sections['advantages_enterprise']->link <> null)                        
                        <div class="btn-about col-12 col-lg-4 mt-3 d-flex justify-content-center justify-content-lg-end">
                            <a href="{{ $sections['advantages_enterprise']->link }}" target="_blank" rel="noopener noreferrer" class="rounded-pill d-table m-auto ms-0 me-lg-0 py-2 px-3 px-lg-4 font-changa bg-button-one color-button-one font-18 font-medium text-decoration-none hover-zoom">
                                {{ $sections['advantages_enterprise']->btn_title }}
                                <svg class="ms-2" width="9" height="13" viewBox="0 0 9 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M1.78794 12.474L8.02494 6.237L1.78794 -1.90735e-06L0.02079 1.76715L4.46985 6.237L0 10.7068L1.78794 12.474Z" fill="var(--color-button-one)"></path>
                                </svg>
                            </a>
                        </div>
                    @endif
                </div>
            @endif

            <!-- Content Grid with Main Image & Swiper -->
            @php
                $enterpriseImage = $sections['advantages_enterprise']->path_image ?? null;
            @endphp

            <div class="row g-4">
                @if (!empty($enterpriseImage))
                    <!-- Left Banner Image -->
                    <div class="col-lg-4">
                        <div class="banner-card">
                            <img src="{{ asset('storage/' . $enterpriseImage) }}" alt="Parceria de negócios" class="img-fluid" loading="lazy">
                        </div>
                    </div>
                @endif

                <!-- Right Slider Area -->
                <div class="{{ !empty($enterpriseImage) ? 'col-lg-8' : 'col-lg-12' }}">
                    <div class="swiper solutions-swiper">
                        <div class="swiper-wrapper">
                            @foreach($benefitForEnterprises->chunk(6) as $benefits)
                                <div class="swiper-slide">
                                    <div class="row g-3">
                                        @foreach($benefits as $benefit)
                                            <div class="col-md-4">
                                                <div class="feature-card">
                                                    <div class="icon-box">
                                                        @if(!empty($benefit->path_icon))
                                                            <img src="{{ url('storage/' . $benefit->path_icon) }}" alt="{{ $benefit->title }}" loading="lazy">
                                                        @endif
                                                    </div>

                                                    <div class="font-changa font-16 font-bold">
                                                        {{ $benefit->title }}
                                                    </div>

                                                    <p class="font-changa font-15 font-medium">
                                                        {!! $benefit->text !!}
                                                    </p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Navigation Buttons -->
            <div class="row mt-4">
                <div class="col-12 d-flex justify-content-end gap-2">
                    <div class="swiper-button-prev-custom">
                        <i class="bi bi-chevron-left"></i>
                    </div>
                    <div class="swiper-button-next-custom">
                        <i class="bi bi-chevron-right"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Enterprise Solutions Section End -->

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof Swiper !== 'undefined') {
                const solutionsSwiper = new Swiper('.solutions-swiper', {
                    slidesPerView: 1,
                    spaceBetween: 20,
                    loop: true,
                    navigation: {
                        nextEl: '.swiper-button-next-custom',
                        prevEl: '.swiper-button-prev-custom',
                    },
                });
            }
        });
    </script>

    @if (!empty($sections['product']) || isset($products) && $products->count())
        <section class="products-section py-3 py-lg-5 bg-secondary-color">
            <div class="container">

                <!-- Header -->
                <div class="my-5 my-lg-4 d-flex justify-content-center justify-content-lg-between align-items-center flex-wrap">
                    <div class="col-12 col-lg-6">                      
                        <h3 class="about-title text-start font-changa d-flex justify-content-center justify-content-lg-start font-45 font-medium text-white mb-3 position-relative">
                            {{$sections['product']->title}}
                        </h3>
                    </div>

                      <!-- Botão -->
                    <div class="col-12 col-lg-6">
                        <div class="about-span primary-color font-20 font-changa justify-content-center justify-content-lg-start font-16 font-medium d-flex align-items-center mb-0">
                            {{$sections['product']->description}} <span class="line-firu"></span>
                        </div>
                    </div>
                </div>
                
                <!-- Produtos -->
                <div class="row g-4 products w-mobile mt-5 mb-5 mb-lg-0">
                    <!-- Produto -->
                    @foreach ($products as $product)                
                        <div class="col-6 col-sm-6 col-lg-4 col-xl-3 mb-2 mb-lg-3 product {{$product->category->slug}}">
                            <div class="product-card bg-white shadow-sm rounded-3 p-0 position-relative">
                                <div class="image position-relative mb-0">
                                    <img src="{{asset('storage/' . $product->path_image)}}" alt="{{$product->title}}" loading="lazy" loading="lazy">
                                </div>
                                <div class="px-2 px-lg-3 pt-2 pt-lg-3 pb-0">
                                    <div class="font-changa font-18 font-semibold text-dark text-start">{{$product->title}}</div>
                                    <p class="color-grey font-changa font-15 font-regular mb-0 text-start lh-sm border-bottom pb-2">{{substr(strip_tags($product->description), 0, 50)}}...</p>
                                </div>
                                <div class="row flex-wrap justify-content-center mt-2">
                                    <div class="btn-group m-auto m-lg-0 col-10 px-0 justify-content-center justify-content-lg-start" role="group">
                                        @php
                                            if (is_string($product->sizes)) {
                                                $sizes = json_decode($product->sizes, true);
                                            } else {
                                                $sizes = $product->sizes;
                                            }

                                            // Garante que seja array
                                            $sizes = is_array($sizes) ? $sizes : [];

                                            // Remove null, '', false etc
                                            $sizes = collect($sizes)
                                            ->filter()
                                            ->values()
                                            ->toArray();
                                        @endphp

                                        @if (!empty($sizes))
                                            @foreach($sizes as $size)
                                                @php
                                                    preg_match('/^(\d+(?:[.,]\d+)?)\s*(.*)$/u', trim($size), $matches);

                                                    $unit = strtolower(trim($matches[2] ?? ''));

                                                    $icon = match (true) {
                                                        str_contains($unit, 'hora') => 'bi bi-clock',
                                                        str_contains($unit, 'semana') => 'bi bi-calendar-week',
                                                        str_contains($unit, 'vídeo'), str_contains($unit, 'video') => 'bi bi-play-btn',
                                                        default => 'bi bi-info-circle',
                                                    };
                                                @endphp

                                                <button class="btn d-flex flex-column text-dark font-changa btn-sm m-auto p-0">
                                                    @if(isset($matches[1]))
                                                        <span class="fw-bold font-15">{{ $matches[1] }}</span>

                                                        @if(!empty($matches[2]))
                                                            <span class="font-12 size-unit">
                                                                <span class="d-none d-md-inline">{{ $matches[2] }}</span>
                                                                <i class="{{ $icon }} d-inline d-md-none"></i>
                                                            </span>
                                                        @endif
                                                    @else
                                                        {{ $size }}
                                                    @endif
                                                </button>
                                            @endforeach
                                        @else
                                            <i class="bi bi-exclamation-circle text-muted me-2"></i>
                                            <p class="text-dark text-center text-lg-start font-changa font-16 font-medium">
                                                Não disponível
                                            </p>
                                        @endif
                                    </div>
                                </div>
                                <div class="row justify-content-center mt-0">
                                    <div class="d-flex flex-wrap {{$product->name <> null || $product->function <> null || $product->path_file <> null ? 'justify-content-between' : 'justify-content-center'}}  align-items-center col-10 px-0 pb-2 pb-lg-3 mt-2 mt-lg-3">
                                        @if ($product->name <> null || $product->function <> null || $product->path_file <> null)
                                            <div class="user-card col-12 col-lg-7 mb-2 mb-lg-0">
                                                <div class="avatar">
                                                    @if ($product->path_file <> null)
                                                        <img src="{{asset('storage/' .$product->path_file)}}" alt="{{$product->name}}" loading="lazy">
                                                    @else                                                    
                                                        <svg width="35" height="35" viewBox="0 0 35 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M17.4107 34.8214C27.0264 34.8214 34.8214 27.0264 34.8214 17.4107C34.8214 7.79504 27.0264 0 17.4107 0C7.79504 0 0 7.79504 0 17.4107C0 27.0264 7.79504 34.8214 17.4107 34.8214Z" fill="#E5E7EB"/>
                                                        <path d="M17.41 17.4104C20.6152 17.4104 23.2136 14.812 23.2136 11.6068C23.2136 8.40157 20.6152 5.80322 17.41 5.80322C14.2048 5.80322 11.6064 8.40157 11.6064 11.6068C11.6064 14.812 14.2048 17.4104 17.41 17.4104Z" fill="#9CA3AF"/>
                                                        <path d="M5.80371 29.0176C5.80371 20.8926 11.6073 20.8926 17.4109 20.8926C23.2144 20.8926 29.018 20.8926 29.018 29.0176H5.80371Z" fill="#9CA3AF"/>
                                                        </svg>
                                                    @endif
                                                </div>
                                                @if ($product->name || $product->function)                                                
                                                    <div class="user-info text-start">
                                                        @if ($product->name <> null)                                                        
                                                            <h3 class="user-name font-changa font-10 font-bold text-dark mb-0">{{$product->name}}</h3>
                                                        @endif
                                                        @if ($product->function <> null)                                                        
                                                            <span class="user-role font-changa font-10 font-medium text-dark">{{$product->function}}</span>
                                                        @endif
                                                    </div>
                                                @endif
                                            </div>
                                        @endif
                      
                                        @php
                                            $isExternal = $product->link_type === 'external';

                                            $href = $isExternal
                                                ? $product->link
                                                : route('client.product', [
                                                    'category' => $product->category->slug,
                                                    'slug' => $product->slug
                                                ]);
                                        @endphp

                                        <a href="{{ $href }}" class="col-12 col-lg-4 col-xl-5" @if($isExternal) target="_blank" rel="noopener noreferrer" @endif>

                                            <span class="bg-button-one color-button-one rounded-2 py-2 px-2 btn-view font-changa font-11 font-medium col-12 col-lg-11 {{$product->name <> null || $product->function <> null || $product->path_file <> null ? 'm-auto me-lg-0' : 'm-auto'}} d-flex align-items-center justify-content-center mb-0">
                                                {{$product->btn_title}}
                                            </span>

                                        </a>
                                    </div>
                                      
                                </div>
                            </div>
                        </div>
                    @endforeach
                    
                    <div class="text-end mt-4 d-flex justify-content-center justify-content-lg-end align-items-center">
                        <a href="{{route('products')}}" class="btn-product bg-button-two color-button-two rounded-pill py-2 px-5 hover-zoom">
                            {{$sections['product']->btn_title}}
                            <svg class="ms-2" width="9" height="13" viewBox="0 0 9 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1.78794 12.474L8.02494 6.237L1.78794 -1.90735e-06L0.02079 1.76715L4.46985 6.237L0 10.7068L1.78794 12.474Z" fill="var(--color-button-one)"></path>
                            </svg>
                        </a>
                    </div>
                </div>               

            </div>
        </section>
    @endif

    @if (isset($letsgo))
        <section class="lets-go pt-5 pb-0 position-relative">
            <div class="container">
                <div class="row flex-column-reverse flex-md-row justify-content-between align-items-center">
                    @if ($letsgo->path_image <> null)                    
                        <div class="content-left text-center col-12 col-lg-3 mt-3 mt-lg-0">
                            <img src="{{asset('storage/' . $letsgo->path_image)}}" alt="Tamiles Alves" class="w-auto tamiles" height="470" loading="lazy">
                        </div>
                    @endif
                    <div class="content-left col-12 col-lg-8 mt-3 mt-lg-0">
                        <h3 class="about-title font-changa font-45 font-bold text-dark mb-3">
                            {{$letsgo->title}}
                        </h3>
                        <p class="color-grey font-changa font-16 font-regular text-center text-lg-start">{{$letsgo->description}}</p>
                        <div class="step-actions gap-2 d-flex mt-4 justify-content-center justify-content-lg-start">
                            @if (isset($contact) && $contact->link_tik_tok <> null)                                
                                <a href="{{ $contact->link_tik_tok }}" class="col-6 col-lg-4 text-center rounded-pill py-2 px-2 px-lg-4 hover-zoom btn-hero font-changa color-button-one bg-button-one font-16 font-medium text-decoration-none" rel="noopener noreferrer">
                                    Conectar no Linkedin
                                    <svg class="ms-1" width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12.7336 0H1.26641C0.567 0 0 0.567 0 1.26641V12.7336C0 13.433 0.567 14 1.26641 14H12.7336C13.433 14 14 13.433 14 12.7336V1.26641C14 0.567 13.433 0 12.7336 0ZM4.33219 12.0885C4.33219 12.2921 4.1672 12.4571 3.96365 12.4571H2.39484C2.19129 12.4571 2.0263 12.2921 2.0263 12.0885V5.51215C2.0263 5.3086 2.19129 5.14361 2.39484 5.14361H3.96365C4.1672 5.14361 4.33219 5.3086 4.33219 5.51215V12.0885ZM3.17925 4.52369C2.35614 4.52369 1.68887 3.85641 1.68887 3.03331C1.68887 2.2102 2.35614 1.54293 3.17925 1.54293C4.00235 1.54293 4.66962 2.2102 4.66962 3.03331C4.66962 3.85641 4.00239 4.52369 3.17925 4.52369ZM12.5307 12.1182C12.5307 12.3053 12.379 12.4571 12.1919 12.4571H10.5084C10.3213 12.4571 10.1696 12.3053 10.1696 12.1182V9.03352C10.1696 8.57335 10.3046 7.01704 8.967 7.01704C7.9295 7.01704 7.71906 8.08229 7.6768 8.56034V12.1182C7.6768 12.3053 7.52511 12.4571 7.33794 12.4571H5.70976C5.52263 12.4571 5.37091 12.3053 5.37091 12.1182V5.48247C5.37091 5.29534 5.52263 5.14361 5.70976 5.14361H7.33794C7.52507 5.14361 7.6768 5.29534 7.6768 5.48247V6.05621C8.06151 5.47887 8.63324 5.03326 9.85054 5.03326C12.5462 5.03326 12.5307 7.55164 12.5307 8.93537V12.1182Z" fill="var(--color-button-one)"/>
                                    </svg>
                                </a>
                            @endif
                            @if (isset($contact) && $contact->link_insta <> null)                                
                                <a href="{{ $contact->link_insta }}" class="col-6 col-lg-4 text-center rounded-pill py-2 px-2 px-lg-4 hover-zoom btn-hero font-changa color-button-one bg-button-one font-16 font-medium text-decoration-none" rel="noopener noreferrer">
                                    Seguir no Instagram
                                    <svg class="ms-1" width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9.75 0.75H3.75C2.09315 0.75 0.75 2.09315 0.75 3.75V9.75C0.75 11.4069 2.09315 12.75 3.75 12.75H9.75C11.4069 12.75 12.75 11.4069 12.75 9.75V3.75C12.75 2.09315 11.4069 0.75 9.75 0.75Z" stroke="var(--color-button-one)" stroke-width="1.5"/>
                                    <path d="M6.75 9.25C8.13071 9.25 9.25 8.13071 9.25 6.75C9.25 5.36929 8.13071 4.25 6.75 4.25C5.36929 4.25 4.25 5.36929 4.25 6.75C4.25 8.13071 5.36929 9.25 6.75 9.25Z" stroke="var(--color-button-one)" stroke-width="1.5"/>
                                    <path d="M10.25 4C10.6642 4 11 3.66421 11 3.25C11 2.83579 10.6642 2.5 10.25 2.5C9.83579 2.5 9.5 2.83579 9.5 3.25C9.5 3.66421 9.83579 4 10.25 4Z" fill="var(--color-button-one)"/>
                                    </svg>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <img src="{{asset('build/client/images/themes/whi-web/firula-letsgo.png')}}" alt="firula letsgo" class="position-absolute bottom-0 end-0" loading="lazy">
        </section>
    @endif

    @if (isset($directions) && $directions->count())
        <section id="team-section" class="team-section py-5">
            <div class="container z-3">
                <div class="row g-4 w-mobile">
                    <!-- Card -->
                    @foreach ($directions as $representative)    
                        <div class="col-6 col-sm-6 col-lg-4 col-xl-3">
                            <div class="team-card position-relative">
                                <div class="team-image bg-white">
                                    <img src="{{asset('storage/' . $representative->path_image)}}" alt="{{$representative->title}}" loading="lazy">
                                </div>
                                <div class="team-body shadow-md rounded-2 text-center position-absolute col-11 z-3 bg-white py-2 py-lg-3 px-1 px-lg-3 d-flex justify-content-between align-items-center">
                                    <div class="d-flex justify-content-start align-items-start flex-column">
                                        <div class="mb-1 font-changa font-semibold font-18 color-green">{{$representative->title}}</div>
                                        <small class="color-grey text-start font-changa font-13 font-regular d-block mb-0">{{$representative->function}}</small>
                                    </div>
                                    <!-- Botão para disparar o Modal -->
                                    <button type="button"
                                        class="color-button-one bg-button-one font-changa font-14 font-regular rounded-2 d-flex justify-content-center align-items-center border-0"
                                        style="width: 30px; height: 30px; cursor: pointer;"
                                        data-bs-toggle="modal"
                                        data-bs-target="#representativeModal{{ $representative->id }}"
                                        aria-label="Visualizar representante">

                                        <i class="bi bi-eye" aria-hidden="true"></i>
                                    </button>                        
                                </div>
                            </div>
                        </div>

                        <!-- Modal com o Layout da Imagem -->
                        <div class="modal fade" id="representativeModal{{$representative->id}}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content border-0 p-4 p-md-5 position-relative" style="background-color: #EAE3D9; border-radius: 16px;">
                                    
                                    <!-- Botão Fechar -->
                                    <button type="button" class="btn-close position-absolute top-0 end-0 m-4 shadow-none" style="z-index: 99;" data-bs-dismiss="modal" aria-label="Close"></button>

                                    <div class="modal-body p-0">
                                        <div class="row align-items-start g-4 mt-0">
                                            <!-- Imagem com cantos arredondados -->
                                            <div class="col-12 col-md-5">
                                                <img src="{{asset('storage/' . $representative->path_image)}}" 
                                                    alt="{{$representative->title}}" 
                                                    class="img-fluid w-100 object-fit-contain" 
                                                    style="border-radius: 24px; max-height: 300px;"
                                                    loading="lazy">
                                            </div>

                                            <!-- Conteúdo com Nome, Cargo, Redes e Biografia -->
                                            <div class="col-12 col-md-7 text-start">
                                                <div class="d-flex justify-content-between align-items-baseline mb-0">
                                                    <h2 class="fw-bold mb-0 text-dark font-28">{{$representative->title}}</h2>
                                                    
                                                    <!-- Redes Sociais (Ajuste os links conforme seus dados) -->
                                                    <div class="d-flex gap-2 color-dark fs-5">
                                                        @if ($representative->instagram <> null)                                                            
                                                            <a href="{{$representative->instagram}}" class="text-dark"><i class="bi bi-instagram"></i></a>
                                                        @endif
                                                        @if ($representative->linkedin <> null)                                                            
                                                            <a href="{{$representative->linkedin}}" class="text-dark"><i class="bi bi-linkedin"></i></a>
                                                        @endif
                                                        @if ($representative->facebook <> null)                                                            
                                                            <a href="{{$representative->facebook}}" class="text-dark"><i class="bi bi-facebook"></i></a>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="text-muted font-15 mb-3">{{$representative->function}}</div>

                                                <div class="text-secondary lh-base mb-0" style="font-size: 0.95rem;">
                                                    {!! $representative->description !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if (isset($depoiments) && $depoiments->count())
        <section id="depoiment" class="depoiment py-5 position-relative bg-light-custom overflow-hidden">
            <div class="container-fluid pe-0">
                <div class="row align-items-center justify-content-end me-0 flex-nowrap">
                    <!-- Texto Vertical (Left side) -->
                    <div class="col-2 d-none d-lg-flex justify-content-center align-items-xenter">
                        <div class="vertical-text-wrapper">
                            <span class="vertical-text">feedback</span>
                        </div>
                    </div>

                    <!-- Conteúdo Principal -->
                    <div class="col-12 col-lg-10 ps-3 pe-0">
                        @if ((isset($sections['testimonial']) && $sections <> null))
                            <div class="mb-4 ps-0 ps-md-0">
                                <h2 class="text-grey font-change font-45 font-bold mb-1">{{$sections['testimonial']->title}}</h2>
                                <h2 class="accent-color font-change font-45 font-bold">{{$sections['testimonial']->subtitle}}</h2>
                            </div>
                        @endif

                        <div class="swiper testimonial-swiper">
                            <div class="swiper-wrapper">

                                @foreach ($depoiments as $depoiment)                    
                                    <div class="swiper-slide">
                                        <div class="testimonial-card p-4 rounded-3 bg-white position-relative shadow-md">
                                            <!-- Ícone de Aspas (Top Right) -->
                                            <div class="quote-icon position-absolute top-0 end-0 m-4">
                                                <div class="quote-badge">
                                                    <i class="bi bi-quote"></i> <!-- Ou <img> com seu ícone -->
                                                </div>
                                            </div>

                                            <!-- Autor / Informações -->
                                            <div class="author mb-3">
                                                <div class="author-name font-bold mb-1">{{ $depoiment->name }}</div>
                                                <span class="author-role d-block text-muted font-14">{{ $depoiment->function }}</span>
                                            </div>

                                            <!-- Texto do Depoimento -->
                                            <div class="text color-grey font-14 text-start">
                                                {!! $depoiment->text !!}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </div>

                            <!-- Navigation Buttons -->
                            <div class="row mt-4">
                                <div class="col-11 d-flex justify-content-end gap-2 pe-4">
                                    <div class="swiper-button-prev-custom">
                                        <i class="bi bi-chevron-left"></i>
                                    </div>
                                    <div class="swiper-button-next-custom">
                                        <i class="bi bi-chevron-right"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            new Swiper('.testimonial-swiper', {
                loop: true,
                spaceBetween: 20,
                navigation: {
                    nextEl: '.swiper-button-next-custom',
                    prevEl: '.swiper-button-prev-custom',
                },
                breakpoints: {
                    0: {
                        slidesPerView: 1.1,
                    },
                    768: {
                        slidesPerView: 2.1,
                    },
                    1200: {
                        slidesPerView: 3.2,
                    }
                }
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
        new Swiper('.blog-swiper', {
            spaceBetween: 24,
            pagination: {
            el: '.swiper-pagination-blog',
            clickable: true,
            },
            breakpoints: {
            0: {
                slidesPerView: 1.3,
            },
            576: {
                slidesPerView: 2,
            },
            992: {
                slidesPerView: 4,
                allowTouchMove: false,
            }
            }
        });
        });


    </script>

    @if (!empty($partners))
        <section class="partners-section py-5 bg-white my-3">
            <div class="container mb-4">
                @if ((isset($sections['partners']) && $sections <> null))
                    <!-- Cabeçalho (Número + Textos) -->
                    <div class="d-flex align-items-center justify-content-center flex-wrap gap-3 text-center text-md-start">
                        <div class="counter-badge d-flex align-items-center">
                            <span class="number-outlined font-change font-86 font-regular">{{$sections['partners']->tag}}</span>
                            <span class="plus-sign">+</span>
                        </div>
                        <div class="text-content">
                            <p class="subtitle-text mb-0 font-change font-30 font-regular">{{$sections['partners']->title}}</p>
                            <h3 class="title-bold mb-0 font-change font-38 font-semibold">{{$sections['partners']->subtitle}}</h3>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Carrossel Infinito (Estilo Timeline Continuous) -->
            <div class="swiper partners-swiper overflow-hidden mt-5">
                <div class="swiper-wrapper ease-linear-wrapper">
                    @foreach ($partners as $partner)
                        <div class="swiper-slide d-flex justify-content-center align-items-center">
                            <div class="partner-card border-0 d-flex justify-content-center align-items-center">
                                @if (isset($partner->path_image) && $partner->path_image <> null)
                                    <img src="{{ asset('storage/'.$partner->path_image) }}" alt="Logo do parceiro" loading="lazy" class="partner-logo"/>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            new Swiper('.partners-swiper', {
                loop: true,
                loopAdditionalSlides: 5, // Duplica os slides na fila para não dar "tranco" ou parar
                freeMode: {
                    enabled: true,
                    momentum: false,
                },
                slidesPerView: 3,
                spaceBetween: 30,
                speed: 4000, // Velocidade do deslizamento
                autoplay: {
                    delay: 0,
                    disableOnInteraction: true, // Para o carrossel assim que o usuário clicar/interagir
                    pauseOnMouseEnter: false,   // Altere para true se quiser que pare apenas ao passar o mouse
                },
                breakpoints: {
                    576: {
                        slidesPerView: 4,
                        spaceBetween: 40,
                    },
                    768: {
                        slidesPerView: 6,
                        spaceBetween: 50,
                    },
                    1200: {
                        slidesPerView: 8,
                        spaceBetween: 60,
                    }
                }
            });
        });
    </script>

    <section id="contact" class="contact my-0 bg-white">
        <div class="container py-5">
            <div class="row">
                @if (isset($contact))
                    <!-- Infos -->
                    <div class="col-12 col-lg-5">
                        <h2 class="faq-title font-changa font-45 font-bold text-grey mt-2 mb-3 text-start">{{$contact->name_section}} <span class="accent-color">{{$contact->link_x}}</span></h2>
                        <p class="col-12 col-lg-8 faq-text color-grey font-changa font-16 font-regular text-start">
                            {{$contact->text}}
                        </p>
        
                        <ul class="list-unstyled">        
                            <li class="d-flex mb-3 align-items-center">
                                <div class="d-flex justify-content-center align-items-center me-3 text-success font-14 bg-accent-color rounded-pill" style="width: 30px; height: 30px;">
                                    <i class="bi bi-telephone-fill text-white"></i>
                                </div>
                                <div>
                                    <p class="color-grey font-changa font-16 font-regular mb-0">{{$contact->phone_one}}</p>
                                </div>
                            </li>
        
                            <li class="d-flex align-items-center">
                                <div class="d-flex justify-content-center align-items-center me-3 text-success font-14 bg-accent-color rounded-pill" style="width: 30px; height: 30px;">
                                    <i class="bi bi-envelope-fill text-white"></i>
                                </div>
                                <div>
                                    <p class="color-grey font-changa font-16 font-regular mb-0">{{$contact->name_one}}</p>
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
                                    <div class="col-md-12 mt-0">
                                        <input type="text" required id="nome" name="name" class="poppins-regular font-15 text-color form-control" placeholder="Nome Completo">
                                    </div>
                                    <div class="col-md-5">
                                        <input type="email" required id="email" name="email" class="poppins-regular font-15 text-color form-control" placeholder="E-mail">
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" required id="phone_whatsapp" name="phone" class="poppins-regular font-15 text-color form-control" placeholder="Whatsapp">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="subject" class="visually-hidden">
                                            Assunto
                                        </label>

                                        <select
                                            required
                                            id="subject"
                                            name="subject"
                                            class="poppins-regular font-15 text-color form-select"
                                        >
                                            <option value="" selected disabled>Selecione uma opção</option>
                                            <option value="pessoa-fisica">Pessoa Física</option>
                                            <option value="empresa">Empresa</option>
                                        </select>
                                    </div>
                                    <div class="col-md-12">
                                        <textarea id="text" required name="text" class="form-control poppins-regular font-15 text-color" rows="4" placeholder="Digite aqui...."></textarea>
                                    </div>
                                    <div class="col-12 d-flex align-items-center flex-wrap">
                                        <div class="form-check me-3">
                                            <input class="form-check-input" required id="term_privacy" name="term_privacy" type="checkbox" value="1">
                                            <label class="form-check-label small poppins-regular font-14 text-color" for="term_privacy">
                                                Aceito os termos descritos na Política de Privacidade
                                            </label>
                                        </div>
                                        <button type="submit" class="bt-hover border font-changa font-15 bg-button-one color-button-one rounded-pill ms-auto py-2 px-5 hover-zoom">
                                            Enviar
                                            <svg class="ms-2" width="9" height="13" viewBox="0 0 9 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1.78794 12.474L8.02494 6.237L1.78794 -1.90735e-06L0.02079 1.76715L4.46985 6.237L0 10.7068L1.78794 12.474Z" fill="var(--color-button-one)"></path>
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
                                showConfirmButton: false
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
                                    confirmButtonText: 'OK'
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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const phoneInput = document.getElementById('phone_whatsapp');

            // 1. Verificação de segurança (se o ID não existir, encerra)
            if (!phoneInput) return;

            // 2. Aplicação da máscara dinâmica durante a digitação
            phoneInput.addEventListener('input', function (e) {
                let value = e.target.value.replace(/\D/g, ''); // Remove tudo que não é número

                if (value.length > 11) {
                    value = value.slice(0, 11); // Limita a 11 dígitos
                }

                // Formatação em tempo real
                if (value.length > 10) {
                    // (11) 99999-9999
                    value = value.replace(/^(\d{2})(\d{5})(\d{4})$/, '($1) $2-$3');
                } else if (value.length > 6) {
                    // (11) 9999-9999 (ou em digitação)
                    value = value.replace(/^(\d{2})(\d{4,5})(\d{0,4})$/, '($1) $2-$3');
                } else if (value.length > 2) {
                    // (11) 9999...
                    value = value.replace(/^(\d{2})(\d{0,5})$/, '($1) $2');
                } else if (value.length > 0) {
                    // (11...
                    value = value.replace(/^(\d{0,2})$/, '($1');
                }

                e.target.value = value;
            });

            // 3. Validação do campo
            phoneInput.addEventListener('blur', function (e) {
                const rawDigits = e.target.value.replace(/\D/g, '');

                // Zera o erro customizado para não travar o formulário
                e.target.setCustomValidity('');

                // Se estiver preenchido mas incompleto (menos de 10 dígitos)
                if (rawDigits.length > 0 && rawDigits.length < 10) {
                    e.target.classList.add('is-invalid');
                    e.target.setCustomValidity('Digite um número de WhatsApp válido com DDD.');
                    e.target.reportValidity(); // Dispara o balão nativo do HTML5
                } else {
                    e.target.classList.remove('is-invalid');
                }
            });
        });
    </script>

@endsection
