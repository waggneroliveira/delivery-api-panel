<form id="newsletterForm">
    @csrf
    <p class="text-color poppins-regular font-12 text-start font-mob">
        Inscreva-se na nossa newsletter e fique por dentro de todas as novidades de toda a acidade
    </p>
    <div class="input-group mb-2" style="width: 100%;">
        <input type="text" name="email" id="email" class="form-control form-control-lg poppins-regular text-color font-14" placeholder="Seu e-mail" required>
        <div class="input-group-append">
            <button type="submit" class="btn background-red text-white poppins-medium font-15 px-2 h-100 rounded-3 font-mob">
                Enviar
            </button>
        </div>
    </div>
    <div class="d-flex justify-content-start align-items-center gap-2">
        <input type="checkbox" id="term_privacy" name="term_privacy" required>
        <label for="term_privacy" class=" term poppins-regular text-color font-12 text-start">
            Aceito os termos descritos na Política de Privacidade
        </label>
    </div>
</form>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $('#newsletterForm').on('submit', function(e) {
        e.preventDefault();

        const formData = $(this).serialize();

        $.ajax({
            url: '{{ route("send-newsletter") }}',
            type: 'POST',
            data: formData,
            success: function(response) {
                Swal.fire({
                    title: 'Sucesso!',
                    text: response.message,
                    icon: 'success',
                    timer: 1800,
                    showConfirmButton: false
                });
                $('#newsletterForm')[0].reset();
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    let errorMessages = '';
                    for (let field in errors) {
                        errorMessages += errors[field][0] + '\n';
                    }

                    Swal.fire({
                        title: 'Erro',
                        text: errorMessages,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                } else {
                    Swal.fire({
                        title: 'Erro',
                        text: 'Ocorreu um erro ao enviar seu cadastro. Tente novamente.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            }
        });
    });

</script>
