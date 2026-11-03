<div class="row mb-3">
    <div class="col-12 col-lg-6">
        <label for="name" class="form-label">Cliente</label>
        <input type="text" class="form-control" id="name{{isset($tenantGoogle->id)?$tenantGoogle->id:''}}" value="{{$tenant->name;}}" readonly disabled>
    </div>
    <div class="col-12 col-lg-6">
        <label for="property" class="form-label">Domínio</label>
        <input type="text" name="property" class="form-control" id="property{{isset($tenantGoogle->id)?$tenantGoogle->id:''}}" value="{{isset($tenantGoogle)?$tenantGoogle->property:''}}" placeholder="https://example.com.br">
    </div>
</div>

<div class="mb-3">
    <div class="form-check">
        <input name="active" {{ isset($tenantGoogle->active) && $tenantGoogle->active == 1 ? 'checked' : '' }} type="checkbox" class="form-check-input" id="invalidCheck{{isset($tenantGoogle->id)?$tenantGoogle->id:''}}" />
        <label class="form-check-label" for="invalidCheck">{{__('dashboard.active')}}?</label>
        <div class="invalid-feedback">
            You must agree before submitting.
        </div>
    </div>
</div>

