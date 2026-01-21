@extends('layouts.app')

@section('title', 'Create Field')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3>Create New Field</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('fields.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="label" class="form-label">Label</label>
                        <input type="text" class="form-control" id="label" name="label" required>
                    </div>
                    <div class="mb-3">
                        <label for="type" class="form-label">Type</label>
                        <select class="form-select" id="type" name="type" required>
                            <option value="text">Text</option>
                            <option value="number">Number</option>
                            <option value="email">Email</option>
                            <option value="date">Date</option>
                            <option value="time">Time</option>
                            <option value="textarea">Textarea</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Create Field</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection