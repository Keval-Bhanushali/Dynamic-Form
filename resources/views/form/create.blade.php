@extends('layouts.app')

@section('title', 'Create Form')

@section('content')

<style>
    :root {
    --primary-gradient: linear-gradient(135deg, #6366f1, #22d3ee);
    --border-light: rgba(0, 0, 0, 0.08);
    --glass-bg: rgba(255, 255, 255, 0.95);
    }
    
    .light-card {
    background: var(--glass-bg);
    backdrop-filter: blur(20px);
    border: 1px solid var(--border-light);
    border-radius: 24px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.12);
    }
    
    .light-header {
    background: var(--primary-gradient);
    color: #fff;
    border-radius: 24px 24px 0 0;
    position: relative;
    overflow: hidden;
    }
    
    .light-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: rgba(255, 255, 255, 0.3);
    }
    
    .form-label {
    color: #1e293b;
    font-weight: 600;
    font-size: 0.95rem;
    margin-bottom: 0.75rem;
    }
    
    .form-control,
    .form-select {
    background: rgba(255, 255, 255, 0.9);
    color: #1e293b;
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    padding: 0.875rem 1.25rem;
    font-size: 0.95rem;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .form-control:focus,
    .form-select:focus {
    background: #fff;
    border-color: #38bdf8;
    box-shadow: 0 0 0 0.25rem rgba(56, 189, 248, 0.15), 0 4px 12px rgba(56, 189, 248, 0.1);
    color: #1e293b;
    transform: translateY(-1px);
    }
    
    .form-control::placeholder {
    color: #94a3b8;
    }
    
    .field-item {
    background: rgba(255, 255, 255, 0.85);
    backdrop-filter: blur(12px);
    border: 2px solid #f1f5f9;
    border-radius: 20px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .field-item:hover {
    border-color: #3b82f6;
    box-shadow: 0 16px 48px rgba(59, 130, 246, 0.15);
    transform: translateY(-4px);
    }
    
    .btn-gradient {
    background: var(--primary-gradient);
    border: none;
    color: #fff;
    border-radius: 12px;
    font-weight: 600;
    padding: 0.75rem 1.5rem;
    box-shadow: 0 6px 20px rgba(99, 102, 241, 0.3);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .btn-gradient:hover {
    opacity: 0.95;
    color: #fff;
    transform: translateY(-2px);
    box-shadow: 0 12px 32px rgba(99, 102, 241, 0.4);
    }
    
    .btn-outline-danger {
    border: 2px solid #ef4444;
    color: #ef4444;
    border-radius: 12px;
    font-weight: 500;
    padding: 0.625rem 1.25rem;
    transition: all 0.3s ease;
    }
    
    .btn-outline-danger:hover {
    background-color: #ef4444;
    color: #fff;
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(239, 68, 68, 0.3);
    }
    
    .form-check-label {
    color: #374151;
    font-weight: 500;
    }
    
    .form-check-input:checked {
    background-color: #3b82f6;
    border-color: #3b82f6;
    }
    
    .text-light {
    color: #1e293b !important;
    }
    
    /* Enhanced spacing and layout */
    .field-item .row {
    margin: 0 -0.75rem;
    }
    
    .field-item .col-md-4,
    .field-item .col-md-3,
    .field-item .col-md-2 {
    padding: 0 0.75rem;
    }
    
    /* Form validation states */
    .is-invalid {
    border-color: #ef4444 !important;
    box-shadow: 0 0 0 0.25rem rgba(239, 68, 68, 0.15) !important;
    }
    
    .invalid-feedback {
    display: block;
    color: #ef4444;
    font-size: 0.875rem;
    margin-top: 0.5rem;
    }
</style>

<div class="row justify-content-center">
    <div class="col-lg-9">
        <div class="card light-card shadow-lg border-0">
            <div class="card-header light-header p-4">
                <h4 class="mb-0">✨ Create New Form</h4>
                <small class="opacity-75">Build your dynamic form</small>
            </div>

            <div class="card-body p-4">
                <form action="{{ route('forms.store') }}" method="POST">
                    @csrf

                    <!-- Form Name -->
                    <div class="mb-4">
                        <label class="form-label">Form Name
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name') }}" required>
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="mb-4">
                        <label class="form-label">Description</label>
                        <textarea name="description" rows="3" class="form-control">{{ old('description') }}</textarea>
                    </div>

                    <!-- Fields -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="text-dark mb-0">🧩 Form Fields</h5>
                        <button type="button" id="add-field" class="btn btn-gradient btn-sm">
                            + Add Field
                        </button>
                    </div>

                    <div id="fields-container"></div>

                    <div class="text-end mt-4">
                        <button type="button" class="btn btn-outline-secondary me-2"
                            onclick="window.location='{{ route('forms.index') }}'">
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-gradient px-4">
                            🚀 Create Form
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const oldFields = @json(old('fields', []));
        oldFields.forEach((field, index) => addField(field, index));
    });

    function addField(fieldData = {}, index) {
        const container = document.getElementById('fields-container');

        container.insertAdjacentHTML('beforeend', `
            <div class="field-item p-3 mb-3">
                <div class="row g-3 align-items-end">

                    <div class="col-md-4">
                        <label class="form-label">Field Label
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               class="form-control"
                               name="fields[${index}][label]"
                               value="${fieldData.label || ''}"
                               required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Field Type
                            <span class="text-danger">*</span>
                        </label>
                        <select class="form-select"
                                name="fields[${index}][type]"
                                required>
                            <option value="text" ${fieldData.type === 'text' ? 'selected' : ''}>Text</option>
                            <option value="number" ${fieldData.type === 'number' ? 'selected' : ''}>Number</option>
                            <option value="email" ${fieldData.type === 'email' ? 'selected' : ''}>Email</option>
                            <option value="date" ${fieldData.type === 'date' ? 'selected' : ''}>Date</option>
                            <option value="time" ${fieldData.type === 'time' ? 'selected' : ''}>Time</option>
                            <option value="textarea" ${fieldData.type === 'textarea' ? 'selected' : ''}>Textarea</option>
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