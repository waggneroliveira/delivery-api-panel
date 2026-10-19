@extends('client.core.client')

@section('content')

<style>
    .announcement{
        display: none;
    }
    @media (max-width: 600px) {
    #calendar {
        grid-template-columns: repeat(7, 1fr);
        font-size: 10px;
    }

    .day {
        min-height: 35px;
        padding: 1px;
    }

    .day-number {
        font-size: 10px;
    }

    #calendar .header {
        font-size: 12px;
    }

    #events-list, #holidays-block {
        font-size: 12px;
    }
    .day .event-badge {
        text-indent: -9999px; /* esconde o texto */
        overflow: hidden;
        width: 8px;
        height: 8px;
        padding: 0;
        min-height: inherit;
    }
    .event-list{
        flex-direction: row;
        flex-wrap: wrap;
    }
    
    /* Estilo para evento destacado */
    .event-item.highlighted {
        background-color: #E6E8F8 !important;
        border-left: 4px solid #2F368B !important;
        padding-left: 10px;
        transition: all 0.3s ease;
    }
}
</style>

<div class="d-flex justify-content-start gap-2 align-items-start flex-nowrap mt-5 mb-3">
    <span class="firula-contact mt-2"></span>
    <div class="description">
        <h1 class="poppins-bold font-30 mb-0 title-blue text-uppercase">Eventos</h1>
    </div>
</div>

<div class="container mx-auto p-4">
    <div id="calendar"></div>
    <div id="events-list" class="mt-6"></div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    // Dados passados pelo controller
    const events = @json($events);
    const holidays = @json($holidays);

    let currentMonth = new Date().getMonth();
    let currentYear = new Date().getFullYear();

    const calendarEl = document.getElementById('calendar');
    const eventsListEl = document.getElementById('events-list');

    // Verificar se há parâmetros na URL
    const urlParams = new URLSearchParams(window.location.search);
    // const eventId = urlParams.get('event_id');
    const eventId = @json($eventId);
    const shouldScroll = urlParams.get('scroll') === 'true';

    // Adicione esta função após a definição das variáveis
function navigateToEventMonth(eventId) {
    const event = events.find(e => e.id == eventId);
    if (event) {
        const eventDate = new Date(event.date);
        currentMonth = eventDate.getMonth();
        currentYear = eventDate.getFullYear();
        renderCalendar(currentMonth, currentYear);
        
        // Destacar o dia do evento
        setTimeout(() => {
            const dayElements = document.querySelectorAll('.day');
            dayElements.forEach(dayEl => {
                const dayNumber = dayEl.querySelector('.day-number').textContent;
                const fullDate = `${currentYear}-${String(currentMonth+1).padStart(2,'0')}-${String(dayNumber).padStart(2,'0')}`;
                
                if (fullDate === event.date) {
                    // Simular clique no dia do evento
                    dayEl.click();
                }
            });
        }, 500);
    }
}

// Modifique a inicialização para usar esta função
document.addEventListener('DOMContentLoaded', function() {
    // ... resto do código ...
    
    // Inicializar o calendário
    renderCalendar(currentMonth, currentYear);
    
    // Se há um event_id, navegar para o mês do evento
    if (eventId && shouldScroll) {
        navigateToEventMonth(eventId);
    }
});

    // Função para rolar até um evento específico
    function scrollToEvent(eventId) {
        console.log('Tentando rolar para o evento:', eventId);
        const elementId = `event-${eventId}`;
        console.log('Procurando elemento com ID:', elementId);
        
        const eventElement = document.getElementById(elementId);
        
        if (eventElement) {
            console.log('Elemento do evento encontrado:', eventElement);
            // Destacar o evento
            eventElement.classList.add('highlighted');
            
            // Rolar até o elemento
            eventElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
            
            // Remover o destaque após 5 segundos
            setTimeout(() => {
                eventElement.classList.remove('highlighted');
            }, 5000);
            
            // Limpar o parâmetro scroll da URL para evitar repetição
            if (history.replaceState && shouldScroll) {
                const newUrl = window.location.protocol + "//" + window.location.host + 
                            window.location.pathname + 
                            window.location.search.replace(/&scroll=true|scroll=true/, '');
                history.replaceState({}, document.title, newUrl);
            }
        } else {
            console.log('Elemento do evento não encontrado com ID:', elementId);
            console.log('Todos os elementos de evento na página:');
            document.querySelectorAll('.event-item').forEach(item => {
                console.log('Elemento:', item, 'ID:', item.id);
            });
        }
    }

    function renderCalendar(month, year) {
        calendarEl.innerHTML = '';

        // Nome do mês com inicial maiúscula
        const monthName = new Date(year, month).toLocaleString('default', { month: 'long' });
        const formattedMonth = monthName.charAt(0).toUpperCase() + monthName.slice(1);

        // Header com navegação
        const header = document.createElement('div');
        header.className = 'header';
        header.innerHTML = `
            <button onclick="prevMonth()">&#8592;</button>
            <span>${formattedMonth} ${year}</span>
            <button onclick="nextMonth()">&#8594;</button>
        `;
        calendarEl.appendChild(header);

        // Dias da semana
        const weekdays = ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'];
        weekdays.forEach(day => {
            const div = document.createElement('div');
            div.className = 'weekday';
            div.textContent = day;
            calendarEl.appendChild(div);
        });

        // Dias do mês
        const firstDay = new Date(year, month, 1).getDay();
        const daysInMonth = new Date(year, month + 1, 0).getDate();

        // Espaços vazios para alinhar o primeiro dia
        for (let i = 0; i < firstDay; i++) {
            const empty = document.createElement('div');
            calendarEl.appendChild(empty);
        }

        for (let day = 1; day <= daysInMonth; day++) {
            const fullDate = `${year}-${String(month+1).padStart(2,'0')}-${String(day).padStart(2,'0')}`;
            const dayEl = document.createElement('div');
            dayEl.className = 'day';
            
            const dayEvents = events.filter(e => e.date === fullDate);

            // Número do dia
            const dayNumber = document.createElement('div');
            dayNumber.textContent = day;
            dayNumber.classList.add('day-number');
            dayEl.appendChild(dayNumber);

            // Criar o container dos eventos
            if(dayEvents.length > 0){
                const eventList = document.createElement('div');
                eventList.classList.add('event-list');

                dayEvents.forEach(ev => {
                    const evDiv = document.createElement('div');
                    evDiv.textContent = ev.title;
                    evDiv.classList.add('event-badge');
                    eventList.appendChild(evDiv);
                });

                dayEl.appendChild(eventList);
                dayEl.classList.add('event');
            }

            // Feriados
            const holiday = holidays.find(h => h.date === fullDate);
            if (holiday) {
                dayEl.style.border = '2px solid #E5282A';
            }

            dayEl.addEventListener('click', () => {
                // Remove borda e fundo de todos os dias
                document.querySelectorAll('.day').forEach(d => {
                    const dayNumber = d.querySelector('.day-number').textContent;
                    const fullDateCheck = `${year}-${String(month+1).padStart(2,'0')}-${String(dayNumber).padStart(2,'0')}`;
                    const holiday = holidays.find(h => h.date === fullDateCheck);

                    if (holiday) {
                        d.style.border = '2px solid #E5282A'; // feriado padrão
                        d.style.backgroundColor = ''; // remove fundo anterior
                    } else {
                        d.style.border = '1px solid #ddd'; // padrão
                        d.style.backgroundColor = ''; // remove fundo anterior
                    }
                });

                // Aplica borda e fundo ao dia clicado
                const clickedHoliday = holidays.find(h => h.date === fullDate);
                if (clickedHoliday) {
                    dayEl.style.border = '2px solid #F5B8B8'; // vermelho mais claro
                    dayEl.style.backgroundColor = '#FDEDEE'; // fundo suave vermelho
                } else {
                    dayEl.style.border = '2px solid #2F368B'; // azul escuro
                    dayEl.style.backgroundColor = '#E6E8F8'; // fundo azul claro
                }

                // Renderiza eventos do dia
                renderEvents(fullDate);

                eventsListEl.scrollIntoView({ behavior: 'smooth', block: 'start' });
            });

            calendarEl.appendChild(dayEl);
        }

        // Render feriados do mês vigente
        renderHolidays(month, year);

        // Lista eventos do mês
        renderEventsMonth(month, year);

        // Adicionar botão "Ver todos os eventos" se estiver filtrado por um evento
        if (eventId) {
            const backButton = document.createElement('button');
            backButton.textContent = 'Ver todos os eventos';
            backButton.className = 'btn background-red poppins-semiBold font-15 text-white mt-3';
            backButton.onclick = () => {
                window.location.href = window.location.pathname; // Remove parâmetros da URL
            };
            eventsListEl.appendChild(backButton);
        }
    }

    function renderHolidays(month, year) {
        // remove bloco anterior de feriados
        const oldBlock = document.getElementById('holidays-block');
        if (oldBlock) oldBlock.remove();

        // Corrigido: usar UTC para evitar problemas de fuso horário
        const monthHolidays = holidays.filter(h => {
            const dateParts = h.date.split('-');
            const holidayMonth = parseInt(dateParts[1]) - 1; // Mês é 0-indexed no JS
            const holidayYear = parseInt(dateParts[0]);
            
            return holidayMonth === month && holidayYear === year;
        });

        if (monthHolidays.length > 0) {
            const block = document.createElement('div');
            block.id = 'holidays-block';
            block.innerHTML = `<h3 class="holiday-month">Feriados</h3>`;

            monthHolidays.forEach(h => {
                const div = document.createElement('div');
                div.className = 'holiday-item';
                div.innerHTML = `${formatDateLocal(h.date)}: <strong>${h.name}</strong>`;
                block.appendChild(div);
            });

            // insere antes da lista de eventos
            eventsListEl.parentNode.insertBefore(block, eventsListEl);
        }
    }

    function renderEventsMonth(month, year) {
        eventsListEl.innerHTML = '';
        
        // Filtrar eventos - se há um event_id, mostrar apenas esse evento
        let monthEvents;
        if (eventId) {
            monthEvents = events.filter(e => {
                const eventIdValue = parseInt(e.id) || e.id;
                return eventIdValue == eventId;
            });
        } else {
            // Mostrar todos os eventos do mês
            monthEvents = events.filter(e => {
                const dateParts = e.date.split('-');
                const eventMonth = parseInt(dateParts[1]) - 1;
                const eventYear = parseInt(dateParts[0]);
                
                return eventMonth === month && eventYear === year;
            });
        }

        monthEvents.forEach(e => {
            const div = document.createElement('div');
            div.className = 'event-item';
            
            // Usar o ID do evento corretamente
            const eventIdValue = parseInt(e.id) || e.id;
            div.id = `event-${eventIdValue}`;
            
            const linkHtml = e.link ? `<a href="${e.link}">Acessar</a>` : '';
            
            div.innerHTML = `
                <strong>${formatDateLocal(e.date)}</strong> - <span style="color:#6c757d;">${e.hours}</span> <br> 
                <h4>${e.title}</h4>
                <div class="description">${e.description}</div> <br>
                ${linkHtml}
            `;
            eventsListEl.appendChild(div);
        });

        if (monthEvents.length === 0) {
            eventsListEl.innerHTML = '<p>Nenhum evento neste mês.</p>';
        }
        
        // Se há um event_id, rolar até o evento
        if (eventId && shouldScroll) {
            setTimeout(() => scrollToEvent(eventId), 1000);
        }
    }


    function formatDateLocal(dateStr) {
        const parts = dateStr.split('-'); // "2025-08-15" => ["2025","08","15"]
        const date = new Date(parts[0], parts[1]-1, parts[2]); // mês é 0-index
        return date.toLocaleDateString('pt-BR');
    }

    function renderEvents(date) {
        // Filtrar eventos - se há um event_id, mostrar apenas esse evento
        let dayEvents;
        if (eventId) {
            dayEvents = events.filter(e => {
                const eventIdValue = parseInt(e.id) || e.id;
                return eventIdValue == eventId && e.date === date;
            });
        } else {
            dayEvents = events.filter(e => e.date === date);
        }
        
        eventsListEl.innerHTML = '';

        if(dayEvents.length === 0) {
            eventsListEl.innerHTML = '<p>Nenhum evento neste dia.</p>';
            return;
        }

        dayEvents.forEach(e => {
            const div = document.createElement('div');
            div.className = 'event-item';
            
            const eventIdValue = parseInt(e.id) || e.id;
            div.id = `event-${eventIdValue}`;
            
            const linkHtml = e.link ? `<a href="${e.link}">Acessar</a>` : '';
            
            div.innerHTML = `
                <strong>${formatDateLocal(e.date)}</strong> - <span style="color:#6c757d;">${e.hours}</span> <br> 
                <h4>${e.title}</h4>
                <div class="description">${e.description}</div> <br>
                ${linkHtml}
            `;
            
            eventsListEl.appendChild(div);
        });
        
        // Se há um event_id, rolar até o evento
        if (eventId && shouldScroll) {
            setTimeout(() => scrollToEvent(eventId), 1000);
        }
    }

    window.prevMonth = function() {
        currentMonth--;
        if(currentMonth < 0) {
            currentMonth = 11;
            currentYear--;
        }
        renderCalendar(currentMonth, currentYear);
    }

    window.nextMonth = function() {
        currentMonth++;
        if(currentMonth > 11) {
            currentMonth = 0;
            currentYear++;
        }
        renderCalendar(currentMonth, currentYear);
    }

    // Inicializar o calendário
    renderCalendar(currentMonth, currentYear);
});
</script>

@endsection