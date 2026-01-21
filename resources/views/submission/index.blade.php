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
                                <a href="{{ route('submissions.show', $submission) }}" class="btn btn-sm btn-info">
                                    <i class="bi bi-eye-fill"></i> View
                                </a>
                                <a href="{{ route('submissions.edit', $submission) }}" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil-fill"></i> Edit
                                </a>
                                <form action="{{ route('submissions.destroy', $submission) }}" method="POST"
                                    style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
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

                <!-- Pagination (if needed) -->
                @if($submissions instanceof \Illuminate\Pagination\LengthAwarePaginator)
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-muted small">
                        Showing {{ $submissions->firstItem() }} to {{ $submissions->lastItem() }} of {{
                        $submissions->total() }} submissions
                    </div>
                    <div>
                        {{ $submissions->links('pagination::bootstrap-5') }}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection