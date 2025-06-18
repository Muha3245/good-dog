@extends('layouts.admin')

@section('admin')
    <div class="container">
        <h1>Puppy Parents</h1>
        
        <div class="mb-4">
            <a href="{{ route('puppies.index', $puppy) }}" class="btn btn-secondary">Back to Puppy</a>
            <a href="{{ route('puppy-parents.create', $puppy) }}" class="btn btn-primary">Add Parent</a>
        </div>

        @if($parents->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Gender</th>
                            <th>Breed</th>
                            <th>Registration Number</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($parents as $parent)
                            <tr>
                                <td><img src="{{asset($parent->image)}}" alt="" style="width:100px; height:100px;"></td>
                                <td>{{ $parent->name }}</td>
                                <td>{{ ucfirst($parent->gender) }}</td>
                                <td>{{ $parent->breed }}</td>
                                <td>{{ $parent->registration_number ?? 'N/A' }}</td>
                                <td>
                                    <a href="{{ route('puppy-parents.edit', ['puppy' => $puppy, 'parent' => $parent]) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('puppy-parents.destroy', ['puppy' => $puppy, 'parent' => $parent]) }}" method="POST" class="d-inline">
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
            
            {{ $parents->links() }}
        @else
            <div class="alert alert-info">No parents found for this puppy.</div>
        @endif
    </div>
@endsection