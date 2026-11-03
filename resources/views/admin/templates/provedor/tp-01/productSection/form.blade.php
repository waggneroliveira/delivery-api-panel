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
    <div class="mb-3 col-lg-3">
        <label for="title" class="form-label">Título</label>
        <input type="text"
               name="title"
               class="form-control"
               id="title"
               value="{{ $product?->title ?? '' }}"
               placeholder="Título">
    </div>

    {{-- btn title --}}
    <div class="mb-3 col-lg-3">
        <label for="btn_title" class="form-label">Título botão</label>
        <input type="text"
               name="btn_title"
               class="form-control"
               id="btn_title"
               value="{{ $product?->btn_title ?? '' }}"
               placeholder="Título botão">
    </div>


    {{-- DESCRIÇÃO --}}
    <div class="mb-3 col-12">
        <label for="{{$textareaId}}" class="form-label text-muted">Descrição breve</label>
        <textarea name="description" id="{{$textareaId}}" placeholder="Texto" class="col-12" rows="10">
            {!!isset($product->description)?$product->description: ''!!}
        </textarea>
    </div>

    <div class="col-12 mb-3">
        <div class="mt-3">
            <label for="path_image" class="form-label">Imagem da sessão</label>
            <input type="file" name="path_image" accept=".jpg,.jpeg,.png" data-plugins="dropify" data-default-file="{{isset($product)?$product->path_image<>''?url('storage/'.$product->path_image):'':''}}"  />
            <p class="text-muted text-center mt-2 mb-0">{{__('dashboard.text_img_size')}} <b class="text-danger">2 MB</b>.</p>
        </div>
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