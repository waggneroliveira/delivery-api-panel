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
        <div class="container-fluid p-0">
            <div class="row g-3 g-lg-4">
                <div class="col-lg-7 px-0 pe-lg-0 m-0">
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
                                                    <span class="badge rounded-0 background-red poppins-semiBold font-12 text-uppercase py-2 px-2 me-2">
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
                                                            width="24"
                                                            height="26"
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

                        <div class="swiper-pagination news"></div>
                    </div>
                </div>

                @if ($blogHighlights->count())
                    <div class="col-lg-5 p-0 m-0">
                        <div class="row g-0">

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
                                                    <span class="badge rounded-0 background-red text-uppercase poppins-semiBold font-12 py-2 px-2 me-2">
                                                        {{ $blogHighlight->category->title }}
                                                    </span>
                                                </div>

                                                <a href="{{ route('blog-inner', ['slug' => $blogHighlight->slug]) }}">
                                                    <h2 class="h6 m-0 text-white poppins-semiBold font-18 d-block">
                                                        {{ $blogHighlight->title }}
                                                    </h2>
                                                </a>

                                                <div class="d-flex justify-content-between align-items-center w-100">

                                                    <p class="text-white mt-3 poppins-regular font-14 col-8">
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
                                                                <i class="fab fa-whatsapp text-white"></i>
                                                            </a>

                                                            <a
                                                                href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($blogHighlight->title) }}"
                                                                target="_blank"
                                                                class="rounded-circle btn btn-sm btn-twiter bg-transparent p-0"
                                                            >
                                                                <i class="fab fa-x-twitter text-white"></i>
                                                            </a>

                                                            <a
                                                                href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                                                                target="_blank"
                                                                class="rounded-circle btn btn-facebook btn-sm bg-transparent p-0"
                                                            >
                                                                <i class="fab fa-facebook-f text-white"></i>
                                                            </a>

                                                        </div>
                                                    </div>

                                                    <button
                                                        id="shareBtn-{{ $blogHighlight->id }}"
                                                        data-target="socialLinks-{{ $blogHighlight->id }}"
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
                @endif
            </div>
        </div>
    </section>
@endif
<style>
    .tab01 .nav-tabs {
  display: -webkit-box;
  display: -webkit-flex;
  display: -moz-box;
  display: -ms-flexbox;
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  border: none;
  flex-grow: 1;
  height: 100%;
}

.tab01 .nav-tabs .nav-item-more,
.tab01 .nav-tabs .nav-item {
  height: 100%;
  padding: 0px;
  margin: 0px;
}

.tab01 .nav-link {
  line-height: 1.7;
  
  display: -webkit-box;
  display: -webkit-flex;
  display: -moz-box;
  display: -ms-flexbox;
  display: flex;
  align-items: center;
  height: 100%;
  padding: 5px 12px;
  border-radius: 0px;
  border: none;
  position: relative;

  -webkit-transition: all 0.3s;
  -o-transition: all 0.3s;
  -moz-transition: all 0.3s;
  transition: all 0.3s;
}

.tab01 .nav-link.active::after {
  content: "";
  display: block;
  position: absolute;
  background-color: #fff;
  width: 7px;
  height: 7px;
  border-left: 1px solid #d5d5d5;
  border-bottom: 1px solid #d5d5d5;
  left: calc(50% - 5px);
  bottom: -5px;
  
  -webkit-transform: rotate(-45deg);
  -moz-transform: rotate(-45deg);
  -ms-transform: rotate(-45deg);
  -o-transform: rotate(-45deg);
  transform: rotate(-45deg);
}

.tab01 .nav-link:hover {
  color: #17b978 !important;
}


/*---------------------------------------------*/
.tab01-link {
  padding-left: 10px;
  white-space: nowrap;
}

.tab01-title {
  padding-right: 25px;
}

/*---------------------------------------------*/
.tab01 .nav-link.dropdown-toggle::after {
  display: none;
}

.tab01 .dropdown-menu {
  min-width: 135px;
  border-radius: 0px;
  padding: 5px 0;
}

.tab01 .dropdown-menu .nav-link {
  width: 100%;
}

.tab01 .dropdown-menu .nav-link.active {
  color: #17b978;
}

.tab01 .dropdown-menu .nav-link.active::after {
  display: none;
}
</style>

@if (isset($recentCategories) || isset($events))
    <section class="py-5">
        <div class="container">
            <div class="row">
                @if ($recentCategories->count() > 0)                    
                    <div class="col-12 col-lg-9 animate-on-scroll mb-3">
                        @foreach($blogCategories as $category)                            
                            <div class="tab01 pb-5 {{$category->slug}}">
                                <div class="tab01-head d-flex justify-content-between">
                                    <!-- Brand tab -->
                                    <h3 class="f1-m-2 cl12 tab01-title">
                                        {{$category->title}}
                                    </h3>
                            
                                    <!-- Nav tabs -->
                                    <ul class="nav nav-tabs" role="tablist">
                                        <button type="button" class="nav-link poppins-semiBold text-decoration-none text-black category-filter font-15 font-mob active"
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
                                    <a href="category-01.html" class="tab01-link f1-s-1 cl9 hov-cl10 trans-03">
                                        Ver todos
                                        <i class="fs-12 m-l-5 fa fa-caret-right"></i>
                                    </a>
                                </div>
                                
                                <div class="blog-filter-content" id="blog-filter-{{ $category->id }}">
                                    @include('client.themes.blog.tp-01.ajax.filter-blog-homePage')
                                </div>
                            </div>
                        @endforeach

                        @if ($announcements->count())                        
                            <div class="mt-4">
                                @include('client.includes.announcement')
                            </div>
                        @endif
                    </div>
                @endif      

                <div class="col-lg-3 col-12">
                    @if ($blogRelacionados->count() > 0)                        
                        <!-- Popular News Start -->
                        <div class="mb-3">
                            <div class="bg-white border p-3 rounded-1">
                                <div class="section-title mb-4 rounded-top-left">
                                    <h3 class="mb-3 poppins-bold font-18 pb-3 border-bottom title-blue news">Veja também</h3>
                                </div>
                                @foreach($blogRelacionados as $index => $relacionado)
                                    @php
                                        // Verifica se a imagem é do RSS (URL externa) ou manual (storage)
                                        if ($relacionado->path_image_thumbnail) {
                                            if (Str::startsWith($relacionado->path_image_thumbnail, ['http://', 'https://'])) {
                                                // Já é uma URL completa (RSS ou manual com URL externa)
                                                $imagemRelacionadoUrl = $relacionado->path_image_thumbnail;
                                            } else {
                                                // Precisa do asset() para o storage
                                                $imagemRelacionadoUrl = asset('storage/' . $relacionado->path_image_thumbnail);
                                            }
                                        } else {
                                            $imagemRelacionadoUrl = 'https://placehold.co/600x400?text=Sem+imagem&font=poppins';
                                        }
                                    @endphp
                                    
                                    <article class="{{ $index >= 5 ? 'rel-item d-none' : '' }}">
                                        <div class="d-flex align-items-center bg-white mb-3" style="height: 110px;">

                                            <div class="h-100 pe-2 d-flex flex-column justify-content-center" style="flex: 1;">
                                                <a href="{{ route('blog-inner', ['slug' => $relacionado->slug]) }}" class="underline">
                                                    <h3 class="h6 m-0 poppins-semiBold font-15 title-blue">
                                                        {{ substr(strip_tags($relacionado->title), 0, 70) }}...
                                                    </h3>
                                                </a>
                                            </div>

                                            <div class="position-relative" style="width:94px; height:94px; flex-shrink:0;">
                                                <img loading="lazy"
                                                    class="rounded-1 img-fluid w-100 h-100"
                                                    style="object-fit: cover; aspect-ratio: 1/1;"
                                                    src="{{ $imagemRelacionadoUrl }}"
                                                    alt="{{ $relacionado->title ?? 'Sem imagem' }}">
                                            </div>

                                        </div>
                                    </article>
                                @endforeach

                                @if(count($blogRelacionados) > 5)
                                    <div class="text-center mt-2">
                                        <p id="btn-ver-mais" class="poppins-bold font-15" style="cursor: pointer;">Ver mais</p>                                        
                                    </div>
                                @endif
                            </div>
                        </div>
                        <!-- Popular News End -->
                    @endif

                    <!-- Tags Start -->
                    <div class="mb-3">
                        <div class="bg-white border rounded-1 p-3">
                            <div class="section-title mb-0 rounded-top-left cat-mt">
                                <h4 class="mb-3 poppins-bold font-18 border-bottom title-blue pb-3 news">Categorias</h4>
                            </div>
                            <ul class="ps-0 d-flex flex-wrap m-n1">
                                @foreach ($blogCategories as $category)
                                    @php
                                        $title = match(strtolower($category->title)) {
                                            'justica' => 'Justiça',
                                            'saude'   => 'Saúde',
                                            'economia'=> 'Economia',
                                            default   => $category->title,
                                        };
                                    @endphp
                                    <li class="nav-link">
                                        <a href="{{ route('blog', ['category' => $category->slug]) }}#news"
                                        class="btn btn-sm title-blue rounded-0 poppins-semiBold font-12 m-1 bg-blue-light">
                                            {{ $title }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <!-- Tags End -->

                    <!-- Ads Start -->
                    @if ($announcements->count())                        
                        <div class="mb-4">
                            @include('client.includes.announcementVertical')
                        </div>
                    @endif
                    <!-- Ads End -->

                    <!-- Newsletter Start -->
                    <div class="mb-4 bg-white text-center border p-3 rounded-1">
                        <div class="section-title mb-0 rounded-top-left">
                            <h4 class="mb-3 poppins-bold font-18 border-bottom pb-3 title-blue text-start news">Newsletter</h4>
                        </div>
                        {{-- @include('client.includes.newsletter') --}}
                    </div>
                    <!-- Newsletter End -->

                    @if (isset($contact) && $contact->link_face || isset($contact) && $contact->link_x || isset($contact) && $contact->link_insta || isset($contact) && $contact->link_youtube)
                        <!-- Rede sociais Start -->
                        <div class="mb-4 bg-white text-center border p-3 rounded-1">
                            <div class="section-title mb-0 rounded-top-left">
                                <h4 class="mb-3 poppins-bold font-18 border-bottom pb-3 title-blue text-start news">Siga-nos nas redes sociais</h4>
                                    <p class="text-color poppins-regular font-12 text-start">
                                        Acompanhe as notícias de toda a cidade através das nossas redes sociais
                                    </p>
                            </div>
                            <div class="p-0 m-auto me-0 mt-4">
                                <nav class="site-navigation position-relative text-end w-100 redes-sociais">
                                    <ul class="p-0 d-flex justify-content-start justify-content-lg-center align-items-center gap-3 flex-row mb-0 w-100">
                                        @if (isset($contact) && $contact->link_face)
                                            <li class="li d-flex justify-content-start align-items-center">
                                                <a href="{{$contact->link_face}}" rel="nofollow noopener noreferrer" target="_blank">
                                                    <svg width="20" height="30" viewBox="0 0 22 43" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M22 0.310097V7.13221H18.0023C16.5424 7.13221 15.5579 7.44231 15.0486 8.0625C14.5394 8.68269 14.2847 9.61298 14.2847 10.8534V15.7374H21.7454L20.7523 23.3864H14.2847V43H6.49306V23.3864H0V15.7374H6.49306V10.104C6.49306 6.89964 7.37577 4.41456 9.1412 2.64874C10.9066 0.882912 13.2577 0 16.1944 0C18.6898 0 20.625 0.103367 22 0.310097Z" fill="black"/>
                                                    </svg>
                                                </a>
                                            </li>
                                        @endif
                                        @if (isset($contact) && $contact->link_x)
                                            <li class="li d-flex justify-content-start align-items-center">
                                                <a href="{{$contact->link_x}}" rel="nofollow noopener noreferrer" target="_blank">
                                                    <svg width="30" height="30" viewBox="0 0 33 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M26.0074 0H31.0372L19.9963 12.6639L33 30H22.8178L14.8439 19.5492L5.64312 30H0.613383L12.513 16.3525L0 0H10.4275L17.6654 9.59016L26.0074 0ZM24.29 26.9262H26.9888L8.95539 2.95082H5.88848L24.29 26.9262Z" fill="black"/>
                                                    </svg>
                                                </a>
                                            </li>
                                        @endif
                                        @if (isset($contact) && $contact->link_insta)
                                            <li class="li d-flex justify-content-start align-items-center">
                                                <a href="{{$contact->link_insta}}" rel="nofollow noopener noreferrer" target="_blank">
                                                    <svg width="30" height="30" viewBox="0 0 37 37" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M22.86 22.86C22.86 22.86 23.1611 22.5589 23.7633 21.9567C24.3656 21.3545 24.6667 20.2023 24.6667 18.5C24.6667 16.7977 24.0645 15.3444 22.86 14.14C21.6556 12.9355 20.2023 12.3333 18.5 12.3333C16.7977 12.3333 15.3444 12.9355 14.14 14.14C12.9355 15.3444 12.3333 16.7977 12.3333 18.5C12.3333 20.2023 12.9355 21.6556 14.14 22.86C15.3444 24.0645 16.7977 24.6667 18.5 24.6667C20.2023 24.6667 21.6556 24.0645 22.86 22.86ZM25.2207 11.7793C25.2207 11.7793 25.6824 12.241 26.6058 13.1644C27.5292 14.0878 27.9909 15.8663 27.9909 18.5C27.9909 21.1337 27.0675 23.3739 25.2207 25.2207C23.3739 27.0675 21.1337 27.9909 18.5 27.9909C15.8663 27.9909 13.6261 27.0675 11.7793 25.2207C9.93251 23.3739 9.00911 21.1337 9.00911 18.5C9.00911 15.8663 9.93251 13.6261 11.7793 11.7793C13.6261 9.93251 15.8663 9.00912 18.5 9.00912C21.1337 9.00912 23.3739 9.93251 25.2207 11.7793ZM29.9421 7.05794C29.9421 7.05794 30.0505 7.16634 30.2673 7.38314C30.484 7.59994 30.5924 8.01346 30.5924 8.6237C30.5924 9.23394 30.3757 9.75586 29.9421 10.1895C29.5085 10.623 28.9865 10.8398 28.3763 10.8398C27.7661 10.8398 27.2441 10.623 26.8105 10.1895C26.377 9.75586 26.1602 9.23394 26.1602 8.6237C26.1602 8.01346 26.377 7.49154 26.8105 7.05794C27.2441 6.62435 27.7661 6.40755 28.3763 6.40755C28.9865 6.40755 29.5085 6.62435 29.9421 7.05794ZM20.3428 3.31218C20.3428 3.31218 20.0637 3.31418 19.5057 3.3182C18.9476 3.32221 18.6124 3.32422 18.5 3.32422C18.3876 3.32422 17.7733 3.32021 16.6572 3.31218C15.5411 3.30415 14.694 3.30415 14.1159 3.31218C13.5378 3.32021 12.7629 3.34429 11.7913 3.38444C10.8198 3.42459 9.99273 3.50488 9.31022 3.62533C8.62771 3.74577 8.0536 3.89431 7.58789 4.07096C6.78494 4.39214 6.07834 4.85786 5.4681 5.4681C4.85786 6.07834 4.39214 6.78494 4.07096 7.58789C3.89431 8.0536 3.74577 8.62771 3.62533 9.31022C3.50488 9.99273 3.42459 10.8198 3.38444 11.7913C3.34429 12.7629 3.3202 13.5378 3.31217 14.1159C3.30414 14.694 3.30414 15.5411 3.31217 16.6572C3.3202 17.7733 3.32422 18.3876 3.32422 18.5C3.32422 18.6124 3.3202 19.2267 3.31217 20.3428C3.30414 21.4589 3.30414 22.306 3.31217 22.8841C3.3202 23.4622 3.34429 24.2371 3.38444 25.2087C3.42459 26.1802 3.50488 27.0073 3.62533 27.6898C3.74577 28.3723 3.89431 28.9464 4.07096 29.4121C4.39214 30.2151 4.85786 30.9217 5.4681 31.5319C6.07834 32.1421 6.78494 32.6079 7.58789 32.929C8.0536 33.1057 8.62771 33.2542 9.31022 33.3747C9.99273 33.4951 10.8198 33.5754 11.7913 33.6156C12.7629 33.6557 13.5378 33.6798 14.1159 33.6878C14.694 33.6959 15.5411 33.6959 16.6572 33.6878C17.7733 33.6798 18.3876 33.6758 18.5 33.6758C18.6124 33.6758 19.2267 33.6798 20.3428 33.6878C21.4589 33.6959 22.306 33.6959 22.8841 33.6878C23.4622 33.6798 24.2371 33.6557 25.2087 33.6156C26.1802 33.5754 27.0073 33.4951 27.6898 33.3747C28.3723 33.2542 28.9464 33.1057 29.4121 32.929C30.2151 32.6079 30.9217 32.1421 31.5319 31.5319C32.1421 30.9217 32.6079 30.2151 32.929 29.4121C33.1057 28.9464 33.2542 28.3723 33.3747 27.6898C33.4951 27.0073 33.5754 26.1802 33.6156 25.2087C33.6557 24.2371 33.6798 23.4622 33.6878 22.8841C33.6959 22.306 33.6959 21.4589 33.6878 20.3428C33.6798 19.2267 33.6758 18.6124 33.6758 18.5C33.6758 18.3876 33.6798 17.7733 33.6878 16.6572C33.6959 15.5411 33.6959 14.694 33.6878 14.1159C33.6798 13.5378 33.6557 12.7629 33.6156 11.7913C33.5754 10.8198 33.4951 9.99273 33.3747 9.31022C33.2542 8.62771 33.1057 8.0536 32.929 7.58789C32.6079 6.78494 32.1421 6.07834 31.5319 5.4681C30.9217 4.85786 30.2151 4.39214 29.4121 4.07096C28.9464 3.89431 28.3723 3.74577 27.6898 3.62533C27.0073 3.50488 26.1802 3.42459 25.2087 3.38444C24.2371 3.34429 23.4622 3.32021 22.8841 3.31218C22.306 3.30415 21.4589 3.30415 20.3428 3.31218ZM36.8796 10.8639C36.9599 12.2771 37 14.8225 37 18.5C37 22.1775 36.9599 24.7229 36.8796 26.1361C36.719 29.4763 35.7233 32.0618 33.8926 33.8926C32.0618 35.7233 29.4763 36.719 26.1361 36.8796C24.7229 36.9599 22.1775 37 18.5 37C14.8225 37 12.2771 36.9599 10.8639 36.8796C7.52365 36.719 4.93815 35.7233 3.10742 33.8926C1.27669 32.0618 0.281033 29.4763 0.120443 26.1361C0.0401476 24.7229 0 22.1775 0 18.5C0 14.8225 0.0401476 12.2771 0.120443 10.8639C0.281033 7.52365 1.27669 4.93815 3.10742 3.10742C4.93815 1.2767 7.52365 0.281033 10.8639 0.120445C12.2771 0.0401497 14.8225 0 18.5 0C22.1775 0 24.7229 0.0401497 26.1361 0.120445C29.4763 0.281033 32.0618 1.2767 33.8926 3.10742C35.7233 4.93815 36.719 7.52365 36.8796 10.8639Z" fill="black"/>
                                                    </svg>
                                                </a>
                                            </li>
                                        @endif
                                        @if (isset($contact) && $contact->link_youtube)
                                            <li class="li d-flex justify-content-start align-items-center">
                                                <a href="{{$contact->link_youtube}}" rel="nofollow noopener noreferrer" target="_blank">
                                                    <svg width="45" height="30" viewBox="0 0 52 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M20.632 24.6286L34.6759 17.4857L20.632 10.2571V24.6286ZM26 0C29.2498 0 32.3884 0.0428581 35.4158 0.128571C38.4431 0.214287 40.6629 0.30476 42.075 0.400002L44.1932 0.514286C44.2125 0.514286 44.377 0.528572 44.6865 0.557144C44.996 0.585712 45.2184 0.614285 45.3538 0.642857C45.4892 0.671429 45.7165 0.714287 46.0357 0.771427C46.3549 0.828571 46.6305 0.904762 46.8627 1C47.0948 1.09524 47.3656 1.21905 47.6751 1.37143C47.9846 1.52381 48.2845 1.70952 48.5746 1.92857C48.8648 2.14762 49.1453 2.4 49.4161 2.68571C49.5322 2.8 49.6821 2.97619 49.8659 3.21429C50.0496 3.45238 50.3301 4.00952 50.7073 4.88571C51.0845 5.7619 51.3408 6.72381 51.4763 7.77143C51.631 8.99048 51.7519 10.2905 51.839 11.6714C51.926 13.0524 51.9792 14.1333 51.9986 14.9143V16.0571V19.9429C52.0179 22.7048 51.8438 25.4667 51.4763 28.2286C51.3408 29.2762 51.099 30.2238 50.7509 31.0714C50.4027 31.919 50.0932 32.5048 49.8223 32.8286L49.4161 33.3143C49.1453 33.6 48.8648 33.8524 48.5746 34.0714C48.2845 34.2905 47.9846 34.4714 47.6751 34.6143C47.3656 34.7571 47.0948 34.8762 46.8627 34.9714C46.6305 35.0667 46.3549 35.1429 46.0357 35.2C45.7165 35.2571 45.4844 35.3 45.3393 35.3286C45.1942 35.3571 44.9718 35.3857 44.672 35.4143C44.3721 35.4429 44.2125 35.4571 44.1932 35.4571C39.3378 35.819 33.2734 36 26 36C21.9958 35.9619 18.5186 35.9 15.5687 35.8143C12.6187 35.7286 10.6794 35.6571 9.75091 35.6L8.32911 35.4857L7.28453 35.3714C6.58814 35.2762 6.06101 35.181 5.70314 35.0857C5.34527 34.9905 4.852 34.7905 4.22331 34.4857C3.59463 34.181 3.04816 33.7905 2.5839 33.3143C2.46783 33.2 2.31791 33.0238 2.13414 32.7857C1.95037 32.5476 1.66988 31.9905 1.29267 31.1143C0.915462 30.2381 0.659152 29.2762 0.523743 28.2286C0.36899 27.0095 0.248089 25.7095 0.16104 24.3286C0.0739914 22.9476 0.020795 21.8667 0.00145081 21.0857V19.9429V16.0571C-0.0178933 13.2952 0.156204 10.5333 0.523743 7.77143C0.659152 6.72381 0.900954 5.77619 1.24915 4.92857C1.59734 4.08095 1.90685 3.49524 2.17767 3.17143L2.5839 2.68571C2.85471 2.4 3.1352 2.14762 3.42537 1.92857C3.71553 1.70952 4.01536 1.52381 4.32487 1.37143C4.63438 1.21905 4.9052 1.09524 5.13732 1C5.36945 0.904762 5.64511 0.828571 5.96429 0.771427C6.28347 0.714287 6.51076 0.671429 6.64617 0.642857C6.78158 0.614285 7.00404 0.585712 7.31354 0.557144C7.62305 0.528572 7.78747 0.514286 7.80682 0.514286C12.6622 0.171429 18.7266 0 26 0Z" fill="black"/>
                                                    </svg>
                                                </a>
                                            </li>
                                        @endif                                    
                                    </ul> 
                                </nav>
                            </div>
                        </div>
                        <!-- Newsletter End -->
                    @endif

                    {{-- @if($tempo)
                        <div class="card border-0 shadow-sm col-12 mb-4">
                            <div class="card-body d-flex align-items-center gap-3 py-2">
        
                                <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center"
                                        style="width:42px;height:42px;">
                                    <i class="bi bi-cloud-sun fs-5"></i>
                                </div>
        
                                <div class="flex-grow-1">
                                    <small class="m-0 poppins-bold font-15 title-blue">Lauro de Freitas</small>
                                    <div class="m-0 poppins-bold font-15 title-blue">
                                        {{ $tempo['temperature'] }}°C
                                        <span class="m-0 poppins-regular font-15 text-muted">
                                            • Vento {{ $tempo['windspeed'] }} km/h
                                        </span>
                                    </div>
                                </div>
        
                            </div>
                        </div>
                    @endif --}}
                    <div class="mb-4">
                        <table class="table table-striped table-sm align-middle">
                            <thead>
                                <tr>
                                    <th class="py-2 m-0 poppins-semiBold font-15 title-blue">#</th>
                                    <th class="py-2 m-0 poppins-semiBold font-15 title-blue">Time</th>
                                    <th class="py-2 m-0 poppins-semiBold font-15 title-blue">P</th>
                                    <th class="py-2 m-0 poppins-semiBold font-15 title-blue">J</th>
                                    <th class="py-2 m-0 poppins-semiBold font-15 title-blue">V</th>
                                    <th class="py-2 m-0 poppins-semiBold font-15 title-blue">E</th>
                                    <th class="py-2 m-0 poppins-semiBold font-15 title-blue">D</th>
                                    <th class="py-2 m-0 poppins-semiBold font-15 title-blue">SG</th>
                                </tr>
                            </thead>

                            <tbody>
                                {{-- @foreach($standings as $team)
                                    <tr>
                                        <td class="p-2 m-0 poppins-regular font-15 title-blue">{{ $team['position'] ?? '-' }}</td>

                                        <td class="py-2 d-flex align-items-center gap-2 m-0 poppins-regular font-15 title-blue">
                                            <img 
                                                src="{{ $team['team']['crest'] ?? '' }}" 
                                                width="20" 
                                                height="20"
                                                style="object-fit: contain;"
                                                alt="{{ $team['team']['shortName'] ?? $team['team']['name'] }}"
                                            >

                                            {{ $team['team']['shortName'] ?? $team['team']['name'] ?? '-' }}
                                        </td>

                                        <td class="py-2 m-0 poppins-semiBold font-15 title-blue">{{ $team['points'] ?? 0 }}</td>

                                        <td class="py-2 m-0 poppins-regular font-15 title-blue">{{ $team['playedGames'] ?? 0 }}</td>

                                        <td class="py-2 m-0 poppins-regular font-15 title-blue">{{ $team['won'] ?? 0 }}</td>

                                        <td class="py-2 m-0 poppins-regular font-15 title-blue">{{ $team['draw'] ?? 0 }}</td>

                                        <td class="py-2 m-0 poppins-regular font-15 title-blue">{{ $team['lost'] ?? 0 }}</td>

                                        <td class="py-2 m-0 poppins-regular font-15 title-blue">{{ $team['goalDifference'] ?? 0 }}</td>
                                    </tr>
                                @endforeach                                 --}}
                            </tbody>
                        </table>
                    </div>

                    <!-- Todas as emergências em um único bloco -->
                    <div class="mb-4">
                        <div class="bg-white border rounded-1 p-3">
                            <div class="section-title mb-0 rounded-top-left cat-mt">
                                <h4 class="mb-3 poppins-bold font-18 border-bottom title-blue pb-3 news">Emergência e Serviços</h4>
                            </div>
                            <div class="d-flex flex-wrap m-n1">
                                <li class="nav-link">
                                    <a href="tel:190" class="btn btn-sm title-blue rounded-0 poppins-semiBold font-12 m-1 bg-blue-light">Polícia Militar – 190</a>
                                </li>
                                <li class="nav-link">
                                    <a href="tel:192" rel="noopener noreferrer" class="btn btn-sm title-blue rounded-0 poppins-semiBold font-12 m-1 bg-blue-light">SAMU – 192</a>
                                </li>
                                <li class="nav-link">
                                    <a href="tel:193" rel="noopener noreferrer" class="btn btn-sm title-blue rounded-0 poppins-semiBold font-12 m-1 bg-blue-light">Bombeiros – 193</a>
                                </li>
                                <li class="nav-link">
                                    <a href="tel:181" rel="noopener noreferrer" class="btn btn-sm title-blue rounded-0 poppins-semiBold font-12 m-1 bg-blue-light">Disque Denúncia – 181</a>
                                </li>
                                <li class="nav-link">
                                    <a href="tel:180" rel="noopener noreferrer" class="btn btn-sm title-blue rounded-0 poppins-semiBold font-12 m-1 bg-blue-light">Violência Doméstica – 180</a>
                                </li>
                                <li class="nav-link">
                                    <a href="https://delegaciavirtual.sinesp.gov.br/portal/" rel="noopener noreferrer" target="_blank" class="btn btn-sm title-blue rounded-0 poppins-semiBold font-12 m-1 bg-blue-light">Delegacia Online</a>
                                </li>
                                <li class="nav-link">
                                    <a href="https://www.consumidor.gov.br/pages/principal/?1458674034017" rel="noopener noreferrer" target="_blank" class="btn btn-sm title-blue rounded-0 poppins-semiBold font-12 m-1 bg-blue-light">Procon</a>
                                </li>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endif


@if ($blogNoBairros->count() > 0) 
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
@endif

<style>
.swiper-button-prev-one,
.swiper-button-next-one {
    position: relative; /* mantém o botão no topo, onde você colocou */
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

    <style>

.video-thumb {
    position: relative;
    height: 160px;
    overflow: hidden;
    border-radius: 4px;
    background: #000;
}
.video-thumb ,.video-intro{
    width: 95%;
    margin: 0 auto;
    margin-right: 0;
}
.video-thumb img {
    display: block;
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.video-play {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: rgba(0, 0, 0, 0.65);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 13px;
    pointer-events: none;
}

.video-play i {
    margin-left: 2px;
}
        .color1 {
            background: #ffe7e6;
        }
        .youtube-area .video-items iframe{
            width:100%;
            height:465px
        }
        .youtube-area .video-info{
            border-bottom:1px solid #ddd
        }
        .youtube-area .video-info .video-caption{
            position:relative;
            top:-90px
        }
        .youtube-area .video-info .video-caption .top-caption{
            background:#fff;
            width:60%;
            border-radius:0 7px 0 0;
            padding-top:60px;
            padding-bottom:30px
        }
        .youtube-area .video-info .video-caption .top-caption span{
            padding:7px 30px;
            line-height:1;
            color:#000;
            text-transform:uppercase;
            font-weight:600;
            font-size:11px
        }
        .youtube-area .video-info .video-caption .bottom-caption h2{
            font-size:30px;
            font-weight:700;
            margin-bottom:27px
        }
        .youtube-area .video-info .video-caption .bottom-caption p{
            color:#777;
            font-size:14px;
            line-height:1.7;
            padding-right:32px
        }
        .youtube-area .testmonial-nav{
            width:100%;
            margin-top:40px
        }
        @media only screen and (min-width: 768px) and (max-width: 991px){
            .youtube-area .testmonial-nav{
                margin-top:0px
            }
        }
        @media (max-width: 767px){
            .youtube-area .testmonial-nav{
                margin-top:0px
            }
        }
        @media only screen and (min-width: 576px) and (max-width: 767px){
            .youtube-area .testmonial-nav{
                margin-top:0px
            }
        }
        .youtube-area .testmonial-nav button{
            position:absolute;
            color:#333;
            border:none;
            font-size:21px;
            background:#f3f4f8;
            width:55px;
            height:55px;
            border-radius:10px;
            color:#bdbdbd;
            left:-421px;
            top:-114px;
            cursor:pointer
        }
        @media only screen and (min-width: 992px) and (max-width: 1199px){
            .youtube-area .testmonial-nav button{
                left:-348px
            }
        }
        .youtube-area .testmonial-nav button.slick-next{
            left:-340px;
            background:red;
            color:#fff
        }
        @media only screen and (min-width: 992px) and (max-width: 1199px){
            .youtube-area .testmonial-nav button.slick-next{
                left:-280px
            }
        }
        .youtube-area .single-video iframe{
            padding:0 5px;
            width:100%
        }
        .youtube-area .single-video .video-intro h4{
            font-size:14px;
            font-weight:500;
            text-align:start;
            padding:0 5px;
            line-height:1.3;
        }
        @media only screen and (min-width: 992px) and (max-width: 1199px){
            .youtube-area .single-video .video-intro h4{
                font-size:14px
            }
        }
        .video-padding{
            padding-top:100px;
            padding-bottom:45px
        }
        @media only screen and (min-width: 1200px) and (max-width: 1600px){
            .video-padding{
                padding-top:100px;
                padding-bottom:45px
            }
        }
        @media only screen and (min-width: 992px) and (max-width: 1199px){
            .video-padding{
                padding-top:100px;
                padding-bottom:45px
            }
        }
        @media only screen and (min-width: 768px) and (max-width: 991px){
            .video-padding{
                padding-top:100px;
                padding-bottom:45px
            }
        }
        @media only screen and (min-width: 576px) and (max-width: 767px){
            .video-padding{
                padding-top:100px;
                padding-bottom:45px
            }
        }
    </style>

@if ($events->count() > 0)                    
    <div class="container mt-5" data-aos="fade-left" data-aos-delay="30">
        <div class="border-bottom news mb-0">
            <div class="d-flex flex-row justify-content-between align-items-start align-items-md-center">
                <h2 class="section-title d-table p-0 w-auto m-0 mb-3 poppins-bold font-28 title-blue">
                    Próximos Eventos
                </h2>        
                <div class="btn-about">
                    <a href="{{route('client.event')}}" class="font-mob background-red poppins-semiBold font-18 py-1 py-lg-2 px-2 px-lg-4 rounded-0">Ver todos</a>
                </div>                         
            </div>
        </div>

        <div class="py-3 mt-5 row row-cols-4 g-2">      
            @foreach($events as $event)                        
                <article class="col-12 col-sm-6 col-lg-3">
                    <div class="d-flex align-items-center bg-white mb-3 overflow-hidden shadow-video-current" style="height: 80px;">
                        <div class="background-red date col-4 h-100 d-flex justify-content-center align-items-center">
                            <span class="poppins-bold col-9 h-100 d-flex justify-content-center align-items-center font-20 text-white">
                                {{ \Carbon\Carbon::parse($event->date)->format('d') }}
                            </span>
                            <span class="border-start vertical-letters poppins-medium col-3 h-100 d-flex justify-content-center align-items-center font-14 title-blue text-white">
                                {{ strtoupper(substr(\Carbon\Carbon::parse($event->date)->translatedFormat('F'), 0, 3)) }}
                            </span>

                        </div>
                        <div class="col-8 h-100 px-2 d-flex flex-row justify-content-center align-items-center border border-left-0">
                            @if($event->link)
                                <a href="{{ $event->link }}" class="underline col-11">
                            @else
                                <a href="{{ route('client.event') }}?event_id={{ $event->id }}&scroll=true" class="underline col-11">
                            @endif
                                <h3 class="h6 m-0 poppins-bold font-14 title-blue font-mob" title="{{$event->title}}">
                                    {{ substr(strip_tags($event->title), 0, 50) }}...
                                </h3>
                            </a>
                            <svg width="17" height="25" viewBox="0 0 17 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M3.59467 25L16.2613 12.5L3.59467 0L0 3.54737L9.07467 12.5L0 21.4526L3.59467 25Z" fill="black"/>
                            </svg>
                        </div>
                    </div>
                </article>
            @endforeach                                   
        </div>

        @if ($announcements->count())                        
            <div class="my-5">
                @include('client.includes.announcement')
            </div>
        @endif
    </div>
@endif

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

{{-- <script defer>
    document.addEventListener('DOMContentLoaded', function() {
        const categoryLinks = document.querySelectorAll('.category-filter');
        const newsContainer = document.getElementById('news-container');

        categoryLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                // Ativar/desativar classes visuais
                categoryLinks.forEach(l => {
                    l.parentElement.classList.remove('active', 'text-white', 'background-red');
                    l.parentElement.classList.add('text-black');
                    l.classList.remove('text-white');
                    l.classList.add('text-black');
                });

                this.parentElement.classList.add('active', 'text-white', 'background-red');
                this.parentElement.classList.remove('text-black');
                this.classList.add('text-white');
                this.classList.remove('text-black');

                const categorySlug = this.getAttribute('data-category');
                
                // Loading indicator
                newsContainer.innerHTML = `
                    <div class="col-12 text-center py-5">
                        <div class="spinner-border text-blue" role="status">
                            <span class="visually-hidden poppins-semiBold font-15">Carregando...</span>
                        </div>
                        <p class="mt-2 poppins-semiBold font-15">Carregando notícias...</p>
                    </div>
                `;

                // Fazer requisição AJAX
                fetch(`blog/filter/${categorySlug}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Erro na rede');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            newsContainer.innerHTML = data.html;
                        } else {
                            throw new Error(data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        newsContainer.innerHTML = `
                            <div class="col-12 text-center py-5">
                                <p class="text-danger poppins-semiBold font-15">Erro ao carregar notícias: ${error.message}</p>
                            </div>
                        `;
                    });
            });
        });
    });
</script> --}}


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


<script defer>
    document.addEventListener("DOMContentLoaded", function () {
        const btn = document.getElementById("btn-ver-mais");
        if (!btn) return;

        btn.addEventListener("click", function () {
            document.querySelectorAll(".rel-item").forEach(el => el.classList.remove("d-none"));
            btn.style.display = "none"; // remove o botão após expandir
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
            pagination: {
                el: '.swiper-pagination.news',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
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
