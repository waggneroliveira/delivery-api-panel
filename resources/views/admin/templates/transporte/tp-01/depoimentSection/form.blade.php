@php
    $testimonial = $serviceSection->get('testimonial');
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

    <input type="hidden" name="section" value="testimonial">

    {{-- TÍTULO --}}
    <div class="mb-3 col-lg-6">
        <label for="title" class="form-label">Título</label>
        <input type="text"
               name="title"
               class="form-control"
               id="title"
               value="{{ $testimonial?->title ?? '' }}"
               placeholder="Título">
    </div>

    {{-- TAG --}}
    <div class="mb-3 col-lg-6">
        <label for="tag" class="form-label">Tag</label>
        <input type="text"
               name="tag"
               class="form-control"
               id="tag"
               value="{{ $testimonial?->tag ?? '' }}"
               placeholder="Tag">
    </div>

    {{-- DESCRIÇÃO --}}
    <div class="mb-3 col-12">
        <label for="description" class="form-label">
            Descrição breve
        </label>

        <input type="text"
               name="description"
               class="form-control"
               id="description"
               value="{{ $testimonial?->description ?? '' }}"
               placeholder="Descrição">
    </div>

    {{-- ATIVO --}}
    <div class="mb-3 col-12">
        <div class="form-check">
            <input name="active"
                   value="1"
                   {{ $testimonial?->active ? 'checked' : '' }}
                   type="checkbox"
                   class="form-check-input"
                   id="active">

            <label class="form-check-label" for="active">
                {{ __('dashboard.active') }}?
            </label>
        </div>
    </div>

</div>
