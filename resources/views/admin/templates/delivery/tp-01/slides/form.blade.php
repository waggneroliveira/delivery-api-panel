@php
    $textareaId = $textareaId ?? 'description' . (isset($slide->id) ? $slide->id : '');
    $titleInputId = 'title' . (isset($slide->id) ? $slide->id : '');
@endphp

<div class="d-flex justify-content-between">
    <div class="row col-lg-6">
        <div class="mb-3">
            <label for="title" class="form-label">Título </label>
            <input type="text" name="title" class="form-control" id="{{$titleInputId}}" value="{{isset($slide)?$slide->title:''}}" placeholder="Título">
        </div>

        <div class="mb-3">
            <label for="subtitle" class="form-label">Subtítulo </label>
            <input type="text" name="subtitle" class="form-control" id="subtitle{{isset($slide->id)?$slide->id:''}}" value="{{isset($slide)?$slide->subtitle:''}}" placeholder="Subtítulo">
        </div>

        <div class="mb-3">
            <label for="typed" class="form-label">Descrição breve </label>
            <input type="text" name="typed" class="form-control" id="typed{{isset($slide->id)?$slide->id:''}}" value="{{isset($slide)?$slide->typed:''}}" placeholder="Descrição breve">
        </div>

        <div class="mb-3">
            <label for="btn_title" class="form-label">Título botão </label>
            <input type="text" name="btn_title" class="form-control" id="btn_title{{isset($slide->id)?$slide->id:''}}" value="{{isset($slide)?$slide->btn_title:''}}" placeholder="Título botão">
        </div>

        <div class="mb-3">
            <label for="link" class="form-label">Link </label>
            <input type="text" name="link" class="form-control" id="link{{isset($slide->id)?$slide->id:''}}" value="{{isset($slide)?$slide->link:''}}" placeholder="Link">
        </div>
        
        <div class="row">    
            <div class="mb-3 col-12">
                <label for="{{$textareaId}}" class="form-label text-muted">Descrição</label>
                <textarea name="description" id="{{$textareaId}}" placeholder="Texto" class="col-12" rows="10">
                    {!!isset($slide->description)?$slide->description: ''!!}
                </textarea>
            </div>
        </div>
        
        <div class="mb-3">
            <div class="form-check">
                <input name="active" {{ isset($slide->active) && $slide->active == 1 ? 'checked' : '' }} type="checkbox" class="form-check-input" id="invalidCheck{{isset($slide->id)?$slide->id:''}}" />
                <label class="form-check-label" for="invalidCheck">{{__('dashboard.active')}}?</label>
                <div class="invalid-feedback">
                    You must agree before submitting.
                </div>
            </div>
        </div>
    </div>
    
    <div class="row col-lg-6">
        <div class="col-lg-12">
            <div class="mt-3">
                <label for="title" class="form-label">Imagem desktop </label>
                <input type="file" name="path_image" data-plugins="dropify" data-default-file="{{isset($slide)?$slide->path_image<>''?url('storage/'.$slide->path_image):'':''}}"  />
                <p class="text-muted text-center mt-2 mb-0">{{__('dashboard.text_img_size')}} <b class="text-danger">2 MB</b>.</p>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="mt-3">
                <label for="title" class="form-label">Imagem mobile </label>
                <input type="file" name="path_image_mobile" data-plugins="dropify" data-default-file="{{isset($slide)?$slide->path_image_mobile<>''?url('storage/'.$slide->path_image_mobile):'':''}}"  />
                <p class="text-muted text-center mt-2 mb-0">{{__('dashboard.text_img_size')}} <b class="text-danger">2 MB</b>.</p>
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