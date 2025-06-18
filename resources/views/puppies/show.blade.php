@extends('layouts.admin')

@section('title', $puppy->name)
@section('admin')
<div class="container py-4">
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">{{ $puppy->name }}</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="mb-3 text-center">
                                <img src="{{ asset($puppy->main_image) }}" alt="{{ $puppy->name }}" 
                                     class="img-fluid rounded" style="max-height: 300px; width: auto;">
                            </div>
                            
                            <div class="d-flex justify-content-center gap-2 mb-3">
                                <span class="badge bg-info text-dark fs-6">
                                    <i class="fas fa-venus-mars"></i> {{ ucfirst($puppy->gender) }}
                                </span>
                                <span class="badge 
                                    @if($puppy->status == 'available') bg-success
                                    @elseif($puppy->status == 'reserved') bg-warning text-dark
                                    @else bg-secondary @endif fs-6">
                                    {{ ucfirst($puppy->status) }}
                                </span>
                            </div>
                            
                            <div class="text-center">
                                <h4 class="text-primary">${{ number_format($puppy->price, 2) }}</h4>
                            </div>
                        </div>
                        
                        <div class="col-md-7">
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <tbody>
                                        <tr>
                                            <th>Breed</th>
                                            <td>{{ $puppy->breed }}</td>
                                        </tr>
                                        <tr>
                                            <th>Color</th>
                                            <td>{{ $puppy->color ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Birth Date</th>
                                            <td>{{ $puppy->birth_date ? \Carbon\Carbon::parse($puppy->birth_date)->format('M d, Y') : 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Age</th>
                                            <td>
                                                @if($puppy->birth_date)
                                                    {{ \Carbon\Carbon::parse($puppy->birth_date)->diffForHumans(null, true) }} old
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Weight/Height</th>
                                            <td>
                                                @if($puppy->weight && $puppy->height)
                                                    {{ $puppy->weight }} kg / {{ $puppy->height }} cm
                                                @elseif($puppy->weight)
                                                    {{ $puppy->weight }} kg
                                                @elseif($puppy->height)
                                                    {{ $puppy->height }} cm
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Breeder</th>
                                            <td>
                                                <a href="#">{{ $puppy->breeder->name }}</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Category</th>
                                            <td>{{ $puppy->category->name }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-3">
                        <h5>Description</h5>
                        <p>{!! $puppy->description ?? 'No description provided.' !!}</p>
                    </div>
                </div>
            </div>
            
            <!-- Gallery Images -->
            @if($puppy->gallery && count(json_decode($puppy->gallery)) > 0)
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Gallery</h5>
                </div>
                <div class="card-body">
                    <div class="row g-2">
                        @foreach(json_decode($puppy->gallery) as $image)
                        <div class="col-6 col-md-4 col-lg-3">
                            <a href="{{ asset($image) }}" data-lightbox="gallery">
                                <img src="{{ asset($image) }}" class="img-thumbnail" 
                                     style="width: 100%; height: 150px; object-fit: cover;">
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
            
            <!-- Parents Information -->
            @if($puppy->parents && $puppy->parents->count() > 0)
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Parents</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($puppy->parents as $parent)
                        <div class="col-md-6">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="text-center mb-3">
                                        <img src="{{ asset($parent->image) }}" alt="{{ $parent->name }}" 
                                             class="img-fluid rounded" style="max-height: 150px; width: auto;">
                                    </div>
                                    <h6>{{ $parent->name }}</h6>
                                    <p class="mb-1">
                                        <span class="badge bg-info text-dark">
                                            {{ ucfirst($parent->gender) }}
                                        </span>
                                    </p>
                                    <!-- Add more parent details as needed -->
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>
        
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('puppies.edit', $puppy->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit Puppy
                        </a>
                        <form action="{{ route('puppies.destroy', $puppy->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" 
                                onclick="return confirm('Are you sure you want to delete this puppy?')">
                                <i class="fas fa-trash"></i> Delete Puppy
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Siblings -->
            @if($puppy->siblings && $puppy->siblings->count() > 0)
            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Siblings</h5>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        @foreach($puppy->siblings as $sibling)
                        <a href="{{ route('puppies.show', $sibling->id) }}" 
                           class="list-group-item list-group-item-action">
                            <div class="d-flex align-items-center">
                                <img src="{{ asset($sibling->main_image) }}" 
                                     class="rounded me-3" width="50" height="50" 
                                     style="object-fit: cover;">
                                <div>
                                    <h6 class="mb-0">{{ $sibling->name }}</h6>
                                    <small class="text-muted">{{ $sibling->breed }}</small>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <div class="mb-4">
                <h5>Siblings</h5>
                <ul>
                    @foreach($puppy->siblings as $sibling)
                        <li>{{ $sibling->name }} ({{ $sibling->breed }})</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">
<style>
    .badge {
        font-size: 0.9rem;
        padding: 0.5em 0.75em;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
@endpush