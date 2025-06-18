<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rule;
use App\Models\BreederCategory;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BreederCategoryController extends Controller
{
    public function index()
    {
        $categories = BreederCategory::orderBy('order')
            ->get();

        return view('category.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:breeder_categories',
            'slug' => 'nullable|string|max:255|unique:breeder_categories',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_active' => 'nullable',
            'order' => 'integer|min:0',
            'breeder_id' => 'required|exists:breeder_profiles,id'
        ]);

        // Handle image upload
        if($request->file('image')){
            $file = $request->file('image');
            $filename = date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('image'), $filename);
            $validated['image'] = $filename;
        }

        // Handle is_active checkbox
        $validated['is_active'] = $request->has('is_active');
        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['name']);

        // Create the category
        $category = BreederCategory::create($validated);

        // Associate with breeder
        $data= DB::table('breeder_category')->insert([
            'breeder_id' => $validated['breeder_id'],
            'category_id' => $category->id
        ]);

        return redirect()->back()->with('success', 'Category added successfully!');
    }

    public function show(BreederCategory $breederCategory)
    {
        return view('category.show', compact('breederCategory'));
    }

    public function update(Request $request, $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_active' => 'nullable',
            'order' => 'integer|min:0',
            'remove_image' => 'nullable|boolean'
        ]);

        $category = BreederCategory::findOrFail($category);

        // Handle image update/removal
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($category->image && file_exists(public_path('image/'.$category->image))) {
                unlink(public_path('image/'.$category->image));
            }
            
            $file = $request->file('image');
            $filename = date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('image'), $filename);
            $validated['image'] = $filename;
        } elseif ($request->has('remove_image')) {
            if ($category->image && file_exists(public_path('image/'.$category->image))) {
                unlink(public_path('image/'.$category->image));
            }
            $validated['image'] = null;
        } else {
            unset($validated['image']);
        }

        // Handle is_active checkbox
        $validated['is_active'] = $request->has('is_active');

        $category->update($validated);

        return redirect()->back()->with('success', 'Category updated successfully!');
    }

    public function destroy(BreederCategory $breederCategory)
    {
        // Delete image if exists
        if ($breederCategory->image && file_exists(public_path('image/'.$breederCategory->image))) {
            unlink(public_path('image/'.$breederCategory->image));
        }

        // Delete the category
        $breederCategory->delete();

        return redirect()->back()->with('success', 'Category deleted successfully!');
    }
}