@php
    use App\Models\Tenant;
    
    $announcement = $announcement ?? null;

    $uid = $uid ?? ($announcement?->id ?? 'create');

    $textareaId = $textareaId ?? 'text' . $uid;

    /*
    |--------------------------------------------------------------------------
    | Usuário
    |--------------------------------------------------------------------------
    */

    $user = Auth::user();

    /*
    |--------------------------------------------------------------------------
    | Permissões
    |--------------------------------------------------------------------------
    */

    // Super usuário
    $isSuper = $user?->hasRole('Super') ?? false;

    // Usuário que pode tornar outros usuários Master
    $isUsuarioMaster = $user?->can('usuario.tornar usuario master') ?? false;

    /*
    |--------------------------------------------------------------------------
    | Pode gerenciar anúncios de todos os clientes
    |--------------------------------------------------------------------------
    */

    $canManageAllAnnouncements = $isSuper || $isUsuarioMaster;

    /*
    |--------------------------------------------------------------------------
    | Pode cadastrar anúncios no Painel
    |--------------------------------------------------------------------------
    */

    $canManagePanelAnnouncements = $canManageAllAnnouncements;

    /*
    |--------------------------------------------------------------------------
    | Pode cadastrar anúncios
    |--------------------------------------------------------------------------
    |
    | Super/Master:
    | - Site
    | - Painel
    | - Site e Painel
    |
    | Usuário comum:
    | - Precisa visualizar + criar
    | - Somente Site
    | - Somente o próprio tenant
    |
    */

    $canCreateAnnouncement = $canManagePanelAnnouncements
        || (
            $user?->can('anuncio.visualizar')
            && $user?->can('anuncio.criar')
        );

    /*
    |--------------------------------------------------------------------------
    | Tenant atual
    |--------------------------------------------------------------------------
    */

    $currentTenant = null;

    if (!$canManageAllAnnouncements) {
        $currentTenant = Tenant::current();
    }

    /*
    |--------------------------------------------------------------------------
    | Público
    |--------------------------------------------------------------------------
    */

    $currentTarget = old(
        'target',
        $announcement?->target ?? 'all'
    );

    /*
    |--------------------------------------------------------------------------
    | Usuário comum
    |--------------------------------------------------------------------------
    |
    | Usuário comum nunca poderá utilizar "all".
    | O anúncio será sempre específico para o tenant atual.
    |
    */

    if (!$canManageAllAnnouncements) {
        $currentTarget = 'specific';
    }

    /*
    |--------------------------------------------------------------------------
    | Clientes selecionados
    |--------------------------------------------------------------------------
    */

    $selectedTenantIds = old('tenant_id');

    if ($selectedTenantIds === null) {
        $selectedTenantIds = $announcement
            ? $announcement->tenants->pluck('id')->toArray()
            : [];
    }

    /*
    |--------------------------------------------------------------------------
    | Usuário comum
    |--------------------------------------------------------------------------
    |
    | Independentemente do que estiver salvo no anúncio,
    | o formulário trabalha somente com o tenant atual.
    |
    */

    if (!$canManageAllAnnouncements && $currentTenant) {
        $selectedTenantIds = [
            $currentTenant->id,
        ];
    }

    $selectedTenantIds = array_map(
        'strval',
        (array) $selectedTenantIds
    );

    /*
    |--------------------------------------------------------------------------
    | Mapa de clientes selecionados
    |--------------------------------------------------------------------------
    */

    $announcementTenants = $announcement?->tenants ?? collect();

    $tenantsMap = collect($tenants ?? [])
        ->mapWithKeys(fn ($t) => [
            (string) $t->id => $t->name
        ])
        ->toArray();

    foreach ($announcementTenants as $t) {
        $key = (string) $t->id;

        if (!array_key_exists($key, $tenantsMap)) {
            $tenantsMap[$key] = $t->name;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Tipo
    |--------------------------------------------------------------------------
    */

    $currentType = old(
        'type',
        $announcement?->type ?? 'general'
    );

    /*
    |--------------------------------------------------------------------------
    | Local de exibição
    |--------------------------------------------------------------------------
    */

    $currentDisplayLocation = old(
        'display_location',
        $announcement?->display_location ?? 'web'
    );

    /*
    |--------------------------------------------------------------------------
    | Usuário comum só pode criar anúncio no Site
    |--------------------------------------------------------------------------
    */

    if (!$canManagePanelAnnouncements) {
        $currentDisplayLocation = 'web';
    }

    /*
    |--------------------------------------------------------------------------
    | Slots de anúncio selecionados
    |--------------------------------------------------------------------------
    */

    $selectedAdSlotIds = old('ad_slot_ids');

    if ($selectedAdSlotIds === null) {
        $selectedAdSlotIds = $announcement
            ? $announcement->adSlots->pluck('id')->toArray()
            : [];
    }

    $selectedAdSlotIds = array_map(
        'strval',
        (array) $selectedAdSlotIds
    );

    /*
    |--------------------------------------------------------------------------
    | Mapa dos slots
    |--------------------------------------------------------------------------
    */

    $adSlotsMap = collect($adSlots ?? [])
        ->mapWithKeys(fn ($slot) => [
            (string) $slot->id => [
                'name' => $slot->name,
                'exhibition' => $slot->exhibition,
            ]
        ])
        ->toArray();

    foreach (($announcement?->adSlots ?? collect()) as $slot) {
        $key = (string) $slot->id;

        if (!array_key_exists($key, $adSlotsMap)) {
            $adSlotsMap[$key] = [
                'name' => $slot->name,
                'exhibition' => $slot->exhibition,
            ];
        }
    }
@endphp

@if(!$canCreateAnnouncement)

    <div class="alert alert-danger">
        Você não possui permissão para cadastrar anúncios.
    </div>

@else

    <div class="row">

        {{-- Público do anúncio --}}
        <div class="mb-3 col-12 col-lg-6">

            <label
                for="target-{{ $uid }}"
                class="form-label"
            >
                Público do anúncio
                <span class="text-danger">*</span>
            </label>

            <select
                name="target"
                class="form-select"
                id="target-{{ $uid }}"
                required
            >

                @if($canManageAllAnnouncements)

                    <option
                        value="all"
                        @selected($currentTarget === 'all')
                    >
                        Todos os clientes
                    </option>

                    <option
                        value="specific"
                        @selected($currentTarget === 'specific')
                    >
                        Clientes específicos
                    </option>

                @else

                    <option
                        value="specific"
                        selected
                    >
                        Meu cliente
                    </option>

                @endif

            </select>

            <small class="text-muted">

                @if($canManageAllAnnouncements)

                    Defina se o anúncio será exibido para todos os clientes
                    ou apenas para clientes selecionados.

                @else

                    Este anúncio será exibido somente para o seu cliente.

                @endif

            </small>

        </div>


        {{-- Seleção de clientes --}}
        <div
            class="mb-3 col-12 col-lg-6"
            id="tenants-container-{{ $uid }}"
            style="{{ $currentTarget === 'specific' ? '' : 'display: none;' }}"
        >

            <label
                for="tenant-selector-{{ $uid }}"
                class="form-label"
            >
                Selecionar clientes
            </label>

            @if(!$canManageAllAnnouncements)

                {{-- Usuário comum --}}
                <div class="form-control bg-light">
                    {{ $currentTenant?->name ?? 'Cliente atual' }}
                </div>

                <small class="text-muted">
                    Este anúncio será associado somente ao seu cliente.
                </small>

            @else

                {{-- Super/Master --}}
                <select
                    id="tenant-selector-{{ $uid }}"
                    class="form-select"
                >
                    <option value="">
                        Selecione um cliente...
                    </option>

                    @foreach($tenants as $tenant)

                        <option
                            value="{{ $tenant->id }}"
                            data-name="{{ $tenant->name }}"
                            @disabled(in_array((string) $tenant->id, $selectedTenantIds, true))
                        >
                            {{ $tenant->name }}
                        </option>

                    @endforeach

                </select>

                <small class="text-muted">
                    Selecione os clientes que receberão este anúncio.
                </small>

            @endif


            <div id="selected-tenants-inputs-{{ $uid }}">

                @if(!$canManageAllAnnouncements && $currentTenant)

                    <input
                        type="hidden"
                        name="tenant_id[]"
                        value="{{ $currentTenant->id }}"
                    >

                @endif

            </div>


            @if($canManageAllAnnouncements)

                <div
                    id="selected-tenants-{{ $uid }}"
                    class="d-flex flex-wrap gap-2 mt-3"
                ></div>

            @else

                <div class="d-flex flex-wrap gap-2 mt-3">

                    <span class="selected-tenant-badge">
                        <span>
                            {{ $currentTenant?->name }}
                        </span>
                    </span>

                </div>

            @endif

        </div>


        {{-- Local de exibição --}}
        <div class="mb-3 col-md-6 col-12">

            <label
                for="display_location-{{ $uid }}"
                class="form-label"
            >
                Local de exibição
                <span class="text-danger">*</span>
            </label>

            <select
                name="display_location"
                class="form-select"
                id="display_location-{{ $uid }}"
                required
            >

                {{-- Todos podem criar no Site --}}
                <option
                    value="web"
                    @selected($currentDisplayLocation === 'web')
                >
                    Site
                </option>

                {{-- Somente Super/Master --}}
                @if($canManagePanelAnnouncements)

                    <option
                        value="panel"
                        @selected($currentDisplayLocation === 'panel')
                    >
                        Painel
                    </option>

                    <option
                        value="both"
                        @selected($currentDisplayLocation === 'both')
                    >
                        Site e Painel
                    </option>

                @endif

            </select>

            <small class="text-muted">

                @if($canManagePanelAnnouncements)

                    Defina onde o anúncio será exibido.

                @else

                    Este anúncio será exibido no site.

                @endif

            </small>

        </div>


        {{-- Tipo --}}
        <div
            class="mb-3 col-md-6 col-12"
            id="type-container-{{ $uid }}"
        >

            <label
                for="type-{{ $uid }}"
                class="form-label"
            >
                Tipo
                <span class="text-danger">*</span>
            </label>

            <select
                name="type"
                class="form-select"
                id="type-{{ $uid }}"
                required
            >

                <option
                    value="general"
                    @selected($currentType === 'general')
                >
                    Geral
                </option>

                <option
                    value="maintenance"
                    @selected($currentType === 'maintenance')
                >
                    Manutenção
                </option>

                <option
                    value="update"
                    @selected($currentType === 'update')
                >
                    Atualização
                </option>

                <option
                    value="promotion"
                    @selected($currentType === 'promotion')
                >
                    Promoção
                </option>

                <option
                    value="warning"
                    @selected($currentType === 'warning')
                >
                    Aviso
                </option>

            </select>

        </div>


        {{-- Espaços de anúncio --}}
        <div
            class="mb-3 col-12"
            id="ad-slots-container-{{ $uid }}"
        >

            <label
                for="ad-slot-selector-{{ $uid }}"
                class="form-label"
            >
                Espaços de anúncio
                <span class="text-danger">*</span>
            </label>

            <select
                id="ad-slot-selector-{{ $uid }}"
                class="form-select"
            >

                <option value="">
                    Selecione um espaço de anúncio...
                </option>

                @foreach($adSlots as $adSlot)

                    <option
                        value="{{ $adSlot->id }}"
                        data-name="{{ $adSlot->name }}"
                        data-exhibition="{{ $adSlot->exhibition }}"
                        @disabled(in_array((string) $adSlot->id, $selectedAdSlotIds, true))
                    >
                        {{ $adSlot->name }}

                        -

                        @if($adSlot->exhibition === 'horizontal')

                            Horizontal Desktop

                        @elseif($adSlot->exhibition === 'mobile')

                            Horizontal Mobile

                        @elseif($adSlot->exhibition === 'vertical')

                            Vertical

                        @endif

                    </option>

                @endforeach

            </select>

            <small class="text-muted">
                Selecione os espaços onde este anúncio poderá ser exibido.
            </small>

            <div id="selected-ad-slots-inputs-{{ $uid }}"></div>

            <div
                id="selected-ad-slots-{{ $uid }}"
                class="d-flex flex-wrap gap-2 mt-3"
            ></div>

        </div>


        {{-- Período de exibição --}}
        <div class="mb-3 col-md-6 col-12">

            <label
                for="starts_at-{{ $uid }}"
                class="form-label"
            >
                Início da exibição
            </label>

            <input
                type="datetime-local"
                name="starts_at"
                id="starts_at-{{ $uid }}"
                class="form-control"
                value="{{ old('starts_at', $announcement?->starts_at?->format('Y-m-d\TH:i') ?? '') }}"
            >

            <small class="text-muted">
                Deixe vazio para exibir imediatamente.
            </small>

        </div>


        <div class="mb-3 col-md-6 col-12">

            <label
                for="ends_at-{{ $uid }}"
                class="form-label"
            >
                Fim da exibição
            </label>

            <input
                type="datetime-local"
                name="ends_at"
                id="ends_at-{{ $uid }}"
                class="form-control"
                value="{{ old('ends_at', $announcement?->ends_at?->format('Y-m-d\TH:i') ?? '') }}"
            >

            <small class="text-muted">
                Deixe vazio para não definir uma data de término.
            </small>

        </div>


        {{-- Link --}}
        <div class="col-12 mb-3">

            <label
                for="link-{{ $uid }}"
                class="form-label"
            >
                Link
            </label>

            <input
                type="text"
                name="link"
                class="form-control"
                id="link-{{ $uid }}"
                value="{{ old('link', $announcement?->link ?? '') }}"
                placeholder="Link"
            >

        </div>


        {{-- Texto --}}
        <div class="col-12 mb-3">

            <label
                for="{{ $textareaId }}"
                class="form-label text-muted"
            >
                Texto
            </label>

            <textarea
                name="text"
                id="{{ $textareaId }}"
                placeholder="Texto"
                class="col-12"
                rows="10"
            >{!! old('text', $announcement?->text ?? '') !!}</textarea>

        </div>


        {{-- Imagem --}}
        <div class="col-12 col-lg-6 mb-3">

            <label
                for="path_image-{{ $uid }}"
                class="form-label"
            >
                Imagem
                <span class="text-danger">*</span>
            </label>

            <input
                type="file"
                name="path_image"
                id="path_image-{{ $uid }}"
                data-plugins="dropify"
                data-default-file="{{ $announcement?->path_image ? url('storage/' . $announcement->path_image) : '' }}"
            />

            <p class="text-muted text-center mt-2 mb-0">
                {{ __('dashboard.text_img_size') }}
                <b class="text-danger">2 MB</b>.
            </p>

        </div>


        {{-- Imagem Mobile --}}
        <div class="col-12 col-lg-6 mb-3">

            <label
                for="path_image_mobile-{{ $uid }}"
                class="form-label"
            >
                Imagem Mobile
                <span class="text-danger">*</span>
            </label>

            <input
                type="file"
                name="path_image_mobile"
                id="path_image_mobile-{{ $uid }}"
                data-plugins="dropify"
                data-default-file="{{ $announcement?->path_image_mobile ? url('storage/' . $announcement->path_image_mobile) : '' }}"
            />

            <p class="text-muted text-center mt-2 mb-0">
                {{ __('dashboard.text_img_size') }}
                <b class="text-danger">2 MB</b>.
            </p>

        </div>


        {{-- Ativo --}}
        <div class="col-12 mb-3">

            <div class="form-check">

                <input
                    name="active"
                    value="1"
                    type="checkbox"
                    class="form-check-input"
                    id="invalidCheck-{{ $uid }}"
                    @checked(old('active', $announcement?->active ?? false))
                >

                <label
                    class="form-check-label"
                    for="invalidCheck-{{ $uid }}"
                >
                    {{ __('dashboard.active') }}?
                </label>

            </div>

        </div>

    </div>

@endif


<style>
    .selected-tenant-badge,
    .selected-ad-slot-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 6px 10px;
        background: #f1f3f5;
        border: 1px solid #dee2e6;
        border-radius: 20px;
        font-size: 14px;
    }

    .selected-tenant-badge button,
    .selected-ad-slot-badge button {
        border: 0;
        background: transparent;
        padding: 0;
        margin: 0;
        color: #dc3545;
        cursor: pointer;
        line-height: 1;
    }

    .selected-tenant-badge button:hover,
    .selected-ad-slot-badge button:hover {
        color: #a71d2a;
    }

    .selected-ad-slot-badge small {
        color: #6c757d;
    }
</style>


<script>
    (function () {

        const uid = "{{ $uid }}";

        const canManageAllAnnouncements = @json($canManageAllAnnouncements);

        function initAnnouncementForm() {

            /*
            |--------------------------------------------------------------------------
            | Elementos
            |--------------------------------------------------------------------------
            */

            const target = document.getElementById(
                'target-' + uid
            );

            const tenantsContainer = document.getElementById(
                'tenants-container-' + uid
            );

            const tenantSelector = document.getElementById(
                'tenant-selector-' + uid
            );

            const selectedTenants = document.getElementById(
                'selected-tenants-' + uid
            );

            const selectedTenantsInputs = document.getElementById(
                'selected-tenants-inputs-' + uid
            );

            const displayLocation = document.getElementById(
                'display_location-' + uid
            );

            const typeContainer = document.getElementById(
                'type-container-' + uid
            );

            const type = document.getElementById(
                'type-' + uid
            );

            const adSlotSelector = document.getElementById(
                'ad-slot-selector-' + uid
            );

            const selectedAdSlots = document.getElementById(
                'selected-ad-slots-' + uid
            );

            const selectedAdSlotsInputs = document.getElementById(
                'selected-ad-slots-inputs-' + uid
            );

            if (
                !target ||
                !tenantsContainer ||
                !selectedTenantsInputs ||
                !displayLocation ||
                !typeContainer ||
                !type ||
                !adSlotSelector ||
                !selectedAdSlots ||
                !selectedAdSlotsInputs
            ) {
                return;
            }


            /*
            |--------------------------------------------------------------------------
            | Clientes
            |--------------------------------------------------------------------------
            */

            const tenantsMap = @json($tenantsMap);

            const selectedTenantIds = new Set(
                @json($selectedTenantIds)
            );


            /*
            |--------------------------------------------------------------------------
            | Renderiza clientes selecionados
            |--------------------------------------------------------------------------
            */

            function renderSelectedTenants() {

                if (!selectedTenants) {
                    return;
                }

                selectedTenants.innerHTML = '';

                selectedTenantsInputs.innerHTML = '';

                selectedTenantIds.forEach(function (tenantId) {

                    tenantId = String(tenantId);

                    const option = tenantSelector
                        ? tenantSelector.querySelector(
                            `option[value="${tenantId}"]`
                        )
                        : null;

                    const tenantName =
                        option?.dataset?.name ??
                        tenantsMap[tenantId] ??
                        null;

                    if (!tenantName) {
                        return;
                    }

                    const input = document.createElement('input');

                    input.type = 'hidden';
                    input.name = 'tenant_id[]';
                    input.value = tenantId;

                    selectedTenantsInputs.appendChild(input);


                    const badge = document.createElement('span');

                    badge.className = 'selected-tenant-badge';

                    badge.innerHTML = `
                        <span>${tenantName}</span>

                        <button
                            type="button"
                            title="Remover"
                            data-tenant-id="${tenantId}"
                        >
                            <i class="bi bi-x-lg"></i>
                        </button>
                    `;

                    selectedTenants.appendChild(badge);


                    if (option) {
                        option.disabled = true;
                    }

                });
            }


            /*
            |--------------------------------------------------------------------------
            | Seleção de clientes
            |--------------------------------------------------------------------------
            */

            if (tenantSelector && canManageAllAnnouncements) {

                tenantSelector.addEventListener(
                    'change',
                    function () {

                        const tenantId = this.value;

                        if (!tenantId) {
                            return;
                        }

                        selectedTenantIds.add(
                            String(tenantId)
                        );

                        renderSelectedTenants();

                        this.value = '';
                    }
                );

            }


            /*
            |--------------------------------------------------------------------------
            | Remover cliente
            |--------------------------------------------------------------------------
            */

            if (selectedTenants && canManageAllAnnouncements) {

                selectedTenants.addEventListener(
                    'click',
                    function (event) {

                        const button = event.target.closest(
                            '[data-tenant-id]'
                        );

                        if (!button) {
                            return;
                        }

                        const tenantId = String(
                            button.dataset.tenantId
                        );

                        selectedTenantIds.delete(
                            tenantId
                        );

                        const option = tenantSelector.querySelector(
                            `option[value="${tenantId}"]`
                        );

                        if (option) {
                            option.disabled = false;
                        }

                        renderSelectedTenants();
                    }
                );

            }


            /*
            |--------------------------------------------------------------------------
            | Público do anúncio
            |--------------------------------------------------------------------------
            */

            function toggleTenants() {

                if (!canManageAllAnnouncements) {

                    target.value = 'specific';

                    tenantsContainer.style.display = '';

                    return;
                }

                const show = target.value === 'specific';

                tenantsContainer.style.display =
                    show ? '' : 'none';
            }


            target.addEventListener(
                'change',
                function () {

                    if (!canManageAllAnnouncements) {

                        this.value = 'specific';

                        return;
                    }

                    toggleTenants();
                }
            );


            /*
            |--------------------------------------------------------------------------
            | Slots de anúncio
            |--------------------------------------------------------------------------
            */

            const selectedAdSlotIds = new Set(
                @json($selectedAdSlotIds)
            );

            const adSlotsMap = @json($adSlotsMap);


            function getExhibitionLabel(exhibition) {

                switch (exhibition) {

                    case 'horizontal':
                        return 'Horizontal Desktop';

                    case 'mobile':
                        return 'Horizontal Mobile';

                    case 'vertical':
                        return 'Vertical';

                    default:
                        return exhibition;
                }
            }


            function renderSelectedAdSlots() {

                selectedAdSlots.innerHTML = '';

                selectedAdSlotsInputs.innerHTML = '';

                selectedAdSlotIds.forEach(function (adSlotId) {

                    adSlotId = String(adSlotId);

                    const option = adSlotSelector.querySelector(
                        `option[value="${adSlotId}"]`
                    );

                    const slotData =
                        adSlotsMap[adSlotId];

                    const slotName =
                        option?.dataset?.name ??
                        slotData?.name ??
                        null;

                    const exhibition =
                        option?.dataset?.exhibition ??
                        slotData?.exhibition ??
                        null;

                    if (!slotName) {
                        return;
                    }

                    const input = document.createElement('input');

                    input.type = 'hidden';
                    input.name = 'ad_slot_ids[]';
                    input.value = adSlotId;

                    selectedAdSlotsInputs.appendChild(input);


                    const badge = document.createElement('span');

                    badge.className = 'selected-ad-slot-badge';

                    badge.innerHTML = `
                        <span>
                            ${slotName}

                            ${
                                exhibition
                                    ? `<small>(${getExhibitionLabel(exhibition)})</small>`
                                    : ''
                            }
                        </span>

                        <button
                            type="button"
                            title="Remover"
                            data-ad-slot-id="${adSlotId}"
                        >
                            <i class="bi bi-x-lg"></i>
                        </button>
                    `;

                    selectedAdSlots.appendChild(badge);


                    if (option) {
                        option.disabled = true;
                    }

                });
            }


            /*
            |--------------------------------------------------------------------------
            | Adicionar slot
            |--------------------------------------------------------------------------
            */

            adSlotSelector.addEventListener(
                'change',
                function () {

                    const adSlotId = this.value;

                    if (!adSlotId) {
                        return;
                    }

                    selectedAdSlotIds.add(
                        String(adSlotId)
                    );

                    renderSelectedAdSlots();

                    this.value = '';
                }
            );


            /*
            |--------------------------------------------------------------------------
            | Remover slot
            |--------------------------------------------------------------------------
            */

            selectedAdSlots.addEventListener(
                'click',
                function (event) {

                    const button = event.target.closest(
                        '[data-ad-slot-id]'
                    );

                    if (!button) {
                        return;
                    }

                    const adSlotId = String(
                        button.dataset.adSlotId
                    );

                    selectedAdSlotIds.delete(
                        adSlotId
                    );

                    const option = adSlotSelector.querySelector(
                        `option[value="${adSlotId}"]`
                    );

                    if (option) {
                        option.disabled = false;
                    }

                    renderSelectedAdSlots();
                }
            );


            /*
            |--------------------------------------------------------------------------
            | Local de exibição
            |--------------------------------------------------------------------------
            */

            displayLocation.addEventListener(
                'change',
                function () {

                    /*
                    |--------------------------------------------------------------------------
                    | Usuário comum
                    |--------------------------------------------------------------------------
                    |
                    | Mantém somente "web".
                    |
                    */

                    if (!canManageAllAnnouncements) {
                        this.value = 'web';
                    }

                }
            );


            /*
            |--------------------------------------------------------------------------
            | Inicialização
            |--------------------------------------------------------------------------
            */

            renderSelectedTenants();

            renderSelectedAdSlots();

            toggleTenants();


            /*
            |--------------------------------------------------------------------------
            | CKEditor
            |--------------------------------------------------------------------------
            */

            const textareaId = "{{ $textareaId }}";

            if (
                document.getElementById(textareaId) &&
                typeof CKEDITOR !== 'undefined'
            ) {

                if (CKEDITOR.instances[textareaId]) {
                    CKEDITOR.instances[textareaId].destroy(true);
                }

                CKEDITOR.replace(textareaId, {
                    toolbar: [
                        {
                            name: 'basicstyles',
                            items: [
                                'Bold',
                                'Italic',
                                'Underline'
                            ]
                        }
                    ],
                    height: 200
                });
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Inicialização
        |--------------------------------------------------------------------------
        */

        if (document.readyState === 'loading') {

            document.addEventListener(
                'DOMContentLoaded',
                initAnnouncementForm
            );

        } else {

            initAnnouncementForm();

        }

    })();
</script>