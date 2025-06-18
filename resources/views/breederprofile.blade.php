<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $breeder->kennel_name }} - Breeder Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://api.mapbox.com/mapbox-gl-js/v2.6.1/mapbox-gl.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #eb5743;
            --primary-light: #c66c50;
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
            font-family: 'Georgia', serif;
            color: var(--text-dark);
            background-color: #f8f9fa;
        }

        /* Cover Image Section */
        .cover-image-section {
            height: 350px;
            background-size: cover;
            background-position: center;
            position: relative;
            margin-bottom: 100px;
        }

        .profile-overlay {
            position: absolute;
            bottom: -75px;
            left: 0;
            right: 0;
            display: flex;
            justify-content: center;
        }

        .profile-image-container {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            border: 5px solid white;
            overflow: hidden;
            box-shadow: var(--shadow-lg);
        }

        .profile-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Main Layout */
        .main-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: grid;
            grid-template-columns: 300px 1fr;
            gap: 30px;
        }

        /* Left Sidebar */
        .breeder-sidebar {
            background-color: white;
            border-radius: var(--rounded-md);
            box-shadow: var(--shadow-sm);
            padding: 25px;
            position: sticky;
            top: 20px;
            height: fit-content;
        }

        .sidebar-profile {
            text-align: center;
            margin-bottom: 25px;
        }

        .sidebar-image {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 15px;
            border: 3px solid var(--primary-light);
        }

        .sidebar-name {
            font-size: 1.4rem;
            font-weight: 600;
            margin-bottom: 5px;
            color: var(--primary-color);
        }

        .sidebar-location {
            color: var(--text-medium);
            font-size: 0.9rem;
            margin-bottom: 15px;
        }

        .health-icons {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-bottom: 25px;
        }

        .health-icon {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .icon-circle {
            width: 50px;
            height: 50px;
            background-color: var(--primary-light);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 8px;
        }

        .icon-circle i {
            color: white;
            font-size: 1.2rem;
        }

        .icon-label {
            font-size: 0.8rem;
            color: var(--text-medium);
        }

        .sidebar-stats {
            border-top: 1px solid var(--border-color);
            padding-top: 20px;
        }

        .stat-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
        }

        .stat-label {
            color: var(--text-medium);
        }

        .stat-value {
            font-weight: 600;
        }

        /* Right Content */
        .breeder-content {
            display: flex;
            flex-direction: column;
            gap: 30px;
        }

        /* Breeder Header */
        .breeder-header {
            background-color: white;
            padding: 25px;
            border-radius: var(--rounded-md);
            box-shadow: var(--shadow-sm);
        }

        .breeder-name {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 10px;
            color: var(--primary-color);
        }

        .badge-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 20px;
        }

        .badge {
            background-color: var(--primary-light);
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.9rem;
        }

        .social-links {
            display: flex;
            gap: 15px;
        }

        .social-link {
            color: var(--text-medium);
            font-size: 1.3rem;
            transition: var(--transition);
        }

        .social-link:hover {
            color: var(--primary-color);
        }

        /* About Section */
        .about-section {
            background-color: white;
            padding: 25px;
            border-radius: var(--rounded-md);
            box-shadow: var(--shadow-sm);
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 20px;
            color: var(--primary-color);
            border-bottom: 2px solid var(--border-color);
            padding-bottom: 10px;
        }

        /* Map Section */
        .map-section {
            background-color: white;
            border-radius: var(--rounded-md);
            box-shadow: var(--shadow-sm);
            overflow: hidden;
            height: 350px;
        }

        #breederMap {
            width: 100%;
            height: 100%;
        }

        .map-overlay {
            position: absolute;
            bottom: 20px;
            left: 20px;
            background-color: white;
            padding: 10px 15px;
            border-radius: var(--rounded-sm);
            box-shadow: var(--shadow-md);
            z-index: 1;
        }

        /* Categories Section */
        .categories-section {
            background-color: white;
            padding: 25px;
            border-radius: var(--rounded-md);
            box-shadow: var(--shadow-sm);
        }

        .categories-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 15px;
        }

        .category-card {
            border: 1px solid var(--border-color);
            border-radius: var(--rounded-sm);
            padding: 15px;
            text-align: center;
            transition: var(--transition);
            cursor: pointer;
        }

        .category-card:hover {
            border-color: var(--primary-color);
            box-shadow: var(--shadow-sm);
            background-color: rgba(90, 103, 216, 0.1);
        }

        .category-card.active {
            background-color: var(--primary-color);
            color: white;
        }

        .category-card.active .category-icon {
            color: white;
        }

        .category-card.active .text-muted {
            color: rgba(255, 255, 255, 0.8) !important;
        }

        .category-icon {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 50%;
            margin-bottom: 10px;
        }

        /* Puppies Section */
        .puppies-section {
            background-color: white;
            padding: 25px;
            border-radius: var(--rounded-md);
            box-shadow: var(--shadow-sm);
        }

        .category-filter {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 20px;
        }

        .category-btn {
            padding: 8px 20px;
            border: 1px solid var(--border-color);
            border-radius: 20px;
            background-color: white;
            cursor: pointer;
            transition: var(--transition);
        }

        .category-btn:hover,
        .category-btn.active {
            background-color: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        .puppies-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
        }

        .puppy-card {
            border-radius: var(--rounded-md);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
        }

        .puppy-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }

        .puppy-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .puppy-info {
            padding: 15px;
        }

        .puppy-name {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .puppy-meta {
            color: var(--text-medium);
            font-size: 0.9rem;
            margin-bottom: 10px;
        }

        .puppy-price {
            font-size: 1rem;
            font-weight: 700;
            color: var(--primary-color);
        }

        /* Responsive Adjustments */
        @media (max-width: 992px) {
            .main-container {
                grid-template-columns: 1fr;
            }
            
            .breeder-sidebar {
                position: static;
            }
        }

        @media (max-width: 768px) {
            .cover-image-section {
                height: 250px;
                margin-bottom: 80px;
            }
            
            .profile-image-container {
                width: 120px;
                height: 120px;
            }
        }

        @media (max-width: 576px) {
            .cover-image-section {
                height: 200px;
            }
            
            .health-icons {
                grid-template-columns: 1fr;
            }
            
            .categories-grid {
                grid-template-columns: 1fr;
            }
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
    </style>
</head>

<body>
    <!-- Cover Image Section -->
    <div class="cover-image-section" style="background-image: url('{{ asset($breeder->cover_image) }}')">
        <div class="profile-overlay">
            <div class="profile-image-container">
                <img src="{{ asset($breeder->profile_image) }}" 
                     alt="{{ $breeder->kennel_name }}" class="profile-image">
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-container">
        <!-- Left Sidebar -->
        <div class="breeder-sidebar">
            <div class="sidebar-profile">
                <img src="{{ asset($breeder->profile_image) }}" 
                     alt="{{ $breeder->kennel_name }}" class="sidebar-image">
                <h2 class="sidebar-name">{{ $breeder->kennel_name }}</h2>
                <div class="sidebar-location">
                    <i class="fas fa-map-marker-alt"></i> {{ $breeder->city }}, {{ $breeder->state }}
                </div>

                <!-- Health Icons -->
                <div class="health-icons">
                    <div class="health-icon">
                        <div class="icon-circle">
                            <i class="fas fa-heartbeat"></i>
                        </div>
                        <span class="icon-label">Health Guarantee</span>
                    </div>
                    <div class="health-icon">
                        <div class="icon-circle">
                            <i class="fas fa-syringe"></i>
                        </div>
                        <span class="icon-label">Vaccinated</span>
                    </div>
                    <div class="health-icon">
                        <div class="icon-circle">
                            <i class="fas fa-dna"></i>
                        </div>
                        <span class="icon-label">Genetic Testing</span>
                    </div>
                    <div class="health-icon">
                        <div class="icon-circle">
                            <i class="fas fa-stethoscope"></i>
                        </div>
                        <span class="icon-label">Vet Checked</span>
                    </div>
                </div>
                
                <!-- Breeder Stats -->
                <div class="sidebar-stats">
                    <div class="stat-item">
                        <span class="stat-label">Experience:</span>
                        <span class="stat-value">{{ $breeder->years_experience ?? '0' }} years</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">Puppies:</span>
                        <span class="stat-value">{{ $puppies->count() }}</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">Categories:</span>
                        <span class="stat-value">{{ count($breederCategories) }}</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">Rating:</span>
                        <span class="stat-value">{{ number_format($breeder->average_rating, 1) }}/5</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Content -->
        <div class="breeder-content">
            <!-- Breeder Header -->
            <div class="breeder-header">
                <h1 class="breeder-name">{{ $breeder->kennel_name }}</h1>
                
                <!-- Badges -->
                <div class="badge-container">
                    @if($breeder->is_akc_registered)
                        <span class="badge"><i class="fas fa-award"></i> AKC Registered</span>
                    @endif
                    @if($breeder->is_licensed)
                        <span class="badge"><i class="fas fa-certificate"></i> Licensed</span>
                    @endif
                    @if($breeder->accepts_visits)
                        <span class="badge"><i class="fas fa-home"></i> Accepts Visits</span>
                    @endif
                </div>
                
                <!-- Social Links -->
                @if($breeder->social_links)
                    <div class="social-links">
                        @foreach(json_decode($breeder->social_links, true) as $platform => $url)
                            @if($url)
                                <a href="{{ $url }}" class="social-link" target="_blank">
                                    <i class="fab fa-{{ $platform }}"></i>
                                </a>
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- About Section -->
            <div class="about-section">
                <h2 class="section-title">About Our Kennel</h2>
                <p>{{ $breeder->about ?? 'No description provided.' }}</p>
                
                @if($breeder->website)
                    <p><strong>Website:</strong> <a href="{{ $breeder->website }}" target="_blank">{{ $breeder->website }}</a></p>
                @endif
                
                @if($breeder->years_experience)
                    <p><strong>Years of Experience:</strong> {{ $breeder->years_experience }}</p>
                @endif
                
                @if($breeder->visit_policy && $breeder->accepts_visits)
                    <div class="mt-4">
                        <h3 class="h5">Visit Policy</h3>
                        <p>{{ $breeder->visit_policy }}</p>
                    </div>
                @endif
            </div>

            <!-- Map Section -->
            <div class="map-section">
                <div id="breederMap"></div>
                <div class="map-overlay">
                    <i class="fas fa-map-marker-alt text-danger"></i> {{ $breeder->address }}, {{ $breeder->city }}, {{ $breeder->state }}
                </div>
            </div>

            <!-- Categories Section -->
            <div class="categories-section">
                <h2 class="section-title">Our Specializations</h2>
                <div class="categories-grid" id="breederCategories">
                    @foreach($categories as $category)
                            <div class="category-card" data-category-id="{{ $category->id }}">
                                @if($category->image)
                                    <img src="{{ asset('image/'.$category->image) }}" alt="{{ $category->name }}" class="category-icon">
                                @else
                                    <div class="category-icon">
                                        <i class="fas fa-paw"></i>
                                    </div>
                                @endif
                                <h3>{{ $category->name }}</h3>
                                <p class="text-muted small">{{ $category->description ?? 'Specialized breeding' }}</p>
                            </div>
                    @endforeach
                </div>
            </div>

            <!-- Puppies Section -->
            <div class="puppies-section">
                <h2 class="section-title">Available Puppies</h2>
                
                <div class="category-filter">
                    <button class="category-btn active" data-category="all">All Puppies</button>
                    @foreach($categories as $category)
                        @if(in_array($category->id, $breederCategories))
                            <button class="category-btn" data-category="{{ $category->id }}">{{ $category->name }}</button>
                        @endif
                    @endforeach
                </div>

                <div class="puppies-grid" id="puppiesContainer">
                    @foreach($puppies as $puppy)
                        <div class="puppy-card" data-category-id="{{ $puppy->category_id }}">
                            <img src="{{ asset($puppy->main_image) }}" alt="{{ $puppy->name }}" class="puppy-image">
                            <div class="puppy-info">
                                <h3 class="puppy-name">{{ $puppy->name }}</h3>
                                <p class="puppy-meta">{{ $puppy->breed }} • {{ $puppy->gender }} • {{ $puppy->age }}</p>
                                <p class="puppy-price">${{ number_format($puppy->price) }}</p>
                                <a href="{{ route('puppies.show', $puppy->id) }}" class="btn btn-primary w-100">View Details</a>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if($puppies->count() === 0)
                    <div class="alert alert-info text-center">
                        No puppies currently available. Please check back later!
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://api.mapbox.com/mapbox-gl-js/v2.6.1/mapbox-gl.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize map
            mapboxgl.accessToken = 'pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw';
            const map = new mapboxgl.Map({
                container: 'breederMap',
                style: 'mapbox://styles/mapbox/streets-v11',
                center: [{{ $breeder->longitude ?? -98.5795 }}, {{ $breeder->latitude ?? 39.8283 }}],
                zoom: 10
            });

            // Add marker
            new mapboxgl.Marker({ color: '#F84C4C' })
                .setLngLat([{{ $breeder->longitude ?? -98.5795 }}, {{ $breeder->latitude ?? 39.8283 }}])
                .addTo(map);

            // Category filter functionality
            const categoryBtns = document.querySelectorAll('.category-btn');
            const puppyCards = document.querySelectorAll('.puppy-card');
            const categoryCards = document.querySelectorAll('.category-card');
            
            // Function to filter puppies by category
            function filterPuppies(categoryId) {
                puppyCards.forEach(card => {
                    if (categoryId === 'all') {
                        card.style.display = 'block';
                    } else {
                        const puppyCategoryId = card.dataset.categoryId;
                        if (puppyCategoryId == categoryId) {
                            card.style.display = 'block';
                        } else {
                            card.style.display = 'none';
                        }
                    }
                    
                    // Add fade animation
                    card.style.animation = 'fadeIn 0.5s ease';
                });
            }
            
            // Filter when clicking category buttons
            categoryBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    // Update active button
                    categoryBtns.forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                    
                    const category = this.dataset.category;
                    filterPuppies(category);
                    
                    // Update active category card
                    categoryCards.forEach(card => {
                        card.classList.remove('active');
                        if (card.dataset.categoryId === category) {
                            card.classList.add('active');
                        }
                    });
                });
            });
            
            // Filter when clicking category cards
            categoryCards.forEach(card => {
                card.addEventListener('click', function() {
                    const categoryId = this.dataset.categoryId;
                    
                    // Update active state for category cards
                    categoryCards.forEach(c => c.classList.remove('active'));
                    this.classList.add('active');
                    
                    // Update active button
                    categoryBtns.forEach(b => {
                        b.classList.remove('active');
                        if (b.dataset.category === categoryId || 
                            (b.dataset.category === 'all' && !document.querySelector('.category-btn.active'))) {
                            b.classList.add('active');
                        }
                    });
                    
                    filterPuppies(categoryId);
                    
                    // Scroll to puppies section
                    document.querySelector('.puppies-section').scrollIntoView({
                        behavior: 'smooth'
                    });
                });
            });
        });
    </script>
</body>
</html>