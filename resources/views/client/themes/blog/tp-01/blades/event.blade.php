@extends($theme->core('client'))

@section('content')

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
    :root {
        --primary: #2F368B;
        --primary-hover: #242a6d;
        --primary-light: #F0F2FA;
        --accent-red: #E5282A;
        --accent-red-light: #FDF2F2;
        --border-color: #E2E8F0;
        --text-main: #0F172A;
        --text-muted: #64748B;
        --bg-card: #FFFFFF;
        --radius-lg: 16px;
        --radius-md: 12px;
        --shadow-subtle: 0 10px 25px -5px rgba(15, 23, 42, 0.05), 0 8px 10px -6px rgba(15, 23, 42, 0.05);
    }

    .announcement { display: none; }

    /* Cabeçalho da Seção */
    .events-hero {
        background: linear-gradient(135deg, var(--primary-light) 0%, #FFFFFF 100%);
        border-radius: var(--radius-lg);
        padding: 2rem 2.5rem;
        border: 1px solid rgba(47, 54, 139, 0.08);
        position: relative;
        overflow: hidden;
    }

    .events-hero::after {
        content: '';
        position: absolute;
        right: -20px;
        bottom: -20px;
        width: 150px;
        height: 150px;
        background: radial-gradient(circle, rgba(47, 54, 139, 0.05) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }

    /* Container do Calendário */
    .calendar-container {
        background: var(--bg-card);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-subtle);
        border: 1px solid var(--border-color);
        padding: 1.75rem;
    }

    #calendar {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 8px;
    }

    #calendar .header {
        grid-column: span 7;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--border-color);
    }

    #calendar .header span {
        font-weight: 700;
        font-size: 1.2rem;
        color: var(--primary);
        text-transform: capitalize;
        letter-spacing: -0.01em;
    }

    #calendar .header button {
        background: var(--primary-light);
        color: var(--primary);
        border: none;
        width: 38px;
        height: 38px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
    }

    #calendar .header button:hover {
        background: var(--primary);
        color: #FFFFFF;
        transform: scale(1.05);
    }

    .weekday {
        text-align: center;
        font-weight: 600;
        font-size: 0.75rem;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        padding-bottom: 0.75rem;
    }

    .day {
        min-height: 90px;
        background: #F8FAFC;
        border: 1px solid var(--border-color);
        border-radius: var(--radius-md);
        padding: 8px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        cursor: pointer;
        transition: all 0.2s ease;
        position: relative;
    }

    .day:hover {
        border-color: var(--primary);
        background: #FFFFFF;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(47, 54, 139, 0.08);
    }

    .day-number {
        font-weight: 600;
        font-size: 0.85rem;
        color: var(--text-main);
    }

    .event-list {
        display: flex;
        gap: 4px;
        flex-wrap: wrap;
        margin-top: 4px;
    }

    .event-badge {
        width: 6px;
        height: 6px;
        background-color: var(--primary);
        border-radius: 50%;
        text-indent: -9999px;
        overflow: hidden;
    }

    .day.holiday-day {
        border-color: rgba(229, 40, 42, 0.3);
        background-color: var(--accent-red-light);
    }

    .day.holiday-day .day-number {
        color: var(--accent-red);
    }

    /* Painel Lateral / Lista de Eventos */
    .events-sidebar {
        background: var(--bg-card);
        border-radius: var(--radius-lg);
        padding: 1.75rem;
        box-shadow: var(--shadow-subtle);
        border: 1px solid var(--border-color);
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .holiday-item {
        background: var(--accent-red-light);
        border-left: 3px solid var(--accent-red);
        padding: 10px 14px;
        border-radius: 8px;
        margin-bottom: 8px;
        font-size: 0.85rem;
        color: #7F1D1D;
        font-weight: 500;
    }

    .events-list-wrapper {
        overflow-y: auto;
        max-height: 600px;
        padding-right: 4px;
    }

    .events-list-wrapper::-webkit-scrollbar {
        width: 5px;
    }
    .events-list-wrapper::-webkit-scrollbar-thumb {
        background: #CBD5E1;
        border-radius: 10px;
    }

    .event-item {
        background: #F8FAFC;
        border: 1px solid var(--border-color);
        border-left: 4px solid var(--primary);
        border-radius: var(--radius-md);
        padding: 1.25rem;
        margin-bottom: 1rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .event-item:hover {
        background: #FFFFFF;
        box-shadow: 0 4px 15px rgba(0,0,0,0.04);
    }

    .event-item.highlighted {
        background-color: var(--primary-light) !important;
        border-left-color: var(--primary) !important;
        box-shadow: 0 0 0 2px rgba(47, 54, 139, 0.2);
        transform: translateY(-2px);
    }

    .event-item h4 {
        color: var(--text-main);
        font-weight: 700;
        font-size: 1rem;
        margin-top: 0.4rem;
        margin-bottom: 0.5rem;
        letter-spacing: -0.01em;
    }

    .btn-access {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: var(--primary);
        color: #FFFFFF;
        padding: 6px 14px;
        border-radius: 8px;
        font-size: 0.8rem;
        text-decoration: none;
        font-weight: 600;
        margin-top: 10px;
        transition: background 0.2s ease, transform 0.1s ease;
    }

    .btn-access:hover {
        background: var(--primary-hover);
        color: #FFFFFF;
    }

    /* Responsividade para Telas Menores */
    @media (max-width: 768px) {
        .events-hero {
            padding: 1.5rem;
        }
        .calendar-container, .events-sidebar {
            padding: 1rem;
        }
        #calendar {
            gap: 4px;
        }
        .day {
            min-height: 52px;
            padding: 4px;
        }
        .day-number {
            font-size: 0.75rem;
        }
        #calendar .header span {
            font-size: 1rem;
        }
        .event-badge {
            width: 4px;
            height: 4px;
        }
    }
</style>

<div class="container">
    <!-- Cabeçalho Visual da Página -->
    <div class="events-hero mb-4 mt-3 d-flex align-items-center justify-content-between flex-wrap gap-3">
        <div>
            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-1 rounded-pill font-12 fw-bold mb-2 d-inline-block">
                <i class="bi bi-calendar3 me-1"></i> AGENDA OFICIAL
            </span>
            <h1 class="poppins-bold font-28 mb-1" style="color: var(--primary); letter-spacing: -0.02em;">Eventos e Programação</h1>
            <p class="text-muted mb-0 font-14">Consulte os próximos eventos, atividades agendadas e feriados do mês.</p>
        </div>
    </div>
    
    <!-- Grid de Conteúdo -->
    <div class="container-fluid px-0">
        <div class="row g-4">
            <!-- Calendário (Esquerda) -->
            <div class="col-lg-7">
                <div class="calendar-container">
                    <div id="calendar"></div>
                </div>
            </div>
    
            <!-- Painel Lateral de Eventos (Direita) -->
            <div class="col-lg-5">
                <div class="events-sidebar">
                    <div id="holidays-container"></div>
                    
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3 class="poppins-bold font-16 mb-0 text-dark"><i class="bi bi-list-task me-2 text-primary"></i>Atividades do Período</h3>
                    </div>
                    
                    <div class="events-list-wrapper" id="events-list"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const events = @json($events);
    const holidays = @json($holidays);
    const eventId = @json($eventId);
    const urlParams = new URLSearchParams(window.location.search);
    const shouldScroll = urlParams.get('scroll') === 'true';

    let currentMonth = new Date().getMonth();
    let currentYear = new Date().getFullYear();

    const calendarEl = document.getElementById('calendar');
    const eventsListEl = document.getElementById('events-list');
    const holidaysContainerEl = document.getElementById('holidays-container');

    // Posicionamento inteligente caso venha um ID específico por URL
    if (eventId) {
        const targetEvent = events.find(e => e.id == eventId);
        if (targetEvent) {
            const evDate = new Date(targetEvent.date);
            currentMonth = evDate.getMonth();
            currentYear = evDate.getFullYear();
        }
    }

    renderCalendar(currentMonth, currentYear);

    if (eventId && shouldScroll) {
        setTimeout(() => scrollToEvent(eventId), 600);
    }

    function renderCalendar(month, year) {
        calendarEl.innerHTML = '';

        const monthName = new Date(year, month).toLocaleString('pt-BR', { month: 'long' });
        const formattedMonth = monthName.charAt(0).toUpperCase() + monthName.slice(1);

        // Header de navegação
        const header = document.createElement('div');
        header.className = 'header';
        header.innerHTML = `
            <button onclick="changeMonth(-1)" title="Mês Anterior"><i class="bi bi-chevron-left"></i></button>
            <span>${formattedMonth} ${year}</span>
            <button onclick="changeMonth(1)" title="Próximo Mês"><i class="bi bi-chevron-right"></i></button>
        `;
        calendarEl.appendChild(header);

        // Dias da semana
        ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'].forEach(day => {
            const div = document.createElement('div');
            div.className = 'weekday';
            div.textContent = day;
            calendarEl.appendChild(div);
        });

        const firstDay = new Date(year, month, 1).getDay();
        const daysInMonth = new Date(year, month + 1, 0).getDate();

        // Espaços iniciais
        for (let i = 0; i < firstDay; i++) {
            const empty = document.createElement('div');
            calendarEl.appendChild(empty);
        }

        // Dias do mês
        for (let day = 1; day <= daysInMonth; day++) {
            const fullDate = `${year}-${String(month+1).padStart(2,'0')}-${String(day).padStart(2,'0')}`;
            const dayEl = document.createElement('div');
            dayEl.className = 'day';

            const dayEvents = events.filter(e => e.date === fullDate);
            const holiday = holidays.find(h => h.date === fullDate);

            if (holiday) {
                dayEl.classList.add('holiday-day');
            }

            const dayNumber = document.createElement('div');
            dayNumber.textContent = day;
            dayNumber.className = 'day-number';
            dayEl.appendChild(dayNumber);

            if (dayEvents.length > 0) {
                const eventList = document.createElement('div');
                eventList.className = 'event-list';
                dayEvents.forEach(() => {
                    const badge = document.createElement('div');
                    badge.className = 'event-badge';
                    eventList.appendChild(badge);
                });
                dayEl.appendChild(eventList);
            }

            // Evento de clique no dia
            dayEl.addEventListener('click', () => {
                document.querySelectorAll('.day').forEach(d => {
                    d.style.borderColor = d.classList.contains('holiday-day') ? 'rgba(229, 40, 42, 0.3)' : 'var(--border-color)';
                    d.style.background = d.classList.contains('holiday-day') ? 'var(--accent-red-light)' : '#F8FAFC';
                });

                dayEl.style.borderColor = 'var(--primary)';
                dayEl.style.background = 'var(--primary-light)';
                
                renderEventsByDate(fullDate);
            });

            calendarEl.appendChild(dayEl);
        }

        renderHolidays(month, year);
        renderEventsMonth(month, year);
    }

    window.changeMonth = function(direction) {
        currentMonth += direction;
        if (currentMonth > 11) {
            currentMonth = 0;
            currentYear++;
        } else if (currentMonth < 0) {
            currentMonth = 11;
            currentYear--;
        }
        renderCalendar(currentMonth, currentYear);
    };

    function renderHolidays(month, year) {
        holidaysContainerEl.innerHTML = '';
        const monthHolidays = holidays.filter(h => {
            const parts = h.date.split('-');
            return parseInt(parts[1]) - 1 === month && parseInt(parts[0]) === year;
        });

        if (monthHolidays.length > 0) {
            let blockHtml = `<h6 class="poppins-bold font-13 mb-2 text-danger text-uppercase tracking-wider"><i class="bi bi-star-fill me-1"></i> Feriados do Mês</h6>`;
            monthHolidays.forEach(h => {
                blockHtml += `<div class="holiday-item"><strong>${formatDateLocal(h.date)}</strong> — ${h.name}</div>`;
            });
            holidaysContainerEl.innerHTML = blockHtml + `<hr class="my-3 text-muted opacity-25">`;
        }
    }

    function renderEventsMonth(month, year) {
        let monthEvents;
        if (eventId) {
            monthEvents = events.filter(e => e.id == eventId);
        } else {
            monthEvents = events.filter(e => {
                const parts = e.date.split('-');
                return parseInt(parts[1]) - 1 === month && parseInt(parts[0]) === year;
            });
        }
        displayEventsList(monthEvents);
    }

    function renderEventsByDate(date) {
        const dayEvents = events.filter(e => e.date === date);
        displayEventsList(dayEvents);
    }

    function displayEventsList(list) {
        eventsListEl.innerHTML = '';

        if (list.length === 0) {
            eventsListEl.innerHTML = `
                <div class="text-center py-5 text-muted">
                    <i class="bi bi-calendar-x font-28 mb-2 d-block opacity-50"></i>
                    <p class="mb-0 font-14">Nenhum evento agendado para este período.</p>
                </div>`;
            return;
        }

        list.forEach(e => {
            const div = document.createElement('div');
            div.className = 'event-item';
            div.id = `event-${e.id}`;

            const linkHtml = e.link ? `<a href="${e.link}" class="btn-access"><i class="bi bi-box-arrow-up-right"></i> Acessar Evento</a>` : '';

            div.innerHTML = `
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="font-12 fw-bold text-primary"><i class="bi bi-calendar-event me-1"></i> ${formatDateLocal(e.date)}</span>
                    <span class="font-12 text-muted bg-white px-2 py-0.5 rounded border border-light"><i class="bi bi-clock me-1"></i> ${e.hours}</span>
                </div>
                <h4>${e.title}</h4>
                <div class="text-muted font-13">${e.description}</div>
                ${linkHtml}
            `;
            eventsListEl.appendChild(div);
        });

        if (eventId) {
            const backBtn = document.createElement('button');
            backBtn.className = 'btn btn-outline-secondary w-100 mt-3 font-14 rounded-pill py-2';
            backBtn.innerHTML = '<i class="bi bi-arrow-left me-1"></i> Ver todos os eventos do calendário';
            backBtn.onclick = () => window.location.href = window.location.pathname;
            eventsListEl.appendChild(backBtn);
        }
    }

    function scrollToEvent(id) {
        const el = document.getElementById(`event-${id}`);
        if (el) {
            el.classList.add('highlighted');
            el.scrollIntoView({ behavior: 'smooth', block: 'center' });
            setTimeout(() => el.classList.remove('highlighted'), 5000);

            if (history.replaceState) {
                const cleanUrl = window.location.protocol + "//" + window.location.host + window.location.pathname;
                history.replaceState({}, document.title, cleanUrl);
            }
        }
    }

    function formatDateLocal(dateStr) {
        const parts = dateStr.split('-');
        const date = new Date(parts[0], parts[1]-1, parts[2]);
        return date.toLocaleDateString('pt-BR', { day: '2-digit', month: '2-digit', year: 'numeric' });
    }
});
</script>

@endsection