@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Edit Breeder: {{ $breeder->kennel_name }}</h1>

    <form action="{{ route('breeders.update', $breeder) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="kennel_name" class="form-label">Kennel Name *</label>
                    <input type="text" class="form-control" id="kennel_name" name="kennel_name" value="{{ old('kennel_name', $breeder->kennel_name) }}" required>
                </div>

                <div class="mb-3">
                    <label for="about" class="form-label">About</label>
                    <textarea class="form-control" id="about" name="about" rows="3">{{ old('about', $breeder->about) }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="website" class="form-label">Website</label>
                    <input type="url" class="form-control" id="website" name="website" value="{{ old('website', $breeder->website) }}">
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label for="address" class="form-label">Address *</label>
                    <input type="text" class="form-control" id="address" name="address" value="{{ old('address', $breeder->address) }}" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="city" class="form-label">City *</label>
                        <input type="text" class="form-control" id="city" name="city" value="{{ old('city', $breeder->city) }}" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="state" class="form-label">State *</label>
                        <input type="text" class="form-control" id="state" name="state" value="{{ old('state', $breeder->state) }}" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="zip_code" class="form-label">Zip Code *</label>
                        <input type="text" class="form-control" id="zip_code" name="zip_code" value="{{ old('zip_code', $breeder->zip_code) }}" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="categories" class="form-label">Categories</label>
                    <select class="form-select" id="categories" name="categories[]" multiple>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" @if(in_array($category->id, $selectedCategories)) selected @endif>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="profile_image" class="form-label">Profile Image</label>
                    <input type="file" class="form-control" id="profile_image" name="profile_image">
                    @if($breeder->profile_image)
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $breeder->profile_image) }}" alt="Current Profile Image" class="img-thumbnail" style="max-height: 100px;">
                            <div class="form-check mt-2">
                                <input class="form-check-input" type="checkbox" id="remove_profile_image" name="remove_profile_image">
                                <label class="form-check-label" for="remove_profile_image">Remove current image</label>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Update Breeder</button>
        <a href="{{ route('breeders.show', $breeder) }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection