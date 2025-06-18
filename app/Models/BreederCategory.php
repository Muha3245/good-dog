<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BreederCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'description', 'image', 'is_active', 'order'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
    
    public function breeder()
    {
        return $this->belongsTo(BreederProfile::class, 'breeder_id');
    }
}