@extends('layouts.admin')

@section('admin')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-6">
            <h1>Category Details</h1>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('breeder-categories.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    @if($breederCategory->image)
                        <img src="{{ asset('image/'.$breederCategory->image) }}" alt="{{ $breederCategory->name }}" class="img-fluid rounded mb-3">
                    @else
                        <div class="bg-light p-5 text-center text-muted rounded mb-3">
                            No Image Available
                        </div>
                    @endif
                </div>
                <div class="col-md-8">
                    <h2>{{ $breederCategory->name }}</h2>
                    <p class="text-muted">{{ $breederCategory->slug }}</p>
                    
                    <div class="d-flex mb-3">
                        <span class="badge bg-{{ $breederCategory->is_active ? 'success' : 'secondary' }} me-2">
                            {{ $breederCategory->is_active ? 'Active' : 'Inactive' }}
                        </span>
                        <span class="badge bg-info">
                            Order: {{ $breederCategory->order }}
                        </span>
                    </div>

                    @if($breederCategory->description)
                        <div class="mb-4">
                            <h5>Description</h5>
                            <p>{{ $breederCategory->description }}</p>
                        </div>
                    @endif

                    <div class="d-flex justify-content-end mt-4">
                        <button class="btn btn-outline-primary me-2" data-bs-toggle="modal" data-bs-target="#editCategoryModal{{ $breederCategory->id }}">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <form action="{{ route('breeder-categories.destroy', $breederCategory->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Are you sure you want to delete this category?')">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
@include('category.edit-modal', ['category' => $breederCategory])

@endsection