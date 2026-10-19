@if($tempo)
    <div class="col-12 mb-4">
        <div class="weather-card col-12 col-lg-11 m-auto" data-condition="{{ strtolower($tempo['condition_code'] ?? 'sunny') }}">
            <!-- Efeitos Atmosféricos de Fundo -->
            <div class="weather-bg-glow glow-primary"></div>
            <div class="weather-bg-glow glow-secondary"></div>
            <div class="weather-shimmer"></div>

            <div class="weather-card-body">
                <!-- Cabeçalho: Localização e Horário/Condição -->
                <div class="weather-header">
                    <div>
                        <div class="weather-location">
                            <i class="bi bi-geo-alt-fill"></i>
                            <span>Lauro de Freitas</span>
                        </div>
                        <div class="weather-condition-text">
                            {{ $tempo['condition'] ?? 'Ensolarado com poucas nuvens' }}
                        </div>
                    </div>

                    <!-- Ícone Animado em Camadas -->
                    <div class="weather-hero-icon" aria-hidden="true">
                        <div class="sun-rays"></div>
                        <i class="bi bi-sun-fill icon-sun"></i>
                        <i class="bi bi-cloud-fill icon-cloud-back"></i>
                        <i class="bi bi-cloud-fill icon-cloud-front"></i>
                    </div>
                </div>

                <!-- Bloco Principal de Temperatura -->
                <div class="weather-main-temp">
                    <div class="temp-value">
                        {{ $tempo['temperature'] }}
                    </div>
                    <div class="temp-unit-group">
                        <span class="temp-degree">°</span>
                        <span class="temp-scale">C</span>
                    </div>
                </div>

                <!-- Variação Térmica Diária -->
                <div class="weather-range-bar">
                    <span class="temp-min">{{ $tempo['min'] ?? '22' }}°</span>
                    <div class="range-track">
                        <div class="range-fill" style="left: 30%; width: 50%;"></div>
                    </div>
                    <span class="temp-max">{{ $tempo['max'] ?? '31' }}°</span>
                </div>

                <div class="weather-divider"></div>

                <!-- Grid de Métricas Secundárias -->
                <div class="weather-metrics-grid">
                    <div class="metric-chip">
                        <div class="metric-icon">
                            <i class="bi bi-wind"></i>
                        </div>
                        <div class="metric-data">
                            <span class="metric-label">Vento</span>
                            <span class="metric-value">{{ $tempo['windspeed'] }} <small>km/h</small></span>
                        </div>
                    </div>

                    <div class="metric-chip">
                        <div class="metric-icon">
                            <i class="bi bi-droplet-half"></i>
                        </div>
                        <div class="metric-data">
                            <span class="metric-label">Umidade</span>
                            <span class="metric-value">{{ $tempo['humidity'] ?? '78' }}<small>%</small></span>
                        </div>
                    </div>

                    <div class="metric-chip">
                        <div class="metric-icon">
                            <i class="bi bi-thermometer-half"></i>
                        </div>
                        <div class="metric-data">
                            <span class="metric-label">Sensação</span>
                            <span class="metric-value">{{ $tempo['feels_like'] ?? $tempo['temperature'] }}<small>°C</small></span>
                        </div>
                    </div>

                    <div class="metric-chip">
                        <div class="metric-icon">
                            <i class="bi bi-sun"></i>
                        </div>
                        <div class="metric-data">
                            <span class="metric-label">Índice UV</span>
                            <span class="metric-value">{{ $tempo['uv_index'] ?? '8' }} <small>Alto</small></span>
                        </div>
                    </div>
                </div>

                <!-- Footer / Status em Tempo Real -->
                <div class="weather-footer">
                    <div class="weather-live-badge">
                        <span class="live-pulse"></span>
                        <span class="live-text">Ao vivo</span>
                    </div>
                    <span class="weather-update-time">Hoje, {{ date('H:i') }}</span>
                </div>

            </div>
        </div>
    </div>
@endif