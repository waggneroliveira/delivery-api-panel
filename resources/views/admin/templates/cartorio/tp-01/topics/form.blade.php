<div class="mb-3">
    <label for="title" class="form-label">Título</label>
    <input type="text" name="title" class="form-control" id="title{{isset($topic->id)?$topic->id:''}}" value="{{isset($topic)?$topic->title:''}}" placeholder="Título">
</div>
<div class="mb-3">
    <label for="description" class="form-label">Descrição breve</label>
    <input type="text" name="description" class="form-control" id="description{{isset($topic->id)?$topic->id:''}}" value="{{isset($topic)?$topic->description:''}}" placeholder="Descrição">
</div>
<div class="mb-3">
    <label for="link" class="form-label">Link</label>
    <input type="text" name="link" class="form-control" id="link{{isset($topic->id)?$topic->id:''}}" value="{{isset($topic)?$topic->link:''}}" placeholder="Link">
</div>
<div class="mb-3">
    <label for="btn_title" class="form-label">Título do botão</label>
    <input type="text" name="btn_title" class="form-control" id="btn_title{{isset($topic->id)?$topic->id:''}}" value="{{isset($topic)?$topic->btn_title:''}}" placeholder="Título do botão">
</div>
<div class="col-lg-12">
    <div class="mb-3">
        <label for="title" class="form-label">Imagem desktop </label>
        <input type="file" name="path_image" data-plugins="dropify" data-default-file="{{isset($topic)?$topic->path_image<>''?url('storage/'.$topic->path_image):'':''}}"  />
        <p class="text-muted text-center mt-2 mb-0">{{__('dashboard.text_img_size')}} <b class="text-danger">2 MB</b>.</p>
    </div>
</div>
<div class="mb-3">
    <div class="form-check">
        <input name="active" {{ isset($topic->active) && $topic->active == 1 ? 'checked' : '' }} type="checkbox" class="form-check-input" id="invalidCheck{{isset($topic->id)?$topic->id:''}}" />
        <label class="form-check-label" for="invalidCheck">{{__('dashboard.active')}}?</label>
        <div class="invalid-feedback">
            You must agree before submitting.
        </div>
    </div>
</div>

