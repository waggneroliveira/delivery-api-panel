@php
    $partners = $serviceSection->get('partners');
@endphp


{{-- ============================================================
    DADOS DA SEÇÃO
============================================================ --}}

<div class="row">

    <div class="col-12">
        <h5 class="mb-3 border-bottom pb-2">
            Dados da Seção
        </h5>
    </div>

    <input type="hidden" name="section" value="partners">

    {{-- TÍTULO --}}
    <div class="mb-3 col-lg-5">
        <label for="title" class="form-label">Título</label>
        <input type="text"
               name="title"
               class="form-control"
               id="title"
               value="{{ $partners?->title ?? '' }}"
               placeholder="Título">
    </div>

    <div class="mb-3 col-lg-5">
        <label for="subtitle" class="form-label">Subtitulo</label>
        <input type="text"
               name="subtitle"
               class="form-control"
               id="subtitle"
               value="{{ $partners?->subtitle ?? '' }}"
               placeholder="Subtitulo">
    </div>

    <div class="mb-3 col-lg-2">
        <label for="tag" class="form-label">Tag</label>
        <input type="text"
               name="tag"
               class="form-control"
               id="tag"
               value="{{ $partners?->tag ?? '' }}"
               placeholder="Tag">
    </div>

    {{-- ATIVO --}}
    <div class="mb-3 col-12">
        <div class="form-check">
            <input name="active"
                   value="1"
                   {{ $partners?->active ? 'checked' : '' }}
                   type="checkbox"
                   class="form-check-input"
                   id="active">

            <label class="form-check-label" for="active">
                {{ __('dashboard.active') }}?
            </label>
        </div>
    </div>

</div>
