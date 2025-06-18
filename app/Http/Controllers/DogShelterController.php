<?php

namespace App\Http\Controllers;

use App\Models\DogShelter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class DogShelterController extends Controller
{
    public function index()
    {
        $shelters = DogShelter::latest()->paginate(10);
        return view('dog-shelters.index', compact('shelters'));
    }

    public function create()
    {
        return view('dog-shelters.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'cover_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'location' => 'required|string|max:255',
            'file' => 'required|file|mimes:jpeg,png,jpg,mp4,mov,avi|max:10000',
            'description' => 'required|string',
            'is_active' => 'boolean'
        ]);

        // Create directories if they don't exist
        $this->ensureDirectoryExists('shelters/covers');
        $this->ensureDirectoryExists('shelters/files');

        // Handle cover image
        $coverImage = $request->file('cover_image');
        $coverName = 'cover_'.time().'_'.Str::random(10).'.'.$coverImage->getClientOriginalExtension();
        $coverImage->move(public_path('shelters/covers'), $coverName);
        $validated['cover_image'] = 'shelters/covers/'.$coverName;

        // Handle main file (image/video)
        $file = $request->file('file');
        $fileName = 'file_'.time().'_'.Str::random(10).'.'.$file->getClientOriginalExtension();
        $file->move(public_path('shelters/files'), $fileName);
        $validated['file_path'] = 'shelters/files/'.$fileName;
        $validated['file_type'] = str_starts_with($file->getMimeType(), 'video') ? 'video' : 'image';

        DogShelter::create($validated);

        return redirect()->route('dog-shelters.index')->with('success', 'Shelter created successfully!');
    }

    public function show(DogShelter $dogShelter)
    {
        return view('dog-shelters.show', compact('dogShelter'));
    }

    public function edit(DogShelter $dogShelter)
    {
        return view('dog-shelters.edit', compact('dogShelter'));
    }

    public function update(Request $request, DogShelter $dogShelter)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'location' => 'required|string|max:255',
            'file' => 'nullable|file|mimes:jpeg,png,jpg,mp4,mov,avi|max:10000',
            'description' => 'required|string',
            'is_active' => 'boolean'
        ]);

        // Update cover image if provided
        if ($request->hasFile('cover_image')) {
            // Delete old cover image
            if ($dogShelter->cover_image && file_exists(public_path($dogShelter->cover_image))) {
                unlink(public_path($dogShelter->cover_image));
            }

            $coverImage = $request->file('cover_image');
            $coverName = 'cover_'.time().'_'.Str::random(10).'.'.$coverImage->getClientOriginalExtension();
            $coverImage->move(public_path('shelters/covers'), $coverName);
            $validated['cover_image'] = 'shelters/covers/'.$coverName;
        } else {
            unset($validated['cover_image']);
        }

        // Update main file if provided
        if ($request->hasFile('file')) {
            // Delete old file
            if ($dogShelter->file_path && file_exists(public_path($dogShelter->file_path))) {
                unlink(public_path($dogShelter->file_path));
            }

            $file = $request->file('file');
            $fileName = 'file_'.time().'_'.Str::random(10).'.'.$file->getClientOriginalExtension();
            $file->move(public_path('shelters/files'), $fileName);
            $validated['file_path'] = 'shelters/files/'.$fileName;
            $validated['file_type'] = str_starts_with($file->getMimeType(), 'video') ? 'video' : 'image';
        } else {
            unset($validated['file_path']);
            unset($validated['file_type']);
        }

        $dogShelter->update($validated);

        return redirect()->route('dog-shelters.index')->with('success', 'Shelter updated successfully!');
    }

    public function destroy(DogShelter $dogShelter)
    {
        // Delete cover image
        if ($dogShelter->cover_image && file_exists(public_path($dogShelter->cover_image))) {
            unlink(public_path($dogShelter->cover_image));
        }

        // Delete main file
        if ($dogShelter->file_path && file_exists(public_path($dogShelter->file_path))) {
            unlink(public_path($dogShelter->file_path));
        }

        $dogShelter->delete();

        return redirect()->route('dog-shelters.index')->with('success', 'Shelter deleted successfully!');
    }

    protected function ensureDirectoryExists($path)
    {
        if (!File::exists(public_path($path))) {
            File::makeDirectory(public_path($path), 0755, true);
        }
    }
}