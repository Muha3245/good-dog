<?php

namespace App\Helpers;
use App\Models\ParentCat;
use App\Models\Puppy;
use App\Models\BreederProfile;
use Illuminate\Support\Facades\Auth;

use App\Models\BreederCategory;

use App\Models\User;


class helpers
{
    /**
     * Get filtered parent cats with dynamic data
     * 
     * @param string $filterType (cuddly|family|allergy)
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getFilteredParents(string $filterType)
    {
        $query = ParentCat::query();
        
        switch($filterType) {
            case 'cuddly':
                $query->where('is_cuddly_champion', true)
                      ->orderBy('name');
                break;
                
            case 'family':
                $query->where('is_good_with_families', true)
                      ->orderBy('name');
                break;
                
            case 'allergy':
                $query->where('is_great_for_allergy_sufferers', true)
                      ->orderBy('name');
                break;
        }
        
        return $query->limit(5)->get();
    }
    public static function user()
    {
        $users=User::all();
        return $users; // Laravel's Auth::user() already returns null if not authenticated
    }
    
    public static function isBreeder()
    {
        return Auth::check() ? BreederProfile::where('user_id', Auth::id())->first() : null;
    }
    public static function allPuppies(){
        $allPuppies = Puppy::all();
        return $allPuppies;
    }
    public static function allBreederCategories(){
        $allBreederCategories = BreederCategory::all();
        return $allBreederCategories;
    }
    public static function crossBreedPuppies(){
        $crossBreedPuppies = Puppy::where('breed', 'cross_breed')->get();
        return $crossBreedPuppies;
    }
    public static function pureBreedPuppies(){
        $pureBreedPuppies = Puppy::where('breed', 'pure_breed')->get();
        return $pureBreedPuppies;
    }
    public static function allBreederProfiles(){
        $allBreederProfiles = BreederProfile::all();
        return $allBreederProfiles;
    }
}