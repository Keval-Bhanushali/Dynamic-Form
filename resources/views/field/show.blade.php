@extends('layouts.app')

@section('title', $field->label)

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3>{{ $field->label }}</h3>
            </div>
            <div class="card-body">
                <p><strong>Type:</strong> {{ $field->type }}</p>
                <a href="{{ route('fields.index') }}" class="btn btn-secondary">Back to Fields</a>
                <a href="{{ route('fields.edit', $field) }}" class="btn btn-warning">Edit</a>
            </div>
        </div>
    </div>
</div>
@endsection