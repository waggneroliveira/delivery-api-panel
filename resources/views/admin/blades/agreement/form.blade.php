<div class="row g-3">
    <div class="mb-3 col-12">
        <label for="title" class="form-label">Título</label>
        <input 
            type="text" 
            name="title" 
            class="form-control" 
            id="title{{ isset($agreement->id) ? $agreement->id : '' }}" 
            value="{{ isset($agreement) ? $agreement->title : '' }}" 
            placeholder="Digite seu nome"
        >
    </div>
</div>
{{-- <div class="row g-3">
    <div class="mb-3 col-12">
        <label for="description" class="form-label">Descrição</label>
        <input 
            type="text" 
            name="description" 
            class="form-control" 
            id="description{{ isset($agreement->id) ? $agreement->id : '' }}" 
            value="{{ isset($agreement) ? $agreement->description : '' }}" 
            placeholder="Digite seu nome"
        >
    </div>
</div> --}}

<div class="mb-3 col-12">
    <label for="path_file" class="form-label">Arquivo</label>
    <input 
        type="file" 
        name="path_file" 
        accept="application/pdf" 
        data-plugins="dropify" 
        data-default-file="{{ isset($agreement) && $agreement->path_file != '' ? url('storage/'.$agreement->path_file) : '' }}" 
        class="form-control"
    />
    <p class="text-muted text-center mt-2 mb-0">
        {{ __('dashboard.text_img_size') }} <b class="text-danger">3 MB</b>.
    </p>
</div>
<div class="col-lg-12 mb-3">
    <label for="title" class="form-label">Imagem</label>
    <input type="file" name="path_image" data-plugins="dropify" data-default-file="{{isset($agreement)?$agreement->path_image<>''?url('storage/'.$agreement->path_image):'':''}}"  />
    <p class="text-muted text-center mt-2 mb-0">{{__('dashboard.text_img_size')}} <b class="text-danger">2 MB</b>.</p>
</div>

<div class="mb-3 col-12">
    <div class="form-check">
        <input 
            name="active" 
            {{ isset($agreement->active) && $agreement->active == 1 ? 'checked' : '' }} 
            type="checkbox" 
            class="form-check-input" 
            id="invalidCheck{{ isset($agreement->id) ? $agreement->id : '' }}" 
        />
        <label class="form-check-label" for="invalidCheck{{ isset($agreement->id) ? $agreement->id : '' }}">
            {{ __('dashboard.active') }}?
        </label>
        <div class="invalid-feedback">
            You must agree before submitting.
        </div>
    </div>
</div>
