@extends('layouts.app')

@section('title', 'Edit Field')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3>Edit Field</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('fields.update', $field) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="label" class="form-label">Label</label>
                        <input type="text" class="form-control" id="label" name="label" value="{{ $field->label }}"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="type" class="form-label">Type</label>
                        <select class="form-select" id="type" name="type" required>
                            <option value="text" {{ $field->type == 'text' ? 'selected' : '' }}>Text</option>
                            <option value="number" {{ $field->type == 'number' ? 'selected' : '' }}>Number</option>
                            <option value="email" {{ $field->type == 'email' ? 'selected' : '' }}>Email</option>
                            <option value="date" {{ $field->type == 'date' ? 'selected' : '' }}>Date</option>
                            <option value="time" {{ $field->type == 'time' ? 'selected' : '' }}>Time</option>
                            <option value="textarea" {{ $field->type == 'textarea' ? 'selected' : '' }}>Textarea
                            </option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Field</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection