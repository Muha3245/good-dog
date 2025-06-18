@extends('layouts.admin')

@section('admin')
<div class="container">
    <h1>Create New Parent</h1>
    
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

    <form action="{{ route('parents.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                   name="name" value="{{ old('name') }}" required>
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
        </div>

        <!-- Boolean Fields with Default Unchecked State -->
        <div class="mb-3 form-check">
            <input type="hidden" name="is_cuddly_champion" value="0">
            <input type="checkbox" class="form-check-input @error('is_cuddly_champion') is-invalid @enderror" 
                   id="is_cuddly_champion" name="is_cuddly_champion" value="1"
                   {{ old('is_cuddly_champion') ? 'checked' : '' }}>
            <label class="form-check-label">Cuddly Champion</label>
            @error('is_cuddly_champion')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="mb-3 form-check">
            <input type="hidden" name="is_good_with_families" value="0">
            <input type="checkbox" class="form-check-input @error('is_good_with_families') is-invalid @enderror" 
                   id="is_good_with_families" name="is_good_with_families" value="1"
                   {{ old('is_good_with_families') ? 'checked' : '' }}>
            <label class="form-check-label">Good with Families</label>
            @error('is_good_with_families')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="mb-3 form-check">
            <input type="hidden" name="is_great_for_allergy_sufferers" value="0">
            <input type="checkbox" class="form-check-input @error('is_great_for_allergy_sufferers') is-invalid @enderror" 
                   id="is_great_for_allergy_sufferers" name="is_great_for_allergy_sufferers" value="1"
                   {{ old('is_great_for_allergy_sufferers') ? 'checked' : '' }}>
            <label class="form-check-label">Great for Allergy Sufferers</label>
            @error('is_great_for_allergy_sufferers')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Create</button>
        <a href="{{ route('parents.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection