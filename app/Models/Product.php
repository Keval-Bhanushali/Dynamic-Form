<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'three_months',
        'one_year',
        'device_limit',
    ];

    public function payments()
    {
        return $this->hasMany(ProductPayment::class);
    }
}
