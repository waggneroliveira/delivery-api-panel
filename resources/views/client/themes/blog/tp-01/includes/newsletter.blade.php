<div class="newsletter-aside-widget mb-4 overflow-hidden rounded-4">
    <div class="newsletter-card p-4">
        
        {{-- Cabeçalho do Widget --}}
        <div class="newsletter-header pb-3 mb-3 border-bottom">
            <div class="d-flex align-items-center gap-2 mb-1">
                <div class="newsletter-icon-badge">
                    <i class="bi bi-envelope-paper-heart-fill text-dark"></i>
                </div>
                <h4 class="m-0 poppins-bold font-18 title-aside">Newsletter</h4>
            </div>
            <p class="text-muted poppins-regular font-12 m-0 mt-2">
                Inscreva-se e receba as principais notícias da cidade direto no seu e-mail.
            </p>
        </div>

        {{-- Formulário --}}
        <form id="newsletterForm" novalidate>
            @csrf
            
            {{-- Campo E-mail + Botão --}}
            <div class="newsletter-input-wrapper mb-3">
                <div class="input-group">
                    <span class="input-group-text border-end-0 bg-transparent ps-3">
                        <i class="bi bi-envelope text-muted"></i>
                    </span>
                    <input type="email" name="email" id="email" 
                           class="form-control border-start-0 ps-2 poppins-regular font-14" 
                           placeholder="Seu melhor e-mail" required>
                </div>
            </div>

            {{-- Checkbox do Termo --}}
            <div class="form-check custom-checkbox mb-3">
                <input class="form-check-input" type="checkbox" id="term_privacy" name="term_privacy" required>
                <label class="form-check-label poppins-regular font-12 text-muted lh-sm cursor-pointer" for="term_privacy">
                    Li e aceito os termos da <a href="#" class="text-decoration-underline text-primary">Política de Privacidade</a>.
                </label>
            </div>

            {{-- Botão de Submissão --}}
            <button type="submit" id="btnNewsletter" class="btn btn-newsletter-submit bg-button-one color-button-one w-100 poppins-medium font-14 d-flex align-items-center justify-content-center gap-2">
                <span>Inscrever-se</span>
                <i class="bi bi-send-fill font-12"></i>
            </button>
        </form>

    </div>
</div>

<style>
    /* ===================================
       ESTILOS DO WIDGET DE NEWSLETTER
    =================================== */
    .newsletter-aside-widget {
        position: relative;
    }

    .newsletter-icon-badge {
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
    }

    .title-aside {
        color: #0f172a;
        letter-spacing: -0.3px;
    }

    /* Estilização do Input Group */
    .newsletter-input-wrapper .input-group {
        background: #f8fafc;
        border: 1px solid #cbd5e1;
        border-radius: 0px;
        overflow: hidden;
        transition: all 0.2s ease;
    }

    .newsletter-input-wrapper .input-group:focus-within {
        border-color: #272a33;
        background: #ffffff;
        box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.12);
    }

    .newsletter-input-wrapper .form-control {
        background: transparent;
        border: none;
        box-shadow: none;
        height: 44px;
        color: #1e293b;
    }

    .newsletter-input-wrapper .form-control::placeholder {
        color: #94a3b8;
    }

    /* Checkbox Customizado */
    .custom-checkbox .form-check-input {
        width: 16px;
        height: 16px;
        margin-top: 2px;
        border-color: #cbd5e1;
        cursor: pointer;
    }

    .custom-checkbox .form-check-input:checked {
        background-color: #272a33;
        border-color: #272a33;
    }

    .cursor-pointer {
        cursor: pointer;
    }

    /* Botão Principal */
    .btn-newsletter-submit {
        color: #ffffff;
        border: none;
        height: 44px;
        border-radius: 0px;
        transition: all 0.25s ease;
    }

    .btn-newsletter-submit:hover {
        background: color-mix(in srgb, var(--bg-button-one) 88%, black);
        color: #ffffff;
        transform: translateY(-1px);
        box-shadow: 0 6px 15px color-mix(in srgb, var(--bg-button-one) 25%, transparent);
    }

    .btn-newsletter-submit:active {
        transform: translateY(0);
    }

    .btn-newsletter-submit:disabled {
        background: #94a3b8;
        cursor: not-allowed;
    }
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $('#newsletterForm').on('submit', function(e) {
        e.preventDefault();

        const $form =$(this);
        const $btn =$('#btnNewsletter');
        const originalBtnText = $btn.html();

        // Feedback visual de carregamento
        $btn.prop('disabled', true).html(`
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            <span>Enviando...</span>
        `);

        $.ajax({
            url: '{{ route("send-newsletter") }}',
            type: 'POST',
            data: $form.serialize(),
            success: function(response) {
                Swal.fire({
                    title: 'Inscrição Confirmada!',
                    text: response.message || 'Obrigado por se inscrever na nossa newsletter.',
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: false,
                    customClass: {
                        popup: 'rounded-4'
                    }
                });
                $form[0].reset();
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    let errorMessages = '';
                    for (let field in errors) {
                        errorMessages += errors[field][0] + '<br>';
                    }

                    Swal.fire({
                        title: 'Atenção',
                        html: errorMessages,
                        icon: 'warning',
                        confirmButtonText: 'Entendido',
                        confirmButtonColor: '#dc2626',
                        customClass: {
                            popup: 'rounded-4'
                        }
                    });
                } else {
                    Swal.fire({
                        title: 'Ops!',
                        text: 'Ocorreu um erro ao processar sua inscrição. Tente novamente em instantes.',
                        icon: 'error',
                        confirmButtonText: 'Fechar',
                        confirmButtonColor: '#dc2626',
                        customClass: {
                            popup: 'rounded-4'
                        }
                    });
                }
            },
            complete: function() {
                // Restaura o botão ao estado normal
                $btn.prop('disabled', false).html(originalBtnText);
            }
        });
    });
</script>