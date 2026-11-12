@extends($theme->core('client'))

@section('content')

    @php
        $preview = is_object($templateThemeInner)
            ? ($templateThemeInner->preview ?? null)
            : ($templateThemeInner['preview'] ?? null);

        if (is_string($preview)) {
            $previews = json_decode($preview, true) ?? [];
        } elseif (is_array($preview)) {
            $previews = $preview;
        } else {
            $previews = [];
        }

        $previews = is_array($previews) ? $previews : [];

        $previewImage = $previews[0] ?? null;
        $countPreviews = count($previews);

        $themeName = is_object($templateThemeInner)
            ? ($templateThemeInner->name ?? '')
            : ($templateThemeInner['name'] ?? '');

        $themeSlug = is_object($templateThemeInner)
            ? ($templateThemeInner->slug ?? \Illuminate\Support\Str::slug($themeName))
            : ($templateThemeInner['slug'] ?? \Illuminate\Support\Str::slug($themeName));
    @endphp

    <!-- Main Content Container -->
    <div class="container-xl px-3 px-sm-4 py-4 mt-5">
        <!-- Hero Title Section -->
        <div class="animate-hero mt-5 mb-4 col-12 col-lg-8 text-center text-lg-start d-flex flex-column flex-md-row align-items-center align-items-ld-end justify-content-center justify-content-lg-between gap-3">
            @if (isset($templateThemeInner) ?? $templateThemeInner->title <> null || isset($templateThemeInner) ?? $templateThemeInner->description)
                <div>
                    @if ($templateThemeInner->title <> null)                        
                        <h1 class="fw-bold text-white fs-2 tracking-tight mb-0">
                            {{ $templateThemeInner->title }}
                        </h1>
                    @endif

                    @if ($templateThemeInner->description <> null)                        
                        <p class="text-white-50 mt-2 mb-0 text-base" style="max-width: 672px;">
                            {{ $templateThemeInner->description }}
                        </p>
                    @endif
                </div>
            @endif

            <a href="{{ route('templates') }}" class="btn-faq-cta py-2 px-5 col-4 col-lg-auto justify-content-center">
                Voltar
            </a>            
        </div>

        <div class="row g-4 items-start">

            <!-- Left Side: Interactive Preview Section -->
            <div class="col-12 col-lg-8 d-flex flex-column gap-4">

                <!-- Main Viewer Box -->
                <div class="animate-viewer bg-dark-card rounded-4 overflow-hidden shadow-lg position-relative">

                    <!-- Browser-like Top Bar -->
                    <div
                        class="bg-dark px-3 py-2.5 border-bottom border-dark-custom d-flex align-items-center justify-content-between"
                        style="background-color: rgba(15, 23, 42, 0.9) !important;"
                    >
                        <div class="d-flex align-items-center gap-1.5">
                            <span class="rounded-circle bg-danger d-inline-block" style="width: 10px; height: 10px;"></span>
                            <span class="rounded-circle bg-warning d-inline-block" style="width: 10px; height: 10px;"></span>
                            <span class="rounded-circle bg-success d-inline-block" style="width: 10px; height: 10px;"></span>
                        </div>

                        <span
                            id="page-indicator"
                            class="text-secondary font-monospace bg-dark border rounded px-2 py-0.5"
                            style="font-size: 0.75rem; border-color: rgba(255, 255, 255, 0.1) !important;"
                        >
                            Página 1 de {{ $countPreviews }}
                        </span>

                        <div class="d-flex align-items-center gap-2 text-secondary">
                            <button
                                id="btn-fullscreen"
                                type="button"
                                class="btn btn-link text-secondary p-0 hover-white"
                                title="Expandir Visualização"
                            >
                                <i data-lucide="maximize-2" style="width: 16px; height: 16px;"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Main Image Viewport -->
                    <div
                        class="position-relative bg-black overflow-y-auto custom-scrollbar d-flex justify-content-center p-3"
                        style="min-height: 420px; max-height: 750px;"
                    >
                        @if($previewImage)
                            <img
                                id="main-preview-image"
                                src="{{ asset('storage/' . $previewImage) }}"
                                alt="{{ $themeName }}"
                                class="w-100 h-auto rounded-3 shadow-sm transition-all object-top"
                                style="object-fit: contain"
                            />
                        @else
                            <div class="d-flex align-items-center justify-content-center text-secondary py-5">
                                <div class="text-center">
                                    <i data-lucide="image-off" style="width: 40px; height: 40px;"></i>
                                    <p class="mt-3 mb-0">Nenhuma imagem de preview disponível.</p>
                                </div>
                            </div>
                        @endif
                    </div>

                </div>

                <!-- Pages Thumbnails Carousel / Grid -->
                @if($countPreviews > 0)
                    <div class="animate-thumbs">

                        <h3
                            class="text-uppercase tracking-wider text-secondary mb-3 d-flex align-items-center gap-2 fw-semibold"
                            style="font-size: 0.85rem;"
                        >
                            <i data-lucide="layers" class="text-primary" style="width: 16px; height: 16px;"></i>
                            Páginas do Template
                        </h3>

                        <div class="row g-3">

                            @foreach($previews as $index => $preview)
                                <div class="col-6 col-sm-3">

                                    <button
                                        type="button"
                                        onclick="changePageImage('{{ asset('storage/' . $preview) }}', '', {{ $index + 1 }})"
                                        class="thumb-btn {{ $loop->first ? 'active-thumb' : '' }}"
                                        data-index="{{ $index + 1 }}"
                                    >
                                        <div class="ratio ratio-16x9 w-100 rounded-2 overflow-hidden bg-dark position-relative">

                                            <img
                                                src="{{ asset('storage/' . $preview) }}"
                                                alt="Preview {{ $index + 1 }}"
                                                class="object-fit-cover w-100 h-100"
                                            >

                                            <div class="thumb-overlay"></div>

                                        </div>
                                    </button>

                                </div>
                            @endforeach

                        </div>
                    </div>
                @endif

            </div>

            <!-- Right Side: Details & Features Sidebar -->
            <div class="col-12 col-lg-4 d-flex flex-column gap-4 animate-sidebar">
                <!-- Specs Card -->
                <div class="bg-dark-card rounded-4 p-4 shadow-lg d-flex flex-column gap-4">

                    <h3 class="fs-6 fw-bold text-white border-bottom border-dark-custom pb-3 mb-0 d-flex align-items-center gap-2">
                        <i data-lucide="info" class="text-primary" style="width: 18px; height: 18px;"></i>
                        Informações do Template
                    </h3>

                    <div class="d-flex flex-column gap-2 text-sm" style="font-size: 0.875rem;">

                        <div class="d-flex justify-content-between align-items-center py-2 border-bottom border-dark-custom">
                            <span class="text-white-50">Total de Páginas</span>
                            <span class="fw-semibold text-white">{{ $countPreviews }}</span>
                        </div>

                        <div class="d-flex justify-content-between align-items-center py-2 border-bottom border-dark-custom">
                            <span class="text-white-50">Layout</span>
                            <span class="fw-semibold text-white">
                            {{ match ($templateThemeInner->layout_type) {
                                'onepage' => 'Página Única',
                                'multipage' => 'Múltiplas Páginas',
                                default => $templateThemeInner->layout_type,
                            } }}
                        </span>
                        </div>
                    </div>

                    @if ($templateThemeInner->technology <> null)
                        <!-- Tech Badges -->
                        <div>
                            <h4
                                class="text-uppercase tracking-wider text-secondary fw-semibold mb-3"
                                style="font-size: 0.75rem;"
                            >
                                Tecnologias / Formatos
                            </h4>

                            <div class="d-flex flex-wrap gap-2">
                                @foreach(explode(',', $templateThemeInner->technology) as $technology)
                                    <span class="badge bg-dark text-secondary border border-dark-custom rounded-2 px-2.5 py-1.5 font-normal">
                                        {{ trim($technology) }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    
                    @php
                        $templateUrl = url()->current();

                        $whatsappMessage = 'Olá! Tenho interesse neste template: ' . $templateThemeInner->name
                            . ' (' . $templateThemeInner->layout_type . ').'
                            . "\n\n"
                            . 'Link do template: ' . $templateUrl
                            . "\n\n"
                            . 'Gostaria de saber mais sobre valores e contratação.';
                    @endphp

                    <a href="https://wa.me/5571982743414?text={{ urlencode($whatsappMessage) }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="btn-faq-cta col-12 justify-content-center">
                        Quero esse
                    </a>
                </div>

                @if ($templateThemeInner->highlights <> null)
                    <!-- Highlight Features Card -->
                    <div class="bg-dark-card rounded-4 p-4 shadow-lg d-flex flex-column gap-3">

                        <h3 class="fs-6 fw-bold text-white mb-0 d-flex align-items-center gap-2">
                            <i data-lucide="check-circle-2" class="text-success" style="width: 18px; height: 18px;"></i>
                            Destaques
                        </h3>

                        <ul class="list-unstyled mb-0 d-flex flex-column gap-2.5 text-secondary" style="font-size: 0.875rem;">
                            @foreach(explode(',', $templateThemeInner->highlights) as $highlight)
                                <li class="d-flex align-items-start gap-2">
                                    <i data-lucide="check" class="text-success flex-shrink-0 mt-1" style="width: 16px; height: 16px;"></i>
                                    <span>{{ trim($highlight) }}</span>
                                </li>
                            @endforeach
                        </ul>

                    </div>
                @endif

            </div>

        </div>

    </div>

    <!-- Fullscreen Lightbox Modal -->
    <div id="lightbox-modal" class="d-none p-3" style="z-index: 999999">

        <button
            id="btn-close-lightbox"
            type="button"
            class="btn btn-dark rounded-circle position-absolute top-0 end-0 m-4 p-2 text-white border-0 shadow"
            style="background-color: rgba(30, 41, 59, 0.8);"
        >
            <i data-lucide="x" style="width: 24px; height: 24px;"></i>
        </button>

        <div class="mw-100 mh-100 overflow-auto custom-scrollbar rounded-3">
            <img
                id="lightbox-image"
                src=""
                alt="Zoom Preview"
                class="img-fluid rounded-3"
            >
        </div>

    </div>

@endsection