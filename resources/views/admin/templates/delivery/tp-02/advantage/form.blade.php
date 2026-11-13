@php
    $textareaId = $textareaId ?? 'text' . (isset($advantage->id) ? $advantage->id : '');
@endphp

<div class="row">

    <div class="col-12 col-lg-7">

        <div class="row">

            <div class="mb-3 col-12 col-lg-4 d-flex align-items-start flex-column">

                <label for="category-select{{ isset($advantage->id) ? $advantage->id : '' }}" class="form-label">
                    Benefícios <span class="text-danger">*</span>
                </label>

                @php
                    $currentForYou = isset($advantage) ? $advantage->for_you : null;
                @endphp

                <select
                    name="for_you"
                    class="form-select"
                    id="category-select{{ isset($advantage->id) ? $advantage->id : '' }}"
                    required
                >
                    <option value="" disabled {{ !$currentForYou ? 'selected' : '' }}>
                        Selecione uma opção
                    </option>

                    <option value="persona" {{ $currentForYou == 'persona' ? 'selected' : '' }}>
                        Para Pessoas
                    </option>

                    <option value="enterprise" {{ $currentForYou == 'enterprise' ? 'selected' : '' }}>
                        Para Empresas
                    </option>
                </select>

            </div>

            <div class="col-12 col-lg-8">

                <label for="title{{ isset($advantage->id) ? $advantage->id : '' }}" class="form-label">
                    Título
                </label>

                <input
                    type="text"
                    name="title"
                    class="form-control"
                    id="title{{ isset($advantage->id) ? $advantage->id : '' }}"
                    value="{{ isset($advantage) ? $advantage->title : '' }}"
                    placeholder="Título"
                >

            </div>

        </div>

        <div class="row">

            <div class="mb-3 col-12">

                <label for="{{ $textareaId }}" class="form-label text-muted">
                    Texto
                </label>

                <textarea
                    name="text"
                    id="{{ $textareaId }}"
                    placeholder="Texto"
                    class="col-12"
                    rows="10"
                >{!! isset($advantage->text) ? $advantage->text : '' !!}</textarea>

            </div>

        </div>

        <div class="mb-3">

            <div class="form-check">

                <input
                    name="active"
                    {{ isset($advantage->active) && $advantage->active == 1 ? 'checked' : '' }}
                    type="checkbox"
                    class="form-check-input"
                    id="invalidCheck{{ isset($advantage->id) ? $advantage->id : '' }}"
                />

                <label
                    class="form-check-label"
                    for="invalidCheck{{ isset($advantage->id) ? $advantage->id : '' }}"
                >
                    {{ __('dashboard.active') }}?
                </label>

                <div class="invalid-feedback">
                    You must agree before submitting.
                </div>

            </div>

        </div>

    </div>

    <div class="col-12 col-lg-5">

        {{-- IMAGEM --}}
        <div
            class="row"
            id="image-field{{ isset($advantage->id) ? $advantage->id : '' }}"
        >
            <div class="col-12">

                <div class="mt-3">

                    <label for="path_image" class="form-label">
                        Imagem
                    </label>

                    <input
                        type="file"
                        name="path_image"
                        data-plugins="dropify"
                        data-default-file="{{ isset($advantage) && $advantage->path_image != '' ? url('storage/' . $advantage->path_image) : '' }}"
                    />

                    <p class="text-muted text-center mt-2 mb-0">
                        {{ __('dashboard.text_img_size') }}
                        <b class="text-danger">2 MB</b>.
                    </p>

                </div>

            </div>
        </div>

        {{-- ÍCONE --}}
        <div class="row">

            <div class="col-12">

                <div class="mt-3">

                    <label for="path_icon" class="form-label">
                        Ícone
                    </label>

                    <input
                        type="file"
                        name="path_icon"
                        data-plugins="dropify"
                        data-default-file="{{ isset($advantage) && $advantage->path_icon != '' ? url('storage/' . $advantage->path_icon) : '' }}"
                    />

                    <p class="text-muted text-center mt-2 mb-0">
                        {{ __('dashboard.text_img_size') }}
                        <b class="text-danger">2 MB</b>.
                    </p>

                </div>

            </div>

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
    
    document.addEventListener('DOMContentLoaded', function () {

        const select = document.getElementById('category-select{{ isset($advantage->id) ? $advantage->id : '' }}');
        const imageField = document.getElementById('image-field{{ isset($advantage->id) ? $advantage->id : '' }}');

        if (!select || !imageField) {
            return;
        }

        function toggleImage() {

            if (select.value === 'enterprise') {
                imageField.style.display = 'none';
            } else {
                imageField.style.display = '';
            }

        }

        // Executa ao carregar o formulário/modal
        toggleImage();

        // Executa quando alterar o select
        select.addEventListener('change', toggleImage);

    });
</script>

<style>
#cke_{{ $textareaId }} {
    width: 100%;
}
</style>
