@extends('layouts.app')

@section('title', 'Fields')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Fields</h1>
            <a href="{{ route('fields.create') }}" class="btn btn-primary">Create New Field</a>
        </div>
        <div class="card">
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Label</th>
                            <th>Type</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($fields as $field)
                        <tr>
                            <td>{{ $field->label }}</td>
                            <td>{{ $field->type }}</td>
                            <td>
                                <a href="{{ route('fields.show', $field) }}" class="btn btn-sm btn-info">View</a>
                                <a href="{{ route('fields.edit', $field) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('fields.destroy', $field) }}" method="POST"
                                    style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center">No fields found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection