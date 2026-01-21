@forelse($submissions as $submission)
<tr>
    <td>{{ $submission->form->name }}</td>
    <td>
        <pre style="white-space: pre-wrap; word-wrap: break-word;">
                                    {{ json_encode(json_decode($submission->data), JSON_PRETTY_PRINT) }}
                                </pre>
    </td>
    <td>{{ $submission->created_at->format('Y-m-d H:i') }}</td>
    <td>
        <a href="{{ route('submissions.show', $submission) }}" class="btn btn-sm btn-info">
            <i class="bi bi-eye-fill"></i> View
        </a>
        <a href="{{ route('submissions.edit', $submission) }}" class="btn btn-sm btn-warning">
            <i class="bi bi-pencil-fill"></i> Edit
        </a>
        <form action="{{ route('submissions.destroy', $submission) }}" method="POST" style="display: inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                <i class="bi bi-trash-fill"></i> Delete
            </button>
        </form>
    </td>
</tr>
@empty
<tr>
    <td colspan="4" class="text-center text-muted">No submissions found.</td>
</tr>
@endforelse