<!-- Eventos da Semana no Aside -->
<div class="mb-4 col-12">
   <div class="p-4">
      <h5 class="card-title fw-bold mb-3 fs-6 text-dark d-flex align-items-center justify-content-between pb-3 border-bottom">
         <span>
            <i class="bi bi-calendar-event me-2 text-dark"></i>Eventos da Semana
         </span>
         <span class="badge bg-light text-dark fw-normal small rounded-0">Agenda</span>
      </h5>

      <!-- Lista de Eventos -->
      <div class="events-list">
         @foreach($events as $event)
            <div class="border-bottom mb-3 @if($loop->last) border-bottom-0 @endif" >
                <div class="d-flex align-items-start mb-3 p-3 pb-0 mb-0" style="background: rgb(254 245 240);">
                    <!-- Data / Bloco do Mês e Dia -->
                    <div class="bg-light text-center rounded-0 p-2 me-3 flex-shrink-0" style="width: 50px;">
                       <span class="d-block text-uppercase text-muted fw-bold font-12">
                          {{ strtoupper(substr(\Carbon\Carbon::parse($event->date)->translatedFormat('F'), 0, 3)) }}
                       </span>
                       <span class="d-block text-dark fw-bold fs-5 lh-1">
                          {{ \Carbon\Carbon::parse($event->date)->format('d') }}
                       </span>
                    </div>
                    <!-- Detalhes do Evento -->
                    <div>
                       <span class="badge bg-primary-subtle text-primary mb-2 font-10 rounded-0">Workshop</span>
                       <h6 class="mb-1 font-12 position-relative">
                          @if($event->link)
                             <a href="{{ $event->link }}" target="_blank" class="text-dark text-decoration-none poppins-semiBold stretched-link" title="{{ $event->title }}">
                          @else
                             <a href="{{ route('client.event', ['slug' => $event->slug]) }}" class="text-dark text-decoration-none poppins-semiBold stretched-link" title="{{ $event->title }}">
                          @endif
                             {{ substr(strip_tags($event->title),0 ,50) }}
                          </a>
                       </h6>
                       <p class="text-muted mb-0 font-12">
                          <i class="bi bi-clock me-1"></i> {{ $event->hours }}
                       </p>
                    </div>
                </div>
            </div>
         @endforeach
      </div>

      <!-- Botão Opcional para ver todos -->
      <div class="mt-3 pt-2 text-center border-top">
         <a href="{{ route('client.event') }}" class="text-decoration-none small fw-semibold text-dark">
            Ver agenda completa <i class="bi bi-arrow-right ms-1"></i>
         </a>
      </div>

   </div>
</div>