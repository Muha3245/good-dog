<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Puppy extends Model
{
    use HasFactory;

    protected $fillable = [
        'breeder_id', 'category_id','parentcat_id', 'name', 'gender', 'birth_date', 'breed',
        'color', 'weight', 'height', 'description', 'price',
        'status', 'main_image', 'gallery', 'health_records'
    ];

    protected $casts = [
        'gallery' => 'array',
        'health_records' => 'array',
        'birth_date' => 'date'
    ];

    // public function breeder()
    // {
    //     return $this->belongsTo(User::class, 'breeder_id');
    // }
    public function breeder()
{
    return $this->belongsTo(BreederProfile::class, 'breeder_id');
}
    

    public function category()
    {
        return $this->belongsTo(BreederCategory::class);
    }

    public function parents()
    {
        return $this->hasMany(PuppyParent::class);
    }
    public function adoptions()
{
    return $this->hasMany(Adoption::class);
}
// app/Models/Puppy.php
public function conversations()
{
    return $this->hasMany(Conversation::class);
}

    public function siblings()
    {
        return $this->belongsToMany(Puppy::class, 'puppy_siblings', 'puppy_id', 'sibling_id')
            ;
    }
    public function siblingsOf()
    {
        return $this->belongsToMany(Puppy::class, 'puppy_siblings', 'sibling_id', );
    }
}