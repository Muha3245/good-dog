@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>{{ $breeder->kennel_name }}</h1>
        <div>
            <a href="{{ route('breeders.edit', $breeder) }}" class="btn btn-warning">Edit</a>
            <form action="{{ route('breeders.destroy', $breeder) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            @if($breeder->profile_image)
                <img src="{{ asset('storage/' . $breeder->profile_image) }}" alt="Profile Image" class="img-fluid rounded mb-3">
            @endif
            
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Contact Information</h5>
                    <p class="card-text">
                        <strong>Breeder:</strong> {{ $breeder->user->name }}<br>
                        <strong>Email:</strong> {{ $breeder->user->email }}<br>
                        <strong>Phone:</strong> {{ $breeder->user->phone ?? 'N/A' }}<br>
                        <strong>Website:</strong> 
                        @if($breeder->website)
                            <a href="{{ $breeder->website }}" target="_blank">{{ $breeder->website }}</a>
                        @else
                            N/A
                        @endif
                    </p>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Location</h5>
                    <p class="card-text">
                        {{ $breeder->address }}<br>
                        {{ $breeder->city }}, {{ $breeder->state }} {{ $breeder->zip_code }}
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">About</h5>
                    <p class="card-text">{{ $breeder->about ?? 'No information provided.' }}</p>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Categories</h5>
                    <div class="d-flex flex-wrap gap-2">
                        @forelse($breeder->categories as $category)
                            <span class="badge bg-primary">{{ $category->name }}</span>
                        @empty
                            <p>No categories assigned.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title">Puppies</h5>
                        <a href="{{ route('puppies.create') }}?breeder_id={{ $breeder->id }}" class="btn btn-sm btn-success">Add Puppy</a>
                    </div>
                    
                    @if($breeder->puppies->count() > 0)
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Breed</th>
                                        <th>Gender</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($breeder->puppies as $puppy)
                                    <tr>
                                        <td>{{ $puppy->name }}</td>
                                        <td>{{ $puppy->breed }}</td>
                                        <td>{{ ucfirst($puppy->gender) }}</td>
                                        <td>
                                            <span class="badge @if($puppy->status == 'available') bg-success @elseif($puppy->status == 'reserved') bg-warning text-dark @else bg-secondary @endif">
                                                {{ ucfirst($puppy->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('puppies.show', $puppy) }}" class="btn btn-sm btn-info">View</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p>No puppies listed yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection