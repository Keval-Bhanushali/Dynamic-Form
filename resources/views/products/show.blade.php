@extends('layouts.app')
@section('title', 'Payment')

@section('content')
<div class="container py-5">
    <div class="card mx-auto shadow-lg" style="max-width: 600px;">
        <div class="card-body">
            <h1 class="card-title display-4 mb-4">{{ $product->name }}</h1>
            <p class="card-text text-muted mb-4">{{ $product->description }}</p>

            <label for="duration" class="form-label fw-bold">Select Duration:</label>
            <select class="form-select mb-4" id="duration" name="duration">
                <option value="three_months" {{ (session('amount')==$product->three_months || old('duration') ===
                    'three_months') ? 'selected' : '' }}>
                    3 Months - ₹{{ number_format($product->three_months, 2) }}
                </option>

                <option value="one_year" {{ (session('amount')==$product->one_year || old('duration') === 'one_year') ?
                    'selected' : '' }}>
                    1 Year - ₹{{ number_format($product->one_year, 2) }}
                </option>
            </select>

            <p class="card-text mb-4">Device Limit: {{ $product->device_limit }}</p>

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
                    class="text-decoration-underline text-primary">Download Invoice</a>
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

                <input type="hidden" name="duration" id="selected_duration" value="three_months">
                <button type="submit" class="btn btn-primary w-100 py-3">
                    Buy Now
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('duration').addEventListener('change', function() {
        document.getElementById('selected_duration').value = this.value;
    });
</script>
@endsection