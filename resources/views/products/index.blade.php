@extends('layouts.app')
@section('title', 'Products')

@section('content')
<div class="container py-5">
    <h1 class="display-4 text-center mb-5 text-primary">Our Products</h1>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        @foreach($products as $product)
        <div class="col">
            <div class="card shadow-lg rounded-3 h-100 transform-hover">

                <div class="card-body d-flex flex-column">
                    <h5 class="card-title fs-4 mb-3">{{ $product->name }}</h5>
                    <p class="card-text text-muted mb-4 flex-grow-1">{{ $product->description }}</p>

                    <div class="d-flex justify-content-between align-items-center mt-auto">
                        <span class="h4 text-success">₹{{ number_format($product->three_months, 2) }}/m</span>
                        <span class="badge bg-info text-dark">Devices: {{ $product->device_limit }}</span>
                    </div>

                    <div class="mt-3 text-center">
                        <a href="{{ route('products.show', $product) }}"
                            class="btn btn-primary w-100 py-2 fw-bold rounded-pill transform-hover">View Details</a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection