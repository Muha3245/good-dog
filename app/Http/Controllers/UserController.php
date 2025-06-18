<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\BreederProfile;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function store(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'programname' => 'nullable|string|max:255',
            'country' => 'nullable|string',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:20',
            'password' => [
                'required',
                'string',
                Password::min(6)
            ],
            'role' => 'required|string'
        ]);
        // dd($validated);

        $user = User::create([
            'firstname' => $validated['firstname'],
            'lastname' => $validated['lastname'],
            'program_name' => $validated['programname'],
            'country' => $validated['country'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'name' => $validated['firstname'] . ' ' . $validated['lastname'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);
        // dd($user);
        auth()->login($user);

        // Redirect with success message
        return redirect()->back()->with('success', 'Registration successful!');
    }
    public function update(Request $request)
{
    $user = auth()->user();

    $validatedUser = $request->validate([
        'firstname' => 'required|string|max:255',
        'lastname'  => 'required|string|max:255',
        'phone'     => 'nullable|string|max:20',
        'email'     => 'nullable|email|unique:users,email,' ,
        'password'   => [
            'nullable',
            'string',
            Password::min(6)
        ],
        'avatar'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    

    $user->update($validatedUser);

    
    // Redirect with success message
    return redirect()->back()->with('success', 'Profile updated successfully!');
 
}
public function breederstore(Request $request)
{
    $validated = $request->validate([
        'kennel_name' => 'required|string|max:255',
        'years_experience' => 'nullable|integer|min:0',
        'about' => 'nullable|string',
        'website' => 'nullable|url|max:255',
        'address' => 'required|string|max:255',
        'city' => 'required|string|max:255',
        'state' => 'required|string|max:255',
        'zip_code' => 'required|string|max:20',
        'latitude' => 'nullable|numeric',
        'longitude' => 'nullable|numeric',
        'is_licensed' => 'nullable|boolean',
        'license_number' => 'nullable|string|max:255',
        'is_akc_registered' => 'nullable|boolean',
        'akc_registration_number' => 'nullable|string|max:255',
        'accepts_visits' => 'nullable|boolean',
        'visit_policy' => 'nullable|string',
        'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'social_links.facebook' => 'nullable|url',
        'social_links.instagram' => 'nullable|url',
        'social_links.twitter' => 'nullable|url',
        'social_links.youtube' => 'nullable|url',
    ]);

    // Handle file uploads
    $profileImagePath = null;
    if ($request->hasFile('profile_image')) {
        $profileImage = $request->file('profile_image');
        $profileImageName = 'profile_'.time().'.'.$profileImage->getClientOriginalExtension();
        $profileImage->move(public_path('uploads/breeder_profiles'), $profileImageName);
        $profileImagePath = 'uploads/breeder_profiles/'.$profileImageName;
    }

    $coverImagePath = null;
    if ($request->hasFile('cover_image')) {
        $coverImage = $request->file('cover_image');
        $coverImageName = 'cover_'.time().'.'.$coverImage->getClientOriginalExtension();
        $coverImage->move(public_path('uploads/breeder_covers'), $coverImageName);
        $coverImagePath = 'uploads/breeder_covers/'.$coverImageName;
    }

    // Prepare social links
    $socialLinks = [
        'facebook' => $validated['social_links.facebook'] ?? null,
        'instagram' => $validated['social_links.instagram'] ?? null,
        'twitter' => $validated['social_links.twitter'] ?? null,
        'youtube' => $validated['social_links.youtube'] ?? null,
    ];

    // Create the breeder profile
    $breederProfile = BreederProfile::create([
        'user_id' => Auth::id(),
        'kennel_name' => $validated['kennel_name'],
        'years_experience' => $validated['years_experience'] ?? 0,
        'about' => $validated['about'] ?? null,
        'website' => $validated['website'] ?? null,
        'address' => $validated['address'],
        'city' => $validated['city'],
        'state' => $validated['state'],
        'zip_code' => $validated['zip_code'],
        'latitude' => $validated['latitude'] ?? null,
        'longitude' => $validated['longitude'] ?? null,
        'is_licensed' => $validated['is_licensed'] ?? false,
        'license_number' => $validated['license_number'] ?? null,
        'is_akc_registered' => $validated['is_akc_registered'] ?? false,
        'akc_registration_number' => $validated['akc_registration_number'] ?? null,
        'accepts_visits' => $validated['accepts_visits'] ?? false,
        'visit_policy' => $validated['visit_policy'] ?? null,
        'profile_image' => $profileImagePath,
        'cover_image' => $coverImagePath,
        'social_links' => json_encode(array_filter($socialLinks)),
    ]);

    return redirect()->route('breeders.profile', ['id' => Auth::id()])
        ->with('success', 'Breeder profile created successfully!');
}

public function breederupdate(Request $request, $id)
{
    $breeder = BreederProfile::where('user_id', Auth::id())->findOrFail($id);

    $validated = $request->validate([
        'kennel_name' => 'required|string|max:255',
        'years_experience' => 'nullable|integer|min:0',
        'about' => 'nullable|string',
        'website' => 'nullable|url|max:255',
        'address' => 'required|string|max:255',
        'city' => 'required|string|max:255',
        'state' => 'required|string|max:255',
        'zip_code' => 'required|string|max:20',
        'latitude' => 'nullable|numeric|between:-90,90',
        'longitude' => 'nullable|numeric|between:-180,180',
        'is_licensed' => 'nullable|boolean',
        'license_number' => 'nullable|string|max:255',
        'is_akc_registered' => 'nullable|boolean',
        'akc_registration_number' => 'nullable|string|max:255',
        'accepts_visits' => 'nullable|boolean',
        'visit_policy' => 'nullable|string',
        'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'social_links.facebook' => 'nullable|url',
        'social_links.instagram' => 'nullable|url',
        'social_links.twitter' => 'nullable|url',
        'social_links.youtube' => 'nullable|url',
    ]);

    // Handle profile image
    if ($request->hasFile('profile_image')) {
        // Delete old image if exists
        if ($breeder->profile_image && file_exists(public_path($breeder->profile_image))) {
            unlink(public_path($breeder->profile_image));
        }
        
        $profileImage = $request->file('profile_image');
        $profileImageName = 'profile_'.time().'.'.$profileImage->getClientOriginalExtension();
        $profileImage->move(public_path('uploads/breeder_profiles'), $profileImageName);
        $validated['profile_image'] = 'uploads/breeder_profiles/'.$profileImageName;
    } elseif ($request->has('remove_profile_image')) {
        // Remove profile image if checkbox is checked
        if ($breeder->profile_image && file_exists(public_path($breeder->profile_image))) {
            unlink(public_path($breeder->profile_image));
        }
        $validated['profile_image'] = null;
    }

    // Handle cover image
    if ($request->hasFile('cover_image')) {
        // Delete old image if exists
        if ($breeder->cover_image && file_exists(public_path($breeder->cover_image))) {
            unlink(public_path($breeder->cover_image));
        }
        
        $coverImage = $request->file('cover_image');
        $coverImageName = 'cover_'.time().'.'.$coverImage->getClientOriginalExtension();
        $coverImage->move(public_path('uploads/breeder_covers'), $coverImageName);
        $validated['cover_image'] = 'uploads/breeder_covers/'.$coverImageName;
    } elseif ($request->has('remove_cover_image')) {
        // Remove cover image if checkbox is checked
        if ($breeder->cover_image && file_exists(public_path($breeder->cover_image))) {
            unlink(public_path($breeder->cover_image));
        }
        $validated['cover_image'] = null;
    }

    // Handle boolean fields
    $booleanFields = [
        'is_licensed',
        'is_akc_registered',
        'accepts_visits',
    ];

    foreach ($booleanFields as $field) {
        $validated[$field] = (bool)($request->input($field) ?? false);
    }

    // Handle social links
    $socialLinks = array_filter([
        'facebook' => $request->input('social_links.facebook'),
        'instagram' => $request->input('social_links.instagram'),
        'twitter' => $request->input('social_links.twitter'),
        'youtube' => $request->input('social_links.youtube'),
    ]);
    $validated['social_links'] = json_encode($socialLinks);

    $breeder->update($validated);

    return redirect()->route('breeders.profile', ['id' => Auth::id()])
        ->with('success', 'Breeder profile updated successfully!');
}

}