@extends('layouts.app')

@section('title', 'Submit Form - ' . $form->name)

@section('content')

<style>
    body {
        background-color: #f8fafc;
        /* Light background */
        color: #333;
        /* Dark text for readability */
    }

    .card-light {
        background: #ffffff;
        /* Light background for the card */
        border: 1px solid #e5e7eb;
        /* Light border color */
        border-radius: 16px;
    }

    .card-header-light {
        background: linear-gradient(135deg, #1255d1, #6ca0de);
        /* Green gradient for header */
        color: #fff;
        border-radius: 16px 16px 0 0;
    }

    .form-label {
        color: #4b5563;
        /* Darker label color for better readability */
        font-weight: 500;
    }

    .form-control {
        background-color: #ffffff;
        /* White background for inputs */
        color: #333;
        /* Dark text for inputs */
        border: 1px solid #d1d5db;
        /* Light border color */
        border-radius: 10px;
    }

    .form-control:focus {
        background-color: #ffffff;
        border-color: #34d399;
        /* Green border on focus */
        box-shadow: 0 0 0 0.2rem rgba(56, 189, 248, 0.35);
        /* Focus shadow */
        color: #333;
    }

    .btn-gradient {
        background: linear-gradient(135deg, #1255d1, #6ca0de);
        /* Green gradient button */
        border: none;
        color: #fff;
        border-radius: 10px;
    }

    .btn-gradient:hover {
        opacity: 0.9;
    }

    .badge-required {
        color: #f87171;
        /* Red for required fields */
    }
</style>

<div class="row justify-content-center">
    <div class="col-lg-8">

        <!-- Form Card -->
        <div class="card card-light shadow-lg mb-4">
            <div class="card-header card-header-light">
                <h4 class="mb-1">{{ $form->name }}</h4>
                <small class="opacity-75">{{ $form->description }}</small>
            </div>

            <div class="card-body p-4">
                <form action="{{ route('forms.submissions.store', $form) }}" method="POST">
                    @csrf

                    @foreach($form->fields as $field)
                    <div class="mb-4">
                        <label for="field_{{ $field->id }}" class="form-label">
                            {{ $field->label }}
                            @if($field->pivot->is_required)
                            <span class="badge-required">*</span>
                            @endif
                        </label>

                        @switch($field->type)
                        @case('text')
                        <input type="text" class="form-control @error('data.' . $field->id) is-invalid @enderror"
                            id="field_{{ $field->id }}" name="data[{{ $field->id }}]" {{ $field->pivot->is_required ?
                        'required' : '' }}>
                        @break

                        @case('number')
                        <input type="number" class="form-control @error('data.' . $field->id) is-invalid @enderror"
                            id="field_{{ $field->id }}" name="data[{{ $field->id }}]" {{ $field->pivot->is_required ?
                        'required' : '' }}>
                        @break

                        @case('email')
                        <input type="email" class="form-control @error('data.' . $field->id) is-invalid @enderror"
                            id="field_{{ $field->id }}" name="data[{{ $field->id }}]" {{ $field->pivot->is_required ?
                        'required' : '' }}>
                        @break

                        @case('date')
                        <input type="date" class="form-control @error('data.' . $field->id) is-invalid @enderror"
                            id="field_{{ $field->id }}" name="data[{{ $field->id }}]" {{ $field->pivot->is_required ?
                        'required' : '' }}>
                        @break

                        @case('time')
                        <input type="time" class="form-control @error('data.' . $field->id) is-invalid @enderror"
                            id="field_{{ $field->id }}" name="data[{{ $field->id }}]" {{ $field->pivot->is_required ?
                        'required' : '' }}>
                        @break

                        @case('textarea')
                        <textarea class="form-control @error('data.' . $field->id) is-invalid @enderror"
                            id="field_{{ $field->id }}" rows="4" name="data[{{ $field->id }}]" {{
                            $field->pivot->is_required ? 'required' : '' }}></textarea>
                        @break
                        @endswitch

                        @error('data.' . $field->id)
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    @endforeach

                    <div class="text-end">
                        <a href="{{ route('forms.show', $form) }}" class="btn btn-outline-secondary me-2">
                            <i class="bi bi-arrow-left me-1"></i>Back to Form
                        </a>
                        <button type="submit" class="btn btn-gradient px-4">
                            🚀 Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

@endsection