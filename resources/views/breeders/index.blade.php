@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Breeders</h1>
    
    <div class="mb-4">
        <a href="{{ route('breeders.create') }}" class="btn btn-primary">Add New Breeder</a>
    </div>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Kennel Name</th>
                    <th>Location</th>
                    <th>Categories</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($breeders as $breeder)
                <tr>
                    <td>{{ $breeder->kennel_name }}</td>
                    <td>{{ $breeder->city }}, {{ $breeder->state }}</td>
                    <td>
                        @foreach($breeder->categories as $category)
                            <span class="badge bg-secondary">{{ $category->name }}</span>
                        @endforeach
                    </td>
                    <td>
                        <a href="{{ route('breeders.show', $breeder) }}" class="btn btn-sm btn-info">View</a>
                        <a href="{{ route('breeders.edit', $breeder) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('breeders.destroy', $breeder) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $breeders->links() }}
</div>
@endsection