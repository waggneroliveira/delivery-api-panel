<div class="row g-3">
    <div class="mb-3 col-12 col-md-8">
        <label for="title" class="form-label">Título</label>
        <input 
            type="text" 
            name="title" 
            class="form-control" 
            id="title{{ isset($noticie->id) ? $noticie->id : '' }}" 
            value="{{ isset($noticie) ? $noticie->title : '' }}" 
            placeholder="Digite seu nome"
        >
    </div>
    
    <div class="mb-3 col-12 col-md-4">
        <label for="date" class="form-label">Data de publicação</label>
        <input 
            type="date" 
            name="date" 
            class="form-control" 
            id="date{{ isset($noticie->id) ? $noticie->id : '' }}" 
            value="{{ isset($noticie) ? $noticie->date : '' }}"
        >
    </div>
</div>

<div class="mb-3 col-12">
    <label for="path_file" class="form-label">Arquivo</label>
    <input 
        type="file" 
        name="path_file" 
        accept="application/pdf" 
        data-plugins="dropify" 
        data-default-file="{{ isset($noticie) && $noticie->path_file != '' ? url('storage/'.$noticie->path_file) : '' }}" 
        class="form-control"
    />
    <p class="text-muted text-center mt-2 mb-0">
        {{ __('dashboard.text_img_size') }} <b class="text-danger">2 MB</b>.
    </p>
</div>

<div class="mb-3 col-12">
    <div class="form-check">
        <input 
            name="active" 
            {{ isset($noticie->active) && $noticie->active == 1 ? 'checked' : '' }} 
            type="checkbox" 
            class="form-check-input" 
            id="invalidCheck{{ isset($noticie->id) ? $noticie->id : '' }}" 
        />
        <label class="form-check-label" for="invalidCheck{{ isset($noticie->id) ? $noticie->id : '' }}">
            {{ __('dashboard.active') }}?
        </label>
        <div class="invalid-feedback">
            You must agree before submitting.
        </div>
    </div>
</div>
