<div class="row g-3">
    <div class="mb-3 col-12">
        <label for="title" class="form-label">Título</label>
        <input 
            type="text" 
            name="title" 
            class="form-control" 
            id="title{{ isset($letsgo->id) ? $letsgo->id : '' }}" 
            value="{{ isset($letsgo) ? $letsgo->title : '' }}" 
            placeholder="Digite seu nome"
        >
    </div>
</div>
<div class="row g-3">
    <div class="mb-3 col-12">
        <label for="description" class="form-label">Descrição</label>
        <input 
            type="text" 
            name="description" 
            class="form-control" 
            id="description{{ isset($letsgo->id) ? $letsgo->id : '' }}" 
            value="{{ isset($letsgo) ? $letsgo->description : '' }}" 
            placeholder="Digite seu nome"
        >
    </div>
</div>

<div class="col-lg-12 mb-3">
    <label for="path_image" class="form-label">Imagem</label>
    <input type="file" name="path_image" data-plugins="dropify" data-default-file="{{isset($letsgo)?$letsgo->path_image<>''?url('storage/'.$letsgo->path_image):'':''}}"  />
    <p class="text-muted text-center mt-2 mb-0">{{__('dashboard.text_img_size')}} <b class="text-danger">2 MB</b>.</p>
</div>

<div class="mb-3 col-12">
    <div class="form-check">
        <input 
            name="active" 
            {{ isset($letsgo->active) && $letsgo->active == 1 ? 'checked' : '' }} 
            type="checkbox" 
            class="form-check-input" 
            id="invalidCheck{{ isset($letsgo->id) ? $letsgo->id : '' }}" 
        />
        <label class="form-check-label" for="invalidCheck{{ isset($letsgo->id) ? $letsgo->id : '' }}">
            {{ __('dashboard.active') }}?
        </label>
        <div class="invalid-feedback">
            You must agree before submitting.
        </div>
    </div>
</div>
