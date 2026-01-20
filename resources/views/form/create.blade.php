@extends('layouts.app')

@section('title', 'Create Form')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3>Create New Form</h3>
            </div>
            <div class="card-body">
                <form id="form-builder" action="{{ route('forms.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Form Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                            name="name" value="{{ old('name') }}" required>
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description"
                            name="description" rows="3">{{ old('description') }}</textarea>
                        @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <h4>Fields</h4>
                    <div id="fields-container">
                        <!-- Fields will be added here -->
                    </div>
                    <button type="button" class="btn btn-secondary" id="add-field">Add Field</button>
                    <button type="submit" class="btn btn-primary">Create Form</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('fields-container');
    const oldFields = @json(old('fields', []));
    const errors = @json($errors->toArray());

    // Populate existing fields from old input or errors
    oldFields.forEach((field, index) => {
        addField(field, index, errors);
    });

    // Do not add default empty field
});

function addField(fieldData = {}, index, errors = {}) {
    const container = document.getElementById('fields-container');
    const fieldHtml = `
    <div class="field-item p-3 mb-3 col-12 row align-items-center">
        <div class="mb-2 col-md-4">
            <label class="form-label" for="field-label-${index}">Field Label</label>
            <input type="text" class="form-control ${errors['fields.' + index + '.label'] ? 'is-invalid' : ''}" name="fields[${index}][label]" id="field-label-${index}" value="${fieldData.label || ''}" required>
            ${errors['fields.' + index + '.label'] ? `<div class="invalid-feedback">${errors['fields.' + index + '.label'][0]}</div>` : ''}
        </div>
        <div class="mb-2 col-md-4">
            <label class="form-label" for="field-type-${index}">Field Type</label>
            <select class="form-select ${errors['fields.' + index + '.type'] ? 'is-invalid' : ''}" name="fields[${index}][type]" id="field-type-${index}" required>
                <option value="text" ${fieldData.type === 'text' ? 'selected' : ''}>Text</option>
                <option value="number" ${fieldData.type === 'number' ? 'selected' : ''}>Number</option>
                <option value="email" ${fieldData.type === 'email' ? 'selected' : ''}>Email</option>
                <option value="date" ${fieldData.type === 'date' ? 'selected' : ''}>Date</option>
            </select>
            ${errors['fields.' + index + '.type'] ? `<div class="invalid-feedback">${errors['fields.' + index + '.type'][0]}</div>` : ''}
        </div>
        <div class="mb-2 col-md-2">
            <div class="form-check">
                <input type="hidden" name="fields[${index}][is_required]" value="0">
                <input class="form-check-input" type="checkbox" name="fields[${index}][is_required]" id="field-required-${index}" value="1" ${fieldData.is_required ? 'checked' : ''}>
                <label class="form-check-label" for="field-required-${index}">Required</label>
            </div>
            ${errors['fields.' + index + '.is_required'] ? `<div class="invalid-feedback d-block">${errors['fields.' + index + '.is_required'][0]}</div>` : ''}
        </div>
        <div class="col-md-2">
            <button type="button" class="btn btn-danger btn-sm remove-field">Remove</button>
        </div>
    </div>
    `;
    container.insertAdjacentHTML('beforeend', fieldHtml);
}

document.getElementById('add-field').addEventListener('click', function() {
    const container = document.getElementById('fields-container');
    const fieldIndex = container.children.length;
    addField({}, fieldIndex);
});

// Event delegation for remove buttons
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('remove-field')) {
        e.target.closest('.field-item').remove();
    }
});
</script>
@endsection