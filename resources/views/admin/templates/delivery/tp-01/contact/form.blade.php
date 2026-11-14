@php
    $textareaId = $textareaId ?? 'text' . (isset($contact->id) ? $contact->id : '');
    $weekDays = [
        1 => 'Segunda-feira',
        2 => 'Terça-feira',
        3 => 'Quarta-feira',
        4 => 'Quinta-feira',
        5 => 'Sexta-feira',
        6 => 'Sábado',
        7 => 'Domingo',
    ];
    $openingHoursByDay = collect($openingHours ?? [])->keyBy('day_of_week');
@endphp

<div class="container">
    <div class="row">
        {{-- Redes sociais --}}
        <div class="col-12">
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
                        <label for="link_tik_tok" class="form-label">Link do LinkedIn</label>
                        <input type="text" name="link_tik_tok" class="form-control" id="link_tik_tok"
                            value="{{ $contact->link_tik_tok ?? '' }}" placeholder="Link do LinkedIn">
                    </div>
                </div>
            </div>
        </div>

        {{-- Filiais --}}
        <div class="col-12">
            <h4 class="page-title">Informações de contato</h4>

            <div class="row">
                <div class="mb-3 col-lg-6">
                    <label for="name_one" class="form-label">E-mail</label>
                    <input type="text" name="name_one" class="form-control" id="name_one"
                        value="{{ isset($contact)?$contact->name_one:'' }}" placeholder="E-mail">
                </div>
                <div class="mb-3 col-lg-6">
                    <label for="phone_one" class="form-label">Telefone</label>
                    <input type="text" name="phone_one" class="form-control" id="phone_one"
                        value="{{ isset($contact)?$contact->phone_one:'' }}" placeholder="Telefone">
                </div>
                <div class="col-12">
                    <label for="address_one" class="form-label">Endereço</label>
                    <input type="text" name="address_one" class="form-control" id="address_one"
                        value="{{ isset($contact)?$contact->address_one:'' }}" placeholder="Endereço">
                </div>
            </div> 
        </div>

        <div class="col-12">
            <h4 class="page-title">Horários por dia da semana</h4>
            <div class="card card-body">
                <div class="row g-3">
                    @foreach ($weekDays as $dayOfWeek => $dayLabel)
                        @php
                            $openingHour = $openingHoursByDay->get($dayOfWeek);
                            $isClosed = old(
                                "opening_hours.{$dayOfWeek}.is_closed",
                                (bool) ($openingHour->is_closed ?? false)
                            );
                            $openTime = $openingHour?->open_time
                                ? substr((string) $openingHour->open_time, 0, 5)
                                : '';
                            $closeTime = $openingHour?->close_time
                                ? substr((string) $openingHour->close_time, 0, 5)
                                : '';
                        @endphp
                        <div class="col-12">
                            <div class="row align-items-end g-2">
                                <input type="hidden" name="opening_hours[{{ $dayOfWeek }}][day_of_week]" value="{{ $dayOfWeek }}">
                                <div class="col-12 col-md-3">
                                    <label class="form-label">{{ $dayLabel }}</label>
                                </div>
                                <div class="col-6 col-md-3">
                                    <label for="open-time-{{ $dayOfWeek }}" class="form-label">Abertura</label>
                                    <input
                                        type="time"
                                        name="opening_hours[{{ $dayOfWeek }}][open_time]"
                                        id="open-time-{{ $dayOfWeek }}"
                                        class="form-control"
                                        value="{{ old("opening_hours.{$dayOfWeek}.open_time", $openTime) }}"
                                    >
                                </div>
                                <div class="col-6 col-md-3">
                                    <label for="close-time-{{ $dayOfWeek }}" class="form-label">Fechamento</label>
                                    <input
                                        type="time"
                                        name="opening_hours[{{ $dayOfWeek }}][close_time]"
                                        id="close-time-{{ $dayOfWeek }}"
                                        class="form-control"
                                        value="{{ old("opening_hours.{$dayOfWeek}.close_time", $closeTime) }}"
                                    >
                                </div>
                                <div class="col-12 col-md-3">
                                    <input type="hidden" name="opening_hours[{{ $dayOfWeek }}][is_closed]" value="0">
                                    <div class="form-check">
                                        <input
                                            type="checkbox"
                                            name="opening_hours[{{ $dayOfWeek }}][is_closed]"
                                            id="is-closed-{{ $dayOfWeek }}"
                                            class="form-check-input"
                                            value="1"
                                            @checked($isClosed)
                                        >
                                        <label class="form-check-label" for="is-closed-{{ $dayOfWeek }}">Fechado</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
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





