<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $parent->name }} Puppies - Good Dog</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #5a67d8;
            --primary-light: #7f9cf5;
            --secondary-color: #f7fafc;
            --accent-color: #f56565;
            --text-dark: #2d3748;
            --text-medium: #4a5568;
            --text-light: #718096;
            --border-color: #e2e8f0;
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.08);
            --shadow-md: 0 4px 6px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 15px rgba(0, 0, 0, 0.1);
            --rounded-sm: 0.25rem;
            --rounded-md: 0.5rem;
            --rounded-lg: 1rem;
            --transition: all 0.3s ease;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--secondary-color);
            color: var(--text-medium);
            line-height: 1.6;
        }

        /* Navigation */
        .navbar {
            background-color: white;
            box-shadow: var(--shadow-sm);
            padding: 1rem 0;
        }

        .navbar-brand {
            font-weight: 700;
            color: var(--primary-color);
            font-size: 1.8rem;
            display: flex;
            align-items: center;
        }

        .navbar-brand i {
            margin-right: 0.5rem;
            font-size: 1.5rem;
        }

        .search-container {
            position: relative;
            width: 100%;
            max-width: 500px;
        }

        .search-input {
            background-color: var(--secondary-color);
            border: none;
            border-radius: 50px;
            padding: 0.75rem 1.5rem;
            width: 100%;
            font-size: 0.9rem;
            transition: var(--transition);
            padding-right: 3rem;
        }

        .search-input:focus {
            outline: none;
            box-shadow: 0 0 0 2px var(--primary-light);
        }

        .search-icon {
            position: absolute;
            right: 1.5rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-light);
        }

        .user-dropdown {
            position: relative;
        }

        .user-menu {
            display: flex;
            align-items: center;
            cursor: pointer;
            padding: 0.5rem 0.75rem;
            border-radius: var(--rounded-md);
            transition: var(--transition);
        }

        .user-menu:hover {
            background-color: var(--secondary-color);
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            margin-right: 0.75rem;
            object-fit: cover;
            border: 2px solid var(--border-color);
        }

        .dropdown-menu {
            position: absolute;
            right: 0;
            top: 100%;
            background: white;
            border-radius: var(--rounded-md);
            box-shadow: var(--shadow-lg);
            padding: 0.5rem 0;
            width: 220px;
            z-index: 1000;
            display: none;
        }

        .dropdown-menu.show {
            display: block;
        }

        .dropdown-item {
            display: block;
            padding: 0.5rem 1.5rem;
            color: var(--text-medium);
            text-decoration: none;
            transition: var(--transition);
            font-size: 0.9rem;
        }

        .dropdown-item:hover {
            background-color: var(--secondary-color);
            color: var(--primary-color);
        }

        .dropdown-divider {
            height: 1px;
            background-color: var(--border-color);
            margin: 0.5rem 0;
        }

        /* Main Content */
        .page-header {
            text-align: center;
            margin: 3rem 0;
        }

        .page-title {
            font-weight: 700;
            color: var(--text-dark);
            position: relative;
            display: inline-block;
            margin-bottom: 1rem;
        }

        .page-title:after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: var(--accent-color);
            border-radius: 2px;
        }

        .page-subtitle {
            color: var(--text-light);
            font-size: 1.1rem;
            max-width: 700px;
            margin: 0 auto;
        }

        /* Filter Section */
        .filter-section {
            background-color: white;
            border-radius: var(--rounded-lg);
            box-shadow: var(--shadow-sm);
            padding: 1.5rem;
            margin-bottom: 2.5rem;
        }

        .filter-title {
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--text-light);
            margin-bottom: 1rem;
            font-weight: 600;
        }

        .filter-group {
            margin-bottom: 1.5rem;
        }

        .filter-group-title {
            font-size: 0.95rem;
            font-weight: 600;
            margin-bottom: 0.75rem;
            color: var(--text-dark);
            display: flex;
            align-items: center;
        }

        .filter-options {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
        }

        .filter-option {
            position: relative;
        }

        .filter-option input {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
        }

        .filter-option label {
            display: inline-block;
            padding: 0.5rem 1rem;
            background-color: var(--secondary-color);
            border: 1px solid var(--border-color);
            border-radius: 50px;
            font-size: 0.85rem;
            cursor: pointer;
            transition: var(--transition);
        }

        .filter-option input:checked+label {
            background-color: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        .filter-actions {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            padding-top: 1rem;
            border-top: 1px solid var(--border-color);
            margin-top: 1rem;
        }

        /* Puppy Cards */
        .puppy-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }

        .puppy-card {
            background: white;
            border-radius: var(--rounded-lg);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .puppy-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }

        .puppy-media {
            position: relative;
            height: 280px;
            overflow: hidden;
        }

        .puppy-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: var(--transition);
        }

        .puppy-card:hover .puppy-image {
            transform: scale(1.05);
        }

        /* Status Badge */
        .status-badge {
            position: absolute;
            top: 1rem;
            right: 1rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50px;
            padding: 0.25rem 0.75rem;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: capitalize;
            z-index: 10;
        }

        .status-badge.available {
            background-color: #48bb78;
            color: white;
        }

        .status-badge.reserved {
            background-color: #ed8936;
            color: white;
        }

        .status-badge.sold {
            background-color: #e53e3e;
            color: white;
        }

        .puppy-gallery-controls {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 1rem;
            pointer-events: none;
        }

        .gallery-btn {
            pointer-events: auto;
            background-color: rgba(255, 255, 255, 0.8);
            border: none;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-dark);
            transition: var(--transition);
            box-shadow: var(--shadow-sm);
            z-index: 10;
        }

        .gallery-btn:hover {
            background-color: white;
            color: var(--primary-color);
        }

        /* Compact Puppy Info */
        .puppy-info-compact {
            padding: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid var(--border-color);
        }

        .puppy-meta-compact {
            display: flex;
            gap: 0.75rem;
            font-size: 0.85rem;
            color: var(--text-light);
        }

        .puppy-title-compact {
            font-size: 1rem;
            font-weight: 600;
            margin: 0;
            color: var(--text-dark);
        }

        .puppy-price-compact {
            font-size: 1rem;
            font-weight: 700;
            color: var(--primary-color);
            margin: 0;
        }

        /* Breeder Info */
        .breeder-info-compact {
            padding: 0.75rem 1rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .breeder-avatar-compact {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid white;
            box-shadow: var(--shadow-sm);
        }

        .breeder-name-compact {
            font-size: 0.85rem;
            font-weight: 600;
            margin: 0;
            color: var(--text-dark);
        }

        /* Puppy Actions */
        .puppy-actions-compact {
            display: flex;
            justify-content: space-between;
            padding: 0.75rem 1rem;
            gap: 0.75rem;
        }

        .btn-sm-compact {
            padding: 0.375rem 0.75rem;
            font-size: 0.85rem;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: #4c51bf;
            border-color: #4c51bf;
        }

        /* Search Dropdown */
        .search-dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            width: 100%;
            background: white;
            border-radius: 0 0 var(--rounded-md) var(--rounded-md);
            box-shadow: var(--shadow-lg);
            z-index: 1000;
            max-height: 400px;
            overflow-y: auto;
            display: none;
        }

        .search-dropdown.show {
            display: block;
        }

        .search-tabs {
            display: flex;
            border-bottom: 1px solid var(--border-color);
        }

        .tab-btn {
            flex: 1;
            padding: 0.75rem;
            border: none;
            background: none;
            cursor: pointer;
            font-weight: 500;
            color: var(--text-light);
            transition: var(--transition);
            font-size: 0.85rem;
            text-align: center;
        }

        .tab-btn.active {
            color: var(--primary-color);
            border-bottom: 2px solid var(--primary-color);
        }

        .search-results {
            padding: 0.5rem;
        }

        .puppy-result {
            display: flex;
            align-items: center;
            padding: 0.75rem;
            border-bottom: 1px solid var(--border-color);
            cursor: pointer;
            transition: var(--transition);
        }

        .puppy-result:hover {
            background-color: var(--secondary-color);
        }

        .puppy-result-image {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: var(--rounded-sm);
            margin-right: 1rem;
        }

        .puppy-result-info {
            flex: 1;
        }

        .puppy-result-name {
            font-size: 0.95rem;
            font-weight: 600;
            margin: 0;
            color: var(--text-dark);
        }

        .puppy-result-meta {
            font-size: 0.8rem;
            margin: 0.25rem 0 0;
            color: var(--text-light);
        }

        .no-results {
            padding: 2rem;
            text-align: center;
            color: var(--text-light);
            font-size: 0.9rem;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 3rem;
            background: white;
            border-radius: var(--rounded-lg);
            box-shadow: var(--shadow-sm);
            grid-column: 1 / -1;
        }

        .empty-state-icon {
            font-size: 3rem;
            color: var(--text-light);
            margin-bottom: 1.5rem;
        }

        .empty-state-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--text-dark);
        }

        .empty-state-text {
            color: var(--text-light);
            margin-bottom: 1.5rem;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
        }

        /* Responsive Adjustments */
        @media (max-width: 992px) {
            .puppy-grid {
                grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            }
        }

        @media (max-width: 768px) {
            .navbar-brand {
                font-size: 1.5rem;
            }

            .search-container {
                margin: 1rem 0;
                order: 3;
                width: 100%;
            }

            .filter-options {
                gap: 0.5rem;
            }

            .filter-option label {
                padding: 0.4rem 0.8rem;
            }
        }

        @media (max-width: 576px) {
            .puppy-media {
                height: 240px;
            }
        }
    </style>
</head>

<body>
    @include('search')

    <!-- Main Content -->
    <main class="container py-4">
        <!-- Page Header -->
        <section class="page-header">
            <h1 class="page-title">{{ $parent->name }}</h1>
            <p class="page-subtitle">Find your perfect companion from our selection of beautiful puppies</p>
        </section>

        <!-- Filter Section -->
        <section class="filter-section">
            <h2 class="filter-title">Filter Puppies</h2>
            <form id="filter-form" method="GET" action="{{ route('parents.puppies', $parent->id) }}">
                <div class="row">
                    <div class="col-md-3">
                        <div class="filter-group">
                            <h3 class="filter-group-title">
                                <i class="fas fa-venus-mars me-2"></i> Gender
                            </h3>
                            <div class="filter-options">
                                <div class="filter-option">
                                    <input type="checkbox" id="filter-male" name="gender[]" value="male"
                                        {{ in_array('male', request('gender', [])) ? 'checked' : '' }}>
                                    <label for="filter-male">Male</label>
                                </div>
                                <div class="filter-option">
                                    <input type="checkbox" id="filter-female" name="gender[]" value="female"
                                        {{ in_array('female', request('gender', [])) ? 'checked' : '' }}>
                                    <label for="filter-female">Female</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="filter-group">
                            <h3 class="filter-group-title">
                                <i class="fas fa-calendar-alt me-2"></i> Age
                            </h3>
                            <div class="filter-options">
                                <div class="filter-option">
                                    <input type="checkbox" id="filter-puppy" name="age[]" value="puppy"
                                        {{ in_array('puppy', request('age', [])) ? 'checked' : '' }}>
                                    <label for="filter-puppy">Puppy (0-12 mo)</label>
                                </div>
                                <div class="filter-option">
                                    <input type="checkbox" id="filter-young" name="age[]" value="young"
                                        {{ in_array('young', request('age', [])) ? 'checked' : '' }}>
                                    <label for="filter-young">Young (1-3 yrs)</label>
                                </div>
                                <div class="filter-option">
                                    <input type="checkbox" id="filter-adult" name="age[]" value="adult"
                                        {{ in_array('adult', request('age', [])) ? 'checked' : '' }}>
                                    <label for="filter-adult">Adult (3+ yrs)</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="filter-group">
                            <h3 class="filter-group-title">
                                <i class="fas fa-tag me-2"></i> Price Range
                            </h3>
                            <div class="filter-options">
                                <div class="filter-option">
                                    <input type="checkbox" id="filter-price1" name="price[]" value="0-500"
                                        {{ in_array('0-500', request('price', [])) ? 'checked' : '' }}>
                                    <label for="filter-price1">Under $500</label>
                                </div>
                                <div class="filter-option">
                                    <input type="checkbox" id="filter-price2" name="price[]" value="500-1000"
                                        {{ in_array('500-1000', request('price', [])) ? 'checked' : '' }}>
                                    <label for="filter-price2">$500-$1000</label>
                                </div>
                                <div class="filter-option">
                                    <input type="checkbox" id="filter-price3" name="price[]" value="1000-2000"
                                        {{ in_array('1000-2000', request('price', [])) ? 'checked' : '' }}>
                                    <label for="filter-price3">$1000-$2000</label>
                                </div>
                                <div class="filter-option">
                                    <input type="checkbox" id="filter-price4" name="price[]" value="2000+"
                                        {{ in_array('2000+', request('price', [])) ? 'checked' : '' }}>
                                    <label for="filter-price4">Over $2000</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="filter-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-filter me-2"></i> Apply Filters
                    </button>
                    <a href="{{ route('parents.puppies', $parent->id) }}" class="btn btn-outline-secondary">
                        <i class="fas fa-undo me-2"></i> Reset
                    </a>
                </div>
            </form>
        </section>

        <!-- Puppies Grid -->
        <section class="puppy-grid">
            @forelse($puppies as $puppy)
                <div class="puppy-card">
                    <!-- Media Carousel -->
                    <div class="puppy-media">
                        <div id="carousel-{{ $puppy->id }}" class="carousel slide h-100" data-bs-ride="carousel">
                            <div class="carousel-inner h-100">
                                <!-- Main Image -->
                                <div class="carousel-item active h-100">
                                    <img src="{{ asset($puppy->main_image) }}" class="puppy-image"
                                        alt="{{ $puppy->name }}">
                                </div>

                                <!-- Gallery Images -->
                                @if ($puppy->gallery)
                                    @foreach (json_decode($puppy->gallery) as $image)
                                        <div class="carousel-item h-100">
                                            <img src="{{ asset($image) }}" class="puppy-image" alt="Gallery image">
                                        </div>
                                    @endforeach
                                @endif
                            </div>

                            @if ($puppy->gallery && count(json_decode($puppy->gallery)) > 0)
                                <!-- Carousel Controls -->
                                <button class="carousel-control-prev" type="button"
                                    data-bs-target="#carousel-{{ $puppy->id }}" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button"
                                    data-bs-target="#carousel-{{ $puppy->id }}" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            @endif
                        </div>

                        <!-- Status Badge -->
                        <span class="status-badge {{ $puppy->status }}">{{ ucfirst($puppy->status) }}</span>


                    </div>

                    <!-- Compact Puppy Info -->
                    <div class="puppy-info-compact">
                        <div>
                            <h3 class="puppy-title-compact">{{ $puppy->name }}</h3>
                            <div class="puppy-meta-compact">
                                <span>{{ $puppy->age }}</span>
                                <span>{{ ucfirst($puppy->gender) }}</span>
                            </div>
                        </div>
                        <p class="puppy-price-compact">${{ number_format($puppy->price) }}</p>
                    </div>

                    <!-- Breeder Info -->
                    <a href="{{ route('breederprofile', $puppy->breeder->id) }}" class="text-decoration-none">
                        <div class="breeder-info-compact">
                            <img src="{{ asset($puppy->breeder->profile_image ?? 'https://ui-avatars.com/api/?name=' . urlencode($puppy->breeder->kennel_name)) }}"
                                class="breeder-avatar-compact" alt="{{ $puppy->breeder->kennel_name }}">
                            <h4 class="breeder-name-compact">{{ $puppy->breeder->kennel_name }}</h4>
                        </div>
                    </a>

                    <!-- Compact Puppy Actions -->
                    <div class="puppy-actions-compact">
                        <a href="{{ route('puppiesprofile.show', $puppy->id) }}"
                            class="btn btn-primary btn-sm-compact">
                            View Details
                        </a>

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

                            {{-- @if ($puppy->status === 'available' && !$userAdoption && !$pendingAdoption)
                                <form method="POST" action="{{ route('adoptions.store', $puppy->id) }}"
                                    class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm-compact">
                                        Adopt Now
                                    </button>
                                </form> --}}
                            @if ($puppy->status === 'available' && !$userAdoption && !$pendingAdoption)
                                <a href="{{ route('adoptions.questions', $puppy->id) }}"
                                    class="btn btn-success btn-sm-compact">
                                    Adopt Now
                                </a>
                            @elseif($pendingAdoption)
                                <button class="btn btn-warning btn-sm-compact" disabled>
                                    Pending
                                </button>
                            @elseif($userAdoption)
                                <button class="btn btn-warning btn-sm-compact" disabled>
                                    Reserved
                                </button>
                            @elseif($puppy->status === 'approved')
                                <button class="btn btn-warning btn-sm-compact" disabled>
                                    Reserved
                                </button>
                            @elseif($puppy->status === 'sold')
                                <button class="btn btn-danger btn-sm-compact" disabled>
                                    Sold
                                </button>
                            @endif
                        @else
                            <a href="#" class="btn btn-success btn-sm-compact" data-bs-toggle="modal"
                                data-bs-target="#loginModal">
                                Login
                            </a>
                        @endauth
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="fas fa-dog"></i>
                    </div>
                    <h3 class="empty-state-title">No Puppies Available</h3>
                    <p class="empty-state-text">
                        There are currently no puppies available in this category.
                        Please check back later or adjust your filters.
                    </p>
                    <a href="{{ route('parents.puppies', $parent->id) }}" class="btn btn-primary">
                        Reset Filters
                    </a>
                </div>
            @endforelse
        </section>

        <!-- Pagination -->
        @if ($puppies->hasPages())
            <nav aria-label="Page navigation" class="d-flex justify-content-center">
                {{ $puppies->withQueryString()->links() }}
            </nav>
        @endif
    </main>

    @include('footer')

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize all carousels
            document.querySelectorAll('.carousel').forEach(carousel => {
                new bootstrap.Carousel(carousel);
            });

            // Account Dropdown Toggle
            const accountArea = document.getElementById('accountArea');
            const dropdownMenu = document.getElementById('dropdownMenu');
            if (accountArea && dropdownMenu) {
                accountArea.addEventListener('click', function(e) {
                    e.stopPropagation();
                    dropdownMenu.classList.toggle('block');
                });

                // Prevent dropdown from closing when clicking inside
                dropdownMenu.addEventListener('click', function(e) {
                    e.stopPropagation();
                });

                // Close dropdown when clicking outside
                document.addEventListener('click', function() {
                    dropdownMenu.classList.remove('show');
                });
            }

            // Real-time Search Functionality
            const puppySearchInput = document.getElementById('puppySearchInput');
            const searchDropdown = document.getElementById('searchDropdown');
            const searchResults = document.getElementById('searchResults');
            const tabButtons = document.querySelectorAll('.tab-btn');

            // Show dropdown when input is focused
            puppySearchInput.addEventListener('focus', function() {
                searchDropdown.classList.add('show');
            });

            // Hide dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!e.target.closest('.search-container') && !e.target.closest('.search-dropdown')) {
                    searchDropdown.classList.remove('show');
                }
            });

            // Real-time search as user types
            puppySearchInput.addEventListener('input', function() {
                const query = puppySearchInput.value.trim();
                const activeTab = document.querySelector('.tab-btn.active').dataset.tab;
                searchPuppies(query, activeTab);
            });

            // Tab switching
            tabButtons.forEach(btn => {
                btn.addEventListener('click', function() {
                    tabButtons.forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                    const query = puppySearchInput.value.trim();
                    if (query !== '') {
                        searchPuppies(query, this.dataset.tab);
                    } else {
                        showStaticData(this.dataset.tab);
                    }
                });
            });

            // Function to handle puppy search
            function searchPuppies(query, type) {
                if (query === '') {
                    showStaticData(type);
                    return;
                }

                // Simulate API call or fetch real data
                const allPuppies = {!! json_encode($allPuppies) !!};
                const filteredPuppies = allPuppies.filter(puppy => {
                    const matchesSearch = puppy.name.toLowerCase().includes(query.toLowerCase()) ||
                        puppy.breed.toLowerCase().includes(query.toLowerCase());
                    const matchesType = type === 'all' ||
                        (type === 'pure' && puppy.type === 'pure') ||
                        (type === 'cross' && puppy.type === 'cross');
                    return matchesSearch && matchesType;
                });

                displayResults(filteredPuppies);
            }

            // Function to show static data for a tab
            function showStaticData(tab) {
                // Hide all tab contents
                document.querySelectorAll('.tab-content').forEach(content => {
                    content.style.display = 'none';
                });

                // Show the selected tab content
                const tabContent = document.getElementById(`${tab}-tab`);
                if (tabContent) {
                    tabContent.style.display = 'block';
                }
            }

            // Function to display search results
            function displayResults(results) {
                if (results.length === 0) {
                    searchResults.innerHTML = '<div class="no-results">No puppies found matching your search</div>';
                    return;
                }

                let html = '';
                results.forEach(puppy => {
                    const imagePath = puppy.main_image.startsWith('http') ?
                        puppy.main_image :
                        `/${puppy.main_image}`;

                    html += `
                    <div class="puppy-result" onclick="selectPuppy('${puppy.name}', ${puppy.id})">
                        <img src="${imagePath}" class="puppy-result-image" alt="${puppy.name}">
                        <div class="puppy-result-info">
                            <h4 class="puppy-result-name">${puppy.name}</h4>
                            <p class="puppy-result-meta">${puppy.breed} • ${puppy.gender} • $${puppy.price.toLocaleString()}</p>
                        </div>
                    </div>
                    `;
                });
                searchResults.innerHTML = html;
            }

            // Initialize with All tab shown by default
            showStaticData('all');
        });

        // Function to handle puppy selection
        window.selectPuppy = function(name, id) {
            window.location.href = `/puppie/${id}`;
        };
    </script>

</body>

</html>
