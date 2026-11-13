{{-- ============================================================
    1. IDENTIFICAÇÃO DA ABA
============================================================ --}}

<div class="mb-3">
    <h5 class="mb-1">Identificação da seção</h5>

    <p class="text-muted mb-3">
        Defina o nome e o ícone que serão utilizados para identificar esta seção no site.
    </p>
</div>

<div class="row g-3">

    <div class="col-12 mb-3">

        <label
            for="title{{ isset($impactSection->id) ? $impactSection->id : '' }}"
            class="form-label"
        >
            Nome da seção
        </label>

        <input
            type="text"
            name="title"
            class="form-control"
            id="title{{ isset($impactSection->id) ? $impactSection->id : '' }}"
            value="{{ old('title', isset($impactSection) ? $impactSection->title : '') }}"
            placeholder="Ex.: Educação"
        >

        <small class="text-muted">
            Este nome será utilizado para identificar a seção na navegação do site.
        </small>

    </div>

    <div class="col-lg-12 mb-3">

        <label
            for="path_icon{{ isset($impactSection->id) ? $impactSection->id : '' }}"
            class="form-label"
        >
            Ícone da seção
        </label>

        <input
            type="file"
            name="path_icon"
            id="path_icon{{ isset($impactSection->id) ? $impactSection->id : '' }}"
            data-plugins="dropify"
            data-default-file="{{ isset($impactSection) ? ($impactSection->path_icon != '' ? url('storage/'.$impactSection->path_icon) : '') : '' }}"
        />

        <p class="text-muted text-center mt-2 mb-0">
            {{ __('dashboard.text_img_size') }}
            <b class="text-danger">2 MB</b>.
        </p>

    </div>

</div>


{{-- ============================================================
    2. CONTEÚDO DA SEÇÃO
============================================================ --}}

<div class="mt-4 mb-3">

    <h5 class="mb-1">
        Conteúdo da seção
    </h5>

    <p class="text-muted mb-3">
        Configure o título, a descrição e a imagem que serão apresentados nesta seção.
    </p>

</div>

<div class="row g-3">

    <div class="col-12 mb-3">

        <label
            for="content_title{{ isset($impactSection->id) ? $impactSection->id : '' }}"
            class="form-label"
        >
            Título do conteúdo
        </label>

        <input
            type="text"
            name="content_title"
            class="form-control"
            id="content_title{{ isset($impactSection->id) ? $impactSection->id : '' }}"
            value="{{ old('content_title', isset($impactSection) ? $impactSection->content_title : '') }}"
            placeholder="Ex.: Nosso impacto"
        >

    </div>

    <div class="col-12 mb-3">

        <label
            for="content_text{{ isset($impactSection->id) ? $impactSection->id : '' }}"
            class="form-label"
        >
            Descrição
        </label>

        <textarea
            name="content_text"
            class="form-control"
            id="content_text{{ isset($impactSection->id) ? $impactSection->id : '' }}"
            rows="4"
            placeholder="Digite uma descrição para apresentar o conteúdo desta seção."
        >{{ old('content_text', isset($impactSection) ? $impactSection->content_text : '') }}</textarea>

    </div>

    <div class="col-lg-12 mb-3">

        <label
            for="path_image{{ isset($impactSection->id) ? $impactSection->id : '' }}"
            class="form-label"
        >
            Imagem da seção
        </label>

        <input
            type="file"
            name="path_image"
            id="path_image{{ isset($impactSection->id) ? $impactSection->id : '' }}"
            data-plugins="dropify"
            data-default-file="{{ isset($impactSection) ? ($impactSection->path_image != '' ? url('storage/'.$impactSection->path_image) : '') : '' }}"
        />

        <p class="text-muted text-center mt-2 mb-0">
            {{ __('dashboard.text_img_size') }}
            <b class="text-danger">2 MB</b>.
        </p>

    </div>

</div>


{{-- ============================================================
    3. INDICADORES / MÉTRICAS
============================================================ --}}
@if (Auth::user()->hasPermissionTo('metricas.visualizar') &&
Auth::user()->hasPermissionTo('metricas.criar') ||
Auth::user()->hasPermissionTo('usuario.tornar usuario master') || 
Auth::user()->hasRole('Super'))
    <div class="mt-4 mb-3">

        <h5 class="mb-1">
            Indicadores da seção
        </h5>

        <p class="text-muted mb-3">
            Cadastre os números ou indicadores que serão exibidos junto ao conteúdo da seção.
        </p>

    </div>

    <div class="impact-metrics">

        @if(isset($impactSection) && $impactSection?->metrics)

            @foreach($impactSection->metrics as $index => $metric)

                <div class="metric-item border rounded p-3 mb-3">

                    <input
                        type="hidden"
                        name="metrics[{{ $index }}][id]"
                        value="{{ $metric->id }}"
                    >

                    <div class="row g-3">

                        <div class="col-md-6">

                            <label class="form-label">
                                Nome do indicador
                            </label>

                            <input
                                type="text"
                                name="metrics[{{ $index }}][title]"
                                class="form-control"
                                value="{{ old("metrics.$index.title", $metric->title) }}"
                                placeholder="Ex.: Pessoas beneficiadas"
                            >

                        </div>

                        <div class="col-md-6">

                            <label class="form-label">
                                Valor do indicador
                            </label>

                            <input
                                type="text"
                                name="metrics[{{ $index }}][value]"
                                class="form-control"
                                value="{{ old("metrics.$index.value", $metric->value) }}"
                                placeholder="Ex.: 80"
                            >

                        </div>

                        <div class="col-12">

                            <div class="form-check">

                                <input
                                    type="hidden"
                                    name="metrics[{{ $index }}][active]"
                                    value="0"
                                >

                                <input
                                    type="checkbox"
                                    name="metrics[{{ $index }}][active]"
                                    value="1"
                                    class="form-check-input"
                                    {{ old("metrics.$index.active", $metric->active) ? 'checked' : '' }}
                                >

                                <label class="form-check-label">
                                    {{ __('dashboard.active') }}?
                                </label>

                            </div>

                        </div>

                        <div class="col-12 text-end">

                            <button
                                type="button"
                                class="btn btn-sm btn-outline-danger remove-impact-metric"
                            >
                                <i class="mdi mdi-delete-outline me-1"></i>
                                Remover indicador
                            </button>

                        </div>

                    </div>

                </div>

            @endforeach

        @endif

    </div>

    <div class="d-flex justify-content-end mt-3">

        <button
            type="button"
            class="btn btn-outline-primary add-impact-metric"
        >
            <i class="mdi mdi-plus me-1"></i>
            Adicionar indicador
        </button>

    </div>
@endif

{{-- ============================================================
    4. STATUS DO CADASTRO
============================================================ --}}

<div class="mt-4 mb-3">

    <h5 class="mb-1">
        Disponibilidade da seção
    </h5>

    <p class="text-muted mb-3">
        Defina se esta seção ficará disponível para os visitantes do site.
    </p>

</div>

<div class="mb-3">

    <div class="form-check">

        <input
            type="checkbox"
            name="active"
            value="1"
            class="form-check-input"
            id="active{{ isset($impactSection->id) ? $impactSection->id : '' }}"
            {{ old('active', isset($impactSection) ? $impactSection->active : 1) ? 'checked' : '' }}
        >

        <label
            class="form-check-label"
            for="active{{ isset($impactSection->id) ? $impactSection->id : '' }}"
        >
            {{ __('dashboard.active') }}?
        </label>

    </div>

</div>


{{-- ============================================================
    JAVASCRIPT - INDICADORES
============================================================ --}}

<script>
    document.addEventListener('DOMContentLoaded', function () {

        document.addEventListener('click', function (event) {

            const addButton = event.target.closest('.add-impact-metric');

            if (addButton) {

                const form = addButton.closest('form');
                const container = form.querySelector('.impact-metrics');

                const metricIndex = container.querySelectorAll('.metric-item').length;

                const item = document.createElement('div');

                item.className = 'metric-item border rounded p-3 mb-3';

                item.innerHTML = `
                    <div class="row g-3">

                        <div class="col-md-6">

                            <label class="form-label">
                                Nome do indicador
                            </label>

                            <input
                                type="text"
                                name="metrics[${metricIndex}][title]"
                                class="form-control"
                                placeholder="Ex.: Pessoas beneficiadas"
                            >

                        </div>

                        <div class="col-md-6">

                            <label class="form-label">
                                Valor do indicador
                            </label>

                            <input
                                type="text"
                                name="metrics[${metricIndex}][value]"
                                class="form-control"
                                placeholder="Ex.: 80"
                            >

                        </div>

                        <div class="col-12">

                            <div class="form-check">

                                <input
                                    type="hidden"
                                    name="metrics[${metricIndex}][active]"
                                    value="0"
                                >

                                <input
                                    type="checkbox"
                                    name="metrics[${metricIndex}][active]"
                                    value="1"
                                    class="form-check-input"
                                    checked
                                >

                                <label class="form-check-label">
                                    {{ __('dashboard.active') }}?
                                </label>

                            </div>

                        </div>

                        <div class="col-12 text-end">

                            <button
                                type="button"
                                class="btn btn-sm btn-outline-danger remove-impact-metric"
                            >
                                <i class="mdi mdi-delete-outline me-1"></i>
                                Remover indicador
                            </button>

                        </div>

                    </div>
                `;

                container.appendChild(item);

                return;
            }

            const removeButton = event.target.closest('.remove-impact-metric');

            if (removeButton) {

                removeButton
                    .closest('.metric-item')
                    .remove();

            }

        });

    });
</script>