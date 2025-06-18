<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DogShelter extends Model
{
    protected $fillable = [
        'name',
        'cover_image',
        'location',
        'file_path',
        'file_type',
        'description',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];
}