@php
    $planNetwork = $serviceSection->get('planNetwork');
    $textareaId = $textareaId ?? 'description' . (isset($planNetwork->id) ? $planNetwork->id : '');
@endphp


{{-- ============================================================
    DADOS DA SEÇÃO
============================================================ --}}

<div class="row">

    <div class="col-12">
        <h5 class="mb-3 border-bottom pb-2">
            Dados da Seção
        </h5>
    </div>

    <input type="hidden" name="section" value="planNetwork">

    {{-- TÍTULO --}}
    <div class="mb-3 col-lg-6">
        <label for="title" class="form-label">Título</label>
        <input type="text"
               name="title"
               class="form-control"
               id="title"
               value="{{ $planNetwork?->title ?? '' }}"
               placeholder="Título">
    </div>

    {{-- subtitle --}}
    <div class="mb-3 col-lg-6">
        <label for="subtitle" class="form-label">SubtTítulo</label>
        <input type="text"
               name="subtitle"
               class="form-control"
               id="subtitle"
               value="{{ $planNetwork?->subtitle ?? '' }}"
               placeholder="subtitle">
    </div>

    {{-- DESCRIÇÃO --}}
    <div class="mb-3 col-12">
        <label for="{{$textareaId}}" class="form-label text-muted">Descrição breve</label>
        <textarea name="description" id="{{$textareaId}}" placeholder="Texto" class="col-12" rows="10">
            {!!isset($planNetwork->description)?$planNetwork->description: ''!!}
        </textarea>
    </div>

    {{-- ATIVO --}}
    <div class="mb-3 col-12">
        <div class="form-check">
            <input name="active"
                   value="1"
                   {{ $planNetwork?->active ? 'checked' : '' }}
                   type="checkbox"
                   class="form-check-input"
                   id="active">

            <label class="form-check-label" for="active">
                {{ __('dashboard.active') }}?
            </label>
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