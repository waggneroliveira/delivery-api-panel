@extends($theme->core('client'))
@section('content')
    <!-- Hero Banner -->
    <section id="inicio">
        @foreach ($slides as $slide)
            <div class="hero">

                <picture class="hero-background">
                    <source srcset="{{ asset('storage/' . $slide->path_image_mobile) }}" media="(max-width: 530px)">
                    <img src="{{ asset('storage/' . $slide->path_image) }}" alt="{{ $slide->title ?? 'Imagem do slide' }}" title="{{ $slide->title ?? 'Imagem do slide' }}">
                </picture>

                <div class="hero-overlay"></div>

                <div class="container text-white text-start hero-content"  data-aos="fade-up" data-aos-duration="1000">
                    <div class="row justify-content-start">
                        <div class="col-lg-7 col-md-9">

                            <span class="badge-feature bg-white text-dark mb-3 d-inline-block">
                                {{$slide->btn_title}}                                
                            </span>

                            <h1 class="display-3 fw-bold mb-3 col-lg-11">
                                {{$slide->title}}
                            </h1>

                            <div class="lead mb-4">
                                {!!$slide->description!!}
                            </div>

                            <div class="d-flex flex-wrap gap-3">
                                <a href="#servicos"
                                class="h-100 bg-button-one color-button-one rounded-pill px-lg-5 px-3 py-lg-3 py-1 font-16 fw-semibold hover-zoom text-uppercase">
                                    Nossos serviços
                                    <i class="bi bi-arrow-right-circle ms-1"></i>
                                </a>

                                <a href="#contato"
                                class="btn btn-outline-light rounded-pill px-lg-5 px-3 py-lg-3 py-1 hover-zoom">
                                    Solicite contato
                                </a>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        @endforeach
    </section>

    <!-- TRÊS BOXES SOBREPOSTOS -->
    <section class="container overlap-cards">
        <div class="row g-4">
            @foreach ($topics as $topic) 
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="{{ ($loop->index + 1) * 100 }}">
                    <div class="quick-card text-center">
                        <div class="quick-icon mb-3"><i class="bi bi-calendar-check"></i></div>
                        <h5 class="fw-bold">{{$topic->title}}</h5>
                        <p class="text-secondary small">{{$topic->description}}</p>
                        @if (isset($topic) && $topic->link <> null)
                            <a href="{{$topic->link}}" class="text-decoration-none fw-semibold secondary-color">{{$topic->btn_title}} <i class="bi bi-arrow-right-short"></i></a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Quem Somos -->
    @if (isset($about) && $about <> null)
        <section id="quem-somos" class="about py-5 py-md-6" style="padding-top: 3rem;">
            <div class="container py-5">
                <div class="row align-items-center g-5">
                    <div class="col-lg-6 order-lg-1 order-2" data-aos="fade-right">
                        <h2 class="fw-bold mb-3">{{$about->title}} <span class="primary-color">{{$about->subtitle}}</span></h2>
                        <div class="gold-divider"></div>
                        <p class="lead fs-5 text-secondary">{{$about->link}}</p>
                        <div class="mt-3">
                            {!! $about->text !!}
                        </div>
                        
                        <a href="#contato" class="bg-button-two color-button-two rounded-pill px-4 py-2 d-table mt-3 fw-semibold hover-zoom">Fale com especialista <i class="bi bi-chat-dots"></i></a>
                    </div>
                    <div class="col-lg-6 order-lg-2 order-1 text-center" data-aos="fade-left">
                        <img src="{{asset('storage/' . $about->path_image)}}" alt="Equipe do cartório" class="img-fluid rounded-4 shadow-lg quem-somos-img" style="max-height: 420px; width: 100%; object-fit: cover;">
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- Serviços com MODAL -->
    <section id="servicos" class="py-5 bg-light">
        <div class="container py-4">
            @if (isset($sections['service']) && $sections <> null)                
                <div class="text-center mb-5" data-aos="fade-up">
                    <span class="badge-feature bg-button-two color-button-two px-3 py-2">{{$sections['service']->tag}}</span>
                    <h2 class="display-6 fw-bold mt-3">{{$sections['service']->title}} <span class="primary-color">{{$sections['service']->subtitle}}</span></h2>
                    <p class="lead text-secondary mx-auto" style="max-width: 680px;">Clique em cada serviço e veja informações detalhadas.</p>
                </div>
            @endif
            @if (isset($services) && $services->count())
                <div class="row g-4">
                    @foreach ($services as $service)
                        <div class="col-md-6 col-lg-4" data-aos="zoom-in" data-aos-delay="100">
                            <div
                                class="card service-card h-100 p-4"
                                data-bs-toggle="modal"
                                data-bs-target="#modalServico"
                                data-servico-titulo="{{ $service->title }}"
                                data-servico-desc="{{ $service->text ?? '' }}"
                                data-servico-link="{{ $service->link ?? '' }}"
                                data-servico-scroll="{{ $service->scroll_section ?? '' }}"
                            >

                                @if ($service->path_icon != null)
                                    <div class="service-icon mb-3">
                                        <img
                                            src="{{ asset('storage/' . $service->path_icon) }}"
                                            alt="{{ $service->title }}"
                                        >
                                    </div>
                                @endif

                                <h5 class="fw-bold">{{ $service->title }}</h5>

                                <p class="text-secondary">
                                    {{ $service->description }}
                                </p>

                                <hr class="my-2">

                                <small class="text-muted">
                                    <i class="bi bi-info-circle"></i>
                                    Clique para detalhes
                                </small>

                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="text-center mt-5" data-aos="fade-up">
                    <a href="#contato" class="btn btn-warning bg-button-two color-button-two rounded-pill px-5 fw-semibold">Solicitar atendimento</a>
                </div>
            @endif
        </div>
    </section>

    <!-- Modal Serviço -->
    <div class="modal fade" id="modalServico" tabindex="-1" aria-labelledby="modalServicoLabel">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content rounded-4 border-0 shadow">

                <div class="modal-header bg-warning bg-opacity-10 border-0">
                    <h5 class="modal-title fw-bold" id="modalServicoLabel">
                        <span id="modalIcon"></span>
                        <span id="modalTitulo">Serviço</span>
                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Fechar">
                    </button>
                </div>

                <div class="modal-body">

                    <div id="modalDescricao" class="fs-6 text-secondary"></div>

                </div>

                <div class="modal-footer bg-light">

                    <a
                        href="#"
                        id="modalSolicitar"
                        class="btn btn-warning bg-button-two color-button-two rounded-pill px-4 d-none"
                    >
                        Solicitar serviço
                    </a>

                    <button
                        type="button"
                        class="btn btn-outline-secondary rounded-pill"
                        data-bs-dismiss="modal">
                        Fechar
                    </button>

                </div>

            </div>
        </div>
    </div>

    <!-- SEÇÃO CASAMENTO ELEGANTE COM FANCYBOX -->
    <section id="galeria-casamento" class="py-5 wedding-section">
        <div class="container py-5">
            @if (isset($sections['gallery']) && $sections <> null) 
                <div class="text-center mb-5" data-aos="fade-up">
                    <span class="badge-feature bg-button-two color-button-two px-3 py-2">{{$sections['gallery']->tag}}</span>
                    <h2 class="display-6 fw-bold mt-3">{{$sections['gallery']->title}} <span class="primary-color">{{$sections['gallery']->subtitle}}</span></h2>
                    <p class="lead text-secondary mx-auto" style="max-width: 680px;">Clique em cada serviço e veja informações detalhadas.</p>
                </div>
            @endif

            @if ($galleries->count())
                @php
                    $featuredGallery = $galleries->first();
                    $remainingGalleries = $galleries->skip(1);
                @endphp

                <div class="row justify-content-center mb-5" data-aos="fade-up">
                    <div class="col-lg-10">
                        <div class="wedding-card">
                            <a href="{{ asset('storage/' . $featuredGallery->file) }}" data-fancybox="wedding-gallery" data-caption="Galeria de imagens">
                                <img src="{{ asset('storage/' . $featuredGallery->file) }}" class="wedding-highlight-img" alt="Imagem principal da galeria">
                            </a>
                            <div class="p-4 text-center bg-white">
                                <h4 class="fw-semibold">{{$sections['gallery']->title_first_image}}</h4>
                                <p class="text-muted mb-0">{{$sections['gallery']->description_first_image}}</p>
                            </div>
                        </div>
                    </div>
                </div>

                @if ($remainingGalleries->count())
                    <div class="row g-4" data-aos="fade-up" data-aos-delay="100">
                        @foreach ($remainingGalleries as $gallery)
                            <div class="col-md-3 col-6">
                                <div class="gallery-grid-item">
                                    <a href="{{ asset('storage/' . $gallery->file) }}" data-fancybox="wedding-gallery" data-caption="Imagem da galeria">
                                        <img src="{{ asset('storage/' . $gallery->file) }}" alt="Imagem da galeria" loading="lazy">
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            @endif
            
            @if (isset($sections['gallery']) && $sections['gallery']->link)                
                <div class="text-center mt-5 pt-3" data-aos="fade-up">
                    <a href="{{$sections['gallery']->link}}" class="bg-button-two color-button-two rounded-pill px-5 py-3 mt-2 hover-zoom">{{$sections['gallery']->btn_title}} <i class="bi bi-heart-fill ms-2"></i></a>
                </div>
            @endif
        </div>
    </section>

    <!-- Contato -->
    @if (isset($contact))
        <section id="contato" class="py-5 bg-light">
            <div class="container py-4">
                <div class="row g-5">                
                    <div class="col-lg-5" data-aos="fade-right">
                        <div class="contact-info h-100 d-flex flex-column justify-content-center p-lg-4 p-1">
                            @if (isset($contact))
                                <div class="icon d-flex justify-content-start align-item-center gap-3">
                                    <i class="bi bi-geo-alt-fill fs-1 text-warning mb-3"></i>
                                    <div class="col-10">
                                        <h3 class="fw-bold">{{$contact->name_section}}</h3>
                                        <p class="lead fs-6">{{$contact->text}}</p>
                                    </div>
                                </div>
                                <div class="mt-3 mb-3">
                                    <div class="d-flex gap-3 mb-3 align-items-center"><i class="bi bi-pin-map-fill fs-4 text-secondary"></i><span>{{$contact->address_one}}</span></div>
                                    <div class="d-flex gap-3 mb-3 align-items-center"><i class="bi bi-telephone-fill fs-4 text-secondary"></i><span>{{$contact->phone_one}}</span></div>
                                    <div class="d-flex gap-3 mb-3 align-items-center"><i class="bi bi-envelope-fill fs-4 text-secondary"></i><span>{{$contact->name_one}}</span></div>
                                    <div class="d-flex gap-3 align-items-center"><i class="bi bi-clock-fill fs-4 text-secondary"></i><span>{{$contact->opening_hours_two}}</span></div>
                                </div>
                            @endif
                            @if (isset($contact->maps) && $contact->maps != null) 
                                <iframe
                                src="{{$contact->maps}}"    
                                width="100%" 
                                height="250" 
                                style="border:0;" 
                                allowfullscreen="" 
                                loading="lazy" 
                                referrerpolicy="no-referrer-when-downgrade">
                                </iframe>
                            @endif
                        </div>

                    </div>                

                    <div class="col-lg-7" data-aos="fade-left">
                        <div class="bg-white shadow-sm rounded-4 p-4 p-md-5">
                            <h4 class="fw-semibold">Envie sua mensagem</h4>
                            <form id="formContato" class="mt-4">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Nome completo</label>
                                        <input type="text" id="name" name="name" class="form-control" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">E-mail</label>
                                        <input id="email" name="email" type="email" class="form-control" required>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Telefone</label>
                                        <input id="phone" name="phone" type="text" class="form-control">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Assunto</label>
                                        <select id="subject" name="subject" class="form-select">
                                            @foreach ($services as $subjectForm)
                                                <option value="{{$subjectForm->title}}">{{$subjectForm->title}}</option>  
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Mensagem</label>
                                        <textarea id="text" name="text" class="form-control" rows="4"></textarea>
                                    </div>
                                    <div class="col-12 d-flex align-items-center flex-wrap">
                                        <div class="form-check me-3">
                                            <input class="form-check-input" required id="term_privacy" name="term_privacy" type="checkbox" value="1">
                                            <label class="form-check-label small poppins-regular font-14 text-color" for="privacyCheck">
                                                Aceito os termos descritos na Política de Privacidade
                                            </label>
                                        </div>
                                        <button type="submit" class="btn btn-warning bg-button-two color-button-two fw-semibold px-5 rounded-pill">Enviar mensagem <i class="bi bi-send"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    @endif

    <style>
        .about li::before{
            color: var(--primary-color);
        }
        .quick-card{
            border-bottom: 3px solid var(--secondary-color);
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const modalServico = document.getElementById('modalServico');

            if (!modalServico) {
                return;
            }

            modalServico.addEventListener('show.bs.modal', function (event) {

                const serviceCard = event.relatedTarget;

                if (!serviceCard) {
                    return;
                }

                const titulo = serviceCard.dataset.servicoTitulo || 'Serviço';
                const descricao = serviceCard.dataset.servicoDesc || '';
                const link = serviceCard.dataset.servicoLink || '';
                const scroll = serviceCard.dataset.servicoScroll || '';
                const icon = serviceCard.dataset.servicoIcon || '';

                const modalTitulo = modalServico.querySelector('#modalTitulo');
                const modalDescricao = modalServico.querySelector('#modalDescricao');
                const modalSolicitar = modalServico.querySelector('#modalSolicitar');
                const modalIcon = modalServico.querySelector('#modalIcon');

                modalTitulo.textContent = titulo;
                modalDescricao.innerHTML = descricao;

                if (modalIcon) {
                    if (icon) {
                        modalIcon.innerHTML = `
                            <img
                                src="${icon}"
                                alt="${titulo}"
                                class="me-2"
                            >
                        `;
                    } else {
                        modalIcon.innerHTML = `
                            <i class="bi bi-star-fill text-warning me-2"></i>
                        `;
                    }
                }

                // Esconde o botão inicialmente
                modalSolicitar.classList.add('d-none');

                /*
                * LINK
                */
                if (link) {

                    modalSolicitar.href = link;
                    modalSolicitar.target = '_blank';
                    modalSolicitar.rel = 'noopener noreferrer';

                    modalSolicitar.classList.remove('d-none');

                /*
                * SCROLL
                */
                } else if (scroll) {

                    modalSolicitar.href = '#' + scroll;
                    modalSolicitar.removeAttribute('target');
                    modalSolicitar.removeAttribute('rel');

                    modalSolicitar.classList.remove('d-none');

                    modalSolicitar.addEventListener('click', function () {

                        const modalInstance = bootstrap.Modal.getInstance(modalServico);

                        if (modalInstance) {
                            modalInstance.hide();
                        }

                    }, { once: true });

                /*
                * NENHUMA AÇÃO
                */
                } else {

                    modalSolicitar.href = '#';
                    modalSolicitar.removeAttribute('target');
                    modalSolicitar.removeAttribute('rel');

                    modalSolicitar.classList.add('d-none');
                }

            });

            modalServico.addEventListener('hidden.bs.modal', function () {

                document.activeElement?.blur();

                const modalSolicitar = modalServico.querySelector('#modalSolicitar');

                modalSolicitar.href = '#';
                modalSolicitar.removeAttribute('target');
                modalSolicitar.removeAttribute('rel');
                modalSolicitar.classList.add('d-none');

            });

            // Mascara telefone
            const phoneInput = document.querySelector("#phone");

            if (phoneInput && !phoneInput.dataset.masked) {

                phoneInput.addEventListener("input", function (e) {

                    let t = e.target.value.replace(/\D/g, "");

                    // Permite apagar completamente o campo
                    if (!t) {
                        e.target.value = "";
                        return;
                    }

                    // Força o DDD 71
                    if (!t.startsWith("71")) {
                        t = "71" + t;
                    }

                    // Limita a 11 dígitos
                    t = t.slice(0, 11);

                    // Máscara: (71) 9 9999-9999
                    let formatado = "(" + t.slice(0, 2) + ")";

                    if (t.length > 2) {
                        formatado += " " + t.slice(2, 3);
                    }

                    if (t.length > 3) {
                        formatado += " " + t.slice(3, 7);
                    }

                    if (t.length > 7) {
                        formatado += "-" + t.slice(7);
                    }

                    e.target.value = formatado;
                });

                phoneInput.dataset.masked = "true";
            }
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#formContato').on('submit', function(e) {
                e.preventDefault();

                const formData = $(this).serialize();

                $.ajax({
                    url: '{{ route("send-contact") }}',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        if (typeof Swal !== 'undefined') {
                            Swal.fire({
                                title: 'Sucesso!',
                                text: response.message,
                                icon: 'success',
                                timer: 2000,
                                showConfirmButton: false
                            });
                        }
                        $('#formContato')[0].reset();
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;
                            let errorMessages = '';
                            for (let field in errors) {
                                errorMessages += errors[field][0] + '\n';
                            }

                            if (typeof Swal !== 'undefined') {
                                Swal.fire({
                                    title: 'Erro',
                                    text: errorMessages,
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            }
                        } else {
                            if (typeof Swal !== 'undefined') {
                                Swal.fire({
                                    title: 'Erro',
                                    text: 'Ocorreu um erro ao enviar a mensagem. Por favor, tente novamente.',
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            }
                        }
                    }
                });
            });
        });
    </script>
@endsection
