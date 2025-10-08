<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TreatmentSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'treatment_id',
        'h2',
        'content',
        'list_title',
        'list_items',
        'subsections',
        'ordered_list',
        'note',
        'image',
        'order',
    ];

    protected $casts = [
        'list_items' => 'array',
        'subsections' => 'array',
        'ordered_list' => 'array',
    ];

    public function treatment()
    {
        return $this->belongsTo(Treatment::class);
    }
}