@extends('layouts.app')

@section('title', 'Forms')

@section('content')

<style>
    body {
        background-color: #020617;
    }

    .page-header {
        background: linear-gradient(135deg, #1e293b, #020617);
        border-radius: 16px;
        padding: 24px;
        border: 1px solid #1e293b;
    }

    .card-dark {
        background: linear-gradient(145deg, #020617, #020617);
        border: 1px solid #1e293b;
        border-radius: 16px;
    }

    .form-row-hover {
        transition: all 0.35s ease;
    }

    .form-row-hover:hover {
        background: rgba(99, 102, 241, 0.12);
        border-left: 4px solid #6366f1;
        transform: translateX(6px);
    }

    .badge-dark-info {
        background: rgba(56, 189, 248, 0.15);
        color: #38bdf8;
    }

    .badge-dark-success {
        background: rgba(34, 197, 94, 0.15);
        color: #22c55e;
    }

    .icon-circle {
        background: rgba(99, 102, 241, 0.15);
        padding: 14px;
        border-radius: 50%;
    }

    .btn-gradient {
        background: linear-gradient(135deg, #6366f1, #22d3ee);
        border: none;
        color: #fff;
    }

    .btn-gradient:hover {
        opacity: 0.9;
    }

    .btn-outline-info,
    .btn-outline-warning,
    .btn-outline-danger {
        border-radius: 8px;
    }

    .text-muted {
        color: #94a3b8 !important;
    }

    .empty-state {
        background: linear-gradient(145deg, #020617, #020617);
        border-radius: 16px;
        border: 1px dashed #1e293b;
    }
</style>

<!-- Header -->
<div class="page-header mb-5">
    <div class="row align-items-center">
        <div class="col-md-6 d-flex align-items-center">
            <i class="bi bi-file-earmark-text-fill fs-1 text-primary me-3"></i>
            <div>
                <h1 class="h3 mb-1 fw-bold text-light">Forms Management</h1>
                <small class="text-muted">Manage your dynamic forms</small>
            </div>
        </div>
        <div class="col-md-6 text-md-end mt-3 mt-md-0">
            <a href="{{ route('forms.create') }}" class="btn btn-gradient btn-lg px-4 shadow">
                <i class="bi bi-plus-circle me-2"></i>Create New Form
            </a>
        </div>
    </div>
</div>

<!-- Forms List -->
<div class="card card-dark shadow-lg overflow-hidden">
    <div class="card-header bg-transparent py-4 border-bottom border-light border-opacity-10">
        <h5 class="mb-0 fw-bold text-light">
            <i class="bi bi-table me-2"></i>All Forms
        </h5>
    </div>

    <div class="card-body p-0">
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
                                {{ Str::limit($form->description, 80) }}
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
    </div>
</div>

<!-- Pagination -->
@if(isset($forms) && $forms instanceof \Illuminate\Pagination\LengthAwarePaginator)
<div class="d-flex justify-content-between align-items-center mt-5 pt-4 border-top border-light border-opacity-10">
    <div class="text-muted small">
        Showing {{ $forms->firstItem() ?? 0 }} to {{ $forms->lastItem() ?? 0 }} of {{ $forms->total() }} forms
    </div>
    {{ $forms->links('pagination::bootstrap-5') }}
</div>
@endif

@endsection