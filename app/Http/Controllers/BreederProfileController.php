<?php

namespace App\Http\Controllers;

use App\Models\BreederProfile;
use App\Models\Puppy;
use Illuminate\Support\Facades\DB;
use App\Models\BreederCategory;
use App\Models\ParentCat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BreederProfileController extends Controller
{
    /**
     * Display a listing of breeders (directory view)
     */
    public function index()
    {
        $breeders = BreederProfile::with('user', 'category')
            ->paginate(10);

        return view('breeders.index', compact('breeders'));
    }

    /**
     * Display the specified breeder profile
     */
    public function show($id)
    {
        // First, try to get breeder profile
        $breeder = BreederProfile::with(['user', 'category', 'puppies'])
            ->where('user_id', $id)->first();

            $breederparant=ParentCat::get();
            $categoryIds = DB::table('breeder_category')->where('breeder_id', $breeder->id)->pluck('category_id');
            $breedercat=BreederCategory::get();
            $breedercategory=BreederCategory::whereIn('id', $categoryIds)->get();
    
        // If no breeder profile found, fetch only user
        if (!$breeder) {
            $user = User::findOrFail($id); // Get user info
            return view('breeders.profile', [
                'breeder' => null,
                'user' => $user,
                'editMode' => request()->has('edit')
            ]);
        }
    
        // If breeder profile exists
        return view('breeders.profile', [
            'breeder' => $breeder,
            'breederparant' => $breederparant,
            'breedercat' => $breedercat,
            'breedercategory' => $breedercategory,
            'user' => $breeder->user, // or Auth::user() if needed
            'editMode' => request()->has('edit')
        ]);
    }
    

    /**
     * Show the form for editing the breeder profile
     */
    public function edit($id)
    {
        $breeder = BreederProfile::with('user', 'categories')->findOrFail($id);
        $this->authorize('update', $breeder);

        $categories = \App\Models\Category::all();
        
        return view('breeders.edit', compact('breeder', 'categories'));
    }

    /**
     * Update the breeder profile
     */
    public function update(Request $request, $id)
    {
        $breeder = BreederProfile::findOrFail($id);

        $validated = $request->validate([
            'kennel_name' => 'required|string|max:255',
            'years_experience' => 'nullable|integer|min:0',
            'about' => 'nullable|string',
            'breeding_philosophy' => 'nullable|string',
            'genetic_testing' => 'nullable|string',
            'puppy_socialization' => 'nullable|string',
            'specialties' => 'nullable|string',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'zip_code' => 'nullable|string|max:20',
            'phone' => 'nullable|string|max:20',
            'website' => 'nullable|url|max:255',
            'facebook' => 'nullable|url|max:255',
            'instagram' => 'nullable|url|max:255',
            'youtube' => 'nullable|url|max:255',
            'is_akc_registered' => 'boolean',
            'akc_registration_number' => 'nullable|string|max:255',
            'is_licensed' => 'boolean',
            'license_number' => 'nullable|string|max:255',
            'breed_club_memberships' => 'nullable|string',
            'accepts_visits' => 'boolean',
            'visit_policy' => 'nullable|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
        ]);

        // Handle file uploads
        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->move(public_path('breeder_covers'));
            $validated['cover_image'] = $path;
        }

        // Update breeder profile
        $breeder->update($validated);

        // Sync categories
        if (isset($validated['categories'])) {
            $breeder->categories()->sync($validated['categories']);
        }

        return redirect()->back()
                         ->with('success', 'Profile updated successfully');
    }

    /**
     * Get all puppies for a breeder
     */
    public function puppies($id)
    {
        $breeder = BreederProfile::findOrFail($id);
        $puppies = $breeder->puppies()
                          ->orderBy('status')
                          ->orderBy('birth_date', 'desc')
                          ->paginate(12);

        return view('breeders.puppies', compact('breeder', 'puppies'));
    }
}
