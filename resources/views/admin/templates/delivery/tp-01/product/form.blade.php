
@php
    $isEdit = isset($product);

    $categories = $categories ?? collect();
    $brands = $brands ?? collect();

    $options = old(
        'options',
        $isEdit ? $product->options->toArray() : []
    );

    $comboItems = old(
        'combo_items',
        $isEdit ? $product->comboItems->toArray() : []
    );

    $comboAddons = old(
        'combo_addons',
        $isEdit ? $product->comboAddons->toArray() : []
    );

    $productType = old(
        'product_type',
        $product->product_type ?? 'food'
    );

    $choicesFrom = function ($option) {
        if (isset($option['choices'])) {
            return is_string($option['choices'])
                ? json_decode($option['choices'], true) ?? []
                : $option['choices'];
        }

        return [];
    };
@endphp

<div class="card">
    <div class="card-body">

        {{-- Tipo de produto --}}
        <div class="mb-4">
            <label class="form-label fw-semibold">O que você deseja cadastrar?</label>

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="product-type-card w-100">
                        <input
                            type="radio"
                            name="product_type"
                            value="food"
                            class="product-type-input"
                            {{ $productType !== 'combo' ? 'checked' : '' }}
                        >

                        <span class="product-type-content">
                            <i class="mdi mdi-food-outline"></i>
                            <strong>Produto individual</strong>
                            <small>Um produto vendido individualmente.</small>
                        </span>
                    </label>
                </div>

                <div class="col-md-6">
                    <label class="product-type-card w-100">
                        <input
                            type="radio"
                            name="product_type"
                            value="combo"
                            class="product-type-input"
                            {{ $productType === 'combo' ? 'checked' : '' }}
                        >

                        <span class="product-type-content">
                            <i class="mdi mdi-food-variant"></i>
                            <strong>Combo</strong>
                            <small>Um conjunto de produtos vendido em uma oferta.</small>
                        </span>
                    </label>
                </div>
            </div>
        </div>

        <hr>

        {{-- Navegação das etapas --}}
        <ul class="nav nav-tabs mb-4" id="productTabs">
            <li class="nav-item">
                <button class="nav-link active" type="button" data-bs-target="#basicTab">
                    1. Básico
                </button>
            </li>

            <li class="nav-item">
                <button class="nav-link" type="button" data-bs-target="#priceTab">
                    2. Preço e estoque
                </button>
            </li>

            <li class="nav-item">
                <button class="nav-link" type="button" data-bs-target="#compositionTab">
                    3. Personalização
                </button>
            </li>

            <li class="nav-item">
                <button class="nav-link" type="button" data-bs-target="#imageTab">
                    4. Imagens
                </button>
            </li>
        </ul>

        <div class="tab-content">

            {{-- ETAPA 1 --}}
            <div class="tab-pane fade show active" id="basicTab">

                <h5 class="mb-3">Informações do produto</h5>

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nome do produto *</label>

                        <input
                            type="text"
                            name="title"
                            class="form-control"
                            value="{{ old('title', $product->title ?? '') }}"
                            placeholder="Ex: X-Burger Especial"
                            required
                        >
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Categoria *</label>

                        <select
                            name="product_category_id"
                            class="form-select"
                            required
                        >
                            <option value="">Selecione uma categoria</option>

                            @foreach ($categories as $category)
                                <option
                                    value="{{ $category->id }}"
                                    {{ old('product_category_id', $product->product_category_id ?? '') == $category->id ? 'selected' : '' }}
                                >
                                    {{ $category->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Marca</label>

                        <select name="brand_id" class="form-select">
                            <option value="">Selecione uma marca</option>

                            @foreach ($brands as $brand)
                                <option
                                    value="{{ $brand->id }}"
                                    {{ old('brand_id', $product->brand_id ?? '') == $brand->id ? 'selected' : '' }}
                                >
                                    {{ $brand->name ?? $brand->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tipo de cozinha</label>

                        <input
                            type="text"
                            name="cuisine_type"
                            class="form-control"
                            value="{{ old('cuisine_type', $product->cuisine_type ?? '') }}"
                            placeholder="Ex: Hambúrguer, japonesa, italiana"
                        >
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label">Descrição curta</label>

                        <textarea
                            name="description"
                            class="form-control"
                            rows="3"
                            placeholder="Descreva brevemente o produto"
                        >{{ old('description', $product->description ?? '') }}</textarea>
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label">Descrição completa</label>

                        <textarea
                            name="text"
                            class="form-control"
                            rows="5"
                        >{{ old('text', $product->text ?? '') }}</textarea>
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label">Tags</label>

                        <input
                            type="text"
                            id="tagsInput"
                            class="form-control"
                            placeholder="Ex: artesanal, promoção, lançamento"
                        >

                        <div id="tagsContainer" class="d-flex flex-wrap gap-2 mt-2"></div>

                        <input
                            type="hidden"
                            name="tags"
                            id="tagsValue"
                            value="{{ old('tags', isset($product->tags) ? json_encode($product->tags) : '[]') }}"
                        >
                    </div>

                </div>

                <div class="d-flex justify-content-end">
                    <button type="button" class="btn btn-primary next-tab">
                        Próxima etapa
                        <i class="mdi mdi-arrow-right"></i>
                    </button>
                </div>
            </div>

            {{-- ETAPA 2 --}}
            <div class="tab-pane fade" id="priceTab">

                <h5 class="mb-3">Preço e estoque</h5>

                <div class="row">

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Preço de venda *</label>

                        <div class="input-group">
                            <span class="input-group-text">R$</span>

                            <input
                                type="text"
                                name="price"
                                class="form-control money-mask"
                                value="{{ old('price', $product->price ?? '') }}"
                                placeholder="0,00"
                                required
                            >
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Preço anterior</label>

                        <div class="input-group">
                            <span class="input-group-text">R$</span>

                            <input
                                type="text"
                                name="old_price"
                                class="form-control money-mask"
                                value="{{ old('old_price', $product->old_price ?? '') }}"
                                placeholder="0,00"
                            >
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Cashback (%)</label>

                        <input
                            type="number"
                            name="cashback"
                            class="form-control"
                            min="0"
                            step="0.01"
                            value="{{ old('cashback', $product->cashback ?? 0) }}"
                        >
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Estoque</label>

                        <input
                            type="number"
                            name="stock[quantity]"
                            class="form-control"
                            min="0"
                            value="{{ old('stock.quantity', data_get($product->stock ?? [], 'quantity', '')) }}"
                            placeholder="Quantidade disponível"
                        >
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Controle de estoque</label>

                        <select name="stock[control]" class="form-select">
                            <option value="0">Não controlar</option>
                            <option
                                value="1"
                                {{ old('stock.control', data_get($product->stock ?? [], 'control', 0)) == 1 ? 'selected' : '' }}
                            >
                                Controlar estoque
                            </option>
                        </select>
                    </div>

                    <div class="col-12">
                        <div class="form-check form-switch">
                            <input
                                type="checkbox"
                                name="featured"
                                value="1"
                                class="form-check-input"
                                id="featured"
                                {{ old('featured', $product->featured ?? false) ? 'checked' : '' }}
                            >

                            <label class="form-check-label" for="featured">
                                Destacar este produto
                            </label>
                        </div>
                    </div>

                </div>

                <div class="d-flex justify-content-between mt-4">
                    <button type="button" class="btn btn-light previous-tab">
                        Voltar
                    </button>

                    <button type="button" class="btn btn-primary next-tab">
                        Próxima etapa
                        <i class="mdi mdi-arrow-right"></i>
                    </button>
                </div>
            </div>

            {{-- ETAPA 3 --}}
            <div class="tab-pane fade" id="compositionTab">

                {{-- Produto individual --}}
                <div id="normalProductOptions">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h5 class="mb-1">Opções de personalização</h5>
                            <small class="text-muted">
                                Exemplo: escolha o tamanho, o sabor ou os acompanhamentos.
                            </small>
                        </div>

                        <button type="button" class="btn btn-outline-primary" id="addOption">
                            <i class="mdi mdi-plus"></i>
                            Adicionar opção
                        </button>
                    </div>

                    <div id="optionsContainer">

                        @foreach ($options as $index => $option)
                            <div class="card border mb-3 option-card">
                                <div class="card-body">

                                    <div class="row">
                                        <div class="col-md-5 mb-3">
                                            <label class="form-label">Título da opção</label>

                                            <input
                                                type="text"
                                                name="options[{{ $index }}][title]"
                                                class="form-control"
                                                value="{{ $option['title'] ?? '' }}"
                                                required
                                            >
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Tipo</label>

                                            <select
                                                name="options[{{ $index }}][type]"
                                                class="form-select"
                                            >
                                                <option value="single" {{ ($option['type'] ?? '') === 'single' ? 'selected' : '' }}>
                                                    Escolha única
                                                </option>

                                                <option value="multiple" {{ ($option['type'] ?? '') === 'multiple' ? 'selected' : '' }}>
                                                    Múltipla escolha
                                                </option>
                                            </select>
                                        </div>

                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">Máximo de escolhas</label>

                                            <input
                                                type="number"
                                                name="options[{{ $index }}][max_selections]"
                                                class="form-control"
                                                min="1"
                                                value="{{ $option['max_selections'] ?? 1 }}"
                                            >
                                        </div>

                                        <div class="col-12">
                                            <label class="form-label">Escolhas disponíveis</label>

                                            <textarea
                                                name="options[{{ $index }}][choices]"
                                                class="form-control choices-json"
                                                rows="4"
                                                placeholder='[{"id":"1","name":"Grande","price":5}]'
                                            >{{ is_array($option['choices'] ?? null) ? json_encode($option['choices'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) : ($option['choices'] ?? '[]') }}</textarea>

                                            <small class="text-muted">
                                                Informe as escolhas em JSON. Cada escolha pode ter name, price, default, description, maxQuantity, category e isRecommended.
                                            </small>
                                        </div>

                                        <div class="col-12 mt-3">
                                            <div class="form-check">
                                                <input
                                                    type="checkbox"
                                                    name="options[{{ $index }}][required]"
                                                    value="1"
                                                    class="form-check-input"
                                                    {{ !empty($option['required']) ? 'checked' : '' }}
                                                >

                                                <label class="form-check-label">
                                                    Esta opção é obrigatória
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <button type="button" class="btn btn-sm btn-outline-danger remove-card mt-3">
                                        Remover opção
                                    </button>

                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>

                {{-- Combo --}}
                <div id="comboComposition" style="display:none">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h5 class="mb-1">Itens do combo</h5>
                            <small class="text-muted">
                                Cadastre os produtos que fazem parte deste combo.
                            </small>
                        </div>

                        <button type="button" class="btn btn-outline-primary" id="addComboItem">
                            <i class="mdi mdi-plus"></i>
                            Adicionar item
                        </button>
                    </div>

                    <div id="comboItemsContainer">

                        @foreach ($comboItems as $index => $item)
                            <div class="card border mb-3 combo-item-card">
                                <div class="card-body">

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Nome do item</label>

                                            <input
                                                type="text"
                                                name="combo_items[{{ $index }}][name]"
                                                class="form-control"
                                                value="{{ $item['name'] ?? '' }}"
                                                required
                                            >
                                        </div>

                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">Quantidade</label>

                                            <input
                                                type="number"
                                                name="combo_items[{{ $index }}][quantity]"
                                                class="form-control"
                                                min="1"
                                                value="{{ $item['quantity'] ?? 1 }}"
                                            >
                                        </div>

                                        <div class="col-md-3 mb-3 d-flex align-items-end">
                                            <div class="form-check mb-2">
                                                <input
                                                    type="checkbox"
                                                    name="combo_items[{{ $index }}][required]"
                                                    value="1"
                                                    class="form-check-input"
                                                    {{ !empty($item['required']) ? 'checked' : '' }}
                                                >

                                                <label class="form-check-label">
                                                    Obrigatório
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <button type="button" class="btn btn-sm btn-outline-danger remove-card">
                                        Remover item
                                    </button>

                                </div>
                            </div>
                        @endforeach

                    </div>

                    <hr>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h5 class="mb-1">Adicionais do combo</h5>
                            <small class="text-muted">
                                Produtos extras que o cliente pode adicionar ao combo.
                            </small>
                        </div>

                        <button type="button" class="btn btn-outline-primary" id="addComboAddon">
                            <i class="mdi mdi-plus"></i>
                            Adicionar adicional
                        </button>
                    </div>

                    <div id="comboAddonsContainer">

                        @foreach ($comboAddons as $index => $addon)
                            <div class="card border mb-3 combo-addon-card">
                                <div class="card-body">

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Nome do adicional</label>

                                            <input
                                                type="text"
                                                name="combo_addons[{{ $index }}][name]"
                                                class="form-control"
                                                value="{{ $addon['name'] ?? '' }}"
                                                required
                                            >
                                        </div>

                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">Preço adicional</label>

                                            <input
                                                type="text"
                                                name="combo_addons[{{ $index }}][price]"
                                                class="form-control money-mask"
                                                value="{{ $addon['price'] ?? '' }}"
                                                placeholder="0,00"
                                            >
                                        </div>

                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">Quantidade máxima</label>

                                            <input
                                                type="number"
                                                name="combo_addons[{{ $index }}][max_quantity]"
                                                class="form-control"
                                                min="1"
                                                value="{{ $addon['max_quantity'] ?? 1 }}"
                                            >
                                        </div>
                                    </div>

                                    <button type="button" class="btn btn-sm btn-outline-danger remove-card">
                                        Remover adicional
                                    </button>

                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <button type="button" class="btn btn-light previous-tab">
                        Voltar
                    </button>

                    <button type="button" class="btn btn-primary next-tab">
                        Próxima etapa
                        <i class="mdi mdi-arrow-right"></i>
                    </button>
                </div>
            </div>

            {{-- ETAPA 4 --}}
            <div class="tab-pane fade" id="imageTab">

                <h5 class="mb-3">Imagem e publicação</h5>

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Imagem principal</label>

                        @if ($isEdit && $product->path_image)
                            <div class="mb-2">
                                <img
                                    src="{{ asset('storage/' . $product->path_image) }}"
                                    alt="Imagem atual"
                                    style="max-width:180px;max-height:160px;object-fit:cover"
                                    class="rounded"
                                >
                            </div>
                        @endif

                        <input
                            type="file"
                            name="path_image"
                            class="form-control"
                            accept="image/jpeg,image/png,image/webp"
                        >

                        <small class="text-muted">
                            JPG, PNG ou WEBP. A imagem será utilizada na apresentação do produto.
                        </small>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Arquivo complementar</label>

                        <input
                            type="file"
                            name="path_file"
                            class="form-control"
                        >

                        @if ($isEdit && $product->path_file)
                            <small class="text-muted">
                                Arquivo atual: {{ basename($product->path_file) }}
                            </small>
                        @endif
                    </div>

                    <div class="col-12 mt-3">
                        <div class="form-check form-switch">
                            <input
                                type="checkbox"
                                name="active"
                                value="1"
                                class="form-check-input"
                                id="active"
                                {{ old('active', $product->active ?? true) ? 'checked' : '' }}
                            >

                            <label class="form-check-label" for="active">
                                Produto ativo e disponível para venda
                            </label>
                        </div>
                    </div>

                </div>

                <div class="d-flex justify-content-between mt-4">
                    <button type="button" class="btn btn-light previous-tab">
                        Voltar
                    </button>

                    <button type="submit" class="btn btn-success">
                        <i class="mdi mdi-check me-1"></i>
                        {{ $isEdit ? 'Salvar produto' : 'Finalizar cadastro' }}
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    .product-type-card {
        cursor: pointer;
        display: block;
    }

    .product-type-input {
        position: absolute;
        opacity: 0;
    }

    .product-type-content {
        display: flex;
        flex-direction: column;
        gap: 5px;
        padding: 20px;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        transition: .2s;
    }

    .product-type-content i {
        font-size: 28px;
    }

    .product-type-content small {
        color: #6c757d;
    }

    .product-type-input:checked + .product-type-content {
        border: 2px solid #0d6efd;
        background: #f0f6ff;
    }

    .product-type-input:focus + .product-type-content {
        outline: 2px solid #0d6efd;
    }

    .nav-tabs .nav-link {
        color: #495057;
    }

    .nav-tabs .nav-link.active {
        font-weight: 600;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const tabs = Array.from(document.querySelectorAll('#productTabs .nav-link'));

    let currentTab = 0;

    function showTab(index) {
        if (index < 0 || index >= tabs.length) return;

        currentTab = index;

        tabs.forEach((tab, i) => {
            const pane = document.querySelector(tab.dataset.bsTarget);

            tab.classList.toggle('active', i === index);
            pane.classList.toggle('show', i === index);
            pane.classList.toggle('active', i === index);
        });
    }

    tabs.forEach((tab, index) => {
        tab.addEventListener('click', () => showTab(index));
    });

    document.querySelectorAll('.next-tab').forEach(button => {
        button.addEventListener('click', () => showTab(currentTab + 1));
    });

    document.querySelectorAll('.previous-tab').forEach(button => {
        button.addEventListener('click', () => showTab(currentTab - 1));
    });

    // Alternância entre produto e combo
    function toggleProductType() {
        const type = document.querySelector('[name="product_type"]:checked')?.value;

        const isCombo = type === 'combo';

        document.getElementById('normalProductOptions').style.display =
            isCombo ? 'none' : 'block';

        document.getElementById('comboComposition').style.display =
            isCombo ? 'block' : 'none';
    }

    document.querySelectorAll('[name="product_type"]').forEach(input => {
        input.addEventListener('change', toggleProductType);
    });

    toggleProductType();

    // Geradores de índices
    let optionIndex = {{ count($options) }};
    let comboItemIndex = {{ count($comboItems) }};
    let addonIndex = {{ count($comboAddons) }};

    // Adicionar opção
    document.getElementById('addOption').addEventListener('click', function () {

        const index = optionIndex++;

        const html = `
            <div class="card border mb-3 option-card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-5 mb-3">
                            <label class="form-label">Título da opção</label>
                            <input type="text" name="options[${index}][title]" class="form-control" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Tipo</label>
                            <select name="options[${index}][type]" class="form-select">
                                <option value="single">Escolha única</option>
                                <option value="multiple">Múltipla escolha</option>
                            </select>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">Máximo de escolhas</label>
                            <input type="number" name="options[${index}][max_selections]" class="form-control" min="1" value="1">
                        </div>

                        <div class="col-12">
                            <label class="form-label">Escolhas em JSON</label>
                            <textarea name="options[${index}][choices]" class="form-control choices-json" rows="4">[]</textarea>
                        </div>

                        <div class="col-12 mt-3">
                            <div class="form-check">
                                <input type="checkbox" name="options[${index}][required]" value="1" class="form-check-input">
                                <label class="form-check-label">Esta opção é obrigatória</label>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="btn btn-sm btn-outline-danger remove-card mt-3">
                        Remover opção
                    </button>
                </div>
            </div>
        `;

        document.getElementById('optionsContainer').insertAdjacentHTML('beforeend', html);
    });

    // Adicionar item do combo
    document.getElementById('addComboItem').addEventListener('click', function () {

        const index = comboItemIndex++;

        const html = `
            <div class="card border mb-3 combo-item-card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nome do item</label>
                            <input type="text" name="combo_items[${index}][name]" class="form-control" required>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">Quantidade</label>
                            <input type="number" name="combo_items[${index}][quantity]" class="form-control" min="1" value="1">
                        </div>

                        <div class="col-md-3 d-flex align-items-end mb-3">
                            <div class="form-check mb-2">
                                <input type="checkbox" name="combo_items[${index}][required]" value="1" class="form-check-input">
                                <label class="form-check-label">Obrigatório</label>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="btn btn-sm btn-outline-danger remove-card">
                        Remover item
                    </button>
                </div>
            </div>
        `;

        document.getElementById('comboItemsContainer').insertAdjacentHTML('beforeend', html);
    });

    // Adicionar adicional
    document.getElementById('addComboAddon').addEventListener('click', function () {

        const index = addonIndex++;

        const html = `
            <div class="card border mb-3 combo-addon-card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nome do adicional</label>
                            <input type="text" name="combo_addons[${index}][name]" class="form-control" required>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">Preço adicional</label>
                            <input type="text" name="combo_addons[${index}][price]" class="form-control money-mask" placeholder="0,00">
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">Quantidade máxima</label>
                            <input type="number" name="combo_addons[${index}][max_quantity]" class="form-control" min="1" value="1">
                        </div>
                    </div>

                    <button type="button" class="btn btn-sm btn-outline-danger remove-card">
                        Remover adicional
                    </button>
                </div>
            </div>
        `;

        document.getElementById('comboAddonsContainer').insertAdjacentHTML('beforeend', html);
    });

    // Remoção dinâmica
    document.addEventListener('click', function (event) {
        const button = event.target.closest('.remove-card');

        if (button) {
            button.closest('.card').remove();
        }
    });

    // Tags
    const tagsInput = document.getElementById('tagsInput');
    const tagsContainer = document.getElementById('tagsContainer');
    const tagsValue = document.getElementById('tagsValue');

    let tags = [];

    try {
        const existingTags = JSON.parse(tagsValue.value || '[]');
        tags = Array.isArray(existingTags) ? existingTags : [];
    } catch (e) {
        tags = [];
    }

    function renderTags() {
        tagsContainer.innerHTML = '';

        tags.forEach((tag, index) => {
            const element = document.createElement('span');

            element.className = 'badge bg-primary p-2';
            element.textContent = tag + ' ×';
            element.style.cursor = 'pointer';

            element.addEventListener('click', () => {
                tags.splice(index, 1);
                renderTags();
            });

            tagsContainer.appendChild(element);
        });

        tagsValue.value = JSON.stringify(tags);
    }

    tagsInput.addEventListener('keydown', function (event) {
        if (event.key !== 'Enter' && event.key !== ',') return;

        event.preventDefault();

        const tag = tagsInput.value.trim();

        if (tag && !tags.includes(tag)) {
            tags.push(tag);
        }

        tagsInput.value = '';
        renderTags();
    });

    renderTags();

    // Validação dos campos JSON antes do envio
    document.getElementById('productForm').addEventListener('submit', function (event) {

        const visibleComposition = document.querySelector('[name="product_type"]:checked')?.value;

        if (visibleComposition !== 'combo') {
            return;
        }

        // A composição de combo é validada no backend também.
    });

});
</script>
