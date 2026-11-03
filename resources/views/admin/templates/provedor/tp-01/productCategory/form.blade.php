<div class="mb-3">
    <label for="title" class="form-label">Título</label>
    <input type="text" name="title" class="form-control" id="title{{isset($productCategory->id)?$productCategory->id:''}}" value="{{isset($productCategory)?$productCategory->title:''}}" placeholder="Digite seu nome">
</div>

<div class="mb-3">
    <label for="path_image" class="form-label">Imagem</label>
    <input type="file" name="path_image" data-plugins="dropify" data-default-file="{{isset($productCategory)?$productCategory->path_image<>''?url('storage/'.$productCategory->path_image):'':''}}"  />
    <p class="text-muted text-center mt-2 mb-0">{{__('dashboard.text_img_size')}} <b class="text-danger">2 MB</b>.</p>
</div>

<div class="mb-0">
    <div class="form-check">
        <input name="active" {{ isset($productCategory->active) && $productCategory->active == 1 ? 'checked' : '' }} type="checkbox" class="form-check-input" id="invalidCheck{{isset($productCategory->id)?$productCategory->id:''}}" />
        <label class="form-check-label" for="invalidCheck">{{__('dashboard.active')}}?</label>
        <div class="invalid-feedback">
            You must agree before submitting.
        </div>
    </div>
</div>
<div class="mb-3">
    <div class="form-check">
        <input name="highlight" {{ isset($productCategory->highlight) && $productCategory->highlight == 1 ? 'checked' : '' }} type="checkbox" class="form-check-input" id="invalidCheck{{isset($productCategory->id)?$productCategory->id:''}}" />
        <label class="form-check-label" for="invalidCheck">Destacar na home?</label>
        <div class="invalid-feedback">
            You must agree before submitting.
        </div>
    </div>
</div>

