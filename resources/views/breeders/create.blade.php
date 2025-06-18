@extends('layouts.admin')

@section('admin')
<div class="container">
    <h1 class="mb-4">Create New Breeder</h1>

    <form action="{{ route('breeders.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="kennel_name" class="form-label">Kennel Name *</label>
                    <input type="text" class="form-control" id="kennel_name" name="kennel_name" required>
                </div>

                <div class="mb-3">
                    <label for="user_id" class="form-label">Breeder Account *</label>
                    <select class="form-select" id="user_id" name="user_id" required>
                        <option value="">Select User</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="about" class="form-label">About</label>
                    <textarea class="form-control" id="about" name="about" rows="3"></textarea>
                </div>

                <div class="mb-3">
                    <label for="website" class="form-label">Website</label>
                    <input type="url" class="form-control" id="website" name="website">
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label for="address" class="form-label">Address *</label>
                    <input type="text" class="form-control" id="address" name="address" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="city" class="form-label">City *</label>
                        <input type="text" class="form-control" id="city" name="city" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="state" class="form-label">State *</label>
                        <input type="text" class="form-control" id="state" name="state" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="zip_code" class="form-label">Zip Code *</label>
                        <input type="text" class="form-control" id="zip_code" name="zip_code" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="categories" class="form-label">Categories</label>
                    <select class="form-select" id="categories" name="categories[]" multiple>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="profile_image" class="form-label">Profile Image</label>
                    <input type="file" class="form-control" id="profile_image" name="profile_image">
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Create Breeder</button>
        <a href="{{ route('breeders.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection