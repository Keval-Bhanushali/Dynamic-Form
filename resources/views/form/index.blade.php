@extends('layouts.app')

@section('title', 'Forms')

@section('content')

<style>
    body {
        background-color: #f8fafc;
        /* Light background */
        color: #333;
        /* Dark text for better readability */
    }

    .page-header {
        background: linear-gradient(135deg, #eef2f7, #f8fafc);
        border-radius: 16px;
        padding: 24px;
        border: 1px solid #d1d5db;
    }

    .card-dark {
        background: linear-gradient(145deg, #ffffff, #f9fafb);
        /* Lighter card background */
        border: 1px solid #d1d5db;
        border-radius: 16px;
    }

    .form-row-hover {
        transition: all 0.35s ease;
    }

    .form-row-hover:hover {
        background: rgba(99, 102, 241, 0.1);
        /* Light hover effect */
        border-left: 4px solid #6366f1;
        transform: translateX(6px);
    }

    .badge-dark-info {
        background: rgba(56, 189, 248, 0.1);
        color: #38bdf8;
    }

    .badge-dark-success {
        background: rgba(34, 197, 94, 0.1);
        color: #22c55e;
    }

    .icon-circle {
        background: rgba(99, 102, 241, 0.1);
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
        border-color: #d1d5db;
    }

    .text-muted {
        color: #6b7280 !important;
        /* Muted gray color for text */
    }

    .empty-state {
        background: linear-gradient(145deg, #ffffff, #f9fafb);
        border-radius: 16px;
        border: 1px dashed #d1d5db;
    }
</style>

<!-- Header -->
<div class="page-header mb-5">
    <div class="row align-items-center">
        <div class="col-md-6 d-flex align-items-center">
            <i class="bi bi-file-earmark-text-fill fs-1 text-primary me-3"></i>
            <div>
                <h1 class="h3 mb-1 fw-bold text-dark">Forms Management</h1>
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
        <h5 class="mb-0 fw-bold text-dark">
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
                        'Accept': 'application/json'
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

@endsection