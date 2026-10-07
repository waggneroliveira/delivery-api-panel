<div class="mb-3">
    <label for="title" class="form-label">Título</label>
    <input type="text" name="title" class="form-control" id="title{{isset($blogCategory->id)?$blogCategory->id:''}}" value="{{isset($blogCategory)?$blogCategory->title:''}}" placeholder="Digite seu nome">
</div>

{{-- <div class="mb-3">
    <label for="path_image" class="form-label">Imagem</label>
    <input type="file" name="path_image" data-plugins="dropify" data-default-file="{{isset($blogCategory)?$blogCategory->path_image<>''?url('storage/'.$blogCategory->path_image):'':''}}"  />
    <p class="text-muted text-center mt-2 mb-0">{{__('dashboard.text_img_size')}} <b class="text-danger">2 MB</b>.</p>
</div> --}}

<div class="mb-3">
    <div class="form-check">
        <input name="active" {{ isset($blogCategory->active) && $blogCategory->active == 1 ? 'checked' : '' }} type="checkbox" class="form-check-input" id="invalidCheck{{isset($blogCategory->id)?$blogCategory->id:''}}" />
        <label class="form-check-label" for="invalidCheck">{{__('dashboard.active')}}?</label>
        <div class="invalid-feedback">
            You must agree before submitting.
        </div>
    </div>
</div>

