@php
    $textareaId = $textareaId ?? 'text' . (isset($lineOfTime->id) ? $lineOfTime->id : '');
@endphp
<div class="row g-3">
    <div class="mb-3 col-12">
        <label for="title" class="form-label">Título</label>
        <input 
            type="text" 
            name="title" 
            class="form-control" 
            id="title{{ isset($lineOfTime->id) ? $lineOfTime->id : '' }}" 
            value="{{ isset($lineOfTime) ? $lineOfTime->title : '' }}" 
            placeholder="Digite seu nome"
        >
    </div>
</div>

<div class="row">    
    <div class="mb-3 col-12">
        <label for="{{$textareaId}}" class="form-label text-muted">Descrição</label>
        <textarea name="text" id="{{$textareaId}}" placeholder="Texto" class="col-12" rows="10">
            {!!isset($lineOfTime->text)?$lineOfTime->text: ''!!}
        </textarea>
    </div>
</div>

<div class="col-lg-12 mb-3">
    <label for="path_image" class="form-label">Imagem</label>
    <input type="file" name="path_image" data-plugins="dropify" data-default-file="{{isset($lineOfTime)?$lineOfTime->path_image<>''?url('storage/'.$lineOfTime->path_image):'':''}}"  />
    <p class="text-muted text-center mt-2 mb-0">{{__('dashboard.text_img_size')}} <b class="text-danger">2 MB</b>.</p>
</div>

<div class="mb-3 col-12">
    <div class="form-check">
        <input 
            name="active" 
            {{ isset($lineOfTime->active) && $lineOfTime->active == 1 ? 'checked' : '' }} 
            type="checkbox" 
            class="form-check-input" 
            id="invalidCheck{{ isset($lineOfTime->id) ? $lineOfTime->id : '' }}" 
        />
        <label class="form-check-label" for="invalidCheck{{ isset($lineOfTime->id) ? $lineOfTime->id : '' }}">
            {{ __('dashboard.active') }}?
        </label>
        <div class="invalid-feedback">
            You must agree before submitting.
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