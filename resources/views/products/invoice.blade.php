<!DOCTYPE html>
<html>

<head>
    <title>Invoice #{{ $payment->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .invoice-details {
            margin-bottom: 20px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .table th {
            background-color: #f2f2f2;
        }

        .total {
            font-weight: bold;
            font-size: 18px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Invoice</h1>
        <p>Invoice</p>
        <p>Date: {{ $payment->created_at->format('d/m/Y') }}</p>
    </div>

    <div class="invoice-details">
        <h3>Transaction Details:</h3>
        <p>Bank Transaction ID: {{ $payment->bank_transaction_id }}</p>
        <p>Razorpay Payment ID: {{ $payment->razorpay_payment_id }}</p>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Product</th>
                <th>Description</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $payment->product->name }}</td>
                <td>{{ $payment->product->description }}</td>
                <td>₹{{ number_format($payment->amount, 2) }}</td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2" class="total">Total</td>
                <td class="total">₹{{ number_format($payment->amount, 2) }}</td>
            </tr>
        </tfoot>
    </table>

    <div style="margin-top: 30px;">
        <p>Payment ID: {{ $payment->razorpay_payment_id }}</p>
        <p>Status: {{ ucfirst($payment->status) }}</p>
    </div>
</body>

</html>