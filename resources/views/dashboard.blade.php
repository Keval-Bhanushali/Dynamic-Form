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
</style>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h2 mb-0">Dashboard</h1>
            </div>
            <div class="row g-4">
                <div class="col-md-4 col-lg-3">
                    <div class="card border-0 shadow-sm h-100 text-white bg-primary bg-gradient">
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
                            <a href="{{ route('forms.index') }}" class="btn btn-light btn-sm w-100">View Forms</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-lg-3">
                    <div class="card border-0 shadow-sm h-100 text-white bg-info bg-gradient">
                        <div class="card-header bg-transparent pb-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">Submissions</h5>
                                <i class="bi bi-check-circle fs-2 opacity-75"></i>
                            </div>
                        </div>
                        <div class="card-body d-flex flex-column justify-content-center text-center">
                            <h2 class="display-4 mb-1">{{ \App\Models\Formsubmission::count() ?? 0 }}</h2>
                            <p class="card-text mb-0">total submissions</p>
                        </div>
                        <div class="card-footer bg-transparent pt-0">
                            <a href="{{ route('submissions.index') }}" class="btn btn-light btn-sm w-100">View All</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection