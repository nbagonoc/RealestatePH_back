<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'status',
        'description',
        'price',
        'address',
        'city',
        'state',
        'zip',
        'photo',
        'category',
        'type',
        'bedrooms',
        'bathrooms',
        'sqft',
        'lot_size',
        'year_built',
        'parking',
    ];
}
