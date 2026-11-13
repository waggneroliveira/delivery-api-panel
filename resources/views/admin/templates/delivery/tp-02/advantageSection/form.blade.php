@php
    $key = 'advantages_' . $forYou;
    
    // Suporta tanto Array quanto Collection/Model
    if (is_array($serviceSection)) {
        $advantage = $serviceSection[$key] ?? null;
    } else {
        $advantage = is_object($serviceSection) && method_exists($serviceSection, 'get') 
            ? $serviceSection->get($key) 
            : ($serviceSection->{$key} ?? null);
    }
    
    // Se $advantage ainda for um array, converte para objeto para manter a sintaxe de objeto
    if (is_array($advantage)) {
        $advantage = (object) $advantage;
    }
@endphp

<div class="row">
    <input type="hidden" name="section" value="advantages_{{ $forYou }}">

    <div class="mb-3 col-lg-6">
        <label for="title-{{ $forYou }}" class="form-label">Título</label>
        <input type="text"
               name="title"
               class="form-control"
               id="title-{{ $forYou }}"
               value="{{ $advantage?->title ?? '' }}"
               placeholder="Título"
               required>
    </div>

    <div class="mb-3 col-lg-6">
        <label for="subtitle-{{ $forYou }}" class="form-label">Subtitulo</label>
        <input type="text"
               name="subtitle"
               class="form-control"
               id="subtitle-{{ $forYou }}"
               value="{{ $advantage?->subtitle ?? '' }}"
               placeholder="Subtitulo">
    </div>
</div>

<div class="row mb-3">
    <div class="col-12 col-lg-4">
        <label for="btn_title-{{ $forYou }}" class="form-label">Títlo botão</label>
        <input type="text"
               name="btn_title"
               class="form-control"
               id="btn_title-{{ $forYou }}"
               value="{{ $advantage?->btn_title ?? '' }}"
               placeholder="Títlo botão">
    </div>
    
    <div class="col-12 col-lg-8">
        <label for="link-{{ $forYou }}" class="form-label">Link</label>
        <input type="text"
               name="link"
               class="form-control"
               id="link-{{ $forYou }}"
               value="{{ $advantage?->link ?? '' }}"
               placeholder="Descrição">
    </div>
</div>

{{-- IMAGEM --}}
@if (isset($forYou) && strtolower(trim($forYou)) === 'enterprise')
    <div class="row" id="image-field-{{ $forYou }}-{{ $advantage->id ?? 'new' }}">
        <div class="col-12">
            <div class="mt-3">
                <label for="path_image" class="form-label">
                    Imagem
                </label>

                <input
                    type="file"
                    name="path_image"
                    data-plugins="dropify"
                    data-default-file="{{ !empty($advantage?->path_image) ? url('storage/' . $advantage->path_image) : '' }}"
                />

                <p class="text-muted text-center mt-2 mb-0">
                    {{ __('dashboard.text_img_size') }}
                    <b class="text-danger">2 MB</b>.
                </p>
            </div>
        </div>
    </div>
@endif

<div class="mb-3">
    <div class="form-check">
        <input name="active"
               value="1"
               {{ $advantage?->active ? 'checked' : '' }}
               type="checkbox"
               class="form-check-input"
               id="active-{{ $forYou }}">

        <label class="form-check-label" for="active-{{ $forYou }}">
            {{ __('dashboard.active') }}?
        </label>
    </div>
</div>