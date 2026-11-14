@php
    $textareaId = $textareaId ?? 'description' . (isset($statute->id) ? $statute->id : '');
    $neighborhoodWidgetId = 'service-location-neighborhoods-' . ($serviceLocation->id ?? 'create');
@endphp
<div class="row g-3">
    <div class="mb-3 col-12">
        <label for="title" class="form-label">Cidade/Município</label>
        <input 
            type="text" 
            name="title" 
            class="form-control" 
            id="title{{ isset($serviceLocation->id) ? $serviceLocation->id : '' }}" 
            value="{{ isset($serviceLocation) ? $serviceLocation->title : '' }}" 
            placeholder="Cidade/Município"
        >
    </div>
    <div class="mb-3 col-12" id="{{ $neighborhoodWidgetId }}" data-neighborhood-widget>
        <label class="form-label">Bairros e taxas de entrega</label>
        <div class="input-group mb-2">
            <input type="text" class="form-control" data-neighborhood-name placeholder="Nome do bairro">
            <span class="input-group-text">R$</span>
            <input type="text" class="form-control" data-neighborhood-fee inputmode="decimal" placeholder="0,00" autocomplete="off" style="max-width: 150px">
            <button type="button" class="btn btn-primary text-black" data-add-neighborhood>Adicionar</button>
        </div>
        <div class="d-flex flex-wrap gap-2" data-neighborhood-list>
            @foreach (($serviceLocation->neighborhoods ?? []) as $index => $neighborhood)
                <span class="badge bg-info text-dark d-inline-flex align-items-center gap-2" data-neighborhood-item>
                    <span>{{ $neighborhood['name'] }} - R$ {{ number_format((float) $neighborhood['delivery_fee'], 2, ',', '.') }}</span>
                    <button type="button" class="btn-close" data-remove-neighborhood aria-label="Remover {{ $neighborhood['name'] }}"></button>
                    <input type="hidden" name="neighborhoods[{{ $index }}][name]" value="{{ $neighborhood['name'] }}">
                    <input type="hidden" name="neighborhoods[{{ $index }}][delivery_fee]" value="{{ $neighborhood['delivery_fee'] }}">
                </span>
            @endforeach
        </div>
    </div>
</div>
{{-- <div class="row">    
    <div class="mb-3 col-12">
        <label for="{{$textareaId}}" class="form-label text-white">Descrição</label>
        <textarea name="description" id="{{$textareaId}}" placeholder="Texto" class="col-12" rows="10">
            {!!isset($serviceLocation->description)?$serviceLocation->description: ''!!}
        </textarea>
    </div>
</div> --}}

{{-- <div class="col-lg-12 mb-3">
    <label for="path_image" class="form-label">Ícone</label>
    <input type="file" name="path_image" data-plugins="dropify" data-default-file="{{isset($serviceLocation)?$serviceLocation->path_image<>''?url('storage/'.$serviceLocation->path_image):'':''}}"  />
    <p class="text-muted text-center mt-2 mb-0">{{__('dashboard.text_img_size')}} <b class="text-danger">2 MB</b>.</p>
</div> --}}

<div class="mb-3 col-12">
    <div class="form-check">
        <input 
            name="active" 
            {{ isset($serviceLocation->active) && $serviceLocation->active == 1 ? 'checked' : '' }} 
            type="checkbox" 
            class="form-check-input" 
            id="invalidCheck{{ isset($serviceLocation->id) ? $serviceLocation->id : '' }}" 
        />
        <label class="form-check-label" for="invalidCheck{{ isset($serviceLocation->id) ? $serviceLocation->id : '' }}">
            {{ __('dashboard.active') }}?
        </label>
        <div class="invalid-feedback">
            You must agree before submitting.
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        if (document.getElementById("{{$textareaId}}")) {
            CKEDITOR.replace("{{$textareaId}}", {
                allowedContent: true,
                readOnly: typeof readOnly !== 'undefined' ? readOnly : false,
                toolbar: [
                    {
                        name: 'basicstyles',
                        items: ['Bold', 'Italic', 'Underline']
                    },
                    {
                        name: 'paragraph',
                        items: ['NumberedList', 'BulletedList']
                    }
                ]
            });
        }
    });
</script>

<script>
    (function () {
        document.addEventListener('input', function (event) {
            const feeInput = event.target.closest('[data-neighborhood-fee]');
            if (!feeInput) {
                return;
            }

            const digits = feeInput.value.replace(/\D/g, '').replace(/^0+(?=\d)/, '');

            if (!digits) {
                feeInput.value = '';
                return;
            }

            const amount = digits.padStart(3, '0');
            const whole = amount.slice(0, -2).replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            feeInput.value = whole + ',' + amount.slice(-2);
            feeInput.setSelectionRange(feeInput.value.length, feeInput.value.length);
        });

        document.addEventListener('click', function (event) {
            const removeButton = event.target.closest('[data-remove-neighborhood]');
            if (removeButton) {
                removeButton.closest('[data-neighborhood-item]').remove();
                return;
            }

            const addButton = event.target.closest('[data-add-neighborhood]');
            if (!addButton) {
                return;
            }

            const widget = addButton.closest('[data-neighborhood-widget]');
            const nameInput = widget.querySelector('[data-neighborhood-name]');
            const feeInput = widget.querySelector('[data-neighborhood-fee]');
            const list = widget.querySelector('[data-neighborhood-list]');
            const name = nameInput.value.trim();
            const fee = feeInput.value.trim().replace(/\./g, '').replace(',', '.');
            const parsedFee = Number(fee);

            if (!name || !/^\d+(?:\.\d{1,2})?$/.test(fee) || !Number.isFinite(parsedFee)) {
                if (!name) {
                    nameInput.focus();
                } else {
                    feeInput.focus();
                }
                return;
            }

            const item = document.createElement('span');
            item.className = 'badge bg-info text-dark d-inline-flex align-items-center gap-2';
            item.dataset.neighborhoodItem = '';

            const label = document.createElement('span');
            label.textContent = name + ' - R$ ' + parsedFee.toLocaleString('pt-BR', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });

            const removeBadgeButton = document.createElement('button');
            removeBadgeButton.type = 'button';
            removeBadgeButton.className = 'btn-close';
            removeBadgeButton.dataset.removeNeighborhood = '';
            removeBadgeButton.setAttribute('aria-label', 'Remover ' + name);

            const nameField = document.createElement('input');
            nameField.type = 'hidden';
            nameField.value = name;

            const feeField = document.createElement('input');
            feeField.type = 'hidden';
            feeField.value = parsedFee.toFixed(2);

            let nextIndex = Number(widget.dataset.nextIndex);
            if (!Number.isInteger(nextIndex)) {
                nextIndex = 0;
                list.querySelectorAll('input[name^="neighborhoods["]').forEach(function (field) {
                    const match = field.name.match(/^neighborhoods\[(\d+)\]/);
                    if (match) {
                        nextIndex = Math.max(nextIndex, Number(match[1]) + 1);
                    }
                });
            }

            nameField.name = 'neighborhoods[' + nextIndex + '][name]';
            feeField.name = 'neighborhoods[' + nextIndex + '][delivery_fee]';
            widget.dataset.nextIndex = String(nextIndex + 1);

            item.append(label, removeBadgeButton, nameField, feeField);
            list.appendChild(item);
            nameInput.value = '';
            feeInput.value = '';
            nameInput.focus();
        });
    })();
</script>
