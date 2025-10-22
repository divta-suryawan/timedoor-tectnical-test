@extends('base')

@section('content')
<x-base-title
    title="Book List"
    subtitle="Displays the top 10 books ranked by their highest average ratings. You can filter the results by book title or author name."
/>

<!-- Book Table -->
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white fw-semibold d-flex justify-content-between align-items-center">
        <span>Book Data</span>
        <div class="d-flex align-items-center gap-2">
            <input type="text" id="searchInput" class="form-control form-control-sm" placeholder="Search book or author...">
            <select id="perPage" class="form-select form-select-sm w-auto">
                @for ($i = 10; $i <= 100; $i += 10)
                    <option value="{{ $i }}">{{ $i }}</option>
                @endfor
            </select>
            <button id="refreshBtn" class="btn btn-light btn-sm">
                <i class="bi bi-arrow-repeat">Refresh</i>
            </button>
        </div>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle mb-0" id="bookTable">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Book Title</th>
                        <th>Category</th>
                        <th>Author</th>
                        <th>Average Rating</th>
                        <th>Total Votes</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

    <div class="card-footer bg-light text-center">
        <nav>
            <ul class="pagination justify-content-center m-0" id="pagination"></ul>
        </nav>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function () {
    const tableBody = $('#bookTable tbody');
    const searchInput = $('#searchInput');
    const perPageSelect = $('#perPage');
    const refreshBtn = $('#refreshBtn');
    const paginationContainer = $('#pagination');
    const baseUrl = '/timedoor-test/books';

    function loadBooks(page = 1) {
        const search = searchInput.val();
        const perPage = perPageSelect.val();

        $.ajax({
            url: `${baseUrl}?page=${page}`,
            type: 'GET',
            data: {
                search: search,
                per_page: perPage
            },
            beforeSend: function() {
                tableBody.html(`
                    <tr>
                        <td colspan="6" class="text-center text-muted">
                            <div class="spinner-border spinner-border-sm text-primary me-2"></div> Loading data...
                        </td>
                    </tr>
                `);
                paginationContainer.empty();
            },
            success: function (response) {
                const books = response.data.data || [];
                const pagination = response.data.links || [];
                tableBody.empty();

                if (books.length === 0) {
                    tableBody.append(`
                        <tr>
                            <td colspan="6" class="text-center text-muted">No data found</td>
                        </tr>
                    `);
                    return;
                }

                $.each(books, function (index, book) {
                    tableBody.append(`
                        <tr>
                            <td>${((response.data.current_page - 1) * response.data.per_page) + (index + 1)}</td>
                            <td>${book.title ?? '-'}</td>
                            <td>${book.category_name ?? '-'}</td>
                            <td>${book.author_name ?? '-'}</td>
                            <td>${
                                book.rating_avg_score >= 10
                                    ? 10
                                    : (parseFloat(book.rating_avg_score || 0)).toFixed(2)
                            }</td>
                            <td>${book.total_vote ?? 0}</td>
                        </tr>
                    `);
                });

                renderPagination(pagination);
            },
            error: function () {
                tableBody.html(`
                    <tr>
                        <td colspan="6" class="text-center text-danger">Failed to load data. Please try again later.</td>
                    </tr>
                `);
                paginationContainer.empty();
            }
        });
    }

    function renderPagination(links) {
        paginationContainer.empty();

        $.each(links, function (index, link) {
            const activeClass = link.active ? 'active' : '';
            const disabled = link.url === null ? 'disabled' : '';
            const label = link.label.replace('&laquo;', '«').replace('&raquo;', '»');

            paginationContainer.append(`
                <li class="page-item ${activeClass} ${disabled}">
                    <a class="page-link" href="#" data-url="${link.url || '#'}">${label}</a>
                </li>
            `);
        });

        $('#pagination a').on('click', function (e) {
            e.preventDefault();
            const url = $(this).data('url');
            if (url && !$(this).parent().hasClass('active') && !$(this).parent().hasClass('disabled')) {
                const page = new URL(url).searchParams.get('page');
                loadBooks(page);
            }
        });
    }

    // Event Listeners
    searchInput.on('keyup', function () {
        clearTimeout($(this).data('timer'));
        const wait = setTimeout(() => loadBooks(1), 400);
        $(this).data('timer', wait);
    });

    perPageSelect.on('change', function () {
        loadBooks(1);
    });

    refreshBtn.on('click', function () {
        searchInput.val('');
        loadBooks(1);
    });

    loadBooks();
});
</script>
@endsection
