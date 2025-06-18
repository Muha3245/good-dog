<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Dave's Poodles</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .contact-top-bar {
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), 
                        url('https://images.unsplash.com/photo-1586671267731-da2cf3ceeb80?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
            height: 300px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 50px;
        }
        
        .contact-title {
            color: white;
            font-size: 4rem;
            font-weight: 700;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }
        
        .contact-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
            margin-bottom: 30px;
            height: 100%;
        }
        
        .contact-card:hover {
            transform: translateY(-5px);
        }
        
        .contact-icon {
            font-size: 2.5rem;
            color: #6f42c1;
            margin-bottom: 20px;
        }
        
        .map-container {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            height: 400px;
        }
        
        .contact-info-item {
            margin-bottom: 20px;
            padding-left: 30px;
            position: relative;
        }
        
        .contact-info-item i {
            position: absolute;
            left: 0;
            top: 5px;
            color: #6f42c1;
        }
    </style>
</head>
<body>
    @include('search')
    <!-- Top Bar with Puppy Image -->
    <div class="contact-top-bar">
        <h1 class="contact-title">Contact Us</h1>
    </div>

    <div class="container">
        <div class="row mb-5">
            <div class="col-md-6">
                <h2 class="mb-4" style="color: #6f42c1;">Get in Touch</h2>
                <p class="lead">We'd love to hear from you! Whether you're interested in our poodles or have questions about our breeding program, feel free to reach out.</p>
                
                <div class="mt-5">
                    <div class="contact-info-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <h5>Our Location</h5>
                        <p>Davie, FL 33330</p>
                    </div>
                    
                    <div class="contact-info-item">
                        <i class="fas fa-envelope"></i>
                        <h5>Email Us</h5>
                        <p><a href="mailto:Davepoodles@gmail.com">Davepoodles@gmail.com</a></p>
                    </div>
                    
                    <div class="contact-info-item">
                        <i class="fas fa-phone"></i>
                        <h5>Call Us</h5>
                        <p>(954) 123-4567</p>
                    </div>
                    
                    <div class="contact-info-item">
                        <i class="fas fa-clock"></i>
                        <h5>Business Hours</h5>
                        <p>Monday - Friday: 9am - 5pm<br>Saturday: 10am - 2pm<br>Sunday: Closed</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="map-container">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d114584.4320024806!2d-80.33174739999999!3d26.0628669!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x88d9018088981e1f%3A0x8d5e9718aadad5a!2sDavie%2C%20FL%2033330%2C%20USA!5e0!3m2!1sen!2s!4v1713459123456!5m2!1sen!2s" 
                            width="100%" 
                            height="100%" 
                            style="border:0;" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
        
        <div class="row mt-5">
            <div class="col-12">
                <div class="card contact-card p-4">
                    <div class="card-body text-center">
                        <i class="fas fa-paw contact-icon"></i>
                        <h3 class="card-title mb-4">Schedule a Visit</h3>
                        <p class="card-text mb-4">We welcome visits by appointment to meet our poodles and see our facilities. Please contact us to schedule a time that works for you.</p>
                        <a href="mailto:Davepoodles@gmail.com" class="btn btn-primary btn-lg px-4" style="background-color: #6f42c1; border: none;">
                            <i class="fas fa-calendar-alt me-2"></i> Book an Appointment
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @include('footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>