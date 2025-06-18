<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adoption Request #{{ $adoption->id }} | Good Dog</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #5a67d8;
            --secondary-color: #f7fafc;
            --accent-color: #f56565;
            --text-dark: #2d3748;
            --text-medium: #4a5568;
            --border-color: #e2e8f0;
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.08);
            --rounded-md: 0.5rem;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--secondary-color);
            color: var(--text-medium);
        }
        
        .adoption-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, #7f9cf5 100%);
            color: white;
            padding: 2rem 0;
            border-radius: var(--rounded-md) var(--rounded-md) 0 0;
        }
        
        .status-badge {
            display: inline-block;
            padding: 0.35rem 1rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.85rem;
        }
        
        .status-pending {
            background-color: #e2e8f0;
            color: #4a5568;
        }
        
        .status-approved {
            background-color: #48bb78;
            color: white;
        }
        
        .status-rejected {
            background-color: #f56565;
            color: white;
        }
        
        .detail-card {
            background-color: white;
            border-radius: var(--rounded-md);
            padding: 1.5rem;
            box-shadow: var(--shadow-sm);
            margin-bottom: 1.5rem;
        }
        
        .detail-card h5 {
            color: var(--primary-color);
            border-bottom: 2px solid var(--border-color);
            padding-bottom: 0.75rem;
            margin-bottom: 1.25rem;
        }
        
        .detail-item {
            display: flex;
            justify-content: space-between;
            padding: 0.75rem 0;
            border-bottom: 1px dashed var(--border-color);
        }
        
        .detail-item:last-child {
            border-bottom: none;
        }
        
        .detail-label {
            font-weight: 600;
            color: var(--text-dark);
        }
        
        .user-card {
            display: flex;
            align-items: center;
            padding: 1rem;
            background-color: white;
            border-radius: var(--rounded-md);
            box-shadow: var(--shadow-sm);
            margin-bottom: 1.5rem;
        }
        
        .user-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid var(--primary-color);
            margin-right: 1.5rem;
        }
        
        .puppy-image {
            width: 100%;
            height: 250px;
            object-fit: cover;
            border-radius: var(--rounded-md);
            margin-bottom: 1.5rem;
            box-shadow: var(--shadow-sm);
        }
        
        .action-buttons {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }
        
        @media (max-width: 768px) {
            .user-card {
                flex-direction: column;
                text-align: center;
            }
            
            .user-avatar {
                margin-right: 0;
                margin-bottom: 1rem;
            }
            
            .action-buttons {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card border-0 shadow-sm">
                    <!-- Header with status -->
                    <div class="adoption-header text-center">
                        <h2 class="mb-3">
                            <i class="fas fa-paw me-2"></i> Adoption Request #{{ $adoption->id }}
                        </h2>
                        <span class="status-badge status-{{ $adoption->status }}">
                            {{ ucfirst($adoption->status) }}
                        </span>
                        @if($adoption->status == 'rejected' && $adoption->rejection_reason)
                            <p class="mt-2 mb-0">
                                <strong>Reason:</strong> {{ $adoption->rejection_reason }}
                            </p>
                        @endif
                    </div>
                    
                    <div class="card-body p-4 p-lg-5">
                        <div class="row">
                            <!-- Left Column - Puppy Details -->
                            <div class="col-md-6">
                                <div class="detail-card">
                                    <h5><i class="fas fa-dog me-2"></i> Puppy Details</h5>
                                    <img src="{{ asset($adoption->puppy->main_image) }}" 
                                         alt="{{ $adoption->puppy->name }}" 
                                         class="puppy-image">
                                    
                                    <div class="detail-item">
                                        <span class="detail-label">Name:</span>
                                        <span>{{ $adoption->puppy->name }}</span>
                                    </div>
                                    <div class="detail-item">
                                        <span class="detail-label">Breed:</span>
                                        <span>{{ $adoption->puppy->breed }}</span>
                                    </div>
                                    <div class="detail-item">
                                        <span class="detail-label">Gender:</span>
                                        <span>{{ ucfirst($adoption->puppy->gender) }}</span>
                                    </div>
                                    <div class="detail-item">
                                        <span class="detail-label">Age:</span>
                                        <span>{{ $adoption->puppy->age }}</span>
                                    </div>
                                    <div class="detail-item">
                                        <span class="detail-label">Price:</span>
                                        <span>${{ number_format($adoption->puppy->price) }}</span>
                                    </div>
                                </div>
                                
                                <!-- Breeder Information -->
                                <div class="user-card">
                                    <img src="{{ asset($adoption->breeder->profile_image ?? 'https://ui-avatars.com/api/?name='.urlencode($adoption->breeder->name)) }}" 
                                         class="user-avatar" 
                                         alt="{{ $adoption->breeder->name }}">
                                    <div>
                                        <h4 class="mb-1">{{ $adoption->breeder->kennel_name }}</h4>
                                        <p class="mb-1"><i class="fas fa-map-marker-alt me-2"></i> {{ $adoption->breeder->location }}</p>
                                        <small class="text-muted"><i class="fas fa-user-tie me-1"></i> Breeder</small>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Right Column - Adoption Details -->
                            <div class="col-md-6">
                                <!-- Adopter Information -->
                                <div class="user-card">
                                    <img src="{{ asset($adoption->user->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($adoption->user->name)) }}" 
                                         class="user-avatar" 
                                         alt="{{ $adoption->user->name }}">
                                    <div>
                                        <h4 class="mb-1">{{ $adoption->user->name }}</h4>
                                        <p class="mb-1"><i class="fas fa-envelope me-2"></i> {{ $adoption->user->email }}</p>
                                        <p class="mb-1"><i class="fas fa-phone me-2"></i> {{ $adoption->contact_info }}</p>
                                        <small class="text-muted"><i class="fas fa-user me-1"></i> Adopter</small>
                                    </div>
                                </div>
                                
                                <!-- Adoption Details -->
                                <div class="detail-card">
                                    <h5><i class="fas fa-info-circle me-2"></i> Adoption Request</h5>
                                    <div class="detail-item">
                                        <span class="detail-label">Submitted:</span>
                                        <span>{{ $adoption->created_at->format('M j, Y \a\t g:i a') }}</span>
                                    </div>
                                    @if($adoption->status == 'approved')
                                    <div class="detail-item">
                                        <span class="detail-label">Approved On:</span>
                                        <span>{{ $adoption->updated_at->format('M j, Y \a\t g:i a') }}</span>
                                    </div>
                                    <div class="detail-item">
                                        <span class="detail-label">Adoption Date:</span>
                                        <span>{{ $adoption->adoption_date?->format('M j, Y') ?? 'To be scheduled' }}</span>
                                    </div>
                                    @endif
                                </div>
                                
                                <!-- Adopter's Message -->
                                <div class="detail-card">
                                    <h5><i class="fas fa-envelope me-2"></i> Message to Breeder</h5>
                                    <div class="bg-light p-3 rounded">
                                        {{ $adoption->message }}
                                    </div>
                                </div>
                                
                                <!-- Action Buttons (Conditional) -->
                                @can('update', $adoption)
                                <div class="action-buttons">
                                    @if($adoption->breeder_id == auth()->id() && $adoption->status == 'pending')
                                        <form method="POST" action="{{ route('adoptions.approve', $adoption) }}">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-lg w-100">
                                                <i class="fas fa-check me-2"></i> Approve Request
                                            </button>
                                        </form>
                                        <button type="button" class="btn btn-danger btn-lg w-100" 
                                                data-bs-toggle="modal" data-bs-target="#rejectModal">
                                            <i class="fas fa-times me-2"></i> Reject Request
                                        </button>
                                    @endif
                                    
                                    @if($adoption->user_id == auth()->id() && $adoption->status == 'pending')
                                        <a href="{{ route('adoptions.edit', $adoption) }}" class="btn btn-primary btn-lg">
                                            <i class="fas fa-edit me-2"></i> Edit Request
                                        </a>
                                    @endif
                                </div>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reject Modal -->
    <div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="rejectModalLabel">Reject Adoption Request</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('adoptions.reject', $adoption) }}">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="rejectionReason" class="form-label">Reason for Rejection</label>
                            <textarea class="form-control" id="rejectionReason" name="rejection_reason" rows="3" ></textarea>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>