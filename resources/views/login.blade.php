<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Good Dog - Authentication</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #6c63ff;
            --secondary: #f8f9fa;
            --dark: #343a40;
            --light: #f8f9fa;
        }
        
        body {
            background-color: #f5f5f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .auth-container {
            max-width: 900px;
            margin: 5rem auto;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border-radius: 15px;
            overflow: hidden;
        }
        
        .auth-hero {
            background: linear-gradient(135deg, var(--primary), #8a85ff);
            color: white;
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .auth-form-container {
            background: white;
            padding: 3rem;
        }
        
        .nav-tabs .nav-link {
            border: none;
            color: var(--dark);
            font-weight: 500;
            padding: 1rem 2rem;
        }
        
        .nav-tabs .nav-link.active {
            color: var(--primary);
            border-bottom: 3px solid var(--primary);
            background: transparent;
        }
        
        .form-control {
            padding: 12px 15px;
            border-radius: 8px;
            border: 1px solid #e0e0e0;
        }
        
        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.25rem rgba(108, 99, 255, 0.25);
        }
        
        .btn-primary {
            background-color: var(--primary);
            border: none;
            padding: 12px;
            border-radius: 8px;
            font-weight: 500;
        }
        
        .btn-primary:hover {
            background-color: #5a52e0;
        }
        
        .social-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 10px;
            border-radius: 8px;
            font-weight: 500;
        }
        
        .social-btn i {
            margin-right: 10px;
        }
        
        .divider {
            display: flex;
            align-items: center;
            margin: 1.5rem 0;
        }
        
        .divider::before, .divider::after {
            content: "";
            flex: 1;
            border-bottom: 1px solid #e0e0e0;
        }
        
        .divider-text {
            padding: 0 1rem;
            color: #6c757d;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="auth-container">
            <div class="row g-0">
                <!-- Hero Section -->
                <div class="col-md-5 d-none d-md-block">
                    <div class="auth-hero">
                        <h2 class="mb-4">Find your perfect furry companion</h2>
                        <p class="mb-4">Join thousands of happy pet owners who found their perfect match through Good Dog.</p>
                        <div class="features">
                            <div class="d-flex align-items-center mb-3">
                                <i class="fas fa-paw me-3"></i>
                                <span>Trusted breeders</span>
                            </div>
                            <div class="d-flex align-items-center mb-3">
                                <i class="fas fa-shield-alt me-3"></i>
                                <span>Verified profiles</span>
                            </div>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-heart me-3"></i>
                                <span>Happy pets</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Form Section -->
                @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
                <div class="col-md-7">
                    <div class="auth-form-container">
                        <!-- Tab Navigation -->
                        <ul class="nav nav-tabs mb-4" id="authTabs">
                            <li class="nav-item">
                                <a class="nav-link active" id="login-tab" data-bs-toggle="tab" href="#login">Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="register-tab" data-bs-toggle="tab" href="#register">Register</a>
                            </li>
                        </ul>
                        
                        <!-- Tab Content -->
                        <div class="tab-content" id="authTabsContent">
                            <!-- Login Tab -->
                            <div class="tab-pane fade show active" id="login">
                                <form method="post" action="{{ route('loggedin') }}">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="loginEmail" class="form-label">Email address</label>
                                        <input type="email" name="email" class="form-control" id="loginEmail" placeholder="Enter your email">
                                    </div>
                                    <div class="mb-3">
                                        <label for="loginPassword" class="form-label">Password</label>
                                        <input type="password" name="password" class="form-control" id="loginPassword" placeholder="Enter your password">
                                    </div>
                                    <div class="d-flex justify-content-between mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="rememberMe">
                                            <label class="form-check-label" for="rememberMe">Remember me</label>
                                        </div>
                                        <a href="#" class="text-decoration-none">Forgot password?</a>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100 mb-3">Log in</button>
                                    
                                    <div class="divider">
                                        <span class="divider-text">OR CONTINUE WITH</span>
                                    </div>
                                    
                                    <div class="text-center">
                                        <p class="mb-0">Don't have an account? <a href="#" class="text-primary text-decoration-none" onclick="switchToRegister()">Sign up</a></p>
                                    </div>
                                </form>
                            </div>
                            
                            <!-- Register Tab -->
                            <div class="tab-pane fade" id="register">
                                <form id="breederForm" method="POST" action="{{ route('users.store') }}">
                                    @csrf
                                    <div class="row mb-3">
                                        <div class="col-md-6 mb-3 mb-md-0">
                                            <label for="firstName" class="form-label">First Name</label>
                                            <input type="text" class="form-control" name="firstname" id="firstName" placeholder="Jane">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="lastName" class="form-label">Last Name</label>
                                            <input type="text" class="form-control" name="lastname" id="lastName" placeholder="Smith">
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="programName" class="form-label">Program Name</label>
                                        <input type="text" class="form-control" name="programname" id="programName" placeholder="e.g. High Peaks Farm">
                                    </div>

                                    <div class="mb-3">
                                        <label for="country" class="form-label">Country</label>
                                        <select class="form-select" id="country" name="country">
                                            <option value="" selected disabled>Select your country</option>
                                            <option value="United States">United States</option>
                                            <option value="Canada">Canada</option>
                                            <option value="United Kingdom">United Kingdom</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="jane@highpeaksfarm.com">
                                    </div>

                                    <div class="mb-3">
                                        <label for="phone" class="form-label">Phone Number</label>
                                        <input type="tel" class="form-control" id="phone" name="phone" placeholder="+1 (123) 456-7890">
                                    </div>

                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="password" name="password" placeholder="6+ characters">
                                        <input type="hidden" name="role" value="breeder">
                                    </div>

                                    <button type="submit" class="btn btn-primary w-100 mb-3">Create Account</button>
                                    
                                    <div class="terms-text small text-muted mb-3">
                                        <p>By continuing, I agree to Good Dog's <a href="#" class="text-decoration-none">Breeder Code of Ethics</a>,
                                            <a href="#" class="text-decoration-none">Terms of Service</a> and <a href="#" class="text-decoration-none">Privacy Policy</a>.
                                        </p>
                                    </div>
                                    
                                    <div class="text-center">
                                        <p class="mb-0">Already have an account? <a href="#" class="text-primary text-decoration-none" onclick="switchToLogin()">Log in</a></p>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function switchToRegister() {
            const registerTab = new bootstrap.Tab(document.getElementById('register-tab'));
            registerTab.show();
        }
        
        function switchToLogin() {
            const loginTab = new bootstrap.Tab(document.getElementById('login-tab'));
            loginTab.show();
        }
        
        // Form validation would go here
        document.getElementById('breederForm').addEventListener('submit', function(e) {
            // Add validation logic here
        });
    </script>
</body>
</html>