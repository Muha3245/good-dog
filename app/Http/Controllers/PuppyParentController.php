<?php

namespace App\Http\Controllers;

use App\Models\Puppy;
use App\Models\PuppyParent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PuppyParentController extends Controller
{
    public function index($id)
    {
        $puppy = Puppy::findOrFail($id);
        $parents = PuppyParent::where('puppy_id', $id)->latest()->paginate(10);
        return view('puppy-parents.index', compact('parents', 'puppy'));
    }

    public function create(Puppy $puppy)
    {
        return view('puppy-parents.create', compact('puppy'));
    }

    public function store(Request $request, Puppy $puppy)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'required|in:male,female',
            'breed' => 'required|in:Mom,Dad',            'registration_number' => 'nullable|string',
            'image' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $file = $request->file('image');
            $filename = 'parent_'.time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads/parents'), $filename);
            $validated['image'] = 'uploads/parents/'.$filename;
        }

        $puppy->parents()->create($validated);

        return redirect()->route('puppy-parents.index', $puppy->id)->with('success', 'Parent added successfully!');
    }

    public function edit(Puppy $puppy, PuppyParent $parent)
    {
        return view('puppy-parents.edit', compact('puppy', 'parent'));
    }

    public function update(Request $request, Puppy $puppy, PuppyParent $parent)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'required|in:male,female',
            'breed' => 'required|in:Mom,Dad',            'registration_number' => 'nullable|string',
            'image' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            // Delete old image if exists
            if ($parent->image && file_exists(public_path($parent->image))) {
                unlink(public_path($parent->image));
            }
            
            $file = $request->file('image');
            $filename = 'parent_'.time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads/parents'), $filename);
            $validated['image'] = 'uploads/parents/'.$filename;
        }

        $parent->update($validated);

        return redirect()->route('puppy-parents.index', $puppy->id)->with('success', 'Parent updated successfully!');
    }

    public function destroy(Puppy $puppy, PuppyParent $parent)
    {
        if ($parent->image && file_exists(public_path($parent->image))) {
            unlink(public_path($parent->image));
        }
        
        $parent->delete();
        return redirect()->route('puppy-parents.index', $puppy->id)->with('success', 'Parent removed successfully!');
    }
}