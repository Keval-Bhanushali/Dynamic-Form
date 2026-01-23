@extends('layouts.app')

@section('title', $form->name)

@section('content')

<style>
    body {
        background-color: #f8fafc;
        /* Light background color */
        color: #333;
        /* Dark text for readability */
    }

    .card-light {
        background: #ffffff;
        /* White background for cards */
        border: 1px solid #d1d5db;
        /* Light border */
        border-radius: 16px;
    }

    .card-header-light {
        background: linear-gradient(135deg, #6366f1, #22d3ee);
        /* Gradient for header */
        color: #fff;
        border-radius: 16px 16px 0 0;
    }

    .form-label {
        color: #1f2937;
        /* Darker text for labels */
        font-weight: 500;
    }

    .form-control {
        background-color: #ffffff;
        /* White background for inputs */
        color: #333;
        /* Dark text for inputs */
        border: 1px solid #d1d5db;
        /* Light border */
        border-radius: 10px;
    }

    .form-control:focus {
        background-color: #ffffff;
        /* Maintain white background when focused */
        border-color: #6366f1;
        /* Focus border color */
        box-shadow: 0 0 0 0.2rem rgba(99, 102, 241, 0.35);
        color: #000;
        /* Black text when focused */
    }

    .btn-gradient {
        background: linear-gradient(135deg, #0a84c6, #1458bd);
        border: none;
        color: #fff;
        border-radius: 10px;
    }

    .btn-gradient:hover {
        opacity: 0.9;
    }

    .table-light-custom {
        background-color: #ffffff;
        /* Light background for the table */
        color: #333;
        /* Dark text for table rows */
        border-color: #d1d5db;
        /* Light border */
    }

    .table-light-custom th {
        color: #1f2937;
        /* Darker text for table headers */
        font-weight: 600;
    }

    .table-light-custom td {
        vertical-align: middle;
    }

    .badge-required {
        color: #ef4444;
        /* Red color for required badge */
    }

    .action-btns .btn {
        border-radius: 8px;
    }
</style>

<div class="row justify-content-center">
    <div class="col-lg-9">

        <div class="d-flex justify-content-end mb-4">
            <a href="{{ route('submission.create', $form) }}" class="btn btn-gradient">
                + New Submission
            </a>
        </div>

        @if($form->submissions->count() > 0)
        <div class="card card-light shadow-lg mb-4">
            <div class="card-header card-header-light bg-transparent border-bottom border-light border-opacity-10">
                <h5 class="mb-0 text-light">📄 Submitted Data</h5>
            </div>

            <div class="card-body p-3">
                <div class="d-flex justify-content-between mb-3">
                    <div class="w-50">
                        <input type="text" id="search-input" class="form-control form-control-lg"
                            placeholder="Search submissions...">
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-light table-striped table-hover mb-0">
                        <thead>
                            <tr>
                                @foreach($form->fields as $field)
                                <th class="text-nowrap">{{ $field->label }}</th>
                                @endforeach
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="submissions-table">
                            @include('form.partials.submission-rows', ['form' => $form, 'submissions' => $submissions])
                        </tbody>
                    </table>
                </div>
            </div>

            @if(isset($submissions) && $submissions->hasPages())
            <div class="d-flex justify-content-end mt-3 mb-3 me-3">
                <div class="pagination-container">
                    {{ $submissions->links('pagination::bootstrap-5') }}
                </div>
            </div>
            @endif
        </div>
        @endif

        <div class="d-flex justify-content-between mb-4">
            <a href="{{ route('forms.index') }}" class="btn btn-outline-secondary">
                ← Back to Forms
            </a>
            <a href="{{ route('forms.edit', $form) }}" class="btn btn-outline-warning">
                ✏️ Edit Form
            </a>
        </div>

    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    $(document).ready(function() {
        $('#search-input').on('input', function() {
            const query = $(this).val().toLowerCase();
            // server side search
            $.ajax({
                url: '{{ route('forms.show', $form) }}',
                type: 'GET',
                data: {
                    search: query
                },
                dataType: 'json',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                success: function(response) {
                    $('#submissions-table').html(response.submissions);
                    $('.pagination-container').html(response.pagination);
                }
            });
        });

        function bindPaginationEvents() {
            $('.pagination-container a').off('click').on('click', function(e) {
                e.preventDefault();
                const url = $(this).attr('href');
                const query = $('#search-input').val().toLowerCase();

                $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: 'json',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    success: function(response) {
                        $('#submissions-table').html(response.submissions);
                        $('.pagination-container').html(response.pagination);

                        // Sync search with pagination
                        $('#submissions-table tr').each(function() {
                            const rowText = $(this).text().toLowerCase();
                            if (rowText.indexOf(query) !== -1) {
                                $(this).show();
                            } else {
                                $(this).hide();
                            }
                        });

                        bindPaginationEvents();
                    }
                });
            });
        }
        bindPaginationEvents();

        $(document).on('click', '.delete-submission', function (e) {
            e.preventDefault();
            
            const $btn = $(this);
            const submissionId = $btn.data('submission-id');
            const csrfToken = $btn.data('csrf');
            
            if (!confirm('Are you sure you want to delete this submission?')) {
                return;
            }
            
            $.ajax({
                url: '/submissions/' + submissionId, 
                type: 'POST',
                data: {
                    _method: 'DELETE',
                    _token: csrfToken,
                },
                success: function (response) {
                    if (response.success) {
                        $btn.closest('tr').fadeOut(200, function () {
                            $(this).remove();
                        });
                    } else {
                        alert(response.message || 'Failed to delete submission.');
                    }
                },
                error: function () {
                    alert('An error occurred while deleting the submission.');
                },
            });
        });
    });
</script>

@endsection