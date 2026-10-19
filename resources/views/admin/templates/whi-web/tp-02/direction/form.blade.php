@php
    $textareaId = $textareaId ?? 'description' . (isset($direction->id) ? $direction->id : '');
@endphp
<div class="mb-3">
    <label for="title" class="form-label">Título</label>
    <input type="text" name="title" class="form-control" id="title{{isset($direction->id)?$direction->id:''}}" value="{{isset($direction)?$direction->title:''}}" placeholder="Digite seu nome">
</div>
<div class="mb-3">
    <label for="function" class="form-label">Função/cargo</label>
    <input type="text" name="function" class="form-control" id="function{{isset($direction->id)?$direction->id:''}}" value="{{isset($direction)?$direction->function:''}}" placeholder="Função/cargo">
</div>
<div class="mb-3">
    <label for="instagram" class="form-label">Link Instagram</label>
    <input type="text" name="instagram" class="form-control" id="instagram{{isset($direction->id)?$direction->id:''}}" value="{{isset($direction)?$direction->instagram:''}}" placeholder="Link Instagram">
</div>
<div class="mb-3">
    <label for="linkedin" class="form-label">Link linkedin</label>
    <input type="text" name="linkedin" class="form-control" id="linkedin{{isset($direction->id)?$direction->id:''}}" value="{{isset($direction)?$direction->linkedin:''}}" placeholder="Link linkedin">
</div>
<div class="mb-3">
    <label for="facebook" class="form-label">Link facebook</label>
    <input type="text" name="facebook" class="form-control" id="facebook{{isset($direction->id)?$direction->id:''}}" value="{{isset($direction)?$direction->facebook:''}}" placeholder="Link facebook">
</div>

{{-- <div class="row mb-3">
    <div class="col-12 col-lg-7">
        <label for="email" class="form-label">E-mail</label>
        <input type="mail" name="email" class="form-control" id="email{{isset($direction->id)?$direction->id:''}}" value="{{isset($direction)?$direction->email:''}}" placeholder="Digite o e-mail">
    </div>
    <div class="col-12 col-lg-5">
        <label for="whatsapp" class="form-label">Whatsapp</label>
        <input 
            type="text" 
            name="whatsapp" 
            class="form-control whatsapp-mask" 
            id="whatsapp{{isset($direction->id)?$direction->id:''}}" 
            value="{{isset($direction)?$direction->whatsapp:''}}" 
            placeholder="(11) 91234-5678">
    </div>
</div> --}}
<div class="mb-3 col-12 col-lg-12">
    <label for="{{$textareaId}}" class="form-label text-white">Texto</label>
    <textarea name="description" id="{{$textareaId}}" placeholder="Texto" class="col-12" rows="10">
        {!!isset($direction->description)?$direction->description: ''!!}
    </textarea>
</div>
<div class="col-12">
    <div class="mt-3">
        <label for="path_image" class="form-label">Imagem</label>
        <input type="file" name="path_image" data-plugins="dropify" data-default-file="{{isset($direction)?$direction->path_image<>''?url('storage/'.$direction->path_image):'':''}}"  />
        <p class="text-muted text-center mt-2 mb-0">{{__('dashboard.text_img_size')}} <b class="text-danger">2 MB</b>.</p>
    </div>
</div> 
<div class="mb-3">
    <div class="form-check">
        <input name="active" {{ isset($direction->active) && $direction->active == 1 ? 'checked' : '' }} type="checkbox" class="form-check-input" id="invalidCheck{{isset($direction->id)?$direction->id:''}}" />
        <label class="form-check-label" for="invalidCheck">{{__('dashboard.active')}}?</label>
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

<style>
    #cke_description{
        width: 100%;
    }
</style>