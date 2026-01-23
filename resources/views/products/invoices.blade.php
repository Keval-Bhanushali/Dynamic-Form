@extends('layouts.app')
@section('title', 'Invoices')

@section('content')
<div class="container mt-4">
    <h2>Invoices</h2>
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover table-sm" id="payments-table">
            <thead class="table-dark">
                <tr class="text-center">
                    <th>ID</th>
                    <th>Product</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Invoice</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <!-- Data will be populated here dynamically -->
            </tbody>
        </table>
    </div>
</div>

<!-- External CSS and JS for DataTables -->
<link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<script>
    $('#payments-table').DataTable({
    processing: true,
    serverSide: true,
    ajax: '{{ route('invoices.data') }}',
    columns: [
    { data: 'id', name: 'id' },
    { data: 'product.name', name: 'product.name', defaultContent: 'No Product' },
    {
    data: 'amount',
    name: 'amount',
    render: function(data, type, row) {
    // Format the amount as INR
    return '₹ ' + parseFloat(data).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
    }
    },
    { data: 'status', name: 'status' },
    { data: 'action', name: 'action', orderable: false, searchable: false }
    ],
    dom: 'Bfrtip',
    buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
    order: [[0, 'desc']],
    pageLength: 10,
    language: {
    lengthMenu: "Show _MENU_ entries",
    zeroRecords: "No matching records found",
    info: "Showing _START_ to _END_ of _TOTAL_ entries",
    infoEmpty: "No records available",
    infoFiltered: "(filtered from _MAX_ total records)"
    },
    responsive: true
    });
</script>
@endsection