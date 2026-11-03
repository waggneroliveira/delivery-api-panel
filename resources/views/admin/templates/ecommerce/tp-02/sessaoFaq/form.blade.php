@php
    $textareaId = $textareaId ?? 'description' . (isset($sessaoFaq->id) ? $sessaoFaq->id : '');
@endphp
<div class="row">
    <div class="col-12">
        <h5 class="modal-title mb-3">Conteúdo direito</h5>
        <div class="row">
            <div class="mb-3 col-12 col-lg-6">
                <label for="title" class="form-label">Título</label>
                <input 
                    type="text" 
                    name="title" 
                    class="form-control" 
                    id="title{{ isset($sessaoFaq->id) ? $sessaoFaq->id : '' }}" 
                    value="{{ isset($sessaoFaq) ? $sessaoFaq->title : '' }}" 
                    placeholder="Digite o título"
                >
            </div>
            <div class="mb-3 col-12 col-lg-6">
                <label for="subtitle" class="form-label">Subtítulo</label>
                <input 
                    type="text" 
                    name="subtitle" 
                    class="form-control" 
                    id="subtitle{{ isset($sessaoFaq->id) ? $sessaoFaq->id : '' }}" 
                    value="{{ isset($sessaoFaq) ? $sessaoFaq->subtitle : '' }}" 
                    placeholder="Digite o subtítulo"
                >
            </div>
            <div class="mb-3 col-12 col-lg-4">
                <label for="btn_title" class="form-label">Título do botão</label>
                <input 
                    type="text" 
                    name="btn_title" 
                    class="form-control" 
                    id="btn_title{{ isset($sessaoFaq->id) ? $sessaoFaq->id : '' }}" 
                    value="{{ isset($sessaoFaq) ? $sessaoFaq->btn_title : '' }}" 
                    placeholder="Digite um título para o botão"
                >
            </div>
            <div class="mb-3 col-12 col-lg-8">
                <label for="btn_number" class="form-label">Link de direcionamento</label>
                <input 
                    type="text" 
                    name="btn_number" 
                    class="form-control" 
                    id="btn_number{{ isset($sessaoFaq->id) ? $sessaoFaq->id : '' }}" 
                    value="{{ isset($sessaoFaq) ? $sessaoFaq->btn_number : '' }}" 
                    placeholder="Digite o Link de direcionamento"
                >
            </div>
        </div>
        <div class="row">    
            <div class="mb-3 col-12">
                <label for="{{$textareaId}}" class="form-label text-white">Descrição</label>
                <textarea name="description" id="{{$textareaId}}" placeholder="Texto" class="col-12" rows="10">
                    {!!isset($sessaoFaq->description)?$sessaoFaq->description: ''!!}
                </textarea>
            </div>
        </div>
        <div class="mb-3 col-12">
            <div class="form-check">
                <input 
                    name="active" 
                    {{ isset($sessaoFaq->active) && $sessaoFaq->active == 1 ? 'checked' : '' }} 
                    type="checkbox" 
                    class="form-check-input" 
                    id="invalidCheck{{ isset($sessaoFaq->id) ? $sessaoFaq->id : '' }}" 
                />
                <label class="form-check-label" for="invalidCheck{{ isset($sessaoFaq->id) ? $sessaoFaq->id : '' }}">
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