@extends('layouts.admin')

@section('admin')
<div class="container">
    <h1>Parent Details</h1>

    <div class="card">
        <div class="card-body">
            <div class="text-center mb-4">
                <img src="{{ $parent->cover_image_url }}" alt="Cover Image" class="img-fluid rounded" style="max-height: 300px;">
            </div>
            <h3 class="card-title">{{ $parent->name }}</h3>
            <p class="text-muted">Created: {{ $parent->created_at->format('M d, Y') }}</p>
            <p class="text-muted">Last Updated: {{ $parent->updated_at->format('M d, Y') }}</p>

            <div class="mt-4">
                <a href="{{ route('parents.edit', $parent->id) }}" class="btn btn-primary">Edit</a>
                <a href="{{ route('parents.index') }}" class="btn btn-secondary">Back</a>
            </div>
            <div class="mb-2">
                <strong>Cuddly Champion:</strong> {{ $parent->is_cuddly_champion ? 'Yes' : 'No' }}
            </div>
            <div class="mb-2">
                <strong>Good with Families:</strong> {{ $parent->is_good_with_families ? 'Yes' : 'No' }}
            </div>
            <div class="mb-2">
                <strong>Great for Allergy Sufferers:</strong> {{ $parent->is_great_for_allergy_sufferers ? 'Yes' : 'No' }}
            </div>
        </div>
    </div>
</div>
@endsection