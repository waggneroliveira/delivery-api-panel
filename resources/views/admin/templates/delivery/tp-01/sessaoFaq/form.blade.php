@php
    $textareaId = $textareaId ?? 'description' . (isset($sessaoFaq->id) ? $sessaoFaq->id : '');
@endphp
<div class="row">
    <div class="col-12">
        <h5 class="modal-title mb-3">Conteúdo direito</h5>
        <div class="row">
            <div class="mb-3 col-12 col-lg-8">
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
            <div class="mb-3 col-12 col-lg-4">
                <label for="tag" class="form-label">Tag</label>
                <input 
                    type="text" 
                    name="tag" 
                    class="form-control" 
                    id="tag{{ isset($sessaoFaq->id) ? $sessaoFaq->id : '' }}" 
                    value="{{ isset($sessaoFaq) ? $sessaoFaq->tag : '' }}" 
                    placeholder="Tag"
                >
            </div>
            <div class="mb-3 col-12 col-lg-6">
                <label for="title_box" class="form-label">Título Box</label>
                <input 
                    type="text" 
                    name="title_box" 
                    class="form-control" 
                    id="title_box{{ isset($sessaoFaq->id) ? $sessaoFaq->id : '' }}" 
                    value="{{ isset($sessaoFaq) ? $sessaoFaq->title_box : '' }}" 
                    placeholder="Título box"
                >
            </div>
            <div class="mb-3 col-12 col-lg-6">
                <label for="description_box" class="form-label">Descrição box</label>
                <input 
                    type="text" 
                    name="description_box" 
                    class="form-control" 
                    id="description_box{{ isset($sessaoFaq->id) ? $sessaoFaq->id : '' }}" 
                    value="{{ isset($sessaoFaq) ? $sessaoFaq->description_box : '' }}" 
                    placeholder="Descrição box"
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
                <label for="link" class="form-label">Link de direcionamento</label>
                <input 
                    type="text" 
                    name="link" 
                    class="form-control" 
                    id="link{{ isset($sessaoFaq->id) ? $sessaoFaq->id : '' }}" 
                    value="{{ isset($sessaoFaq) ? $sessaoFaq->link : '' }}" 
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