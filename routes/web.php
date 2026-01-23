<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

// Forms and Submissions
Route::resource('forms', App\Http\Controllers\FormController::class);
Route::resource('forms.submissions', App\Http\Controllers\FormSubmissionController::class)->shallow();
Route::get('forms/{form}/submit', [App\Http\Controllers\FormSubmissionController::class, 'create'])->name('submission.create');
Route::get('/submissions', [App\Http\Controllers\FormSubmissionController::class, 'index'])->name('submissions.index');
Route::resource('fields', App\Http\Controllers\FieldController::class);

// Products and Payments
Route::resource('products', App\Http\Controllers\ProductController::class);
Route::post('products/{product}/payment', [App\Http\Controllers\ProductController::class, 'createPayment'])->name('products.payment.create');
Route::post('payment/verify', [App\Http\Controllers\ProductController::class, 'verifyPayment'])->name('payment.verify');

// Invoices
Route::get('invoices/view', [App\Http\Controllers\InvoiceController::class, 'index'])->name('invoices');
Route::get('invoices/data', [App\Http\Controllers\InvoiceController::class, 'listInvoices'])->name('invoices.data');
Route::get('payments/{payment}/invoice', [App\Http\Controllers\InvoiceController::class, 'downloadInvoice'])->name('payments.invoice');
