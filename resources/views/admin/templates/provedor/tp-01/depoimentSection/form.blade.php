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
    <div class="mb-3 col-lg-3">
        <label for="title" class="form-label">Título</label>
        <input type="text"
               name="title"
               class="form-control"
               id="title"
               value="{{ $testimonial?->title ?? '' }}"
               placeholder="Título">
    </div>

    {{-- btn title --}}
    <div class="mb-3 col-lg-3">
        <label for="btn_title" class="form-label">Título botão</label>
        <input type="text"
               name="btn_title"
               class="form-control"
               id="btn_title"
               value="{{ $testimonial?->btn_title ?? '' }}"
               placeholder="Título botão">
    </div>

    {{-- link --}}
    <div class="mb-3 col-lg-6">
        <label for="link" class="form-label">Link</label>
        <input type="text"
               name="link"
               class="form-control"
               id="link"
               value="{{ $testimonial?->link ?? '' }}"
               placeholder="Link">
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

    <div class="col-12 mb-3">
        <div class="mt-3">
            <label for="path_image" class="form-label">Imagem da sessão</label>
            <input type="file" name="path_image" accept=".jpg,.jpeg,.png" data-plugins="dropify" data-default-file="{{isset($testimonial)?$testimonial->path_image<>''?url('storage/'.$testimonial->path_image):'':''}}"  />
            <p class="text-muted text-center mt-2 mb-0">{{__('dashboard.text_img_size')}} <b class="text-danger">2 MB</b>.</p>
        </div>
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
