@extends($theme->core('client'))
@section('content')
    
<!-- Pop-up -->
@if (isset($popUp))
    <div id="popup" class="popup" style="display: flex;">
        <div class="popup-content">
            <span class="close-btn font-24 poppins-bold">x</span>
            @if ($popUp->link != null)            
                <a href="{{ $popUp->link }}" target="_blank" rel="noopener noreferrer">
                <img 
                    src="{{ asset('storage/' . $popUp->path_image) }}" 
                    alt="Pop-up"
                    fetchpriority="high" 
                    width="500" 
                    height="auto"
                    decoding="async"
                    loading="eager"
                />
                </a>
                @else
                <img 
                src="{{ asset('storage/' . $popUp->path_image) }}" 
                alt="Pop-up"
                fetchpriority="high" 
                width="500" 
                height="auto"
                decoding="async"
                loading="eager"
                />
            @endif

        </div>
    </div>
    <script defer>
        document.addEventListener("DOMContentLoaded", function () {
            let popup = document.getElementById("popup");
            let closeBtn = document.querySelector(".close-btn");
            popup.style.display = "flex";
            closeBtn.addEventListener("click", () => popup.style.display = "none");
            window.addEventListener("click", (e) => { if (e.target === popup) popup.style.display = "none"; });
        });
    </script>
@endif


@if (isset($blogSuperHighlights) && $blogSuperHighlights <> null)
    <section class="blog mb-0 mt-4">
        <div class="container">
            <div class="row g-3 g-lg-4 mt-4">
                <div class="col-lg-7 px-0 pe-lg-0 m-0">
                    <div class="d-flex justify-content-start align-items-center my-3 position-relative">
                                                                            
                        <span class="border-left me-3 bg-dark" style="width:4px; height: 35px;"></span>
                        
                        <!-- Brand tab -->
                        <h3 class="poppins-semiBold font-20 mb-0 text-dark">
                            Principais Destaques
                        </h3>
                        
                        <div class="navigation-destaque position-relative col-8 d-flex justify-content-end">
                            <div class="swiper-button-prev news"></div>
                            <div class="swiper-button-next news"></div>
                        </div>
                    </div>
                    <!-- Swiper Main Carousel -->
                    <div class="swiper main-swiper">
                        <div class="swiper-wrapper">

                            @foreach($blogSuperHighlights as $blogSuperHighlight)

                                @php
                                    \Carbon\Carbon::setLocale('pt_BR');

                                    $dataFormatada = \Carbon\Carbon::parse($blogSuperHighlight->date)
                                        ->translatedFormat('d \d\e F \d\e Y');

                                    if ($blogSuperHighlight->path_image_thumbnail) {
                                        if (Str::startsWith($blogSuperHighlight->path_image_thumbnail, ['http://', 'https://'])) {
                                            $imagemSuperHighlightUrl = $blogSuperHighlight->path_image_thumbnail;
                                        } else {
                                            $imagemSuperHighlightUrl = asset('storage/' . $blogSuperHighlight->path_image_thumbnail);
                                        }
                                    } else {
                                        $imagemSuperHighlightUrl = 'https://placehold.co/600x400?text=Sem+imagem&font=poppins';
                                    }
                                @endphp

                                <div class="swiper-slide">
                                    <article class="w-100">
                                        <div
                                            class="position-relative overflow-hidden"  
                                            style="height: 500px;"                                          
                                        >

                                            <img
                                                class="img-fluid h-100 w-100"
                                                src="{{ $imagemSuperHighlightUrl }}"
                                                alt="{{ $blogSuperHighlight->title ?: 'Sem imagem' }}"
                                                style="object-fit: cover;"
                                            >

                                            <div class="overlay">

                                                <div class="mb-3 d-flex justify-content-center align-items-center gap-1 flex-wrap">
                                                    <span class="badge rounded-0 bg-accent-color text-dark poppins-semiBold font-12 text-uppercase py-2 px-2 me-2">
                                                        {{ $blogSuperHighlight->category->title }}
                                                    </span>
                                                </div>

                                                <a href="{{ route('blog-inner', ['slug' => $blogSuperHighlight->slug]) }}">
                                                    <h1 class="h2 m-0 text-white poppins-bold font-32 d-block">
                                                        {{ $blogSuperHighlight->title }}
                                                    </h1>
                                                </a>

                                                <div class="description-blog mt-2">
                                                    {!! substr(strip_tags($blogSuperHighlight->text), 0, 400) !!}...
                                                </div>

                                                <div class="d-flex justify-content-between gap-2 align-items-center w-100">

                                                    <p class="text-white mt-3 poppins-regular font-15 col-8 col-lg-10">
                                                        {{ $dataFormatada }}
                                                    </p>

                                                    <div
                                                        id="socialLinks-{{ $blogSuperHighlight->id }}"
                                                        class="social-links home opacity-0"
                                                    >
                                                        <div class="d-flex gap-2">

                                                            <a
                                                                href="https://api.whatsapp.com/send?text={{ urlencode($blogSuperHighlight->title . ' ' . route('blog-inner', ['slug' => $blogSuperHighlight->slug])) }}"
                                                                target="_blank"
                                                                class="rounded-circle btn btn-sm bg-whatsapp bg-transparent p-0"
                                                            >
                                                                <i class="fab fa-whatsapp text-white"></i>
                                                            </a>

                                                            <a
                                                                href="https://twitter.com/intent/tweet?url={{ urlencode(route('blog-inner', ['slug' => $blogSuperHighlight->slug])) }}&text={{ urlencode($blogSuperHighlight->title) }}"
                                                                target="_blank"
                                                                class="rounded-circle btn btn-sm btn-twiter bg-transparent p-0"
                                                            >
                                                                <i class="fab fa-x-twitter text-white"></i>
                                                            </a>

                                                            <a
                                                                href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('blog-inner', ['slug' => $blogSuperHighlight->slug])) }}"
                                                                target="_blank"
                                                                class="rounded-circle btn btn-facebook btn-sm bg-transparent p-0"
                                                            >
                                                                <i class="fab fa-facebook-f text-white"></i>
                                                            </a>

                                                        </div>
                                                    </div>

                                                    <button
                                                        id="shareBtn-{{ $blogSuperHighlight->id }}"
                                                        data-target="socialLinks-{{ $blogSuperHighlight->id }}"
                                                        class="share-button d-flex"
                                                    >
                                                        <svg
                                                            width="18"
                                                            height="20"
                                                            viewBox="0 0 24 26"
                                                            fill="none"
                                                            xmlns="http://www.w3.org/2000/svg"
                                                        >
                                                            <path
                                                                d="M4.28845 8.58841C1.92459 8.58841 0 10.5692 0 13.002C0 15.4348 1.92459 17.4155 4.28845 17.4155C5.68567 17.4155 6.92779 16.7195 7.70969 15.6506L15.6837 20.0897C15.5186 20.5571 15.4231 21.0603 15.4231 21.5864C15.4231 24.0193 17.3477 26 19.7115 26C22.0754 26 24 24.0193 24 21.5864C24 19.1536 22.0754 17.1729 19.7115 17.1729C18.3143 17.1729 17.0722 17.8689 16.2903 18.9378L8.31633 14.4987C8.48136 14.0313 8.57691 13.5281 8.57691 12.9982C8.57691 12.4682 8.47516 11.9356 8.3002 11.4554L16.2033 6.94346C16.9789 8.08134 18.262 8.82714 19.71 8.82714C22.0739 8.82714 23.9985 6.84639 23.9985 4.41357C23.9985 1.98074 22.0739 0 19.71 0C17.3462 0 15.4216 1.98074 15.4216 4.41357C15.4216 4.88736 15.4973 5.34584 15.6313 5.77367L7.67731 10.3151C6.89306 9.26915 5.66339 8.58848 4.28466 8.58848L4.28845 8.58841ZM19.7148 18.4846C21.3788 18.4846 22.7326 19.8779 22.7326 21.5905C22.7326 23.303 21.3788 24.6963 19.7148 24.6963C18.0508 24.6963 16.697 23.303 16.697 21.5905C16.697 21.0605 16.8273 20.5611 17.0556 20.1231C17.0556 20.1231 17.0594 20.1167 17.0618 20.1167C17.0618 20.1129 17.0618 20.1065 17.068 20.1039C17.583 19.1397 18.5732 18.4859 19.7136 18.4859L19.7148 18.4846ZM19.7148 1.30799C21.3788 1.30799 22.7326 2.70127 22.7326 4.41383C22.7326 6.12639 21.3788 7.51967 19.7148 7.51967C18.0508 7.51967 16.697 6.12639 16.697 4.41383C16.697 2.70127 18.0508 1.30799 19.7148 1.30799ZM4.28845 16.1081C2.62444 16.1081 1.27065 14.7149 1.27065 13.0023C1.27065 11.2897 2.62444 9.89646 4.28845 9.89646C5.95247 9.89646 7.30626 11.2897 7.30626 13.0023C7.30626 13.5348 7.17596 14.0355 6.94393 14.4735C6.94393 14.4735 6.94393 14.4773 6.94021 14.4799C6.94021 14.4799 6.94021 14.4863 6.93648 14.4863C6.42524 15.4504 5.42758 16.1081 4.28724 16.1081L4.28845 16.1081Z"
                                                                fill="white"
                                                            />
                                                        </svg>
                                                    </button>

                                                </div>

                                            </div>

                                        </div>
                                    </article>
                                </div>

                            @endforeach

                        </div>                        
                    </div>
                </div>

                @if ($blogHighlights->count())
                    <div class="col-lg-5 p-0 m-0">
                        <div class="row g-0">
                            <div class="d-flex justify-content-start align-items-center my-3">
                                                                            
                                <span class="border-left me-3 bg-dark" style="width:4px; height: 35px;"></span>
                                
                                <!-- Brand tab -->
                                <h3 class="poppins-semiBold font-20 mb-0 text-dark">
                                    Destaques
                                </h3>
                            </div>
                            @foreach($blogHighlights->take(4) as $blogHighlight)

                                @php
                                    \Carbon\Carbon::setLocale('pt_BR');

                                    $dataFormatada = \Carbon\Carbon::parse($blogHighlight->date)
                                        ->translatedFormat('d \d\e F \d\e Y');

                                    if ($blogHighlight->path_image_thumbnail) {
                                        if (Str::startsWith($blogHighlight->path_image_thumbnail, ['http://', 'https://'])) {
                                            $imagemHighlightUrl = $blogHighlight->path_image_thumbnail;
                                        } else {
                                            $imagemHighlightUrl = asset('storage/' . $blogHighlight->path_image_thumbnail);
                                        }
                                    } else {
                                        $imagemHighlightUrl = 'https://placehold.co/600x400?text=Sem+imagem&font=poppins';
                                    }
                                @endphp

                                <div class="col-6 box-small">
                                    <article>

                                        <div class="position-relative overflow-hidden" style="height: 250px;">

                                            <img
                                                class="img-fluid h-100 w-100"
                                                src="{{ $imagemHighlightUrl }}"
                                                alt="{{ $blogHighlight->title ?: 'Sem imagem' }}"
                                                style="object-fit: cover;"
                                            >

                                            <div class="overlay">

                                                <div class="mb-2 d-flex justify-content-start align-items-center gap-1 flex-wrap">
                                                    <span class="badge rounded-0 text-dark bg-accent-color text-uppercase poppins-semiBold font-12 py-2 px-2 me-2">
                                                        {{ $blogHighlight->category->title }}
                                                    </span>
                                                </div>

                                                <a href="{{ route('blog-inner', ['slug' => $blogHighlight->slug]) }}">
                                                    <h2 class="h6 m-0 text-white poppins-semiBold font-16 d-block">
                                                        {{ $blogHighlight->title }}
                                                    </h2>
                                                </a>

                                                <div class="d-flex justify-content-between align-items-center w-100">

                                                    <p class="text-white mt-3 poppins-regular font-12 col-8">
                                                        {{ $dataFormatada }}
                                                    </p>

                                                    <div
                                                        id="socialLinks-{{ $blogHighlight->id }}"
                                                        class="social-links home opacity-0"
                                                    >
                                                        <div class="d-flex gap-2">

                                                            <a
                                                                href="https://api.whatsapp.com/send?text={{ urlencode($blogHighlight->title . ' ' . url()->current()) }}"
                                                                target="_blank"
                                                                class="rounded-circle btn btn-sm bg-whatsapp bg-transparent p-0"
                                                            >
                                                                <i class="fab fa-whatsapp text-white font-12"></i>
                                                            </a>

                                                            <a
                                                                href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($blogHighlight->title) }}"
                                                                target="_blank"
                                                                class="rounded-circle btn btn-sm btn-twiter bg-transparent p-0"
                                                            >
                                                                <i class="fab fa-x-twitter text-white font-12"></i>
                                                            </a>

                                                            <a
                                                                href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                                                                target="_blank"
                                                                class="rounded-circle btn btn-facebook btn-sm bg-transparent p-0"
                                                            >
                                                                <i class="fab fa-facebook-f text-white font-12"></i>
                                                            </a>

                                                        </div>
                                                    </div>

                                                    <button
                                                        id="shareBtn-{{ $blogHighlight->id }}"
                                                        data-target="socialLinks-{{ $blogHighlight->id }}"
                                                        class="share-button d-flex"
                                                    >
                                                        <svg
                                                            width="14"
                                                            height="16"
                                                            viewBox="0 0 24 26"
                                                            fill="none"
                                                            xmlns="http://www.w3.org/2000/svg"
                                                        >
                                                            <path
                                                                d="M4.28845 8.58841C1.92459 8.58841 0 10.5692 0 13.002C0 15.4348 1.92459 17.4155 4.28845 17.4155C5.68567 17.4155 6.92779 16.7195 7.70969 15.6506L15.6837 20.0897C15.5186 20.5571 15.4231 21.0603 15.4231 21.5864C15.4231 24.0193 17.3477 26 19.7115 26C22.0754 26 24 24.0193 24 21.5864C24 19.1536 22.0754 17.1729 19.7115 17.1729C18.3143 17.1729 17.0722 17.8689 16.2903 18.9378L8.31633 14.4987C8.48136 14.0313 8.57691 13.5281 8.57691 12.9982C8.57691 12.4682 8.47516 11.9356 8.3002 11.4554L16.2033 6.94346C16.9789 8.08134 18.262 8.82714 19.71 8.82714C22.0739 8.82714 23.9985 6.84639 23.9985 4.41357C23.9985 1.98074 22.0739 0 19.71 0C17.3462 0 15.4216 1.98074 15.4216 4.41357C15.4216 4.88736 15.4973 5.34584 15.6313 5.77367L7.67731 10.3151C6.89306 9.26915 5.66339 8.58848 4.28466 8.58848L4.28845 8.58841ZM19.7148 18.4846C21.3788 18.4846 22.7326 19.8779 22.7326 21.5905C22.7326 23.303 21.3788 24.6963 19.7148 24.6963C18.0508 24.6963 16.697 23.303 16.697 21.5905C16.697 21.0605 16.8273 20.5611 17.0556 20.1231C17.0556 20.1231 17.0594 20.1167 17.0618 20.1167C17.0618 20.1129 17.0618 20.1065 17.068 20.1039C17.583 19.1397 18.5732 18.4859 19.7136 18.4859L19.7148 18.4846ZM19.7148 1.30799C21.3788 1.30799 22.7326 2.70127 22.7326 4.41383C22.7326 6.12639 21.3788 7.51967 19.7148 7.51967C18.0508 7.51967 16.697 6.12639 16.697 4.41383C16.697 2.70127 18.0508 1.30799 19.7148 1.30799ZM4.28845 16.1081C2.62444 16.1081 1.27065 14.7149 1.27065 13.0023C1.27065 11.2897 2.62444 9.89646 4.28845 9.89646C5.95247 9.89646 7.30626 11.2897 7.30626 13.0023C7.30626 13.5348 7.17596 14.0355 6.94393 14.4735C6.94393 14.4735 6.94393 14.4773 6.94021 14.4799C6.94021 14.4799 6.94021 14.4863 6.93648 14.4863C6.42524 15.4504 5.42758 16.1081 4.28724 16.1081L4.28845 16.1081Z"
                                                                fill="white"
                                                            />
                                                        </svg>
                                                    </button>

                                                </div>

                                            </div>

                                        </div>

                                    </article>
                                </div>

                            @endforeach

                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endif

@if (isset($recentCategories) || isset($events))
    <section class="py-5">
        <div class="container">
            <div class="row">
                @if ($recentCategories->count() > 0)                    
                    <div class="col-12 col-lg-9 mb-3" style="border-right: 1px solid #dee2e6;">
                        @foreach($blogCategories as $category)                                                    
                            <div class="tab01 pb-5 {{$category->slug}}" style="--category-color: {{ $category->color }};">
                                <div class="tab01-head d-flex justify-content-center align-items-center" style="border: 1px solid #dee2e6;">
                                    @if ($category->color <> null)                                        
                                        <span class="border-left me-3" style="width:4px; height: 45px; background: {{$category->color}}"></span>
                                    @endif

                                    <!-- Brand tab -->
                                    <h3 class="poppins-semiBold font-18 mb-0" style="color: {{$category->color}}">
                                        {{$category->title}}
                                    </h3>
                            
                                    <!-- Nav tabs -->
                                    <ul class="ms-0 ms-lg-5 nav nav-tabs justify-content-start" role="tablist">
                                        <button type="button" class="nav-link poppins-semiBold text-decoration-none text-black category-filter font-14 font-mob active"
                                        data-category-id="{{ $category->id }}"
                                        data-subcategory-id=""
                                        href="#"
                                        role="tab"
                                        >
                                            Todos
                                        </button>

                                        @foreach($category->subcategories as $subcategory)
                                            <button type="button"
                                                class="nav-link poppins-semiBold text-decoration-none text-black category-filter font-15 font-mob"
                                                data-category-id="{{ $category->id }}"
                                                data-subcategory-id="{{ $subcategory->id }}"
                                                href="#"
                                                role="tab"
                                            >
                                                {{ $subcategory->name }}
                                            </button>                                            
                                        @endforeach
                            
                                        <li class="nav-item-more dropdown d-none">
                                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                                                <i class="fa fa-ellipsis-h"></i>
                                            </a>
                            
                                            <ul class="dropdown-menu">
                                                
                                            </ul>
                                        </li>
                                    </ul>
                            
                                    <!--  -->
                                    <a href="category-01.html" class="tab01-link pe-3">
                                        Ver todos
                                        <i class="fs-12 m-l-5 fa fa-caret-right"></i>
                                    </a>
                                </div>
                                
                                <div class="blog-filter-content" id="blog-filter-{{ $category->id }}">
                                    @include('client.themes.blog.tp-01.ajax.filter-blog-homePage')
                                </div>
                            </div>
                        @endforeach

                        @if (isset($announcements['center-bottom']) && $announcements['center-bottom']->isNotEmpty())
                            <div class="ad-container mt-3 mb-0 bg-transparent border-0">
                                <div class="ad-placeholder overflow-hidden bg-transparent">
                                    <!-- Espaço para Banner Adsense -->
                                    @includeIf('client.components.announcement.all-announcement',[
                                            'announcements' => $announcements['center-bottom'] ?? collect()
                                        ]
                                    )
                                </div>
                            </div>
                        @endif
                    </div>
                @endif      

                <div class="col-lg-3 col-12">
                    <!-- Tags Start -->
                        @include('client.themes.blog.tp-01.includes.category-aside')  
                    <!-- Tags End -->

                    <!-- Popular News Start -->
                        @include('client.themes.blog.tp-01.includes.view-more')                    
                    <!-- Popular News End -->

                    <!-- Eventos Start -->
                        @include('client.themes.blog.tp-01.includes.event-aside')                   
                    <!-- Eventos End -->      

                    <!-- Previsao tempo Start -->
                        @include('client.themes.blog.tp-01.includes.weather')                    
                    <!-- Previsao tempo News End -->  

                    <!-- Ads Start -->
                    @if ($announcements->count())                        
                        <div class="mb-0">
                            <div class="ad-placeholder overflow-hidden px-3" style="min-height: 250px">
                                <!-- Anúncio 300x250 -->  
                                @includeIf('client.components.announcement.all-announcement',[
                                        'announcements' => $announcements['sidebar-right'] ?? collect()
                                    ]
                                )
                            </div>
                        </div>
                    @endif
                    <!-- Ads End -->

                    <!-- Newsletter Start -->
                        @include('client.themes.blog.tp-01.includes.newsletter')
                    <!-- Newsletter End -->
                    
                </div>
            </div>
        </div>
    </section>
@endif

{{-- @if ($blogNoBairros->count() > 0) 
    <section id="no-bairro" data-aos="fade-up" data-aos-delay="30">
        <div class="container border-bottom news mb-0 p-0">
            <div class="px-0 d-flex flex-row justify-content-between align-items-center w-100">
                <h2 class="section-title d-table p-0 w-auto m-0 mb-3 poppins-bold font-28 title-blue">
                    No Bairro
                </h2>

                <!-- Navegação EXTERNA -->
                <div class="d-flex justify-content-between align-items-center">
                    <div class="swiper-button-prev-one text-center">
                        <svg width="17" height="25" viewBox="0 0 17 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12.6671 0L0.000387192 12.5L12.6671 25L16.2617 21.4526L7.18705 12.5L16.2617 3.54737L12.6671 0Z" fill="black"/>
                        </svg>
                    </div>
                    <div class="swiper-button-next-one text-center">
                        <svg width="17" height="25" viewBox="0 0 17 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3.59467 25L16.2613 12.5L3.59467 0L0 3.54737L9.07467 12.5L0 21.4526L3.59467 25Z" fill="black"/>
                        </svg>             
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid m-auto me-0 mt-5 pe-0 pad-mobi" style="padding-left: 100px;">
            <div class="swiper myNewsSwiper">            
                <div class="swiper-wrapper" style="align-items: flex-start;">
                    @foreach($blogNoBairros as $noBairro)
                        @php
                            \Carbon\Carbon::setLocale('pt_BR');
                            $dataFormatada = \Carbon\Carbon::parse($noBairro->date)->translatedFormat('d \d\e F \d\e Y');
                        @endphp
                        
                        <div class="swiper-slide">
                            <article class="col-12">
                                <div class="d-flex flex-column align-items-center bg-white mb-4 overflow-hidden position-relative">

                                    <div class="position-absolute mt-2 start-0">
                                        <span class="badge rounded-0 badge-primary poppins-semiBold font-10 text-uppercase py-2 px-2 mr-2 background-red">
                                            {{ $noBairro->category->title }}
                                        </span>
                                    </div>

                                    <img loading="lazy" class="img-fluid w-100 rounded-1"
                                    src="{{ $noBairro->path_image_thumbnail ? asset('storage/' . $noBairro->path_image_thumbnail) : 'https://placehold.co/600x400?text=Sem+imagem&font=poppins' }}"
                                    alt="{{ $noBairro->title }}"
                                    style="height: 232px;aspect-ratio:1/1;object-fit: cover;">

                                    <div class="col-12 my-3 h-100 px-2 d-flex flex-column justify-content-center position-relative">                        
                                        <a href="{{ route('blog-inner', $noBairro->slug) }}" class="underline">
                                            <h3 class="h6 m-0 poppins-bold font-14 title-blue">
                                                {{ Str::limit($noBairro->title, 60) }}
                                            </h3>
                                        </a>

                                        <p class="text-color my-3 poppins-regular font-15">
                                            {!! substr(strip_tags($noBairro->text), 0, 200) !!}...
                                        </p>

                                        <div class="d-flex justify-content-between align-items-center w-100">
                                            <p class="text-color mb-0 poppins-regular font-12 col-8">{{$dataFormatada}}</p>

                                            <div id="socialLinks-filter-two-{{$noBairro->id}}" class="social-links home opacity-0">
                                                <div class="d-flex gap-2">
                                                    <a href="https://api.whatsapp.com/send?text={{ urlencode($noBairro->title . ' ' . route('blog-inner', ['slug' => $noBairro->slug])) }}" 
                                                    class="rounded-circle btn btn-sm bg-transparent p-0" target="_blank">
                                                        <i class="fab fa-whatsapp text-dark"></i>
                                                    </a>

                                                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('blog-inner', ['slug' => $noBairro->slug])) }}&text={{ urlencode($noBairro->title) }}" 
                                                    class="rounded-circle btn btn-sm bg-transparent p-0" target="_blank">
                                                        <i class="fab fa-x-twitter text-dark"></i>
                                                    </a>

                                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('blog-inner', ['slug' => $noBairro->slug])) }}" 
                                                    class="rounded-circle btn btn-sm bg-transparent p-0" target="_blank">
                                                        <i class="fab fa-facebook-f text-dark"></i>
                                                    </a>
                                                </div>
                                            </div>  

                                            <button id="btnShare-filter-two-{{$noBairro->id}}" 
                                                    data-target="socialLinks-filter-two-{{$noBairro->id}}"
                                                    class="share-button d-flex">
                                                <svg width="18" height="20" viewBox="0 0 24 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M4.28845 8.58841C1.92459 8.58841 0 10.5692 0 13.002C0 15.4348 1.92459 17.4155 4.28845 17.4155C5.68567 17.4155 6.92779 16.7195 7.70969 15.6506L15.6837 20.0897C15.5186 20.5571 15.4231 21.0603 15.4231 21.5864C15.4231 24.0193 17.3477 26 19.7115 26C22.0754 26 24 24.0193 24 21.5864C24 19.1536 22.0754 17.1729 19.7115 17.1729C18.3143 17.1729 17.0722 17.8689 16.2903 18.9378L8.31633 14.4987C8.48136 14.0313 8.57691 13.5281 8.57691 12.9982C8.57691 12.4682 8.47516 11.9356 8.3002 11.4554L16.2033 6.94346C16.9789 8.08134 18.262 8.82714 19.71 8.82714C22.0739 8.82714 23.9985 6.84639 23.9985 4.41357C23.9985 1.98074 22.0739 0 19.71 0C17.3462 0 15.4216 1.98074 15.4216 4.41357C15.4216 4.88736 15.4973 5.34584 15.6313 5.77367L7.67731 10.3151C6.89306 9.26915 5.66339 8.58848 4.28466 8.58848L4.28845 8.58841Z" fill="#282828"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        </div>    
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endif --}}

<style>
.swiper-button-prev-one,
.swiper-button-next-one {
    position: relative; 
    color: #003366;
    width: 32px;
    height: 32px;
    z-index: 10;
}

</style>
<script defer>
    document.addEventListener('DOMContentLoaded', function () {
        if (typeof Swiper === 'undefined') {
            console.error('Swiper não carregado');
            return;
        }

        const newsSwiper = new Swiper('.myNewsSwiper', {
            slidesPerView: 1,
            spaceBetween: 20,
            navigation: {
            nextEl: ".swiper-button-next-one",
            prevEl: ".swiper-button-prev-one",
            },
            breakpoints: {
            360: { slidesPerView: 1.3 },
            576: { slidesPerView: 2.5 },
            1200: { slidesPerView: 4.5 }
            }
        });
    });
</script>


<!-- Start Youtube -->
@if (!empty($videos) && $videos->count() > 0)
    <div class="youtube-area video-padding">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="video-items-active">
                        @foreach ($videos as $i => $video)
                            <div
                                class="video-items text-center"
                                data-id="{{ $i }}"
                                data-video="{{ $video->link }}">
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="video-info">
                <div class="row">

                    <div class="col-lg-6">
                        <div class="video-caption">
                            <div class="top-caption">
                                <span class="color1">Politics</span>
                            </div>
                            <div class="bottom-caption">
                                <h2>Welcome To The Best Model Winner Contest At Look of the year</h2>
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit sed do eiusmod ipsum dolor sit. Lorem ipsum dolor sit amet consectetur adipisicing elit sed do eiusmod ipsum dolor sit. Lorem ipsum dolor sit amet consectetur adipisicing elit sed do eiusmod ipsum dolor sit lorem ipsum dolor sit.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="testmonial-nav text-center">
                            @foreach ($videos as $i => $video)
                                <div
                                    class="single-video"
                                    data-id="{{ $i }}"
                                    data-video="{{ $video->link }}">

                                    <div class="video-thumb">
                                        <img
                                            src=""
                                            alt="{{ $video->title ?? 'Vídeo' }}"
                                            loading="lazy">

                                        <span class="video-play">
                                            <i class="fas fa-play"></i>
                                        </span>
                                    </div>

                                    <div class="video-intro mt-1">
                                        <h4>{{ $video->title ?? 'Vídeo' }}</h4>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endif
<!-- End Start youtube -->

<!-- Colunista Start -->
    @include('client.themes.blog.tp-01.includes.colunista')                    
<!-- Colunista End -->  

<script defer>
    document.addEventListener("DOMContentLoaded", function () {
        const section = document.querySelector(".youtube-area");

        if (!section) return;

        const mainVideos = Array.from(
            section.querySelectorAll(".video-items-active .video-items")
        );

        const navVideos = Array.from(
            section.querySelectorAll(".testmonial-nav .single-video")
        );

        if (!mainVideos.length || !navVideos.length) return;

        /**
         * Normaliza URL
         */
        function norm(url) {
            if (!url) return "";

            return url.startsWith("//")
                ? window.location.protocol + url
                : url;
        }

        /**
         * Converte URL para URL de embed
         * YouTube / Vimeo
         */
        function toEmbed(rawUrl) {
            const urlStr = norm(rawUrl);

            if (!urlStr) return "";

            let u;

            try {
                u = new URL(urlStr);
            } catch {
                return urlStr;
            }

            const host = u.hostname.replace(/^www\./, "");

            /**
             * YouTube
             */
            if (host.includes("youtube.com") || host.includes("youtu.be")) {

                // Já é embed
                if (u.pathname.startsWith("/embed/")) {
                    return u.toString();
                }

                // youtu.be/ID
                if (host === "youtu.be" && u.pathname.length > 1) {
                    const id = u.pathname.split("/")[1];

                    return `https://www.youtube.com/embed/${id}`;
                }

                // Shorts
                if (u.pathname.startsWith("/shorts/")) {
                    const id = u.pathname.split("/")[2] || u.pathname.split("/")[1];

                    return `https://www.youtube.com/embed/${id}`;
                }

                // watch?v=ID
                const v = u.searchParams.get("v");

                if (v) {
                    return `https://www.youtube.com/embed/${v}`;
                }

                // /live/ID, /v/ID etc.
                const parts = u.pathname
                    .split("/")
                    .filter(Boolean);

                if (parts.length >= 2) {
                    const id = parts.pop();

                    return `https://www.youtube.com/embed/${id}`;
                }
            }

            /**
             * Vimeo
             */
            if (host.includes("vimeo.com")) {

                // Já é player.vimeo.com
                if (host === "player.vimeo.com") {
                    return u.toString();
                }

                const parts = u.pathname
                    .split("/")
                    .filter(Boolean);

                const last = parts[parts.length - 1];

                if (/^\d+$/.test(last)) {
                    return `https://player.vimeo.com/video/${last}`;
                }
            }

            // Desconhecido
            return urlStr;
        }

        /**
         * ID do YouTube
         */
        function getYouTubeID(url) {
            try {
                const u = new URL(norm(url));

                const host = u.hostname.replace(/^www\./, "");

                if (host === "youtu.be") {
                    return u.pathname.split("/").filter(Boolean)[0] || null;
                }

                if (u.searchParams.get("v")) {
                    return u.searchParams.get("v");
                }

                const parts = u.pathname.split("/").filter(Boolean);

                if (parts.includes("embed")) {
                    return parts[parts.indexOf("embed") + 1] || null;
                }

                if (parts.includes("shorts")) {
                    return parts[parts.indexOf("shorts") + 1] || null;
                }

                return parts.pop() || null;

            } catch {
                return null;
            }
        }

        /**
         * ID do Vimeo
         */
        function getVimeoID(url) {
            try {
                const u = new URL(norm(url));

                const parts = u.pathname
                    .split("/")
                    .filter(Boolean);

                return parts.pop() || null;

            } catch {
                return null;
            }
        }

        /**
         * Cria os iframes dos vídeos principais
         */
        mainVideos.forEach(video => {
            const rawUrl = video.getAttribute("data-video");

            if (!rawUrl) return;

            const embedUrl = toEmbed(rawUrl);

            if (!embedUrl) return;

            const iframe = document.createElement("iframe");

            iframe.src = embedUrl;
            iframe.title = "Vídeo";
            iframe.frameBorder = "0";
            iframe.allow =
                "accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture";
            iframe.allowFullscreen = true;

            video.appendChild(iframe);
        });

        /**
         * Cria as thumbnails
         */
        navVideos.forEach(video => {
            const rawUrl = video.getAttribute("data-video");

            if (!rawUrl) return;

            const thumb = video.querySelector(".video-thumb img");

            if (!thumb) return;

            /**
             * YouTube
             */
            const youtubeID = getYouTubeID(rawUrl);

            if (youtubeID) {
                thumb.src =
                    `https://img.youtube.com/vi/${youtubeID}/hqdefault.jpg`;

                return;
            }

            /**
             * Vimeo
             */
            const vimeoID = getVimeoID(rawUrl);

            if (vimeoID) {
                fetch(
                    `https://vimeo.com/api/v2/video/${vimeoID}.json`
                )
                    .then(response => response.json())
                    .then(data => {
                        if (data?.[0]?.thumbnail_medium) {
                            thumb.src = data[0].thumbnail_medium;
                        }
                    })
                    .catch(() => {
                        thumb.src = "/images/placeholder.jpg";
                    });

                return;
            }

            thumb.src = "/images/placeholder.jpg";
        });

        /**
         * Inicializa o Slick
         */
        if (
            typeof jQuery !== "undefined" &&
            typeof jQuery.fn.slick !== "undefined"
        ) {
            const $main = jQuery(".video-items-active");
            const $nav = jQuery(".testmonial-nav");

            $main.slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                arrows: false,
                fade: true,
                asNavFor: ".testmonial-nav"
            });

            $nav.slick({
                slidesToShow: 4,
                slidesToScroll: 1,
                asNavFor: ".video-items-active",
                dots: false,
                focusOnSelect: true,
                arrows: true,
                prevArrow:
                    '<button type="button" class="slick-prev"><i class="fas fa-chevron-left"></i></button>',
                nextArrow:
                    '<button type="button" class="slick-next"><i class="fas fa-chevron-right"></i></button>',
                responsive: [
                    {
                        breakpoint: 992,
                        settings: {
                            slidesToShow: 3
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 2
                        }
                    },
                    {
                        breakpoint: 576,
                        settings: {
                            slidesToShow: 1
                        }
                    }
                ]
            });
        }
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        document.addEventListener('click', function (e) {

            const filter = e.target.closest('.category-filter');

            if (!filter) {
                return;
            }

            e.preventDefault();

            const categoryId = filter.dataset.categoryId;
            const subcategoryId = filter.dataset.subcategoryId;

            console.log('Filtro clicado');
            console.log('Categoria:', categoryId);
            console.log('Subcategoria:', subcategoryId);

            const categoryContainer = filter.closest('.tab01');

            const filterContent = categoryContainer.querySelector(
                '#blog-filter-' + categoryId
            );

            if (!filterContent) {
                console.error(
                    'Container do filtro não encontrado:',
                    '#blog-filter-' + categoryId
                );
                return;
            }

            const filters = categoryContainer.querySelectorAll('.category-filter');

            filters.forEach(function (item) {
                item.classList.remove('active');
            });

            filter.classList.add('active');

            $.ajax({
                url: '{{ route("blog.filter.subcategory") }}',
                type: 'GET',
                data: {
                    category_id: categoryId,
                    subcategory_id: subcategoryId
                },

                beforeSend: function () {
                    console.log('Enviando AJAX...');
                },

                success: function (response) {

                    console.log('Resposta AJAX:', response);

                    if (response.success) {
                        filterContent.innerHTML = response.html;
                    }
                },

                error: function (xhr) {

                    console.error('Erro AJAX');
                    console.error('Status:', xhr.status);
                    console.error('Resposta:', xhr.responseText);
                }
            });

        });

    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Inicializa o Swiper
        const mainSwiper = new Swiper('.main-swiper', {
            slidesPerView: 1,
            spaceBetween: 0,
            loop: true,
            autoHeight: true,
            // pagination: {
            //     el: '.swiper-pagination.news',
            //     clickable: true,
            // },
            navigation: {
                nextEl: '.swiper-button-next.news',
                prevEl: '.swiper-button-prev.news',
            },
            breakpoints: {
                768: {
                    slidesPerView: 1,
                },
                1200: {
                    slidesPerView: 1,
                },
                1400: {
                    slidesPerView: 1,
                },
            },
            lazy: {
                loadPrevNext: true,
                loadPrevNextAmount: 2,
            },
        });

        // Share button toggle
        const shareButtons = document.querySelectorAll('.share-button');
        shareButtons.forEach(btn => {
            btn.addEventListener('click', function () {
                const targetId = this.dataset.target;
                const target = document.getElementById(targetId);
                if (target) {
                    target.classList.toggle('opacity-0');
                    target.classList.toggle('opacity-100');
                }
            });
        });
    });
</script>
@endsection
