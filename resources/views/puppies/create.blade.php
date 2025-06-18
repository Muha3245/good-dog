@extends('layouts.admin')

@section('title', 'Add New Puppy')

@section('admin')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Puppy Information</h3>
                </div>
                <form method="POST" action="{{ route('puppies.store') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="breeder_id" value="{{ $breeder->id }}">

                    <div class="card-body">
                        <!-- Basic Information Section -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5><i class="fas fa-info-circle"></i> Basic Information</h5>
                                <hr>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="category_id">Category *</label>
                                    <select class="form-control select2 @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="name">Puppy Name *</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                        id="name" name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="gender">Gender *</label>
                                    <select class="form-control @error('gender') is-invalid @enderror" 
                                        id="gender" name="gender" required>
                                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                    </select>
                                    @error('gender')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="parentcat_id">Parent Category *</label>
                                    <select class="form-control select2 @error('parentcat_id') is-invalid @enderror" id="parentcat_id" name="parentcat_id" required>
                                        <option value="">Select Parent Category</option>
                                        @foreach($parentCats as $category)
                                            <option value="{{ $category->id }}" {{ old('parentcat_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('parentcat_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="breed">Breed *</label>
                                    <select class="form-control @error('breed') is-invalid @enderror" id="breed" name="breed">
                                        <option value="" disabled selected>Select Breed Type</option>
                                        <option value="pure_breed" {{ old('breed', $breeder->breed) == 'pure_breed' ? 'selected' : '' }}>Pure Breed</option>
                                        <option value="cross_breed" {{ old('breed', $breeder->breed) == 'cross_breed' ? 'selected' : '' }}>Cross Breed</option>
                                    </select>
                                    @error('breed')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="birth_date">Birth Date</label>
                                    <input type="date" class="form-control @error('birth_date') is-invalid @enderror" 
                                        id="birth_date" name="birth_date" value="{{ old('birth_date') }}">
                                    @error('birth_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Physical Attributes Section -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5><i class="fas fa-paw"></i> Physical Attributes</h5>
                                <hr>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="color">Color</label>
                                    <input type="text" class="form-control @error('color') is-invalid @enderror" 
                                        id="color" name="color" value="{{ old('color') }}">
                                    @error('color')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="weight">Weight (kg)</label>
                                    <input type="number" step="0.1" class="form-control @error('weight') is-invalid @enderror" 
                                        id="weight" name="weight" value="{{ old('weight') }}">
                                    @error('weight')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="height">Height (cm)</label>
                                    <input type="number" step="0.1" class="form-control @error('height') is-invalid @enderror" 
                                        id="height" name="height" value="{{ old('height') }}">
                                    @error('height')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Pricing Section -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5><i class="fas fa-tag"></i> Pricing</h5>
                                <hr>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="price">Price ($) *</label>
                                    <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" 
                                        id="price" name="price" value="{{ old('price') }}" required>
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status">Status *</label>
                                    <select class="form-control @error('status') is-invalid @enderror" 
                                        id="status" name="status" required>
                                        <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Available</option>
                                        <option value="reserved" {{ old('status') == 'reserved' ? 'selected' : '' }}>Reserved</option>
                                        <option value="sold" {{ old('status') == 'sold' ? 'selected' : '' }}>Sold</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Description Section -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5><i class="fas fa-align-left"></i> Description</h5>
                                <hr>
                            </div>
                            
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                        id="description" name="description" rows="5">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Images Section -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5><i class="fas fa-images"></i> Images</h5>
                                <hr>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="main_image">Main Image *</label>
                                    <input type="file" class="form-control @error('main_image') is-invalid @enderror" 
                                        id="main_image" name="main_image" required>
                                    @error('main_image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Max size: 2MB (JPEG, PNG, JPG, GIF)</small>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="images">Gallery Images</label>
                                    <input type="file" class="form-control @error('images.*') is-invalid @enderror" 
                                        id="images" name="images[]" multiple>
                                    @error('images.*')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">You can select multiple images</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Save Puppy
                        </button>
                        <a href="{{ route('puppies.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Load CKEditor from CDN -->
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script>
    // Replace the textarea with CKEditor
    CKEDITOR.replace('description', {
        // Optional configuration
        toolbar: [
            { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike'] },
            { name: 'paragraph', items: ['NumberedList', 'BulletedList'] },
            { name: 'links', items: ['Link', 'Unlink'] },
            { name: 'tools', items: ['Maximize'] },
            { name: 'document', items: ['Source'] }
        ],
        // Remove image upload for security (use your file upload fields instead)
        removeButtons: 'Image',
        // Set height
        height: 300
    });
</script>
@endsection