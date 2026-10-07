@php
    $textareaId = $textareaId ?? 'description' . (isset($depoiment->id) ? $depoiment->id : '');
@endphp

<div class="d-flex justify-content-between">
    <div class="row col-lg-12">
        <div class="mb-3 col-lg-6">
            <label for="name" class="form-label">Nome </label>
            <input type="text" name="name" class="form-control" id="{{isset($depoiment)?$depoiment->id:''}}" value="{{isset($depoiment)?$depoiment->name:''}}" placeholder="Nome">
        </div>
        
        <div class="mb-3 col-lg-6">
            <label for="function" class="form-label">Tempo como cliente </label>
            <input type="text" name="function" class="form-control" id="function{{isset($depoiment->id)?$depoiment->id:''}}" value="{{isset($depoiment)?$depoiment->function:''}}" placeholder="Função/Cargo">
        </div>
        
        <div class="row">    
            <div class="mb-3 col-12">
                <label for="{{$textareaId}}" class="form-label text-white">Texto</label>
                <textarea name="text" id="{{$textareaId}}" placeholder="Texto" class="col-12" rows="10">
                    {!!isset($depoiment->text)?$depoiment->text: ''!!}
                </textarea>
            </div>
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