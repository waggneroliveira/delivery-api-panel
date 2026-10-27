<div class="mb-3">
    <label for="title" class="form-label">Título</label>
    <input type="text" name="title" class="form-control" id="title{{isset($brand->id)?$brand->id:''}}" value="{{isset($brand)?$brand->title:''}}" placeholder="Digite seu nome">
</div>

<div class="mb-3">
    <div class="form-check">
        <input name="active" {{ isset($brand->active) && $brand->active == 1 ? 'checked' : '' }} type="checkbox" class="form-check-input" id="invalidCheck{{isset($brand->id)?$brand->id:''}}" />
        <label class="form-check-label" for="invalidCheck">{{__('dashboard.active')}}?</label>
        <div class="invalid-feedback">
            You must agree before submitting.
        </div>
    </div>
</div>

