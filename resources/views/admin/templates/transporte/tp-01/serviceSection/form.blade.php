@php
    $service = $serviceSection->get('service');
@endphp

<div class="row">
    <input type="hidden" name="section" value="service">

    <div class="mb-3 col-lg-6">
        <label for="title" class="form-label">Título</label>
        <input type="text"
               name="title"
               class="form-control"
               id="title"
               value="{{ $service?->title ?? '' }}"
               placeholder="Título">
    </div>

    <div class="mb-3 col-lg-6">
        <label for="tag" class="form-label">Tag</label>
        <input type="text"
               name="tag"
               class="form-control"
               id="tag"
               value="{{ $service?->tag ?? '' }}"
               placeholder="Tag">
    </div>
</div>

<div class="mb-3">
    <label for="description" class="form-label">Descrição breve</label>
    <input type="text"
           name="description"
           class="form-control"
           id="description"
           value="{{ $service?->description ?? '' }}"
           placeholder="Descrição">
</div>

<div class="col-12 mb-3">
    <div class="mt-3">
        <label for="path_image" class="form-label">Imagem da sessão</label>
        <input type="file" name="path_image" accept=".jpg,.jpeg,.png" data-plugins="dropify" data-default-file="{{isset($service)?$service->path_image<>''?url('storage/'.$service->path_image):'':''}}"  />
        <p class="text-muted text-center mt-2 mb-0">{{__('dashboard.text_img_size')}} <b class="text-danger">2 MB</b>.</p>
    </div>
</div>

<div class="mb-3">
    <div class="form-check">
        <input name="active"
               value="1"
               {{ $service?->active ? 'checked' : '' }}
               type="checkbox"
               class="form-check-input"
               id="active">

        <label class="form-check-label" for="active">
            {{ __('dashboard.active') }}?
        </label>
    </div>
</div>