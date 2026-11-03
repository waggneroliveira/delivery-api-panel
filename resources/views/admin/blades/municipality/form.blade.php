<div class="mb-3 col-12 d-flex align-items-start flex-column">
    <label for="category-select" class="form-label">Regionais <span class="text-danger">*</span></label>
    @php
        $currentCategory = isset($municipality) ? $municipality->regional_id : null;
    @endphp

    <select name="regional_id" class="form-select" id="category-select" required>
        <option value="" disabled selected>Selecione a Regional</option>
        @foreach ($regionalCategory as $categoryValue => $categoryLabel)
            <option value="{{ $categoryValue }}" {{ $categoryValue == $currentCategory ? 'selected' : '' }}>
                {{ $categoryLabel }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label for="title" class="form-label">Município</label>
    <input type="text" name="title" class="form-control" id="title{{isset($municipality->id)?$municipality->id:''}}" value="{{isset($municipality)?$municipality->title:''}}" placeholder="Digite o município">
</div>

<div class="mb-3">
    <div class="form-check">
        <input name="active" {{ isset($municipality->active) && $municipality->active == 1 ? 'checked' : '' }} type="checkbox" class="form-check-input" id="invalidCheck{{isset($municipality->id)?$municipality->id:''}}" />
        <label class="form-check-label" for="invalidCheck">{{__('dashboard.active')}}?</label>
        <div class="invalid-feedback">
            You must agree before submitting.
        </div>
    </div>
</div>

