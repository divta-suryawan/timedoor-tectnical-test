<!-- Component: Base Table -->
@props(['title', 'tableId' => 'baseTable', 'hasFilter' => false])

<div class="card shadow-sm mb-4">
    <div class="card-header bg-primary text-white fw-semibold d-flex justify-content-between align-items-center">
        <span>{{ $title }}</span>

        {{-- Filter Section --}}
        @if ($hasFilter)
            <div class="d-flex align-items-center gap-2">
                <!-- Search Box -->
                <input
                    type="text"
                    id="searchInput"
                    class="form-control form-control-sm"
                    placeholder="Search by book title or author name..."
                    style="width: 220px;"
                >

                <!-- Per Page Dropdown -->
                <select id="perPage" class="form-select form-select-sm" style="width: 110px;">
                    @foreach (range(10, 100, 10) as $num)
                        <option value="{{ $num }}">{{ $num }} / page</option>
                    @endforeach
                </select>

                <!-- Refresh Button -->
                <button id="refreshBtn" class="btn btn-sm btn-light border" title="Reload data">
                    <i class="bi bi-arrow-clockwise"></i>
                </button>
            </div>
        @endif
    </div>

    <div class="card-body p-0">

        <!-- Responsive Table -->
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle mb-0" id="{{ $tableId }}">
                <thead class="table-light">
                    {{ $slot }}
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>
