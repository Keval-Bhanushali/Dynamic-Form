<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formsubmission extends Model
{
    /** @use HasFactory<\Database\Factories\FormsubmissionFactory> */
    use HasFactory;

    protected $fillable = [
        'form_id',
        'data',
    ];

    protected $casts = [
        'data' => 'array',
    ];

    public function form()
    {
        return $this->belongsTo(Form::class);
    }
}
