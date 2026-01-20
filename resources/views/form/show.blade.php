@extends('layouts.app')

@section('title', $form->name)

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3>{{ $form->name }}</h3>
                <p>{{ $form->description }}</p>
            </div>
            <div class="card-body">
                <form action="{{ route('forms.submissions.store', $form) }}" method="POST">
                    @csrf
                    @foreach($form->fields as $field)
                    <div class="mb-3">
                        <label for="field_{{ $field->id }}" class="form-label">{{ $field->label }}
                            @if($field->pivot->is_required)<span class="text-danger">*</span>@endif</label>
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
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>

        @if($form->submissions->count() > 0)
        <div class="card mt-4">
            <div class="card-header">
                <h4>Submitted Data</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                @foreach($form->fields as $field)
                                <th>{{ $field->label }}</th>
                                @endforeach
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($form->submissions as $submission)
                            @php
                            $rawData = json_decode($submission->data, true);
                            $mappedData = [];
                            foreach ($form->fields as $field) {
                            if (isset($rawData[$field->id])) {
                            $mappedData[$field->label] = $rawData[$field->id];
                            } elseif (isset($rawData[$field->label])) {
                            $mappedData[$field->label] = $rawData[$field->label];
                            } else {
                            $mappedData[$field->label] = '-';
                            }
                            }
                            @endphp
                            <tr>
                                @foreach($form->fields as $field)
                                <td>{{ $mappedData[$field->label] }}</td>
                                @endforeach
                                <td>
                                    <a href="{{ route('submissions.show', $submission) }}"
                                        class="btn btn-sm btn-info">View</a>
                                    <a href="{{ route('submissions.edit', $submission) }}"
                                        class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('submissions.destroy', $submission) }}" method="POST"
                                        style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Are you sure?')">Delete</button>
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

        <div class="mt-4 mb-4">
            <a href="{{ route('forms.index') }}" class="btn btn-secondary">Back to Forms</a>
            <a href="{{ route('forms.edit', $form) }}" class="btn btn-warning">Edit Form</a>
        </div>
    </div>
</div>
@endsection