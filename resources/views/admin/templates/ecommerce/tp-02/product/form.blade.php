<div class="col-12 col-lg-6">
    <div class="row">
        <div class="mb-3 col-12 col-lg-6 d-flex align-items-start flex-column">
            <label for="category-select" class="form-label">Categoria(s) <span class="text-danger">*</span></label>
            @php
                $currentCategory = isset($product) ? $product->product_category_id : null;
            @endphp
        
            <select name="product_category_id" class="form-select" id="category-select" required>
                <option value="" disabled selected>Selecione o Cliente</option>
                @foreach ($productCategory as $categoryValue => $categoryLabel)
                    <option value="{{ $categoryValue }}" {{ $categoryValue == $currentCategory ? 'selected' : '' }}>
                        {{ $categoryLabel }}
                    </option>
                @endforeach
            </select>
        </div>
        
        <div class="mb-3 col-6 d-flex align-items-start flex-column">
            <label for="brand-select" class="form-label">Marca(s) <span class="text-danger">*</span></label>
            @php
                $currentBrand = isset($product) ? $product->brand_id : null;
            @endphp

            <select name="brand_id" class="form-select" id="brand-select" required>
                <option value="" disabled selected>Selecione a Marca</option>
                @foreach ($productBrand as $brandValue => $brandLabel)
                    <option value="{{ $brandValue }}" {{ $brandValue == $currentBrand ? 'selected' : '' }}>
                        {{ $brandLabel }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="mb-3 col-12 col-lg-12">
        <label for="title" class="form-label">Título <span class="text-danger">*</span></label>
        <input type="text" name="title" class="form-control" id="title{{isset($product->id)?$product->id:''}}" value="{{isset($product)?$product->title:''}}" required placeholder="Digite seu nome">
    </div>
    
    <div class="mb-3 col-12">
        <label for="sizes" class="form-label">Tamanhos do produto</label>
        
        <div id="sizes-wrapper" class="mb-3 d-flex">
            @if(isset($product) && $product->sizes)
                @php
                    // Decodifica o JSON para array
                    $sizesArray = is_string($product->sizes) ? json_decode($product->sizes, true) : $product->sizes;
                @endphp
                
                @if(!empty($sizesArray))
                    @foreach($sizesArray as $size)
                        <div class="d-flex mb-2 size-item">
                            <input type="text" 
                                class="form-control me-2" 
                                name="sizes[]" 
                                value="{{ $size }}" 
                                placeholder="Ex: 1kg">
                            <button type="button" 
                                    class="btn btn-outline-danger remove-size" 
                                    onclick="this.closest('.size-item').remove()">
                                ×
                            </button>
                        </div>
                    @endforeach
                @else
                    <!-- Se decodificou mas está vazio -->
                    <div class="d-flex mb-2 size-item">
                        <input type="text" 
                            class="form-control me-2" 
                            name="sizes[]" 
                            placeholder="Ex: 1kg">
                        <button type="button" 
                                class="btn btn-outline-danger remove-size" 
                                onclick="this.closest('.size-item').remove()">
                            ×
                        </button>
                    </div>
                @endif
            @else
                <!-- Create: Apenas um campo vazio -->
                <div class="d-flex mb-2 size-item">
                    <input type="text" 
                        class="form-control me-2" 
                        name="sizes[]" 
                        placeholder="Ex: 1kg">
                    <button type="button" 
                            class="btn btn-outline-danger remove-size" 
                            onclick="this.closest('.size-item').remove()">
                        ×
                    </button>
                </div>
            @endif
        </div>

        <button type="button" class="btn btn-primary" onclick="addSize()">
            + Adicionar tamanho
        </button>
    </div>

    <script>
        function addSize() {
            const wrapper = document.getElementById('sizes-wrapper')
            
            const div = document.createElement('div')
            div.className = 'd-flex mb-2 size-item'
            
            const input = document.createElement('input')
            input.type = 'text'
            input.name = 'sizes[]'
            input.placeholder = 'Ex: 5kg'
            input.className = 'form-control me-2'
            
            const button = document.createElement('button')
            button.type = 'button'
            button.className = 'btn btn-outline-danger'
            button.innerHTML = '×'
            button.onclick = function() {
                div.remove() // ou wrapper.removeChild(div)
            }
            
            div.appendChild(input)
            div.appendChild(button)
            wrapper.appendChild(div)
        }
    </script>
    <div class="mb-3">
        <label for="link" class="form-label">Link</label>
        <input type="text" name="link" value="{{isset($product)?$product->link:''}}" class="form-control" id="link" placeholder="Link">
    </div>
    
    <div class="mb-3">
        <label for="description" class="form-label">Breve descrição <span class="text-danger">*</span></label>
        <input type="text" name="description" value="{{isset($product)?$product->description:''}}" class="form-control" id="description" placeholder="Digite uma breve descrição" required>
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
        <div class="form-check">
            <input name="active" {{ isset($product->active) && $product->active == 1 ? 'checked' : '' }} type="checkbox" class="form-check-input" id="invalidCheck{{isset($product->id)?$product->id:''}}" />
            <label class="form-check-label" for="invalidCheck">{{__('dashboard.active')}}?</label>
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
                <label for="path_image" class="form-label">Imagem de capa</label>
                <input type="file" name="path_image" accept=".jpg,.jpeg,.png" data-plugins="dropify" data-default-file="{{isset($product)?$product->path_image<>''?url('storage/'.$product->path_image):'':''}}"  />
                <p class="text-muted text-center mt-2 mb-0">{{__('dashboard.text_img_size')}} <b class="text-danger">2 MB</b>.</p>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        const uploadUrl = "{{ route('admin.dashboard.product.uploadImageCkeditor') }}";
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
                            'Subscript',
                            'Superscript'
                        ]
                    },
                    {
                        name: 'paragraph',
                        items: [
                            'NumberedList',
                            'BulletedList',
                            'JustifyBlock'
                        ]
                    },
                    {
                        name: 'links',
                        items: ['Link', 'Unlink']
                    },
                    {
                        name: 'insert',
                        items: ['Image', 'Table', 'HorizontalRule', 'SpecialChar']
                    },
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
