@if (!empty($standings))
    <!-- Tabela do Brasileirão Widget Start -->
    <div class="standings-aside-widget mb-0 overflow-hidden">
        <div class="standings-card p-4">

            {{-- Cabeçalho do Widget --}}
            <div class="standings-header pb-3 mb-3 border-bottom d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <div class="standings-icon-badge">
                        <i class="bi bi-trophy-fill"></i>
                    </div>
                    <h4 class="m-0 poppins-bold font-18 title-aside">Brasileirão</h4>
                </div>
                <span class="badge bg-light text-dark border poppins-medium font-11">Série A</span>
            </div>

            {{-- Tabela Otimizada com Container de Scroll --}}
            <div class="table-responsive standings-table-wrapper">
                <table class="table table-borderless table-hover align-middle mb-0">
                    <thead>
                        <tr class="standings-thead-row">
                            <th scope="col" class="text-center ps-2">#</th>
                            <th scope="col">Time</th>
                            <th scope="col" class="text-center fw-bold">P</th>
                            <th scope="col" class="text-center">J</th>
                            <th scope="col" class="text-center">V</th>
                            <th scope="col" class="text-center">E</th>
                            <th scope="col" class="text-center">D</th>
                            <th scope="col" class="text-center pe-2">SG</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($standings as $team)
                            @php
                                $pos = $team['position'] ?? 0;
                                // Destaques visuais conforme zonas tradicionais do Brasileirão
                                $zoneClass = '';
                                if ($pos >= 1 && $pos <= 4) {
                                    $zoneClass = 'zone-libertadores'; // G4 - Libertadores Direta
                                } elseif ($pos >= 5 && $pos <= 6) {
                                    $zoneClass = 'zone-pre-libertadores'; // G6 - Pré-Libertadores
                                } elseif ($pos >= 7 && $pos <= 12) {
                                    $zoneClass = 'zone-sulamericana'; // Sul-Americana
                                } elseif ($pos >= 17) {
                                    $zoneClass = 'zone-rebaixamento'; // Z4
                                }
                            @endphp
                            <tr class="standings-row {{ $zoneClass }}">
                                {{-- Posição --}}
                                <td class="text-center fw-semibold font-12 pos-col ps-2">
                                    {{ $pos ?: '-' }}
                                </td>

                                {{-- Time e Escudo --}}
                                <td class="py-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <img src="{{ $team['team']['crest'] ?? '' }}" 
                                             alt="{{ $team['team']['shortName'] ?? $team['team']['name'] }}" 
                                             class="team-crest-sm" 
                                             loading="lazy">
                                        <span class="team-name-text text-truncate poppins-medium font-12" 
                                              title="{{ $team['team']['name'] ?? '' }}">
                                            {{ $team['team']['tla'] ?? $team['team']['shortName'] ?? $team['team']['name'] ?? '-' }}
                                        </span>
                                    </div>
                                </td>

                                {{-- Pontos --}}
                                <td class="text-center poppins-bold font-12 text-dark points-col">
                                    {{ $team['points'] ?? 0 }}
                                </td>

                                {{-- Jogos, Vitórias, Empates, Derrotas, Saldo --}}
                                <td class="text-center poppins-regular font-12 text-muted">{{ $team['playedGames'] ?? 0 }}</td>
                                <td class="text-center poppins-regular font-12 text-muted">{{ $team['won'] ?? 0 }}</td>
                                <td class="text-center poppins-regular font-12 text-muted">{{ $team['draw'] ?? 0 }}</td>
                                <td class="text-center poppins-regular font-12 text-muted">{{ $team['lost'] ?? 0 }}</td>
                                <td class="text-center poppins-regular font-12 text-muted pe-2">{{ $team['goalDifference'] ?? 0 }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Legenda das Zonas --}}
            <div class="standings-legend pt-3 mt-3 border-top d-flex flex-wrap gap-2 justify-content-between font-11 poppins-regular text-muted">
                <span class="d-flex align-items-center gap-1"><span class="legend-dot bg-libertadores"></span> Libertadores</span>
                <span class="d-flex align-items-center gap-1"><span class="legend-dot bg-sulamericana"></span> Sul-Americana</span>
                <span class="d-flex align-items-center gap-1"><span class="legend-dot bg-z4"></span> Z-4</span>
            </div>

        </div>
    </div>
    <!-- Tabela do Brasileirão Widget End -->
@endif

<style>
    /* ===================================
       ESTILOS DO WIDGET DE CLASSIFICAÇÃO
    =================================== */
    .table>:not(caption)>*>*{
        background-color: rgb(254 245 240) !important;
    }
    .standings-icon-badge {
        color: #d97706;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
    }

    /* Container de Scroll com Scrollbar Personalizada */
    .standings-table-wrapper {
        max-height: 420px;
        overflow-y: auto;
        padding-right: 2px;
    }

    .standings-table-wrapper::-webkit-scrollbar {
        width: 5px;
        height: 5px;
    }

    .standings-table-wrapper::-webkit-scrollbar-thumb {
        background: var(--accent-color);
        border-radius: 4px;
    }

    /* Cabeçalho da Tabela */
    .standings-thead-row th {
        font-size: 11px;
        color: #64748b;
        font-weight: 700;
        text-transform: uppercase;
        border-bottom: 1px solid #e2e8f0 !important;
        padding-bottom: 8px;
    }

    /* Linhas da Tabela */
    .standings-row {
        border-bottom: 1px solid #f1f5f9;
        transition: background-color 0.15s ease;
        position: relative;
    }

    .standings-row:hover {
        background-color: #f8fafc !important;
    }

    /* Escudo do Time */
    .team-crest-sm {
        width: 20px;
        height: 20px;
        object-fit: contain;
        flex-shrink: 0;
    }

    .team-name-text {
        color: #1e293b;
        max-width: 90px;
    }

    .points-col {
        background: rgba(241, 245, 249, 0.5);
        border-radius: 4px;
    }

    /* Indicadores de Zonas (Borda Lateral da Posição) */
    .zone-libertadores .pos-col {
        border-left: 3px solid #059669; /* Verde */
        color: #059669;
    }

    .zone-pre-libertadores .pos-col {
        border-left: 3px solid #10b981; /* Verde Claro */
        color: #10b981;
    }

    .zone-sulamericana .pos-col {
        border-left: 3px solid #0284c7; /* Azul */
        color: #0284c7;
    }

    .zone-rebaixamento .pos-col {
        border-left: 3px solid #dc2626; /* Vermelho Z4 */
        color: #dc2626;
    }

    /* Bolinhas da Legenda */
    .legend-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        display: inline-block;
    }

    .bg-libertadores { background-color: #059669; }
    .bg-sulamericana { background-color: #0284c7; }
    .bg-z4 { background-color: #dc2626; }
</style>