@extends('layouts.app')

@section('title', 'Forms')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Forms</h1>
            <a href="{{ route('forms.create') }}" class="btn btn-primary">Create</a>
        </div>
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Fields</th>
                            <th>Submissions</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($forms as $form)
                        <tr>
                            <td>{{ $form->name }}</td>
                            <td>{{ Str::limit($form->description, 50) }}</td>
                            <td>{{ $form->fields->count() }}</td>
                            <td>{{ $form->submissions->count() }}</td>
                            <td>
                                <a href="{{ route('forms.show', $form) }}" class="btn btn-sm btn-info">View</a>
                                <a href="{{ route('forms.edit', $form) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('forms.destroy', $form) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center">No forms found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection