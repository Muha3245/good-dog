@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <img src="{{ asset('storage/'.$dogShelter->cover_image) }}" alt="Cover" class="img-fluid rounded">
                </div>
                <div class="col-md-6">
                    <h1>{{ $dogShelter->name }}</h1>
                    <p class="text-muted"><i class="fas fa-map-marker-alt"></i> {{ $dogShelter->location }}</p>
                    <p class="text-muted">
                        Status: 
                        <span class="badge bg-{{ $dogShelter->is_active ? 'success' : 'secondary' }}">
                            {{ $dogShelter->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h3>Media</h3>
        </div>
        <div class="card-body">
            @if($dogShelter->file_type === 'video')
                <div class="ratio ratio-16x9">
                    <video controls>
                        <source src="{{ asset('storage/'.$dogShelter->file_path) }}" type="video/mp4">
                    </video>
                </div>
            @else
                <img src="{{ asset('storage/'.$dogShelter->file_path) }}" alt="Media" class="img-fluid rounded">
            @endif
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3>Description</h3>
        </div>
        <div class="card-body">
            {!! $dogShelter->description !!}
        </div>
    </div>
</div>
@endsection