{{-- ============================================================
SEO BÁSICO
============================================================ --}}

<div class="mb-4">

    <h4 class="mb-1">SEO básico</h4>

    <p class="text-muted">
        Informações utilizadas pelos mecanismos de busca para apresentar e identificar o seu site.
    </p>

</div>

<div class="mb-3">

    <label for="title" class="form-label">Título do site</label>

    <input
        type="text"
        name="title"
        class="form-control"
        id="title{{ isset($seoGoogle->id) ? $seoGoogle->id : '' }}"
        value="{{ old('title', $seoGoogle->title ?? '') }}"
        placeholder="Ex: Girollato - Distribuidora de Produtos Pet"
    >

    <small class="text-muted">
        Título principal exibido nos resultados de busca e na aba do navegador.
    </small>

</div>

<div class="mb-3">

    <label for="description" class="form-label">Descrição do site</label>

    <textarea
        name="description"
        class="form-control"
        id="description{{ isset($seoGoogle->id) ? $seoGoogle->id : '' }}"
        rows="4"
        placeholder="Descreva brevemente sua empresa e seus principais serviços."
    >{{ old('description', $seoGoogle->description ?? '') }}</textarea>

    <small class="text-muted">
        Descrição utilizada pelos mecanismos de busca para apresentar o seu site.
    </small>

</div>

<div class="mb-3">

    <label for="keywords" class="form-label">Palavras-chave</label>

    <textarea
        name="keywords"
        class="form-control"
        id="keywords{{ isset($seoGoogle->id) ? $seoGoogle->id : '' }}"
        rows="3"
        placeholder="Ex: pet shop, ração para cães, ração para gatos"
    >{{ old('keywords', $seoGoogle->keywords ?? '') }}</textarea>

    <small class="text-muted">
        Separe as palavras-chave por vírgulas.
    </small>

</div>


{{-- ============================================================
REDES SOCIAIS
============================================================ --}}

<hr class="my-4">

<div class="mb-4">

    <h4 class="mb-1">Redes sociais</h4>

    <p class="text-muted">
        Informações utilizadas quando o site é compartilhado em redes sociais e aplicativos de mensagens.
    </p>

</div>

<div class="mb-3">

    <label for="social_image" class="form-label">
        Imagem para compartilhamento
    </label>

    <input
        type="file"
        name="social_image"
        class="form-control"
        id="social_image{{ isset($seoGoogle->id) ? $seoGoogle->id : '' }}"
        accept="image/*"
    >

    @if (!empty($seoGoogle->social_image))

        <div class="mt-2">

            <img
                src="{{ asset('storage/' . $seoGoogle->social_image) }}"
                alt="Imagem atual para compartilhamento"
                style="max-width: 200px; max-height: 120px; object-fit: cover;"
                class="rounded border"
            >

        </div>

    @endif

    <small class="text-muted">
        Imagem exibida quando o site for compartilhado no WhatsApp, Facebook, X e outras redes.
    </small>

</div>


{{-- ============================================================
IDENTIDADE DA EMPRESA
============================================================ --}}

<hr class="my-4">

<div class="mb-4">

    <h4 class="mb-1">Identidade da empresa</h4>

    <p class="text-muted">
        Informações básicas sobre a empresa ou organização responsável pelo site.
    </p>

</div>

<div class="mb-3">

    <label for="organization_name" class="form-label">
        Nome da empresa
    </label>

    <input
        type="text"
        name="organization_name"
        class="form-control"
        id="organization_name{{ isset($seoGoogle->id) ? $seoGoogle->id : '' }}"
        value="{{ old('organization_name', $seoGoogle->organization_name ?? '') }}"
        placeholder="Ex: Girollato"
    >

</div>

<div class="mb-3">

    <label for="legal_name" class="form-label">
        Razão social
    </label>

    <input
        type="text"
        name="legal_name"
        class="form-control"
        id="legal_name{{ isset($seoGoogle->id) ? $seoGoogle->id : '' }}"
        value="{{ old('legal_name', $seoGoogle->legal_name ?? '') }}"
        placeholder="Razão social da empresa"
    >

</div>

<div class="mb-3">

    <label for="organization_url" class="form-label">
        Site da empresa
    </label>

    <input
        type="url"
        name="organization_url"
        class="form-control"
        id="organization_url{{ isset($seoGoogle->id) ? $seoGoogle->id : '' }}"
        value="{{ old('organization_url', $seoGoogle->organization_url ?? '') }}"
        placeholder="https://www.exemplo.com.br"
    >

</div>

<div class="mb-3">

    <label for="organization_logo" class="form-label">
        Logo da empresa
    </label>

    <input
        type="file"
        name="organization_logo"
        class="form-control"
        id="organization_logo{{ isset($seoGoogle->id) ? $seoGoogle->id : '' }}"
        accept="image/*"
    >

    @if (!empty($seoGoogle->organization_logo))

        <div class="mt-2">

            <img
                src="{{ asset('storage/' . $seoGoogle->organization_logo) }}"
                alt="Logo atual"
                style="max-width: 180px; max-height: 100px; object-fit: contain;"
                class="rounded border p-2"
            >

        </div>

    @endif

</div>

<div class="mb-3">

    <label for="organization_description" class="form-label">
        Sobre a empresa
    </label>

    <textarea
        name="organization_description"
        class="form-control"
        id="organization_description{{ isset($seoGoogle->id) ? $seoGoogle->id : '' }}"
        rows="4"
        placeholder="Descreva brevemente a empresa."
    >{{ old('organization_description', $seoGoogle->organization_description ?? '') }}</textarea>

</div>

<div class="mb-3">

    <label for="founding_date" class="form-label">
        Ano/data de fundação
    </label>

    <input
        type="date"
        name="founding_date"
        class="form-control"
        id="founding_date{{ isset($seoGoogle->id) ? $seoGoogle->id : '' }}"
        value="{{ old(
            'founding_date',
            isset($seoGoogle->founding_date)
                ? $seoGoogle->founding_date->format('Y-m-d')
                : ''
        ) }}"
    >

</div>


{{-- ============================================================
CONTATO
============================================================ --}}

<hr class="my-4">

<div class="mb-4">

    <h4 class="mb-1">Contato</h4>

    <p class="text-muted">
        Informações de contato que poderão ser utilizadas pelos mecanismos de busca.
    </p>

</div>

<div class="mb-3 col-lg-6">

    <label for="email" class="form-label">
        E-mail
    </label>

    <input
        type="email"
        name="email"
        class="form-control"
        id="email{{ isset($seoGoogle->id) ? $seoGoogle->id : '' }}"
        value="{{ old('email', $seoGoogle->email ?? '') }}"
        placeholder="contato@empresa.com.br"
    >

</div>

<div class="mb-3 col-lg-6">

    <label for="telephone" class="form-label">
        Telefone
    </label>

    <input
        type="text"
        name="telephone"
        class="form-control"
        id="telephone{{ isset($seoGoogle->id) ? $seoGoogle->id : '' }}"
        value="{{ old('telephone', $seoGoogle->telephone ?? '') }}"
        placeholder="+55 71 99999-9999"
    >

</div>


{{-- ============================================================
LOCALIZAÇÃO
============================================================ --}}

<hr class="my-4">

<div class="mb-4">

    <h4 class="mb-1">Localização</h4>

    <p class="text-muted">
        Endereço físico da empresa. Essas informações ajudam os mecanismos de busca a identificar onde sua empresa está localizada.
    </p>

</div>

<div class="mb-3 col-lg-12">

    <label for="street_address" class="form-label">
        Endereço
    </label>

    <input
        type="text"
        name="street_address"
        class="form-control"
        id="street_address{{ isset($seoGoogle->id) ? $seoGoogle->id : '' }}"
        value="{{ old('street_address', $seoGoogle->street_address ?? '') }}"
        placeholder="Rua, número e bairro"
    >

</div>

<div class="mb-3 col-lg-4">

    <label for="address_locality" class="form-label">
        Cidade
    </label>

    <input
        type="text"
        name="address_locality"
        class="form-control"
        id="address_locality{{ isset($seoGoogle->id) ? $seoGoogle->id : '' }}"
        value="{{ old('address_locality', $seoGoogle->address_locality ?? '') }}"
        placeholder="Ex: Lauro de Freitas"
    >

</div>

<div class="mb-3 col-lg-2">

    <label for="address_region" class="form-label">
        Estado
    </label>

    <input
        type="text"
        name="address_region"
        class="form-control"
        id="address_region{{ isset($seoGoogle->id) ? $seoGoogle->id : '' }}"
        value="{{ old('address_region', $seoGoogle->address_region ?? '') }}"
        placeholder="Ex: BA"
    >

</div>

<div class="mb-3 col-lg-3">

    <label for="postal_code" class="form-label">
        CEP
    </label>

    <input
        type="text"
        name="postal_code"
        class="form-control"
        id="postal_code{{ isset($seoGoogle->id) ? $seoGoogle->id : '' }}"
        value="{{ old('postal_code', $seoGoogle->postal_code ?? '') }}"
        placeholder="00000-000"
    >

</div>

<div class="mb-3 col-lg-3">

    <label for="address_country" class="form-label">
        País
    </label>

    <input
        type="text"
        name="address_country"
        class="form-control"
        id="address_country{{ isset($seoGoogle->id) ? $seoGoogle->id : '' }}"
        value="{{ old('address_country', $seoGoogle->address_country ?? 'BR') }}"
        placeholder="BR"
    >

</div>


{{-- ============================================================
ATENDIMENTO
============================================================ --}}

<hr class="my-4">

<div class="mb-4">

    <h4 class="mb-1">Atendimento</h4>

    <p class="text-muted">
        Informações sobre como sua empresa atende seus clientes.
    </p>

</div>

<div class="mb-3 col-lg-4">

    <label for="contact_type" class="form-label">
        Tipo de atendimento
    </label>

    <input
        type="text"
        name="contact_type"
        class="form-control"
        id="contact_type{{ isset($seoGoogle->id) ? $seoGoogle->id : '' }}"
        value="{{ old('contact_type', $seoGoogle->contact_type ?? '') }}"
        placeholder="Ex: Atendimento ao cliente"
    >

</div>

<div class="mb-3 col-lg-4">

    <label for="area_served" class="form-label">
        Área de atendimento
    </label>

    <input
        type="text"
        name="area_served"
        class="form-control"
        id="area_served{{ isset($seoGoogle->id) ? $seoGoogle->id : '' }}"
        value="{{ old('area_served', $seoGoogle->area_served ?? '') }}"
        placeholder="Ex: Bahia ou Brasil"
    >

</div>

<div class="mb-3 col-lg-4">

    <label for="available_languages" class="form-label">
        Idiomas de atendimento
    </label>

    <input
        type="text"
        name="available_languages"
        class="form-control"
        id="available_languages{{ isset($seoGoogle->id) ? $seoGoogle->id : '' }}"
        value="{{ old(
            'available_languages',
            isset($seoGoogle->available_languages)
                ? implode(', ', $seoGoogle->available_languages)
                : ''
        ) }}"
        placeholder="Ex: Português, Inglês"
    >

    <small class="text-muted">
        Separe os idiomas por vírgula.
    </small>

</div>


{{-- ============================================================
HORÁRIO DE FUNCIONAMENTO
============================================================ --}}

<hr class="my-4">

<div class="mb-4">

    <h4 class="mb-1">Horário de funcionamento</h4>

    <p class="text-muted">
        Informe os dias e horários em que sua empresa está aberta.
    </p>

</div>

<div class="mb-3">

    <label for="opening_hours" class="form-label">
        Horários
    </label>

    <textarea
        name="opening_hours"
        class="form-control"
        id="opening_hours{{ isset($seoGoogle->id) ? $seoGoogle->id : '' }}"
        rows="5"
        placeholder="Informe os horários de funcionamento"
    >{{ old(
        'opening_hours',
        isset($seoGoogle->opening_hours)
            ? json_encode(
                $seoGoogle->opening_hours,
                JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
            )
            : ''
    ) }}</textarea>

    <small class="text-muted">
        Configuração técnica utilizada para informar os horários aos mecanismos de busca.
    </small>

</div>


{{-- ============================================================
DADOS ESTRUTURADOS / SCHEMA.ORG
============================================================ --}}

<hr class="my-4">

<div class="mb-4">

    <h4 class="mb-1">Dados estruturados</h4>

    <p class="text-muted mb-2">
        Essas informações ajudam mecanismos de busca, como o Google, a entender melhor sua empresa e seus dados.
    </p>

    <div class="alert alert-info">

        <strong>Importante:</strong>

        os dados desta seção são utilizados automaticamente pelo sistema para gerar informações estruturadas no código do site.
        Você não precisa inserir códigos ou configurações técnicas.

    </div>

</div>

<div class="mb-3">

    <label for="slogan" class="form-label">
        Slogan
    </label>

    <input
        type="text"
        name="slogan"
        class="form-control"
        id="slogan{{ isset($seoGoogle->id) ? $seoGoogle->id : '' }}"
        value="{{ old('slogan', $seoGoogle->slogan ?? '') }}"
        placeholder="Ex: Qualidade e confiança para o seu pet"
    >

</div>

<div class="mb-3">

    <label for="organization_keywords" class="form-label">
        Termos relacionados à empresa
    </label>

    <textarea
        name="organization_keywords"
        class="form-control"
        id="organization_keywords{{ isset($seoGoogle->id) ? $seoGoogle->id : '' }}"
        rows="4"
        placeholder="Ex: distribuidora de rações, produtos pet, pet shop"
    >{{ old('organization_keywords', $seoGoogle->organization_keywords ?? '') }}</textarea>

    <small class="text-muted">
        Informe termos que descrevem os principais produtos, serviços ou atividades da empresa.
        Separe por vírgulas.
    </small>

</div>


{{-- ============================================================
FAVICON
============================================================ --}}

<hr class="my-4">

<div class="mb-4">

    <h4 class="mb-1">Ícone do site</h4>

    <p class="text-muted">
        Ícone exibido na aba do navegador e em alguns dispositivos quando o site é salvo ou acessado.
    </p>

</div>

<div class="mb-3">

    <label for="favicon" class="form-label">
        Favicon
    </label>

    <input
        type="file"
        name="favicon"
        class="form-control"
        id="favicon{{ isset($seoGoogle->id) ? $seoGoogle->id : '' }}"
        accept=".png,.ico,.jpg,.jpeg,.webp"
    >

    @if (!empty($seoGoogle->favicon))

        <div class="mt-2">

            <img
                src="{{ asset('storage/' . $seoGoogle->favicon) }}"
                alt="Favicon atual"
                style="width: 48px; height: 48px; object-fit: contain;"
                class="border rounded p-1"
            >

        </div>

    @endif

</div>


{{-- ============================================================
INTEGRAÇÕES E RASTREAMENTO
============================================================ --}}

<hr class="my-4">

<div class="mb-4">

    <h4 class="mb-1">Integrações e rastreamento</h4>

    <p class="text-muted">
        Configure as ferramentas utilizadas para monitoramento, análise e rastreamento do seu site.
    </p>

</div>


{{-- ============================================================
GOOGLE SEARCH CONSOLE
============================================================ --}}

<div class="mb-3">

    <label for="search_console" class="form-label">
        Google Search Console
    </label>

    <input
        type="text"
        name="search_console"
        class="form-control"
        id="search_console{{ isset($seoGoogle->id) ? $seoGoogle->id : '' }}"
        value="{{ old('search_console', $seoGoogle->search_console ?? '') }}"
        placeholder="Ex: abc123456789..."
    >

    <small class="text-muted">
        Código de verificação utilizado para validar o site no Google Search Console.
    </small>

</div>


{{-- ============================================================
GOOGLE TAG MANAGER
============================================================ --}}

<div class="mb-3">

    <label for="google_tag_manager" class="form-label">
        Google Tag Manager
    </label>

    <input
        type="text"
        name="google_tag_manager"
        class="form-control"
        id="google_tag_manager{{ isset($seoGoogle->id) ? $seoGoogle->id : '' }}"
        value="{{ old('google_tag_manager', $seoGoogle->google_tag_manager ?? '') }}"
        placeholder="Ex: GTM-XXXXXXX"
    >

    <small class="text-muted">
        ID do contêiner do Google Tag Manager utilizado para gerenciar tags e eventos do site.
    </small>

</div>


{{-- ============================================================
GOOGLE ADS
============================================================ --}}

<div class="mb-3">

    <label for="google_ads" class="form-label">
        Google Ads
    </label>

    <input
        type="text"
        name="google_ads"
        class="form-control"
        id="google_ads{{ isset($seoGoogle->id) ? $seoGoogle->id : '' }}"
        value="{{ old('google_ads', $seoGoogle->google_ads ?? '') }}"
        placeholder="Ex: AW-XXXXXXXXX"
    >

    <small class="text-muted">
        ID da conta de conversão do Google Ads. Esse identificador poderá ser utilizado para configurar conversões através do Google Tag Manager.
    </small>

</div>


{{-- ============================================================
META PIXEL
============================================================ --}}

<div class="mb-3">

    <label for="meta_pixel" class="form-label">
        Meta Pixel
    </label>

    <input
        type="text"
        name="meta_pixel"
        class="form-control"
        id="meta_pixel{{ isset($seoGoogle->id) ? $seoGoogle->id : '' }}"
        value="{{ old('meta_pixel', $seoGoogle->meta_pixel ?? '') }}"
        placeholder="Ex: 123456789012345"
    >

    <small class="text-muted">
        ID do Meta Pixel utilizado para acompanhar visitas, eventos e conversões no Facebook e Instagram.
    </small>

</div>