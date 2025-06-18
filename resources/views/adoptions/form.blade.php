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
        
        /* User Registration Modal Styles */
        .modal-user .modal-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);
            color: white;
            border-bottom: none;
        }
        
        .modal-user .modal-footer {
            border-top: none;
            background-color: var(--secondary-color);
        }
        
        .user-banner {
            text-align: center;
            margin-bottom: 1.5rem;
        }
        
        .user-banner img {
            max-width: 200px;
            margin-bottom: 1rem;
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
        }
    </style>
</head>
<body>
    <!-- User Registration Modal -->
    <div class="modal fade modal-user" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userModalLabel">Join as a Pet Lover</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="user-banner">
                        <img src="https://d3requdwnyz98t.cloudfront.net/assets/packs/static/src/assets/signup_hands-30f04ab0052ee1a0ab28.svg" alt="heart with hands">
                        <p>We take the safety of your information seriously. Your information is secure and never shared.</p>
                    </div>

                    <form id="userForm" method="POST" action="{{ route('users.store') }}">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label for="firstName" class="form-label">First Name</label>
                                <input type="text" class="form-control @error('firstname') is-invalid @enderror"
                                    name="firstname" id="firstName" value="{{ old('firstname') }}"
                                    placeholder="Jane">
                                @error('firstname')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="lastName" class="form-label">Last Name</label>
                                <input type="text" class="form-control @error('lastname') is-invalid @enderror"
                                    name="lastname" id="lastName" value="{{ old('lastname') }}"
                                    placeholder="Smith">
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
                                <option value="United States"
                                    {{ old('country') == 'United States' ? 'selected' : '' }}>United States</option>
                                <option value="Canada" {{ old('country') == 'Canada' ? 'selected' : '' }}>Canada
                                </option>
                                <option value="United Kingdom"
                                    {{ old('country') == 'United Kingdom' ? 'selected' : '' }}>United Kingdom</option>
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
                </div>
                <div class="modal-footer justify-content-center">
                    <span>Already have an account?</span>
                    <a href="#" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#loginModal">Log in</a>
                </div>
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
                            <input type="email" class="form-control" id="loginEmail" name="email" >
                        </div>
                        <div class="mb-3">
                            <label for="loginPassword" class="form-label">Password</label>
                            <input type="password" class="form-control" id="loginPassword" name="password" >
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
                                        @if(auth()->user()->role === 'user')
                                            <form id="adoption-form" method="POST" action="{{ route('adoptions.store', ['puppy' => 'PUPPY_ID']) }}">
                                                @csrf
                                                <input type="hidden" name="puppy_id" id="adoption-puppy-id">
                                                
                                                <div class="mb-4">
                                                    <label for="message" class="form-label fw-bold">
                                                        <i class="fas fa-envelope me-2"></i> Your Message to the Breeder
                                                    </label>
                                                    <textarea class="form-control" id="message" name="message" rows="4" 
                                                        placeholder="Tell us about your home, experience with pets, and why you'd be a great fit for this puppy..."></textarea>
                                                </div>
                                                
                                                <div class="mb-4">
                                                    <label for="contact" class="form-label fw-bold">
                                                        <i class="fas fa-phone-alt me-2"></i> Contact Information
                                                    </label>
                                                    <input type="text" class="form-control" id="contact" name="contact" 
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
                                                <h4 class="mb-3">Only pet lovers can submit adoption requests</h4>
                                                <p>Your account is registered as a {{ auth()->user()->role }} account.</p>
                                                <a href="#" class="btn btn-outline-secondary" id="back-to-puppy">
                                                    <i class="fas fa-arrow-left me-2"></i> Back to Puppy Details
                                                </a>
                                            </div>
                                        @endif
                                    @else
                                        <div class="text-center py-4">
                                            <h4 class="mb-3">You need a pet lover account to adopt this puppy</h4>
                                            <div class="d-grid gap-2">
                                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#loginModal">
                                                    <i class="fas fa-sign-in-alt me-2"></i> Login
                                                </button>
                                                <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#userModal">
                                                    <i class="fas fa-user-plus me-2"></i> Register as Pet Lover
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
                const registrationModal = bootstrap.Modal.getInstance(document.getElementById('userModal'));
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