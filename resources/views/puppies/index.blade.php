@extends('layouts.admin')

@section('admin')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Puppies List</h1>
        <a href="{{ route('puppies.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add New Puppy
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Breed</th>
                    <th>Gender</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($puppies as $puppy)
                <tr>
                    <td>
                        <img src="{{ asset($puppy->main_image) }}" alt="{{ $puppy->name }}" 
                             class="img-thumbnail" style="width: 80px; height: 80px; object-fit: cover;">
                    </td>
                    <td>{{ $puppy->name }}</td>
                    <td>{{ $puppy->breed }}</td>
                    <td>{{ ucfirst($puppy->gender) }}</td>
                    <td>${{ number_format($puppy->price, 2) }}</td>
                    <td>
                        <span class="badge 
                            @if($puppy->status == 'available') bg-success
                            @elseif($puppy->status == 'reserved') bg-warning text-dark
                            @else bg-secondary @endif">
                            {{ ucfirst($puppy->status) }}
                        </span>
                    </td>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="{{ route('puppies.show', $puppy->id) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('puppies.edit', $puppy->id) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="{{ route('puppies.siblings.index', $puppy->id) }}" class="btn btn-sm btn-secondary">
                                <i class="fas fa-users"></i> Siblings
                            </a>
                            <a href="{{ route('puppy-parents.index', $puppy->id) }}" class="btn btn-sm btn-secondary">
                                <i class="fas fa-users"></i> Parents
                            </a>
                            <form action="{{ route('puppies.destroy', $puppy->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" 
                                    onclick="return confirm('Are you sure?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">No puppies found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center">
        {{ $puppies->links() }}
    </div>
</div>
@endsection

@push('styles')
<style>
    .img-thumbnail {
        object-fit: cover;
    }
</style>
@endpush