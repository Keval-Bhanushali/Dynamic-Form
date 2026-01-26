@extends('layouts.app')
@section('title', 'Products')

@section('content')
<div class="container py-5">
    <h1 class="display-4 text-center mb-5">Our Products</h1>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        @foreach($products as $product)
        <div class="col">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="card-text text-muted">{{ $product->description }}</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="h4 text-success">₹{{ number_format($product->price, 2) }}</span>
                        <span class="badge bg-info text-dark">Devices: {{ $product->device_limit }}</span>
                        <a href="{{ route('products.show', $product) }}" class="btn btn-primary">View Details</a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection