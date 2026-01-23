<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductPayment;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function index() {
        return view('products.invoices');
    }

    public function listInvoices()
    {
        $payments = ProductPayment::where('status', 'completed')->with('product');

        return DataTables::of($payments)
            ->addColumn('action', function ($payment) {
                return '<a href="'.route('payments.invoice', $payment).'" class="btn btn-sm btn-primary">Download Invoice</a>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function downloadInvoice(ProductPayment $payment)
    {
        $pdf = Pdf::loadView('products.invoice', compact('payment'));

        return $pdf->download('invoice_'.$payment->id.'.pdf');
    }
}
