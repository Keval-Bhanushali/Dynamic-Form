@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<style>
    .card {
        transition: all 0.3s ease;
    }

    .card:hover {
        transform: translateY(-4px);
        box-shadow: 0 0.5rem 2rem rgba(0, 0, 0, 0.15) !important;
    }

    .recent-forms .list-group-item {
        background: rgba(255, 255, 255, 0.9);
        border: 1px solid rgba(0, 0, 0, 0.1);
        transition: background 0.3s ease;
    }

    .recent-forms .list-group-item:hover {
        background: rgba(59, 130, 246, 0.1);
    }

    .stats-card {
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        border: 1px solid rgba(0, 0, 0, 0.1);
    }
</style>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h2 mb-0">Dashboard</h1>
            </div>

            <!-- Stats Cards -->
            <div class="row g-4 mb-5">
                <div class="col-md-4 col-lg-3">
                    <div class="card border-0 shadow-sm h-100 text-white bg-transparent bg-gradient">
                        <div class="card-header bg-transparent pb-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">Forms</h5>
                                <i class="bi bi-file-earmark-text fs-2 opacity-75"></i>
                            </div>
                        </div>
                        <div class="card-body d-flex flex-column justify-content-center text-center">
                            <h2 class="display-4 mb-1">{{ \App\Models\Form::count() }}</h2>
                            <p class="card-text mb-0">forms created</p>
                        </div>
                        <div class="card-footer bg-transparent pt-0">
                            <a href="{{ route('forms.index') }}" class="btn btn-light btn-sm w-100">View All Forms</a>
                        </div>
                    </div>
                </div>

                <!-- Products Stats Card -->
                <div class="col-md-4 col-lg-3">
                    <div class="card border-0 shadow-sm h-100 text-dark stats-card submissions">
                        <div class="card-header bg-transparent pb-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">Total Products</h5>
                                <i class="bi bi-box-seam fs-2 opacity-75"></i>
                            </div>
                        </div>
                        <div class="card-body d-flex flex-column justify-content-center text-center">
                            <h2 class="display-4 mb-1">{{ \App\Models\Product::count() }}</h2>
                            <p class="card-text mb-0 opacity-90">Products created</p>
                        </div>
                        <div class="card-footer bg-transparent pt-0">
                            <a href="{{ route('products.index') }}" class="btn btn-light btn-sm w-100">View All
                                Products</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Forms Section -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card border-0 shadow-sm recent-forms">
                        <div class="card-header bg-transparent">
                            <h5 class="card-title mb-0">Recent Forms</h5>
                        </div>
                        <div class="card-body p-0">
                            <ul class="list-group list-group-flush">
                                @forelse(\App\Models\Form::latest()->take(5)->get() as $form)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>{{ $form->name ?? 'Unnamed Form' }}</strong>
                                        <br>
                                        <small class="text-muted">Created {{ $form->created_at->diffForHumans()
                                            }}</small>
                                    </div>
                                    <a href="{{ route('forms.show', $form->id) }}"
                                        class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-eye"></i> View
                                    </a>
                                </li>
                                @empty
                                <li class="list-group-item text-center text-muted">
                                    No forms created yet.
                                </li>
                                @endforelse
                            </ul>
                        </div>
                        <div class="card-footer bg-transparent text-center">
                            <a href="{{ route('forms.index') }}" class="btn btn-primary">View All Forms</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection