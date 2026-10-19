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

    {{--SUBTÍTULO --}}
    <div class="mb-3 col-lg-6">
        <label for="subtitle" class="form-label">Subtítulo</label>
        <input type="text"
               name="subtitle"
               class="form-control"
               id="subtitle"
               value="{{ $testimonial?->subtitle ?? '' }}"
               placeholder="Título">
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
