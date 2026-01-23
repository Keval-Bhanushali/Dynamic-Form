@extends('layouts.app')

@section('title', 'Submissions')

@section('content')
<style>
    /* Light Theme Styling */
    body {
        background-color: #f8fafc;
        color: #333;
    }

    .card {
        background-color: #ffffff;
        border-radius: 16px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .card-header {
        background: linear-gradient(135deg, #6366f1, #22d3ee);
        color: #fff;
        border-radius: 16px 16px 0 0;
    }

    .btn-outline-primary {
        border-color: #6366f1;
        color: #6366f1;
    }

    .btn-outline-primary:hover {
        background-color: #6366f1;
        color: #fff;
    }

    .btn-outline-warning {
        border-color: #f59e0b;
        color: #f59e0b;
    }

    .btn-outline-warning:hover {
        background-color: #f59e0b;
        color: #fff;
    }

    .btn-outline-danger {
        border-color: #ef4444;
        color: #ef4444;
    }

    .btn-outline-danger:hover {
        background-color: #ef4444;
        color: #fff;
    }

    .table-light {
        background-color: #f8fafc;
        color: #333;
    }

    .table-light th,
    .table-light td {
        border: 1px solid #e5e7eb;
    }

    .table-light tbody tr:hover {
        background-color: #e9ecef;
    }
</style>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-lg border-0 mb-4">
            <div class="card-header">
                <h3 class="mb-0">Submissions</h3>
            </div>
            <div class="card-body">

                @if($submissions->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped table-light">
                        <thead>
                            <tr>
                                <th>Form Name</th>
                                <th>Submission Data</th>
                                <th>Submitted At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($submissions as $submission)
                            <tr>
                                <td>{{ $submission->form->name }}</td>
                                <td>
                                    <pre style="white-space: pre-wrap; word-wrap: break-word;">
                                        {{ json_encode(json_decode($submission->data), JSON_PRETTY_PRINT) }}
                                    </pre>
                                </td>
                                <td>{{ $submission->created_at->format('Y-m-d H:i') }}</td>
                                <td>
                                    <a href="{{ route('submissions.show', $submission) }}"
                                        class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye-fill"></i> View
                                    </a>
                                    <a href="{{ route('submissions.edit', $submission) }}"
                                        class="btn btn-sm btn-outline-warning">
                                        <i class="bi bi-pencil-fill"></i> Edit
                                    </a>
                                    <form action="{{ route('submissions.destroy', $submission) }}" method="POST"
                                        style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm('Are you sure?')">
                                            <i class="bi bi-trash-fill"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">No submissions found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @else
                <p class="text-center text-muted">No submissions found.</p>
                @endif

                <!-- Pagination -->
                @if($submissions->hasPages())
                <div class="d-flex justify-content-end mt-4">
                    <div class="pagination-container">
                        {{ $submissions->links('pagination::bootstrap-5') }}
                    </div>
                </div>
                @endif

            </div>
        </div>
    </div>
</div>
@endsection