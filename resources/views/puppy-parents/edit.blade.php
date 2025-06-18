@extends('layouts.admin')

@section('admin')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Edit Parent - {{ $parent->name }}</h3>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card-body">
            <form action="{{ route('puppy-parents.update', ['puppy' => $puppy, 'parent' => $parent]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="name" class="form-label">Name *</label>
                            <input type="text" name="name" id="name" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name', $parent->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="gender" class="form-label">Gender *</label>
                            <select name="gender" id="gender" 
                                    class="form-control @error('gender') is-invalid @enderror" required>
                                <option value="">Select Gender</option>
                                <option value="male" {{ old('gender', $parent->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old('gender', $parent->gender) == 'female' ? 'selected' : '' }}>Female</option>
                            </select>
                            @error('gender')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="breed" class="form-label">Parent Type *</label>
                            <select name="breed" id="breed" 
                                    class="form-control @error('breed') is-invalid @enderror" required>
                                <option value="">Select Parent Type</option>
                                <option value="Mom" {{ old('breed', $parent->breed) == 'Mom' ? 'selected' : '' }}>Mom</option>
                                <option value="Dad" {{ old('breed', $parent->breed) == 'Dad' ? 'selected' : '' }}>Dad</option>
                            </select>
                            @error('breed')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="registration_number" class="form-label">Registration Number</label>
                            <input type="text" name="registration_number" id="registration_number" 
                                   class="form-control @error('registration_number') is-invalid @enderror" 
                                   value="{{ old('registration_number', $parent->registration_number) }}">
                            @error('registration_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-12">
                        <div class="form-group mb-3">
                            <label for="image" class="form-label">Image</label>
                            
                            @if($parent->image)
                                <div class="mb-3">
                                    <img src="{{ asset($parent->image) }}" alt="{{ $parent->name }}" 
                                         class="img-thumbnail" style="max-width: 200px;">
                                    <div class="form-check mt-2">
                                        <input class="form-check-input" type="checkbox" 
                                               name="remove_image" id="remove_image" value="1">
                                        <label class="form-check-label" for="remove_image">
                                            Remove current image
                                        </label>
                                    </div>
                                </div>
                            @endif
                            
                            <input type="file" name="image" id="image" 
                                   class="form-control @error('image') is-invalid @enderror">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="form-group mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Parent
                    </button>
                    <a href="{{ route('puppy-parents.index', $puppy) }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection