<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Dave's Poodles</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .about-hero {
            background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), 
                        url('https://images.unsplash.com/photo-1594149929911-78975a43d4f5?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
            height: 400px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 50px;
            border-bottom: 5px solid #6f42c1;
        }
        
        .hero-title {
            color: white;
            font-size: 4rem;
            font-weight: 700;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }
        
        .feature-icon {
            font-size: 2.5rem;
            color: #6f42c1;
            margin-bottom: 20px;
        }
        
        .about-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
            margin-bottom: 30px;
            height: 100%;
            background-color: #f8f9fa;
        }
        
        .health-badge {
            background-color: #e9ecef;
            border-radius: 50px;
            padding: 10px 20px;
            margin-right: 10px;
            margin-bottom: 10px;
            display: inline-flex;
            align-items: center;
        }
        
        .health-badge i {
            color: #28a745;
            margin-right: 8px;
            font-size: 1.2rem;
        }
        
        .family-img {
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            max-height: 400px;
            object-fit: cover;
        }
        
        .section-title {
            color: #6f42c1;
            position: relative;
            padding-bottom: 15px;
            margin-bottom: 30px;
        }
        
        .section-title:after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 80px;
            height: 4px;
            background: #6f42c1;
        }
    </style>
</head>
<body>
    @include('search')
    <!-- Hero Section with Breeder Cover Image -->
    <div class="about-hero">
        <h1 class="hero-title">About Dave's Poodles</h1>
    </div>

    <div class="container">
        <!-- Our Story Section -->
        <div class="row mb-5 align-items-center">
            <div class="col-lg-6">
                <h2 class="section-title">Our Story</h2>
                <p class="lead">I'm the breeder behind Dave's Poodles located in Davie, FL. Our dogs are part of our family and are beloved companions.</p>
                <p>All our puppies are socialized with our children, teaching them that the world is a safe place. We offer top-quality Toy and Mini Poodle puppies for all who share the same love and passion as we do for these amazing companions!</p>
                <p>We have breathtaking personalities, amazing temperaments, and we strive to provide the best quality care possible. Our Poodle parents are registered with AKC, tested, and cleared for breed-related genetic conditions.</p>
            </div>
            <div class="col-lg-6">
                <img src="https://images.unsplash.com/photo-1586671267731-da2cf3ceeb80?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" 
                     alt="Dave's Poodles Family" 
                     class="img-fluid family-img">
            </div>
        </div>
        
        <!-- Our Approach Section -->
        <div class="row mb-5">
            <div class="col-12">
                <h2 class="section-title text-center">Our Approach</h2>
                <p class="text-center lead mb-5">We care deeply about each member of our family and are proud to be responsible Poodle breeders.</p>
                
                <div class="row">
                    <div class="col-md-4 mb-4">
                        <div class="about-card p-4 h-100">
                            <div class="text-center">
                                <i class="fas fa-home feature-icon"></i>
                                <h3>Family-Raised</h3>
                                <p>All our dogs are raised in our home and taken care of with high standards. They are very spoiled and love the attention they get.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4 mb-4">
                        <div class="about-card p-4 h-100">
                            <div class="text-center">
                                <i class="fas fa-heart feature-icon"></i>
                                <h3>Temperament First</h3>
                                <p>Each of our poodles is bred for temperament and personality, ensuring they are not only stunning but also deeply loyal and playful.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4 mb-4">
                        <div class="about-card p-4 h-100">
                            <div class="text-center">
                                <i class="fas fa-award feature-icon"></i>
                                <h3>AKC Registered</h3>
                                <p>All our breeding dogs are AKC registered and genetically tested to ensure the healthiest possible puppies.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Health Guarantee Section -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="about-card p-5">
                    <h2 class="section-title">Health & Vaccination</h2>
                    <p class="lead mb-4">We take puppy health seriously with comprehensive care from birth through adoption.</p>
                    
                    <div class="mb-4">
                        <span class="health-badge"><i class="fas fa-syringe"></i> Up-to-date vaccinations</span>
                        <span class="health-badge"><i class="fas fa-shield-alt"></i> 2-year health guarantee</span>
                        <span class="health-badge"><i class="fas fa-stethoscope"></i> Vet-checked before adoption</span>
                        <span class="health-badge"><i class="fas fa-dna"></i> Genetic testing</span>
                        <span class="health-badge"><i class="fas fa-notes-medical"></i> 30-day pet insurance</span>
                        <span class="health-badge"><i class="fas fa-paw"></i> Dewormed regularly</span>
                    </div>
                    
                    <p>All puppies receive age-appropriate vaccinations and are examined by our veterinarian before going to their new homes. We provide complete health records and guidance for ongoing care.</p>
                </div>
            </div>
        </div>
        
        <!-- Our Promise Section -->
        <div class="row">
            <div class="col-lg-6 mb-4">
                <img src="https://images.unsplash.com/photo-1544568100-847a948585b9?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" 
                     alt="Happy Poodle" 
                     class="img-fluid family-img">
            </div>
            <div class="col-lg-6 mb-4">
                <h2 class="section-title">Our Promise</h2>
                <p>We believe in responsible breeding practices that prioritize health, temperament, and breed standards above all else. When you adopt a puppy from Dave's Poodles, you're not just getting a pet - you're gaining a new family member with a lifetime of love to give.</p>
                <p>Our commitment continues even after you take your puppy home. We're always available to offer advice and support throughout your poodle's life.</p>
                
                <div class="mt-4">
                    <a href="/contact" class="btn btn-primary btn-lg px-4" style="background-color: #6f42c1; border: none;">
                        <i class="fas fa-paw me-2"></i> Contact Us Today
                    </a>
                </div>
            </div>
        </div>
    </div>
    @include('footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>