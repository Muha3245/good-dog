@extends('layouts.admin')

@section('admin')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="page-header d-flex justify-content-between align-items-center">
                <h2 class="mb-0">
                    <i class="fas fa-paw me-2"></i> Adoption Requests
                </h2>
                <div class="status-badges">
                    <span class="badge bg-warning me-2">
                        <i class="fas fa-clock me-1"></i> Pending: {{ $counts['pending'] }}
                    </span>
                    <span class="badge bg-success me-2">
                        <i class="fas fa-check me-1"></i> Approved: {{ $counts['approved'] }}
                    </span>
                    <span class="badge bg-danger">
                        <i class="fas fa-times me-1"></i> Rejected: {{ $counts['rejected'] }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="80">Request #</th>
                            <th>Puppy</th>
                            <th>Adopter</th>
                            <th>Submitted</th>
                            <th>Status</th>
                            <th width="220">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($adoptions as $adoption)
                        <tr>
                            <td>#{{ $adoption->id }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset($adoption->puppy->main_image) }}" 
                                         alt="{{ $adoption->puppy->name }}" 
                                         class="rounded-circle me-3" 
                                         width="50" height="50">
                                    <div>
                                        <strong>{{ $adoption->puppy->name }}</strong>
                                        <div class="text-muted small">{{ $adoption->puppy->breed }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <a href="#" 
                                       data-bs-toggle="modal" 
                                       data-bs-target="#userDetailModal-{{ $adoption->user->id }}">
                                        <img src="{{ $adoption->user->avatar ? asset('storage/'.$adoption->user->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($adoption->user->name) }}" 
                                             class="rounded-circle me-3" 
                                             width="40" height="40">
                                    </a>
                                    <div>
                                        <a href="#" 
                                           data-bs-toggle="modal" 
                                           data-bs-target="#userDetailModal-{{ $adoption->user->id }}"
                                           class="text-decoration-none">
                                            <strong>{{ $adoption->user->name }}</strong>
                                        </a>
                                        <div class="text-muted small">
                                            <a href="#" 
                                               data-bs-toggle="modal" 
                                               data-bs-target="#userDetailModal-{{ $adoption->user->id }}"
                                               class="text-decoration-none">
                                                {{ $adoption->user->email }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $adoption->created_at->diffForHumans() }}</td>
                            <td>
                                @if($adoption->status == 'pending')
                                    <span class="badge bg-warning">Pending</span>
                                @elseif($adoption->status == 'approved')
                                    <span class="badge bg-success">Approved</span>
                                @else
                                    <span class="badge bg-danger">Rejected</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('adoptions.show', $adoption->id) }}" 
                                       class="btn btn-sm btn-outline-primary"
                                       title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    
                                    @if($adoption->status == 'pending')
                                        <form action="{{ route('adoptions.approve', $adoption->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success" title="Approve">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                        
                                        <button class="btn btn-sm btn-danger" 
                                                title="Reject"
                                                data-bs-toggle="modal" 
                                                data-bs-target="#rejectModal-{{ $adoption->id }}">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    @endif
                                    
                                    {{-- @if($adoption->status == 'approved')
                                        <a href="#" class="btn btn-sm btn-info" title="Message Adopter">
                                            <i class="fas fa-envelope"></i>
                                        </a>
                                    @endif --}}
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <div class="empty-state">
                                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                    <h4>No adoption requests yet</h4>
                                    <p class="text-muted">When you receive requests, they'll appear here.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($adoptions->hasPages())
            <div class="card-footer">
                {{ $adoptions->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Create modals for each user and adoption -->
@foreach($adoptions as $adoption)
<!-- Rejection Modal for each adoption -->
<div class="modal fade" id="rejectModal-{{ $adoption->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Reject Adoption Request #{{ $adoption->id }}</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('adoptions.reject', $adoption->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="rejectionReason-{{ $adoption->id }}" class="form-label">Reason for Rejection</label>
                        <textarea class="form-control" id="rejectionReason-{{ $adoption->id }}" 
                                  name="rejection_reason" rows="3" required></textarea>
                        <small class="text-muted">This will be shared with the adopter</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Confirm Rejection</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- User Detail Modal for each user -->
<div class="modal fade" id="userDetailModal-{{ $adoption->user->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Adopter Details</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4 text-center">
                        <img src="{{ $adoption->user->avatar ? asset('storage/'.$adoption->user->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($adoption->user->name) }}" 
                             class="rounded-circle mb-3" width="120" height="120">
                        <h4 class="mb-1">{{ $adoption->user->name }}</h4>
                        <p class="text-muted">{{ $adoption->user->email }}</p>
                    </div>
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Contact Information</h5>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span><i class="fas fa-phone me-2"></i> Phone</span>
                                        <span class="fw-bold">{{ $adoption->user->phone ?? 'Not provided' }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span><i class="fas fa-map-marker-alt me-2"></i> Address</span>
                                        <span class="fw-bold">{{ $adoption->user->address ?? 'Not provided' }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span><i class="fas fa-calendar-alt me-2"></i> Member Since</span>
                                        <span class="fw-bold">{{ $adoption->user->created_at->format('M d, Y') }}</span>
                                    </li>
                                    @if($adoption->user->phone_verified_at)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span><i class="fas fa-check-circle me-2 text-success"></i> Phone Verified</span>
                                        <span class="fw-bold">{{ $adoption->user->phone_verified_at->diffForHumans() }}</span>
                                    </li>
                                    @endif
                                    @if($adoption->user->email_verified_at)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span><i class="fas fa-check-circle me-2 text-success"></i> Email Verified</span>
                                        <span class="fw-bold">{{ $adoption->user->email_verified_at->diffForHumans() }}</span>
                                    </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <a href="mailto:{{ $adoption->user->email }}" class="btn btn-primary">
                    <i class="fas fa-envelope me-1"></i> Send Email
                </a>
            </div>
        </div>
    </div>
</div>
@endforeach

@endsection