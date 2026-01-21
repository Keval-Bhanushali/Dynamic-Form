@extends('layouts.app')

@section('title', 'Forms')

@section('content')

<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #3b82f6, #1d4ed8);
        --secondary-gradient: linear-gradient(135deg, #6366f1, #22d3ee);
        --card-hover-shadow: 0 0.5rem 2rem rgba(0, 0, 0, 0.1);
        --border-light: rgba(0, 0, 0, 0.08);
    }

    .page-header {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        border-radius: 24px;
        padding: 2rem;
        border: 1px solid var(--border-light);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    }

    .card-light {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border: 1px solid var(--border-light);
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }

    .form-row-hover {
        transition: all 0.35s ease;
        border-radius: 12px;
        margin-bottom: 0.5rem;
    }

    .form-row-hover:hover {
        background: rgba(59, 130, 246, 0.08);
        border-left: 4px solid #3b82f6;
        transform: translateX(6px);
        box-shadow: var(--card-hover-shadow);
    }

    .badge-light-info {
        background: rgba(56, 189, 248, 0.12);
        color: #0ea5e9;
        border: 1px solid rgba(56, 189, 248, 0.2);
    }

    .badge-light-success {
        background: rgba(34, 197, 94, 0.12);
        color: #059669;
        border: 1px solid rgba(34, 197, 94, 0.2);
    }

    .badge-light-warning {
        background: rgba(251, 191, 36, 0.12);
        color: #d97706;
        border: 1px solid rgba(251, 191, 36, 0.2);
    }

    .icon-circle {
        background: rgba(59, 130, 246, 0.15);
        padding: 14px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .btn-gradient {
        background: var(--secondary-gradient);
        border: none;
        color: #fff;
        border-radius: 12px;
        font-weight: 500;
        box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
    }

    .btn-gradient:hover {
        opacity: 0.95;
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4);
    }

    .btn-outline-info,
    .btn-outline-warning,
    .btn-outline-danger {
        border-radius: 10px;
        font-weight: 500;
    }

    .text-muted {
        color: #64748b !important;
    }

    .empty-state {
        background: rgba(255, 255, 255, 0.6);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        border: 2px dashed #cbd5e1;
        min-height: 300px;
    }

    .stats-badge {
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
    }
</style>

<!-- Header -->
<div class="page-header mb-5">
    <div class="row align-items-center">
        <div class="col-md-6 d-flex align-items-center">
            <div class="icon-circle text-primary me-3">
                <i class="bi bi-file-earmark-text-fill fs-2"></i>
            </div>
            <div>
                <h1 class="h3 mb-1 fw-bold text-dark">Forms Management</h1>
                <p class="mb-0 text-muted fs-6">Manage all your dynamic forms and submissions</p>
            </div>
        </div>
        <div class="col-md-6 text-md-end mt-3 mt-md-0">
            <a href="{{ route('forms.create') }}" class="btn btn-gradient btn-lg px-5">
                <i class="bi bi-plus-circle me-2"></i>Create New Form
            </a>
        </div>
    </div>
</div>

<!-- Forms List -->
<div class="card card-light shadow-lg overflow-hidden">
    <div class="card-header bg-transparent py-4 border-bottom" style="border-color: var(--border-light);">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold text-dark">
                <i class="bi bi-table me-2 text-primary"></i>All Forms ({{ $forms->total() ?? 0 }})
            </h5>
        </div>
    </div>

    <div class="card-body p-0" id="formsContainer">
        @include('form.partials.forms-table')
    </div>
</div>

@if(isset($forms) && $forms->hasPages())
<div class="d-flex justify-content-between align-items-center mt-5 pt-4"
    style="border-top: 1px solid var(--border-light);">
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
    const formsContainer = document.getElementById('formsContainer');
    const paginationLinks = document.getElementById('paginationLinks');
    
    // Forms per page selector
    document.getElementById('formsPerPage').addEventListener('change', function() {
        const url = new URL(window.location.href);
        url.searchParams.set('per_page', this.value);
        window.location.href = url.toString();
    });
    
    // Enhanced AJAX pagination
    document.addEventListener('click', function(e) {
        if (e.target.closest('.pagination a.page-link')) {
            e.preventDefault();
            
            const link = e.target.closest('a');
            const url = link.getAttribute('href');
            
            if (!url || url.includes('#')) return;
            
            // Show loading state
            formsContainer.innerHTML = `
                <div class="text-center py-5">
                    <div class="spinner-border text-primary fs-3" role="status" style="width: 3rem; height: 3rem;">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <div class="mt-3 text-muted">Loading forms...</div>
                </div>
            `;
            
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
                if (paginationLinks) {
                    paginationLinks.innerHTML = data.pagination;
                }
                
                // Update counter
                const counter = document.querySelector('.text-muted.small');
                if (counter) {
                    counter.textContent = `Showing ${data.first_item} to ${data.last_item} of ${data.total} forms`;
                }
            })
            .catch(error => {
                console.error('AJAX Error:', error);
                window.location.href = url;
            });
        }
    });
});
</script>

@endsection