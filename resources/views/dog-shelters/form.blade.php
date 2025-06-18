<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adopt Your New Best Friend | Good Dog</title>
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
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.08);
            --shadow-md: 0 4px 6px rgba(0,0,0,0.1);
            --shadow-lg: 0 10px 15px rgba(0,0,0,0.1);
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
        
        .adoption-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);
            color: white;
            padding: 1.5rem;
            border-radius: var(--rounded-lg) var(--rounded-lg) 0 0;
            position: relative;
            overflow: hidden;
        }
        
        .adoption-header::before {
            content: "";
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 200%;
            background-image: radial-gradient(circle, rgba(255,255,255,0.1) 1px, transparent 1px);
            background-size: 15px 15px;
            opacity: 0.3;
            transform: rotate(15deg);
        }
        
        .adoption-card {
            border: none;
            border-radius: var(--rounded-lg);
            box-shadow: var(--shadow-lg);
            overflow: hidden;
            transition: var(--transition);
        }
        
        .puppy-image-container {
            position: relative;
            border-radius: var(--rounded-md);
            overflow: hidden;
            box-shadow: var(--shadow-md);
            border: 3px solid white;
            margin-bottom: 1.5rem;
        }
        
        .puppy-image-container img {
            width: 100%;
            height: auto;
            display: block;
        }
        
        .detail-card {
            background-color: white;
            border-radius: var(--rounded-md);
            padding: 1.25rem;
            margin-bottom: 1.5rem;
            box-shadow: var(--shadow-sm);
        }
        
        .detail-card h5 {
            color: var(--primary-color);
            border-bottom: 2px solid var(--border-color);
            padding-bottom: 0.5rem;
            margin-bottom: 1rem;
        }
        
        .detail-item {
            display: flex;
            justify-content: space-between;
            padding: 0.5rem 0;
            border-bottom: 1px dashed var(--border-color);
        }
        
        .detail-item:last-child {
            border-bottom: none;
        }
        
        .detail-label {
            font-weight: 600;
            color: var(--text-dark);
        }
        
        .detail-value {
            color: var(--text-medium);
        }
        
        .breeder-card {
            display: flex;
            align-items: center;
            background-color: white;
            border-radius: var(--rounded-md);
            padding: 1rem;
            box-shadow: var(--shadow-sm);
            margin-bottom: 1.5rem;
        }
        
        .breeder-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid var(--primary-color);
            margin-right: 1rem;
        }
        
        .breeder-info {
            flex: 1;
        }
        
        .breeder-name {
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.25rem;
        }
        
        .breeder-location {
            color: var(--text-light);
            font-size: 0.9rem;
        }
        
        .adoption-form {
            background-color: white;
            border-radius: var(--rounded-md);
            padding: 1.5rem;
            box-shadow: var(--shadow-sm);
        }
        
        .form-control, .form-select {
            border-radius: var(--rounded-sm);
            border: 1px solid var(--border-color);
            padding: 0.75rem 1rem;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(90, 103, 216, 0.25);
        }
        
        .btn-adopt {
            background-color: var(--primary-color);
            border: none;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: var(--transition);
        }
        
        .btn-adopt:hover {
            background-color: #4c51bf;
            transform: translateY(-2px);
        }
        
        .btn-outline-secondary {
            border-color: var(--border-color);
        }
        
        .btn-outline-secondary:hover {
            background-color: var(--secondary-color);
        }
        
        /* Registration Modal Styles */
        .modal-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);
            color: white;
            border-bottom: none;
        }
        
        .modal-footer {
            border-top: none;
            background-color: var(--secondary-color);
        }
        
        .role-selection {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        
        .role-option {
            flex: 1;
            text-align: center;
        }
        
        .role-option input[type="radio"] {
            display: none;
        }
        
        .role-option label {
            display: block;
            padding: 1rem;
            background-color: white;
            border: 2px solid var(--border-color);
            border-radius: var(--rounded-md);
            cursor: pointer;
            transition: var(--transition);
        }
        
        .role-option input[type="radio"]:checked + label {
            border-color: var(--primary-color);
            background-color: rgba(90, 103, 216, 0.1);
        }
        
        .role-icon {
            font-size: 2rem;
            margin-bottom: 0.5rem;
            color: var(--primary-color);
        }
        
        @media (max-width: 768px) {
            .adoption-header {
                padding: 1rem;
            }
            
            .breeder-card {
                flex-direction: column;
                text-align: center;
            }
            
            .breeder-avatar {
                margin-right: 0;
                margin-bottom: 1rem;
            }
            
            .role-selection {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <!-- Registration Modal -->
    <div class="modal fade" id="registrationModal" tabindex="-1" aria-labelledby="registrationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="registrationModalLabel">Join Good Dog</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="registrationForm" method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="role-selection">
                            <div class="role-option">
                                <input type="radio" id="roleUser" name="role" value="user" checked>
                                <label for="roleUser">
                                    <div class="role-icon"><i class="fas fa-user"></i></div>
                                    <h5>Pet Lover</h5>
                                    <p class="text-muted">I want to adopt a puppy</p>
                                </label>
                            </div>
                            <div class="role-option">
                                <input type="radio" id="roleBreeder" name="role" value="breeder">
                                <label for="roleBreeder">
                                    <div class="role-icon"><i class="fas fa-home"></i></div>
                                    <h5>Breeder</h5>
                                    <p class="text-muted">I want to list puppies</p>
                                </label>
                            </div>
                        </div>
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="col-md-6">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="tel" class="form-control" id="phone" name="phone" required>
                            </div>
                            <div class="col-md-6">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" class="form-control" id="address" name="address" required>
                            </div>
                            <div class="col-md-6">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Register</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Login Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginModalLabel">Welcome Back</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="loginForm" method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="loginEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="loginEmail" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="loginPassword" class="form-label">Password</label>
                            <input type="password" class="form-control" id="loginPassword" name="password" required>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember">Remember me</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="adoption-card">
                    <div class="adoption-header text-center">
                        <h2><i class="fas fa-paw me-2"></i> Adoption Request</h2>
                        <p class="mb-0">For <span id="adoption-puppy-name" class="fw-bold"></span></p>
                    </div>
                    
                    <div class="card-body p-4">
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="puppy-image-container">
                                    <img id="adoption-puppy-image" src="" alt="" class="img-fluid">
                                </div>
                                
                                <div class="detail-card">
                                    <h5><i class="fas fa-dog me-2"></i> Puppy Details</h5>
                                    <div class="detail-item">
                                        <span class="detail-label">Name:</span>
                                        <span class="detail-value" id="adoption-puppy-name-text"></span>
                                    </div>
                                    <div class="detail-item">
                                        <span class="detail-label">Breed:</span>
                                        <span class="detail-value" id="adoption-puppy-breed"></span>
                                    </div>
                                    <div class="detail-item">
                                        <span class="detail-label">Gender:</span>
                                        <span class="detail-value" id="adoption-puppy-gender"></span>
                                    </div>
                                    <div class="detail-item">
                                        <span class="detail-label">Age:</span>
                                        <span class="detail-value" id="adoption-puppy-age"></span>
                                    </div>
                                    <div class="detail-item">
                                        <span class="detail-label">Price:</span>
                                        <span class="detail-value">$<span id="adoption-puppy-price"></span></span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="breeder-card">
                                    <img id="adoption-breeder-image" src="" class="breeder-avatar">
                                    <div class="breeder-info">
                                        <h5 class="breeder-name" id="adoption-breeder-name"></h5>
                                        <p class="breeder-location mb-1" id="adoption-breeder-location"></p>
                                        <small class="text-muted"><i class="fas fa-user-tie me-1"></i> Breeder</small>
                                    </div>
                                </div>
                                
                                <div class="detail-card">
                                    <h5><i class="fas fa-info-circle me-2"></i> About This Puppy</h5>
                                    <p class="mb-0" id="adoption-puppy-description"></p>
                                </div>
                                
                                <div class="adoption-form mt-3">
                                    @auth
                                        <form id="adoption-form" method="POST" action="{{ route('adoptions.store', ['puppy' => 'PUPPY_ID']) }}">
                                            @csrf
                                            <input type="hidden" name="puppy_id" id="adoption-puppy-id">
                                            
                                            <div class="mb-4">
                                                <label for="message" class="form-label fw-bold">
                                                    <i class="fas fa-envelope me-2"></i> Your Message to the Breeder
                                                </label>
                                                <textarea class="form-control" id="message" name="message" rows="4" required
                                                    placeholder="Tell us about your home, experience with pets, and why you'd be a great fit for this puppy..."></textarea>
                                            </div>
                                            
                                            <div class="mb-4">
                                                <label for="contact" class="form-label fw-bold">
                                                    <i class="fas fa-phone-alt me-2"></i> Contact Information
                                                </label>
                                                <input type="text" class="form-control" id="contact" name="contact" required
                                                    value="{{ auth()->user()->phone ?? auth()->user()->email ?? '' }}"
                                                    placeholder="Phone number or email where we can reach you">
                                            </div>
                                            
                                            <div class="d-grid gap-3">
                                                <button type="submit" class="btn btn-adopt btn-lg text-white">
                                                    <i class="fas fa-paper-plane me-2"></i> Submit Adoption Request
                                                </button>
                                                <a href="#" class="btn btn-outline-secondary" id="back-to-puppy">
                                                    <i class="fas fa-arrow-left me-2"></i> Back to Puppy Details
                                                </a>
                                            </div>
                                        </form>
                                    @else
                                        <div class="text-center py-4">
                                            <h4 class="mb-3">You need an account to adopt this puppy</h4>
                                            <div class="d-grid gap-2">
                                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#loginModal">
                                                    <i class="fas fa-sign-in-alt me-2"></i> Login
                                                </button>
                                                <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#registrationModal">
                                                    <i class="fas fa-user-plus me-2"></i> Register
                                                </button>
                                                <a href="#" class="btn btn-outline-secondary" id="back-to-puppy">
                                                    <i class="fas fa-arrow-left me-2"></i> Back to Puppy Details
                                                </a>
                                            </div>
                                        </div>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get the puppy data from session storage
            const puppyData = JSON.parse(sessionStorage.getItem('adoptionPuppy'));
            
            if (puppyData) {
                // Populate the form with puppy data
                document.getElementById('adoption-puppy-id').value = puppyData.id;
                document.getElementById('adoption-puppy-name').textContent = puppyData.name;
                document.getElementById('adoption-puppy-name-text').textContent = puppyData.name;
                document.getElementById('adoption-puppy-image').src = puppyData.image;
                document.getElementById('adoption-puppy-image').alt = puppyData.name;
                document.getElementById('adoption-puppy-breed').textContent = puppyData.breed;
                document.getElementById('adoption-puppy-gender').textContent = puppyData.gender;
                document.getElementById('adoption-puppy-age').textContent = puppyData.age;
                document.getElementById('adoption-puppy-price').textContent = puppyData.price.toLocaleString();
                document.getElementById('adoption-puppy-description').textContent = puppyData.description;
                
                // Populate breeder info
                document.getElementById('adoption-breeder-name').textContent = puppyData.breeder_name;
                document.getElementById('adoption-breeder-location').textContent = puppyData.breeder_location;
                document.getElementById('adoption-breeder-image').src = puppyData.breeder_image;
                document.getElementById('adoption-breeder-image').alt = puppyData.breeder_name;
                
                // Set back button URL
                document.getElementById('back-to-puppy').href = `/puppies/${puppyData.id}`;
                
                // Update form action with actual puppy ID
                const form = document.getElementById('adoption-form');
                if (form) {
                    form.action = form.action.replace('PUPPY_ID', puppyData.id);
                }
            } else {
                // No puppy data found, redirect back
                window.location.href = '/puppies';
            }

            // Handle registration success
            @if(session('registration_success'))
                const registrationModal = bootstrap.Modal.getInstance(document.getElementById('registrationModal'));
                if (registrationModal) {
                    registrationModal.hide();
                }
                // Auto-fill login form
                document.getElementById('loginEmail').value = '{{ session("registration_email") }}';
                const loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
                loginModal.show();
            @endif

            // Handle login redirect
            @if(isset($login_redirect))
                const loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
                loginModal.show();
            @endif
        });
    </script>
</body>
</html>