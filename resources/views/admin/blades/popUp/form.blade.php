<div class="mb-3">
    <label for="link" class="form-label">Link</label>
    <input type="text" name="link" class="form-control" id="link{{isset($popUp->id)?$popUp->id:''}}" value="{{isset($popUp)?$popUp->link:''}}" placeholder="Link de redirecionamento">
</div>
<div class="col-12">
    <div class="mt-3">
        <label for="path_image" class="form-label">Imagem</label>
        <input type="file" name="path_image" data-plugins="dropify" data-default-file="{{isset($popUp)?$popUp->path_image<>''?url('storage/'.$popUp->path_image):'':''}}"  />
        <p class="text-muted text-center mt-2 mb-0">{{__('dashboard.text_img_size')}} <b class="text-danger">2 MB</b>.</p>
    </div>
</div>

<div class="mb-3">
    <div class="form-check">
        <input name="active" {{ isset($popUp->active) && $popUp->active == 1 ? 'checked' : '' }} type="checkbox" class="form-check-input" id="invalidCheck{{isset($popUp->id)?$popUp->id:''}}" />
        <label class="form-check-label" for="invalidCheck">{{__('dashboard.active')}}?</label>
        <div class="invalid-feedback">
            You must agree before submitting.
        </div>
    </div>
</div>

