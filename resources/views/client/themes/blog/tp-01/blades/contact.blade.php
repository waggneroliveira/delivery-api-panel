@extends($theme->core('client'))

@section('content')
<section class="contact-section py-3 my-lg-3 position-relative">
    <div class="container py-lg-4">

        <div class="row g-5 align-items-stretch">
            
            <!-- Coluna de Informações / Canais -->
            @if (isset($contact))
                <div class="col-lg-5 d-flex flex-column justify-content-between">
                    <div class="pe-lg-4">
                        <h2 class="faq-title font-32 font-bold text-dark mb-3">{{ $contact->name_section }}</h2>
                        <p class="faq-text text-muted font-16 font-regular mb-4">
                            {{ $contact->text }}
                        </p>

                        <div class="d-flex flex-column gap-4 mt-4">
                            <!-- Endereço -->
                            @if($contact->address_one)
                            <div class="d-flex align-items-start">
                                <div class="icon-box text-primary rounded-0 p-3 me-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 50px; height: 50px;">
                                    <i class="bi bi-geo-alt fs-5"></i>
                                </div>
                                <div>
                                    <span class="d-block font-16 font-semibold text-dark">Endereço</span>
                                    <span class="font-15 text-muted">{{ $contact->address_one }}</span>
                                </div>
                            </div>
                            @endif

                            <!-- Telefone -->
                            @if($contact->phone_one)
                            <div class="d-flex align-items-start">
                                <div class="icon-box text-primary rounded-0 p-3 me-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 50px; height: 50px;">
                                    <i class="bi bi-telephone fs-5"></i>
                                </div>
                                <div>
                                    <span class="d-block font-16 font-semibold text-dark">Telefone</span>
                                    <span class="font-15 text-muted">{{ $contact->phone_one }}</span>
                                </div>
                            </div>
                            @endif

                            <!-- E-mail -->
                            @if($contact->name_one)
                            <div class="d-flex align-items-start">
                                <div class="icon-box text-primary rounded-0 p-3 me-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 50px; height: 50px;">
                                    <i class="bi bi-envelope fs-5"></i>
                                </div>
                                <div>
                                    <span class="d-block font-16 font-semibold text-dark">E-mail</span>
                                    <span class="font-15 text-muted">{{ $contact->name_one }}</span>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
            
            <!-- Coluna do Formulário em Card Clean -->
            <div class="{{ isset($contact) ? 'col-lg-7' : 'col-lg-8 mx-auto' }}">
                <div class="card border-0 bg-accent-color shadow-sm rounded-0 p-4 p-md-5 h-100">
                    <form id="contactForm">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label for="nome" class="form-label font-15 text-dark mb-1">Nome Completo</label>
                                <input type="text" required id="nome" name="name" class="form-control poppins-regular font-15 py-2 px-3 border-light rounded-0" placeholder="Seu nome completo">
                            </div>
                            
                            <div class="col-md-6">
                                <label for="email" class="form-label font-15 text-dark mb-1">E-mail</label>
                                <input type="email" required id="email" name="email" class="form-control poppins-regular font-15 py-2 px-3 border-light rounded-0" placeholder="seu@email.com">
                            </div>
                            
                            <div class="col-md-6">
                                <label for="phone" class="form-label font-15 text-dark mb-1">WhatsApp</label>
                                <input type="text" required id="phone" name="phone" maxlength="15" class="form-control poppins-regular font-15 py-2 px-3 border-light rounded-0" placeholder="(00) 00000-0000">
                            </div>
                            
                            <div class="col-md-12">
                                <label for="subject" class="form-label font-15 text-dark mb-1">Assunto</label>
                                <input type="text" required id="subject" name="subject" class="form-control poppins-regular font-15 py-2 px-3 border-light rounded-0" placeholder="Sobre o que deseja falar?">
                            </div>
                            
                            <div class="col-md-12">
                                <label for="text" class="form-label font-15 text-dark mb-1">Mensagem</label>
                                <textarea id="text" required name="text" class="form-control poppins-regular font-15 py-2 px-3 border-light rounded-0" rows="4" placeholder="Escreva sua mensagem aqui..."></textarea>
                            </div>
                            
                            <div class="col-12 d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mt-4 pt-2">
                                <div class="form-check">
                                    <input class="form-check-input" required id="term_privacy" name="term_privacy" type="checkbox" value="1">
                                    <label class="form-check-label poppins-regular font-14 text-muted" for="term_privacy">
                                        Aceito os termos da <a href="#" class="text-primary text-decoration-none">Política de Privacidade</a>
                                    </label>
                                </div>
                                
                                <button type="submit" id="submitBtn" class="btn btn-primary bg-button-one color-button-one font-15 py-2 px-4 rounded-0 fw-semibold shadow-sm border-0 d-inline-flex align-items-center justify-content-center">
                                    <span class="btn-text">Enviar Mensagem</span>
                                    <span class="spinner-border spinner-border-sm ms-2 d-none" role="status" aria-hidden="true"></span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>

        <!-- Mapa Moderno e Suave -->
        @if (isset($contact->maps) && $contact->maps != null) 
            <div class="row mt-5 pt-3">
                <div class="col-12">
                    <div class="ratio ratio-21x9 rounded-0 overflow-hidden shadow-sm border">
                        <iframe
                            src="{{ $contact->maps }}"
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"
                            style="border:0;">
                        </iframe>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Máscara nativa para Telefone / WhatsApp (sem dependência externa)
        $('#phone').on('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 11) value = value.slice(0, 11);

            if (value.length > 10) {
                // Celular com 9º dígito: (00) 00000-0000
                value = value.replace(/^(\d{2})(\d{5})(\d{4}).*/, '($1) $2-$3');
            } else if (value.length > 6) {
                // Telefone fixo ou celular incompleto: (00) 0000-0000
                value = value.replace(/^(\d{2})(\d{4})(\d{0,4}).*/, '($1) $2-$3');
            } else if (value.length > 2) {
                value = value.replace(/^(\d{2})(\d{0,5})/, '($1) $2');
            } else if (value.length > 0) {
                value = value.replace(/^(\d*)/, '($1');
            }
            e.target.value = value;
        });

        // Envio do formulário via AJAX
        $('#contactForm').on('submit', function(e) {
            e.preventDefault();

            const $form = $(this);
            const $submitBtn = $('#submitBtn');
            const $btnText = $submitBtn.find('.btn-text');
            const $spinner = $submitBtn.find('.spinner-border');

            // Feedback visual de carregamento no botão
            $submitBtn.prop('disabled', true);
            $btnText.text('Enviando...');
            $spinner.removeClass('d-none');

            const formData = $form.serialize();

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
                            timer: 2500,
                            showConfirmButton: false
                        });
                    }
                    $form[0].reset();
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
                                title: 'Atenção',
                                text: errorMessages,
                                icon: 'warning',
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
                },
                complete: function() {
                    // Restaura o botão
                    $submitBtn.prop('disabled', false);
                    $btnText.text('Enviar Mensagem');
                    $spinner.addClass('d-none');
                }
            });
        });
    });
</script>
@endsection