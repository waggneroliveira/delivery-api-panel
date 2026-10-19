<div class="mb-3">
    <label for="title" class="form-label">Título</label>
    <input type="text" name="title" class="form-control" id="title{{isset($benefitTopic->id)?$benefitTopic->id:''}}" value="{{isset($benefitTopic)?$benefitTopic->title:''}}" placeholder="Título">
</div>
<div class="mb-3">
    <label for="number" class="form-label">Números</label>
    <input type="number" name="number" class="form-control" id="number{{isset($benefitTopic->id)?$benefitTopic->id:''}}" value="{{isset($benefitTopic)?$benefitTopic->number:''}}" placeholder="Informe o parâmetro numérico">
</div>

<div class="mb-3">
    <div class="form-check">
        <input name="active" {{ isset($benefitTopic->active) && $benefitTopic->active == 1 ? 'checked' : '' }} type="checkbox" class="form-check-input" id="invalidCheck{{isset($benefitTopic->id)?$benefitTopic->id:''}}" />
        <label class="form-check-label" for="invalidCheck">{{__('dashboard.active')}}?</label>
        <div class="invalid-feedback">
            You must agree before submitting.
        </div>
    </div>
</div>

