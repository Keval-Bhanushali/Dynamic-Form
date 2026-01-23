@extends('layouts.app')
@section('title', 'Invoices')

@section('content')
<div class="container mt-4">
    <h2>Invoices</h2>
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover table-sm">
            <thead class="table-dark">
                <tr class="text-center">
                    <th>ID</th>
                    <th>Product</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Invoice</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($payments as $payment)
                <tr class="text-center">
                    <td>{{ $payment->id }}</td>
                    <td>{{ $payment->product->name }}</td>
                    <td>{{ $payment->amount }}</td>
                    <td>{{ $payment->status }}</td>
                    <td class="pb-3">
                        <a href="{{ route('payments.invoice', $payment) }}" class="btn btn-primary">Download Invoice</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection