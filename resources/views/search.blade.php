@php
    $allPuppies = App\Helpers\helpers::allPuppies();
    $pureBreedPuppies = App\Helpers\Helpers::pureBreedPuppies();
    $crossBreedPuppies = App\Helpers\Helpers::crossBreedPuppies();
@endphp

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
</style>

<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container">
        <a class="navbar-brand" href="/">
            <img src="{{ asset('logo.jpeg') }}" alt=""
                style="width: auto; height: 100px; object-fit: cover; border-radius: 50%; padding:10px;">
        </a>

        <div class="search-container">
            <input type="text" class="search-input" id="puppySearchInput" placeholder="Search puppies..."
                autocomplete="off">
            <i class="fas fa-search search-icon" id="searchIcon"></i>
            <div class="search-dropdown" id="searchDropdown">
                <div class="search-tabs">
                    <button class="tab-btn active" data-tab="all">All</button>
                    <button class="tab-btn" data-tab="pure">Pure Breed</button>
                    <button class="tab-btn" data-tab="cross">Cross Breed</button>
                </div>
                <div class="search-results" id="searchResults">
                    <div class="tab-content" id="all-tab">
                        @foreach ($allPuppies as $puppy)
                            <div class="puppy-result" onclick="selectPuppy('{{ $puppy->name }}', {{ $puppy->id }})">
                                <img src="{{ asset($puppy->main_image) }}" class="puppy-result-image"
                                    alt="{{ $puppy->name }}">
                                <div class="puppy-result-info">
                                    <h4 class="puppy-result-name">{{ $puppy->name }}</h4>
                                    <p class="puppy-result-meta">{{ $puppy->breed }} • {{ $puppy->gender }} •
                                        ${{ number_format($puppy->price) }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="tab-content" id="pure-tab" style="display:none">
                        @foreach ($pureBreedPuppies as $puppy)
                            <div class="puppy-result"
                                onclick="selectPuppy('{{ $puppy->name }}', {{ $puppy->id }})">
                                <img src="{{ asset($puppy->main_image) }}" class="puppy-result-image"
                                    alt="{{ $puppy->name }}">
                                <div class="puppy-result-info">
                                    <h4 class="puppy-result-name">{{ $puppy->name }}</h4>
                                    <p class="puppy-result-meta">{{ $puppy->breed }} • {{ $puppy->gender }} •
                                        ${{ number_format($puppy->price) }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="tab-content" id="cross-tab" style="display:none">
                        @foreach ($crossBreedPuppies as $puppy)
                            <div class="puppy-result"
                                onclick="selectPuppy('{{ $puppy->name }}', {{ $puppy->id }})">
                                <img src="{{ asset($puppy->main_image) }}" class="puppy-result-image"
                                    alt="{{ $puppy->name }}">
                                <div class="puppy-result-info">
                                    <h4 class="puppy-result-name">{{ $puppy->name }}</h4>
                                    <p class="puppy-result-meta">{{ $puppy->breed }} • {{ $puppy->gender }} •
                                        ${{ number_format($puppy->price) }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="user-dropdown">
            <div class="user-menu" id="accountArea">
                @auth
                    <img src="{{ auth()->user()->avatar
                        ? asset('storage/avatars/' . auth()->user()->avatar)
                        : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) }}"
                        class="user-avatar" alt="User Avatar">
                    <span>{{ auth()->user()->name }}</span>
                @else
                    <i class="fas fa-user-circle user-avatar"></i>
                    <span>Account</span>
                @endauth
                <i class="fas fa-chevron-down ms-2"></i>
            </div>
            <div class="dropdown-menu" id="dropdownMenu">
                @auth
                    @if (auth()->user()->role === 'breeder')
                        <a href="{{ route('breeders.profile', ['id' => auth()->user()->id]) }}" class="dropdown-item">
                            <i class="fas fa-user-circle me-2"></i> My Profile
                        </a>
                    @endif

                    {{-- Add more role-based menu items here if needed --}}
                    {{-- Example for dog-shelter --}}
                    {{-- @if (auth()->user()->role === 'shelter')
                        <a href="{{ route('dog-shelters.index') }}" class="dropdown-item">
                            <i class="fas fa-home me-2"></i> Shelter Profile
                        </a>
                    @endif --}}

                    <div class="dropdown-divider"></div>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    <a href="#" class="dropdown-item"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                    </a>
                    
                    @if (auth()->user()->role === 'user')
                        <a href="{{ route('users.message', ['id' => auth()->user()->id]) }}" class="dropdown-item">Your
                            Messages</a>
                    @endif
                @else
                    <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#loginModal">
                        <i class="fas fa-sign-in-alt me-2"></i> Login
                    </a>
                    <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#breederModal">
                        <i class="fas fa-user-plus me-2"></i> Register as user
                    </a>

                @endauth
            </div>
        </div>

    </div>
</nav>

<!-- Your modals remain exactly the same -->

<!-- Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">Log in to Good Dog</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('loggedin') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="loginEmail" class="form-label">Email address</label>
                        <input type="email" name="email" class="form-control" id="loginEmail"
                            placeholder="challakram11@gmail.com">
                    </div>
                    <div class="mb-3">
                        <label for="loginPassword" class="form-label">Password</label>
                        <input type="password" name="password"class="form-control" id="loginPassword"
                            placeholder="........">
                    </div>
                    <button type="submit" class="btn btn-primary btn-login">Log in</button>
                    <div class="forgot-password">
                        {{-- <a href="#">Forgot password?</a> --}}
                    </div>
                    <p class="mt-3 text-center">
                        If you are new, please
                        <a href="#" class="text-primary fw-semibold text-decoration-none"
                            data-bs-toggle="modal" data-bs-target="#breederModal">
                            <i class="fas fa-user-plus me-1"></i>Register
                        </a> first.
                    </p>



                </form>
            </div>
        </div>
    </div>
</div>

<!-- Breeder Registration Modal -->
<div class="modal fade modal-breeder" id="breederModal" tabindex="-1" aria-labelledby="breederModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="breeder-banner">
                    <img src="https://d3requdwnyz98t.cloudfront.net/assets/packs/static/src/assets/signup_hands-30f04ab0052ee1a0ab28.svg"
                        alt="heart with hands">
                    <h5 class="modal-title" id="breederModalLabel">Register </h5>
                    <p>We take the safety of your information seriously. Your information is secure and never
                        shared. <a href="#" class="text-decoration-underline">Learn more</a></p>
                </div>

                <form id="breederForm" method="POST" action="{{ route('users.store') }}">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label for="firstName" class="form-label">First Name</label>
                            <input type="text" class="form-control @error('firstname') is-invalid @enderror"
                                name="firstname" id="firstName" value="{{ old('firstname') }}" placeholder="Jane">
                            @error('firstname')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="lastName" class="form-label">Last Name</label>
                            <input type="text" class="form-control @error('lastname') is-invalid @enderror"
                                name="lastname" id="lastName" value="{{ old('lastname') }}" placeholder="Smith">
                            @error('lastname')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="programName" class="form-label">Program Name</label>
                        <input type="text" class="form-control @error('programname') is-invalid @enderror"
                            name="programname" id="programName" value="{{ old('programname') }}"
                            placeholder="e.g. High Peaks Farm">
                        @error('programname')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="country" class="form-label">Country</label>
                        <select class="form-select @error('country') is-invalid @enderror" id="country"
                            name="country">
                            <option value="" selected disabled>Select your country</option>
                            <option value="United States" {{ old('country') == 'United States' ? 'selected' : '' }}>
                                United States</option>
                            <option value="Canada" {{ old('country') == 'Canada' ? 'selected' : '' }}>Canada
                            </option>
                            <option value="United Kingdom" {{ old('country') == 'United Kingdom' ? 'selected' : '' }}>
                                United Kingdom</option>
                        </select>
                        @error('country')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                            id="email" name="email" value="{{ old('email') }}"
                            placeholder="jane@highpeaksfarm.com">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="tel" class="form-control @error('phone') is-invalid @enderror"
                            id="phone" name="phone" value="{{ old('phone') }}"
                            placeholder="+1 (123) 456-7890">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                            id="password" name="password" placeholder="6+ characters">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <input type="hidden" name="role" value="user">
                    </div>

                    <button type="submit" class="btn btn-primary btn-breeder mb-3">Continue</button>

                    <div class="terms-text">
                        <p>By continuing, I agree to Good Dog's <a href="#">Breeder Code of Ethics</a>,
                            <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>.
                        </p>
                    </div>
                </form>

                <div class="login-link">
                    <span>Already have an account?</span>
                    <a href="#" data-bs-dismiss="modal" data-bs-toggle="modal"
                        data-bs-target="#loginModal">Log in</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    window.puppyData = {
        all: @json($allPuppies),
        pure: @json($pureBreedPuppies),
        cross: @json($crossBreedPuppies)
    };
    // Initialize with all puppies shown by default
    document.addEventListener('DOMContentLoaded', function() {
        showStaticData('all'); // Show all puppies by default
    });
    document.addEventListener('DOMContentLoaded', function() {
        const puppySearchInput = document.getElementById('puppySearchInput');
        const searchDropdown = document.getElementById('searchDropdown');
        const tabButtons = document.querySelectorAll('.tab-btn');

        // Show dropdown when input is focused
        if (puppySearchInput) {
            puppySearchInput.addEventListener('focus', function() {
                searchDropdown.classList.add('show');
            });

            puppySearchInput.addEventListener('input', function() {
                const query = puppySearchInput.value.trim().toLowerCase();
                const activeTab = document.querySelector('.tab-btn.active').dataset.tab;

                if (query === '') {
                    showStaticData(activeTab); // Show all puppies when search is empty
                } else {
                    searchPuppies(query, activeTab); // Filter when there's a query
                }
            });
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.search-container')) {
                searchDropdown.classList.remove('show');
            }
        });

        // Tab switching
        tabButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                tabButtons.forEach(b => b.classList.remove('active'));
                this.classList.add('active');

                const query = puppySearchInput.value.trim().toLowerCase();
                if (query === '') {
                    showStaticData(this.dataset.tab); // Show all puppies for the selected tab
                } else {
                    searchPuppies(query, this.dataset.tab); // Filter existing search
                }
            });
        });

        function searchPuppies(query, type) {
            const puppies = window.puppyData[type] || [];
            const resultsContainer = document.getElementById('searchResults');

            const filteredPuppies = puppies.filter(puppy => {
                return puppy.name.toLowerCase().includes(query) ||
                    puppy.breed.toLowerCase().includes(query);
            });

            displayResults(filteredPuppies, type);
        }

        // Show all puppies for a specific tab
        function showStaticData(type) {
            const puppies = window.puppyData[type] || [];
            displayResults(puppies, type);
        }

        // Display puppies in the results container
        function displayResults(puppies, type) {
            const resultsContainer = document.getElementById('searchResults');

            if (puppies.length === 0) {
                resultsContainer.innerHTML = '<div class="p-3 text-center">No puppies found</div>';
                return;
            }

            let html = '';
            puppies.forEach(puppy => {
                const imagePath = puppy.main_image.startsWith('http') ?
                    puppy.main_image :
                    `/${puppy.main_image}`;

                html += `
        <div class="puppy-result" onclick="window.location.href='/puppie/${puppy.id}'">
            <img src="${imagePath}" class="puppy-result-image" alt="${puppy.name}">
            <div class="puppy-result-info">
                <h4 class="puppy-result-name">${puppy.name}</h4>
                <p class="puppy-result-meta">${puppy.breed} • ${puppy.gender} • $${puppy.price.toLocaleString()}</p>
            </div>
        </div>
        `;
            });

            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(content => {
                content.style.display = 'none';
            });

            // Show results in the container
            resultsContainer.innerHTML = html;
        }
    });

    window.selectPuppy = function(name, id) {
        window.location.href = `/puppie/${id}`;
    };
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const accountArea = document.getElementById('accountArea');
        const dropdownMenu = document.getElementById('dropdownMenu');

        accountArea.addEventListener('click', function(e) {
            e.stopPropagation(); // Prevents the event from bubbling up
            dropdownMenu.classList.toggle('show');
        });

        // Hide dropdown when clicking outside
        document.addEventListener('click', function() {
            dropdownMenu.classList.remove('show');
        });
    });
</script>
