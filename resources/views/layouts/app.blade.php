@php
    $user = App\Helpers\helpers::user();
    $breeder = App\Helpers\Helpers::isBreeder();
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>{{ $user->name }} - Breeder Profile</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
    <style>
        .cover-photo {
            background-size: cover;
            background-position: center;
            height: 300px;
            position: relative;
            border-radius: 8px;
            margin-bottom: 80px;
            background-color: #f0f0f0;
        }

        .profile-avatar {
            position: absolute;
            bottom: -75px;
            left: 50%;
            transform: translateX(-50%);
            width: 150px;
            height: 150px;
            object-fit: cover;
            border: 5px solid white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .dashboard-card {
            border-radius: 8px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
            padding: 20px;
            margin-bottom: 20px;
        }

        .action-btns .btn {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }

        .form-section {
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #eee;
        }

        .modal-dialog-scrollable .modal-body {
            max-height: 70vh;
            overflow-y: auto;
        }

        .modal-footer.sticky-footer {
            position: sticky;
            bottom: 0;
            background: white;
            padding: 1rem;
            border-top: 1px solid #dee2e6;
            z-index: 1050;
        }

        .invalid-feedback {
            display: block;
        }
        
        .nav-tabs .nav-link {
            color: #495057;
        }
        
        .nav-tabs .nav-link.active {
            font-weight: bold;
            border-bottom: 3px solid #0d6efd;
        }
    </style>
</head>

<body>
    <div class="container mt-4">
        <!-- Cover Photo -->
        <div class="cover-photo"
            style="background-image: url('{{ $breeder->cover_image ? asset($breeder->cover_image) : asset('images/default-cover.jpg') }}');">
            <div class="profile-avatar">
                <img src="{{ $breeder?->profile_image
                    ? asset($breeder->profile_image)
                    : ($user->avatar
                        ? asset('storage/avatars/' . $user->avatar)
                        : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&size=200') }}"
                    class="rounded-circle avatar-img profile-avatar" alt="{{ $user->name }}'s profile picture"
                    onerror="this.onerror=null;this.src='https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&size=200'">
            </div>
        </div>
        
        <!-- Profile Header -->
        <div class="text-center mt-5">
            <h1>{{ $user->name }}</h1>
            @if ($breeder && $breeder->kennel_name)
                <h4 class="text-muted">{{ $breeder->kennel_name }}</h4>
            @endif
            @if (auth()->id() === $user->id)
                @if ($breeder)
                    <button type="button" class="btn btn-primary mt-2" data-bs-toggle="modal"
                        data-bs-target="#editProfileModal">
                        <i class="fas fa-edit"></i> Edit Profile
                    </button>
                @endif
                @if (!$breeder)
                    <button type="button" class="btn btn-success mt-2 ms-2" data-bs-toggle="modal"
                        data-bs-target="#createBreederModal">
                        <i class="fas fa-plus"></i> Create Breeder Profile
                    </button>
                @endif
            @endif
        </div>
        
        <!-- Main Content -->
        <div class="dashboard-card mt-4">
            <ul class="nav nav-tabs" id="breederTabs">
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('breeder/profile*') ? 'active' : '' }}" 
                       href="#">Profile</a>
                </li>
                @if ($breeder)
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('puppies*') ? 'active' : '' }}" 
                           href="{{ route('puppies.index') }}">Puppies</a>
                    </li>
                    {{-- <li class="nav-item">
                        <a class="nav-link {{ request()->is('litters*') ? 'active' : '' }}" 
                           href="{{ route('litters.index') }}">Litters</a>
                    </li> --}}
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('breeder-categories*') ? 'active' : '' }}" 
                           href="{{ route('breeder-categories.index') }}">Categories</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('adoptions*') ? 'active' : '' }}" 
                           href="{{ route('adoptions.index') }}">Adoption Requests</a>
                    </li>
                @endif
            </ul>

            <div class="tab-content mt-3">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>

    <!-- Template Main JS File -->
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Highlight active tab based on current URL
            const currentPath = window.location.pathname;
            const navLinks = document.querySelectorAll('#breederTabs .nav-link');
            
            navLinks.forEach(link => {
                if (link.getAttribute('href') === currentPath) {
                    link.classList.add('active');
                } else {
                    link.classList.remove('active');
                }
            });
            
            // Prevent default behavior for active links
            document.querySelectorAll('#breederTabs .nav-link.active').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                });
            });
        });
    </script>

</body>

</html>