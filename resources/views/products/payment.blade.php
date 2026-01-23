@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="card mx-auto shadow-lg" style="max-width: 500px;">
        <div class="card-body">
            <h1 class="card-title display-4 mb-4">Complete Payment</h1>

            <p class="card-text mb-4"><strong>Product:</strong> {{ $product->name }}</p>
            <p class="card-text mb-4"><strong>Amount:</strong> ₹{{ number_format($product->price, 2) }}</p>

            <form action="{{ route('payment.verify') }}" method="POST" id="payment-form">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">

                <!-- Razorpay Checkout Button -->
                <script src="https://checkout.razorpay.com/v1/checkout.js"
                    data-key="{{ config('services.razorpay.key') }}" data-amount="{{ $product->price * 100 }}"
                    data-currency="INR" data-order_id="{{ $order->id }}" data-name="Your Company"
                    data-description="{{ $product->name }}" data-theme.color="#3399cc">
                </script>
            </form>
        </div>
    </div>
</div>

<script>
    var options = {
        "key": "{{ config('services.razorpay.key') }}",
        "amount": "{{ $product->price * 100 }}",  // amount in paise
        "currency": "INR",
        "name": "Your Company",
        "description": "{{ $product->name }}",
        "order_id": "{{ $order->id }}",
        "handler": function(response) {
            var form = document.getElementById('payment-form');

            // Create hidden inputs and append to form
            var paymentIdInput = document.createElement('input');
            paymentIdInput.type = 'hidden';
            paymentIdInput.name = 'razorpay_payment_id';
            paymentIdInput.value = response.razorpay_payment_id;
            form.appendChild(paymentIdInput);

            var orderIdInput = document.createElement('input');
            orderIdInput.type = 'hidden';
            orderIdInput.name = 'razorpay_order_id';
            orderIdInput.value = response.razorpay_order_id;
            form.appendChild(orderIdInput);

            var signatureInput = document.createElement('input');
            signatureInput.type = 'hidden';
            signatureInput.name = 'razorpay_signature';
            signatureInput.value = response.razorpay_signature;
            form.appendChild(signatureInput);

            form.submit();  // Submit the form after payment is successful
        }
    };
    var rzp1 = new Razorpay(options);
    rzp1.open();  // Open the Razorpay checkout modal
</script>
@endsection