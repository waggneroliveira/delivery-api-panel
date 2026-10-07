<div class="mb-3 col-12 col-lg-12 d-flex align-items-start flex-column">
    <label for="category-select" class="form-label">Categoria(s) <span class="text-danger">*</span></label>
    @php
        $currentCategory = isset($blogSubCategory) ? $blogSubCategory->blog_category_id : null;
    @endphp

    <select name="blog_category_id" class="form-select" id="category-select" required>
        <option value="" disabled selected>Selecione o Cliente</option>
        @foreach ($blogCategory as $categoryValue => $categoryLabel)
            <option value="{{ $categoryValue }}" {{ $categoryValue == $currentCategory ? 'selected' : '' }}>
                {{ $categoryLabel }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label for="name" class="form-label">Título</label>
    <input type="text" name="name" class="form-control" id="name{{isset($blogSubCategory->id)?$blogSubCategory->id:''}}" value="{{isset($blogSubCategory)?$blogSubCategory->name:''}}" placeholder="Digite a sub categoria">
</div>


<div class="mb-3">
    <div class="form-check">
        <input name="active" {{ isset($blogSubCategory->active) && $blogSubCategory->active == 1 ? 'checked' : '' }} type="checkbox" class="form-check-input" id="invalidCheck{{isset($blogSubCategory->id)?$blogSubCategory->id:''}}" />
        <label class="form-check-label" for="invalidCheck">{{__('dashboard.active')}}?</label>
        <div class="invalid-feedback">
            You must agree before submitting.
        </div>
    </div>
</div>

