@extends('layouts.app')

@section('title', 'Edit Submission')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card light-card shadow-lg border-0 mb-4">
            <div class="card-header light-header">
                <h3 class="mb-0">Edit Submission for {{ $submission->form->name }}</h3>
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
                        <input type="text" class="form-control @error('data.' . $field->id) is-invalid @enderror"
                            id="field_{{ $field->id }}" name="data[{{ $field->id }}]"
                            value="{{ old('data.' . $field->id, $data[$field->label] ?? '') }}" {{
                            $field->pivot->is_required ? 'required' : '' }}>
                        @break
                        @case('number')
                        <input type="number" class="form-control @error('data.' . $field->id) is-invalid @enderror"
                            id="field_{{ $field->id }}" name="data[{{ $field->id }}]"
                            value="{{ old('data.' . $field->id, $data[$field->label] ?? '') }}" {{
                            $field->pivot->is_required ? 'required' : '' }}>
                        @break
                        @case('email')
                        <input type="email" class="form-control @error('data.' . $field->id) is-invalid @enderror"
                            id="field_{{ $field->id }}" name="data[{{ $field->id }}]"
                            value="{{ old('data.' . $field->id, $data[$field->label] ?? '') }}" {{
                            $field->pivot->is_required ? 'required' : '' }}>
                        @break
                        @case('date')
                        <input type="date" class="form-control @error('data.' . $field->id) is-invalid @enderror"
                            id="field_{{ $field->id }}" name="data[{{ $field->id }}]"
                            value="{{ old('data.' . $field->id, $data[$field->label] ?? '') }}" {{
                            $field->pivot->is_required ? 'required' : '' }}>
                        @break
                        @case('time')
                        <input type="time" class="form-control @error('data.' . $field->id) is-invalid @enderror"
                            id="field_{{ $field->id }}" name="data[{{ $field->id }}]"
                            value="{{ old('data.' . $field->id, $data[$field->label] ?? '') }}" {{
                            $field->pivot->is_required ? 'required' : '' }}>
                        @break
                        @case('textarea')
                        <textarea class="form-control @error('data.' . $field->id) is-invalid @enderror"
                            id="field_{{ $field->id }}" name="data[{{ $field->id }}]" rows="4" {{
                            $field->pivot->is_required ? 'required' : '' }}>{{ old('data.' . $field->id, $data[$field->label] ?? '') }}</textarea>
                        @break
                        @endswitch

                        @error('data.' . $field->id)
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    @endforeach

                    <button type="submit" class="btn btn-gradient px-5 py-3 fw-semibold shadow-lg">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        Update
                    </button>
                </form>
            </div>
        </div>

        <div class="mt-4">
            <a href="{{ route('forms.show', $submission->form) }}" class="btn btn-outline-primary btn-lg">
                <i class="bi bi-arrow-left-circle me-2"></i>Back to Form
            </a>
        </div>
    </div>
</div>
@endsection