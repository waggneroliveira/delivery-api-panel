{{-- ============================================================
INFORMAÇÕES DO TEMPLATE
============================================================ --}}

<div class="row g-3 mt-0">

    <div class="col-12 mt-0">
        <h5 class="mb-2 border-bottom pb-2">
            Informações do Template
        </h5>
    </div>

    {{-- NOME --}}
    <div class="col-12 col-lg-5 mt-1">
        <div class="mb-0">

            <label class="form-label">
                Título do Template
            </label>

            <input
                name="title"
                type="text"
                class="form-control"
                value="{{ isset($templateTheme) ? $templateTheme->title ?? '' : '' }}"

            >

        </div>
    </div>
    <div class="col-12 col-lg-7 mt-1">
        <div class="mb-0">

            <label class="form-label">
                Descrição do Template
            </label>

            <input
                name="description"
                type="text"
                class="form-control"
                value="{{ isset($templateTheme) ? $templateTheme->description ?? '' : '' }}"

            >

        </div>
    </div>

    <div class="col-12 col-lg-4 mt-1">
        <div class="mb-0">

            <label class="form-label">
                Nome do Template
            </label>

            <input
                name="name"
                type="text"
                class="form-control"
                value="{{ isset($templateTheme) ? $templateTheme->name ?? '' : '' }}"

            >

        </div>
    </div>

    {{-- LAYOUT TYPE --}}
    <div class="col-12 col-lg-4 mt-1">
        <div class="mb-0">

            <label for="layout_type" class="form-label">
                Tipo de Layout
            </label>

            <select
                name="layout_type"
                id="layout_type"
                class="form-select"
            >
                <option
                    value="onepage"
                    {{ old('layout_type', $templateTheme->layout_type ?? 'onepage') === 'onepage' ? 'selected' : '' }}
                >
                    One Page
                </option>

                <option
                    value="multipage"
                    {{ old('layout_type', $templateTheme->layout_type ?? 'onepage') === 'multipage' ? 'selected' : '' }}
                >
                    Multi Page
                </option>
            </select>

        </div>
    </div>

    {{-- VARIAÇÃO --}}
    <div class="col-12 col-lg-4 mt-1">
        <div class="mb-0">

            <label class="form-label">
                Variação do Template
            </label>

            <input
                name="template_variation"
                type="text"
                class="form-control"
                value="{{ isset($templateTheme)?$templateTheme->template_variation ?? '' : '' }}"

            >

            <small class="text-muted">
                Definida pelo template selecionado.
            </small>

        </div>
    </div>

    {{-- TECNOLOGIA --}}
    <div class="col-12 mt-1">
        <div class="mb-0">

            <label class="form-label">
                Tecnologia
            </label>

            <div
                class="technology-tags-wrapper form-control d-flex flex-wrap align-items-center gap-2"
                style="
                    min-height: 42px;
                    height: auto;
                    cursor: text;
                    padding: 6px 10px;
                "
            >

                <div class="technology-tags d-flex flex-wrap gap-2"></div>

                <input
                    type="text"
                    class="technology-input"
                    placeholder="Digite uma tecnologia..."
                    autocomplete="off"
                    style="
                        border: 0;
                        outline: 0;
                        box-shadow: none;
                        min-width: 180px;
                        flex: 1;
                        background: transparent;
                        padding: 4px;
                    "
                >

            </div>

            {{-- Esse é o único campo enviado para o Laravel --}}
            <input
                type="hidden"
                name="technology"
                class="technology-hidden"
                value="{{ $templateTheme->technology ?? '' }}"
            >

            <small class="text-muted d-block mt-2">
                Digite uma tecnologia e pressione <strong>Enter</strong> ou <strong>,</strong>
            </small>

        </div>
    </div>

</div>


{{-- ============================================================
DESTAQUES DO TEMPLATE
============================================================ --}}

<div class="row g-3 mt-2">

    <div class="col-12 mt-1">
        <h5 class="mb-0 border-bottom pb-2">
            Destaques do Template
        </h5>
    </div>

    <div class="col-12">

        <label class="form-label">
            Destaques
        </label>

        <div
            class="highlight-tags-wrapper form-control d-flex flex-wrap align-items-center gap-2"
            style="
                min-height: 42px;
                height: auto;
                cursor: text;
                padding: 6px 10px;
            "
        >

            <div
                class="highlight-tags d-flex flex-wrap gap-2"
            ></div>

            <input
                type="text"
                class="highlight-input"
                placeholder="Digite um destaque..."
                autocomplete="off"
                style="
                    border: 0;
                    outline: 0;
                    box-shadow: none;
                    min-width: 180px;
                    flex: 1;
                    background: transparent;
                    padding: 4px;
                "
            >

        </div>

        {{-- Valor enviado para o Laravel --}}
        <input
            type="hidden"
            name="highlights"
            class="highlight-hidden"
            value="{{ $templateTheme->highlights ?? '' }}"
        >

        <small class="text-muted d-block mt-2">
            Digite um destaque e pressione <strong>Enter</strong> ou <strong>,</strong>
        </small>

    </div>

</div>

{{-- ============================================================
PREVIEWS DO TEMPLATE
============================================================ --}}

<div class="row g-3 mt-2">

    <div class="col-12 mt-0">
        <h5 class="mb-0 border-bottom pb-2">
            Preview do Template
        </h5>
    </div>


    {{-- Upload de novas imagens --}}
    <div class="col-12">

        <label class="form-label">
            Imagens do Preview
        </label>

        <div
            class="border rounded-3 p-4 text-center"
            style="
                border-style: dashed !important;
                background: #f8f9fa;
                cursor: pointer;
            "
            onclick="this.querySelector('input').click()"
        >

            <i class="bi bi-images fs-2 text-primary"></i>

            <div class="fw-semibold mt-2">
                Adicionar imagens
            </div>

            <small class="text-muted">
                Selecione uma ou mais imagens para o preview do template
            </small>

            <input
                type="file"
                name="preview[]"
                class="d-none template-preview-input"
                accept="image/png,image/jpeg,image/webp,image/avif"
                multiple
            >

        </div>

        <div
            class="template-preview-new row g-3 mt-2"
        ></div>

    </div>


    {{-- Imagens atuais --}}
    @php

        $templatePreviews = $templateTheme->preview ?? [];

        if (!is_array($templatePreviews)) {
            $templatePreviews = [];
        }

    @endphp


    @if(count($templatePreviews))

        <div class="col-12 mt-4">

            <label class="form-label">
                Imagens atuais
            </label>

            <div class="row g-3">

                @foreach($templatePreviews as $index => $preview)

                    <div
                        class="col-12 col-sm-6 col-md-4 col-lg-3"
                        data-preview-item
                    >

                        <div class="card h-100 border shadow-sm overflow-hidden">

                            <div
                                class="position-relative"
                                style="
                                    height: 220px;
                                    background: #f8f9fa;
                                "
                            >

                                <img
                                    src="{{ url('storage/' . $preview) }}"
                                    alt="Preview do template"
                                    class="w-100 h-100"
                                    style="
                                        object-fit: cover;
                                        object-position: top;
                                    "
                                >


                                {{-- Botão remover --}}
                                <button
                                    type="button"
                                    class="btn btn-danger btn-sm position-absolute top-0 end-0 m-2 rounded-circle"
                                    style="width: 34px; height: 34px; display: flex; justify-content: center; align-items: center;"
                                    onclick="removeTemplatePreview(this)"
                                    title="Remover imagem"
                                >
                                    <i class="bi bi-trash"></i>
                                </button>

                            </div>


                            <div class="card-body p-2">

                                <small class="text-muted text-truncate d-block">
                                    {{ basename($preview) }}
                                </small>

                            </div>

                        </div>


                        {{-- Caminho da imagem que será removida --}}
                        <input
                            type="hidden"
                            name="delete_preview[]"
                            value="{{ $preview }}"
                            disabled
                            data-delete-preview
                        >

                    </div>

                @endforeach

            </div>

        </div>

    @endif

</div>

{{-- STATUS --}}
<div class="col-12 col-lg-2">
    <div class="mt-3">        
        <label class="form-label me-1">
            Status
        </label>
        <input name="active" {{ isset($templateTheme->active) && $templateTheme->active == 1 ? 'checked' : '' }} type="checkbox" class="form-check-input" id="invalidCheck{{isset($templateTheme->id)?$templateTheme->id:''}}" />
    </div>
</div>

<script>
    function removeTemplatePreview(button) {

        const item = button.closest('[data-preview-item]');

        if (!item) {
            return;
        }

        const deleteInput = item.querySelector('[data-delete-preview]');

        if (deleteInput) {
            deleteInput.disabled = false;
        }

        item.style.transition = 'all .25s ease';
        item.style.opacity = '0';
        item.style.transform = 'scale(.9)';

        setTimeout(function () {
            item.remove();
        }, 250);
    }

    document.addEventListener('DOMContentLoaded', function () {

        document
            .querySelectorAll('.template-preview-input')
            .forEach(function (input) {

                input.addEventListener('change', function () {

                    const previewContainer = input
                        .closest('.col-12')
                        .querySelector('.template-preview-new');

                    if (!previewContainer) {
                        return;
                    }

                    previewContainer.innerHTML = '';


                    Array.from(input.files).forEach(function (file) {

                        if (!file.type.startsWith('image/')) {
                            return;
                        }


                        const reader = new FileReader();


                        reader.onload = function (event) {

                            const col = document.createElement('div');

                            col.className =
                                'col-12 col-sm-6 col-md-4 col-lg-3';


                            col.innerHTML = `
                                <div class="card border shadow-sm overflow-hidden">

                                    <div
                                        class="position-relative"
                                        style="
                                            height: 220px;
                                            background: #f8f9fa;
                                        "
                                    >

                                        <img
                                            src="${event.target.result}"
                                            class="w-100 h-100"
                                            style="
                                                object-fit: cover;
                                                object-position: top;
                                            "
                                        >

                                        <span
                                            class="badge bg-success position-absolute top-0 start-0 m-2"
                                        >
                                            Nova
                                        </span>

                                    </div>

                                    <div class="card-body p-2">

                                        <small
                                            class="text-muted text-truncate d-block"
                                        >
                                            ${file.name}
                                        </small>

                                    </div>

                                </div>
                            `;


                            previewContainer.appendChild(col);

                        };


                        reader.readAsDataURL(file);

                    });

                });

            });

    });
</script>

<style>
    [data-preview-item] {
        transition:
            opacity .3s ease,
            transform .3s ease,
            filter .3s ease;
    }

    [data-preview-item].template-preview-removing {
        opacity: .45;
        transform: scale(.97);
    }

    [data-preview-item].template-preview-removing img {
        filter: grayscale(1);
    }

    [data-preview-item].template-preview-removing .card {
        border: 2px solid #dc3545 !important;
    }
</style>