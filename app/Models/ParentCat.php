<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParentCat extends Model
{
    use HasFactory;
    protected $table = 'parents';
    protected $fillable = ['name', 'cover_image','is_cuddly_champion',
    'is_good_with_families',
    'is_great_for_allergy_sufferers'];

    public function breeders()
    {
        return $this->hasMany(BreederProfile::class, 'parentcat_id');
    }

    public function puppies()
    {
        return $this->hasMany(Puppy::class, 'parentcat_id');
    }

    public function breeder()
    {
        return $this->belongsTo(BreederProfile::class, 'breeder_id');
    }
}
