<!-- Komponen: Base Form -->
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white fw-semibold">
        {{ $title ?? 'Form Input' }}
    </div>

    <div class="card-body">
        <form id="{{ $formId ?? 'baseForm' }}" method="POST">
            @csrf
            {{ $slot }}
        </form>
    </div>
</div>
