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

    <div class="card-body p-0" id="formsContainer">
        @include('form.partials.forms-table')
    </div>
</div>

@if(isset($forms) && $forms->hasPages())
<div class="d-flex justify-content-between align-items-center mt-5 pt-4 border-top border-light border-opacity-10">
    <div class="text-muted small">
        Showing {{ $forms->firstItem() }} to {{ $forms->lastItem() }} of {{ $forms->total() }} forms
    </div>
    <nav aria-label="Forms pagination">
        <ul class="pagination pagination-sm mb-0" id="paginationLinks">
            {{ $forms->links('pagination::bootstrap-5') }}
        </ul>
    </nav>
</div>
@endif

<script>
    document.addEventListener('DOMContentLoaded', function() {
    // Pure JavaScript - NO jQuery needed
    const formsContainer = document.getElementById('formsContainer');
    const paginationLinks = document.getElementById('paginationLinks');
    
    // Use event delegation for pagination
    document.addEventListener('click', function(e) {
        if (e.target.closest('.pagination a.page-link')) {
            e.preventDefault();
            
            const link = e.target.closest('a');
            const url = link.getAttribute('href');
            
            if (!url || url.includes('#')) return;
            
            // Show loading
            formsContainer.innerHTML = `
                <div class="text-center py-5">
                    <div class="spinner-border text-primary fs-1" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <div class="mt-3 text-muted">Loading forms...</div>
                </div>
            `;
            
            // Fetch new content
            fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                formsContainer.innerHTML = data.html;
                paginationLinks.innerHTML = data.pagination;
                
                // Update counter
                const counter = document.querySelector('.text-muted.small');
                if (counter) {
                    counter.textContent = `Showing ${data.first_item} to ${data.last_item} of ${data.total} forms`;
                }
            })
            .catch(error => {
                console.error('AJAX Error:', error);
                window.location.href = url; // Fallback
            });
        }
    });
});
</script>

<!-- ADD THIS to <head> -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Add CSRF meta tag in <head> of your layout -->
<meta name="csrf-token" content="{{ csrf_token() }}">

@endsection