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
                        @endswitch
                    </div>
                    @endforeach

                    <div class="text-end">
                        <button type="submit" class="btn btn-gradient px-4">
                            🚀 Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Submissions -->
        @if($form->submissions->count() > 0)
        <div class="card card-dark shadow-lg mb-4">
            <div class="card-header bg-transparent border-bottom border-light border-opacity-10">
                <h5 class="mb-0 text-light">📄 Submitted Data</h5>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-dark-custom mb-0">
                        <thead>
                            <tr>
                                @foreach($form->fields as $field)
                                <th>{{ $field->label }}</th>
                                @endforeach
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($form->submissions as $submission)
                            @php $rawData = json_decode($submission->data, true) ?? []; @endphp
                            <tr>
                                @foreach($form->fields as $field)
                                <td>
                                    @php
                                    $value = $rawData[$field->label] ?? $rawData[$field->id] ?? '-';
                                    $displayValue = (is_string($value) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $value))
                                    ? \Carbon\Carbon::parse($value)->format('m/d/Y')
                                    : $value;
                                    @endphp
                                    {{ $displayValue }}
                                </td>
                                @endforeach
                                <td class="text-end action-btns">
                                    <a href="{{ route('submissions.show', $submission) }}"
                                        class="btn btn-outline-info btn-sm">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    <a href="{{ route('submissions.edit', $submission) }}"
                                        class="btn btn-outline-warning btn-sm">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    <form action="{{ route('submissions.destroy', $submission) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-outline-danger btn-sm">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif

        <!-- Footer Buttons -->
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

@endsection