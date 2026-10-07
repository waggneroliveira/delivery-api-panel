<div class="mb-3">
    <label for="title" class="form-label">Título</label>
    <input type="text" name="title" class="form-control" id="title{{isset($productCategory->id)?$productCategory->id:''}}" value="{{isset($productCategory)?$productCategory->title:''}}" placeholder="Digite seu nome">
</div>

<div class="mb-0">
    <div class="form-check">
        <input name="active" {{ isset($productCategory->active) && $productCategory->active == 1 ? 'checked' : '' }} type="checkbox" class="form-check-input" id="invalidCheck{{isset($productCategory->id)?$productCategory->id:''}}" />
        <label class="form-check-label" for="invalidCheck">{{__('dashboard.active')}}?</label>
        <div class="invalid-feedback">
            You must agree before submitting.
        </div>
    </div>
</div>

