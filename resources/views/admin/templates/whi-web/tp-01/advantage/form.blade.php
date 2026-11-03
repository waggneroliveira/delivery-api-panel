<div class="row">
    <div class="col-12 col-lg-7">
        <div class="row mb-3">
            <div class="col-lg-8">
                <label for="title" class="form-label">Título</label>
                <input type="text" name="title" class="form-control" id="title{{isset($advantage->id)?$advantage->id:''}}" value="{{isset($advantage)?$advantage->title:''}}" placeholder="Título">
            </div>
            <div class="col-lg-4">
                <label for="tag" class="form-label">Tag</label>
                <input type="text" name="tag" class="form-control" id="tag{{isset($advantage->id)?$advantage->id:''}}" value="{{isset($advantage)?$advantage->tag:''}}" placeholder="Subtítulo">
            </div>
        </div>    
    
        <div class="mb-3">
            <label for="link" class="form-label">Breve Descrição </label>
            <input type="text" name="link" class="form-control" id="link{{isset($advantage->id)?$advantage->id:''}}" value="{{isset($advantage)?$advantage->link:''}}" placeholder="Breve Descrição">
        </div>
        
        <div class="mb-3 col-12 d-flex align-items-start flex-column">
            <label for="textarea-text" class="form-label">Texto</label>
    
            <textarea
                name="text"
                class="form-control ck-editor"
                id="textarea-text"
                rows="5"
            >{!! old('text', $advantage->text ?? '') !!}</textarea>
        </div>
        <div class="mb-3">
            <div class="form-check">
                <input name="active" {{ isset($advantage->active) && $advantage->active == 1 ? 'checked' : '' }} type="checkbox" class="form-check-input" id="invalidCheck{{isset($advantage->id)?$advantage->id:''}}" />
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
                    <input type="file" name="path_image" data-plugins="dropify" data-default-file="{{isset($advantage)?$advantage->path_image<>''?url('storage/'.$advantage->path_image):'':''}}"  />
                    <p class="text-muted text-center mt-2 mb-0">{{__('dashboard.text_img_size')}} <b class="text-danger">2 MB</b>.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {

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
                            'NumberedList',
                            'BulletedList',
                        ]
                    },
                    {
                        name: 'links',
                        items: ['Link', 'Unlink']
                    },
                ],
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
</style>