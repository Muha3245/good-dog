@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Dog Shelters</h1>
        <a href="{{ route('dog-shelters.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add New Shelter
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Location</th>
                            <th>Media Type</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($shelters as $shelter)
                        <tr>
                            <td>{{ $shelter->name }}</td>
                            <td>{{ $shelter->location }}</td>
                            <td>
                                <span class="badge bg-{{ $shelter->file_type === 'video' ? 'info' : 'success' }}">
                                    {{ ucfirst($shelter->file_type) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-{{ $shelter->is_active ? 'success' : 'secondary' }}">
                                    {{ $shelter->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('dog-shelters.show', $shelter->id) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('dog-shelters.edit', $shelter->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('dog-shelters.destroy', $shelter->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $shelters->links() }}
        </div>
    </div>
</div>
@endsection