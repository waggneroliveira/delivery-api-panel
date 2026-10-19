@php
    $textareaId = $textareaId ?? 'text' . (isset($contact->id) ? $contact->id : '');
@endphp

<div class="container">
    <div class="row">
        {{-- Sessão --}}
        <div class="col-12 mb-4">
            <h4 class="page-title">Informações da sessão</h4>
            <div class="card card-body">
                <div class="row g-3">
                    <div class="col-12 col-md-4">
                        <label for="name_section" class="form-label">Nome da sessão</label>
                        <input type="text" name="name_section" class="form-control" id="name_section"
                            value="{{ $contact->name_section ?? '' }}" placeholder="Nome da sessão">
                    </div>
                    <div class="col-12 col-md-8">
                        <label for="text" class="form-label">Texto</label>
                        <input type="text" name="text" class="form-control" id="text"
                            value="{{ $contact->text ?? '' }}" placeholder="Texto">
                    </div>
                    <div class="col-12">
                        <label for="maps" class="form-label">Link mapa</label>
                        <input type="text" name="maps" class="form-control" id="maps"
                        value="{{ $contact->maps ?? '' }}" placeholder="Mapa">
                        <div class="instructions">
                            <h5>Como usar:</h5>
                            <ol>
                                <li>Vá ao Google Maps e encontre o local desejado</li>
                                <li>Clique no botão "Compartilhar" e depois em "Incorporar um mapa"</li>
                                <li>Selecione e copie todo o código iframe</li>
                                <li>Cole o código no campo abaixo - o link será extraído automaticamente</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Redes sociais --}}
        <div class="col-12 mb-4">
            <h4 class="page-title">Informações das redes sociais</h4>
            <div class="card card-body">
                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <label for="whatsapp" class="form-label">Whatsapp</label>
                        <input type="text" name="whatsapp" class="form-control" id="whatsapp"
                            value="{{ $contact->whatsapp ?? '' }}" placeholder="Whatsapp">
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="link_insta" class="form-label">Link Instagram</label>
                        <input type="text" name="link_insta" class="form-control" id="link_insta"
                            value="{{ $contact->link_insta ?? '' }}" placeholder="Link Instagram">
                    </div>
                    <div class="col-12 col-md-6">
                        <label for="link_x" class="form-label">Link X</label>
                        <input type="text" name="link_x" class="form-control" id="link_x"
                            value="{{ $contact->link_x ?? '' }}" placeholder="Link X">
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="link_youtube" class="form-label">Link Youtube</label>
                        <input type="text" name="link_youtube" class="form-control" id="link_youtube"
                            value="{{ $contact->link_youtube ?? '' }}" placeholder="Link Youtube">
                    </div>
                    <div class="col-12 col-md-6">
                        <label for="link_face" class="form-label">Link Facebook</label>
                        <input type="text" name="link_face" class="form-control" id="link_face"
                            value="{{ $contact->link_face ?? '' }}" placeholder="Link Facebook">
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="link_tik_tok" class="form-label">Link Tik Tok</label>
                        <input type="text" name="link_tik_tok" class="form-control" id="link_tik_tok"
                            value="{{ $contact->link_tik_tok ?? '' }}" placeholder="Link Tik Tok">
                    </div>
                </div>
            </div>
        </div>

        {{-- Filiais --}}
        <div class="col-12 mb-4">
            <h4 class="page-title">Informações de contato</h4>

            <div class="row">
                <div class="mb-3 col-lg-6 col-12">
                    <label for="name_one" class="form-label">E-mail</label>
                    <input type="text" name="name_one" class="form-control" id="name_one"
                        value="{{ isset($contact)?$contact->name_one:'' }}" placeholder="Título">
                </div>
                <div class="mb-3 col-lg-6 col-12">
                    <label for="phone_one" class="form-label">Telefone</label>
                    <input type="text" name="phone_one" class="form-control" id="phone_one"
                        value="{{ isset($contact)?$contact->phone_one:'' }}" placeholder="Telefone">
                </div>
            </div> 
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {

        function simpleConfig() {
            return {
                // forçar apenas estes botões
                toolbar: [
                    ['Bold', 'Italic', 'Underline']
                ],
                // remover plugins que adicionam elementos extras
                removePlugins: 'elementspath,resize,about,toolbar',
                resize_enabled: false,
                // definir grupos mínimos (ajuda a evitar presets sendo mesclados)
                toolbarGroups: [
                    { name: 'basicstyles', groups: ['basicstyles'] }
                ],
                height: 120
            };
        }

        function initCKEditorOnElement(el) {
            if (!el) return;
            // garante id (CKEDITOR.replace aceita elemento, mas ter id facilita controle)
            if (!el.id) el.id = 'tmp-' + Math.random().toString(36).substr(2,9);

            // destrói qualquer instância existente com esse id (evita herdar config antiga)
            if (CKEDITOR.instances[el.id]) {
                try { CKEDITOR.instances[el.id].destroy(true); }
                catch (e) { /* ignore */ }
            }

            // passa o elemento DOM diretamente para garantir aplicação do config
            CKEDITOR.replace(el, simpleConfig());
        }

        // ao abrir qualquer modal, inicializa textareas .ckeditor dentro dele
        $(document).on('shown.bs.modal', function (e) {
            $(e.target).find('textarea.ckeditor').each(function () {
                initCKEditorOnElement(this);
            });
        });

        // ao fechar, destrói as instâncias para sempre re-criar limpas na próxima abertura
        $(document).on('hidden.bs.modal', function (e) {
            $(e.target).find('textarea.ckeditor').each(function () {
                var id = this.id;
                if (id && CKEDITOR.instances[id]) {
                    try { CKEDITOR.instances[id].destroy(true); }
                    catch (err) { /* ignore */ }
                }
            });
        });

    });

    //Mascara de telefone
document.addEventListener("shown.bs.modal", function (event) {
    // procura o input dentro do modal que abriu
    const phoneInput = event.target.querySelector("#whatsapp");

    if (phoneInput && !phoneInput.dataset.masked) {
        phoneInput.addEventListener("input", function (e) {
            let t = e.target.value.replace(/\D/g, ""); // só dígitos

            // força prefixo 71
            if (!t.startsWith("71")) {
                t = "71" + t;
            }
            if (t.length > 11) t = t.slice(0, 11);

            // aplica máscara (71) 9 9999-9999
            let formatado = "(" + t.slice(0, 2) + ")";
            if (t.length > 2) formatado += " " + t.slice(2, 3);
            if (t.length > 3) formatado += " " + t.slice(3, 7);
            if (t.length > 7) formatado += "-" + t.slice(7);

            e.target.value = formatado;
        });

        // marca como inicializado para não duplicar listeners
        phoneInput.dataset.masked = "true";
    }
});
</script>





