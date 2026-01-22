@extends('layouts.app')

@section('title', $form->name)

@section('content')

<style>
    body {
        background-color: #020617;
    }

    .card-dark {
        background: linear-gradient(145deg, #020617, #020617);
        border: 1px solid #1e293b;
        border-radius: 16px;
    }

    .card-header-dark {
        background: linear-gradient(135deg, #6366f1, #22d3ee);
        color: #fff;
        border-radius: 16px 16px 0 0;
    }

    .form-label {
        color: #c7d2fe;
        font-weight: 500;
    }

    .form-control {
        background-color: #020617;
        color: #e5e7eb;
        border: 1px solid #1e293b;
        border-radius: 10px;
    }

    .form-control:focus {
        background-color: #020617;
        border-color: #38bdf8;
        box-shadow: 0 0 0 0.2rem rgba(56, 189, 248, 0.35);
        color: #fff;
    }

    .btn-gradient {
        background: linear-gradient(135deg, #6366f1, #22d3ee);
        border: none;
        color: #fff;
        border-radius: 10px;
    }

    .btn-gradient:hover {
        opacity: 0.9;
    }

    .table-dark-custom {
        --bs-table-bg: #020617;
        --bs-table-striped-bg: #020617;
        --bs-table-color: #e5e7eb;
        border-color: #1e293b;
    }

    .table-dark-custom th {
        color: #c7d2fe;
        font-weight: 600;
    }

    .table-dark-custom td {
        vertical-align: middle;
    }

    .badge-required {
        color: #f87171;
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
        <div class="card card-dark shadow-lg mb-4">
            <div class="card-header bg-transparent border-bottom border-light border-opacity-10">
                <h5 class="mb-0 text-light">📄 Submitted Data</h5>
            </div>

            <div class="card-body p-3">
                <div class="d-flex justify-content-between mb-3 text-light">
                    <div class="w-50">
                        <input type="text" id="search-input" class="form-control form-control-lg"
                            placeholder="Search submissions...">
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-dark table-striped table-hover mb-0">
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