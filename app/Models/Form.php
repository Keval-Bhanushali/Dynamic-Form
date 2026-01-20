<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    /** @use HasFactory<\Database\Factories\FormFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    public function fields()
    {
        return $this->belongsToMany(Field::class)->withPivot('is_required')->withTimestamps();
    }

    public function submissions()
    {
        return $this->hasMany(Formsubmission::class);
    }
}
