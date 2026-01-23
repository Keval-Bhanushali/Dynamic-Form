<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductPayment;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Razorpay\Api\Api as RazorpayApi;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();

        return view('products.index', compact('products'));
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function createPayment(Request $request, Product $product)
    {
        $api = new RazorpayApi(config('services.razorpay.key'), config('services.razorpay.secret'));

        $order = $api->order->create([
            'receipt' => 'order_'.$product->id.'_'.time(),
            'amount' => $product->price * 100, // Amount in paisa
            'currency' => 'INR',
            'payment_capture' => 1,
        ]);

        return view('products.payment', compact('product', 'order'));
    }

    public function verifyPayment(Request $request)
    {
        $api = new RazorpayApi(config('services.razorpay.key'), config('services.razorpay.secret'));

        try {
            $attributes = [
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature,
            ];

            $api->utility->verifyPaymentSignature($attributes);

            // Payment successful
            $product = Product::find($request->product_id);

            ProductPayment::create([
                'product_id' => $product->id,
                'bank_transaction_id' => $request->razorpay_payment_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_order_id' => $request->razorpay_order_id,
                'amount' => $product->price,
                'status' => 'completed',
                'payment_data' => $request->all(),
            ]);

            return redirect()->route('products.show', $product)->with('success', 'Payment successful!');

        } catch (\Exception $e) {
            // Payment failed
            $product = Product::find($request->product_id);

            ProductPayment::create([
                'product_id' => $product->id,
                'bank_transaction_id' => $request->razorpay_payment_id ?? 'failed_'.time(),
                'razorpay_payment_id' => $request->razorpay_payment_id ?? '',
                'razorpay_order_id' => $request->razorpay_order_id ?? '',
                'amount' => $product->price,
                'status' => 'failed',
                'payment_data' => $request->all(),
            ]);

            return redirect()->route('products.show', $product)->with('error', 'Payment failed!');
        }
    }

    public function downloadInvoice(ProductPayment $payment)
    {
        $pdf = Pdf::loadView('products.invoice', compact('payment'));

        return $pdf->download('invoice_'.$payment->id.'.pdf');
    }

    public function listInvoices()
    {
        $payments = ProductPayment::where('status', 'completed')->get();

        return view('products.invoices', compact('payments'));
    }
}
