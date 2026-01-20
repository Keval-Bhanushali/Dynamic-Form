@extends('layouts.app')

@section('title', 'Edit Submission')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3>Edit Submission for {{ $submission->form->name }}</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('submissions.update', $submission) }}" method="POST">
                    @csrf
                    @method('PUT')
                    @php $data = json_decode($submission->data, true); @endphp
                    @foreach($submission->form->fields as $field)
                    <div class="mb-3">
                        <label for="field_{{ $field->id }}" class="form-label">{{ $field->label }}
                            @if($field->pivot->is_required)<span class="text-danger">*</span>@endif</label>
                        @switch($field->type)
                        @case('text')
                        <input type="text" class="form-control" id="field_{{ $field->id }}"
                            name="data[{{ $field->id }}]" value="{{ $data[$field->label] ?? '' }}" {{
                            $field->pivot->is_required ? 'required' : '' }}>
                        @break
                        @case('number')
                        <input type="number" class="form-control" id="field_{{ $field->id }}"
                            name="data[{{ $field->id }}]" value="{{ $data[$field->label] ?? '' }}" {{
                            $field->pivot->is_required ? 'required' : '' }}>
                        @break
                        @case('email')
                        <input type="email" class="form-control" id="field_{{ $field->id }}"
                            name="data[{{ $field->id }}]" value="{{ $data[$field->label] ?? '' }}" {{
                            $field->pivot->is_required ? 'required' : '' }}>
                        @break
                        @case('date')
                        <input type="date" class="form-control" id="field_{{ $field->id }}"
                            name="data[{{ $field->id }}]" value="{{ $data[$field->label] ?? '' }}" {{
                            $field->pivot->is_required ? 'required' : '' }}>
                        @break
                        @endswitch
                    </div>
                    @endforeach
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
        <div class="mt-4">
            <a href="{{ route('forms.show',$submission->form) }}" class="btn btn-secondary">Back to Form</a>
        </div>
    </div>
</div>
@endsection