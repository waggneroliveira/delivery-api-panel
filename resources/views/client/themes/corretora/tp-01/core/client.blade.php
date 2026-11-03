<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="index, follow">
    <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="theme-color" content="#0d0d0d">
    <meta name="description" content="A Girollato é uma distribuidora especializada em rações, alimentos e artigos pet, oferecendo produtos de qualidade para cães, gatos e outros animais com variedade, cuidado e confiança.">
    <meta name="keywords" content="Girollato, distribuidora de rações, artigos pet, produtos pet, ração para cães, ração para gatos, acessórios pet, pet shop, alimentos para animais, higiene pet, brinquedos para pets, areia para gatos, distribuidora pet, casa de ração, produtos para cães e gatos, pet store, ração premium, produtos pet em Lauro de Freitas, distribuidora de rações Bahia">    <meta name="google-site-verification" content="-bUd4PZJ-3xvnf7cOkcmNLV7jzTk5106hfB0mPtvhqE" />
    <title>Corretora</title>
    @if(isset($blogInner))
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:type" content="article">
        <meta property="og:title" content="{{ $blogInner->title }}">
        <meta property="og:description" content="{{ Str::limit(strip_tags($blogInner->text), 150) }}">
        <meta property="og:image" content="{{ asset('storage/' . $blogInner->path_image_thumbnail) }}">

        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:url" content="{{ url()->current() }}">
        <meta name="twitter:title" content="{{ $blogInner->title }}">
        <meta name="twitter:description" content="{{ Str::limit(strip_tags($blogInner->text), 150) }}">
        <meta name="twitter:image" content="{{ asset('storage/' . $blogInner->path_image_thumbnail) }}">
    @else
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:type" content="website">
        <meta property="og:title" content="Girollato">
        <meta property="og:description" content="A Girollato é uma distribuidora especializada em rações, alimentos e artigos pet, oferecendo produtos de qualidade para cães, gatos e outros animais com variedade, cuidado e confiança.">
        <meta property="og:image" content="https://girolato.com.br/build/client/images/logo.svg">

        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:url" content="{{ url()->current() }}">
        <meta name="twitter:title" content="Girollato">
        <meta name="twitter:description" content="A Girollato é uma distribuidora especializada em rações, alimentos e artigos pet, oferecendo produtos de qualidade para cães, gatos e outros animais com variedade, cuidado e confiança.">
        <meta name="twitter:image" content="https://girolato.com.br/build/client/images/logo.svg">
    @endif

    
    <link rel="canonical" href="{{ url()->current() }}">
    <meta name="copyright" content="Direitos reservados WHI">
    <meta name="author" content="WHI">
    <link rel="shortcut icon" href="https://girolato.com.br/build/client/images/favicon.png">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>    
    <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Changa:wght@200..800&display=swap" onload='this.onload=null,this.rel="stylesheet"'>
    <noscript>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Changa:wght@200..800&display=swap">
    </noscript>

    <link rel="preload" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css"></noscript>
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"></noscript>
    <link href="{{ asset('build/client/lgpd/style.css') }}" rel="stylesheet" type="text/css" />

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link href="{{ asset('build/client/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel="preload" href="{{ asset('build/client/bootstrap-icons/bootstrap-icons.css') }}" as="style" onload="this.rel='stylesheet'">
    <link href="{{ asset('build/client/themes/corretora/tp-01/css/style.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('build/client/themes/corretora/tp-01/css/responsivo.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('build/client/css/default.css') }}" rel="stylesheet" type="text/css" />

    <script type=application/ld+json>
        {
            "@context": "https://schema.org",
            "@type": "Organization",
            "@id": "#organization",
            "name": "Girollato",
            "legalName": "Girollato",
            "url": "https://girolato.com.br/",
            "logo": "https://girolato.com.br/build/client/images/logo.svg",
            "image": "https://girolato.com.br/build/client/images/logo.svg",
            "description": "A Girollato é uma distribuidora especializada em rações, alimentos e artigos pet, oferecendo produtos de qualidade para cães, gatos e outros animais com variedade, cuidado e confiança.",
            "foundingDate": "2010",
            "email": "contato@girollato.com.br",
            "telephone": "+55 71 9 9623-8037",
            "address": {
                "@type": "PostalAddress",
                "streetAddress": "Alameda Maji, 144 - Quingoma",
                "addressLocality": "Lauro de Freitas",
                "addressRegion": "BA",
                "postalCode": "42725-610",
                "addressCountry": "BR"
            },
            "contactPoint": {
                "@type": "ContactPoint",
                "telephone": "+55 71 9 9623-8037",
                "contactType": "customer service",
                "email": "contato@girollato.com.br",
                "areaServed": "BR",
                "availableLanguage": ["pt", "en"]
            },
            "openingHoursSpecification": {
                "@type": "OpeningHoursSpecification",
                "dayOfWeek": ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday"],
                "opens": "08:00",
                "closes": "17:00"
            },
            "slogan": "Girollato",
            "keywords": [
                "distribuidora de rações",
                "ração para cães",
                "ração para gatos",
                "artigos pet",
                "produtos pet",
                "acessórios para pets",
                "pet shop",
                "distribuidora pet",
                "alimentos para animais",
                "ração premium",
                "ração super premium",
                "produtos para cães e gatos",
                "brinquedos para pets",
                "higiene pet",
                "areia para gatos",
                "pet store",
                "distribuidor de produtos pet",
                "ração em Lauro de Freitas",
                "produtos pet em Lauro de Freitas",
                "distribuidora de rações Bahia",
                "produtos para animais domésticos",
                "suplementos pet",
                "petshop online",
                "casa de ração",
                "loja pet"
            ]
        }
    </script>
</head>
<body>
    <div id="organization" hidden></div>

    <header class="border-bottom bg-transparent fixed-top">
        <nav class="navbar navbar-expand-lg navbar-light py-4">
            <div class="container">

                <!-- Logo -->
                <a class="navbar-brand me-5" href="{{route('index')}}">
                    <img src="{{asset('storage/' .$tenantTheme->path_image_logo_header)}}" alt="Girollato" height="40">
                </a>

                <!-- Mobile -->
                <button class="navbar-toggler" type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#navbarSite">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Menu -->
                <div class="collapse navbar-collapse" id="navbarSite">

                    <ul class="navbar-nav mx-auto align-items-lg-center gap-1">

                        <li class="nav-item">
                            <a class="nav-link text-white font-changa font-16 font-regular font-header active position-relative" href="{{route('index')}}">
                                Home
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link text-white font-changa font-16 font-regular font-header" href="#">
                                Quem Somos
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link text-white font-changa font-16 font-regular font-header" href="{{route('imovel')}}">
                                Imóveis
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link text-white font-changa font-16 font-regular font-header" href="#">
                                Engenharia
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link text-white font-changa font-16 font-regular font-header" href="#">
                                Blog
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link text-white font-changa font-16 font-regular font-header" href="#">
                                Contato
                            </a>
                        </li>

                    </ul>

                    <!-- Botões -->
                    <div class="d-flex align-items-center gap-3">

                        <a href="#" class="btn btn-outline-info rounded-pill px-4">
                            Simule Aqui
                        </a>

                    </div>

                </div>

            </div>
        </nav>
    </header>

    <main>
        @yield('content') 
    </main>

    {{-- footer tp-01 --}}
    <footer class="bg-yellow text-white pt-5 pb-3">
        <div class="container">

            <!-- Linha principal -->
            <div class="row align-items-start">

                <!-- Logo + botão -->
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <img src="{{asset('storage/' .$tenantTheme->path_image_logo_footer)}}" alt="Girollato" height="40">

                    <div class="mt-5">
                        <a href="{{ request()->routeIs('about') ? '#team-section' : route('about') . '#team-section' }}" class="border-btn-footer btn bg-yellow px-4 py-2 rounded-pill font-changa color-green font-16 font-medium text-decoration-none">
                            Encontrar Representantes
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>

                <!-- Mapa do site -->
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <h6 class="font-changa font-16 font-bold mb-3 position-relative d-inline-block font-changa font-16 font-medium">
                        Mapa do Site
                        <span class="d-block bg-yellow mt-1" style="height:3px; width:40px;"></span>
                    </h6>

                    <div class="row">
                        <div class="col-6">
                            <ul class="list-unstyled">
                                <li><a href="{{route('index')}}" class="font-changa font-16 font-regular text-white text-decoration-none d-block mb-2">Início</a></li>
                                <li><a href="{{route('about')}}" class="font-changa font-16 font-regular text-white text-decoration-none d-block mb-2">Quem Somos</a></li>
                                <li><a href="{{ request()->routeIs('index') ? '#stats-section' : route('index') . '#stats-section' }}" class="font-changa font-16 font-regular text-white text-decoration-none d-block mb-2">Diferenciais</a></li>
                                <li><a href="{{route('blogAll')}}" class="font-changa font-16 font-regular text-white text-decoration-none d-block mb-2">Blog</a></li>
                                <li><a href="{{route('products')}}" class="font-changa font-16 font-regular text-white text-decoration-none d-block mb-2">Produtos</a></li>
                            </ul>
                        </div>

                        <div class="col-6">
                            <ul class="list-unstyled">
                                <li><a href="{{ request()->routeIs('index') ? '#depoiment' : route('index') . '#depoiment' }}" class="font-changa font-16 font-regular text-white text-decoration-none d-block mb-2">Depoimentos</a></li>
                                <li><a href="{{ request()->routeIs('index') ? '#faq' : route('index') . '#faq' }}" class="font-changa font-16 font-regular text-white text-decoration-none d-block mb-2">FAQ</a></li>
                                <li><a href="{{route('contact')}}" class="font-changa font-16 font-regular text-white text-decoration-none d-block mb-2">Contato</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Redes sociais -->
                @if (isset($contact) && (
                    $contact->link_insta ||
                    $contact->link_face ||
                    $contact->link_tik_tok
                ))
                    <div class="col-lg-2 text-lg-end">
                        <div class="d-flex gap-3 justify-content-lg-end">
                            @if ($contact->link_insta <> null)                            
                                <a href="{{$contact->link_insta}}" target="_blank" rel="noopener noreferrer" class="text-white fs-5">
                                    <i class="bi bi-instagram"></i>
                                </a>
                            @endif
                            @if ($contact->link_face <> null)                            
                                <a href="{{$contact->link_face}}" target="_blank" rel="noopener noreferrer" class="text-white fs-5">
                                    <i class="bi bi-facebook"></i>
                                </a>
                            @endif
                            @if ($contact->link_tik_tok <> null)                            
                                <a href="{{$contact->link_tik_tok}}" target="_blank" rel="noopener noreferrer" class="text-white fs-5">
                                    <i class="bi bi-linkedin"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                @endif

            </div>

            <!-- Linha inferior -->
            <hr class="border-light opacity-25 my-4">

            <div class="row align-items-center">

                <div class="col-md-10 small">
                    <div class="d-flex flex-wrap col-12 font-changa font-16 font-regular text-center text-lg-end justify-content-center justify-content-lg-end">
                        <p id="footer-text"></p>                        
                    </div>

                    <script defer>
                        const currentYeaar = (new Date).getFullYear();
                        document.getElementById("footer-text").innerHTML = `© ${currentYeaar} <span> Transportes e Atacadista de Rações LTDA.
                    Todos os direitos reservados.</span> <a href="https://policies.google.com/privacy?hl=pt-BR" target="_blank" class="text-white font-semibold">| Política de Privacidade</a>`
                    </script>
                </div>

                <div class="col-12 col-md-2 text-center text-md-end mt-3 mt-md-0">
                    <a href="http://www.whi.dev.br" target="_blank" rel="noopener noreferrer">
                        <img src="{{asset('build/client/images/whi.svg')}}" alt="Agência WHI" style="height:35px;">
                    </a>
                </div>

            </div>

        </div>
    </footer>
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>


    <script src="https://cdn.ckeditor.com/4.22.1/basic/ckeditor.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('build/client/bootstrap/js/bootstrap.bundle.js') }}"></script>
    <script src="{{ asset('build/client/lgpd/script.js') }}"></script>
    <script src="{{ asset('build/client/themes/petshop/tp-01/js/default.js') }}"></script>
    <script src="{{ asset('build/client/js/default.js') }}"></script>

</body>
</html>
