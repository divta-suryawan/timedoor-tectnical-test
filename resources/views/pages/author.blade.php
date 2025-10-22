@extends('base')

@section('content')
    <x-base-title
        title="Top 10 Authors"
        subtitle="Displays the top 10 authors ranked by the highest total votes from all rated books."
    />

    <!-- Author Table -->
    <x-base-table title="Author Data" tableId="authorTable">
        <tr>
            <th>No</th>
            <th>Author Name</th>
            <th>Total Votes</th>
        </tr>
    </x-base-table>
@endsection


@section('scripts')
<script>
$(document).ready(function () {
    const tableBody = $('#authorTable tbody');
    const baseUrl = '/timedoor-test/authors/top';

    function loadAuthors() {
        $.ajax({
            url: `${baseUrl}`,
            type: 'GET',
            beforeSend: function() {
                tableBody.html(`
                    <tr>
                        <td colspan="3" class="text-center text-muted">
                            <div class="spinner-border spinner-border-sm text-primary me-2"></div> Loading authors...
                        </td>
                    </tr>
                `);
            },
            success: function (response) {
                console.log(response);

                const authors = response.data || [];
                tableBody.empty();

                if (authors.length === 0) {
                    tableBody.append(`
                        <tr>
                            <td colspan="3" class="text-center text-muted">No data found</td>
                        </tr>
                    `);
                    return;
                }

                $.each(authors, function (index, author) {
                    tableBody.append(`
                        <tr>
                            <td>${index + 1}</td>
                            <td>${author.name ?? '-'}</td>
                            <td>${author.total_vote ?? 0}</td>
                        </tr>
                    `);
                });
            },
            error: function () {
                tableBody.html(`
                    <tr>
                        <td colspan="3" class="text-center text-danger">Failed to load data. Please try again later.</td>
                    </tr>
                `);
            }
        });
    }

    loadAuthors();
});
</script>
@endsection
