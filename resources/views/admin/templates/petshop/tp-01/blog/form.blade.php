<div class="col-12 col-lg-6">
    <div class="row">
        <div class="mb-3 col-12 col-lg-6 d-flex align-items-start flex-column">
            <label for="category-select" class="form-label">Categoria(s) <span class="text-danger">*</span></label>
            @php
                $currentCategory = isset($blog) ? $blog->blog_category_id : null;
            @endphp
        
            <select name="blog_category_id" class="form-select" id="category-select" required>
                <option value="" disabled selected>Selecione o Cliente</option>
                @foreach ($blogCategory as $categoryValue => $categoryLabel)
                    <option value="{{ $categoryValue }}" {{ $categoryValue == $currentCategory ? 'selected' : '' }}>
                        {{ $categoryLabel }}
                    </option>
                @endforeach
            </select>
        </div>
        
        <div class="mb-3 col-12 col-lg-6">
            <label for="date" class="form-label">Data de publicação <span class="text-danger">*</span></label>
            <input type="date" name="date" class="form-control" id="date{{isset($blog->id)?$blog->id:''}}" value="{{isset($blog)?$blog->date->format('Y-m-d'):''}}" required>
        </div>
    </div>
    
    <div class="mb-3 col-12">
        <label for="title" class="form-label">Título <span class="text-danger">*</span></label>
        <input type="text" name="title" class="form-control" id="title{{isset($blog->id)?$blog->id:''}}" value="{{isset($blog)?$blog->title:''}}" required placeholder="Digite seu nome">
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
    
    <div class="mb-3">
        <div class="form-check">
            <input name="active" {{ isset($blog->active) && $blog->active == 1 ? 'checked' : '' }} type="checkbox" class="form-check-input" id="invalidCheck{{isset($blog->id)?$blog->id:''}}" />
            <label class="form-check-label" for="invalidCheck">{{__('dashboard.active')}}?</label>
            <div class="invalid-feedback">
                You must agree before submitting.
            </div>
        </div>

        <div class="form-check">
            <input name="highlight" {{ isset($blog->highlight) && $blog->highlight == 1 ? 'checked' : '' }} type="checkbox" class="form-check-input" id="invalidCheck3{{isset($blog->id)?$blog->id:''}}" />
            <label class="form-check-label" for="invalidCheck3{{isset($blog->id)?$blog->id:''}}">Destaque?</label>
            <div class="invalid-feedback">
                You must agree before submitting.
            </div>
        </div>
    </div>
</div>

<div class="col-12 col-lg-6">
    <div class="row">
        <div class="col-12 mb-3">
            <div class="mt-3">
                <label for="path_image_thumbnail" class="form-label">Imagem de capa</label>
                <input type="file" name="path_image_thumbnail" data-plugins="dropify" data-default-file="{{isset($blog)?$blog->path_image_thumbnail<>''?url('storage/'.$blog->path_image_thumbnail):'':''}}"  />
                <p class="text-muted text-center mt-2 mb-0">{{__('dashboard.text_img_size')}} <b class="text-danger">2 MB</b>.</p>
            </div>
        </div>
        
        <div class="col-12">
            <div class="mt-3">
                <label for="path_image" class="form-label">Imagem</label>
                <input type="file" name="path_image" data-plugins="dropify" data-default-file="{{isset($blog)?$blog->path_image<>''?url('storage/'.$blog->path_image):'':''}}"  />
                <p class="text-muted text-center mt-2 mb-0">{{__('dashboard.text_img_size')}} <b class="text-danger">2 MB</b>.</p>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        const uploadUrl = "{{ route('admin.dashboard.blog.uploadImageCkeditor') }}";
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
                            'Strike'
                        ]
                    },
                    {
                        name: 'paragraph',
                        items: [
                            'NumberedList',
                            'BulletedList'
                        ]
                    },
                    {
                        name: 'links',
                        items: ['Link', 'Unlink']
                    },
                    {
                        name: 'insert',
                        items: ['Image', 'Table']
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
</style>