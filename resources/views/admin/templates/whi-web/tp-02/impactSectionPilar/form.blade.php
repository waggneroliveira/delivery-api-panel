@php
    $pilar = $serviceSection->get('pilar');
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

    <input type="hidden" name="section" value="pilar">

    {{-- TÍTULO --}}
    <div class="mb-3 col-lg-4">
        <label for="title" class="form-label">Título</label>
        <input type="text"
               name="title"
               class="form-control"
               id="title"
               value="{{ $pilar?->title ?? '' }}"
               placeholder="Título">
    </div>

    <div class="mb-3 col-lg-4">
        <label for="tag" class="form-label">Palavra em destaque</label>
        <input type="text"
               name="tag"
               class="form-control"
               id="tag"
               value="{{ $pilar?->tag ?? '' }}"
               placeholder="Palavra em destaque">
    </div>
    <div class="mb-3 col-lg-4">
        <label for="subtitle" class="form-label">Subtitulo</label>
        <input type="text"
               name="subtitle"
               class="form-control"
               id="subtitle"
               value="{{ $pilar?->subtitle ?? '' }}"
               placeholder="Subtitulo">
    </div>

    <div class="mb-3 col-lg-12">
        <label for="description" class="form-label">Descrição</label>
        <input type="text"
               name="description"
               class="form-control"
               id="description"
               value="{{ $pilar?->description ?? '' }}"
               placeholder="Descrição">
    </div>

    {{-- ATIVO --}}
    <div class="mb-3 col-12">
        <div class="form-check">
            <input name="active"
                   value="1"
                   {{ $pilar?->active ? 'checked' : '' }}
                   type="checkbox"
                   class="form-check-input"
                   id="active">

            <label class="form-check-label" for="active">
                {{ __('dashboard.active') }}?
            </label>
        </div>
    </div>

</div>
