@php
    $product = $serviceSection->get('product');
    $textareaId = $textareaId ?? 'description' . (isset($product->id) ? $product->id : '');

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

    <input type="hidden" name="section" value="product">

    {{-- TÍTULO --}}
    <div class="mb-3 col-lg-4">
        <label for="title" class="form-label">Título</label>
        <input type="text"
               name="title"
               class="form-control"
               id="title"
               value="{{ $product?->title ?? '' }}"
               placeholder="Título">
    </div>
    {{-- SUBTÍTULO --}}
    <div class="mb-3 col-lg-4">
        <label for="subtitle" class="form-label">Subtítulo</label>
        <input type="text"
               name="subtitle"
               class="form-control"
               id="subtitle"
               value="{{ $product?->subtitle ?? '' }}"
               placeholder="Subtítulo">
    </div>

    {{-- btn title --}}
    <div class="mb-3 col-lg-4">
        <label for="btn_title" class="form-label">Título botão</label>
        <input type="text"
               name="btn_title"
               class="form-control"
               id="btn_title"
               value="{{ $product?->btn_title ?? '' }}"
               placeholder="Título botão">
    </div>

    {{-- ATIVO --}}
    <div class="mb-3 col-12">
        <div class="form-check">
            <input name="active"
                   value="1"
                   {{ $product?->active ? 'checked' : '' }}
                   type="checkbox"
                   class="form-check-input"
                   id="active">

            <label class="form-check-label" for="active">
                {{ __('dashboard.active') }}?
            </label>
        </div>
    </div>

</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const textareaId = "{{$textareaId}}";

        if (document.getElementById(textareaId)) {
            CKEDITOR.replace(textareaId, {
                toolbar: [
                    { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline'] },
                ],
                height: 200
            });
        }
    });
</script>