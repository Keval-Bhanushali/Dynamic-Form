@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #3b82f6, #1d4ed8);
        --card-hover-shadow: 0 0.5rem 2rem rgba(0, 0, 0, 0.1);
        --stats-gradient-1: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --stats-gradient-2: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        --stats-gradient-3: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    }

    .card {
        transition: all 0.3s ease;
        border: 1px solid rgba(0, 0, 0, 0.08);
    }

    .card:hover {
        transform: translateY(-4px);
        box-shadow: var(--card-hover-shadow) !important;
    }

    .stats-card {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(0, 0, 0, 0.08);
        position: relative;
        overflow: hidden;
    }

    .stats-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--primary-gradient);
    }

    .stats-card.forms::before {
        background: var(--stats-gradient-1);
    }

    .stats-card.submissions::before {
        background: var(--stats-gradient-2);
    }

    .stats-card.responses::before {
        background: var(--stats-gradient-3);
    }

    .recent-forms .list-group-item {
        background: rgba(255, 255, 255, 0.7);
        border: 1px solid rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        backdrop-filter: blur(5px);
    }

    .recent-forms .list-group-item:hover {
        background: rgba(59, 130, 246, 0.08);
        border-color: rgba(59, 130, 246, 0.2);
        transform: translateX(4px);
    }

    .empty-state {
        padding: 3rem 1rem;
        text-align: center;
        color: #64748b;
    }

    .empty-state i {
        font-size: 4rem;
        opacity: 0.5;
        margin-bottom: 1rem;
    }
</style>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h2 mb-1">Dashboard</h1>
                    <p class="mb-0 text-muted">Welcome back! Here's what's happening with your forms.</p>
                </div>
            </div>

            <!-- Stats Cards - Complete Row -->
            <div class="row g-4 mb-5">
                <!-- Total Forms -->
                <div class="col-md-4 col-lg-3">
                    <div class="card border-0 shadow-sm h-100 text-dark stats-card forms">
                        <div class="card-header bg-transparent pb-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">Total Forms</h5>
                                <i class="bi bi-file-earmark-text fs-2 opacity-75"></i>
                            </div>
                        </div>
                        <div class="card-body d-flex flex-column justify-content-center text-center">
                            <h2 class="display-4 mb-1">{{ \App\Models\Form::count() }}</h2>
                            <p class="card-text mb-0 opacity-90">Forms created</p>
                        </div>
                        <div class="card-footer bg-transparent pt-0">
                            <a href="{{ route('forms.index') }}" class="btn btn-light btn-sm w-100">View All Forms</a>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Recent Forms Section -->
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="card border-0 shadow-sm recent-forms h-100">
                        <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Recent Forms</h5>
                            <small class="text-muted">{{ \App\Models\Form::count() }} total forms</small>
                        </div>
                        <div class="card-body p-0">
                            <ul class="list-group list-group-flush">
                                @forelse(\App\Models\Form::latest()->take(5)->get() as $form)
                                <li class="list-group-item d-flex justify-content-between align-items-center px-4 py-3">
                                    <div>
                                        <div class="d-flex align-items-center mb-1">
                                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3"
                                                style="width: 40px; height: 40px; font-size: 0.875rem; font-weight: 600;">
                                                {{ substr($form->name ?? 'Form', 0, 1) }}
                                            </div>
                                            <div>
                                                <strong class="text-dark">{{ Str::limit($form->name ?? 'Unnamed Form',
                                                    30) }}</strong>
                                                <br>
                                                <small class="text-muted">
                                                    <i class="bi bi-calendar3 me-1"></i>
                                                    Created {{ $form->created_at->diffForHumans() }}
                                                    @if($form->submissions_count > 0)
                                                    <span class="badge bg-primary ms-2">{{ $form->submissions_count }}
                                                        responses</span>
                                                    @endif
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('forms.show', $form->id) }}"
                                            class="btn btn-outline-primary btn-sm" title="View Form">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('forms.edit', $form->id) }}"
                                            class="btn btn-outline-secondary btn-sm" title="Edit Form">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form method="POST" action="{{ route('forms.destroy', $form->id) }}"
                                            class="d-inline" onsubmit="return confirm('Delete this form?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm" title="Delete">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </li>
                                @empty
                                <li class="list-group-item">
                                    <div class="empty-state">
                                        <i class="bi bi-file-earmark-text"></i>
                                        <h5>No forms created yet</h5>
                                        <p class="mb-3">Get started by creating your first form.</p>
                                        <a href="{{ route('forms.create') }}" class="btn btn-primary">
                                            <i class="bi bi-plus-circle me-2"></i>Create First Form
                                        </a>
                                    </div>
                                </li>
                                @endforelse
                            </ul>
                        </div>
                        <div class="card-footer bg-transparent text-center border-0 pt-0">
                            <a href="{{ route('forms.index') }}" class="btn btn-primary">
                                <i class="bi bi-arrow-right me-2"></i>View All Forms
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection