
{{-- ============================================================
DADOS DO CLIENTE
============================================================ --}}

<div class="row g-3">
    <div class="col-12">
        <h5 class="mb-3 border-bottom pb-2">Dados do Cliente</h5>
    </div>

    <div class="mb-3 col-12 col-md-6">
        <label for="name{{ isset($tenant->id) ? $tenant->id : '' }}" class="form-label">
            Nome
        </label>

        <input
            type="text"
            name="name"
            id="name{{ isset($tenant->id) ? $tenant->id : '' }}"
            class="form-control @error('name') is-invalid @enderror"
            value="{{ old('name', $tenant->name ?? '') }}"
            placeholder="Nome do cliente"
            required
        >

        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3 col-12 col-md-6">
        <label for="domain{{ isset($tenant->id) ? $tenant->id : '' }}" class="form-label">
            Domínio
        </label>

        <input
            type="text"
            name="domain"
            id="domain{{ isset($tenant->id) ? $tenant->id : '' }}"
            class="form-control @error('domain') is-invalid @enderror"
            value="{{ old('domain', $tenant->domain ?? '') }}"
            placeholder="exemplo.com.br"
            required
        >

        @error('domain')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

{{-- ============================================================
PLANO E LIMITES
============================================================ --}}

<div class="row mt-4">
    <div class="col-12">
        <h5 class="mb-3 border-bottom pb-2">Plano e Limites</h5>
    </div>

    <div class="mb-3 col-12">
        <label for="plan_id{{ isset($tenant->id) ? $tenant->id : '' }}" class="form-label">
            Plano
        </label>

        <select
            name="plan_id"
            id="plan_id{{ isset($tenant->id) ? $tenant->id : '' }}"
            class="form-select @error('plan_id') is-invalid @enderror"
        >
            <option value="">Selecione um plano</option>

            @foreach ($plans as $planOption)
                <option
                    value="{{ $planOption->id }}"
                    {{ old('plan_id', $tenant->plan_id ?? '') == $planOption->id ? 'selected' : '' }}
                >
                    {{ $planOption->name }}
                    @if(isset($planOption->price))
                        - R$ {{ number_format($planOption->price, 2, ',', '.') }}
                    @endif
                </option>
            @endforeach
        </select>

        @error('plan_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12 mt-2">
        <h6 class="mb-1">Limites personalizados</h6>

        <p class="text-muted mb-3">
            Informe somente os limites que deseja personalizar para este cliente.
            Campos vazios utilizarão o limite definido pelo plano.
        </p>
    </div>

    @foreach ($availableModules as $module => $moduleName)
        <div class="mb-3 col-12 col-md-4 col-lg-3">
            <label for="limit_{{ $module }}{{ isset($tenant->id) ? $tenant->id : '' }}" class="form-label">
                {{ $moduleName }}
            </label>

            <input
                type="number"
                name="limits[{{ $module }}]"
                class="form-control @error('limits.' . $module) is-invalid @enderror"
                id="limit_{{ $module }}{{ isset($tenant->id) ? $tenant->id : '' }}"
                value="{{ old('limits.' . $module, isset($tenantModuleLimits[$module]) ? $tenantModuleLimits[$module]->limit : '') }}"
                min="0"
                placeholder="Padrão do plano"
            >

            <small class="text-muted">
                {{ $module }}
            </small>

            @error('limits.' . $module)
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    @endforeach

    <div class="col-12 mt-2">
        <div class="alert alert-info mb-0">
            <div class="d-flex align-items-start">
                <i class="mdi mdi-information-outline font-20 me-2"></i>

                <div>
                    <strong>Como funcionam os limites?</strong>

                    <p class="mb-0 mt-1">
                        O limite personalizado do cliente tem prioridade sobre o
                        limite definido no plano. Se nenhum limite personalizado
                        for informado, será utilizado o limite do plano. Caso o
                        plano também não possua limite, será utilizado o limite
                        definido no arquivo <code>template_modules.php</code>.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ============================================================
TEMPLATE
============================================================ --}}

<div class="row mt-4">
    <div class="col-12">
        <h5 class="mb-3 border-bottom pb-2">Configurações do Template</h5>
    </div>

    <div class="mb-3 col-12 col-md-6">
        <label for="template_theme_id{{ isset($tenant->id) ? $tenant->id : '' }}" class="form-label">
            Template
        </label>

        <input
            type="text"
            class="form-control"
            id="template_theme_id{{ isset($tenant->id) ? $tenant->id : '' }}"
            value="{{ $tenant->templateTheme->name ?? $tenant->template_theme_id ?? '' }}"
            readonly
        >
    </div>

    <div class="mb-3 col-12 col-md-6">
        <label for="template_variation" class="form-label">
            Variação do Template
        </label>

        <input
            type="text"
            class="form-control"
            id="template_variation"
            value="{{ $tenant->templateTheme->template_variation ?? '' }}"
            readonly
        >
    </div>

    <input
        type="hidden"
        name="template_theme_id"
        value="{{ old('template_theme_id', $tenant->template_theme_id ?? '') }}"
    >
</div>

{{-- ============================================================
HEADER
============================================================ --}}

<div class="row mt-4">
    <div class="col-12">
        <h5 class="mb-3 border-bottom pb-2">Configurações do Header</h5>
    </div>

    <div class="mb-3 col-12 col-md-6">
        <label class="form-label">Cor do texto no Header</label>

        <input
            type="text"
            name="text_color_header"
            class="form-control"
            id="colorpicker-text-header"
            value="{{ old('text_color_header', $tenant->text_color_header ?? '') }}"
        >
    </div>

    <div class="mb-3 col-12 col-md-6">
        <label class="form-label">Cor do Header</label>

        <input
            type="text"
            name="bg_header"
            class="form-control"
            id="colorpicker-bg-header"
            value="{{ old('bg_header', $tenant->bg_header ?? '') }}"
        >
    </div>

    <div class="mb-3 col-12 col-md-6">
        <label class="form-label">Cor do Scroll</label>

        <input
            type="text"
            name="bg_scroll"
            class="form-control"
            id="colorpicker-bg-scroll"
            value="{{ old('bg_scroll', $tenant->bg_scroll ?? '') }}"
        >
    </div>
</div>

{{-- ============================================================
CORES GERAIS
============================================================ --}}

<div class="row mt-4">
    <div class="col-12">
        <h5 class="mb-3 border-bottom pb-2">Cores Gerais</h5>
    </div>

    <div class="mb-3 col-12 col-md-6">
        <label class="form-label">Cor Primária</label>

        <input
            type="text"
            name="primary_color"
            class="form-control"
            id="colorpicker-primary"
            value="{{ old('primary_color', $tenant->primary_color ?? '') }}"
        >
    </div>

    <div class="mb-3 col-12 col-md-6">
        <label class="form-label">Cor Secundária</label>

        <input
            type="text"
            name="secondary_color"
            class="form-control"
            id="colorpicker-secondary"
            value="{{ old('secondary_color', $tenant->secondary_color ?? '') }}"
        >
    </div>

    <div class="mb-3 col-12 col-md-6">
        <label class="form-label">Cor de Destaque (Accent)</label>

        <input
            type="text"
            name="accent_color"
            class="form-control"
            id="colorpicker-accent"
            value="{{ old('accent_color', $tenant->accent_color ?? '') }}"
        >
    </div>

    <div class="mb-3 col-12 col-md-6">
        <label class="form-label">Cor do Texto</label>

        <input
            type="text"
            name="text_color"
            class="form-control"
            id="colorpicker-text"
            value="{{ old('text_color', $tenant->text_color ?? '') }}"
        >
    </div>
</div>

{{-- ============================================================
BOTÕES
============================================================ --}}

<div class="row mt-4">
    <div class="col-12">
        <h5 class="mb-3 border-bottom pb-2">Configurações dos Botões</h5>
    </div>

    <div class="mb-3 col-12 col-md-6">
        <label class="form-label">Texto do Botão 1</label>

        <input
            type="text"
            name="text_button_one"
            class="form-control"
            value="{{ old('text_button_one', $tenant->text_button_one ?? '') }}"
            placeholder="Ex: Comprar Agora"
        >
    </div>

    <div class="mb-3 col-12 col-md-6">
        <label class="form-label">Cor do Texto Botão 1</label>

        <input
            type="text"
            name="color_button_one"
            class="form-control"
            id="colorpicker-color-button1"
            value="{{ old('color_button_one', $tenant->color_button_one ?? '') }}"
        >
    </div>

    <div class="mb-3 col-12 col-md-6">
        <label class="form-label">Cor de Fundo Botão 1</label>

        <input
            type="text"
            name="bg_button_one"
            class="form-control"
            id="colorpicker-bg-button1"
            value="{{ old('bg_button_one', $tenant->bg_button_one ?? '') }}"
        >
    </div>

    <div class="mb-3 col-12 col-md-6">
        <label class="form-label">Texto do Botão 2</label>

        <input
            type="text"
            name="text_button_two"
            class="form-control"
            value="{{ old('text_button_two', $tenant->text_button_two ?? '') }}"
            placeholder="Ex: Saiba Mais"
        >
    </div>

    <div class="mb-3 col-12 col-md-6">
        <label class="form-label">Cor do Texto Botão 2</label>

        <input
            type="text"
            name="color_button_two"
            class="form-control"
            id="colorpicker-color-button2"
            value="{{ old('color_button_two', $tenant->color_button_two ?? '') }}"
        >
    </div>

    <div class="mb-3 col-12 col-md-6">
        <label class="form-label">Cor de Fundo Botão 2</label>

        <input
            type="text"
            name="bg_button_two"
            class="form-control"
            id="colorpicker-bg-button2"
            value="{{ old('bg_button_two', $tenant->bg_button_two ?? '') }}"
        >
    </div>
</div>

{{-- ============================================================
RODAPÉ
============================================================ --}}

<div class="row mt-4">
    <div class="col-12">
        <h5 class="mb-3 border-bottom pb-2">Configurações do Rodapé</h5>
    </div>

    <div class="mb-3 col-12 col-md-6">
        <label for="copyright" class="form-label">
            Copyright
        </label>

        <input
            type="text"
            name="copyright"
            class="form-control"
            id="copyright"
            value="{{ old('copyright', $tenant->copyright ?? '') }}"
            placeholder="Ex: © 2026 Minha Empresa"
        >
    </div>
</div>

{{-- ============================================================
IMAGENS
============================================================ --}}

<div class="row mt-4">
    <div class="col-12">
        <h5 class="mb-3 border-bottom pb-2">Imagens</h5>
    </div>

    <div class="mb-3 col-12 col-md-6">
        <label for="path_image_logo_header" class="form-label">
            Logo do Header
        </label>

        <input
            type="file"
            name="path_image_logo_header"
            id="path_image_logo_header"
            data-plugins="dropify"
            data-default-file="{{ isset($tenant) && $tenant->path_image_logo_header ? url('storage/' . $tenant->path_image_logo_header) : '' }}"
        >

        <p class="text-muted text-center mt-2 mb-0">
            {{ __('dashboard.text_img_size') }}
            <b class="text-danger">2 MB</b>.
        </p>
    </div>

    <div class="mb-3 col-12 col-md-6">
        <label for="path_image_logo_footer" class="form-label">
            Logo do Footer
        </label>

        <input
            type="file"
            name="path_image_logo_footer"
            id="path_image_logo_footer"
            data-plugins="dropify"
            data-default-file="{{ isset($tenant) && $tenant->path_image_logo_footer ? url('storage/' . $tenant->path_image_logo_footer) : '' }}"
        >

        <p class="text-muted text-center mt-2 mb-0">
            {{ __('dashboard.text_img_size') }}
            <b class="text-danger">2 MB</b>.
        </p>
    </div>
</div>

{{-- ============================================================
STATUS
============================================================ --}}

@if (isset($tenant))
    <div class="row mt-4">
        <div class="col-12">
            <h5 class="mb-3 border-bottom pb-2">Status</h5>
        </div>

        <div class="col-12">
            <div class="form-check">
                <input
                    name="active"
                    value="1"
                    type="checkbox"
                    class="form-check-input"
                    id="active{{ $tenant->id }}"
                    {{ old('active', $tenant->active ?? true) ? 'checked' : '' }}
                >

                <label
                    class="form-check-label"
                    for="active{{ $tenant->id }}"
                >
                    Cliente ativo?
                </label>
            </div>
        </div>
    </div>
@endif

