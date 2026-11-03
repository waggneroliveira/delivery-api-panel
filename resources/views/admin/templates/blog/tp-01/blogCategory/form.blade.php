<div class="mb-3">
    <label for="title" class="form-label">Título</label>
    <input type="text" name="title" class="form-control" id="title{{isset($blogCategory->id)?$blogCategory->id:''}}" value="{{isset($blogCategory)?$blogCategory->title:''}}" placeholder="Digite seu nome">
</div>

<div class="col-12 col-lg-12">
    <div class="mb-3">
        <label class="form-label">Cor</label>
        <input type="text" name="color" class="form-control colorpicker-default" value="{{ old('color', $blogCategory->color ?? '') }}">
    </div>
</div>

<div class="mb-1">
    <div class="form-check">
        <input name="active" {{ isset($blogCategory->active) && $blogCategory->active == 1 ? 'checked' : '' }} type="checkbox" class="form-check-input" id="invalidCheck{{isset($blogCategory->id)?$blogCategory->id:''}}" />
        <label class="form-check-label" for="invalidCheck">{{__('dashboard.active')}}?</label>
        <div class="invalid-feedback">
            You must agree before submitting.
        </div>
    </div>
</div>
<div class="mb-1">
    <div class="form-check">
        <input name="highlight" {{ isset($blogCategory->highlight) && $blogCategory->highlight == 1 ? 'checked' : '' }} type="checkbox" class="form-check-input" id="invalidCheck{{isset($blogCategory->id)?$blogCategory->id:''}}" />
        <label class="form-check-label" for="invalidCheck">Descatar na home?</label>
        <div class="invalid-feedback">
            You must agree before submitting.
        </div>
    </div>
</div>
<div class="mb-1">
    <div class="form-check">
        <input name="show_in_header" {{ isset($blogCategory->show_in_header) && $blogCategory->show_in_header == 1 ? 'checked' : '' }} type="checkbox" class="form-check-input" id="invalidCheck{{isset($blogCategory->id)?$blogCategory->id:''}}" />
        <label class="form-check-label" for="invalidCheck">Exibir no header?</label>
        <div class="invalid-feedback">
            You must agree before submitting.
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {

    function initColorpicker($container) {

        const $colorpickers = $container.find('.colorpicker-default');

        $colorpickers.each(function () {

            const $colorpicker = $(this);

            if ($colorpicker.data('spectrum')) {
                return;
            }

            $colorpicker.spectrum({
                color: $colorpicker.val() || '#3498db',
                showInput: true,
                showInitial: true,
                showAlpha: false,
                showPaletteOnly: false,
                preferredFormat: 'hex',

                change: function (color) {
                    if (color) {
                        $colorpicker.val(color.toHexString());
                    }
                },

                move: function (color) {
                    if (color) {
                        $colorpicker.val(color.toHexString());
                    }
                }
            });

        });
    }

    // Create
    initColorpicker($(document));

    // Edit
    $(document).on('shown.bs.modal', '.modal', function () {
        initColorpicker($(this));
    });

});
</script>