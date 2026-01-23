@foreach($submissions as $submission)
@php
// Decode the submission data (assuming it's stored as a JSON string)
$rawData = json_decode($submission->data, true) ?? [];
@endphp
<tr>
    @foreach($form->fields as $field)
    <td>
        @php
        // Try to get the value by field label or ID, fallback to '-' if not found
        $value = $rawData[$field->label] ?? $rawData[$field->id] ?? '-';

        // If the value is a date string, format it to m/d/Y using Carbon
        $displayValue = (is_string($value) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $value))
        ? \Carbon\Carbon::parse($value)->format('m/d/Y')
        : $value;
        @endphp
        {{ $displayValue }}
    </td>
    @endforeach

    <!-- Action Buttons Column -->
    <td class="text-end action-btns">
        <a href="{{ route('submissions.show', $submission) }}" class="btn btn-outline-info btn-sm" title="View">
            <i class="bi bi-eye"></i>
        </a>
        <a href="{{ route('submissions.edit', $submission) }}" class="btn btn-outline-warning btn-sm" title="Edit">
            <i class="bi bi-pencil"></i>
        </a>
        <button class="btn btn-outline-danger btn-sm delete-submission" data-submission-id="{{ $submission->id }}"
            data-csrf="{{ csrf_token() }}" title="Delete">
            <i class="bi bi-trash"></i>
        </button>
    </td>
</tr>
@endforeach