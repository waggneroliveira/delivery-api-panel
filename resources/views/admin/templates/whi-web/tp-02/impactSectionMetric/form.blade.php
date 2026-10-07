<div class="row g-3">

    <div class="mb-3 col-12">
        <label for="title{{ isset($impactSectionMetric->id) ? $impactSectionMetric->id : '' }}" class="form-label">
            Título
        </label>

        <input
            type="text"
            name="title"
            class="form-control"
            id="title{{ isset($impactSectionMetric->id) ? $impactSectionMetric->id : '' }}"
            value="{{ old('title', isset($impactSectionMetric) ? $impactSectionMetric->title : '') }}"
            placeholder="Ex.: Educação"
        >
    </div>

    <div class="mb-3 col-12">
        <label for="value{{ isset($impactSectionMetric->id) ? $impactSectionMetric->id : '' }}" class="form-label">
            Valor em números
        </label>

        <input
            type="text"
            name="value"
            class="form-control"
            id="value{{ isset($impactSectionMetric->id) ? $impactSectionMetric->id : '' }}"
            value="{{ old('value', isset($impactSectionMetric) ? $impactSectionMetric->value : '') }}"
            placeholder="Ex.: 80"
        >
    </div>

</div>

<div class="mt-4 mb-3">
    <h5 class="mb-1">Status do cadastro</h5>
    <p class="text-muted mb-3">
        Defina se esta métrica ficará disponível no site.
    </p>
</div>

<div class="mb-3 col-12">
    <div class="form-check">
        <input
            name="active"
            type="checkbox"
            class="form-check-input"
            id="active{{ isset($impactSectionMetric->id) ? $impactSectionMetric->id : '' }}"
            value="1"
            {{ old('active', isset($impactSectionMetric) ? $impactSectionMetric->active : 1) ? 'checked' : '' }}
        />

        <label
            class="form-check-label"
            for="active{{ isset($impactSectionMetric->id) ? $impactSectionMetric->id : '' }}"
        >
            {{ __('dashboard.active') }}?
        </label>
    </div>
</div>