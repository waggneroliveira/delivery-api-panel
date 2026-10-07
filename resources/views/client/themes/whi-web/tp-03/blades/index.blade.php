@extends($theme->core('client'))
@section('content')
    <div class="container pt-0 pb-3">
        @if (isset($announcements['top-center']) && $announcements['top-center']->isNotEmpty())
            <div class="ad-container mb-3 mb-lg-5 overflow-hidden bg-transparent border-0 m-0 p-0">
                <div class="ad-placeholder bg-transparent">
                    <!-- Espaço para Banner Adsense -->
                    @includeIf('client.components.announcement.all-announcement', [
                            'announcements' => $announcements['top-center'] ?? collect()
                        ]
                    )
                </div>
            </div>
        @endif
        
        <div class="row g-4">
            <div class="col-lg-3 order-lg-1 order-1">
                <div class="sidebar-card mb-0">
                    <div class="d-flex align-items-center mb-3 px-2">
                        <i class="bi bi-grid-3x3-gap-fill fs-5 text-primary me-2"></i>
                        <h6 class="fw-bold mb-0">Todas as ferramentas</h6>
                    </div>
                    <div class="swiper tools-swiper">
                        <nav class="nav nav-pills flex-column swiper-wrapper" id="toolsNav">
                            <a class="nav-link active tool-item swiper-slide"
                                data-tool="calc-juros" data-cat="calculadoras">
                                <i class="bi bi-percent"></i> Calc. Juros
                            </a>

                            <a class="nav-link tool-item swiper-slide"
                                data-tool="calc-porcentagem" data-cat="calculadoras">
                                <i class="bi bi-calculator-fill"></i> Calc. Porcentagem
                            </a>

                            <a class="nav-link tool-item swiper-slide"
                                data-tool="calc-financiamento" data-cat="calculadoras">
                                <i class="bi bi-house"></i> Calc. Financiamento
                            </a>

                            <a class="nav-link tool-item swiper-slide"
                                data-tool="format-json" data-cat="validadores">
                                <i class="bi bi-braces"></i> Formatador JSON
                            </a>

                            <a class="nav-link tool-item swiper-slide"
                                data-tool="gerar-cartao" data-cat="geradores">
                                <i class="bi bi-credit-card"></i> Gerar Cartão
                            </a>

                            <a class="nav-link tool-item swiper-slide"
                                data-tool="gerar-cpf" data-cat="geradores">
                                <i class="bi bi-person-badge"></i> Gerar CPF
                            </a>

                            <a class="nav-link tool-item swiper-slide"
                                data-tool="validar-cpf" data-cat="validadores">
                                <i class="bi bi-check-circle"></i> Validar CPF
                            </a>

                            <a class="nav-link tool-item swiper-slide"
                                data-tool="gerar-cnpj" data-cat="geradores">
                                <i class="bi bi-building"></i> Gerar CNPJ
                            </a>

                            <a class="nav-link tool-item swiper-slide"
                                data-tool="gerar-senhas" data-cat="geradores">
                                <i class="bi bi-lock-fill"></i> Gerador Senhas
                            </a>

                            <a class="nav-link tool-item swiper-slide"
                                data-tool="gerar-uuid" data-cat="geradores">
                                <i class="bi bi-hash"></i> Gerador UUID
                            </a>

                            <a class="nav-link tool-item swiper-slide"
                                data-tool="conversor-moedas" data-cat="conversores">
                                <i class="bi bi-currency-dollar"></i> Conversor Moedas
                            </a>

                            <a class="nav-link tool-item swiper-slide"
                                data-tool="contador-palavras" data-cat="calculadoras">
                                <i class="bi bi-text-paragraph"></i> Contador Palavras
                            </a>

                            <a class="nav-link tool-item swiper-slide"
                                data-tool="sorteador-numeros" data-cat="geradores">
                                <i class="bi bi-dice-6"></i> Sorteador Números
                            </a>

                            <a class="nav-link tool-item swiper-slide"
                                data-tool="conversor-unidades" data-cat="conversores">
                                <i class="bi bi-rulers"></i> Conversor Unidades
                            </a>

                            <a class="nav-link tool-item swiper-slide"
                                data-tool="gerador-qr" data-cat="geradores">
                                <i class="bi bi-qr-code"></i> Gerador QR Code
                            </a>
                        </nav>
                        
                        <!-- Navegação -->
                        <div class="tools-swiper-navigation">
                            <button type="button" class="tools-swiper-prev">
                                <i class="bi bi-chevron-left"></i>
                            </button>

                            <div class="tools-swiper-pagination"></div>

                            <button type="button" class="tools-swiper-next">
                                <i class="bi bi-chevron-right"></i>
                            </button>
                        </div>
                    </div>
                    @if (isset($announcements['sidebar-left']) && $announcements['sidebar-left']->isNotEmpty()) 
                        <div class="ad-container mt-4 sidebar-left">
                            <p><i class="bi bi-megaphone"></i> PUBLICIDADE</p>
                            <div class="ad-placeholder overflow-hidden">
                                <!-- Seu anúncio aqui<br>(Google Ads) -->
                                    @includeIf('client.components.announcement.all-announcement', [
                                            'announcements' => $announcements['sidebar-left'] ?? collect()
                                        ]
                                    )
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            
            <div class="col-lg-6 order-lg-2 order-2 mt-4">
                <div class="main-content-card p-4 p-xl-4">
                    <div id="toolContent" class="fade-tool" style="opacity: 1">
                        <div class="text-center py-5">
                            <div class="spinner-border text-primary"></div>
                            <p class="mt-3">Carregando ferramenta...</p>
                        </div>
                    </div>
                </div>
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
            
            @if (isset($announcements['sidebar-right']) && $announcements['sidebar-right']->isNotEmpty())                
                <div class="col-lg-3 order-lg-3 order-3">
                    <div class="sidebar-card" style="background: white">
                        <div class="ad-container mb-3 sidebar-right">
                            <p><i class="bi bi-display"></i> DESTAQUE</p>
                            <div class="ad-placeholder overflow-hidden" style="min-height: 250px">
                                <!-- Anúncio 300x250 -->  
                                @includeIf('client.components.announcement.all-announcement',[
                                        'announcements' => $announcements['sidebar-right'] ?? collect()
                                    ]
                                )
                            </div>
                        </div>
                        <div class="mt-3 p-2 bg-light rounded-4 text-center small text-muted">
                            <i class="bi bi-shield-check text-success"></i> Processamento 100% local<br />Seus dados nunca saem
                            do seu dispositivo                        
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toolsSwiper = new Swiper('.tools-swiper', {
                slidesPerView: 'auto',
                spaceBetween: 8,
                freeMode: true,
                grabCursor: true,
                navigation: {
                    nextEl: '.tools-swiper-next',
                    prevEl: '.tools-swiper-prev',
                },
                breakpoints: {
                    768: {
                        enabled: false
                    }
                }
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof Swiper === 'undefined') {
                return;
            }

            document.querySelectorAll('.announcement-swiper').forEach(function (element) {
                const slides = element.querySelectorAll('.swiper-slide');

                new Swiper(element, {
                    effect: 'fade',
                    fadeEffect: {
                        crossFade: true,
                    },
                    slidesPerView: 1,
                    spaceBetween: 0,
                    loop: false,

                    allowTouchMove: false,
                    simulateTouch: false,

                    autoplay: slides.length > 1 ? {
                        delay: 7000,
                        disableOnInteraction: false,
                    } : false,
                });
            });
        });
    </script>
    <style>
        .swiper-fade .swiper-slide{
            /* opacity: 1 !important; */
        }
    </style>
@endsection
