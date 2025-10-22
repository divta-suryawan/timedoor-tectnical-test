<!-- Component: Base Title -->
@props(['title','subtitle'])
<div class="mb-4">
    <h3 class="fw-semibold">{{ $title}}</h3>

    @if (!empty($subtitle))
        <p class="text-muted mb-1">{{ $subtitle }}</p>
    @endif

    <hr>
</div>
