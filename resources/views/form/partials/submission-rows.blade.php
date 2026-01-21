@foreach($submissions as $submission)
@php $rawData = json_decode($submission->data, true) ?? []; @endphp
<tr>
    @foreach($form->fields as $field)
    <td>
        @php
        $value = $rawData[$field->label] ?? $rawData[$field->id] ?? '-';
        $displayValue = (is_string($value) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $value))
        ? \Carbon\Carbon::parse($value)->format('m/d/Y')
        : $value;
        @endphp
        {{ $displayValue }}
    </td>
    @endforeach
    <td class="text-end action-btns">
        <a href="{{ route('submissions.show', $submission) }}" class="btn btn-outline-info btn-sm">
            <i class="bi bi-eye"></i>
        </a>
        <a href="{{ route('submissions.edit', $submission) }}" class="btn btn-outline-warning btn-sm">
            <i class="bi bi-pencil"></i>
        </a>
        <button class="btn btn-outline-danger btn-sm delete-submission" data-submission-id="{{ $submission->id }}"
            data-csrf="{{ csrf_token() }}">
            <i class="bi bi-trash"></i>
        </button>
    </td>
</tr>
@endforeach