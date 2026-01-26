@extends('layouts.app')
@section('title', 'Payment')

@section('content')
<div class="container py-5">
    <div class="card mx-auto shadow-lg" style="max-width: 600px;">
        <div class="card-body">
            <h1 class="card-title display-4 mb-4">{{ $product->name }}</h1>
            <p class="card-text text-muted mb-4">{{ $product->description }}</p>
            <div class="text-success h3 mb-4">₹{{ number_format($product->price, 2) }}</div>

            @if(session('success'))
            <div class="alert alert-success mb-4" role="alert">
                {{ session('success') }}
                @php
                $payment = \App\Models\ProductPayment::where('product_id', $product->id)
                ->where('status', 'completed')
                ->latest()
                ->first();
                @endphp
                @if($payment)
                <br><a href="{{ route('payments.invoice', $payment) }}"
                    class="text-decoration-underline text-primary">Download
                    Invoice</a>
                @endif
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger mb-4" role="alert">
                {{ session('error') }}
            </div>
            @endif

            <form action="{{ route('products.payment.create', $product) }}" method="POST">
                @csrf
                
                <button type="submit" class="btn btn-primary w-100 py-3">
                    Buy Now
                </button>
            </form>
        </div>
    </div>
</div>
@endsection