@extends('layouts.admin')

@section('admin')
<div class="col-md-12">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Breeder Profile Management</h1>
                </div>
                
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h5><i class="icon fas fa-check"></i> Success!</h5>
                    {{ session('success') }}
                </div>
            @endif

            <!-- User Information Card -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-user mr-2"></i>
                        User Information
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-toggle="modal" data-target="#editUserModal">
                            <i class="fas fa-edit"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>First Name</label>
                                <p class="form-control-static">{{ $user->firstname ?? 'N/A' }}</p>
                            </div>
                            <div class="form-group">
                                <label>Last Name</label>
                                <p class="form-control-static">{{ $user->lastname ?? 'N/A' }}</p>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <p class="form-control-static">{{ $user->email }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Program Name</label>
                                <p class="form-control-static">{{ $user->program_name ?? 'N/A' }}</p>
                            </div>
                            <div class="form-group">
                                <label>Country</label>
                                <p class="form-control-static">{{ $user->country ?? 'N/A' }}</p>
                            </div>
                            <div class="form-group">
                                <label>Phone</label>
                                <p class="form-control-static">{{ $user->phone ?? 'N/A' }}</p>
                            </div>
                            <div class="form-group">
                                <label>Role</label>
                                <p class="form-control-static">
                                    <span class="badge badge-{{ $user->role === 'admin' ? 'danger' : ($user->role === 'breeder' ? 'success' : 'primary') }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if($breeder)
                <!-- Breeder Information Card -->
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-paw mr-2"></i>
                            Breeder Profile Information
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-toggle="modal" data-target="#editBreederModal">
                                <i class="fas fa-edit"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h5><i class="fas fa-info-circle"></i> Basic Information</h5>
                                <div class="form-group">
                                    <label>Kennel Name</label>
                                    <p class="form-control-static">{{ $breeder->kennel_name }}</p>
                                </div>
                                <div class="form-group">
                                    <label>Years Experience</label>
                                    <p class="form-control-static">{{ $breeder->years_experience ?? 'N/A' }}</p>
                                </div>
                                <div class="form-group">
                                    <label>About</label>
                                    <p class="form-control-static">{{ $breeder->about ?? 'N/A' }}</p>
                                </div>
                                <div class="form-group">
                                    <label>Website</label>
                                    <p class="form-control-static">
                                        @if($breeder->website)
                                            <a href="{{ $breeder->website }}" target="_blank">{{ $breeder->website }}</a>
                                        @else
                                            N/A
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h5><i class="fas fa-map-marker-alt"></i> Location</h5>
                                <div class="form-group">
                                    <label>Address</label>
                                    <p class="form-control-static">{{ $breeder->address }}</p>
                                </div>
                                <div class="form-group">
                                    <label>City</label>
                                    <p class="form-control-static">{{ $breeder->city }}</p>
                                </div>
                                <div class="form-group">
                                    <label>State</label>
                                    <p class="form-control-static">{{ $breeder->state }}</p>
                                </div>
                                <div class="form-group">
                                    <label>Zip Code</label>
                                    <p class="form-control-static">{{ $breeder->zip_code }}</p>
                                </div>
                                <div class="form-group">
                                    <label>Coordinates</label>
                                    <p class="form-control-static">
                                        @if($breeder->latitude && $breeder->longitude)
                                            {{ $breeder->latitude }}, {{ $breeder->longitude }}
                                        @else
                                            N/A
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-6">
                                <h5><i class="fas fa-certificate"></i> Certifications</h5>
                                <div class="form-group">
                                    <label>Licensed</label>
                                    <p class="form-control-static">
                                        <span class="badge badge-{{ $breeder->is_licensed ? 'success' : 'secondary' }}">
                                            {{ $breeder->is_licensed ? 'Yes' : 'No' }}
                                        </span>
                                    </p>
                                </div>
                                <div class="form-group">
                                    <label>License Number</label>
                                    <p class="form-control-static">{{ $breeder->license_number ?? 'N/A' }}</p>
                                </div>
                                <div class="form-group">
                                    <label>AKC Registered</label>
                                    <p class="form-control-static">
                                        <span class="badge badge-{{ $breeder->is_akc_registered ? 'success' : 'secondary' }}">
                                            {{ $breeder->is_akc_registered ? 'Yes' : 'No' }}
                                        </span>
                                    </p>
                                </div>
                                <div class="form-group">
                                    <label>AKC Registration #</label>
                                    <p class="form-control-static">{{ $breeder->akc_registration_number ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h5><i class="fas fa-paw"></i> Policies</h5>
                                <div class="form-group">
                                    <label>Accepts Visits</label>
                                    <p class="form-control-static">
                                        <span class="badge badge-{{ $breeder->accepts_visits ? 'success' : 'secondary' }}">
                                            {{ $breeder->accepts_visits ? 'Yes' : 'No' }}
                                        </span>
                                    </p>
                                </div>
                                <div class="form-group">
                                    <label>Visit Policy</label>
                                    <p class="form-control-static">{{ $breeder->visit_policy ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Social Links Section -->
                        @if($breeder->social_links)
                            @php
                                $socialLinks = json_decode($breeder->social_links, true);
                                $socialLinks = is_array($socialLinks) ? $socialLinks : [];
                            @endphp
                            @if(!empty(array_filter($socialLinks)))
                                <div class="row mt-4">
                                    <div class="col-md-12">
                                        <h5><i class="fas fa-share-alt"></i> Social Links</h5>
                                        <div class="form-group">
                                            @foreach($socialLinks as $platform => $url)
                                                @if($url)
                                                    <a href="{{ $url }}" target="_blank" class="btn btn-outline-primary btn-sm mr-2 mb-2">
                                                        <i class="fab fa-{{ $platform }} mr-1"></i>
                                                        {{ ucfirst($platform) }}
                                                    </a>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endif

                        <!-- Media Section -->
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <h5><i class="fas fa-image"></i> Profile Image</h5>
                                @if($breeder->profile_image)
                                    <img src="{{ asset($breeder->profile_image) }}" class="img-fluid rounded" style="max-height: 200px;" alt="Profile Image">
                                @else
                                    <p class="text-muted">No profile image uploaded</p>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <h5><i class="fas fa-image"></i> Cover Image</h5>
                                @if($breeder->cover_image)
                                    <img src="{{ asset($breeder->cover_image) }}" class="img-fluid rounded" style="max-height: 200px;" alt="Cover Image">
                                @else
                                    <p class="text-muted">No cover image uploaded</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="card card-warning">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            No Breeder Profile Found
                        </h3>
                    </div>
                    <div class="card-body">
                        <p>This user doesn't have a breeder profile yet.</p>
                        <button class="btn btn-primary" data-toggle="modal" data-target="#createBreederModal">
                            <i class="fas fa-plus mr-2"></i>Create Breeder Profile
                        </button>
                    </div>
                </div>
            @endif
        </div>
    </section>
</div>

<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="{{route('users.update')}}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel">Edit User Information</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="firstname">First Name</label>
                                <input type="text" class="form-control" id="firstname" name="firstname" value="{{ old('firstname', $user->firstname) }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="lastname">Last Name</label>
                                <input type="text" class="form-control" id="lastname" name="lastname" value="{{ old('lastname', $user->lastname) }}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}">
                    </div>
                    <div class="form-group">
                        <label for="program_name">Program Name</label>
                        <input type="text" class="form-control" id="program_name" name="program_name" value="{{ old('program_name', $user->program_name) }}">
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="country">Country</label>
                                <input type="text" class="form-control" id="country" name="country" value="{{ old('country', $user->country) }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Leave blank to keep current password">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Breeder Modal -->
@if($breeder)
<div class="modal fade" id="editBreederModal" tabindex="-1" role="dialog" aria-labelledby="editBreederModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="{{ route('breeders.update', $breeder->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editBreederModalLabel">Edit Breeder Profile</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Basic Information Section -->
                    <div class="form-group">
                        <label for="kennel_name">Kennel Name</label>
                        <input type="text" class="form-control" id="kennel_name" name="kennel_name" value="{{ old('kennel_name', $breeder->kennel_name) }}">
                    </div>
                    <div class="form-group">
                        <label for="about">About</label>
                        <textarea class="form-control" id="about" name="about" rows="3">{{ old('about', $breeder->about) }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="website">Website</label>
                        <input type="url" class="form-control" id="website" name="website" value="{{ old('website', $breeder->website) }}">
                    </div>
                    <div class="form-group">
                        <label for="years_experience">Years of Experience</label>
                        <input type="number" class="form-control" id="years_experience" name="years_experience" value="{{ old('years_experience', $breeder->years_experience) }}">
                    </div>

                    <!-- Location Section -->
                    <h5 class="mt-4">Location Information</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="address">Address</label>
                                <input type="text" class="form-control" id="address" name="address" value="{{ old('address', $breeder->address) }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="city">City</label>
                                <input type="text" class="form-control" id="city" name="city" value="{{ old('city', $breeder->city) }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="state">State</label>
                                <input type="text" class="form-control" id="state" name="state" value="{{ old('state', $breeder->state) }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="zip_code">Zip Code</label>
                                <input type="text" class="form-control" id="zip_code" name="zip_code" value="{{ old('zip_code', $breeder->zip_code) }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="latitude">Latitude</label>
                                <input type="number" step="0.0000001" class="form-control" id="latitude" name="latitude" value="{{ old('latitude', $breeder->latitude) }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="longitude">Longitude</label>
                                <input type="number" step="0.0000001" class="form-control" id="longitude" name="longitude" value="{{ old('longitude', $breeder->longitude) }}">
                            </div>
                        </div>
                    </div>

                    <!-- Certifications Section -->
                    <h5 class="mt-4">Certifications</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="is_licensed" name="is_licensed" value="1" {{ old('is_licensed', $breeder->is_licensed) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_licensed">Is Licensed</label>
                            </div>
                            <div class="form-group mt-2">
                                <label for="license_number">License Number</label>
                                <input type="text" class="form-control" id="license_number" name="license_number" value="{{ old('license_number', $breeder->license_number) }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="is_akc_registered" name="is_akc_registered" value="1" {{ old('is_akc_registered', $breeder->is_akc_registered) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_akc_registered">Is AKC Registered</label>
                            </div>
                            <div class="form-group mt-2">
                                <label for="akc_registration_number">AKC Registration Number</label>
                                <input type="text" class="form-control" id="akc_registration_number" name="akc_registration_number" value="{{ old('akc_registration_number', $breeder->akc_registration_number) }}">
                            </div>
                        </div>
                    </div>

                    <!-- Policies Section -->
                    <h5 class="mt-4">Policies</h5>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="accepts_visits" name="accepts_visits" value="1" {{ old('accepts_visits', $breeder->accepts_visits) ? 'checked' : '' }}>
                        <label class="form-check-label" for="accepts_visits">Accepts Visits</label>
                    </div>
                    <div class="form-group mt-2">
                        <label for="visit_policy">Visit Policy</label>
                        <textarea class="form-control" id="visit_policy" name="visit_policy" rows="3">{{ old('visit_policy', $breeder->visit_policy) }}</textarea>
                    </div>

                    <!-- Media Section -->
                    <h5 class="mt-4">Media</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="profile_image">Profile Image</label>
                                <input type="file" class="form-control-file" id="profile_image" name="profile_image">
                                @if($breeder->profile_image)
                                    <div class="mt-2">
                                        <small>Current: {{ basename($breeder->profile_image) }}</small>
                                        <div class="form-check mt-2">
                                            <input class="form-check-input" type="checkbox" name="remove_profile_image" id="remove_profile_image">
                                            <label class="form-check-label" for="remove_profile_image">Remove current profile image</label>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="cover_image">Cover Image</label>
                                <input type="file" class="form-control-file" id="cover_image" name="cover_image">
                                @if($breeder->cover_image)
                                    <div class="mt-2">
                                        <small>Current: {{ basename($breeder->cover_image) }}</small>
                                        <div class="form-check mt-2">
                                            <input class="form-check-input" type="checkbox" name="remove_cover_image" id="remove_cover_image">
                                            <label class="form-check-label" for="remove_cover_image">Remove current cover image</label>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Social Links Section -->
                    <h5 class="mt-4">Social Links</h5>
                    @php
                        $socialLinks = $breeder->social_links ? json_decode($breeder->social_links, true) : [];
                    @endphp
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="facebook">Facebook</label>
                                <input type="url" class="form-control" id="facebook" name="social_links[facebook]" value="{{ old('social_links.facebook', $socialLinks['facebook'] ?? '') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="instagram">Instagram</label>
                                <input type="url" class="form-control" id="instagram" name="social_links[instagram]" value="{{ old('social_links.instagram', $socialLinks['instagram'] ?? '') }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="twitter">Twitter</label>
                                <input type="url" class="form-control" id="twitter" name="social_links[twitter]" value="{{ old('social_links.twitter', $socialLinks['twitter'] ?? '') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="youtube">YouTube</label>
                                <input type="url" class="form-control" id="youtube" name="social_links[youtube]" value="{{ old('social_links.youtube', $socialLinks['youtube'] ?? '') }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

<!-- Create Breeder Modal -->
{{-- <div class="modal fade" id="createBreederModal" tabindex="-1" role="dialog" aria-labelledby="createBreederModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="{{ route('breeders.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="user_id" value="{{ $user->id }}">
                <div class="modal-header">
                    <h5 class="modal-title" id="createBreederModalLabel">Create Breeder Profile</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <!-- Basic Information Section -->
                    <div class="form-group">
                        <label for="kennel_name">Kennel Name*</label>
                        <input type="text" class="form-control" id="kennel_name" name="kennel_name" value="{{ old('kennel_name') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="about">About</label>
                        <textarea class="form-control" id="about" name="about" rows="3">{{ old('about') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="website">Website</label>
                        <input type="url" class="form-control" id="website" name="website" value="{{ old('website') }}">
                    </div>
                    <div class="form-group">
                        <label for="years_experience">Years of Experience</label>
                        <input type="number" class="form-control" id="years_experience" name="years_experience" value="{{ old('years_experience') }}">
                    </div>

                    <!-- Location Section -->
                    <h5 class="mt-4">Location Information</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="address">Address*</label>
                                <input type="text" class="form-control" id="address" name="address" value="{{ old('address') }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="city">City*</label>
                                <input type="text" class="form-control" id="city" name="city" value="{{ old('city') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="state">State*</label>
                                <input type="text" class="form-control" id="state" name="state" value="{{ old('state') }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="zip_code">Zip Code*</label>
                                <input type="text" class="form-control" id="zip_code" name="zip_code" value="{{ old('zip_code') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="latitude">Latitude</label>
                                <input type="number" step="0.0000001" class="form-control" id="latitude" name="latitude" value="{{ old('latitude') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="longitude">Longitude</label>
                                <input type="number" step="0.0000001" class="form-control" id="longitude" name="longitude" value="{{ old('longitude') }}">
                            </div>
                        </div>
                    </div>

                    <!-- Media Section -->
                    <h5 class="mt-4">Media</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="profile_image">Profile Image</label>
                                <input type="file" class="form-control-file" id="profile_image" name="profile_image">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="cover_image">Cover Image</label>
                                <input type="file" class="form-control-file" id="cover_image" name="cover_image">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Profile</button>
                </div>
            </form>
        </div>
    </div>
</div> --}}

<script>
    $(document).ready(function() {
        // Toggle license number field based on checkbox
        $('#is_licensed').change(function() {
            $('#license_number').prop('disabled', !this.checked);
        }).trigger('change');

        // Toggle AKC registration number field based on checkbox
        $('#is_akc_registered').change(function() {
            $('#akc_registration_number').prop('disabled', !this.checked);
        }).trigger('change');

        // Show success message
        @if(session('success'))
            toastr.success('{{ session('success') }}');
        @endif
    });
</script>
@endsection
