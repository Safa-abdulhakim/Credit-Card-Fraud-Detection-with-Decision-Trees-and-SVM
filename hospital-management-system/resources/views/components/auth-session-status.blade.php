@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'alert alert-success py-2 small']) }}>
        <i class="fas fa-check-circle me-1"></i>{{ $status }}
    </div>
@endif
