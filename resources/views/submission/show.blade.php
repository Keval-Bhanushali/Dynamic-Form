@extends('layouts.app')

@section('title', 'Submission Details')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3>Submission for {{ $submission->form->name }}</h3>
                <p>Submitted at: {{ $submission->created_at->format('Y-m-d H:i:s') }}</p>
            </div>
            <div class="card-body">
                <dl class="row">
                    @php $data = json_decode($submission->data, true); @endphp
                    @foreach($submission->form->fields as $field)
                    <dt class="col-sm-3">{{ $field->label }}</dt>
                    <dd class="col-sm-9">{{ $data[$field->label] ?? 'N/A' }}</dd>
                    @endforeach
                </dl>
            </div>
        </div>
        <div class="mt-4">
            <a href="{{ route('forms.show', $submission->form) }}" class="btn btn-secondary">Back to Form</a>
            <a href="{{ route('submissions.edit', $submission) }}" class="btn btn-warning">Edit</a>
            <form action="{{ route('submissions.destroy', $submission) }}" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
            </form>
        </div>
    </div>
</div>
@endsection