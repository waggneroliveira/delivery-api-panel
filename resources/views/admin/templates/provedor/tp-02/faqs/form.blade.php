@php
    $textareaId = $textareaId ?? 'description' . (isset($faq->id) ? $faq->id : '');
@endphp

<div class="d-flex justify-content-between">
    <div class="row col-12">
        <div class="mb-3">
            <label for="question" class="form-label">Pergunta </label>
            <input type="text" name="question" class="form-control" id="{{isset($faq)?$faq->id:''}}" value="{{isset($faq)?$faq->question:''}}" placeholder="Pergunta">
        </div>

        <div class="mb-3 col-12">
            <label for="{{$textareaId}}" class="form-label text-white">Resposta</label>
            <textarea name="answer" id="{{$textareaId}}" placeholder="Texto" class="col-12" rows="10">
                {!!isset($faq->answer)?$faq->answer: ''!!}
            </textarea>
        </div>
        
        <div class="mb-3">
            <div class="form-check">
                <input name="active" {{ isset($faq->active) && $faq->active == 1 ? 'checked' : '' }} type="checkbox" class="form-check-input" id="invalidCheck{{isset($faq->id)?$faq->id:''}}" />
                <label class="form-check-label" for="invalidCheck">{{__('dashboard.active')}}?</label>
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