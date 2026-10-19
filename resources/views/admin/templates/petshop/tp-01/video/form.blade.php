{{-- <div class="mb-3">
    <label for="title" class="form-label">Título</label>
    <input type="text" name="title" class="form-control" id="title{{isset($video->id)?$video->id:''}}" value="{{isset($video)?$video->title:''}}" placeholder="Informe o título do link">
</div> --}}
<div class="mb-3">
    <label for="link" class="form-label">Link</label>
    <input type="text" name="link" class="form-control" id="link{{isset($video->id)?$video->id:''}}" value="{{isset($video)?$video->link:''}}" placeholder="Informe o link">
</div>

<div class="mb-3">
    <div class="form-check">
        <input name="active" {{ isset($video->active) && $video->active == 1 ? 'checked' : '' }} type="checkbox" class="form-check-input" id="invalidCheck{{isset($video->id)?$video->id:''}}" />
        <label class="form-check-label" for="invalidCheck">{{__('dashboard.active')}}?</label>
        <div class="invalid-feedback">
            You must agree before submitting.
        </div>
    </div>
</div>

