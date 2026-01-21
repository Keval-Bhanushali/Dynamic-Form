@extends('layouts.app')

@section('title', 'Edit Form')

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

    .form-control,
    .form-select {
        background-color: #020617;
        color: #e5e7eb;
        border: 1px solid #1e293b;
        border-radius: 10px;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #38bdf8;
        box-shadow: 0 0 0 0.2rem rgba(56, 189, 248, .35);
        color: #fff;
    }

    .field-item {
        background: #020617;
        border: 1px solid #1e293b;
        border-radius: 14px;
    }

    .btn-gradient {
        background: linear-gradient(135deg, #6366f1, #22d3ee);
        border: none;
        color: #fff;
        border-radius: 10px;
    }

    .btn-gradient:hover {
        opacity: .9;
    }

    .btn-outline-danger {
        border-radius: 10px;
    }

    .form-check-label {
        color: #e5e7eb;
    }
</style>

<div class="row justify-content-center">
    <div class="col-lg-9">
        <div class="card card-dark shadow-lg border-0">
            <div class="card-header card-header-dark">
                <h4 class="mb-0">✏️ Edit Form</h4>
                <small class="opacity-75">Update form details & fields</small>
            </div>

            <div class="card-body p-4">
                <form id="form-builder" action="{{ route('forms.update', $form) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Form Name -->
                    <div class="mb-4">
                        <label class="form-label">Form Name</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $form->name) }}" required>
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="mb-4">
                        <label class="form-label">Description</label>
                        <textarea name="description" rows="3"
                            class="form-control @error('description') is-invalid @enderror">{{ old('description', $form->description) }}</textarea>
                        @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Fields Header -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="text-light mb-0">🧩 Fields</h5>
                        <button type="button" id="add-field" class="btn btn-gradient btn-sm">
                            + Add Field
                        </button>
                    </div>

                    <!-- Fields -->
                    <div id="fields-container"></div>

                    <!-- Submit -->
                    <div class="text-end mt-4">
                        <button type="submit" class="btn btn-gradient px-4">
                            💾 Update Form
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
    const oldFields = @json(old('fields'));
    const existingFields = @json($fields);
    const errors = @json($errors->toArray());

    const fieldsToUse = (oldFields && oldFields.length) ? oldFields : existingFields;

    fieldsToUse.forEach((field, index) => addField(field, index, errors));

    if (!fieldsToUse.length) addField({}, 0, errors);
});

function addField(fieldData = {}, index, errors = {}) {
    const container = document.getElementById('fields-container');

    container.insertAdjacentHTML('beforeend', `
        <div class="field-item p-3 mb-3">
            <div class="row g-3 align-items-end">

                <div class="col-md-4">
                    <label class="form-label">Field Label</label>
                    <input type="text"
                           class="form-control ${errors['fields.' + index + '.label'] ? 'is-invalid' : ''}"
                           name="fields[${index}][label]"
                           value="${fieldData.label || ''}"
                           required>
                    ${errors['fields.' + index + '.label']
                        ? `<div class="invalid-feedback">${errors['fields.' + index + '.label'][0]}</div>` : ''}
                </div>

                <div class="col-md-3">
                    <label class="form-label">Field Type</label>
                    <select class="form-select ${errors['fields.' + index + '.type'] ? 'is-invalid' : ''}"
                            name="fields[${index}][type]"
                            required>
                        <option value="text" ${fieldData.type === 'text' ? 'selected' : ''}>Text</option>
                        <option value="number" ${fieldData.type === 'number' ? 'selected' : ''}>Number</option>
                        <option value="email" ${fieldData.type === 'email' ? 'selected' : ''}>Email</option>
                        <option value="date" ${fieldData.type === 'date' ? 'selected' : ''}>Date</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <div class="form-check mt-4">
                        <input type="hidden" name="fields[${index}][is_required]" value="0">
                        <input class="form-check-input"
                               type="checkbox"
                               name="fields[${index}][is_required]"
                               value="1"
                               ${fieldData.is_required ? 'checked' : ''}>
                        <label class="form-check-label">Required</label>
                    </div>
                </div>

                <div class="col-md-2 text-end">
                    <button type="button"
                            class="btn btn-outline-danger btn-sm remove-field">
                        ✕ Remove
                    </button>
                </div>
            </div>
        </div>
    `);
}

document.getElementById('add-field').addEventListener('click', function () {
    const container = document.getElementById('fields-container');
    addField({}, container.children.length);
});

document.addEventListener('click', function (e) {
    if (e.target.classList.contains('remove-field')) {
        e.target.closest('.field-item').remove();
    }
});
</script>

@endsection