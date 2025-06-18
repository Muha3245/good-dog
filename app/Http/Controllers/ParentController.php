<?php

namespace App\Http\Controllers;

use App\Models\ParentCat;
use App\Models\Puppy;
use App\Models\BreederProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ParentController extends Controller
{
    public function index()
    {
        $parents = ParentCat::latest()->paginate(10);
        return view('parents.index', compact('parents'));
    }

    public function create()
    {
        return view('parents.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_cuddly_champion' => 'sometimes|boolean',
            'is_good_with_families' => 'sometimes|boolean',
            'is_great_for_allergy_sufferers' => 'sometimes|boolean',
        ]);

        // Handle image upload
        if($request->file('cover_image')){
            $file = $request->file('cover_image');
            $filename = date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('cover_image'), $filename);
            $validated['cover_image'] = $filename;
        }

        // Convert checkbox values to proper booleans
        $validated['is_cuddly_champion'] = $request->input('is_cuddly_champion', 0) == 1;
        $validated['is_good_with_families'] = $request->input('is_good_with_families', 0) == 1;
        $validated['is_great_for_allergy_sufferers'] = $request->input('is_great_for_allergy_sufferers', 0) == 1;

        ParentCat::create($validated);

        return redirect()->route('parents.index')->with('success', 'Parent created successfully');
    }

    public function show(ParentCat $parent)
    {
        return view('parents.show', compact('parent'));
    }

    public function edit(ParentCat $parent)
    {
        return view('parents.edit', compact('parent'));
    }

    public function update(Request $request, ParentCat $parent)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_cuddly_champion' => 'sometimes|boolean',
            'is_good_with_families' => 'sometimes|boolean',
            'is_great_for_allergy_sufferers' => 'sometimes|boolean',
        ]);

        // Handle image upload
        if ($request->hasFile('cover_image')) {
            // Delete old image if exists
            if ($parent->cover_image) {
                $oldImagePath = public_path('cover_image/'.$parent->cover_image);
                if (File::exists($oldImagePath)) {
                    File::delete($oldImagePath);
                }
            }
            
            // Store new image
            $file = $request->file('cover_image');
            $filename = date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('cover_image'), $filename);
            $validated['cover_image'] = $filename;
        }

        // Explicitly set boolean values
        $validated['is_cuddly_champion'] = $request->input('is_cuddly_champion', 0) == 1;
        $validated['is_good_with_families'] = $request->input('is_good_with_families', 0) == 1;
        $validated['is_great_for_allergy_sufferers'] = $request->input('is_great_for_allergy_sufferers', 0) == 1;

        $parent->update($validated);

        return redirect()->route('parents.index')->with('success', 'Parent updated successfully');
    }

    public function destroy(ParentCat $parent)
    {
        // Delete associated image
        if ($parent->cover_image) {
            $imagePath = public_path('cover_image/'.$parent->cover_image);
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }
        
        $parent->delete();
        return redirect()->route('parents.index')->with('success', 'Parent deleted successfully');
    }

    public function showPuppies(ParentCat $parent)
    {
        $query = Puppy::where('parentcat_id', $parent->id)
            ->with('breeder')
            ->orderBy('created_at', 'desc');
    
            $allPuppies = Puppy::get();
            $pureBreedPuppies=Puppy::where('breed', 'pure_breed')->get();
            $crossBreedPuppies=Puppy::where('breed', 'cross_breed')->get();
        // Gender filter
        if (request()->has('gender')) {
            $query->whereIn('gender', request('gender'));
        }
    
        // Age filter
        if (request()->has('age')) {
            $ageConditions = [];
            
            foreach (request('age') as $age) {
                switch ($age) {
                    case 'puppy':
                        $ageConditions[] = ['birth_date', '>=', now()->subYear()];
                        break;
                    case 'young':
                        $ageConditions[] = ['birth_date', '<=', now()->subYear()];
                        $ageConditions[] = ['birth_date', '>=', now()->subYears(3)];
                        break;
                    case 'adult':
                        $ageConditions[] = ['birth_date', '<=', now()->subYears(3)];
                        break;
                }
            }
            
            $query->where(function($q) use ($ageConditions) {
                foreach ($ageConditions as $condition) {
                    $q->orWhere([$condition]);
                }
            });
        }
    
        // Price filter
        if (request()->has('price')) {
            $priceConditions = [];
            
            foreach (request('price') as $price) {
                switch ($price) {
                    case '0-500':
                        $priceConditions[] = ['price', '<=', 500];
                        break;
                    case '500-1000':
                        $priceConditions[] = ['price', '>=', 500];
                        $priceConditions[] = ['price', '<=', 1000];
                        break;
                    case '1000-2000':
                        $priceConditions[] = ['price', '>=', 1000];
                        $priceConditions[] = ['price', '<=', 2000];
                        break;
                    case '2000+':
                        $priceConditions[] = ['price', '>=', 2000];
                        break;
                }
            }
            
            $query->where(function($q) use ($priceConditions) {
                foreach ($priceConditions as $condition) {
                    $q->orWhere([$condition]);
                }
            });
        }
    
        // Attributes filter
        // if (request()->has('attributes')) {
        //     foreach (request('attributes') as $attribute) {
        //         switch ($attribute) {
        //             case 'akc':
        //                 $query->where('is_akc_registered', true);
        //                 break;
        //             // case 'champion':
        //             //     $query->where('champion_bloodline', true);
        //             //     break;
        //             // case 'health':
        //             //     $query->where('health_guarantee', true);
        //             //     break;
        //         }
        //     }
        // }
    
        $puppies = $query->paginate(12)->withQueryString();
    
        return view('showcat', compact('parent', 'puppies','allPuppies', 'pureBreedPuppies', 'crossBreedPuppies'));
    }
}