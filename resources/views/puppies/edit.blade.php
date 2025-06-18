@extends('layouts.admin')

@section('title', 'Edit Puppy')



@section('admin')
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Puppy Information</h3>
            </div>
            <form method="POST" action="{{ route('puppies.update', $puppy) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="card-body">
                    <div class="row">
                        <!-- Left Column -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="category_id">Category *</label>
                                <select class="form-control select2 @error('category_id') is-invalid @enderror" 
                                    id="category_id" name="category_id" required>
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" 
                                            {{ old('category_id', $puppy->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="name">Puppy Name *</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                    id="name" name="name" value="{{ old('name', $puppy->name) }}" required>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="gender">Gender *</label>
                                <select class="form-control @error('gender') is-invalid @enderror" 
                                    id="gender" name="gender" required>
                                    <option value="male" {{ old('gender', $puppy->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ old('gender', $puppy->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                </select>
                                @error('gender')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="birth_date">Birth Date</label>
                                <input type="date" class="form-control @error('birth_date') is-invalid @enderror" 
                                    id="birth_date" name="birth_date" value="{{ old('birth_date', $puppy->birth_date ? $puppy->birth_date->format('Y-m-d') : '') }}">
                                @error('birth_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="breed">Breed Type *</label>
                                <select class="form-control @error('breed') is-invalid @enderror" id="breed" name="breed" required>
                                    <option value="">Select Breed Type</option>
                                    <option value="pure_breed" {{ old('breed', $puppy->breed) == 'pure_breed' ? 'selected' : '' }}>Pure Breed</option>
                                    <option value="cross_breed" {{ old('breed', $puppy->breed) == 'cross_breed' ? 'selected' : '' }}>Cross Breed</option>
                                </select>
                                @error('breed')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="color">Color</label>
                                <input type="text" class="form-control @error('color') is-invalid @enderror" 
                                    id="color" name="color" value="{{ old('color', $puppy->color) }}">
                                @error('color')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="weight">Weight (kg)</label>
                                <input type="number" step="0.1" class="form-control @error('weight') is-invalid @enderror" 
                                    id="weight" name="weight" value="{{ old('weight', $puppy->weight) }}">
                                @error('weight')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="height">Height (cm)</label>
                                <input type="number" step="0.1" class="form-control @error('height') is-invalid @enderror" 
                                    id="height" name="height" value="{{ old('height', $puppy->height) }}">
                                @error('height')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="price">Price ($) *</label>
                                <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" 
                                    id="price" name="price" value="{{ old('price', $puppy->price) }}" required>
                                @error('price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Status and Parent Category -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="status">Status *</label>
                                <select class="form-control @error('status') is-invalid @enderror" 
                                    id="status" name="status" required>
                                    <option value="available" {{ old('status', $puppy->status) == 'available' ? 'selected' : '' }}>Available</option>
                                    <option value="reserved" {{ old('status', $puppy->status) == 'reserved' ? 'selected' : '' }}>Reserved</option>
                                    <option value="sold" {{ old('status', $puppy->status) == 'sold' ? 'selected' : '' }}>Sold</option>
                                </select>
                                @error('status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="parentcat_id">Parent Category *</label>
                                <select class="form-control select2 @error('parentcat_id') is-invalid @enderror" 
                                    id="parentcat_id" name="parentcat_id" required>
                                    <option value="">Select Parent Category</option>
                                    @foreach($breederparants as $parent)
                                        <option value="{{ $parent->id }}" 
                                            {{ old('parentcat_id', $puppy->parentcat_id) == $parent->id ? 'selected' : '' }}>
                                            {{ $parent->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('parentcat_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                            id="description" name="description">{{ old('description', $puppy->description) }}</textarea>
                        @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- Images -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="main_image">Main Image</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input @error('main_image') is-invalid @enderror" 
                                        id="main_image" name="main_image">
                                    <label class="custom-file-label" for="main_image">Choose file</label>
                                </div>
                                @error('main_image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                @if($puppy->main_image)
                                    <div class="mt-3">
                                        <img src="{{ asset($puppy->main_image) }}" class="img-thumbnail" style="max-height: 150px;">
                                        <div class="custom-control custom-checkbox mt-2">
                                            <input type="checkbox" class="custom-control-input" id="remove_main_image" name="remove_main_image">
                                            <label class="custom-control-label" for="remove_main_image">Remove current image</label>
                                        </div>
                                    </div>
                                @endif
                                <small class="form-text text-muted">Max size: 2MB (JPEG, PNG, JPG, GIF)</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="images">Gallery Images</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input @error('images.*') is-invalid @enderror" 
                                        id="images" name="images[]" multiple>
                                    <label class="custom-file-label" for="images">Choose files</label>
                                </div>
                                @error('images.*')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                                @if($puppy->gallery)
                                    <div class="mt-3">
                                        <h6>Current Gallery Images:</h6>
                                        <div class="d-flex flex-wrap">
                                            @foreach(json_decode($puppy->gallery) as $image)
                                                <div class="position-relative m-2" style="width: 100px;">
                                                    <img src="{{ asset($image) }}" class="img-thumbnail" style="max-height: 80px;">
                                                    <div class="custom-control custom-checkbox position-absolute" style="top: 0; right: 0;">
                                                        <input type="checkbox" class="custom-control-input" name="remove_gallery_images[]" value="{{ $image }}" id="remove_image_{{ $loop->index }}">
                                                        <label class="custom-control-label" for="remove_image_{{ $loop->index }}"></label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <small class="form-text text-muted">Check images to remove</small>
                                    </div>
                                @endif
                                <small class="form-text text-muted">You can select multiple images</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Puppy
                    </button>
                    <a href="{{ route('puppies.index') }}" class="btn btn-secondary float-right">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- CKEditor with full toolbar -->
<script src="https://cdn.ckeditor.com/4.16.2/full/ckeditor.js"></script>
<script>
    // Initialize CKEditor with all features
    CKEDITOR.replace('description', {
        height: 300,
        // Allow all content
        allowedContent: true,
        // File upload configuration (if needed)
       
    });

    // AdminLTE file input styling
    $(document).ready(function() {
        bsCustomFileInput.init();
    });
</script>
@endsection