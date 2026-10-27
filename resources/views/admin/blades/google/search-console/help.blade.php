@extends('admin.core.admin')

@section('content')

<style>
    .help-scroll {
        overflow-x: hidden;
        overflow-y: auto;
        height: 635px;
    }

    .help-card {
        border: 0;
        box-shadow: 0 .125rem .25rem rgba(0, 0, 0, .075);
    }

    .help-section {
        scroll-margin-top: 20px;
    }

    .help-icon {
        width: 42px;
        height: 42px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        font-size: 20px;
        flex-shrink: 0;
    }

    .help-title {
        font-size: 15px;
        font-weight: 600;
    }

    .help-text {
        color: #6c757d;
        line-height: 1.7;
    }

    .help-list {
        color: #6c757d;
        line-height: 1.8;
    }

    .help-highlight {
        background: #f8f9fa;
        border-left: 3px solid #cbff4d;
        padding: 14px 16px;
        border-radius: 4px;
    }

    .help-term {
        font-weight: 600;
        color: #212529;
    }

    .help-table th {
        white-space: nowrap;
    }

    .help-table td,
    .help-table th {
        vertical-align: middle;
    }
</style>

<div class="help-scroll">

{{-- CABEÇALHO --}}
<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 my-3">

    <div>

        <h1 class="h4 mb-1 d-flex align-items-center gap-2">
            <i class="bi bi-google"></i>
            Como funciona o Google Search Console
        </h1>

        <p class="text-muted mb-0">
            Entenda como os dados apresentados pelo WHI WEB são coletados,
            organizados e apresentados no painel.
        </p>

    </div>

    <a
        href="{{ route('google.search-console.index') }}"
        class="btn btn-outline-secondary"
    >
        <i class="bi bi-arrow-left me-1"></i>
        Voltar
    </a>

</div>

{{-- RESUMO --}}
<div class="card help-card mb-4">

    <div class="card-body">

        <div class="d-flex gap-3">

            <div class="help-icon bg-primary-subtle text-primary">
                <i class="bi bi-info-circle"></i>
            </div>

            <div>

                <h5 class="mb-2">
                    Sobre esta área
                </h5>

                <p class="help-text mb-0">
                    O Google Search Console é uma ferramenta do Google que
                    apresenta informações sobre o desempenho de um site
                    nos resultados da pesquisa orgânica.
                </p>

                <p class="help-text mb-0 mt-2">
                    O WHI WEB utiliza esses dados para apresentar, dentro
                    do painel administrativo, uma visão simplificada do
                    desempenho de cada site.
                </p>

            </div>

        </div>

    </div>

</div>

{{-- ÍNDICE --}}
<div class="card help-card mb-4">

    <div class="card-body">

        <h5 class="mb-3">
            Nesta documentação
        </h5>

        <div class="row g-2">

            <div class="col-md-6">
                <a href="#metricas" class="text-decoration-none">
                    <i class="bi bi-bar-chart me-1"></i>
                    Métricas
                </a>
            </div>

            <div class="col-md-6">
                <a href="#periodos" class="text-decoration-none">
                    <i class="bi bi-calendar3 me-1"></i>
                    Períodos
                </a>
            </div>

            <div class="col-md-6">
                <a href="#desempenho" class="text-decoration-none">
                    <i class="bi bi-graph-up me-1"></i>
                    Gráfico de desempenho
                </a>
            </div>

            <div class="col-md-6">
                <a href="#detalhado" class="text-decoration-none">
                    <i class="bi bi-table me-1"></i>
                    Desempenho detalhado
                </a>
            </div>

            <div class="col-md-6">
                <a href="#tendencias" class="text-decoration-none">
                    <i class="bi bi-arrow-up-right me-1"></i>
                    Tendências
                </a>
            </div>

            <div class="col-md-6">
                <a href="#comparativo" class="text-decoration-none">
                    <i class="bi bi-bar-chart-line me-1"></i>
                    Comparativo de tráfego
                </a>
            </div>

            <div class="col-md-6">
                <a href="#sincronizacao" class="text-decoration-none">
                    <i class="bi bi-arrow-repeat me-1"></i>
                    Sincronização
                </a>
            </div>

            <div class="col-md-6">
                <a href="#diferencas" class="text-decoration-none">
                    <i class="bi bi-question-circle me-1"></i>
                    Diferenças em relação ao Google
                </a>
            </div>

        </div>

    </div>

</div>

{{-- MÉTRICAS --}}
<div
    id="metricas"
    class="card help-card mb-4 help-section"
>

    <div class="card-body">

        <div class="d-flex align-items-center gap-3 mb-3">

            <div class="help-icon bg-primary-subtle text-primary">
                <i class="bi bi-bar-chart"></i>
            </div>

            <div>
                <h5 class="mb-0">
                    Principais métricas
                </h5>

                <small class="text-muted">
                    Entenda os números apresentados no topo da página.
                </small>
            </div>

        </div>

        <div class="table-responsive">

            <table class="table table-hover help-table">

                <thead>

                    <tr>
                        <th>Métrica</th>
                        <th>O que significa?</th>
                    </tr>

                </thead>

                <tbody>

                    <tr>

                        <td>
                            <span class="help-term">
                                Cliques
                            </span>
                        </td>

                        <td>
                            Quantidade de vezes que usuários clicaram
                            em um resultado do site na pesquisa do Google.
                        </td>

                    </tr>

                    <tr>

                        <td>
                            <span class="help-term">
                                Impressões
                            </span>
                        </td>

                        <td>
                            Quantidade de vezes que uma página do site
                            apareceu nos resultados de pesquisa.
                        </td>

                    </tr>

                    <tr>

                        <td>
                            <span class="help-term">
                                CTR
                            </span>
                        </td>

                        <td>
                            Percentual de impressões que resultaram em
                            um clique. É calculado pela relação entre
                            cliques e impressões.
                        </td>

                    </tr>

                    <tr>

                        <td>
                            <span class="help-term">
                                Posição média
                            </span>
                        </td>

                        <td>
                            Média das posições em que os resultados
                            do site apareceram nas pesquisas.
                        </td>

                    </tr>

                </tbody>

            </table>

        </div>

    </div>

</div>

{{-- PERÍODOS --}}
<div
    id="periodos"
    class="card help-card mb-4 help-section"
>

    <div class="card-body">

        <div class="d-flex align-items-center gap-3 mb-3">

            <div class="help-icon bg-success-subtle text-success">
                <i class="bi bi-calendar3"></i>
            </div>

            <div>
                <h5 class="mb-0">
                    Períodos de análise
                </h5>

                <small class="text-muted">
                    Como funciona o filtro de período.
                </small>
            </div>

        </div>

        <p class="help-text">
            O painel permite analisar quatro períodos diferentes:
        </p>

        <ul class="help-list">

            <li>
                <strong>7 dias:</strong>
                últimos 7 dias disponíveis.
            </li>

            <li>
                <strong>28 dias:</strong>
                últimos 28 dias disponíveis.
            </li>

            <li>
                <strong>3 meses:</strong>
                últimos 90 dias disponíveis.
            </li>

            <li>
                <strong>6 meses:</strong>
                últimos 180 dias disponíveis.
            </li>

        </ul>

        <div class="help-highlight mt-3">

            <strong>Importante:</strong>

            <span class="text-muted">
                os dados são considerados até o último dia disponível
                no Search Console. Por isso, o dia atual normalmente
                não aparece imediatamente nos resultados.
            </span>

        </div>

        <p class="help-text mt-3 mb-0">
            Para facilitar a comparação, o sistema também utiliza um
            período anterior com a mesma duração.
        </p>

    </div>

</div>

{{-- DESEMPENHO --}}
<div
    id="desempenho"
    class="card help-card mb-4 help-section"
>

    <div class="card-body">

        <div class="d-flex align-items-center gap-3 mb-3">

            <div class="help-icon bg-info-subtle text-info">
                <i class="bi bi-graph-up"></i>
            </div>

            <div>

                <h5 class="mb-0">
                    Gráfico de desempenho
                </h5>

                <small class="text-muted">
                    Evolução diária das principais métricas.
                </small>

            </div>

        </div>

        <p class="help-text">
            O gráfico apresenta a evolução diária de cliques e impressões
            durante o período selecionado.
        </p>

        <p class="help-text mb-0">
            Isso permite visualizar oscilações ao longo dos dias,
            identificar períodos de maior movimentação e acompanhar
            a evolução do tráfego orgânico.
        </p>

    </div>

</div>

{{-- DESEMPENHO DETALHADO --}}
<div
    id="detalhado"
    class="card help-card mb-4 help-section"
>

    <div class="card-body">

        <div class="d-flex align-items-center gap-3 mb-3">

            <div class="help-icon bg-warning-subtle text-warning">
                <i class="bi bi-table"></i>
            </div>

            <div>

                <h5 class="mb-0">
                    Desempenho detalhado
                </h5>

                <small class="text-muted">
                    Consultas, páginas e dispositivos.
                </small>

            </div>

        </div>

        <p class="help-text">
            Esta seção detalha de onde o tráfego orgânico está vindo.
        </p>

        <div class="row g-3 mt-2">

            <div class="col-md-4">

                <div class="border rounded p-3 h-100">

                    <h6>
                        <i class="ri-search-line me-1"></i>
                        Consultas
                    </h6>

                    <p class="text-muted small mb-0">
                        Mostra os termos pesquisados no Google que
                        geraram impressões e cliques para o site.
                    </p>

                </div>

            </div>

            <div class="col-md-4">

                <div class="border rounded p-3 h-100">

                    <h6>
                        <i class="ri-pages-line me-1"></i>
                        Páginas
                    </h6>

                    <p class="text-muted small mb-0">
                        Mostra quais páginas do site receberam
                        tráfego proveniente da pesquisa orgânica.
                    </p>

                </div>

            </div>

            <div class="col-md-4">

                <div class="border rounded p-3 h-100">

                    <h6>
                        <i class="ri-smartphone-line me-1"></i>
                        Dispositivos
                    </h6>

                    <p class="text-muted small mb-0">
                        Apresenta o desempenho separado entre
                        computadores, celulares e tablets.
                    </p>

                </div>

            </div>

        </div>

    </div>

</div>

{{-- TENDÊNCIAS --}}
<div
    id="tendencias"
    class="card help-card mb-4 help-section"
>

    <div class="card-body">

        <div class="d-flex align-items-center gap-3 mb-3">

            <div class="help-icon bg-success-subtle text-success">
                <i class="bi bi-arrow-up-right"></i>
            </div>

            <div>

                <h5 class="mb-0">
                    Tendências de pesquisa
                </h5>

                <small class="text-muted">
                    Comparação de páginas e consultas.
                </small>

            </div>

        </div>

        <p class="help-text">
            A área de tendências compara o período atual com o período
            anterior de mesma duração.
        </p>

        <div class="row g-3 mt-2">

            <div class="col-md-4">

                <div class="border rounded p-3 h-100">

                    <h6>
                        Superior
                    </h6>

                    <p class="text-muted small mb-0">
                        Apresenta os itens com maior quantidade
                        de cliques no período atual.
                    </p>

                </div>

            </div>

            <div class="col-md-4">

                <div class="border rounded p-3 h-100">

                    <h6 class="text-success">
                        Em alta
                    </h6>

                    <p class="text-muted small mb-0">
                        Apresenta itens que tiveram aumento
                        de cliques em relação ao período anterior.
                    </p>

                </div>

            </div>

            <div class="col-md-4">

                <div class="border rounded p-3 h-100">

                    <h6 class="text-danger">
                        Em baixa
                    </h6>

                    <p class="text-muted small mb-0">
                        Apresenta itens que tiveram redução
                        de cliques em relação ao período anterior.
                    </p>

                </div>

            </div>

        </div>

    </div>

</div>

{{-- COMPARATIVO --}}
<div
    id="comparativo"
    class="card help-card mb-4 help-section"
>

    <div class="card-body">

        <div class="d-flex align-items-center gap-3 mb-3">

            <div class="help-icon bg-primary-subtle text-primary">
                <i class="bi bi-bar-chart-line"></i>
            </div>

            <div>

                <h5 class="mb-0">
                    Comparativo de tráfego
                </h5>

                <small class="text-muted">
                    Comparação do volume total de cliques.
                </small>

            </div>

        </div>

        <p class="help-text">
            O gráfico compara a quantidade total de cliques do período
            selecionado com o período anterior de mesma duração.
        </p>

        <div class="help-highlight">

            <strong>Exemplo:</strong>

            <span class="text-muted">
                se você selecionar 28 dias, o sistema compara os últimos
                28 dias disponíveis com os 28 dias imediatamente anteriores.
            </span>

        </div>

        <p class="help-text mt-3 mb-0">
            Dessa forma, é possível visualizar se o volume de acessos
            provenientes da pesquisa aumentou ou diminuiu entre os
            dois períodos.
        </p>

    </div>

</div>

{{-- SINCRONIZAÇÃO --}}
<div
    id="sincronizacao"
    class="card help-card mb-4 help-section"
>

    <div class="card-body">

        <div class="d-flex align-items-center gap-3 mb-3">

            <div class="help-icon bg-success-subtle text-success">
                <i class="bi bi-arrow-repeat"></i>
            </div>

            <div>

                <h5 class="mb-0">
                    Sincronização dos dados
                </h5>

                <small class="text-muted">
                    Como o botão "Sincronizar" funciona.
                </small>

            </div>

        </div>

        <p class="help-text">
            O botão <strong>Sincronizar</strong> atualiza os dados
            armazenados pelo WHI WEB a partir das informações disponíveis
            no Google Search Console.
        </p>

        <p class="help-text">
            Uma sincronização atualiza os períodos utilizados pelo painel:
        </p>

        <ul class="help-list">

            <li>7 dias</li>
            <li>28 dias</li>
            <li>90 dias</li>
            <li>180 dias</li>
        </ul>

        <div class="help-highlight mt-3">

            <strong>Recomendação:</strong>

            <span class="text-muted">
                utilize a sincronização quando quiser atualizar os dados
                apresentados no painel. Depois da atualização, basta
                consultar novamente o site e o período desejado.
            </span>

        </div>

    </div>

</div>

{{-- DIFERENÇAS --}}
<div
    id="diferencas"
    class="card help-card mb-4 help-section"
>

    <div class="card-body">

        <div class="d-flex align-items-center gap-3 mb-3">

            <div class="help-icon bg-secondary-subtle text-secondary">
                <i class="bi bi-question-circle"></i>
            </div>

            <div>

                <h5 class="mb-0">
                    Por que os números podem ser diferentes do Google?
                </h5>

                <small class="text-muted">
                    Entenda pequenas diferenças entre os painéis.
                </small>

            </div>

        </div>

        <p class="help-text">
            Os dados apresentados pelo WHI WEB são obtidos diretamente
            do Google Search Console. Ainda assim, pequenas diferenças
            podem aparecer quando os números são comparados manualmente
            com o painel do Google.
        </p>

        <p class="help-text">
            Isso pode acontecer devido aos períodos selecionados,
            filtros aplicados, momento da consulta, processamento dos
            dados e critérios utilizados pelo Google para disponibilizar
            determinadas informações.
        </p>

        <p class="help-text">
            O painel também considera o
            <strong>fuso horário de Brasília (America/Sao_Paulo)</strong>
            para organizar os períodos apresentados.
        </p>

        <div class="help-highlight mt-3">

            <strong>Importante:</strong>

            <span class="text-muted">
                pequenas diferenças não significam necessariamente
                que os dados estejam incorretos. Ao comparar informações,
                procure utilizar o mesmo período e os mesmos critérios
                de análise.
            </span>

        </div>

    </div>

</div>

{{-- BOA PRÁTICA --}}
<div class="card help-card mb-4">

    <div class="card-body">

        <div class="d-flex align-items-center gap-3">

            <div class="help-icon bg-primary-subtle text-primary">
                <i class="bi bi-lightbulb"></i>
            </div>

            <div>

                <h5 class="mb-1">
                    Como utilizar esta área
                </h5>

                <p class="help-text mb-0">
                    Selecione o site, escolha o período desejado e clique
                    em <strong>Consultar</strong>. Utilize as métricas
                    para acompanhar o cenário geral, o gráfico para observar
                    a evolução diária e as tabelas para identificar quais
                    consultas e páginas estão gerando tráfego.
                </p>

            </div>

        </div>

    </div>

</div>

{{-- VOLTAR --}}
<div class="text-end mb-4">

    <a
        href="{{ route('google.search-console.index') }}"
        class="btn btn-primary text-dark"
    >
        <i class="bi bi-arrow-left me-1"></i>
        Voltar para o Google Search Console
    </a>

</div>

</div>

@endsection
