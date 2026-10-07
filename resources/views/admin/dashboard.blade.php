@extends('admin.core.admin')

@section('content')
    @php
        /*
        |--------------------------------------------------------------------------
        | Tema atual
        |--------------------------------------------------------------------------
        */
        $templateSlug = $theme->slug ?? 'default';
        $layoutType = $theme->layout_type ?? 'onepage';

        /*
        |--------------------------------------------------------------------------
        | Módulos do layout atual
        |--------------------------------------------------------------------------
        |
        | A configuração agora é específica por:
        |
        | template
        |   -> layout
        |       -> template variation
        |           -> página
        |               -> módulos
        |
        | Exemplo:
        |
        | ecommerce
        |   multipage
        |       tp-01
        |           home
        |           about
        |           products
        |           contact
        |
        |--------------------------------------------------------------------------
        */
        $layoutConfig = config(
            "template_modules.{$templateSlug}.{$layoutType}.{$theme->template_variation}",
            []
        );

        /*
        |--------------------------------------------------------------------------
        | Fallback caso não exista configuração específica da variação
        |--------------------------------------------------------------------------
        */
        if (empty($layoutConfig)) {
            $layoutConfig = config(
                "template_modules.{$templateSlug}.{$layoutType}.tp-01",
                []
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Páginas e módulos disponíveis
        |--------------------------------------------------------------------------
        |
        | No OnePage tudo pertence à Home.
        |
        | No Multipage cada chave representa uma página real do template.
        |
        |--------------------------------------------------------------------------
        */
        if ($layoutType === 'onepage') {
            $pageModules = [
                'home' => $layoutConfig['home'] ?? [],
            ];
        } else {
            $pageModules = $layoutConfig;
        }

        /*
        |--------------------------------------------------------------------------
        | Verifica se um módulo existe em qualquer página do layout
        |--------------------------------------------------------------------------
        */
        $hasModule = function (string $module) use ($pageModules, $theme) {
            if ($theme->hasModule($module)) {
                return true;
            }

            foreach ($pageModules as $modules) {
                if (is_array($modules) && in_array($module, $modules, true)) {
                    return true;
                }
            }

            return false;
        };

        /*
        |--------------------------------------------------------------------------
        | Verifica se existe pelo menos um módulo em determinada página
        |--------------------------------------------------------------------------
        */
        $hasPageModules = function (string $page) use ($pageModules) {
            return !empty($pageModules[$page]);
        };

        /*
        |--------------------------------------------------------------------------
        | Verifica se existe pelo menos um dos módulos informados em uma página
        |--------------------------------------------------------------------------
        */
        $hasAnyPageModule = function (string $page, array $modules) use ($pageModules) {
            $available = $pageModules[$page] ?? [];

            foreach ($modules as $module) {
                if (in_array($module, $available, true)) {
                    return true;
                }
            }

            return false;
        };

        /*
        |--------------------------------------------------------------------------
        | Usuário atual
        |--------------------------------------------------------------------------
        */
        $user = Auth::user();
        $isSuper = $user->hasRole('Super');

        /*
        |--------------------------------------------------------------------------
        | Módulos da Home
        |--------------------------------------------------------------------------
        */
        $homeModules = $pageModules['home'] ?? [];

    @endphp

    {{-- HEADER --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="mdi mdi-view-dashboard-outline me-2 text-primary"></i>
                {{ __('dashboard.title_dashboard') }}
            </h1>
            <p class="text-muted small mb-0">
                Gerencie todos os módulos do seu site
            </p>
        </div>

    </div>

    <style>
        .announcement-badge {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 12px 16px;
            margin-bottom: 24px;
            border: 1px solid transparent;
            border-radius: 12px;
            transition: .2s ease;
        }

        .announcement-badge:hover {
            transform: translateY(-1px);
            box-shadow: 0 5px 18px rgba(0, 0, 0, .07);
        }

        .announcement-icon {
            width: 42px;
            height: 42px;
            min-width: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            font-size: 18px;
        }

        .announcement-content {
            flex: 1;
            min-width: 0;
        }

        .announcement-label {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .5px;
            margin-bottom: 2px;
            opacity: .75;
        }

        .announcement-title {
            font-size: 14px;
            font-weight: 700;
            line-height: 1.3;
        }

        .announcement-text {
            font-size: 13px;
            line-height: 1.4;
            margin-top: 2px;
        }

        .announcement-text p {
            margin: 0;
        }

        .announcement-action {
            flex-shrink: 0;
        }

        .announcement-button {
            border: 0;
            font-weight: 600;
            padding: 7px 12px;
            transition: .2s ease;
        }

        .announcement-button:hover {
            transform: translateX(2px);
        }

        /* Geral */
        .announcement-general {
            background: #eef5ff;
            border-color: #a8ccff;
            color: #021127;
        }

        .announcement-general .announcement-icon {
            background: #cfe2ff;
        }

        .announcement-general .announcement-button {
            background: #0d6efd;
            color: #fff;
        }

        /* Manutenção */
        .announcement-maintenance {
            background: #fff8e6;
            border-color: #ffe69c;
            color: #664d03;
        }

        .announcement-maintenance .announcement-icon {
            background: #ffe69c;
        }

        .announcement-maintenance .announcement-button {
            background: #ffc107;
            color: #212529;
        }

        /* Atualização */
        .announcement-update {
            background: #eefbf3;
            border-color: #badbcc;
            color: #0f5132;
        }

        .announcement-update .announcement-icon {
            background: #badbcc;
        }

        .announcement-update .announcement-button {
            background: #198754;
            color: #fff;
        }

        /* Promoção */
        .announcement-promotion {
            background: #eef5ff;
            border-color: #a8ccff;
            color: #021127;
        }

        .announcement-promotion .announcement-icon {
            background: #e9d5ff;
        }

        .announcement-promotion .announcement-button {
            background: #005af9;
            color: #fff;
        }

        /* Aviso */
        .announcement-warning {
            background: #fff1f2;
            border-color: #fecdd3;
            color: #881337;
        }

        .announcement-warning .announcement-icon {
            background: #fecdd3;
        }

        .announcement-warning .announcement-button {
            background: #dc3545;
            color: #fff;
        }
        .announcement-wrapper {
        position: relative;
        margin-bottom: 24px;
        }

        .announcement-badge {
        position: relative;
        padding-right: 48px;
        transition: opacity .25s ease, transform .25s ease;
        }

        .announcement-toggle {
        position: absolute;
        top: 50%;
        right: 12px;
        transform: translateY(-50%);
        width: 30px;
        height: 30px;
        border: 0;
        border-radius: 7px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(0, 0, 0, .06);
        color: inherit;
        cursor: pointer;
        transition: .2s ease;
        }

        .announcement-toggle:hover {
        background: rgba(0, 0, 0, .12);
        }

        .announcement-toggle i {
        transition: transform .25s ease;
        }

        .announcement-open {
        display: none;
        align-items: center;
        gap: 7px;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 6px 11px;
        background: #fff;
        color: #495057;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        box-shadow: 0 2px 8px rgba(0, 0, 0, .06);
        transition: .2s ease;
        }

        .announcement-open:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, .1);
        }

        .announcement-wrapper.is-hidden .announcement-badge {
        display: none;
        }

        .announcement-wrapper.is-hidden .announcement-open {
        display: inline-flex;
        }

        @media (max-width: 576px) {
        .announcement-toggle {
            top: 12px;
            right: 10px;
            transform: none;
        }            
        .announcement-badge {
                align-items: flex-start;
                padding: 12px;
            }

            .announcement-icon {
                width: 36px;
                height: 36px;
                min-width: 36px;
                font-size: 15px;
            }

            .announcement-title {
                font-size: 13px;
            }

            .announcement-text {
                font-size: 12px;
            }

            .announcement-action {
                display: none;
            }
        }
    </style> 

    @if(!empty($announcement))
        @php
            $announcementConfig = [
                'general' => [
                    'icon' => 'bi-megaphone-fill',
                    'class' => 'announcement-general',
                    'label' => 'Informação',
                ],
                'maintenance' => [
                    'icon' => 'bi-tools',
                    'class' => 'announcement-maintenance',
                    'label' => 'Manutenção',
                ],
                'update' => [
                    'icon' => 'bi-arrow-up-circle-fill',
                    'class' => 'announcement-update',
                    'label' => 'Atualização',
                ],
                'promotion' => [
                    'icon' => 'bi-stars',
                    'class' => 'announcement-promotion',
                    'label' => 'Novidade',
                ],
                'warning' => [
                    'icon' => 'bi-exclamation-triangle-fill',
                    'class' => 'announcement-warning',
                    'label' => 'Aviso',
                ],
            ];

            $announcementType = $announcementConfig[$announcement->type] ?? $announcementConfig['general'];
        @endphp

        <div class="announcement-wrapper col-12" id="announcementWrapper">
            <div class="announcement-badge {{ $announcementType['class'] }}">
                <div class="announcement-icon">
                    <i class="bi {{ $announcementType['icon'] }}"></i>
                </div>

                <div class="announcement-content">
                    <div class="announcement-label">
                        {{ $announcementType['label'] }}
                    </div>

                    @if(!empty($announcement->title))
                        <div class="announcement-title">
                            {{ $announcement->title }}
                        </div>
                    @endif

                    @if(!empty($announcement->text))
                        <div class="announcement-text">
                            {!! $announcement->text !!}
                        </div>
                    @endif
                </div>

                @if(!empty($announcement->link))
                    <div class="announcement-action">
                        <a
                            href="{{ $announcement->link }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="btn btn-sm announcement-button"
                        >
                            Saiba mais
                            <i class="bi bi-arrow-up-right ms-1"></i>
                        </a>
                    </div>
                @endif

                <button
                    type="button"
                    class="announcement-toggle"
                    id="announcementToggle"
                    aria-label="Ocultar anúncio"
                    title="Ocultar anúncio"
                >
                    <i class="bi bi-chevron-up"></i>
                </button>
            </div>

            <button
                type="button"
                class="announcement-open"
                id="announcementOpen"
                aria-label="Exibir anúncio"
                title="Exibir anúncio"
            >
                <i class="bi {{ $announcementType['icon'] }}"></i>
                <span>{{ $announcementType['label'] }}</span>
            </button>
        </div>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const wrapper = document.getElementById('announcementWrapper');
            const toggle = document.getElementById('announcementToggle');
            const open = document.getElementById('announcementOpen');

            if (!wrapper || !toggle || !open) {
                return;
            }

            toggle.addEventListener('click', function () {
                wrapper.classList.add('is-hidden');
            });

            open.addEventListener('click', function () {
                wrapper.classList.remove('is-hidden');
            });
        });
    </script>


   {{-- ============================================================
        HOME
    ============================================================ --}}
    @if ($hasPageModules('home'))

        <div class="mb-2">
            <div class="d-flex align-items-center gap-2 mb-2">
                <span class="badge bg-primary bg-opacity-10 text-primary p-2">
                    <i class="mdi mdi-home fs-5"></i>
                </span>
                <h5 class="mb-0 fw-semibold">Home</h5>
            </div>

            <div class="row g-2">

                @if (in_array('slides', $homeModules, true) && ($isSuper || $user->can('slide.visualizar') || $user->can('usuario.tornar usuario master')))
                    @include('admin.components.dashboard-card', [
                        'route' => route('admin.dashboard.slide.index'),
                        'icon' => 'mdi-image-size-select-actual',
                        'title' => 'Slides'
                    ])
                @endif

                @if (in_array('topics', $homeModules, true) && ($isSuper || $user->can('topico.visualizar') || $user->can('usuario.tornar usuario master')))
                    @include('admin.components.dashboard-card', [
                        'route' => route('admin.dashboard.topic.index'),
                        'icon' => 'mdi-format-list-bulleted',
                        'title' => 'Tópicos'
                    ])
                @endif

                @if (in_array('statute', $homeModules, true) && ($isSuper || $user->can('passo a passo.visualizar') || $user->can('usuario.tornar usuario master')))
                    @include('admin.components.dashboard-card', [
                        'route' => route('admin.dashboard.statute.index'),
                        'icon' => 'mdi-file-document',
                        'title' => 'Passo a passo'
                    ])
                @endif

                @if (in_array('letsgo', $homeModules, true) && ($isSuper || $user->can('sesssao lets go.visualizar') || $user->can('usuario.tornar usuario master')))
                    @include('admin.components.dashboard-card', [
                        'route' => route('admin.dashboard.letsgo.index'),
                        'icon' => 'mdi-rocket-launch',
                        'title' => 'Sessão Lets Go'
                    ])
                @endif

                @if (in_array('impactSection', $homeModules, true) && ($isSuper || $user->can('destaques.visualizar') || $user->can('usuario.tornar usuario master')))
                    @include('admin.components.dashboard-card', [
                        'route' => route('admin.dashboard.impactSection.index'),
                        'icon' => 'mdi-star-circle',
                        'title' => 'Destaques'
                    ])
                @endif

                @if (in_array('lineOfTime', $homeModules, true) && ($isSuper || $user->can('linha do tempo.visualizar') || $user->can('usuario.tornar usuario master')))
                    @include('admin.components.dashboard-card', [
                        'route' => route('admin.dashboard.lineOfTime.index'),
                        'icon' => 'mdi-timeline-clock',
                        'title' => 'Linha do tempo'
                    ])
                @endif

                @if (in_array('faq_session', $homeModules, true) && ($isSuper || $user->can('sesssao faq.visualizar') || $user->can('usuario.tornar usuario master')))
                    @include('admin.components.dashboard-card', [
                        'route' => route('admin.dashboard.sessaoFaq.index'),
                        'icon' => 'mdi-help-circle',
                        'title' => 'Sessão FAQ'
                    ])
                @endif

                @if (in_array('faq', $homeModules, true) && ($isSuper || $user->can('perguntas e respostas.visualizar') || $user->can('usuario.tornar usuario master')))
                    @include('admin.components.dashboard-card', [
                        'route' => route('admin.dashboard.faq.index'),
                        'icon' => 'mdi-comment-question',
                        'title' => 'Perguntas/Respostas'
                    ])
                @endif

                @if (in_array('testimonials', $homeModules, true) && ($isSuper || $user->can('depoimento.visualizar') || $user->can('usuario.tornar usuario master')))
                    @include('admin.components.dashboard-card', [
                        'route' => route('admin.dashboard.depoiment.index'),
                        'icon' => 'mdi-account-voice',
                        'title' => 'Depoimentos'
                    ])
                @endif

                @if (in_array('services', $homeModules, true) && ($isSuper || $user->can('servicos.visualizar') || $user->can('usuario.tornar usuario master')))
                    @include('admin.components.dashboard-card', [
                        'route' => route('admin.dashboard.serviceItem.index'),
                        'icon' => 'mdi-briefcase-outline',
                        'title' => 'Serviços'
                    ])
                @endif

                @if (in_array('gallery', $homeModules, true) && ($isSuper || $user->can('galeria.visualizar') || $user->can('usuario.tornar usuario master')))
                    @include('admin.components.dashboard-card', [
                        'route' => route('admin.dashboard.gallery.index'),
                        'icon' => 'mdi-image-multiple',
                        'title' => 'Galeria'
                    ])
                @endif

                @if (in_array('about', $homeModules, true) && ($isSuper || $user->can('sobre nos.visualizar') || $user->can('usuario.tornar usuario master')))
                    @include('admin.components.dashboard-card', [
                        'route' => route('admin.dashboard.about.index'),
                        'icon' => 'mdi-information-outline',
                        'title' => 'Sobre Nós'
                    ])
                @endif

                @if (in_array('advantage', $homeModules, true) && ($isSuper || $user->can('vantagens.visualizar') || $user->can('usuario.tornar usuario master')))
                    @include('admin.components.dashboard-card', [
                        'route' => route('admin.dashboard.advantage.index'),
                        'icon' => 'mdi-thumb-up-outline',
                        'title' => 'Vantagens'
                    ])
                @endif

                @if (in_array('benefits', $homeModules, true) && ($isSuper || $user->can('parametro.visualizar') || $user->can('usuario.tornar usuario master')))
                    @include('admin.components.dashboard-card', [
                        'route' => route('admin.dashboard.benefitTopic.index'),
                        'icon' => 'mdi-tune',
                        'title' => 'Parâmetros'
                    ])
                @endif

                @if (in_array('mission', $homeModules, true) && ($isSuper || $user->can('missao visao e valores.visualizar') || $user->can('usuario.tornar usuario master')))
                    @include('admin.components.dashboard-card', [
                        'route' => route('admin.dashboard.report.index'),
                        'icon' => 'mdi-target',
                        'title' => 'Missão, Visão e Valores'
                    ])
                @endif

                @if (in_array('planNetworkCategory', $homeModules, true) && ($isSuper || $user->can('categorias do plano.visualizar') || $user->can('usuario.tornar usuario master')))
                    @include('admin.components.dashboard-card', [
                        'route' => route('admin.dashboard.planNetworkCategory.index'),
                        'icon' => 'mdi-shape',
                        'title' => 'Categorias do Plano'
                    ])
                @endif

                @if (in_array('planNetwork', $homeModules, true) && ($isSuper || $user->can('plano.visualizar') || $user->can('usuario.tornar usuario master')))
                    @include('admin.components.dashboard-card', [
                        'route' => route('admin.dashboard.planNetwork.index'),
                        'icon' => 'mdi-wifi',
                        'title' => 'Planos de Internet'
                    ])
                @endif

                @if (in_array('representatives', $homeModules, true) && ($isSuper || $user->can('representantes.visualizar') || $user->can('usuario.tornar usuario master')))
                    @include('admin.components.dashboard-card', [
                        'route' => route('admin.dashboard.direction.index'),
                        'icon' => 'mdi-account-group',
                        'title' => 'Representantes'
                    ])
                @endif

                @if (in_array('videos', $homeModules, true) && ($isSuper || $user->can('video.visualizar') || $user->can('usuario.tornar usuario master')))
                    @include('admin.components.dashboard-card', [
                        'route' => route('admin.dashboard.video.index'),
                        'icon' => 'mdi-play-circle',
                        'title' => 'Vídeos'
                    ])
                @endif

                @if (in_array('service_locations', $homeModules, true) && ($isSuper || $user->can('onde atendemos.visualizar') || $user->can('usuario.tornar usuario master')))
                    @include('admin.components.dashboard-card', [
                        'route' => route('admin.dashboard.serviceLocation.index'),
                        'icon' => 'mdi-map-marker',
                        'title' => 'Sessão Onde Atendemos'
                    ])
                @endif

                @if (in_array('brands', $homeModules, true) && ($isSuper || $user->can('marcas.visualizar')))
                    @include('admin.components.dashboard-card', [
                        'route' => route('admin.dashboard.brand.index'),
                        'icon' => 'mdi-tag-multiple',
                        'title' => 'Marcas'
                    ])
                @endif

                @if (in_array('product_categories', $homeModules, true) && ($isSuper || $user->can('categorias de produtos.visualizar') || $user->can('usuario.tornar usuario master')))
                    @include('admin.components.dashboard-card', [
                        'route' => route('admin.dashboard.productCategory.index'),
                        'icon' => 'mdi-tag-multiple',
                        'title' => 'Categorias dos produtos'
                    ])
                @endif

                @if (in_array('products', $homeModules, true) && ($isSuper || $user->can('produtos.visualizar') || $user->can('usuario.tornar usuario master')))
                    @include('admin.components.dashboard-card', [
                        'route' => route('admin.dashboard.product.index'),
                        'icon' => 'mdi-package-variant',
                        'title' => 'Produtos'
                    ])
                @endif

                @if (in_array('partner', $homeModules, true) && ($isSuper || $user->can('parceiro.visualizar') || $user->can('usuario.tornar usuario master')))
                    @include('admin.components.dashboard-card', [
                        'route' => route('admin.dashboard.partner.index'),
                        'icon' => 'mdi-handshake-outline',
                        'title' => 'Parceiros'
                    ])
                @endif

                @if (in_array('blog_categories', $homeModules, true) && ($isSuper || $user->can('categorias de noticias.visualizar') || $user->can('usuario.tornar usuario master')))
                    @include('admin.components.dashboard-card', [
                        'route' => route('admin.dashboard.blogCategory.index'),
                        'icon' => 'mdi-tag-multiple',
                        'title' => 'Categorias das Notícias'
                    ])
                @endif

                @if (in_array('blog', $homeModules, true) && ($isSuper || $user->can('noticias.visualizar') || $user->can('usuario.tornar usuario master')))
                    @include('admin.components.dashboard-card', [
                        'route' => route('admin.dashboard.blog.index'),
                        'icon' => 'mdi-newspaper-variant',
                        'title' => 'Notícias'
                    ])
                @endif

                @if (in_array('contact', $homeModules, true) && ($isSuper || $user->can('contato.visualizar') || $user->can('usuario.tornar usuario master')))
                    @include('admin.components.dashboard-card', [
                        'route' => route('admin.dashboard.contact.index'),
                        'icon' => 'mdi-card-account-mail-outline',
                        'title' => 'Contato'
                    ])
                @endif

                @if (in_array('contact_leads', $homeModules, true) && ($isSuper || $user->can('lead contato.visualizar') || $user->can('usuario.tornar usuario master')))
                    @include('admin.components.dashboard-card', [
                        'route' => route('admin.dashboard.formIndex.index'),
                        'icon' => 'mdi-account-box-outline',
                        'title' => 'Lead Contato'
                    ])
                @endif

                @if (in_array('download_leads', $homeModules, true) && ($isSuper || $user->can('usuario.tornar usuario master') || $user->can('usuario.tornar usuario master')))
                    @include('admin.components.dashboard-card', [
                        'route' => route('admin.dashboard.leadDownload.index'),
                        'icon' => 'mdi-download',
                        'title' => 'Lead Download'
                    ])
                @endif

            </div>
        </div>

    @endif

    {{-- ============================================================
        MULTIPAGE - PÁGINAS DINÂMICAS
    ============================================================ --}}
    @if ($layoutType === 'multipage')

        {{-- ========================================================
            SOBRE NÓS
        ======================================================== --}}
        @if ($hasPageModules('about'))

            @php $aboutModules = $pageModules['about']; @endphp

            <div class="mb-2">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <span class="badge bg-primary bg-opacity-10 text-primary p-2">
                        <i class="mdi mdi-information-outline fs-5"></i>
                    </span>
                    <h5 class="mb-0 fw-semibold">Sobre Nós</h5>
                </div>

                <div class="row g-2">

                    @if (in_array('about', $aboutModules, true) && ($isSuper || $user->can('sobre nos.visualizar') || $user->can('usuario.tornar usuario master')))
                        @include('admin.components.dashboard-card', [
                            'route' => route('admin.dashboard.about.index'),
                            'icon' => 'mdi-information-outline',
                            'title' => 'Sobre Nós'
                        ])
                    @endif

                    @if (in_array('benefits', $aboutModules, true) && ($isSuper || $user->can('parametro.visualizar') || $user->can('usuario.tornar usuario master')))
                        @include('admin.components.dashboard-card', [
                            'route' => route('admin.dashboard.benefitTopic.index'),
                            'icon' => 'mdi-tune',
                            'title' => 'Parâmetros'
                        ])
                    @endif

                    @if (in_array('mission', $aboutModules, true) && ($isSuper || $user->can('missao visao e valores.visualizar') || $user->can('usuario.tornar usuario master')))
                        @include('admin.components.dashboard-card', [
                            'route' => route('admin.dashboard.report.index'),
                            'icon' => 'mdi-target',
                            'title' => 'Missão, Visão e Valores'
                        ])
                    @endif

                    @if (in_array('planNetworkCategory', $aboutModules, true) && ($isSuper || $user->can('categorias do plano.visualizar') || $user->can('usuario.tornar usuario master')))
                        @include('admin.components.dashboard-card', [
                            'route' => route('admin.dashboard.planNetworkCategory.index'),
                            'icon' => 'mdi-shape',
                            'title' => 'Categorias do Plano'
                        ])
                    @endif

                    @if (in_array('planNetwork', $aboutModules, true) && ($isSuper || $user->can('plano.visualizar') || $user->can('usuario.tornar usuario master')))
                        @include('admin.components.dashboard-card', [
                            'route' => route('admin.dashboard.planNetwork.index'),
                            'icon' => 'mdi-wifi',
                            'title' => 'Planos de Internet'
                        ])
                    @endif

                    @if (in_array('representatives', $aboutModules, true) && ($isSuper || $user->can('representantes.visualizar') || $user->can('usuario.tornar usuario master')))
                        @include('admin.components.dashboard-card', [
                            'route' => route('admin.dashboard.direction.index'),
                            'icon' => 'mdi-account-group',
                            'title' => 'Representantes'
                        ])
                    @endif

                    @if (in_array('videos', $aboutModules, true) && ($isSuper || $user->can('video.visualizar') || $user->can('usuario.tornar usuario master')))
                        @include('admin.components.dashboard-card', [
                            'route' => route('admin.dashboard.video.index'),
                            'icon' => 'mdi-play-circle',
                            'title' => 'Vídeos'
                        ])
                    @endif

                    @if (in_array('service_locations', $aboutModules, true) && ($isSuper || $user->can('onde atendemos.visualizar') || $user->can('usuario.tornar usuario master')))
                        @include('admin.components.dashboard-card', [
                            'route' => route('admin.dashboard.serviceLocation.index'),
                            'icon' => 'mdi-map-marker',
                            'title' => 'Sessão Onde Atendemos'
                        ])
                    @endif

                </div>
            </div>

        @endif

        {{-- ========================================================
            PRODUTOS
        ======================================================== --}}
        @if ($hasPageModules('products'))

            @php $productModules = $pageModules['products']; @endphp

            <div class="mb-2">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <span class="badge bg-warning bg-opacity-10 text-warning p-2">
                        <i class="mdi mdi-toolbox fs-5"></i>
                    </span>
                    <h5 class="mb-0 fw-semibold">Produtos</h5>
                </div>

                <div class="row g-2">

                    @if (in_array('brands', $productModules, true) && ($isSuper || $user->can('marcas.visualizar') || $user->can('usuario.tornar usuario master')))
                        @include('admin.components.dashboard-card', [
                            'route' => route('admin.dashboard.brand.index'),
                            'icon' => 'mdi-tag-multiple',
                            'title' => 'Marcas'
                        ])
                    @endif

                    @if (in_array('product_categories', $productModules, true) && ($isSuper || $user->can('categorias de produtos.visualizar') || $user->can('usuario.tornar usuario master')))
                        @include('admin.components.dashboard-card', [
                            'route' => route('admin.dashboard.productCategory.index'),
                            'icon' => 'mdi-tag-multiple',
                            'title' => 'Categorias dos produtos'
                        ])
                    @endif

                    @if (in_array('products', $productModules, true) && ($isSuper || $user->can('produtos.visualizar') || $user->can('usuario.tornar usuario master')))
                        @include('admin.components.dashboard-card', [
                            'route' => route('admin.dashboard.product.index'),
                            'icon' => 'mdi-package-variant',
                            'title' => 'Produtos'
                        ])
                    @endif

                </div>
            </div>

        @endif

        {{-- ========================================================
            NOTÍCIAS
        ======================================================== --}}
        @if ($hasPageModules('blog'))

            @php $blogModules = $pageModules['blog']; @endphp

            <div class="mb-2">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <span class="badge bg-primary bg-opacity-10 text-primary p-2">
                        <i class="mdi mdi-newspaper-variant fs-5"></i>
                    </span>
                    <h5 class="mb-0 fw-semibold">Notícias</h5>
                </div>

                <div class="row g-2">

                    @if (in_array('blog_categories', $blogModules, true) && ($isSuper || $user->can('categorias de noticias.visualizar') || $user->can('usuario.tornar usuario master')))
                        @include('admin.components.dashboard-card', [
                            'route' => route('admin.dashboard.blogCategory.index'),
                            'icon' => 'mdi-tag-multiple',
                            'title' => 'Categorias das Notícias'
                        ])
                    @endif

                    @if (in_array('blog_sub_categories', $blogModules, true) && ($isSuper || $user->can('sub categorias de noticias.visualizar') || $user->can('usuario.tornar usuario master')))
                        @include('admin.components.dashboard-card', [
                            'route' => route('admin.dashboard.blogSubCategory.index'),
                            'icon' => 'mdi-tag-multiple',
                            'title' => 'Sub Categorias das Notícias'
                        ])
                    @endif

                    @if (in_array('blog', $blogModules, true) && ($isSuper || $user->can('noticias.visualizar') || $user->can('usuario.tornar usuario master')))
                        @include('admin.components.dashboard-card', [
                            'route' => route('admin.dashboard.blog.index'),
                            'icon' => 'mdi-newspaper-variant',
                            'title' => 'Notícias'
                        ])
                    @endif

                </div>
            </div>

        @endif

        {{-- ========================================================
            PARCEIROS
        ======================================================== --}}
        @if ($hasPageModules('partner'))

            @php $partnerModules = $pageModules['partner']; @endphp

            <div class="mb-2">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <span class="badge btn-green-whi bg-opacity-10 text-success p-2">
                        <i class="mdi mdi-handshake-outline fs-5"></i>
                    </span>
                    <h5 class="mb-0 fw-semibold">Parceiros</h5>
                </div>

                <div class="row g-2">

                    @if (in_array('partner', $partnerModules, true) && ($isSuper || $user->can('parceiro.visualizar') || $user->can('usuario.tornar usuario master')))
                        @include('admin.components.dashboard-card', [
                            'route' => route('admin.dashboard.partner.index'),
                            'icon' => 'mdi-handshake-outline',
                            'title' => 'Parceiros'
                        ])
                    @endif

                </div>
            </div>

        @endif

        {{-- ========================================================
            CONTATO
        ======================================================== --}}
        @if ($hasPageModules('contact'))

            @php $contactModules = $pageModules['contact']; @endphp

            <div class="mb-2">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <span class="badge bg-primary bg-opacity-10 text-primary p-2">
                        <i class="mdi mdi-card-account-mail-outline fs-5"></i>
                    </span>
                    <h5 class="mb-0 fw-semibold">Contato</h5>
                </div>

                <div class="row g-2">

                    @if (in_array('contact', $contactModules, true) && ($isSuper || $user->can('contato.visualizar') || $user->can('usuario.tornar usuario master')))
                        @include('admin.components.dashboard-card', [
                            'route' => route('admin.dashboard.contact.index'),
                            'icon' => 'mdi-card-account-mail-outline',
                            'title' => 'Contato'
                        ])
                    @endif

                    @if (in_array('contact_leads', $contactModules, true) && ($isSuper || $user->can('lead contato.visualizar') || $user->can('usuario.tornar usuario master')))
                        @include('admin.components.dashboard-card', [
                            'route' => route('admin.dashboard.formIndex.index'),
                            'icon' => 'mdi-account-box-outline',
                            'title' => 'Lead Contato'
                        ])
                    @endif

                    @if (in_array('download_leads', $contactModules, true) && ($isSuper || $user->can('usuario.tornar usuario master') || $user->can('usuario.tornar usuario master')))
                        @include('admin.components.dashboard-card', [
                            'route' => route('admin.dashboard.leadDownload.index'),
                            'icon' => 'mdi-download',
                            'title' => 'Lead Download'
                        ])
                    @endif

                </div>
            </div>

        @endif

    @endif

    {{-- ============================================================
        SMTP
    ============================================================ --}}
    @if ($theme->hasModule('config_smtp') && $isSuper)

        <div class="mb-2">
            <div class="d-flex align-items-center gap-2 mb-2">
                <span class="badge bg-primary bg-opacity-10 text-primary p-2">
                    <i class="mdi mdi-email-edit fs-5"></i>
                </span>
                <h5 class="mb-0 fw-semibold">
                    {{ __('dashboard.setting_smtp') }}
                </h5>
            </div>

            <div class="row g-2">
                @include('admin.components.dashboard-card', [
                    'route' => route('admin.dashboard.settingEmail.index'),
                    'icon' => 'mdi-email',
                    'title' => __('dashboard.setting_email')
                ])
            </div>
        </div>

    @endif

    {{-- ============================================================
        SEGURANÇA
    ============================================================ --}}
    @if (
        $theme->hasModule('audit') ||
        $theme->hasModule('permissions') ||
        $theme->hasModule('users')
    )

        @if (
            $isSuper ||
            $user->can('usuario.tornar usuario master') ||
            ($theme->hasModule('audit') && $user->can('auditoria.visualizar')) ||
            ($theme->hasModule('users') && $user->can('usuario.visualizar')) ||
            ($theme->hasModule('permissions') && $user->can('grupo.visualizar'))
        )

            <div class="mb-2">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <span class="badge bg-primary bg-opacity-10 text-primary p-2">
                        <i class="mdi mdi-security fs-5"></i>
                    </span>
                    <h5 class="mb-0 fw-semibold">
                        {{ __('dashboard.security_and_access_control') }}
                    </h5>
                </div>

                <div class="row g-2">

                    @if ($theme->hasModule('audit') && ($isSuper || $user->can('auditoria.visualizar') || $user->can('usuario.tornar usuario master')))
                        @include('admin.components.dashboard-card', [
                            'route' => route('admin.dashboard.audit.index'),
                            'icon' => 'mdi-clipboard-text',
                            'title' => __('dashboard.audit')
                        ])
                    @endif

                    @if ($theme->hasModule('permissions') && ($isSuper || $user->can('grupo.visualizar') || $user->can('usuario.tornar usuario master')))
                        @include('admin.components.dashboard-card', [
                            'route' => route('admin.dashboard.group.index'),
                            'icon' => 'mdi-account-group',
                            'title' => __('dashboard.group_and_permission')
                        ])
                    @endif

                    @if ($theme->hasModule('users') && ($isSuper || $user->can('usuario.visualizar') || $user->can('usuario.tornar usuario master')))
                        @include('admin.components.dashboard-card', [
                            'route' => route('admin.dashboard.user.index'),
                            'icon' => 'mdi-account-multiple',
                            'title' => __('dashboard.users')
                        ])
                    @endif

                </div>
            </div>

        @endif

    @endif

    {{-- ============================================================
        CONFIGURAÇÃO DO TEMA
    ============================================================ --}}
    @if (
        $theme->hasModule('config_theme') &&
        (
            $isSuper || $user->can('usuario.tornar usuario master') ||
            $user->can('usuario.tornar usuario master') ||
            $user->can('configuracao do tema.visualizar')
        )
    )

        <div class="mb-2">
            <div class="d-flex align-items-center gap-2 mb-2">
                <span class="badge bg-primary bg-opacity-10 text-primary p-2">
                    <i class="mdi mdi-palette fs-5"></i>
                </span>
                <h5 class="mb-0 fw-semibold">
                    Configuração do Tema
                </h5>
            </div>

            <div class="row g-2">
                @include('admin.components.dashboard-card', [
                    'route' => route('admin.dashboard.tenant.index'),
                    'icon' => 'mdi-palette',
                    'title' => 'Configuração do Tema'
                ])
            </div>
        </div>

    @endif

    {{-- ============================================================
        SEO E PLANOS
    ============================================================ --}}
    @if ($isSuper || $user->can('usuario.tornar usuario master'))

        <div class="mb-2">
            <div class="d-flex align-items-center gap-2 mb-2">
                <span class="badge bg-primary bg-opacity-10 text-primary p-2">
                    <i class="mdi mdi-google fs-5"></i>
                </span>
                <h5 class="mb-0 fw-semibold">
                    SEO e Google
                </h5>
            </div>

            <div class="row g-2">

                @include('admin.components.dashboard-card', [
                    'route' => route('admin.dashboard.seoGoogle.index'),
                    'icon' => 'mdi-google',
                    'title' => 'SEO Google'
                ])

                @include('admin.components.dashboard-card', [
                    'route' => route('google.search-console.client.index'),
                    'icon' => 'mdi-account-search',
                    'title' => 'Clientes do Google Search Console'
                ])

                @include('admin.components.dashboard-card', [
                    'route' => route('google.search-console.index'),
                    'icon' => 'mdi-chart-line',
                    'title' => 'Google Search Console'
                ])

            </div>
        </div>

    @endif

    @if ($isSuper || $user->can('usuario.tornar usuario master') || $user->can('anuncio.visualizar'))
        <div class="mb-2">
            <div class="d-flex align-items-center gap-2 mb-2">
                <span class="badge bg-primary bg-opacity-10 text-primary p-2">
                    <i class="mdi mdi-bullhorn fs-5"></i>
                </span>
                <h5 class="mb-0 fw-semibold">
                    Anúncios                    
                </h5>
            </div>

            <div class="row g-2">
                @if ($isSuper || $user->can('usuario.tornar usuario master'))
                    @include('admin.components.dashboard-card', [
                        'route' => route('admin.dashboard.adSlot.index'),
                        'icon' => 'mdi-billboard',
                        'title' => 'Áreas do anúncio'
                    ])
                @endif

                @if ($isSuper || in_array('announcement', $homeModules, true) && ($isSuper || $user->can('anuncio.visualizar') || $user->can('usuario.tornar usuario master')))
                    @include('admin.components.dashboard-card', [
                        'route' => route('admin.dashboard.announcement.index'),
                        'icon' => 'mdi-image-size-select-actual',
                        'title' => 'Anúncios'
                    ])
                @endif
            </div>
        </div>
    @endif

    @if ($isSuper || $user->can('usuario.tornar usuario master'))

        <div class="mb-2">
            <div class="d-flex align-items-center gap-2 mb-2">
                <span class="badge bg-primary bg-opacity-10 text-primary p-2">
                    <i class="mdi mdi-google-analytics fs-5"></i>
                </span>
                <h5 class="mb-0 fw-semibold">
                    Planos e Clientes
                </h5>
            </div>

            <div class="row g-2">

                @include('admin.components.dashboard-card', [
                    'route' => route('admin.dashboard.templateTheme.index'),
                    'icon' => 'mdi-view-grid-outline',
                    'title' => 'Templates'
                ])

                @include('admin.components.dashboard-card', [
                    'route' => route('admin.dashboard.plans.index'),
                    'icon' => 'mdi-credit-card-outline',
                    'title' => 'Plano contratado'
                ])

                @include('admin.components.dashboard-card', [
                    'route' => route('admin.dashboard.tenants.index'),
                    'icon' => 'mdi-account-multiple-outline',
                    'title' => 'Cliente/Tenant'
                ])

            </div>
        </div>

    @endif

    {{-- ============================================================
        FOOTER
    ============================================================ --}}
    <footer class="footer d-none d-lg-flex">
        <div class="container-fluid">
            <div class="row">

                <div class="col-md-6">
                    <div>
                        <a
                            href="https://www.whi.dev.br/"
                            target="_blank"
                            rel="noopener noreferrer"
                            style="color:#94a0ad;"
                        >
                            <script>
                                document.write(new Date().getFullYear())
                            </script>
                            © WHI - Web de Alta Inspiração
                        </a>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="d-none d-md-flex gap-4 align-items-center justify-content-md-end footer-links">

                        <a
                            href="https://www.whi.dev.br/"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="text-muted"
                        >
                            Sobre a WHI
                        </a>

                        <a
                            href="https://wa.me/5571992768360"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="text-muted"
                        >
                            Fale conosco
                        </a>

                    </div>
                </div>

            </div>
        </div>
    </footer>

    @include('admin.loadPage.loading')

@endsection
