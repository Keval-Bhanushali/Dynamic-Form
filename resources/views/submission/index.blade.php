@extends('layouts.app')

@section('title', 'Submissions')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h1 class="mb-4">Form Submissions</h1>
        <div class="card shadow-lg border-0">
            <div class="card-body bg-dark text-light">
                <table class="table table-striped table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Form</th>
                            <th>Data</th>
                            <th>Submitted At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="submissionsContainer">
                        @include('submission.partials.submissions-table')
                    </tbody>
                </table>

                <!-- Pagination (if needed) -->
                @if($submissions instanceof \Illuminate\Pagination\LengthAwarePaginator)
                <div class="d-flex justify-content-between align-items-center mt-4" id="paginationContainer">
                    <div class="text-muted small">
                        Showing {{ $submissions->firstItem() }} to {{ $submissions->lastItem() }} of {{
                        $submissions->total() }} submissions
                    </div>
                    <div id="paginationLinks">
                        {{ $submissions->links('pagination::bootstrap-5') }}
                    </div>
                </div>
                @endif

                <script>
                    $(document).ready(function() {
    // Function to bind pagination events
    function bindPaginationEvents() {
        $('#paginationContainer a').off('click').on('click', function(e) {
            e.preventDefault();
            const url = $(this).attr('href');

            $.ajax({
                url: url,
                type: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                success: function(response) {
                    $('#submissionsContainer').html(response.html);
                    $('#paginationLinks').html(response.pagination);
                    // Update showing text
                    const showingText = 'Showing ' + (response.current_page * response.per_page - response.per_page + 1) +
                                      ' to ' + Math.min(response.current_page * response.per_page, response.total) +
                                      ' of ' + response.total + ' submissions';
                    $('#paginationContainer .text-muted').text(showingText);
                    // Rebind events after content update
                    bindPaginationEvents();
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                    // Fallback to normal navigation
                    window.location.href = url;
                }
            });
        });
    }

    // Bind events initially
    bindPaginationEvents();
});
                </script>
            </div>
        </div>
    </div>
</div>
@endsection