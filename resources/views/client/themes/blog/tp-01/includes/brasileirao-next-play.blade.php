<div class="col-12 mb-0">
    <div class="matches-widget rounded-4">
        <div class="matches-widget-content">

            {{-- Cabeçalho do Widget com Navegação --}}
            <div class="d-flex flex-column justify-content-between align-items-center mb-3">
                <div class="matches-title col-12">
                    <i class="bi bi-trophy-fill me-2 text-warning"></i> Próximos Jogos
                </div>

                <div class="d-flex justify-content-between col-12 align-items-center gap-2">
                    @if(!empty($proximosJogos) && isset($proximosJogos[0]['matchday']))
                        <span class="matches-badge">
                            {{ $proximosJogos[0]['matchday'] }}ª Rodada
                        </span>
                    @endif

                    {{-- Botões do Carrossel --}}
                    <div class="navigation d-flex gap-2">
                        <div class="swiper-navigation-btn matches-prev"><i class="bi bi-chevron-left"></i></div>
                        <div class="swiper-navigation-btn matches-next"><i class="bi bi-chevron-right"></i></div>
                    </div>
                </div>
            </div>

            {{-- Container Swiper --}}
            @if(!empty($proximosJogos))
                <div class="swiper matches-swiper">
                    <div class="swiper-wrapper">
                        @foreach($proximosJogos as $jogo)
                            <div class="swiper-slide">
                                <div class="match-card-vertical">
                                    {{-- Time Mandante --}}
                                    <div class="match-team-row">
                                        <img src="{{ $jogo['homeTeam']['crest'] }}" alt="{{ $jogo['homeTeam']['name'] }}" class="team-crest" loading="lazy">
                                        <span class="team-name text-truncate" title="{{ $jogo['homeTeam']['name'] }}">
                                            {{ $jogo['homeTeam']['tla'] ?? $jogo['homeTeam']['shortName'] ?? $jogo['homeTeam']['name'] }}
                                        </span>
                                    </div>

                                    {{-- Separador VS e Horário --}}
                                    <div class="match-info-center">
                                        <span class="vs-badge">VS</span>
                                        <span class="match-datetime">
                                            <i class="bi bi-calendar3 me-1"></i>
                                            {{ \Carbon\Carbon::parse($jogo['utcDate'])->setTimezone('America/Sao_Paulo')->format('d/m') }}

                                            <i class="bi bi-clock ms-1 me-1"></i>
                                            {{ \Carbon\Carbon::parse($jogo['utcDate'])->setTimezone('America/Sao_Paulo')->format('H:i') }}
                                        </span>
                                    </div>

                                    {{-- Time Visitante --}}
                                    <div class="match-team-row">
                                        <img src="{{ $jogo['awayTeam']['crest'] }}" alt="{{ $jogo['awayTeam']['name'] }}" class="team-crest" loading="lazy">
                                        <span class="team-name text-truncate" title="{{ $jogo['awayTeam']['name'] }}">
                                            {{ $jogo['awayTeam']['tla'] ?? $jogo['awayTeam']['shortName'] ?? $jogo['awayTeam']['name'] }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="text-center w-100 py-4 text-white-50">
                    <i class="bi bi-calendar-x fs-3 d-block mb-2"></i>
                    Nenhum jogo agendado para a próxima rodada.
                </div>
            @endif

        </div>
    </div>
</div>

<style>
    /* ===================================
       ESTILOS DOS JOGOS (SWIPER CAROUSEL)
    =================================== */
    .matches-widget {
        position: relative;
        overflow: hidden;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .matches-widget-content {
        padding: 18px 20px;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .matches-title {
        font-size: 15px;
        font-weight: 700;
    }

    .matches-badge {
        background: color-mix(in srgb, var(--primary-color) 8%, transparent);
        border: 1px solid rgba(255, 255, 255, .15);
        padding: 3px 10px;
        border-radius: 10px;
        font-size: 11px;
        font-weight: 600;
    }

    /* Botões de Navegação Personalizados */
    .swiper-navigation-btn {
        width: 26px;
        height: 26px;
        background: #272a33;
        border: 1px solid rgba(255, 255, 255, .12);
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary-color);
        font-size: 12px;
        cursor: pointer;
        transition: background .2s ease;
    }

    .swiper-navigation-btn:hover {
        background: #272a33;
        color: #FFF;
    }

    .swiper-button-disabled {
        opacity: .3;
        cursor: not-allowed;
    }

    /* Swiper Container */
    .matches-swiper {
        width: 100%;
        padding: 4px 2px;
    }

    .swiper-slide {
        width: auto; /* Permite tamanho dinâmico do card */
    }

    /* Card Individual */
    .match-card-vertical {
        width: 210px;
        background: rgba(80, 80, 80, .07);
        border-radius: 10px;
        padding: 14px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        gap: 8px;
        border: 1px solid rgba(0, 0, 0, .09);
        transition: transform .2s ease, background .2s ease;
    }

    .match-card-vertical:hover {
        background: #363e4e;
        transform: translateY(-2px);
    }
    
    .match-card-vertical:hover .team-name.text-truncate, .match-card-vertical:hover .vs-badge{
        color: #FFF;
    }
    .match-team-row {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    .team-crest {
        width: 28px !important;
        height: 28px !important;
        object-fit: contain;
        flex-shrink: 0;
    }

    .team-name {
        font-size: 13px;
        font-weight: 700;
        color: #2f3644;
        letter-spacing: -0.2px;
    }

    .match-info-center {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin: 2px 0;
    }

    .vs-badge {
        color: #2f3644;
        font-weight: 900;
        font-size: 13px;
        letter-spacing: .5px;
        line-height: 1;
    }

    .match-datetime {
        font-size: 11px;
        color: #9aa4b2;
        font-weight: 500;
        margin-top: 4px;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        new Swiper('.matches-swiper', {
            slidesPerView: 'auto',
            spaceBetween: 14,
            freeMode: true,
            grabCursor: true,
            navigation: {
                nextEl: '.matches-next',
                prevEl: '.matches-prev',
            },
        });
    });
</script>
