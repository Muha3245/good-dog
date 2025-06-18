<?php

namespace App\Http\Controllers;

use App\Models\Puppy;
use App\Models\User;
use Illuminate\Validation\Validator;
use App\Models\ParentCat;

use App\Models\BreederCategory;
use App\Models\BreederProfile;
use App\Models\PuppyParent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class PuppyController extends Controller
{
    // ... (keep your existing index, show, destroy methods)
    public function index()
    {
        // Fetch puppies with only breeder and category relationships
        $puppies = Puppy:: // Exclude puppies that have siblings
        whereDoesntHave('siblingsOf') // Exclude puppies that are siblings of others
        ->with(['breeder', 'category'])
        ->orderBy('created_at', 'desc')
        ->paginate(10);

        return view('puppies.index', compact('puppies'));
    }

    public function create()
    {
        $breeder = BreederProfile::with(['user', 'category', 'puppies'])
            ->where('user_id', Auth::id())->first();
        
        $categories = BreederCategory::where('is_active', true)->get();
        $parentCats = ParentCat::get();
        
        // Get potential siblings (other puppies from same breeder)
        $siblings = Puppy::where('breeder_id', $breeder->user_id)->get();
        
        return view('puppies.create', compact('breeder', 'categories', 'siblings', 'parentCats'));
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'breeder_id' => 'required|exists:breeder_profiles,id',
        'category_id' => 'required|exists:breeder_categories,id',
        'parentcat_id' => 'required|exists:parents,id',
        'name' => 'required|string|max:255',
        'gender' => 'required|in:male,female',
        'birth_date' => 'nullable|date',
        'breed' => 'required|string|max:255',
        'color' => 'nullable|string|max:255',
        'weight' => 'nullable|string|max:255',
        'height' => 'nullable|string|max:255',
        'description' => 'nullable|string',
        'price' => 'required|numeric|min:0',
        'status' => 'required|in:available,reserved,sold',
        'main_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Handle main image upload
    $mainImagePath = null;
    if ($request->hasFile('main_image')) {
        $file = $request->file('main_image');
        $filename = 'puppy_'.time().'_'.$file->getClientOriginalName();
        $file->move(public_path('uploads/puppies/main'), $filename);
        $mainImagePath = 'uploads/puppies/main/'.$filename;
    }

    // Handle gallery images upload
    $galleryImages = [];
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $file) {
            $filename = 'gallery_'.time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads/puppies/gallery'), $filename);
            $galleryImages[] = 'uploads/puppies/gallery/'.$filename;
        }
    }

    // Create the puppy
    $puppy = Puppy::create([
        'breeder_id' => $validated['breeder_id'],
        'category_id' => $validated['category_id'],
        'parentcat_id' => $validated['parentcat_id'],
        'name' => $validated['name'],
        'gender' => $validated['gender'],
        'birth_date' => $validated['birth_date'] ?? null,
        'breed' => $validated['breed'],
        'color' => $validated['color'] ?? null,
        'weight' => $validated['weight'] ?? null,
        'height' => $validated['height'] ?? null,
        'description' => $validated['description'] ?? null,
        'price' => $validated['price'],
        'status' => $validated['status'],
        'main_image' => $mainImagePath,
        'gallery' => !empty($galleryImages) ? json_encode($galleryImages) : null,
    ]);

    return redirect()->route('puppies.index')->with('success', 'Puppy added successfully!');
}

    public function edit(Puppy $puppy)
    {
        $breeder = BreederProfile::with(['user', 'category', 'puppies'])
            ->where('user_id', Auth::id())->first();
            $breederparants = ParentCat::get();

        $categories = BreederCategory::where('is_active', true)->get();
        
        // Get potential siblings (other puppies from same breeder excluding current)
        $siblings = Puppy::where('breeder_id', $breeder->user_id)
            ->where('id', '!=', $puppy->id)
            ->get();
        
        return view('puppies.edit', compact('puppy', 'breeder', 'categories', 'siblings','breederparants'));
    }

    public function update(Request $request, Puppy $puppy)
{
    $validated = $request->validate([
        'category_id' => 'required|exists:breeder_categories,id',
        'parentcat_id' => 'required|exists:parents,id',
        'name' => 'required|string|max:255',
        'gender' => 'required|in:male,female',
        'birth_date' => 'nullable|date',
        'breed' => 'required|string|max:255',
        'color' => 'nullable|string|max:255',
        'weight' => 'nullable|numeric',
        'height' => 'nullable|numeric',
        'description' => 'nullable|string',
        'price' => 'required|numeric|min:0',
        'status' => 'required|in:available,reserved,sold',
        'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'remove_main_image' => 'nullable|boolean',
        'remove_gallery_images' => 'nullable|array',
        'remove_gallery_images.*' => 'string'
    ]);

    // Handle main image update
    if ($request->hasFile('main_image')) {
        // Delete old main image if exists
        if ($puppy->main_image && file_exists(public_path($puppy->main_image))) {
            unlink(public_path($puppy->main_image));
        }
        
        // Upload new main image
        $file = $request->file('main_image');
        $filename = 'puppy_'.time().'_'.$file->getClientOriginalName();
        $file->move(public_path('uploads/puppies/main'), $filename);
        $validated['main_image'] = 'uploads/puppies/main/'.$filename;
    } elseif ($request->has('remove_main_image')) {
        // Remove main image if checkbox is checked
        if ($puppy->main_image && file_exists(public_path($puppy->main_image))) {
            unlink(public_path($puppy->main_image));
        }
        $validated['main_image'] = null;
    } else {
        // Keep existing main image
        $validated['main_image'] = $puppy->main_image;
    }

    // Handle gallery images
    $galleryImages = $puppy->gallery ? json_decode($puppy->gallery) : [];
    
    // Remove selected gallery images
    if ($request->has('remove_gallery_images')) {
        foreach ($request->remove_gallery_images as $imageToRemove) {
            if (($key = array_search($imageToRemove, $galleryImages)) !== false) {
                if (file_exists(public_path($imageToRemove))) {
                    unlink(public_path($imageToRemove));
                }
                unset($galleryImages[$key]);
            }
        }
        $galleryImages = array_values($galleryImages); // Reindex array
    }

    // Add new gallery images
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $file) {
            $filename = 'gallery_'.time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads/puppies/gallery'), $filename);
            $galleryImages[] = 'uploads/puppies/gallery/'.$filename;
        }
    }

    $validated['gallery'] = !empty($galleryImages) ? json_encode($galleryImages) : null;

    // Update puppy record
    $puppy->update($validated);

    return redirect()->route('puppies.index')
        ->with('success', 'Puppy updated successfully!');
}

    public function show(Puppy $puppy)  
    {
        $puppy->load(['breeder', 'category', 'parents', 'siblings']);
        return view('puppies.show', compact('puppy'));
    }
    public function profileshow(Puppy $puppy)  
    {
        $puppy->load(['breeder', 'category', 'parents', 'siblings']);
        $allPuppies = Puppy::get();
        $pureBreedPuppies=Puppy::where('breed', 'pure_breed')->get();
        $crossBreedPuppies=Puppy::where('breed', 'cross_breed')->get();
        return view('puppyprofile', compact('puppy','allPuppies','pureBreedPuppies','crossBreedPuppies'));
    }
    public function breederprofile($id){
        // Load breeder with relationships
        $breeder = BreederProfile::with(['puppies'])->findOrFail($id);
        
        // Get all active categories using model
        $categories = BreederCategory::where('is_active', true)->get();
        
        // Get breeder's categories from pivot table
        $breederCategories = DB::table('breeder_category')
                             ->where('breeder_id', $id)
                             ->pluck('category_id')
                             ->toArray();
        
        // Get puppies
        $puppies = $breeder->puppies;
        
        // If category filter is applied
        if(request('category')) {
            $puppies = $puppies->filter(function($puppy) {
                return DB::table('breeder_category')
                       ->where('breeder_id', $puppy->breeder_id)
                       ->where('category_id', request('category'))
                       ->exists();
            });
        }
        
        // Add breeder's categories to each puppy (since puppies inherit breeder's categories)
        foreach($puppies as $puppy) {
            $puppy->categories = $breederCategories; // Using breeder's categories
        }
        
        return view('breederprofile', compact('breeder', 'puppies', 'categories', 'breederCategories'));
    }

    

    public function removeGalleryImage(Request $request, Puppy $puppy)
    {
        $request->validate([
            'image' => 'required|string',
        ]);

        $image = $request->input('image');
        $gallery = json_decode($puppy->gallery, true);

        if (($key = array_search($image, $gallery)) !== false) {
            unset($gallery[$key]);

            // Delete the image file from the server
            if (file_exists(public_path($image))) {
                unlink(public_path($image));
            }

            // Update the gallery in the database
            $puppy->gallery = json_encode(array_values($gallery));
            $puppy->save();

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 400);
    }

    public function siblingsIndex(Puppy $puppy)
    {
        $siblings = $puppy->siblings;
        return view('siblings.index', compact('puppy', 'siblings'));
    }

    public function storeSibling(Request $request, Puppy $puppy)
    {

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'required|in:male,female',
            'breed' => 'required|string|max:255',
            'main_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'birth_date' => 'nullable|date',
            'color' => 'nullable|string|max:255',
            'price' => 'nullable|string|max:255',

        ]);

        // Handle image upload
        $mainImagePath = null;
        if ($request->hasFile('main_image')) {
            $file = $request->file('main_image');
            $filename = 'puppy_'.time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads/puppies/main'), $filename);
            $mainImagePath = 'uploads/puppies/main/'.$filename;
        }

        // Create sibling puppy with the same parentcat_id, category_id, and breeder_id as the parent puppy
        $sibling = Puppy::create([
            'breeder_id' => $puppy->breeder_id, // Use the breeder_id of the parent puppy
            'category_id' => $puppy->category_id, // Use the category_id of the parent puppy
            'parentcat_id' => $puppy->parentcat_id, // Use the parentcat_id of the parent puppy
            'birth_date' => $validated['birth_date'], // Use the parentcat_id of the parent puppy
            'color' => $validated['breed'], // Use the parentcat_id of the parent puppy
            'price' => $validated['price'], // Use the parentcat_id of the parent puppy
            'name' => $validated['name'],
            'gender' => $validated['gender'],
            'breed' => $validated['breed'],
            'main_image' => $mainImagePath,
            'status' => 'available',
        ]);

        // Save relationship in puppy_siblings table
        $puppy->siblings()->attach($sibling->id);

        return redirect()->route('puppies.siblings.index', $puppy->id)->with('success', 'Sibling added successfully!');
    }

    public function showSibling(Puppy $puppy, Puppy $sibling)
    {
        // Ensure the sibling is actually related to the given puppy
        if (!$puppy->siblings->contains($sibling)) {
            abort(404, 'Sibling not found for this puppy.');
        }

        return view('siblings.show', compact('puppy', 'sibling'));
    }

    public function editSibling(Puppy $puppy, Puppy $sibling)
    {
        // Ensure the sibling is actually related to the given puppy
        if (!$puppy->siblings->contains($sibling)) {
            abort(404, 'Sibling not found for this puppy.');
        }

        return view('siblings.edit', compact('puppy', 'sibling'));
    }

    public function updateSibling(Request $request, Puppy $puppy, Puppy $sibling)
{
    // Ensure the sibling is actually related to the given puppy
    if (!$puppy->siblings->contains($sibling)) {
        abort(404, 'Sibling not found for this puppy.');
    }

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'gender' => 'required|in:male,female',
        'breed' => 'required|string|max:255',
        'birth_date' => 'nullable|date',
        'color' => 'nullable|string|max:255',
        'price' => 'nullable|numeric|min:0',
        'description' => 'nullable|string',
        'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'remove_main_image' => 'nullable|boolean'
    ]);

    // Handle image upload/removal
    if ($request->hasFile('main_image')) {
        // Delete old image if exists
        if ($sibling->main_image && file_exists(public_path($sibling->main_image))) {
            unlink(public_path($sibling->main_image));
        }
        
        // Upload new image
        $file = $request->file('main_image');
        $filename = 'sibling_'.time().'_'.$file->getClientOriginalName();
        $file->move(public_path('uploads/puppies/main'), $filename);
        $validated['main_image'] = 'uploads/puppies/main/'.$filename;
    } elseif ($request->has('remove_main_image')) {
        // Remove image if checkbox is checked
        if ($sibling->main_image && file_exists(public_path($sibling->main_image))) {
            unlink(public_path($sibling->main_image));
        }
        $validated['main_image'] = null;
    } else {
        // Keep existing image if no changes
        $validated['main_image'] = $sibling->main_image;
    }

    // Update sibling with all validated data
    $sibling->update($validated);

    return redirect()->route('puppies.siblings.index', $puppy->id)
        ->with('success', 'Sibling updated successfully!');
}

    public function destroySibling(Puppy $puppy, Puppy $sibling)
    {
        // Ensure the sibling is actually related to the given puppy
        if (!$puppy->siblings->contains($sibling)) {
            abort(404, 'Sibling not found for this puppy.');
        }

        // Detach the sibling relationship
        $puppy->siblings()->detach($sibling->id);

        // Optionally, delete the sibling record if it is no longer needed
        $sibling->delete();

        return redirect()->route('puppies.siblings.index', $puppy->id)->with('success', 'Sibling deleted successfully!');
    }
    public function search(Request $request)
    {
        $query = $request->input('q', '');
        $type = $request->input('type', 'all');
        
        $puppies = Puppy::query()
            ->with(['breeder'])
            ->where(function($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('breed', 'like', "%{$query}%");
            });
        
        if ($type === 'pure') {
            $puppies->where('breed', 'pure_breed');
        } elseif ($type === 'cross') {
            $puppies->where('breed', 'cross_breed');
        }
        
        $results = $puppies->limit(10)
            ->get(['id', 'name', 'breed', 'gender', 'price', 'main_image', 'status'])
            ->map(function($puppy) {
                return [
                    'id' => $puppy->id,
                    'name' => $puppy->name,
                    'breed' => $puppy->breed,
                    'gender' => $puppy->gender,
                    'price' => $puppy->price,
                    'main_image' => asset($puppy->main_image),
                    'status' => $puppy->status,
                    'breeder_name' => $puppy->breeder->kennel_name ?? 'Unknown'
                ];
            });
        
        return response()->json($results);
    }
}