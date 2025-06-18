<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container py-4">
    <h1 class="mb-4 fw-bold">Explore breeds</h1>

    <!-- Cuddly companions -->
    <div class="breed-section mb-5">
        <h3 class="mb-2 fw-semibold">Cuddly companions</h3>
        <p class="text-muted mb-4">These fluffy, soft and oh-so-lovable breeds make for ideal best friends.</p>
        
        <div class="position-relative">
            <div class="scroll-slider d-flex flex-nowrap overflow-auto pb-4 pe-2">
                @foreach (\App\Helpers\Helpers::getFilteredParents('cuddly') as $parent)
                <div class="card me-4 flex-shrink-0 border-0 shadow-sm hover-card" style="width: 32%; min-width: 280px;">
                    <a href="{{ route('parents.puppies', $parent->id) }}" class="text-decoration-none text-dark">
                        <div class="position-relative overflow-hidden rounded-top">
                            @if ($parent->cover_image)
                                <img src="{{ asset('cover_image/' . $parent->cover_image) }}" class="card-img-top hover-zoom" alt="{{ $parent->name }}" style="height: 350px; object-fit: cover;">
                            @else
                                <img src="https://via.placeholder.com/300x350?text=No+Image" class="card-img-top hover-zoom" alt="No image available" style="height: 350px; object-fit: cover;">
                            @endif
                            <div class="hover-overlay"></div>
                        </div>
                        <div class="card-body text-center py-3">
                            <h5 class="card-title mb-0 fw-medium">{{ $parent->name }}</h5>
                            <div class="mt-2">
                                <span class="badge bg-primary bg-opacity-10 text-primary"></span>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Good with families -->
    <div class="breed-section mb-5">
        <h3 class="mb-2 fw-semibold">Good with families</h3>
        <p class="text-muted mb-4">These dogs have the potential to be wonderful companions for your whole family.</p>
        
        <div class="position-relative">
            <div class="scroll-slider d-flex flex-nowrap overflow-auto pb-4 pe-2">
                @foreach (\App\Helpers\Helpers::getFilteredParents('family') as $parent)
                <div class="card me-4 flex-shrink-0 border-0 shadow-sm hover-card" style="width: 32%; min-width: 280px;">
                    <a href="{{ route('parents.puppies', $parent->id) }}" class="text-decoration-none text-dark">
                        <div class="position-relative overflow-hidden rounded-top">
                            @if ($parent->cover_image)
                                <img src="{{ asset('cover_image/' . $parent->cover_image) }}" class="card-img-top hover-zoom" alt="{{ $parent->name }}" style="height: 350px; object-fit: cover;">
                            @else
                                <img src="https://via.placeholder.com/300x350?text=No+Image" class="card-img-top hover-zoom" alt="No image available" style="height: 350px; object-fit: cover;">
                            @endif
                            <div class="hover-overlay"></div>
                        </div>
                        <div class="card-body text-center py-3">
                            <h5 class="card-title mb-0 fw-medium">{{ $parent->name }}</h5>
                            <div class="mt-2">
                                <span class="badge bg-primary bg-opacity-10 text-primary"></span>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Great for allergy sufferers -->
    <div class="breed-section mb-5">
        <h3 class="mb-2 fw-semibold">Great for allergy sufferers</h3>
        <p class="text-muted mb-4">These breeds are known to be better choices for people with allergies.</p>
        
        <div class="position-relative">
            <div class="scroll-slider d-flex flex-nowrap overflow-auto pb-4 pe-2">
                @foreach (\App\Helpers\Helpers::getFilteredParents('allergy') as $parent)
                <div class="card me-4 flex-shrink-0 border-0 shadow-sm hover-card" style="width: 32%; min-width: 280px;">
                    <a href="{{ route('parents.puppies', $parent->id) }}" class="text-decoration-none text-dark">
                        <div class="position-relative overflow-hidden rounded-top">
                            @if ($parent->cover_image)
                                <img src="{{ asset('cover_image/' . $parent->cover_image) }}" class="card-img-top hover-zoom" alt="{{ $parent->name }}" style="height: 350px; object-fit: cover;">
                            @else
                                <img src="https://via.placeholder.com/300x350?text=No+Image" class="card-img-top hover-zoom" alt="No image available" style="height: 350px; object-fit: cover;">
                            @endif
                            <div class="hover-overlay"></div>
                        </div>
                        <div class="card-body text-center py-3">
                            <h5 class="card-title mb-0 fw-medium">{{ $parent->name }}</h5>
                            <div class="mt-2">
                                <span class="badge bg-primary bg-opacity-10 text-primary"></span>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<style>
    /* Custom scrollbar styling */
    .scroll-slider {
        -ms-overflow-style: none; /* IE and Edge */
        scrollbar-width: none;    /* Firefox */
        scroll-behavior: smooth;
    }
    .scroll-slider::-webkit-scrollbar {
        height: 6px;
    }
    .scroll-slider::-webkit-scrollbar-track {
        background: #f8f9fa;
        border-radius: 10px;
    }
    .scroll-slider::-webkit-scrollbar-thumb {
        background: rgba(0,0,0,0.2);
        border-radius: 10px;
    }
    .scroll-slider::-webkit-scrollbar-thumb:hover {
        background: rgba(0,0,0,0.3);
    }
    
    /* Card hover effects */
    .hover-card {
        transition: all 0.3s ease;
        border-radius: 12px !important;
    }
    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    
    /* Image zoom effect */
    .hover-zoom {
        transition: transform 0.5s ease;
    }
    .hover-card:hover .hover-zoom {
        transform: scale(1.05);
    }
    
    /* Overlay effect */
    .hover-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0);
        transition: background 0.3s ease;
    }
    .hover-card:hover .hover-overlay {
        background: rgba(0,0,0,0.03);
    }
    
    /* Responsive adjustments */
    @media (max-width: 992px) {
        .scroll-slider .card {
            width: 48% !important;
            min-width: 240px !important;
        }
    }
    
    @media (max-width: 768px) {
        .scroll-slider .card {
            min-width: 220px !important;
        }
    }
    
    @media (max-width: 576px) {
        .scroll-slider .card {
            width: 85% !important;
            min-width: 85% !important;
        }
        .card-img-top {
            height: 300px !important;
        }
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>