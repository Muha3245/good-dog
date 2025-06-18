@extends('layouts.admin')

@section('admin')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Sibling Details: {{ $sibling->name }}</h1>
        <a href="{{ route('puppies.siblings.index', $puppy->id) }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Siblings
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <img src="{{ asset($sibling->main_image) }}" alt="{{ $sibling->name }}" class="img-fluid rounded">
                </div>
                <div class="col-md-8">
                    <h3>{{ $sibling->name }}</h3>
                    <p><strong>Breed:</strong> {{ $sibling->breed }}</p>
                    <p><strong>Gender:</strong> {{ ucfirst($sibling->gender) }}</p>
                    <p><strong>Birth Date:</strong> {{ $sibling->birth_date ? $sibling->birth_date->format('d-m-Y') : 'N/A' }}</p>
                    <p><strong>Color:</strong> {{ $sibling->color ?? 'N/A' }}</p>
                    <p><strong>Price:</strong> ${{ number_format($sibling->price, 2) }}</p>
                    <p><strong>Status:</strong> 
                        <span class="badge 
                            @if($sibling->status == 'available') bg-success
                            @elseif($sibling->status == 'reserved') bg-warning text-dark
                            @else bg-secondary @endif">
                            {{ ucfirst($sibling->status) }}
                        </span>
                    </p>
                    <p><strong>Description:</strong> {!! $sibling->description ?? 'No description provided.' !!}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection