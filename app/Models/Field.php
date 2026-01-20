<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    /** @use HasFactory<\Database\Factories\FieldFactory> */
    use HasFactory;

    protected $fillable = [
        'label',
        'type',
    ];

    public function forms()
    {
        return $this->belongsToMany(Form::class)->withPivot('is_required')->withTimestamps();
    }
}
