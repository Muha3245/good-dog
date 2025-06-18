<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BreederProfile extends Model
{
    protected $fillable = [
        'user_id', 'category_id', 'parentcat_id', 'kennel_name', 'years_experience', 'about',
        'website', 'address', 'city', 'state', 'zip_code', 'country', 'latitude', 'longitude',
        'is_licensed', 'license_number', 'is_akc_registered', 'akc_registration_number',
        'accepts_visits', 'visit_policy', 'health_guarantee', 'spay_neuter_requirement',
        'profile_image', 'cover_image', 'social_links'
    ];

    // Relationship: A breeder profile belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relationship: A breeder profile belongs to a category
    public function category()
    {
        return $this->belongsTo(BreederCategory::class, 'category_id');
    }

    // Relationship: A breeder profile belongs to a parent category
    public function parent()
    {
        return $this->belongsTo(ParentCat::class, 'parentcat_id');
    }

    // Relationship: A breeder profile has many puppies
    public function puppies()
    {
        return $this->hasMany(Puppy::class, 'breeder_id');
    }
}