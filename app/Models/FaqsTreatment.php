<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FaqsTreatment extends Model
{
    use HasFactory;

    protected $fillable = [
        'treatment_id',
        'question',
        'answer',
        'order',
    ];

    public function treatment()
    {
        return $this->belongsTo(Treatment::class);
    }
}