@if ($events->count() > 0) 
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --primary-blue: #2F368B;
            --primary-red: #E5282A;
            --bg-light: #F8FAFC;
            --border-color: #E2E8F0;
            --text-main: #0F172A;
            --shadow-sm: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -2px rgba(0, 0, 0, 0.05);
            --shadow-hover: 0 10px 15px -3px rgba(47, 54, 139, 0.1), 0 4px 6px -4px rgba(47, 54, 139, 0.1);
        }

        /* Seção Header */
        .section-header-events {
            border-bottom: 2px solid var(--border-color);
            padding-bottom: 0.75rem;
        }

        .btn-view-all {
            background-color: var(--primary-red);
            color: #ffffff;
            font-weight: 600;
            font-size: 0.9rem;
            padding: 8px 20px;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-view-all:hover {
            background-color: #c81e20;
            color: #ffffff;
            transform: translateY(-1px);
        }

        /* Cards de Eventos */
        .event-card-home {
            background: #ffffff;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            height: 85px;
            display: flex;
            align-items: center;
            text-decoration: none;
            color: inherit;
        }

        .event-card-home:hover {
            border-color: var(--primary-blue);
            box-shadow: var(--shadow-hover);
            transform: translateY(-3px);
            color: inherit;
        }

        /* Badge da Data (Bloco Vermelho/Azul) */
        .event-date-badge {
            background: linear-gradient(135deg, var(--primary-red) 0%, #c81e20 100%);
            color: #ffffff;
            width: 75px;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            flex-shrink: 0;
        }

        .event-date-badge .day-num {
            font-size: 1.35rem;
            font-weight: 800;
            line-height: 1;
        }

        .event-date-badge .month-name {
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            opacity: 0.9;
            margin-top: 2px;
        }

        /* Conteúdo do Card */
        .event-card-body {
            padding: 0.75rem 1rem;
            flex-grow: 1;
            display: flex;
            align-items: center;
            justify-content: space-between;
            overflow: hidden;
        }

        .event-title-home {
            font-size: 0.88rem;
            font-weight: 700;
            color: var(--primary-blue);
            margin: 0;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            line-height: 1.25;
        }

        .event-arrow-icon {
            color: #94A3B8;
            font-size: 1.1rem;
            transition: transform 0.2s ease, color 0.2s ease;
            margin-left: 8px;
            flex-shrink: 0;
        }

        .event-card-home:hover .event-arrow-icon {
            color: var(--primary-blue);
            transform: translateX(4px);
        }
    </style>

    <div class="container my-5">
        <!-- Cabeçalho da Seção -->
        <div class="section-header-events d-flex justify-content-between align-items-center mb-4">
            <h2 class="section-title poppins-bold font-24 title-blue mb-0">
                <i class="bi bi-calendar-event me-2 text-danger"></i>Próximos Eventos
            </h2>        
            <a href="{{ route('client.event') }}" class="btn-view-all">
                Ver todos <i class="bi bi-arrow-right"></i>
            </a>                            
        </div>

        <!-- Grid de Cards de Evento -->
        <div class="row g-3">      
            @foreach($events as $event)                
                @php
                    $eventUrl = $event->link ?: route('client.event') . '?event_id=' . $event->id . '&scroll=true';
                    $eventDate = \Carbon\Carbon::parse($event->date);
                @endphp

                <div class="col-12 col-sm-6 col-lg-3">
                    <a href="{{ $eventUrl }}" class="event-card-home" title="{{ strip_tags($event->title) }}">
                        <!-- Badge da Data -->
                        <div class="event-date-badge">
                            <span class="day-num">{{ $eventDate->format('d') }}</span>
                            <span class="month-name">{{ strtoupper($eventDate->translatedFormat('M')) }}</span>
                        </div>

                        <!-- Conteúdo com Título e Ícone -->
                        <div class="event-card-body">
                            <h3 class="event-title-home">
                                {{ strip_tags($event->title) }}
                            </h3>
                            <i class="bi bi-chevron-right event-arrow-icon"></i>
                        </div>
                    </a>
                </div>
            @endforeach                                 
        </div>

        <!-- Bloco de Anúncios / Comunicados -->
        @if (isset($announcements) && $announcements->count())                        
            <div class="mt-5">
                @include('client.includes.announcement')
            </div>
        @endif
    </div>
@endif