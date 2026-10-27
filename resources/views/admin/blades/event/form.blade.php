<div class="row">
    <div class="col-7">
        <div class="mb-3 col-12">
            <label for="title" class="form-label">Título</label>
            @if (session('blogTitle'))                
                <input type="text" name="title" class="form-control" id="title" value="{{session()->get('blogTitle')}}" placeholder="Título">
                @else
                <input type="text" name="title" class="form-control" id="title{{isset($event->id)?$event->id:''}}" value="{{isset($event)?$event->title:''}}" placeholder="Título">
            @endif
        </div>
        <div class="row">
            <div class="mb-3 col-12 col-lg-6">
                <label for="date" class="form-label">Data do evento</label>
                <input type="date" name="date" class="form-control" id="date{{isset($event->id)?$event->id:''}}" value="{{isset($event)?$event->date:''}}">
            </div>
            <div class="mb-3 col-12 col-lg-6">
                <label for="hours" class="form-label">Horário do evento</label>
                <input type="text" name="hours" class="form-control" id="hours{{isset($event->id)?$event->id:''}}" value="{{isset($event)?$event->hours:''}}" placeholder="Horário do evento">
            </div>
        </div>
        <div class="mb-3 col-12">
            <label for="link" class="form-label">Link</label>
            <input type="text" name="link" class="form-control" id="link{{isset($event->id)?$event->id:''}}" value="{{isset($event)?$event->link:''}}" placeholder="Link">
        </div>
        
        <div class="mb-3">
            <div class="form-check">
                <input name="active" {{ isset($event->active) && $event->active == 1 ? 'checked' : '' }} type="checkbox" class="form-check-input" id="invalidCheck{{isset($event->id)?$event->id:''}}" />
                <label class="form-check-label" for="invalidCheck">{{__('dashboard.active')}}?</label>
                <div class="invalid-feedback">
                    You must agree before submitting.
                </div>
            </div>
        </div>
    </div>  
    <div class="col-5">
        <div class="mb-3 col-12 d-flex align-items-end flex-column">
            <label for="textarea-edit" class="form-label">Texto</label>
            <textarea name="description" class="form-control col-12" id="textarea-edit" rows="5">
                {!!isset($event)?$event->description:''!!}
            </textarea>
        </div>
    </div>
</div>


