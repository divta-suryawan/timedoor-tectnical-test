@extends('base')

@section('content')
    <x-base-title
        title="Add Book Rating"
        subtitle="Submit a new rating for a selected book. Choose the author to view their books, then rate the book from 1 to 10."
    />

    <!-- Alert container -->
    <div id="alertContainer"></div>

    <x-base-form
        title="Rating Form"
        formId="ratingForm">

        <div class="mb-3">
            <label for="author_id" class="form-label fw-semibold">Select Author</label>
            <select id="author_id" class="form-select" required>
                <option value="">-- Choose Author --</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="book_id" class="form-label fw-semibold">Select Book</label>
            <select id="book_id" class="form-select" required>
                <option value="">-- Choose Book --</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="score" class="form-label fw-semibold">Select Score</label>
            <select id="score" class="form-select" required>
                <option value="">-- Choose Score --</option>
                @for ($i = 1; $i <= 10; $i++)
                    <option value="{{ $i }}">{{ $i }}</option>
                @endfor
            </select>
        </div>

        <div class="text-end mt-3">
            <button type="button" id="submitRating" class="btn btn-primary">
                Submit Rating
            </button>
        </div>
    </x-base-form>
@endsection


@section('scripts')
<script>
$(document).ready(function() {
    const baseUrl = '/timedoor-test';
    const authorUrl = `${baseUrl}/authors`;
    const ratingUrl = `${baseUrl}/ratings/create`;

    const authorSelect = $('#author_id');
    const bookSelect = $('#book_id');
    const scoreSelect = $('#score');
    const alertContainer = $('#alertContainer');

    // Setup CSRF Token for AJAX
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    });

    // Load authors into dropdown
    function loadAuthors() {
        $.ajax({
            url: authorUrl,
            type: 'GET',
            success: function(response) {
                const authors = response.data || [];
                authorSelect.empty().append('<option value="">-- Choose Author --</option>');
                $.each(authors, function(i, author) {
                    authorSelect.append(`<option value="${author.id}">${author.name}</option>`);
                });
            },
            error: function() {
                showAlert('danger', 'Failed to load authors. Please try again later.');
            }
        });
    }

    // Load books by selected author
    authorSelect.on('change', function() {
        const authorId = $(this).val();
        bookSelect.empty().append('<option value="">-- Choose Book --</option>');
        if (!authorId) return;

        $.ajax({
            url: `${authorUrl}/${authorId}/books`,
            type: 'GET',
            success: function(response) {
                const books = response.data || [];
                $.each(books, function(i, book) {
                    bookSelect.append(`<option value="${book.id}">${book.title}</option>`);
                });
            },
            error: function() {
                showAlert('danger', 'Failed to load books for the selected author.');
            }
        });
    });

    // Submit rating
    $('#submitRating').on('click', function() {
        const bookId = bookSelect.val();
        const score = scoreSelect.val();

        if (!authorSelect.val() || !bookId || !score) {
            showAlert('warning', 'Please complete all fields before submitting.');
            return;
        }

        $.ajax({
            url: ratingUrl,
            type: 'POST',
            data: { book_id: bookId, score: score },
            success: function(response) {
                console.log(response);

                showAlert('success', 'Rating submitted successfully!');
                setTimeout(() => window.location.href = '/', 1500);
            },
            error: function(xhr) {
                console.error(xhr.responseText);
                showAlert('danger', 'Failed to submit rating. Please try again.');
            }
        });
    });

    // Simple Bootstrap alert generator
    function showAlert(type, message) {
        const alertHTML = `
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>`;
        alertContainer.html(alertHTML);
    }

    // Initial load
    loadAuthors();
});
</script>
@endsection
