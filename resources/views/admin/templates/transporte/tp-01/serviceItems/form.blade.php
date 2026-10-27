@php
    $textareaId = $textareaId ?? 'text' . (isset($serviceItem->id) ? $serviceItem->id : '');
    $titleInputId = 'title' . (isset($serviceItem->id) ? $serviceItem->id : '');
@endphp

<div class="d-flex justify-content-between">
    <div class="row col-lg-6">
        <div class="mb-3">
            <label for="title" class="form-label">Título </label>
            <input type="text" name="title" class="form-control" id="{{$titleInputId}}" value="{{isset($serviceItem)?$serviceItem->title:''}}" placeholder="Título">
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Descrição breve </label>
            <input type="text" name="description" class="form-control" id="description{{isset($serviceItem->id)?$serviceItem->id:''}}" value="{{isset($serviceItem)?$serviceItem->description:''}}" placeholder="Descrição">
        </div>

        <div class="row">
            <div class="col-12 col-md-6 mb-3">
                <label for="action_type{{ isset($serviceItem->id) ? $serviceItem->id : '' }}" class="form-label">
                    Ação do botão
                </label>

                <select
                    name="action_type"
                    id="action_type{{ isset($serviceItem->id) ? $serviceItem->id : '' }}"
                    class="form-select action-type"
                >
                    <option value="">Selecione uma ação</option>

                    <option
                        value="link"
                        {{ isset($serviceItem) && !empty($serviceItem->link) ? 'selected' : '' }}
                    >
                        Link
                    </option>

                    {{-- <option
                        value="scroll"
                        {{ isset($serviceItem) && $serviceItem->scroll_section === 'contato' ? 'selected' : '' }}
                    >
                        Rolar para Contato
                    </option> --}}
                </select>
            </div>

            <div class="col-12 col-md-6 mb-3 link-field d-none">
                <label for="link{{ isset($serviceItem->id) ? $serviceItem->id : '' }}" class="form-label">
                    Link
                </label>

                <input
                    type="url"
                    name="link"
                    id="link{{ isset($serviceItem->id) ? $serviceItem->id : '' }}"
                    class="form-control"
                    value="{{ isset($serviceItem) ? $serviceItem->link : '' }}"
                    placeholder="https://exemplo.com"
                >
            </div>

            <input
                type="hidden"
                name="scroll_section"
                value="{{ isset($serviceItem) ? $serviceItem->scroll_section : '' }}"
                class="scroll-section-input"
            >
        </div>

        <div class="row">    
            <div class="mb-3 col-12">
                <label for="{{$textareaId}}" class="form-label text-white">Texto</label>
                <textarea name="text" id="{{$textareaId}}" placeholder="Texto" class="col-12" rows="10">
                    {!!isset($serviceItem->text)?$serviceItem->text: ''!!}
                </textarea>
            </div>
        </div>
        
        <div class="mb-3">
            <div class="form-check">
                <input name="active" {{ isset($serviceItem->active) && $serviceItem->active == 1 ? 'checked' : '' }} type="checkbox" class="form-check-input" id="invalidCheck{{isset($serviceItem->id)?$serviceItem->id:''}}" />
                <label class="form-check-label" for="invalidCheck">{{__('dashboard.active')}}?</label>
                <div class="invalid-feedback">
                    You must agree before submitting.
                </div>
            </div>
        </div>
    </div>
    
    <div class="row col-lg-6">
        <div class="col-lg-12">
            <div class="mt-3">
                <label for="title" class="form-label">Icone </label>
                <input type="file" name="path_icon" data-plugins="dropify" data-default-file="{{isset($serviceItem)?$serviceItem->path_icon<>''?url('storage/'.$serviceItem->path_icon):'':''}}"  />
                <p class="text-muted text-center mt-2 mb-0">{{__('dashboard.text_img_size')}} <b class="text-danger">2 MB</b>.</p>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="mt-3">
                <label for="title" class="form-label">Imagem </label>
                <input type="file" name="path_image" data-plugins="dropify" data-default-file="{{isset($serviceItem)?$serviceItem->path_image<>''?url('storage/'.$serviceItem->path_image):'':''}}"  />
                <p class="text-muted text-center mt-2 mb-0">{{__('dashboard.text_img_size')}} <b class="text-danger">2 MB</b>.</p>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const textareaId = "{{$textareaId}}";

        if (document.getElementById(textareaId)) {
            CKEDITOR.replace(textareaId, {
                toolbar: [
                    { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline'] },
                ],
                height: 200
            });
        }
    });

</script>

{{-- <script>
    document.addEventListener('change', function (event) {

        if (!event.target.classList.contains('action-type')) {
            return;
        }

        const select = event.target;
        const container = select.closest('.modal, form, .row');

        if (!container) {
            return;
        }

        const linkField = container.querySelector('.link-field');
        const scrollField = container.querySelector('.scroll-field');

        const linkInput = linkField?.querySelector('input[name="link"]');
        const scrollInput = scrollField?.querySelector('input[name="scroll_section"]');

        if (!linkField || !scrollField) {
            return;
        }

        /*
         * LINK
         */
        if (select.value === 'link') {

            linkField.classList.remove('d-none');
            scrollField.classList.add('d-none');

            // Limpa o scroll para garantir apenas uma opção
            if (scrollInput) {
                scrollInput.value = '';
            }

        /*
         * SCROLL
         */
        } else if (select.value === 'scroll') {

            scrollField.classList.remove('d-none');
            linkField.classList.add('d-none');

            // Limpa o link para garantir apenas uma opção
            if (linkInput) {
                linkInput.value = '';
            }

        /*
         * NENHUMA OPÇÃO
         */
        } else {

            linkField.classList.add('d-none');
            scrollField.classList.add('d-none');

            if (linkInput) {
                linkInput.value = '';
            }

            if (scrollInput) {
                scrollInput.value = '';
            }
        }
    });


    /*
     * Inicializa o estado dos campos quando o modal de edição é aberto
     */
    document.addEventListener('shown.bs.modal', function (event) {

        const modal = event.target;
        const select = modal.querySelector('.action-type');

        if (!select) {
            return;
        }

        const linkField = modal.querySelector('.link-field');
        const scrollField = modal.querySelector('.scroll-field');

        const linkInput = linkField?.querySelector('input[name="link"]');
        const scrollInput = scrollField?.querySelector('input[name="scroll_section"]');

        if (!linkField || !scrollField) {
            return;
        }

        /*
         * Se já existe LINK
         */
        if (linkInput && linkInput.value.trim() !== '') {

            select.value = 'link';

            linkField.classList.remove('d-none');
            scrollField.classList.add('d-none');

        /*
         * Se já existe SCROLL
         */
        } else if (scrollInput && scrollInput.value.trim() !== '') {

            select.value = 'scroll';

            scrollField.classList.remove('d-none');
            linkField.classList.add('d-none');

        /*
         * Nenhum dos dois
         */
        } else {

            select.value = '';

            linkField.classList.add('d-none');
            scrollField.classList.add('d-none');
        }
    });
</script> --}}

<script>
    document.addEventListener('change', function (event) {

        if (!event.target.classList.contains('action-type')) {
            return;
        }

        const select = event.target;
        const container = select.closest('.modal, form, .row');

        if (!container) {
            return;
        }

        const linkField = container.querySelector('.link-field');
        const linkInput = container.querySelector('input[name="link"]');
        const scrollInput = container.querySelector('.scroll-section-input');

        if (!linkField || !linkInput || !scrollInput) {
            return;
        }

        if (select.value === 'link') {

            linkField.classList.remove('d-none');

            linkInput.focus();

            // Remove o scroll
            scrollInput.value = '';

        } else if (select.value === 'scroll') {

            linkField.classList.add('d-none');

            // Remove o link
            linkInput.value = '';

            // Define Contato automaticamente
            scrollInput.value = 'contato';

        } else {

            linkField.classList.add('d-none');

            linkInput.value = '';
            scrollInput.value = '';
        }
    });


    /*
     * Inicializa o formulário de edição
     */
    document.addEventListener('shown.bs.modal', function (event) {

        const modal = event.target;
        const select = modal.querySelector('.action-type');

        if (!select) {
            return;
        }

        const linkField = modal.querySelector('.link-field');
        const linkInput = modal.querySelector('input[name="link"]');
        const scrollInput = modal.querySelector('.scroll-section-input');

        if (!linkField || !linkInput || !scrollInput) {
            return;
        }

        if (linkInput.value.trim() !== '') {

            select.value = 'link';
            linkField.classList.remove('d-none');

        } else if (scrollInput.value === 'contato') {

            select.value = 'scroll';
            linkField.classList.add('d-none');

        } else {

            select.value = '';
            linkField.classList.add('d-none');
        }
    });
</script>