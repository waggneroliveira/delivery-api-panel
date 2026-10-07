@php
    $formPrefix = $formPrefix ?? 'default';
@endphp
{{-- ============================================================
DADOS DO CLIENTE
============================================================ --}}
@if (Auth::user()->hasRole('Super'))
    <div class="row g-3">
        <div class="col-12">
            <h5 class="mb-3 border-bottom pb-2">Dados do Cliente</h5>
        </div>
    
        {{-- NOME --}}
        <div class="col-12 col-lg-4">
            <div class="mb-3">
                <label for="name{{ isset($tenant->id) ? $tenant->id : '' }}" class="form-label">Nome</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name{{ isset($tenant->id) ? $tenant->id : '' }}" value="{{ old('name', $tenant->name ?? '') }}" placeholder="Nome do cliente" readonly required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    
        {{-- DOMÍNIO --}}
        <div class="col-12 col-lg-4">
            <div class="mb-3">
                <label for="domain{{ isset($tenant->id) ? $tenant->id : '' }}" class="form-label">Domínio</label>
                <input type="text" class="form-control @error('domain') is-invalid @enderror" id="domain{{ isset($tenant->id) ? $tenant->id : '' }}" value="{{ old('domain', $tenant->domain ?? '') }}" placeholder="exemplo.com.br" readonly required>
                @error('domain')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        
        {{-- PLANO --}}
        <div class="col-12 col-lg-4">
            <div class="mb-3">
                <label for="plan_id{{ isset($tenant->id) ? $tenant->id : '' }}" class="form-label">
                    Plano contratado
                </label>

            @php
                $selectedPlanId = old(
                    'plan_id',
                    $tenant->plan_id ?? ''
                );

                $selectedPlan = collect($plans ?? [])
                    ->firstWhere('id', $selectedPlanId);
            @endphp

            <input
                type="text"
                class="form-control"
                value="{{ $selectedPlan?->name ?? 'Nenhum plano selecionado' }}"
                readonly
            >

            <input
                type="hidden"
                id="plan_id{{ isset($tenant->id) ? $tenant->id : '' }}"
                name="plan_id"
                value="{{ $selectedPlanId }}"
            >

            @error('plan_id')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>
    </div>
@endif

{{-- ============================================================
INFORMAÇÕES DO TEMPLATE
============================================================ --}}

<div class="row g-3 mt-2">
    <div class="col-12">
        <h5 class="mb-3 border-bottom pb-2">Informações do Template</h5>
    </div>

    {{-- NOME --}}
    <div class="col-12 col-lg-3">
        <div class="mb-3">
            <label class="form-label">Nome do Template</label>
            <input type="text" class="form-control" value="{{ $tenant->templateTheme->name ?? '' }}" readonly>
        </div>
    </div>

    {{-- LAYOUT TYPE --}}
    @if(isset($tenant->templateTheme->layout_type))
        <div class="col-12 col-lg-3">
            <div class="mb-3">
                <label class="form-label">Tipo de layout</label>
                <input type="text" class="form-control" value="{{ $tenant->templateTheme->layout_type }}" readonly>
            </div>
        </div>
    @endif

    {{-- VARIAÇÃO --}}
    <div class="col-12 col-lg-3">
        <div class="mb-3">
            <label for="template_variation" class="form-label">Variação do Template</label>
            <input type="text" class="form-control" id="template_variation" value="{{ $tenant->templateTheme->template_variation ?? '' }}" readonly>
            <small class="text-muted">Definida pelo template selecionado.</small>
        </div>
    </div>
    
    {{-- BANCO --}}
    @if(isset($tenant))
        <div class="col-12 col-lg-3">
            <div class="mb-3">
                <label class="form-label">Banco de dados</label>
                <input type="text" class="form-control" value="{{ $tenant->database ?? '' }}" readonly>
                <small class="text-muted">Campo gerenciado pelo sistema.</small>
            </div>
        </div>
    @endif
</div>

{{-- ============================================================
CORES GERAIS
============================================================ --}}

<div class="row g-3 mt-2">
    <div class="col-12">
        <h5 class="mb-3 border-bottom pb-2">Cores Gerais</h5>
    </div>

    <div class="col-12 col-lg-4">
        <div class="mb-3">
            <label class="form-label">Cor primária</label>
            <input type="text" name="primary_color" class="form-control" id="colorpicker-default" value="{{ old('primary_color', $tenant->primary_color ?? '') }}">
        </div>
    </div>

    <div class="col-12 col-lg-4">
        <div class="mb-3">
            <label class="form-label">Cor secundária</label>
            <input type="text" name="secondary_color" class="form-control" id="colorpicker-showalpha" value="{{ old('secondary_color', $tenant->secondary_color ?? '') }}">
        </div>
    </div>

    <div class="col-12 col-lg-4">
        <div class="mb-3">
            <label class="form-label">Cor de destaque</label>
            <input type="text" name="accent_color" class="form-control" id="colorpicker-showpaletteonly" value="{{ old('accent_color', $tenant->accent_color ?? '') }}">
        </div>
    </div>

    <div class="col-12 col-lg-3 d-none">
        <div class="mb-3">
            <label class="form-label">Cor do texto</label>
            <input type="text" name="text_color" class="form-control" id="colorpicker-togglepaletteonly" value="{{ old('text_color', $tenant->text_color ?? '') }}">
        </div>
    </div>
</div>

{{-- ============================================================
HEADER
============================================================ --}}

<div class="row g-3 mt-2">
    <div class="col-12">
        <h5 class="mb-3 border-bottom pb-2">Configurações do Header</h5>
    </div>

    <div class="col-12 col-lg-2">
        <div class="mb-3">
            <label class="form-label">Cor texto Header</label>
            <input type="text" name="text_color_header" class="form-control" id="colorpicker-text-header" value="{{ old('text_color_header', $tenant->text_color_header ?? '') }}">
        </div>
    </div>

    <div class="col-12 col-lg-2">
        <div class="mb-3">
            <label class="form-label">Cor do Header</label>
            <input type="text" name="bg_header" class="form-control" id="colorpicker-bg-header" value="{{ old('bg_header', $tenant->bg_header ?? '') }}">
        </div>
    </div>

        <div class="col-12 col-lg-3">
        <div class="mb-3">
            <label class="form-label">Título Botão</label>
            <input type="text" name="btn_title_header" class="form-control" value="{{ old('btn_title_header', $tenant->btn_title_header ?? '') }}">
        </div>
    </div>

    <div class="col-12 col-lg-5">
        <div class="mb-3">
            <label class="form-label">Link Botão</label>
            <input type="text" name="link_header" class="form-control" value="{{ old('link_header', $tenant->link_header ?? '') }}">
        </div>
    </div>
</div>

{{-- ============================================================
BOTÃO 1
============================================================ --}}

<div class="row g-3 mt-2">
    <div class="col-12">
        <h5 class="mb-3 border-bottom pb-2">Configurações do Botão Primário</h5>
    </div>

    <div class="col-12 col-lg-4 d-none">
        <div class="mb-3">
            <label class="form-label">Texto do Botão Primário</label>
            <input type="text" name="text_button_one" class="form-control" value="{{ old('text_button_one', $tenant->text_button_one ?? '') }}">
        </div>
    </div>

    <div class="col-12 col-lg-6">
        <div class="mb-3">
            <label class="form-label">Cor do Texto</label>
            <input type="text" name="color_button_one" class="form-control" id="colorpicker-color-button1" value="{{ old('color_button_one', $tenant->color_button_one ?? '') }}">
        </div>
    </div>

    <div class="col-12 col-lg-6">
        <div class="mb-3">
            <label class="form-label">Cor de Fundo</label>
            <input type="text" name="bg_button_one" class="form-control" id="colorpicker-bg-button1" value="{{ old('bg_button_one', $tenant->bg_button_one ?? '') }}">
        </div>
    </div>
</div>

{{-- ============================================================
BOTÃO 2
============================================================ --}}

<div class="row g-3 mt-2">
    <div class="col-12">
        <h5 class="mb-3 border-bottom pb-2">Configurações do Botão Secundário</h5>
    </div>

    <div class="col-12 col-lg-4 d-none">
        <div class="mb-3">
            <label class="form-label">Texto do Botão Secundário</label>
            <input type="text" name="text_button_two" class="form-control" value="{{ old('text_button_two', $tenant->text_button_two ?? '') }}">
        </div>
    </div>

    <div class="col-12 col-lg-6">
        <div class="mb-3">
            <label class="form-label">Cor do Texto</label>
            <input type="text" name="color_button_two" class="form-control" id="colorpicker-color-button2" value="{{ old('color_button_two', $tenant->color_button_two ?? '') }}">
        </div>
    </div>

    <div class="col-12 col-lg-6">
        <div class="mb-3">
            <label class="form-label">Cor de Fundo</label>
            <input type="text" name="bg_button_two" class="form-control" id="colorpicker-bg-button2" value="{{ old('bg_button_two', $tenant->bg_button_two ?? '') }}">
        </div>
    </div>
</div>


{{-- ============================================================
POLITICA DE PRIVACIDADE
============================================================ --}}

<div class="row g-3 mt-2">  
    <div class="col-12">
        <h5 class="mb-3 border-bottom pb-2">Política de Privacidade e Termos de Uso</h5>
    </div>

    <div class="row">
        <div class="mb-3 col-lg-6">
            <label
                for="{{ $formPrefix }}_privacy_policy"
                class="form-label text-white"
            >
                Política de Privacidade
            </label>

            <textarea
                name="privacy_policy"
                id="{{ $formPrefix }}_privacy_policy"
                placeholder="Digite a Política de Privacidade"
                class="form-control js-ckeditor"
                rows="10"
            >{!! $tenant->privacy_policy ?? '' !!}</textarea>
        </div>

        <div class="mb-3 col-lg-6">
            <label
                for="{{ $formPrefix }}_terms_of_use"
                class="form-label text-white"
            >
                Termos de Uso
            </label>

            <textarea
                name="terms_of_use"
                id="{{ $formPrefix }}_terms_of_use"
                placeholder="Digite os Termos de Uso"
                class="form-control js-ckeditor"
                rows="10"
            >{!! $tenant->terms_of_use ?? '' !!}</textarea>
        </div>
    </div>
</div>

{{-- ============================================================
RODAPÉ
============================================================ --}}

<div class="row g-3 mt-2">
    <div class="col-12">
        <h5 class="mb-3 border-bottom pb-2">Rodapé</h5>
    </div>

        <div class="col-12 col-lg-4">
        <div class="mb-3">
            <label class="form-label">Cor do texto no Footer</label>
            <input type="text" name="text_color_footer" class="form-control" id="colorpicker-text-footer" value="{{ old('text_color_footer', $tenant->text_color_footer ?? '') }}">
        </div>
    </div>

    <div class="col-12 col-lg-4">
        <div class="mb-3">
            <label class="form-label">Cor do Footer</label>
            <input type="text" name="bg_footer" class="form-control" id="colorpicker-bg-footer" value="{{ old('bg_footer', $tenant->bg_footer ?? '') }}">
        </div>
    </div>

    <div class="col-12 col-lg-4">
        <div class="mb-3">
            <label class="form-label">Cor do Scroll</label>
            <input type="text" name="bg_scroll" class="form-control" id="colorpicker-bg-scroll" value="{{ old('bg_scroll', $tenant->bg_scroll ?? '') }}">
        </div>
    </div>

    <div class="col-12 col-lg-12">
        <div class="mb-3">
            <label for="copyright" class="form-label">Copyright</label>
            <input type="text" name="copyright" class="form-control" id="copyright" value="{{ old('copyright', $tenant->copyright ?? '') }}" placeholder="Ex.: © 2026 Minha Empresa">
        </div>
    </div>
</div>

{{-- ============================================================
LOGOS
============================================================ --}}

<div class="row g-3 mt-2">
    <div class="col-12">
        <h5 class="mb-3 border-bottom pb-2">Logos</h5>
    </div>

    <div class="col-12 col-lg-6">
        <div class="mb-3">
            <label for="path_image_logo_header" class="form-label">Logo Header</label>
            <input type="file" name="path_image_logo_header" id="path_image_logo_header" data-plugins="dropify" data-default-file="{{ !empty($tenant->path_image_logo_header) ? url('storage/' . $tenant->path_image_logo_header) : '' }}">
            <p class="text-muted text-center mt-2 mb-0">
                {{ __('dashboard.text_img_size') }} <b class="text-danger">2 MB</b>.
            </p>
        </div>
    </div>

    <div class="col-12 col-lg-6">
        <div class="mb-3">
            <label for="path_image_logo_footer" class="form-label">Logo Footer</label>
            <input type="file" name="path_image_logo_footer" id="path_image_logo_footer" data-plugins="dropify" data-default-file="{{ !empty($tenant->path_image_logo_footer) ? url('storage/' . $tenant->path_image_logo_footer) : '' }}">
            <p class="text-muted text-center mt-2 mb-0">
                {{ __('dashboard.text_img_size') }} <b class="text-danger">2 MB</b>.
            </p>
        </div>
    </div>
</div>

{{-- ============================================================
LIMITES PERSONALIZADOS
============================================================ --}}

@if (Auth::user()->hasRole('Super'))
    <div class="row mt-4">
        <div class="col-12">
            <hr>
            <h5 class="mb-1">Limites Personalizados</h5>
            <p class="text-muted mb-3">
                Estes valores sobrescrevem os limites definidos no plano.
                Deixe vazio para utilizar o limite do plano ou do template.
            </p>
        </div>

        @foreach ($availableModules as $module => $moduleName)
            <div class="mb-3 col-12 col-md-4 col-lg-3">
                <label for="limit_{{ $module }}" class="form-label">{{ $moduleName }}</label>

                <input type="number"
                    name="limits[{{ $module }}]"
                    class="form-control @error('limits.' . $module) is-invalid @enderror"
                    id="limit_{{ $module }}"
                    value="{{ old('limits.' . $module, $tenantModuleLimits[$module]->limit ?? '') }}"
                    min="0"
                    placeholder="Ex.: 10">

                <small class="text-muted">{{ $module }}</small>

                @error('limits.' . $module)
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        @endforeach
    </div>

    {{-- ============================================================
    INFORMAÇÃO SOBRE HERANÇA
    ============================================================ --}}

    <div class="row mt-2 mb-3">
        <div class="col-12">
            <div class="alert alert-info mb-0">
                <div class="d-flex align-items-start">
                    <i class="mdi mdi-information-outline font-20 me-2"></i>

                    <div class="col">
                        <strong>Como funcionam os limites?</strong>

                        <p class="mb-0 mt-1" style="white-space: normal;">
                            O sistema utiliza primeiro o limite personalizado
                            do cliente.

                            Caso não exista, utiliza o limite definido pelo plano.

                            Se o plano também não possuir um limite para o módulo,
                            será utilizado o limite padrão definido no template.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

{{-- ============================================================
SCRIPT DOS COLORPICKERS
============================================================ --}}

<script>
    $(document).ready(function () {

        function destroyColorpickers() {
            try {
                $('[id^="colorpicker-"]').each(function () {
                    const $this = $(this);

                    if ($this.data('spectrum')) {
                        $this.spectrum('destroy');
                    }
                });

                $('.sp-container').remove();
                $('.sp-replacer').remove();

            } catch (e) {
                console.log('Erro ao destruir colorpickers:', e);
            }
        }

        function initColorpickers() {

            destroyColorpickers();

            const colorpickerConfigs = {

                'colorpicker-default': {
                    color: '#3498db',
                    showAlpha: false,
                    showPaletteOnly: false
                },

                'colorpicker-showalpha': {
                    color: '#2c3e50',
                    showAlpha: true,
                    showPaletteOnly: false
                },

                'colorpicker-showpaletteonly': {
                    color: '#f1c40f',
                    showAlpha: false,
                    showPaletteOnly: true,
                    palette: [
                        [
                            '#f1c40f',
                            '#e67e22',
                            '#1abc9c',
                            '#3498db'
                        ],
                        [
                            '#2ecc71',
                            '#e74c3c',
                            '#9b59b6',
                            '#34495e'
                        ],
                        [
                            '#95a5a6',
                            '#27ae60',
                            '#c0392b',
                            '#8e44ad'
                        ]
                    ]
                },

                'colorpicker-togglepaletteonly': {
                    color: '#333333',
                    showAlpha: false,
                    showPaletteOnly: false,
                    palette: [
                        [
                            '#ffffff',
                            '#f8f9fa',
                            '#e9ecef',
                            '#dee2e6'
                        ],
                        [
                            '#333333',
                            '#495057',
                            '#6c757d',
                            '#adb5bd'
                        ],
                        [
                            '#000000',
                            '#212529',
                            '#343a40',
                            '#000000'
                        ]
                    ]
                },

                'colorpicker-text-header': {
                    color: '#ffffff',
                    showAlpha: false,
                    showPaletteOnly: false
                },

                'colorpicker-bg-header': {
                    color: '#2c3e50',
                    showAlpha: false,
                    showPaletteOnly: false
                },

                'colorpicker-bg-scroll': {
                    color: '#f8f9fa',
                    showAlpha: false,
                    showPaletteOnly: false
                },

                'colorpicker-color-button1': {
                    color: '#ffffff',
                    showAlpha: false,
                    showPaletteOnly: false
                },

                'colorpicker-bg-button1': {
                    color: '#3498db',
                    showAlpha: false,
                    showPaletteOnly: false
                },

                'colorpicker-color-button2': {
                    color: '#ffffff',
                    showAlpha: false,
                    showPaletteOnly: false
                },

                'colorpicker-bg-button2': {
                    color: '#2ecc71',
                    showAlpha: false,
                    showPaletteOnly: false
                }
            };

            $('[id^="colorpicker-"]').each(function () {

                const $this = $(this);
                const id = $this.attr('id');
                const config = colorpickerConfigs[id] || {};
                const currentValue = $this.val();

                const defaultColor =
                    currentValue ||
                    config.color ||
                    '#3498db';

                const options = {
                    color: defaultColor,
                    showInput: true,
                    showInitial: true,
                    preferredFormat: 'hex',

                    change: function (color) {
                        if (color) {
                            $this.val(color.toHexString());
                        }
                    },

                    move: function (color) {
                        if (color) {
                            $this.val(color.toHexString());
                        }
                    }
                };

                if (config.showAlpha !== undefined) {
                    options.showAlpha = config.showAlpha;
                }

                if (config.showPaletteOnly !== undefined) {
                    options.showPaletteOnly = config.showPaletteOnly;
                }

                if (config.palette) {
                    options.palette = config.palette;
                }

                if (config.showPalette !== undefined) {
                    options.showPalette = config.showPalette;
                }

                $this.spectrum(options);
            });
        }

        setTimeout(initColorpickers, 100);

        $(document).on('shown.bs.modal', function () {
            setTimeout(initColorpickers, 200);
        });

        document.addEventListener('shown.bs.modal', function () {
            setTimeout(initColorpickers, 200);
        });

    });
    // mascara cnpj
    document.getElementById('cnpj').addEventListener('input', function (e) {
        let value = e.target.value.replace(/\D/g, '').slice(0, 14);

        value = value.replace(/^(\d{2})(\d)/, '$1.$2');
        value = value.replace(/^(\d{2})\.(\d{3})(\d)/, '$1.$2.$3');
        value = value.replace(/\.(\d{3})(\d)/, '.$1/$2');
        value = value.replace(/(\d{4})(\d)/, '$1-$2');

        e.target.value = value;
    });
</script>

