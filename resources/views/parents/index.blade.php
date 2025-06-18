@extends('layouts.admin')

@section('admin')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Parents</h1>
            <a href="{{ route('parents.create') }}" class="btn btn-primary">Add New Parent</a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Cover Image</th>
                        <th>Name</th>
                        <th>Actions</th>
                        <th>Cuddly Champion</th>
                        <th>Good with Families</th>
                        <th>Great for Allergy</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($parents as $parent)
                        <tr>
                            <td>
                                @if($parent->cover_image)
                                    <img src="{{ asset('cover_image/' . $parent->cover_image) }}" alt="Cover Image" width="50" height="50" class="rounded">
                                @else
                                    <span class="text-muted">No image</span>
                                @endif
                            </td>
                            <td>{{ $parent->name }}</td>
                            <td>
                                <a href="{{ route('parents.show', $parent->id) }}" class="btn btn-sm btn-info">View</a>
                                <a href="{{ route('parents.edit', $parent->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                <form action="{{ route('parents.destroy', $parent->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                            <td>{{ $parent->is_cuddly_champion ? 'Yes' : 'No' }}</td>
                            <td>{{ $parent->is_good_with_families ? 'Yes' : 'No' }}</td>
                            <td>{{ $parent->is_great_for_allergy_sufferers ? 'Yes' : 'No' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{ $parents->links() }}
    </div>
@endsection
