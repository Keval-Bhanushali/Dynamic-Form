@extends('layouts.app')

@section('title', 'Submit Form - ' . $form->name)

@section('content')

<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #6366f1, #22d3ee);
        --border-light: rgba(0, 0, 0, 0.08);
    }

    body {
        /* Removed dark background - uses layout */
    }

    .light-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border: 1px solid var(--border-light);
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .light-header {
        background: var(--primary-gradient);
        color: #fff;
        border-radius: 16px 16px 0 0;
    }

    .form-label {
        color: #1e293b;
        font-weight: 500;
    }

    .form-control {
        background-color: #fff;
        color: #1e293b;
        border: 1px solid #d1d5db;
        border-radius: 10px;
    }

    .form-control:focus {
        background-color: #fff;
        border-color: #38bdf8;
        box-shadow: 0 0 0 0.2rem rgba(56, 189, 248, 0.35);
        color: #1e293b;
    }

    .btn-gradient {
        background: var(--primary-gradient);
        border: none;
        color: #fff;
        border-radius: 10px;
    }

    .btn-gradient:hover {
        opacity: 0.9;
        color: #fff;
    }

    .badge-required {
        color: #dc2626;
        background: rgba(239, 68, 68, 0.1);
        padding: 0.25em 0.5em;
        border-radius: 6px;
    }
</style>
<div class="row justify-content-center">
    <div class="col-lg-8">

        <!-- Form Card -->
        <div class="card card-dark shadow-lg mb-4">
            <div class="card-header card-header-dark">
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
                        <input type="text" class="form-control" id="field_{{ $field->id }}"
                            name="data[{{ $field->id }}]" {{ $field->pivot->is_required ? 'required' : '' }}>
                        @break

                        @case('number')
                        <input type="number" class="form-control" id="field_{{ $field->id }}"
                            name="data[{{ $field->id }}]" {{ $field->pivot->is_required ? 'required' : '' }}>
                        @break

                        @case('email')
                        <input type="email" class="form-control" id="field_{{ $field->id }}"
                            name="data[{{ $field->id }}]" {{ $field->pivot->is_required ? 'required' : '' }}>
                        @break

                        @case('date')
                        <input type="date" class="form-control" id="field_{{ $field->id }}"
                            name="data[{{ $field->id }}]" {{ $field->pivot->is_required ? 'required' : '' }}>
                        @break

                        @case('time')
                        <input type="time" class="form-control" id="field_{{ $field->id }}"
                            name="data[{{ $field->id }}]" {{ $field->pivot->is_required ? 'required' : '' }}>
                        @break

                        @case('textarea')
                        <textarea class="form-control" id="field_{{ $field->id }}" rows="4"
                            name="data[{{ $field->id }}]" {{ $field->pivot->is_required ? 'required' : '' }}></textarea>
                        @break
                        @endswitch
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