<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhyChooseTreatment extends Model
{
    use HasFactory;

    protected $table = 'why_choose_treatments';

    protected $fillable = ['treatment_id', 'icon', 'title', 'description', 'order'];

    public function treatment()
    {
        return $this->belongsTo(Treatment::class);
    }
}