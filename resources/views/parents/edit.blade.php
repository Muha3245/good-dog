@extends('layouts.admin')

@section('admin')
<div class="container">
    <h1>Edit Parent</h1>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('parents.update', $parent->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                   name="name" value="{{ old('name', $parent->name) }}" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Cover Image</label>
            <input type="file" class="form-control @error('cover_image') is-invalid @enderror" 
                   name="cover_image">
            @error('cover_image')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            
            @if($parent->cover_image)
                <div class="mt-2">
                    <img src="{{ asset('cover_image/' . $parent->cover_image) }}" width="150" class="img-thumbnail">
                    <p class="text-muted">Current Image</p>
                </div>
            @endif
        </div>

        <div class="mb-3 form-check">
            <input type="hidden" name="is_cuddly_champion" value="0">
            <input type="checkbox" class="form-check-input" 
                   name="is_cuddly_champion" value="1"
                   @checked(old('is_cuddly_champion', $parent->is_cuddly_champion))>
            <label class="form-check-label">Cuddly Champion</label>
        </div>
        
        <div class="mb-3 form-check">
            <input type="hidden" name="is_good_with_families" value="0">
            <input type="checkbox" class="form-check-input" 
                   name="is_good_with_families" value="1"
                   @checked(old('is_good_with_families', $parent->is_good_with_families))>
            <label class="form-check-label">Good with Families</label>
        </div>
        
        <div class="mb-3 form-check">
            <input type="hidden" name="is_great_for_allergy_sufferers" value="0">
            <input type="checkbox" class="form-check-input" 
                   name="is_great_for_allergy_sufferers" value="1"
                   @checked(old('is_great_for_allergy_sufferers', $parent->is_great_for_allergy_sufferers))>
            <label class="form-check-label">Great for Allergy Sufferers</label>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('parents.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection