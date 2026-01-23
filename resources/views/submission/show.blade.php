@extends('layouts.app')

@section('title', 'Submission Details')

@section('content')

<style>
    body {
        background-color: #f8fafc;
        /* Light background */
        color: #333;
        /* Dark text for readability */
    }

    .card {
        background-color: #ffffff;
        /* White background for cards */
        border: 1px solid #e5e7eb;
        /* Light border */
        border-radius: 16px;
    }

    .card-header {
        background-color: #3b5cee;
        /* Green header for cards */
        color: #fff;
        border-radius: 16px 16px 0 0;
    }

    .card-body {
        background-color: #ffffff;
        /* White background for the body */
        color: #333;
        /* Dark text color */
    }

    .badge {
        background-color: #e0e0e0;
        /* Light grey background for badges */
        color: #333;
        /* Dark text color for badges */
        padding: 5px 10px;
        border-radius: 10px;
    }

    .btn-outline-primary {
        border-color: #2377e5;
        /* Green border for primary button */
        color: #0c82d0;
    }

    .btn-outline-primary:hover {
        background-color: #136eaf;
        color: #fff;
    }

    .btn-warning {
        background-color: #ff9800;
        /* Yellow for Edit button */
        border-color: #ff9800;
        color: #fff;
    }

    .btn-warning:hover {
        background-color: #f57c00;
        border-color: #f57c00;
    }

    .btn-danger {
        background-color: #f44336;
        /* Red for Delete button */
        border-color: #f44336;
        color: #fff;
    }

    .btn-danger:hover {
        background-color: #e53935;
        border-color: #e53935;
    }
</style>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-lg mb-4">
            <div class="card-header">
                <h3 class="mb-0">Submission for {{ $submission->form->name }}</h3>
            </div>
            <div class="card-body">
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
                        <span class="badge">{{ $value }}</span>
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