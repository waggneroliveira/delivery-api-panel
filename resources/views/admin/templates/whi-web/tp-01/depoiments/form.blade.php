@php
    $textareaId = $textareaId ?? 'description' . (isset($depoiment->id) ? $depoiment->id : '');
@endphp

<div class="d-flex justify-content-between">
    <div class="row col-12">
        <div class="mb-3 col-12 col-lg-6">
            <label for="name" class="form-label">Nome </label>
            <input type="text" name="name" class="form-control" id="{{isset($depoiment)?$depoiment->id:''}}" value="{{isset($depoiment)?$depoiment->name:''}}" placeholder="Nome">
        </div>
        
        <div class="mb-3 col-12 col-lg-6">
            <label for="function" class="form-label">Função/Cargo </label>
            <input type="text" name="function" class="form-control" id="function{{isset($depoiment->id)?$depoiment->id:''}}" value="{{isset($depoiment)?$depoiment->function:''}}" placeholder="Função/Cargo">
        </div>

        <div class="mb-3 col-12 col-lg-6">
            <label for="{{$textareaId}}" class="form-label text-white">Texto</label>
            <textarea name="text" id="{{$textareaId}}" placeholder="Texto" class="col-12" rows="10">
                {!!isset($depoiment->text)?$depoiment->text: ''!!}
            </textarea>
        </div>

        <div class="mb-3 col-12 col-lg-6">
            <label for="path_image" class="form-label">Imagem </label>
            <input type="file" name="path_image" data-plugins="dropify" data-default-file="{{isset($depoiment)?$depoiment->path_image<>''?url('storage/'.$depoiment->path_image):'':''}}"  />
            <p class="text-muted text-center mt-2 mb-0">{{__('dashboard.text_img_size')}} <b class="text-danger">2 MB</b>.</p>
        </div>
        
        <div class="mb-3">
            <div class="form-check">
                <input name="active" {{ isset($depoiment->active) && $depoiment->active == 1 ? 'checked' : '' }} type="checkbox" class="form-check-input" id="invalidCheck{{isset($depoiment->id)?$depoiment->id:''}}" />
                <label class="form-check-label" for="invalidCheck">{{__('dashboard.active')}}?</label>
                <div class="invalid-feedback">
                    You must agree before submitting.
                </div>
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