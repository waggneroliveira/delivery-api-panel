@php
    $textareaId = $textareaId ?? 'description' . (isset($statute->id) ? $statute->id : '');
@endphp
<div class="row g-3">
    <div class="mb-3 col-12">
        <label for="title" class="form-label">Título</label>
        <input 
            type="text" 
            name="title" 
            class="form-control" 
            id="title{{ isset($serviceLocation->id) ? $serviceLocation->id : '' }}" 
            value="{{ isset($serviceLocation) ? $serviceLocation->title : '' }}" 
            placeholder="Digite seu nome"
        >
    </div>
</div>
<div class="row">    
    <div class="mb-3 col-12">
        <label for="{{$textareaId}}" class="form-label text-white">Descrição</label>
        <textarea name="description" id="{{$textareaId}}" placeholder="Texto" class="col-12" rows="10">
            {!!isset($serviceLocation->description)?$serviceLocation->description: ''!!}
        </textarea>
    </div>
</div>

<div class="col-lg-12 mb-3">
    <label for="path_image" class="form-label">Imagem</label>
    <input type="file" name="path_image" data-plugins="dropify" data-default-file="{{isset($serviceLocation)?$serviceLocation->path_image<>''?url('storage/'.$serviceLocation->path_image):'':''}}"  />
    <p class="text-muted text-center mt-2 mb-0">{{__('dashboard.text_img_size')}} <b class="text-danger">2 MB</b>.</p>
</div>

<div class="mb-3 col-12">
    <div class="form-check">
        <input 
            name="active" 
            {{ isset($serviceLocation->active) && $serviceLocation->active == 1 ? 'checked' : '' }} 
            type="checkbox" 
            class="form-check-input" 
            id="invalidCheck{{ isset($serviceLocation->id) ? $serviceLocation->id : '' }}" 
        />
        <label class="form-check-label" for="invalidCheck{{ isset($serviceLocation->id) ? $serviceLocation->id : '' }}">
            {{ __('dashboard.active') }}?
        </label>
        <div class="invalid-feedback">
            You must agree before submitting.
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        if (document.getElementById("{{$textareaId}}")) {
            CKEDITOR.replace("{{$textareaId}}");
        }
    });
</script>
