@php
    $gallery = $serviceSection->get('gallery');
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

    <input type="hidden" name="section" value="gallery">

    {{-- TÍTULO --}}
    <div class="mb-3 col-lg-4">
        <label for="title" class="form-label">Título</label>
        <input type="text"
               name="title"
               class="form-control"
               id="title"
               value="{{ $gallery?->title ?? '' }}"
               placeholder="Título">
    </div>

    {{-- SUBTÍTULO --}}
    <div class="mb-3 col-lg-4">
        <label for="subtitle" class="form-label">Subtítulo</label>
        <input type="text"
               name="subtitle"
               class="form-control"
               id="subtitle"
               value="{{ $gallery?->subtitle ?? '' }}"
               placeholder="Subtítulo">
    </div>

    {{-- TAG --}}
    <div class="mb-3 col-lg-4">
        <label for="tag" class="form-label">Tag</label>
        <input type="text"
               name="tag"
               class="form-control"
               id="tag"
               value="{{ $gallery?->tag ?? '' }}"
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
               value="{{ $gallery?->description ?? '' }}"
               placeholder="Descrição">
    </div>

    {{-- ATIVO --}}
    <div class="mb-3 col-12">
        <div class="form-check">
            <input name="active"
                   value="1"
                   {{ $gallery?->active ? 'checked' : '' }}
                   type="checkbox"
                   class="form-check-input"
                   id="active">

            <label class="form-check-label" for="active">
                {{ __('dashboard.active') }}?
            </label>
        </div>
    </div>

</div>


{{-- ============================================================
    IMAGEM DESTAQUE
============================================================ --}}

<div class="row mt-4">

    <div class="col-12">
        <h5 class="mb-3 border-bottom pb-2">
            Imagem Destaque
        </h5>
    </div>

    {{-- TÍTULO DA IMAGEM --}}
    <div class="mb-3 col-lg-5">
        <label for="title_first_image" class="form-label">
            Título da imagem destaque
        </label>

        <input type="text"
               name="title_first_image"
               class="form-control"
               id="title_first_image"
               value="{{ $gallery?->title_first_image ?? '' }}"
               placeholder="Título da imagem destaque">
    </div>

    {{-- DESCRIÇÃO DA IMAGEM --}}
    <div class="mb-3 col-lg-7">
        <label for="description_first_image" class="form-label">
            Descrição da imagem destaque
        </label>

        <input type="text"
               name="description_first_image"
               class="form-control"
               id="description_first_image"
               value="{{ $gallery?->description_first_image ?? '' }}"
               placeholder="Descrição da imagem destaque">
    </div>

</div>


{{-- ============================================================
    BOTÃO / LINK
============================================================ --}}

<div class="row mt-4">

    <div class="col-12">
        <h5 class="mb-3 border-bottom pb-2">
            Botão e Link
        </h5>
    </div>

    {{-- TÍTULO DO BOTÃO --}}
    <div class="mb-3 col-lg-5">
        <label for="btn_title" class="form-label">
            Título do botão
        </label>

        <input type="text"
               name="btn_title"
               class="form-control"
               id="btn_title"
               value="{{ $gallery?->btn_title ?? '' }}"
               placeholder="Título do botão">
    </div>

    {{-- LINK DO BOTÃO --}}
    <div class="mb-3 col-lg-7">
        <label for="link" class="form-label">
            Link
        </label>

        <input type="text"
               name="link"
               class="form-control"
               id="link"
               value="{{ $gallery?->link ?? '' }}"
               placeholder="Link">
    </div>

</div>