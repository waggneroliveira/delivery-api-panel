@php
    $adSlot = $adSlot ?? null;

    $uid = $uid ?? ($adSlot?->id ?? 'create');

    /*
    |--------------------------------------------------------------------------
    | Campos
    |--------------------------------------------------------------------------
    */

    $currentName = old(
        'name',
        $adSlot?->name ?? ''
    );

    $currentSlug = old(
        'slug',
        $adSlot?->slug ?? ''
    );

    $currentExhibition = old(
        'exhibition',
        $adSlot?->exhibition ?? 'horizontal'
    );

    $currentDescription = old(
        'description',
        $adSlot?->description ?? ''
    );

    $currentSorting = old(
        'sorting',
        $adSlot?->sorting ?? 0
    );

    $currentActive = old(
        'active',
        $adSlot?->active ?? true
    );

    /*
    |--------------------------------------------------------------------------
    | Tenants autorizados
    |--------------------------------------------------------------------------
    */

    $currentTenantIds = old(
        'tenant_ids',
        $adSlot
            ? $adSlot->tenants->pluck('id')->toArray()
            : []
    );

    $currentTenantIds = array_map(
        'intval',
        (array) $currentTenantIds
    );
@endphp

<div class="row">

    {{-- Nome --}}
    <div class="col-12 col-md-6 mb-3">
        <label
            for="name-{{ $uid }}"
            class="form-label"
        >
            Nome
            <span class="text-danger">*</span>
        </label>

        <input
            type="text"
            name="name"
            id="name-{{ $uid }}"
            class="form-control"
            value="{{ $currentName }}"
            placeholder="Ex.: Banner Principal"
            maxlength="255"
            required
        >

        <small class="text-muted">
            Nome utilizado para identificar este espaço de anúncio no painel.
        </small>
    </div>

    {{-- Slug --}}
    <div class="col-12 col-md-6 mb-3">
        <label
            for="slug-{{ $uid }}"
            class="form-label"
        >
            Slug
        </label>

        <input
            type="text"
            name="slug"
            id="slug-{{ $uid }}"
            class="form-control"
            value="{{ $currentSlug }}"
            placeholder="Ex.: banner-principal"
            maxlength="255"
        >

        <small class="text-muted">
            Identificador utilizado pelo sistema para localizar o espaço.
            Se deixar vazio, será gerado automaticamente pelo nome.
        </small>
    </div>

    {{-- Tipo de exibição --}}
    <div class="col-12 col-md-6 mb-3">
        <label
            for="exhibition-{{ $uid }}"
            class="form-label"
        >
            Tipo de exibição
            <span class="text-danger">*</span>
        </label>

        <select
            name="exhibition"
            id="exhibition-{{ $uid }}"
            class="form-select"
            required
        >
            <option
                value="horizontal"
                @selected($currentExhibition === 'horizontal')
            >
                Horizontal Desktop
            </option>

            <option
                value="mobile"
                @selected($currentExhibition === 'mobile')
            >
                Horizontal Mobile
            </option>

            <option
                value="vertical"
                @selected($currentExhibition === 'vertical')
            >
                Vertical
            </option>
        </select>

        <small class="text-muted">
            Define o formato do espaço de anúncio dentro do template.
        </small>
    </div>

    {{-- Ordem --}}
    <div class="col-12 col-md-6 mb-3">
        <label
            for="sorting-{{ $uid }}"
            class="form-label"
        >
            Ordem
        </label>

        <input
            type="number"
            name="sorting"
            id="sorting-{{ $uid }}"
            class="form-control"
            value="{{ $currentSorting }}"
            min="0"
            step="1"
        >

        <small class="text-muted">
            Define a ordem de exibição dos espaços de anúncio.
        </small>
    </div>

    {{-- Descrição --}}
    <div class="col-12 mb-3">
        <label
            for="description-{{ $uid }}"
            class="form-label"
        >
            Descrição
        </label>

        <textarea
            name="description"
            id="description-{{ $uid }}"
            class="form-control"
            rows="4"
            maxlength="1000"
            placeholder="Ex.: Espaço exibido no topo da página inicial."
        >{{ $currentDescription }}</textarea>

        <small class="text-muted">
            Descreva onde este espaço será utilizado no template.
        </small>
    </div>

    {{-- Tenants autorizados --}}
    <div class="col-12 mb-3">

        <label class="form-label">
            Clientes autorizados
        </label>

        <div class="border rounded p-3">

            @if($tenants->isNotEmpty())

                <div class="row">

                    @foreach($tenants as $tenant)

                        <div class="col-12 col-md-6 col-lg-4 mb-2">

                            <div class="form-check">

                                <input
                                    type="checkbox"
                                    name="tenant_ids[]"
                                    value="{{ $tenant->id }}"
                                    id="tenant-{{ $uid }}-{{ $tenant->id }}"
                                    class="form-check-input"
                                    @checked(in_array($tenant->id, $currentTenantIds))
                                >

                                <label
                                    class="form-check-label"
                                    for="tenant-{{ $uid }}-{{ $tenant->id }}"
                                >
                                    {{ $tenant->name }}
                                </label>

                            </div>

                        </div>

                    @endforeach

                </div>

            @else

                <div class="text-muted">
                    Nenhum cliente disponível para autorização.
                </div>

            @endif

        </div>

        <small class="text-muted">
            Selecione quais clientes poderão utilizar este espaço de anúncio.
            Somente os clientes selecionados poderão visualizar e vincular anúncios a este espaço.
        </small>

    </div>

    {{-- Ativo --}}
    <div class="col-12 mb-3">

        <div class="form-check">

            <input
                type="hidden"
                name="active"
                value="0"
            >

            <input
                name="active"
                value="1"
                type="checkbox"
                class="form-check-input"
                id="active-{{ $uid }}"
                @checked($currentActive)
            >

            <label
                class="form-check-label"
                for="active-{{ $uid }}"
            >
                {{ __('dashboard.active') }}?
            </label>

        </div>

    </div>

</div>

<script>
    (function () {
        const nameInput = document.getElementById('name-{{ $uid }}');
        const slugInput = document.getElementById('slug-{{ $uid }}');

        if (!nameInput || !slugInput) {
            return;
        }

        let slugManuallyChanged = slugInput.value !== '';

        slugInput.addEventListener('input', function () {
            slugManuallyChanged = this.value.trim() !== '';
        });

        nameInput.addEventListener('input', function () {
            if (slugManuallyChanged) {
                return;
            }

            slugInput.value = this.value
                .toLowerCase()
                .normalize('NFD')
                .replace(/[\u0300-\u036f]/g, '')
                .replace(/[^a-z0-9\s-]/g, '')
                .trim()
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-');
        });
    })();
</script>