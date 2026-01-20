@extends('layouts.app')

@section('title', 'Submissions')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h1>Form Submissions</h1>
        <div class="card">
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
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
                                <pre>{{ json_encode(json_decode($submission->data), JSON_PRETTY_PRINT) }}</pre>
                            </td>
                            <td>{{ $submission->created_at->format('Y-m-d H:i') }}</td>
                            <td>
                                <a href="{{ route('submissions.show', $submission) }}"
                                    class="btn btn-sm btn-info">View</a>
                                <a href="{{ route('submissions.edit', $submission) }}"
                                    class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('submissions.destroy', $submission) }}" method="POST"
                                    style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center">No submissions found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection