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
                            <div class="hero-content mt-5 mt-lg-0">
                                <div class="container">
                                <div class="row">
                                    <div class="col-lg-6">

                                        <span class="hero-subtitle font-changa font-15 font-regular">
                                            {!!$slide->description!!}
                                        </span>

                                        <h1 class="hero-title font-changa font-40 font-bold">
                                            {{$slide->title}}
                                        </h1>

                                        <div class="hero-actions d-flex">
                                            @if ($slide->link <> null)                                    
                                                <a href="{{$slide->link}}" target="_blank" rel="noopener noreferrer" class="btn-one rounded-2 py-2 px-3 px-lg-5 btn-hero font-changa bg-button-one color-button-one font-15 font-medium text-decoration-none hover-zoom">
                                                    {{$slide->btn_title}}
                                                    <svg width="11" height="9" viewBox="0 0 11 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M5.77699 8.90909L5.01136 8.15341L8.16335 5.00142H0V3.90767H8.16335L5.01136 0.765624L5.77699 -7.15256e-07L10.2315 4.45454L5.77699 8.90909Z" fill="var(--color-button-one)"/>
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

    @if ($benefitTopics->count())
        <section id="stats-section" class="stats-section position-relative w-100 d-flex">

            <div class="container">
                <div class="d-flex flex-wrap text-center align-items-center g-4 py-3">
                    @foreach ($benefitTopics as $parametro)                
                        <div class="col-6 col-md-3 mt-0">
                            <div class="stat-item">
                                <div class="stat-number primary-color font-changa font-bold font-44 mb-0" data-target="{{$parametro->number}}">0</div>
                                <p class="font-changa font-bold font-16 secondary-color">{{$parametro->title}}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if($abouts->count())
        <section id="about" class="about py-3 py-lg-5">
            <div class="container">
                <div class="row align-items-center justify-content-between">
                    @foreach($abouts as $about)
                        @if (isset($about->path_image) && $about->path_image <> null)                    
                            <!-- IMAGEM (fora do container) -->
                            <div class="col-12 col-lg-5 p-0 about-image text-center text-lg-start">
                                <img
                                src="{{asset('storage/'.$about->path_image)}}"
                                alt="Sobre a Girollato"
                                class="img-fluid w-auto rounded-5"
                                loading="lazy"
                                >
                            </div>
                        @endif
                        
                        <!-- TEXTO (dentro do container) -->
                        <div class="col-12 col-lg-7 mt-4 mt-lg-0 z-3">
                            <div class="position-relative">

                                <h2 class="about-span primary-color font-changa font-16 font-medium d-flex align-items-center mb-0">
                                    Sobre Nós <span class="line-firu"></span>
                                </h2>

                                <h3 class="about-title font-changa font-50 font-bold mb-3 text-black text-start">
                                    {{$about->title}}
                                </h3>

                                <!-- Conteúdo adicional opcional -->
                                <div class="description">
                                    {!! $about->text !!}
                                </div>

                                @if ($about->link <> null)                        
                                    <div class="btn-about my-4 d-flex justify-content-center justify-content-lg-start">
                                        <a href="{{$about->link}}" class="rounded-2 py-3 px-3 px-lg-5 font-changa bg-button-two color-button-two font-18 font-medium text-decoration-none hover-zoom" rel="noopener noreferrer">
                                            Comprar agora
                                            
                                            <svg class="ms-2" width="11" height="9" viewBox="0 0 11 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M5.77699 8.90909L5.01136 8.15341L8.16335 5.00142H0V3.90767H8.16335L5.01136 0.765624L5.77699 -7.15256e-07L10.2315 4.45454L5.77699 8.90909Z" fill="var(--color-button-two)"/>
                                            </svg>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>                        
                    @endforeach
                </div>
            </div>
        </section>
    @endif    

    @if (!empty($sections['product']) || isset($products) && $products->count())
        <section class="products-section py-3 py-lg-5 bg-secondary-color">
            <div class="container">

                <!-- Header -->
                <div class="my-5 my-lg-4 d-flex justify-content-center justify-content-lg-between align-items-center flex-wrap">
                    <div class="col-10">
                        <div class="about-span primary-color font-changa justify-content-center justify-content-lg-start font-16 font-medium d-flex align-items-center mb-0">
                            {{$sections['product']->subtitle}} <span class="line-firu"></span>
                        </div>
    
                        <h3 class="about-title text-start font-changa d-flex justify-content-center justify-content-lg-start font-50 font-bold text-white mb-3 position-relative">
                            {{$sections['product']->title}}
                        </h3>
                    </div>

                      <!-- Botão -->
                    <div class="text-end mt-0 d-flex justify-content-center justify-content-lg-end align-items-center">
                        <a href="{{route('products')}}" class="btn-product bg-button-two color-button-two rounded-2 py-2 px-4 hover-zoom">
                            {{$sections['product']->btn_title}}
                            <svg class="ms-2" width="11" height="9" viewBox="0 0 11 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5.77699 8.90909L5.01136 8.15341L8.16335 5.00142H0V3.90767H8.16335L5.01136 0.765624L5.77699 -7.15256e-07L10.2315 4.45454L5.77699 8.90909Z" fill="var(--color-button-two)"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Filtros -->
                @if (isset($productCategories) && $productCategories->count())                    
                    <div class="d-flex justify-content-center justify-content-lg-start gap-2 mb-5 flex-wrap">
                        <button class="btn-filter font-changa font-18 font-medium primary-color px-4 px-lg-5 py-1 active" data-filter="all">Todos</button>
                        @foreach ($productCategories as $productCategory)
                            <button class="btn-filter font-changa font-18 font-medium primary-color px-4 px-lg-5 py-1" data-filter="{{$productCategory->slug}}">{{$productCategory->title}}</button>
                        @endforeach
                    </div>
                @endif
                
                <!-- Produtos -->
                <div class="row g-4 products mb-5">
                    <!-- Produto -->
                    @foreach ($products as $product)                
                        <div class="col-6 col-sm-6 col-lg-3 mb-4 product {{$product->category->slug}}">
                            <div class="product-card bg-accent-color shadow-sm rounded-3 p-2 p-lg-3 position-relative">
                                <div class="image position-relative mb-0">
                                    <img src="{{asset('storage/' . $product->path_image)}}" alt="{{$product->title}}" loading="lazy">
                                </div>
                                <div class="pt-3 pb-3 pb-lg-4">
                                    <h6 class="font-changa font-18 font-semibold text-dark">{{$product->title}}</h6>
                                    <p class="color-grey font-changa font-16 font-regular mb-0">{{substr(strip_tags($product->description), 0, 70)}}</p>
                                </div>
                                <a href="{{ route('client.product', ['category' => $product->category->slug, 'slug' => $product->slug]) }}" class="col-12">
                                    <span class="bg-button-two color-button-two rounded-2 py-2 py-lg-3 px-2 px-lg-3 btn-view font-changa font-16 font-medium col-9 col-lg-8 d-flex align-items-center justify-content-center">
                                        Comprar agora
                                        <svg class="ms-2" width="11" height="9" viewBox="0 0 11 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5.77699 8.90909L5.01136 8.15341L8.16335 5.00142H0V3.90767H8.16335L5.01136 0.765624L5.77699 -7.15256e-07L10.2315 4.45454L5.77699 8.90909Z" fill="var(--color-button-two)"/>
                                        </svg>
                                    </span>                                    
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>               

            </div>
        </section>
    @endif

    @if (isset($sessaoFaq) && $sessaoFaq <> null || isset($faqs) && $faqs->count())
        <section id="faq" class="faq-section py-5 bg-grey-light">
            <div class="container">
                <div class="row align-items-start flex-column-reverse flex-lg-row flex-wrap g-5">
                    @if (isset($faqs) && $faqs->count())
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
                    @endif

                    @if (isset($sessaoFaq) && $sessaoFaq <> null)
                        <!-- COLUNA ESQUERDA -->
                        <div class="col-lg-5">
                            <!-- Header -->
                            <div class="mb-4">
                                <div class="about-span primary-color font-changa font-16 justify-content-center justify-content-lg-start font-medium d-flex align-items-center mb-0">
                                    {{$sessaoFaq->subtitle}} <span class="line-firu"></span>
                                </div>

                                <h3 class="faq-title font-changa font-40 font-semiBold text-dark mb-3">
                                    {{$sessaoFaq->title}}
                                </h3>
                            </div>

                            <div class="faq-text color-grey font-changa font-16 font-regular text-center text-lg-start">
                                {!!$sessaoFaq->description!!}
                            </div>

                            @if ($sessaoFaq->btn_title <> null && $sessaoFaq->btn_number <> null)                
                                <div class="d-flex justify-content-center justify-content-lg-start align-items-center">
                                    <a href="{{$sessaoFaq->btn_number}}" class="bg-button-two color-button-two btn-product rounded-2 py-3 px-4 mt-4 text-white hover-zoom">
                                        {{$sessaoFaq->btn_title}}
                                        <svg class="ms-2" width="11" height="9" viewBox="0 0 11 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5.77699 8.90909L5.01136 8.15341L8.16335 5.00142H0V3.90767H8.16335L5.01136 0.765624L5.77699 -7.15256e-07L10.2315 4.45454L5.77699 8.90909Z" fill="var(--color-button-two)"/>
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

    @if (isset($videos) && $videos->count())
        <section class="video-section">
            @foreach($videos as $video)
                {{-- Garante a execução apenas na primeira iteração --}}
                @if($loop->first)
                    <div class="video-container position-relative" 
                        data-video="{{ $video->link }}">
                        
                        <img
                            src="{{ $video->thumb }}" 
                            alt="Vídeo institucional"
                            class="video-thumb"
                            loading="eager"
                        >

                        <button class="video-play-btn" aria-label="Reproduzir vídeo"></button>
                    </div>
                @endif
            @endforeach
        </section>
    @endif

    @if ((isset($sections['testimonial']) && $sections <> null) || isset($depoiments) && $depoiments->count())
        <section id="depoiment" class="depoiment py-5 position-relative bg-light">
            <div class="container z-3 position-relative">
                <div class="about-span primary-color font-changa font-16 font-medium d-flex justify-content-center align-items-center mb-0">
                    {{$sections['testimonial']->subtitle}} <span class="line-firu"></span>
                </div>

                <h3 class="about-title font-changa font-50 font-bold text-dark mb-3 text-center">
                    {{ $sections['testimonial']->title }}
                </h3>
            </div>
            <div class="container mt-5">
                <div class="swiper testimonial-swiper">
                    <div class="swiper-wrapper">

                        <!-- Slide -->
                        @foreach ($depoiments as $depoiment)                    
                            <div class="swiper-slide">
                                <div class="testimonial-card p-3 p-lg-4">
                                    @if ($depoiment->path_image <> null)                                
                                        <div class="icon mb-3">
                                            <img src="{{asset('storage/' . $depoiment->path_image)}}" alt="Depoimento-{{$depoiment->id}}" loading="lazy">
                                        </div>
                                    @endif

                                    <div class="text color-grey font-changa font-16 font-regular text-center">
                                        {!!$depoiment->text!!}
                                    </div>

                                    <div class="author text-center">
                                        <h5 class="text-dark font-changa font-18 font-medium mb-0 mt-3">{{$depoiment->name}}</h5>
                                        <span class="color-grey font-changa font-16 font-regular">{{$depoiment->function}}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>

                    <!-- Dots -->
                    <div class="swiper-pagination mt-4 position-relative d-flex justify-content-center align-items-center"></div>
                </div>
            </div>
        </section>
    @endif
@endsection
