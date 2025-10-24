<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactInformation extends Model
{
    use HasFactory;

    // 👇 Force Laravel to use the correct plural table name
    protected $table = 'contact_informations';

    protected $fillable = [
        'slug',
        'name',
        'address',
        'phone',
        'secondary_phone',
        'email',
        'hours',
        'map_embed',
    ];
}
