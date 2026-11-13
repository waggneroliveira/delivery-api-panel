<div class="col-12 col-lg-7">
    <div class="row mb-3">
        <div class="col-lg-6">
            <label for="title" class="form-label">Título</label>
            <input type="text" name="title" class="form-control" id="title{{isset($about->id)?$about->id:''}}" value="{{isset($about)?$about->title:''}}" placeholder="Título">
        </div>
        <div class="col-lg-6">
            <label for="subtitle" class="form-label">Subtitulo</label>
            <input type="text" name="subtitle" class="form-control" id="subtitle{{isset($about->id)?$about->id:''}}" value="{{isset($about)?$about->subtitle:''}}" placeholder="Subtítulo">
        </div>
    </div>

    <div class="col-12 col-lg-12 mb-3">
        <label for="link" class="form-label">Link</label>
        <input type="text" name="link" class="form-control" id="link{{isset($about->id)?$about->id:''}}" value="{{isset($about)?$about->link:''}}" placeholder="Link">
    </div>

    <div class="mb-3 col-12 d-flex align-items-start flex-column">
        <label for="textarea-text" class="form-label">Texto</label>

        <textarea
            name="text"
            class="form-control ck-editor"
            id="textarea-text"
            rows="5"
        >{!! old('text', $about->text ?? '') !!}</textarea>
    </div>
    <div class="card mb-1">
        <div class="card-header" id="headingTen">
            <h5 class="m-0 position-relative">
                <a
                    class="custom-accordion-title text-reset d-block collapsed"
                    data-bs-toggle="collapse"
                    href="#collapseAbout"
                    aria-expanded="false"
                    aria-controls="collapseAbout"
                >
                    <i class="mdi mdi-help-circle me-1 text-dark"></i>
                    Como estruturar texto para ficar igual ao layout
                    <i class="mdi mdi-chevron-down accordion-arrow"></i>
                </a>
            </h5>
        </div>

        <div
            id="collapseAbout"
            class="collapse"
            aria-labelledby="headingAbout"
            data-bs-parent="#custom-accordion-one"
        >
            <div class="card-body">
                <p>
                    Para criar os itens desta seção, siga o padrão abaixo:
                </p>

                <ul>
                    <li>
                        <i class="mdi mdi-image me-1"></i>
                        Adicione a imagem pelo CMS de texto, utilizando o botão de <strong>imagem</strong>.
                    </li>

                    <li>
                        <i class="mdi mdi-format-bold me-1"></i>
                        Informe o título em <strong>negrito</strong> no CMS de texto, utilizando o botão <strong>B</strong>.
                    </li>

                    <li>
                        <i class="mdi mdi-format-list-bulleted me-1"></i>
                        Cada novo item deve ser iniciado em uma nova linha da listagem.
                    </li>

                    <li>
                        Na linha seguinte, informe a descrição do item.
                    </li>

                    <li>
                        Separe cada item com uma linha em branco.
                    </li>
                </ul>

                <p><strong>Exemplo de estrutura no CMS:</strong></p>

                <pre>[image] **Nossa Missão**
                Lorem ipsum is simply dummy text of the priting and typesetting

                [image] **Nossa Visão**
                Lorem ipsum is simply dummy text of the priting and typesetting</pre>
            </div>
        </div>
    </div>
    <div class="mb-3">
        <div class="form-check">
            <input name="active" {{ isset($about->active) && $about->active == 1 ? 'checked' : '' }} type="checkbox" class="form-check-input" id="invalidCheck{{isset($about->id)?$about->id:''}}" />
            <label class="form-check-label" for="invalidCheck">{{__('dashboard.active')}}?</label>
            <div class="invalid-feedback">
                You must agree before submitting.
            </div>
        </div>
    </div>
</div>

<div class="col-12 col-lg-5">
    <div class="row">
        <div class="col-12">
            <div class="mt-3">
                <label for="path_image" class="form-label">Imagem</label>
                <input type="file" name="path_image" data-plugins="dropify" data-default-file="{{isset($about)?$about->path_image<>''?url('storage/'.$about->path_image):'':''}}"  />
                <p class="text-muted text-center mt-2 mb-0">{{__('dashboard.text_img_size')}} <b class="text-danger">2 MB</b>.</p>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        const uploadUrl = "{{ route('admin.dashboard.about.uploadImageCkeditorAbout') }}";
        const csrfToken = "{{ csrf_token() }}";

        function getEditorConfig(readOnly = false) {
            return {
                allowedContent: true,
                readOnly: readOnly,

                toolbar: [
                    {
                        name: 'basicstyles',
                        items: [
                            'Bold',
                            'Italic',
                            'Underline',
                            'Strike',
                        ]
                    },
                    {
                        name: 'paragraph',
                        items: [
                            'BulletedList',
                        ]
                    },
                    {
                        name: 'links',
                        items: ['Link', 'Unlink']
                    },
                    {
                        name: 'insert',
                        items: ['Image']
                    },
                    {
                        name: 'tools',
                        items: ['Maximize']
                    }
                ],

                filebrowserUploadUrl: uploadUrl,

                // Mantive exatamente como funcionava no seu Edit
                fileTools_requestHeaders: {
                    'X-CSRF-TOKEN': csrfToken
                }
            };
        }

        // Editores de Create/Edit
        document.querySelectorAll('.ck-editor').forEach(function (element) {

            if (!element.id) {
                console.error('Textarea CKEditor sem ID:', element);
                return;
            }

            if (CKEDITOR.instances[element.id]) {
                CKEDITOR.instances[element.id].destroy(true);
            }

            CKEDITOR.replace(element.id, getEditorConfig(false));
        });

        // Editores somente leitura (Index)
        document.querySelectorAll('.ck-readonly').forEach(function (element) {

            if (!element.id) {
                console.error('Textarea CKEditor sem ID:', element);
                return;
            }

            if (CKEDITOR.instances[element.id]) {
                CKEDITOR.instances[element.id].destroy(true);
            }

            CKEDITOR.replace(element.id, getEditorConfig(true));
        });

    });
</script>

<style>
    #cke_textarea-text{
        width: 100%;
    }
    pre {
        white-space: pre-line;
        margin-left: 0;
        padding-left: 0;
    }
</style>