@extends('layouts.admin')

@section('admin')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Siblings of {{ $puppy->name }}</h1>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSiblingModal">
            <i class="fas fa-plus"></i> Add New Sibling
        </button>
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
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($siblings as $sibling)
                <tr>
                    <td>
                        <img src="{{ asset($sibling->main_image) }}" alt="{{ $sibling->name }}" 
                             class="img-thumbnail" style="width: 80px; height: 80px; object-fit: cover;">
                    </td>
                    <td>{{ $sibling->name }}</td>
                    <td>{{ $sibling->breed }}</td>
                    <td>{{ ucfirst($sibling->gender) }}</td>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="{{ route('siblings.edit', ['puppy' => $puppy->id, 'sibling' => $sibling->id]) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <a href="{{ route('siblings.show', ['puppy' => $puppy->id, 'sibling' => $sibling->id]) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-eye"></i> show
                            </a>
                            <form action="{{ route('siblings.destroy', ['puppy' => $puppy->id, 'sibling' => $sibling->id]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this sibling?')">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">No siblings found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Add Sibling Modal -->
<div class="modal fade" id="addSiblingModal" tabindex="-1" aria-labelledby="addSiblingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addSiblingModalLabel">Add New Sibling</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addSiblingForm" method="POST" action="{{ route('siblings.store', $puppy->id) }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name *</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">color *</label>
                                <input type="text" class="form-control" id="color" name="color" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">prise *</label>
                                <input type="text" class="form-control" id="price" name="price" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">prise *</label>
                                <input type="text" class="form-control" id="price" name="price" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="birth_date" class="form-label">Birth Date</label>
                                    <input type="date" class="form-control @error('birth_date') is-invalid @enderror" 
                                        id="birth_date" name="birth_date" value="{{ old('birth_date') }}">
                                    @error('birth_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="gender" class="form-label">Gender *</label>
                                <select class="form-select" id="gender" name="gender" required>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="breed" class="form-label">Breed *</label>
                                <select class="form-select" id="breed" name="breed" required>
                                    <option value="" disabled selected>Select Breed Type</option>
                                    <option value="pure_breed">Pure Breed</option>
                                    <option value="cross_breed">Cross Breed</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="main_image" class="form-label">Image *</label>
                                <input type="file" class="form-control" id="main_image" name="main_image" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Sibling</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection