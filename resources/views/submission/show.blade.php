@extends('layouts.app')

@section('title', 'Submission Details')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-lg border-0 mb-4">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0">Submission for {{ $submission->form->name }}</h3>
            </div>
            <div class="card-body bg-dark text-light">
                <dl class="row">
                    @php
                    $data = json_decode($submission->data, true);
                    @endphp

                    @foreach($submission->form->fields as $field)
                    <dt class="col-sm-4 fw-bold">{{ $field->label }}</dt>
                    <dd class="col-sm-8">
                        @php
                        // Handle missing or null data
                        $value = $data[$field->label] ?? 'N/A';

                        // Format Date fields (if applicable)
                        if ($field->type == 'date' && $value !== 'N/A') {
                        $value = \Carbon\Carbon::parse($value)->format('m-d-Y');
                        }
                        @endphp
                        <span class="badge bg-secondary p-2">{{ $value }}</span>
                    </dd>
                    @endforeach
                </dl>
            </div>
        </div>

        <div class="mt-4 d-flex justify-content-between">
            <a href="{{ route('forms.show', $submission->form) }}" class="btn btn-outline-primary btn-lg">
                <i class="bi bi-arrow-left-circle me-2"></i>Back to Form
            </a>
            <div>
                <a href="{{ route('submissions.edit', $submission) }}" class="btn btn-warning btn-lg me-2">
                    <i class="bi bi-pencil-fill me-2"></i>Edit
                </a>

                <form action="{{ route('submissions.destroy', $submission) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-lg"
                        onclick="return confirm('Are you sure you want to delete this submission?')">
                        <i class="bi bi-trash-fill me-2"></i>Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection