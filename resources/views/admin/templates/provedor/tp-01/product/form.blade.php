<div class="d-flex justify-content-between">
    <div class="row col-lg-12">
        <div class="mb-3">
            <label for="title" class="form-label">Título </label>
            <input type="text" name="title" class="form-control" id="title" value="{{isset($product)?$product->title:''}}" placeholder="Título">
        </div>       

        <div class="mb-3 col-12">
            <label for="price" class="form-label">Preço</label>
            <input type="text" name="price" class="form-control price-mask" id="price{{isset($product->id)?$product->id:''}}" value="{{ isset($product) ? number_format($product->price, 2, ',', '.') : '' }}" placeholder="Preço">
        </div>

        <div class="mb-3 col-12 d-flex align-items-start flex-column">
            <label for="textarea-text" class="form-label">Texto</label>

            <textarea
                name="text"
                class="form-control ck-editor"
                id="textarea-text"
                rows="5"
            >{!! old('text', $product->text ?? '') !!}</textarea>
        </div>
        
        <div class="mb-3">
            <label for="title" class="form-label">Imagem </label>
            <input type="file" name="path_image" data-plugins="dropify" data-default-file="{{isset($product)?$product->path_image<>''?url('storage/'.$product->path_image):'':''}}"  />
            <p class="text-muted text-center mt-2 mb-0">{{__('dashboard.text_img_size')}} <b class="text-danger">2 MB</b>.</p>
        </div>

        <div class="mb-3">
            <div class="form-check">
                <input name="active" {{ isset($product->active) && $product->active == 1 ? 'checked' : '' }} type="checkbox" class="form-check-input" id="invalidCheck{{isset($product->id)?$product->id:''}}" />
                <label class="form-check-label" for="invalidCheck">{{__('dashboard.active')}}?</label>
                <div class="invalid-feedback">
                    You must agree before submitting.
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .cke_chrome{
        width: 100%;
    }
</style>
    

<script>
    document.addEventListener('DOMContentLoaded', function () {

        const uploadUrl = "{{ route('admin.dashboard.product.uploadImageCkeditor') }}";
        const csrfToken = "{{ csrf_token() }}";

        function getEditorConfig(readOnly = false) {
            return {
                allowedContent: true,
                readOnly: readOnly,

                toolbar: [
                    { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript'] },
                    { name: 'tools', items: ['Maximize'] }
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
