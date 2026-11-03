@php
    $textareaId = $textareaId ?? 'description' . (isset($statute->id) ? $statute->id : '');
@endphp
<div class="row">
    <div class="col-12 col-lg-6">
        <h5 class="modal-title mb-3">Conteúdo esquerdo</h5>
        <div class="mb-3 col-12">
            <label for="text_atend" class="form-label">Texto de atendimento</label>
            <input 
                type="text" 
                name="text_atend" 
                class="form-control" 
                id="text_atend{{ isset($statute->id) ? $statute->id : '' }}" 
                value="{{ isset($statute) ? $statute->text_atend : '' }}" 
                placeholder="Digite um texto"
            >
        </div>
        <div class="mb-3 col-12">
            <label for="phone" class="form-label">Telefone</label>
            <input 
                type="text" 
                name="phone" 
                class="form-control" 
                id="phone{{ isset($statute->id) ? $statute->id : '' }}" 
                value="{{ isset($statute) ? $statute->phone : '' }}" 
                placeholder="Digite o telefone"
            >
        </div>

        <div class="mb-3 col-12">
            <label for="path_file" class="form-label">Imagem</label>
            <input 
                type="file" 
                name="path_file" 
                {{-- accept="application/pdf" --}}
                data-plugins="dropify" 
                data-default-file="{{ isset($statute) && $statute->path_file != '' ? url('storage/'.$statute->path_file) : '' }}" 
                class="form-control"
            />
            <p class="text-muted text-center mt-2 mb-0">
                {{ __('dashboard.text_img_size') }} <b class="text-danger">3 MB</b>.
            </p>
        </div>
    </div>

    <div class="col-12 col-lg-6">
        <h5 class="modal-title mb-3">Conteúdo direito</h5>
        <div class="row">
            <div class="mb-3 col-12">
                <label for="title" class="form-label">Título</label>
                <input 
                    type="text" 
                    name="title" 
                    class="form-control" 
                    id="title{{ isset($statute->id) ? $statute->id : '' }}" 
                    value="{{ isset($statute) ? $statute->title : '' }}" 
                    placeholder="Digite o título"
                >
            </div>
            <div class="mb-3 col-12">
                <label for="subtitle" class="form-label">Subtítulo</label>
                <input 
                    type="text" 
                    name="subtitle" 
                    class="form-control" 
                    id="subtitle{{ isset($statute->id) ? $statute->id : '' }}" 
                    value="{{ isset($statute) ? $statute->subtitle : '' }}" 
                    placeholder="Digite o subtítulo"
                >
            </div>
            <div class="mb-3 col-12">
                <label for="btn_title" class="form-label">Título do botão</label>
                <input 
                    type="text" 
                    name="btn_title" 
                    class="form-control" 
                    id="btn_title{{ isset($statute->id) ? $statute->id : '' }}" 
                    value="{{ isset($statute) ? $statute->btn_title : '' }}" 
                    placeholder="Digite um título para o botão"
                >
            </div>
            <div class="mb-3 col-12">
                <label for="btn_number" class="form-label">Link de direcionamento</label>
                <input 
                    type="text" 
                    name="btn_number" 
                    class="form-control" 
                    id="btn_number{{ isset($statute->id) ? $statute->id : '' }}" 
                    value="{{ isset($statute) ? $statute->btn_number : '' }}" 
                    placeholder="Digite o Link de direcionamento"
                >
            </div>
        </div>
        <div class="row">    
            <div class="mb-3 col-12">
                <label for="{{$textareaId}}" class="form-label text-white">Descrição</label>
                <textarea name="description" id="{{$textareaId}}" placeholder="Texto" class="col-12" rows="10">
                    {!!isset($statute->description)?$statute->description: ''!!}
                </textarea>
            </div>
        </div>
        <div class="mb-3 col-12">
            <div class="form-check">
                <input 
                    name="active" 
                    {{ isset($statute->active) && $statute->active == 1 ? 'checked' : '' }} 
                    type="checkbox" 
                    class="form-check-input" 
                    id="invalidCheck{{ isset($statute->id) ? $statute->id : '' }}" 
                />
                <label class="form-check-label" for="invalidCheck{{ isset($statute->id) ? $statute->id : '' }}">
                    {{ __('dashboard.active') }}?
                </label>
                <div class="invalid-feedback">
                    You must agree before submitting.
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        if (document.getElementById("{{$textareaId}}")) {
            CKEDITOR.replace("{{$textareaId}}");
        }
    });
</script>