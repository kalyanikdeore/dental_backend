<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $table = 'contact'; // since your migration uses singular 'contact'

    protected $fillable = [
        'name',
        'slug',
        'address',
        'phone',
        'secondary_phone',
        'hours',
        'map_embed',
        'email',
    ];
}
