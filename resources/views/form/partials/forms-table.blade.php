@forelse($forms as $form)
<div class="form-row-hover">
    <div class="row g-0 align-items-center py-4 px-4 border-bottom"
        style="border-color: rgba(0, 0, 0, 0.08) !important;">
        <!-- Form Info -->
        <div class="col-lg-3">
            <div class="d-flex align-items-center">
                <div class="icon-circle me-3 bg-primary-subtle">
                    <i class="bi bi-file-earmark-text text-primary fs-4"></i>
                </div>
                <div class="min-w-0 flex-grow-1">
                    <h6 class="mb-1 fw-bold text-dark">{{ $form->name ?? 'Unnamed Form' }}</h6>
                    @if($form->description)
                    <p class="mb-0 text-muted small">
                        {{ Str::limit($form->description, 80) }}
                    </p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Fields Count -->
        <div class="col-lg-3 text-center mt-3 mt-lg-0">
            <span class="badge badge-light-info fs-6 px-3 py-2 fw-semibold">
                {{ $form->fields->count() }}
            </span>
            <small class="d-block text-muted mt-1 fw-medium">Fields</small>
        </div>

        <!-- Submissions -->
        <div class="col-lg-3 text-center mt-3 mt-lg-0">
            <span class="badge badge-light-success fs-6 px-3 py-2 fw-semibold">
                {{ $form->submissions->count() }}
            </span>
            <small class="d-block text-muted mt-1 fw-medium">Responses</small>
        </div>

        <!-- Actions -->
        <div class="col-lg-3 text-end mt-3 mt-lg-0">
            <div class="d-flex gap-2 justify-content-end flex-wrap">
                <a href="{{ route('forms.show', $form) }}" class="btn btn-outline-primary btn-sm px-3"
                    title="Preview Form">
                    <i class="bi bi-eye"></i>
                </a>
                <a href="{{ route('forms.edit', $form) }}" class="btn btn-outline-warning btn-sm px-3"
                    title="Edit Form">
                    <i class="bi bi-pencil"></i>
                </a>
                <form action="{{ route('forms.destroy', $form) }}" method="POST" class="d-inline"
                    onsubmit="return confirm('Delete {{ $form->name ?? 'this form' }}? This cannot be undone.')"
                    style="margin-left: 0.25rem;">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger btn-sm px-3" title="Delete Form">
                        <i class="bi bi-trash"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@empty
<!-- Enhanced Empty State -->
<div class="empty-state text-center py-5 m-4">
    <div class="mb-4">
        <div class="icon-circle mx-auto mb-3 d-block bg-secondary-subtle" style="width: 80px; height: 80px;">
            <i class="bi bi-file-earmark-x fs-1 text-muted"></i>
        </div>
        <h4 class="fw-bold text-muted mb-3">No forms yet</h4>
        <p class="text-muted mb-4 lead">
            Create your first dynamic form to get started.
        </p>
    </div>
    <div class="row g-3 justify-content-center">
        <div class="col-md-4">
            <a href="{{ route('forms.create') }}" class="btn btn-gradient w-100 px-4 py-2">
                <i class="bi bi-plus-circle me-2"></i>Create Form
            </a>
        </div>
    </div>
</div>
@endforelse