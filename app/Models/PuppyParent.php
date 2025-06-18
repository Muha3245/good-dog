<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PuppyParent extends Model
{
    use HasFactory;

    protected $fillable = [
        'puppy_id', 'name', 'gender', 'breed', 'registration_number',
        'genetic_tests', 'health_clearances', 'image'
    ];

    public function puppy()
    {
        return $this->belongsTo(Puppy::class);
    }
}