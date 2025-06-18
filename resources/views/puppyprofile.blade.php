<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $puppy->name }} - Dave Poodles</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --primary: #c53030;
            --primary-light: rgba(197, 48, 48, 0.1);
            --secondary: #4b5563;
            --light: #f8f9fa;
            --dark: #212529;
            --rounded-sm: 8px;
            --rounded-md: 12px;
            --rounded-lg: 16px;
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.1);
            --shadow-md: 0 4px 6px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 15px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #eed493b1;
            color: var(--dark);
        }

        .card {
            border: none;
            border-radius: var(--rounded-lg);
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
            overflow: hidden;
            background-color: transparent
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }

        .img-cover {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .badge-primary {
            background-color: var(--primary-light);
            color: var(--primary);
        }

        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        .text-primary {
            color: var(--primary) !important;
        }

        .bg-primary-light {
            background-color: transparent;
        }

        .section-title {
            font-family: 'Playfair Display', serif;
            font-weight: 600;
            position: relative;
            padding-bottom: 10px;
        }

        .section-title:after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 50px;
            height: 3px;
            background: var(--primary);
        }

        .info-item {
            padding: 15px;
            border-radius: var(--rounded-sm);
            background: transparent;
            box-shadow: var(--shadow-sm);
            margin-bottom: 15px;
            border-left: 3px solid var(--primary);
            transition: var(--transition);
        }

        .info-item:hover {
            transform: translateX(5px);
        }

        .price-tag {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--primary);
        }

        .carousel-item img {
            height: 500px;
            object-fit: cover;
        }

        .gallery-thumbnail {
            transition: all 0.3s ease;
            border: 2px solid transparent;
            border-radius: 8px;
        }

        .gallery-thumbnail:hover,
        .gallery-thumbnail.active {
            border-color: #c53030;
            transform: scale(1.02);
        }

        .gallery-thumbnail img {
            cursor: pointer;
        }

        @media (max-width: 768px) {
            .carousel-item img {
                height: 350px;
            }
        }

        .sibling-card {
            width: 18rem;
            margin: 0 10px;
            flex-shrink: 0;
        }

        .siblings-container {
            display: flex;
            overflow-x: auto;
            padding: 20px 0;
            scroll-snap-type: x mandatory;
            gap: 15px;
        }

        .siblings-container::-webkit-scrollbar {
            height: 8px;
        }

        .siblings-container::-webkit-scrollbar-thumb {
            background: var(--primary);
            border-radius: 4px;
        }
    </style>
</head>

<body>
    @include('search')

    <div class="container py-5">
        <!-- Puppy Header Section -->
        <div class="row mb-5">
            <div class="col-md-6">
                <h1 class="mb-3">{{ $puppy->name }}</h1>
                <div class="d-flex align-items-center mb-4">
                    <span class="price-tag me-3">${{ number_format($puppy->price, 2) }}</span>
                    @auth
                        @php
                            $userAdoption = $puppy
                                ->adoptions()
                                ->where('user_id', auth()->id())
                                ->where('status', 'approved')
                                ->first();
                            $pendingAdoption = $puppy
                                ->adoptions()
                                ->where('user_id', auth()->id())
                                ->where('status', 'pending')
                                ->first();
                        @endphp
                        @if ($puppy->status === 'available' && !$userAdoption && !$pendingAdoption)
                            <a href="{{ route('adoptions.store', $puppy->id) }}" class="btn btn-primary btn-lg">
                                <i class="fas fa-heart me-2"></i> Adopt Now
                            </a>
                        @elseif($pendingAdoption)
                            <button class="btn btn-warning btn-lg" disabled>
                                <i class="fas fa-hourglass-half me-2"></i> Pending Approval
                            </button>
                        @elseif($userAdoption)
                            <button class="btn btn-success btn-lg" disabled>
                                <i class="fas fa-check-circle me-2"></i> Approved
                            </button>
                        @elseif($puppy->status === 'reserved')
                            <button class="btn btn-warning btn-lg" disabled>
                                <i class="fas fa-lock me-2"></i> Reserved
                            </button>
                        @elseif($puppy->status === 'sold')
                            <button class="btn btn-danger btn-lg" disabled>
                                <i class="fas fa-times-circle me-2"></i> Sold
                            </button>
                        @endif
                    @else
                        <a href="#" class="btn btn-primary btn-lg" data-bs-toggle="modal"
                            data-bs-target="#loginModal">
                            <i class="fas fa-sign-in-alt me-2"></i> Login to Adopt
                        </a>
                    @endauth
                </div>
                <div class="alert alert-primary bg-primary-light border-primary">
                    <i class="fas fa-info-circle me-2"></i>
                    {{ $puppy->short_description ?? 'Loving and playful companion' }}
                </div>
            </div>
            <div class="row">
                <!-- Main Carousel Column -->
                <div class="col-md-10">
                    <!-- Bootstrap Carousel -->
                    <div id="puppyCarousel" class="carousel slide rounded-3 overflow-hidden shadow-lg"
                        data-bs-ride="carousel">
                        <div class="carousel-indicators">
                            <button type="button" data-bs-target="#puppyCarousel" data-bs-slide-to="0"
                                class="active"></button>
                            @if ($puppy->gallery && count(json_decode($puppy->gallery)) > 0)
                                @foreach (range(1, count(json_decode($puppy->gallery))) as $index)
                                    <button type="button" data-bs-target="#puppyCarousel"
                                        data-bs-slide-to="{{ $index }}"></button>
                                @endforeach
                            @endif
                        </div>
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="{{ asset($puppy->main_image) }}" class="d-block w-100"
                                    alt="{{ $puppy->name }}" style="height: 500px; object-fit: cover;">
                            </div>
                            @if ($puppy->gallery && count(json_decode($puppy->gallery)) > 0)
                                @foreach (json_decode($puppy->gallery) as $image)
                                    <div class="carousel-item">
                                        <img src="{{ asset($image) }}" class="d-block w-100"
                                            alt="Gallery image of {{ $puppy->name }}"
                                            style="height: 500px; object-fit: cover;">
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#puppyCarousel"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#puppyCarousel"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>

                <!-- Gallery Thumbnails Column -->
                <div class="col-md-2">
                    <div class="d-flex flex-column h-100" style="gap: 10px;">
                        <!-- Main Image Thumbnail -->
                        <a href="#" class="gallery-thumbnail active" data-bs-target="#puppyCarousel"
                            data-bs-slide-to="0">
                            <img src="{{ asset($puppy->main_image) }}" class="img-fluid rounded" alt="Thumbnail"
                                style="height: 80px; width: 100%; object-fit: cover;">
                        </a>

                        <!-- Gallery Thumbnails -->
                        @if ($puppy->gallery && count(json_decode($puppy->gallery)) > 0)
                            @foreach (json_decode($puppy->gallery) as $index => $image)
                                <a href="#" class="gallery-thumbnail" data-bs-target="#puppyCarousel"
                                    data-bs-slide-to="{{ $index + 1 }}">
                                    <img src="{{ asset($image) }}" class="img-fluid rounded" alt="Thumbnail"
                                        style="height: 80px; width: 100%; object-fit: cover;">
                                </a>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>




        </div>

        <!-- Details Section -->
        <div class="card mb-5">
            <div class="card-body">
                <h2 class="section-title mb-4"><i class="fas fa-info-circle me-2"></i>Details</h2>
                <div class="row">
                    <div class="col-md-6">
                        <div class="info-item">
                            <i class="fas fa-dog text-primary me-2"></i>
                            <strong>Breed:</strong> {{ $puppy->breed }}
                        </div>
                        <div class="info-item">
                            <i class="fas fa-paint-brush text-primary me-2"></i>
                            <strong>Color:</strong> {{ $puppy->color ?? 'N/A' }}
                        </div>
                        <div class="info-item">
                            <i class="fas fa-venus-mars text-primary me-2"></i>
                            <strong>Gender:</strong> {{ $puppy->gender ?? 'N/A' }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-item">
                            <i class="fas fa-birthday-cake text-primary me-2"></i>
                            <strong>Birth Date:</strong>
                            {{ $puppy->birth_date ? \Carbon\Carbon::parse($puppy->birth_date)->format('F j, Y') : 'N/A' }}
                            @if ($puppy->birth_date)
                                <br><small>({{ \Carbon\Carbon::parse($puppy->birth_date)->diffForHumans(null, true) }}
                                    old)</small>
                            @endif
                        </div>
                        <div class="info-item">
                            <i class="fas fa-weight text-primary me-2"></i>
                            <strong>Weight:</strong> {{ $puppy->weight ?? 'N/A' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Description Section -->
        <div class="card mb-5">
            <div class="card-body">
                <h2 class="section-title mb-4"><i class="fas fa-align-left me-2"></i>About {{ $puppy->name }}</h2>
                @if ($puppy->description)
                    <div class="p-3 bg-light rounded">
                        {!! $puppy->description !!}
                    </div>
                @else
                    <div class="alert alert-warning">
                        <i class="fas fa-info-circle me-2"></i> No description provided for this puppy.
                    </div>
                @endif
            </div>
        </div>

        <!-- Parents Section -->
        <div class="card mb-5">
            <div class="card-body">
                <h2 class="section-title mb-4"><i class="fas fa-users me-2"></i>Parents</h2>
                <div class="row">
                    @foreach ($puppy->parents as $parent)
                        <div class="col-md-6 mb-4">
                            <div class="card h-100">
                                <div class="row g-0">
                                    <div class="col-md-5">
                                        <img src="{{ $parent->image ? asset($parent->image) : 'https://ui-avatars.com/api/?name=' . urlencode($parent->name) . '&background=random' }}"
                                            class="img-fluid rounded-start h-100" alt="{{ $parent->name }}">
                                    </div>
                                    <div class="col-md-7">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $parent->name }}</h5>
                                            <div class="mb-2">
                                                <span class="badge bg-primary">Parent</span>
                                                <span
                                                    class="badge bg-secondary ms-1">{{ $parent->gender == 'male' ? 'Father' : 'Mother' }}</span>
                                            </div>
                                            <ul class="list-unstyled">
                                                <li><i class="fas fa-dog text-primary me-2"></i>
                                                    <strong>Breed:</strong> {{ $parent->breed ?? 'N/A' }}
                                                </li>
                                                <li><i class="fas fa-paint-brush text-primary me-2"></i>
                                                    <strong>Color:</strong> {{ $parent->color ?? 'N/A' }}
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Siblings Section -->
        <div class="card mb-5">
            <div class="card-body">
                <h2 class="section-title mb-4"><i class="fas fa-paw me-2"></i>Siblings</h2>
                @if ($puppy->siblings && $puppy->siblings->count() > 0)
                    <div id="siblingsCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            @foreach ($puppy->siblings->chunk(3) as $chunk)
                                <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                    <div class="row g-4">
                                        @foreach ($chunk as $sibling)
                                            <div class="col-md-4">
                                                <div class="card h-100">
                                                    <img src="{{ asset($sibling->main_image) }}" class="card-img-top"
                                                        alt="{{ $sibling->name }}"
                                                        style="height: 200px; object-fit: cover;">
                                                    <div class="card-body">
                                                        <h5 class="card-title">{{ $sibling->name }}</h5>
                                                        <p class="card-text">{{ $sibling->breed }}</p>
                                                        <a href="{{ route('puppiesprofile.show', $sibling->id) }}"
                                                            class="btn btn-sm btn-primary">View Details</a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @if ($puppy->siblings->count() > 3)
                            <button class="carousel-control-prev" type="button" data-bs-target="#siblingsCarousel"
                                data-bs-slide="prev">
                                <span class="carousel-control-prev-icon bg-primary rounded-circle p-3"
                                    aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#siblingsCarousel"
                                data-bs-slide="next">
                                <span class="carousel-control-next-icon bg-primary rounded-circle p-3"
                                    aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        @endif
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-paw fa-3x text-muted mb-3"></i>
                        <p class="text-muted">No siblings available</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Breeder Section -->
        <div class="card">
            <div class="card-body">
                <h2 class="section-title mb-4"><i class="fas fa-home me-2"></i>Breeder Information</h2>
                <div class="row align-items-center">
                    <div class="col-md-3 text-center mb-3 mb-md-0">
                        <a href="/breederprofile/{{ $puppy->breeder->id }}">
                            <img src="{{ $puppy->breeder->profile_image ? asset($puppy->breeder->profile_image) : 'https://ui-avatars.com/api/?name=' . urlencode($puppy->breeder->name) . '&background=random' }}"
                                class="rounded-circle shadow" width="150" height="150"
                                style="object-fit: cover;" alt="{{ $puppy->breeder->name }}">
                        </a>
                    </div>
                    <div class="col-md-9">
                        <h3>{{ $puppy->breeder->name }}</h3>
                        <p class="text-muted mb-2">
                            <i class="fas fa-map-marker-alt text-danger me-1"></i>
                            {{ $puppy->breeder->city }}, {{ $puppy->breeder->state }}
                        </p>
                        <p>{{ $puppy->breeder->about ?? 'Professional breeder with years of experience.' }}</p>
                        <a href="/breederprofile/{{ $puppy->breeder->id }}" class="btn btn-outline-primary">View
                            Breeder Profile</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('footer')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Initialize carousel with auto-rotation
        document.addEventListener('DOMContentLoaded', function() {
            var puppyCarousel = new bootstrap.Carousel(document.getElementById('puppyCarousel'), {
                interval: 5000,
                ride: 'carousel'
            });
        });
    </script>
    <script>
        // Highlight active thumbnail when carousel slides
        document.addEventListener('DOMContentLoaded', function() {
            const carousel = document.getElementById('puppyCarousel');
            const thumbnails = document.querySelectorAll('.gallery-thumbnail');

            carousel.addEventListener('slid.bs.carousel', function(e) {
                // Remove active class from all thumbnails
                thumbnails.forEach(thumb => {
                    thumb.classList.remove('active');
                });

                // Add active class to corresponding thumbnail
                thumbnails[e.to].classList.add('active');
            });

            // Click handler for thumbnails
            thumbnails.forEach(thumb => {
                thumb.addEventListener('click', function(e) {
                    e.preventDefault();
                });
            });
        });
    </script>
</body>

</html>
