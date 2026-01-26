@extends('layouts.app')
@section('title', 'Payment')

@section('content')
@php
// Resolve price key from order amount (paise → rupees)
$priceKey = collect($product)
->only(['three_months', 'one_year'])
->map(fn ($v) => (float) $v)
->search($order->amount / 100);

$price = $product->$priceKey;
@endphp

<div class="container py-5">
    <div class="card mx-auto shadow-lg" style="max-width: 500px;">
        <div class="card-body">
            <h1 class="card-title display-4 mb-4">Complete Payment</h1>

            <p class="card-text mb-2"><strong>Product:</strong> {{ $product->name }}</p>
            <p class="card-text mb-4">
                <strong>Plan:</strong> {{ ucfirst(str_replace('_', ' ', $priceKey)) }}
            </p>
            <p class="card-text mb-4">
                <strong>Amount:</strong> ₹{{ number_format($price, 2) }}
            </p>

            <form action="{{ route('payment.verify') }}" method="POST" id="payment-form">
                @csrf
                <input type="hidden" name="price_key" value="{{ $priceKey }}">
                <input type="hidden" name="product_id" value="{{ $product->id }}">
            </form>
        </div>
    </div>
</div>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    var options = {
        key: "{{ config('services.razorpay.key') }}",
        amount: "{{ $price * 100 }}", // paise
        currency: "INR",
        name: "Your Company",
        description: "{{ $product->name }}",
        order_id: "{{ $order->razorpay_order_id ?? $order->id }}",
        handler: function (response) {
            let form = document.getElementById('payment-form');

            ['payment_id', 'order_id', 'signature'].forEach(function (field) {
                let input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'razorpay_' + field;
                input.value = response['razorpay_' + field];
                form.appendChild(input);
            });

            form.submit();
        }
    };

    new Razorpay(options).open();
</script>
@endsection