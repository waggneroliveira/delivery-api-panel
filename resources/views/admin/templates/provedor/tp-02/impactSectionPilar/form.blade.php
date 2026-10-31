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
        <label for="btn_title" class="form-label">Título botão</label>
        <input type="text"
               name="btn_title"
               class="form-control"
               id="btn_title"
               value="{{ $pilar?->btn_title ?? '' }}"
               placeholder="Título botão">
    </div>
    <div class="mb-3 col-lg-4">
        <label for="link" class="form-label">Link</label>
        <input type="text"
               name="link"
               class="form-control"
               id="link"
               value="{{ $pilar?->link ?? '' }}"
               placeholder="Link">
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
