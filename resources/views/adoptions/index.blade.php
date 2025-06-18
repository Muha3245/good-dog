@extends('layouts.admin')
@section('admin')
<div class="container py-4">
    <h1 class="page-title">Adoption Requests</h1>
    
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Puppy</th>
                            <th>User</th>
                            <th>Breeder</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($adoptions as $adoption)
                        <tr>
                            <td>
                                <a href="{{ route('puppiesprofile.show', $adoption->puppy_id) }}">
                                    {{ $adoption->puppy->name }}
                                </a>
                            </td>
                            <td>{{ $adoption->user->name }}</td>
                            <td>{{ $adoption->breeder->name }}</td>
                            <td>
                                <span class="status-badge {{ $adoption->status }}">
                                    {{ ucfirst($adoption->status) }}
                                </span>
                            </td>
                            <td>{{ $adoption->created_at->format('M d, Y') }}</td>
                            <td>
                                <a href="{{ route('adoptions.show', $adoption) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @can('delete', $adoption)
                                <form action="{{ route('adoptions.destroy', $adoption) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                @endcan
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">No adoption requests found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($adoptions->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $adoptions->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

<style>
    .status-badge {
        display: inline-block;
        padding: 0.35rem 0.75rem;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: capitalize;
    }
    .status-badge.pending { background-color: #e2e8f0; color: #4a5568; }
    .status-badge.approved { background-color: #48bb78; color: white; }
    .status-badge.rejected { background-color: #e53e3e; color: white; }
    .status-badge.completed { background-color: #805ad5; color: white; }
</style>

@endsection