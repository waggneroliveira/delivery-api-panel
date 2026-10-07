@extends($theme->core('client'))
@section('content')
    <div class="banner-inner blog container-fluid d-flex justify-content-center align-items-center flex-column position-relative" style="--banner-bg: url('../images/banner-blog.png');">
        <span class="color-yellow font-changa font-16 font-bold position-relative z-3 text-center">Contato </span>
        <h1 class="font-mobi font-changa font-40 font-bold text-white position-relative z-3 mt-2">Fale Conosco</h1>
        <p class="font-changa font-15 font-regular text-white position-relative z-3">Conheça um pouco sobre a gente aqui!</p>
    </div>

    <section class="contact mb-0 mt-4">
        <div class="container py-5">
            <div class="row">
                @if (isset($contact))
                    <!-- Infos -->
                    <div class="col-12 col-lg-5">
                        <span class="about-subtitle faq-eyebrow color-yellow font-changa font-16 font-bold d-block mb-2 text-end m-0 z-3 position-relative">Fale Conosco</span>
                        <h2 class="faq-title font-changa font-50 font-bold color-green mt-2 mb-3">{{$contact->name_section}}</h2>
                        <p class="faq-text color-grey font-changa font-16 font-regular text-center text-lg-start">
                            {{$contact->text}}
                        </p>
        
                        <ul class="list-unstyled">
                            <li class="d-flex mb-3">
                                <div class="me-3 text-success fs-4">
                                    <i class="bi bi-geo-alt-fill primary-color"></i>
                                </div>
                                <div>
                                    <span class="color-green font-changa font-16 font-semibold">Endereço</span>
                                    <p class="color-grey font-changa font-16 font-regular col-12 col-lg-10">
                                        {{$contact->address_one}}
                                    </p>
                                </div>
                            </li>
        
                            <li class="d-flex mb-3">
                                <div class="me-3 text-success fs-4">
                                    <i class="bi bi-telephone-fill primary-color"></i>
                                </div>
                                <div>
                                    <span class="color-green font-changa font-16 font-semibold">Telefone</span>
                                    <p class="color-grey font-changa font-16 font-regular">{{$contact->phone_one}}</p>
                                </div>
                            </li>
        
                            <li class="d-flex">
                                <div class="me-3 text-success fs-4">
                                    <i class="bi bi-envelope-fill primary-color"></i>
                                </div>
                                <div>
                                    <span class="color-green font-changa font-16 font-semibold">E-mail</span>
                                    <p class="color-grey font-changa font-16 font-regular">{{$contact->name_one}}</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                @endif
                
                <div class="col-lg-7">
                    <!-- Formulário e Mapa -->
                    <div class="row g-4 mt-4">
                        <div class="col-12">
                            <form id="contactForm">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <input type="text" required id="nome" name="name" class="poppins-regular font-15 text-color form-control" placeholder="Nome Completo">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="email" required id="email" name="email" class="poppins-regular font-15 text-color form-control" placeholder="E-mail">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" required id="phone" name="phone" class="poppins-regular font-15 text-color form-control" placeholder="Whatsapp para contato">
                                    </div>
                                    <div class="col-md-12">
                                        <input type="text" required id="subject" name="subject" class="poppins-regular font-15 text-color form-control" placeholder="Assunto">
                                    </div>
                                    <div class="col-md-12">
                                        <textarea id="text" required name="text" class="form-control poppins-regular font-15 text-color" rows="4" placeholder="Digite aqui...."></textarea>
                                    </div>
                                    <div class="col-12 d-flex align-items-center flex-wrap">
                                        <div class="form-check me-3">
                                            <input class="form-check-input" required id="term_privacy" name="term_privacy" type="checkbox" value="1">
                                            <label class="form-check-label small poppins-regular font-14 text-color" for="privacyCheck">
                                                Aceito os termos descritos na Política de Privacidade
                                            </label>
                                        </div>
                                        <button type="submit" class="bt-hover border font-changa font-15 bg-button-two color-button-two rounded-3 ms-auto py-2 px-4 hover-zoom">Enviar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Mapa -->
        @if (isset($contact->maps) && $contact->maps != null) 
            <div class="row mt-5">
                <div class="col-12">
                    <div class="ratio ratio-21x9 rounded overflow-hidden shadow-sm">
                        <iframe
                            src="{{$contact->maps}}"
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>
            </div>
        @endif
    </section>
    

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#contactForm').on('submit', function(e) {
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
                    $('#contactForm')[0].reset();
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