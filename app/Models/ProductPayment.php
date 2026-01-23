<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductPayment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'product_id',
        'bank_transaction_id',
        'razorpay_payment_id',
        'razorpay_order_id',
        'amount',
        'currency',
        'status',
        'payment_data',
    ];

    protected $casts = [
        'payment_data' => 'array',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
