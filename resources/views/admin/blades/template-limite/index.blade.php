@foreach ($templateLimits as $module => $defaultLimit)

    @php
        $customLimit = $tenant->moduleLimits
            ->firstWhere('module', $module);
    @endphp

    <div class="mb-3">

        <label class="form-label">
            {{ ucfirst(str_replace('_', ' ', $module)) }}
        </label>

        <small class="text-muted d-block">
            Limite padrão: {{ $defaultLimit }}
        </small>

        <input
            type="number"
            name="limits[{{ $module }}]"
            class="form-control"
            min="0"
            value="{{ $customLimit?->limit ?? $defaultLimit }}"
        >

    </div>

@endforeach