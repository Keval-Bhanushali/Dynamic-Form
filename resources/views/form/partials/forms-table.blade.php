@forelse($forms as $form)
<div class="form-row-hover">
    <div class="row g-0 align-items-center py-4 px-4 border-bottom border-light border-opacity-10">
        <!-- Form Info -->
        <div class="col-lg-3">
            <div class="d-flex align-items-center">
                <div class="icon-circle me-3">
                    <i class="bi bi-file-earmark-text text-primary fs-4"></i>
                </div>
                <div class="min-w-0">
                    <h6 class="mb-1 fw-bold text-light">{{ $form->name }}</h6>
                    <p class="mb-0 text-muted small">
                        {{ Str::limit($form->description ?? '', 80) }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Fields Count -->
        <div class="col-lg-3 text-center mt-3 mt-lg-0">
            <span class="badge badge-dark-info fs-6 px-3 py-2">
                {{ $form->fields->count() }}
            </span>
            <small class="d-block text-muted mt-1">Fields</small>
        </div>

        <!-- Submissions -->
        <div class="col-lg-3 text-center mt-3 mt-lg-0">
            <span class="badge badge-dark-success fs-6 px-3 py-2">
                {{ $form->submissions->count() }}
            </span>
            <small class="d-block text-muted mt-1">Submissions</small>
        </div>

        <!-- Actions -->
        <div class="col-lg-3 text-end mt-3 mt-lg-0">
            <div class="d-flex gap-2 justify-content-end">
                <a href="{{ route('forms.show', $form) }}" class="btn btn-outline-info btn-sm" title="View">
                    <i class="bi bi-eye"></i>
                </a>
                <a href="{{ route('forms.edit', $form) }}" class="btn btn-outline-warning btn-sm" title="Edit">
                    <i class="bi bi-pencil"></i>
                </a>
                <form action="{{ route('forms.destroy', $form) }}" method="POST"
                    onsubmit="return confirm('Delete {{ $form->name }}?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger btn-sm" title="Delete">
                        <i class="bi bi-trash"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@empty
<!-- Empty State -->
<div class="empty-state text-center py-5 m-4">
    <i class="bi bi-file-earmark-x fs-1 text-muted mb-3 d-block"></i>
    <h5 class="text-light mb-2">No forms created yet</h5>
    <p class="text-muted mb-4">
        Get started by creating your first dynamic form.
    </p>
    <a href="{{ route('forms.create') }}" class="btn btn-gradient px-4">
        <i class="bi bi-plus-circle me-2"></i>Create First Form
    </a>
</div>
@endforelse