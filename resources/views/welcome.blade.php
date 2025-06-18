@php
    $allPuppies = App\Helpers\helpers::allPuppies();
    $pureBreedPuppies = App\Helpers\Helpers::pureBreedPuppies();
    $crossBreedPuppies = App\Helpers\Helpers::crossBreedPuppies();
    $breederprofiles = App\Helpers\Helpers::allBreederProfiles();
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Good Dog Search</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #9b4949;
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

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Georgia', serif;
        }

        body {
            background: white;
        }

        /* Top bar */
        .top-bar {
            background:#6b2514;
            color: white;
            padding: 12px 0;
            display: flex;
            justify-content: center;
            gap: 24px;
            font-size: 14px;
        }

        .top-bar a {
            color: white;
            text-decoration: none;
        }

        /* Header with video */
        header {
            position: relative;
            height: 100vh;
            overflow: hidden;
        }

        .video-container {
            width: 100%;
            aspect-ratio: 16/9;
            /* For 16:9 ratio (adjust if needed) */
            overflow: hidden;
        }

        #homeVideo {
            width: 100%;
            height: 100%;
            object-fit: cover;
            /* Prevents stretching, crops if needed */
        }

        .video-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            text-align: center;
            width: 100%;
            padding: 0 20px;
        }

        .video-text h1 {
            font-size: 3rem;
            margin-bottom: 10px;
        }

        .video-text h2 {
            font-size: 4rem;
            margin-bottom: 20px;
        }

        .video-text p {
            max-width: 700px;
            margin: 0 auto;
            font-size: 1.2rem;
        }

        /* Search Container */
        .navbar {
            background-color: white;
            box-shadow: var(--shadow-sm);
            height: 100px;
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
            margin: 0 auto;
        }

        .search-input {
            width: 100%;
            padding: 0.75rem 1rem;
            padding-right: 2.5rem;
            border: 1px solid var(--border-color);
            border-radius: var(--rounded-md);
            font-size: 0.9rem;
            transition: var(--transition);
        }

        .search-input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 2px rgba(var(--primary-rgb), 0.1);
        }

        .search-icon {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-light);
            cursor: pointer;
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
            margin-top: 0.25rem;
            border: 1px solid var(--border-color);
            border-top: none;
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

        /* Puppy Result Items */
        .puppy-result {
            display: flex;
            align-items: center;
            padding: 0.5rem;
            border-radius: var(--rounded-sm);
            cursor: pointer;
            transition: var(--transition);
            margin-bottom: 0.25rem;
        }

        .puppy-result:hover {
            background-color: rgba(var(--primary-rgb), 0.05);
        }

        .puppy-result-image {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 0.75rem;
        }

        .puppy-result-info {
            flex: 1;
        }

        .puppy-result-name {
            font-size: 0.9rem;
            font-weight: 500;
            margin: 0;
            color: var(--text-dark);
        }

        .puppy-result-meta {
            font-size: 0.75rem;
            margin: 0;
            color: var(--text-light);
        }

        /* Tab Content */
        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        /* Account dropdown */
        .account-area {
            position: relative;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .dropdown-menu {
            position: absolute;
            top: ;
            right: 0;
            background: white;
            width: 200px;
            border-radius: 5px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            display: none;
            z-index: 1001;
        }

        .dropdown-menu a {
            display: block;
            padding: 10px 15px;
            color: #333;
            margin-top: 30px;
            text-decoration: none;
        }

        .dropdown-menu a:hover {
            background: #f5f5f5;
        }

        .divider {
            height: 1px;
            background: #eee;
            margin: 5px 0;
        }

        /* Blur overlay */
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(2px);
            display: none;
            z-index: 999;
        }

        /* Breed sections */
        .container {
            max-width: 1200px;
            margin: 80px auto;
            padding: 0 20px;
        }

        .container h1 {
            text-align: center;
            margin-bottom: 40px;
        }

        .breed-section {
            margin-bottom: 60px;
        }

        .breed-section h3 {
            margin-bottom: 10px;
            font-size: 1.5rem;
            color: #2c3e50;
        }

        .breed-section p {
            margin-bottom: 20px;
            color: #7f8c8d;
            line-height: 1.6;
        }

        /* Breed cards grid */
        .breed-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 20px;
        }

        .breed-card {
            background: transparent;
            border-radius: 8px;
            overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .breed-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .breed-card img {
            width: 100%;
            height: 300px;
            object-fit: contain;
            display: block;
            transition: transform 0.3s ease;
        }

        .breed-card:hover img {
            transform: scale(1.05);
        }

        .breed-card p {
            padding: 15px;
            font-weight: 600;
            color: #2c3e50;
            margin: 0;
            text-align: center;
        }
        /* 
        /* Screening Section */
        .screening-section {
            background-color: #510707;
            color: white;
            padding: 80px 0;
        }

        .screening-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            flex-wrap: wrap;
        }

        .screening-left {
            flex: 1;
            min-width: 300px;
            padding-right: 40px;
            margin-bottom: 40px;
        }

        .screening-right {
            flex: 1;
            min-width: 300px;
        }

        .screening-title {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 30px;
            line-height: 1.2;
        }

        .screening-title u {
            text-decoration-thickness: 2px;
        }

        .screening-subtitle {
            font-size: 1.25rem;
            font-weight: 500;
            margin-bottom: 30px;
        }

        .screening-tabs {
            display: flex;
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
            margin-bottom: 20px;
        }

        .screening-tab {
            padding: 15px 25px;
            font-size: 1.1rem;
            font-weight: 500;
            background: none;
            border: none;
            color: white;
            cursor: pointer;
            position: relative;
        }

        .screening-tab.active {
            font-weight: 600;
        }

        .screening-tab.active:after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            width: 100%;
            height: 2px;
            background-color: #ef4444;
        }

        .screening-panel {
            display: none;
            margin-bottom: 30px;
            font-size: 1.1rem;
            line-height: 1.6;
        }

        .screening-panel.active {
            display: block;
        }

        .screening-button {
            display: inline-block;
            background-color: white;
            color: black;
            padding: 12px 24px;
            font-weight: 600;
            border-radius: 4px;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .screening-button:hover {
            background-color: #f0f0f0;
        }

        /* Modal styles */
        .modal-content {
            border-radius: 8px;
            border: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .modal-header {
            border-bottom: none;
            padding-bottom: 0;
            justify-content: center;
        }

        .modal-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #2c3e50;
        }

        .modal-body {
            padding: 1.5rem 2rem;
        }

        .form-label {
            font-weight: 500;
            color: #2c3e50;
        }

        .form-control {
            padding: 12px 15px;
            border-radius: 4px;
        }

        .form-control:focus {
            border-color: #3498db;
            box-shadow: none;
        }

        .btn-login {
            width: 100%;
            padding: 12px;
            background-color: #2563eb;
            border: none;
            font-weight: 500;
        }

        .btn-login:hover {
            background-color: #1d4ed8;
        }

        .forgot-password {
            text-align: center;
            margin: 15px 0 25px;
        }

        .forgot-password a {
            color: #2563eb;
            text-decoration: none;
            font-size: 0.9rem;
        }

        .divider-text {
            display: flex;
            align-items: center;
            color: #7f8c8d;
            font-size: 0.8rem;
        }

        .divider-text::before,
        .divider-text::after {
            content: "";
            flex: 1;
            border-bottom: 1px solid #ddd;
        }

        .divider-text::before {
            margin-right: 10px;
        }

        .divider-text::after {
            margin-left: 10px;
        }

        .btn-join {
            width: 100%;
            padding: 12px;
            background-color: white;
            color: #2c3e50;
            border: 1px solid #ddd;
            font-weight: 500;
            margin-bottom: 10px;
        }

        .btn-join:hover {
            border-color: #2563eb;
            color: #2563eb;
        }

        /* Breeder Modal Styles */
        .modal-breeder .modal-header {
            text-align: center;
            border-bottom: none;
            padding-bottom: 0;
        }

        .modal-breeder .modal-title {
            font-size: 1.5rem;
            font-weight: 600;
        }

        .modal-breeder .modal-body {
            padding: 1.5rem 2rem;
        }

        .breeder-banner {
            text-align: center;
            margin-bottom: 1rem;
        }

        .breeder-banner img {
            height: 60px;
            margin-bottom: 1rem;
        }

        .breeder-banner p {
            color: #666;
            margin-bottom: 1.5rem;
        }

        .btn-breeder {
            width: 100%;
            padding: 12px;
            background-color: #2563eb;
            border: none;
            font-weight: 500;
        }

        .btn-breeder:hover {
            background-color: #1d4ed8;
        }

        .terms-text {
            font-size: 0.85rem;
            color: #666;
            text-align: center;
            margin-top: 1.5rem;
        }

        .terms-text a {
            color: #2563eb;
            text-decoration: none;
        }

        .login-link {
            text-align: center;
            padding: 1.5rem 0;
            border-top: 1px solid #eee;
            margin-top: 1rem;
        }

        /* Responsive adjustments */
        @media (max-width: 900px) {
            .video-text h1 {
                font-size: 2.5rem;
            }

            .video-text h2 {
                font-size: 3rem;
            }

            .slide {
                min-width: calc(50% - 10px);
            }
        }

        @media (max-width: 600px) {
            .video-text h1 {
                font-size: 2rem;
            }

            .video-text h2 {
                font-size: 2.5rem;
            }

            .modal-body {
                padding: 1.5rem;
            }

            .slide {
                min-width: 100%;
            }

            .screening-title {
                font-size: 2rem;
            }

            .screening-tab {
                padding: 12px 15px;
                font-size: 1rem;
            }

        }

        .border-stone-700 {
            border-color: #283e52 !important;
        }

        .border-light-blue {
            border-color: #8CD0FF !important;
        }

        .breeder-slider-section {
            background-color: #f8f9fc;
            border-radius: 10px;
            padding: 40px 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .breeder-title {
            font-size: 2rem;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 20px;
        }

        .breeder-description {
            font-size: 1rem;
            color: #4a5568;
            margin-bottom: 20px;
            line-height: 1.6;
        }

        .breeder-features li {
            font-size: 1rem;
            color: #4a5568;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
        }

        .breeder-features i {
            font-size: 1.2rem;
        }

        .breeder-image img {
            border-radius: 10px;
            box-shadow: var(--shadow-md);
            transition: transform 0.3s ease;
        }

        .breeder-image img:hover {
            transform: scale(1.05);
        }

        .btn-primary {
            background-color: #4e73df;
            border-color: #4e73df;
            font-size: 1rem;
            font-weight: 600;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #375a9e;
        }

       
    </style>
</head>

<body>
    <!-- Top bar -->
    <div class="top-bar">
        <a href="#">Learning Center</a>
        <a href="#">Our Standards</a>
        <a href="#">Contact a Specialist</a>
        @auth
            @if (auth()->user()->role === 'breeder')
                <a href="{{ route('breeders.profile', ['id' => auth()->user()->id]) }}">{{ auth()->user()->name }}</a>
            @else
                <span>{{ auth()->user()->name }}</span>
            @endif
        @else
            <a href="#" data-bs-toggle="modal" data-bs-target="#loginModal">Login</a>
            <a href="#" data-bs-toggle="modal" data-bs-target="#breederModal">User Sign Up</a>
        @endauth

    </div>

    <!-- Hero section -->
    <header>
        <div class="video-container">
            <video muted autoplay loop playsinline id="homeVideo">
                <source src="{{ asset('banner (2).mp4') }}" type="video/mp4">
            </video>
        </div>

        <div class="video-text">
            <h1>Dave poodles</h1>
            <h2>Where love grows</h2>
            <p>Premium quality puppies from responsible breeders! Vet-checked, family-raised pups ready for forever homes. Exclusive access to rare breeds. Health guarantees included. Don't just buy a puppy - welcome a new family member. Reserve your bundle of joy today!</p>
        </div>
    </header>


    @include('search')



    <!-- Overlay for blur effect -->
    <div class="overlay" id="overlay"></div>



    
    @include('partials.breedersection')
    

    <!-- Join Section -->
    <section class="py-5">
        <div class="container">
            <div class="row gx-lg-5">
                <!-- Breeder Column -->
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <div class="h-100 p-4 p-lg-5 border-start border-5 border-stone-700 rounded-end">
                        <div class="d-flex flex-column h-100">
                            <h3 class="mb-4">Are you a responsible breeder?</h3>
                            <div class="row flex-grow-1 align-items-center">
                                <div class="col-md-8 mb-4 mb-md-0">
                                    <p class="mb-4">
                                        We'd love to talk to you about joining our community of Good Breeders.
                                        We list only breeders screened for quality and help educated potential
                                        dog owners connect with them directly.
                                    </p>
                                    @auth
                                        @if (auth()->user()->role === 'breeder')
                                            <a class="d-inline-flex align-items-center text-decoration-none border-bottom border-dark pb-1"
                                                href="{{ route('breeders.profile', ['id' => auth()->user()->id]) }}"
                                                title="View your breeder profile">
                                                View your breeder profile
                                                <svg class="ms-2" width="16" height="16" viewBox="0 0 16 16"
                                                    fill="currentColor">
                                                    <path d="M8 0L6.59 1.41 12.17 7H0v2h12.17l-5.58 5.59L8 16l8-8-8-8z" />
                                                </svg>
                                            </a>
                                        @else
                                            <a class="d-inline-flex align-items-center text-decoration-none border-bottom border-dark pb-1"
                                                href="#" title="Join as breeder" data-bs-toggle="modal"
                                                data-bs-target="#breederModal">
                                                Join as breeder
                                                <svg class="ms-2" width="16" height="16" viewBox="0 0 16 16"
                                                    fill="currentColor">
                                                    <path d="M8 0L6.59 1.41 12.17 7H0v2h12.17l-5.58 5.59L8 16l8-8-8-8z" />
                                                </svg>
                                            </a>
                                        @endif
                                    @else
                                        <a class="d-inline-flex align-items-center text-decoration-none border-bottom border-dark pb-1"
                                            href="#" title="Join as breeder" data-bs-toggle="modal"
                                            data-bs-target="#breederModal">
                                            Join as breeder
                                            <svg class="ms-2" width="16" height="16" viewBox="0 0 16 16"
                                                fill="currentColor">
                                                <path d="M8 0L6.59 1.41 12.17 7H0v2h12.17l-5.58 5.59L8 16l8-8-8-8z" />
                                            </svg>
                                        </a>
                                    @endauth
                                </div>
                                <div class="col-md-4 text-center text-md-end">
                                    <svg viewBox="0 0 145 199" width="120" class="img-fluid"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <defs>
                                            <path
                                                d="M2.261 28.006c0 6.153 3.754 11.417 9.074 13.594a33.999 33.999 0 0 0-2.472 14.276c.005.151.015.298.024.448a34.114 34.114 0 0 0 .103 1.432c.027.288.058.573.092.854.018.156.037.314.057.469.041.298.086.592.133.883.02.124.039.251.06.374.072.412.148.82.234 1.219l.009.039c.083.39.173.775.267 1.157.028.113.059.225.088.338.073.285.147.57.226.851l.104.363a60.403 60.403 0 0 0 .687 2.204l.028.083c.59 1.765 1.257 3.55 1.944 5.487-.151.209-.072.621.171 1.174-.185.271 13.489 17.635 14.295 17.611.486.527.772.833.772.833a3.23 3.23 0 0 1 .109.816c0 4.951-3.261 5.402-3.261 19.988 0 .912.054 1.832.138 2.753l-.046-.033c0 3.961 7.546 54.275 6.926 54.275-5.41 0-10.988 1.892-11.872 6.005-1.148 5.341 4.386 6.08 9.796 6.08 3.382 0 12.371-4.197 12.371-4.197s1.543-6.443 2.434-14.326c.435-3.851 1.344-10.093 2.159-16.075.434.234.874.456 1.315.672l.293.143a41.732 41.732 0 0 0 1.439.653c.447.191.899.373 1.353.546.062.023.122.048.182.07.489.184.98.357 1.476.519l.056.017c1.04.338 2.097.627 3.171.864l.003.002c1.086.241 2.188.429 3.304.563-.013.227 22.788 20.781 24.164 21.854l.014.012a35.557 35.557 0 0 0 2.8 1.976c.027.018.053.036.08.052.456.288.919.565 1.389.833l.127.073a34.4 34.4 0 0 0 1.38.736c.061.031.122.064.183.094.448.225.904.436 1.363.642.08.036.161.075.242.11.44.194.887.374 1.337.549.103.04.204.083.307.122.432.163.868.314 1.308.46.125.041.248.087.374.128.42.134.846.257 1.274.376.146.041.292.087.441.126.411.109.827.204 1.242.298.169.037.333.082.503.117.403.085.812.155 1.221.226.185.033.366.071.553.1.404.063.812.111 1.222.161.192.024.382.053.576.074.426.044.857.073 1.288.102l.102.008c-3.613 1.869-7.135 3.866-8.393 5.136-1.194 1.207-1.904 3.149-2.324 5.028-.662 2.961 1.387 5.837 4.365 6.245 3.581.491 8.275.79 11.195-.369 5.237-2.077 13.2-9.479 13.2-9.479l9.415-6.946c7.987-5.892 12.254-15.64 11.193-25.572l-1.032-9.662c0-14.14-9.432-27.748-19.94-32.141-9.806-4.101-29.574-15.256-33.613-20.804-8.835-12.137-13.424-20.556-13.424-20.556s1.566-10.297 2.167-16.706C77.544 35.835 60.811 20.61 42.318 20.61a33.11 33.11 0 0 0-12.522 2.452C25.2 13.991 11.155.943 4.504.943c-8.016 0-2.243 18.964-2.243 27.063"
                                                id="a"></path>
                                            <path
                                                d="M2.261 28.006c0 6.153 3.754 11.417 9.074 13.594a33.999 33.999 0 0 0-2.472 14.276c.005.151.015.298.024.448a34.114 34.114 0 0 0 .103 1.432c.027.288.058.573.092.854.018.156.037.314.057.469.041.298.086.592.133.883.02.124.039.251.06.374.072.412.148.82.234 1.219l.009.039c.083.39.173.775.267 1.157.028.113.059.225.088.338.073.285.147.57.226.851l.104.363a60.403 60.403 0 0 0 .687 2.204l.028.083c.59 1.765 1.257 3.55 1.944 5.487-.151.209-.072.621.171 1.174-.185.271 13.489 17.635 14.295 17.611.486.527.772.833.772.833a3.23 3.23 0 0 1 .109.816c0 4.951-3.261 5.402-3.261 19.988 0 .912.054 1.832.138 2.753l-.046-.033c0 3.961 7.546 54.275 6.926 54.275-5.41 0-10.988 1.892-11.872 6.005-1.148 5.341 4.386 6.08 9.796 6.08 3.382 0 12.371-4.197 12.371-4.197s1.543-6.443 2.434-14.326c.435-3.851 1.344-10.093 2.159-16.075.434.234.874.456 1.315.672l.293.143a41.732 41.732 0 0 0 1.439.653c.447.191.899.373 1.353.546.062.023.122.048.182.07.489.184.98.357 1.476.519l.056.017c1.04.338 2.097.627 3.171.864l.003.002c1.086.241 2.188.429 3.304.563-.013.227 22.788 20.781 24.164 21.854l.014.012a35.557 35.557 0 0 0 2.8 1.976c.027.018.053.036.08.052.456.288.919.565 1.389.833l.127.073a34.4 34.4 0 0 0 1.38.736c.061.031.122.064.183.094.448.225.904.436 1.363.642.08.036.161.075.242.11.44.194.887.374 1.337.549.103.04.204.083.307.122.432.163.868.314 1.308.46.125.041.248.087.374.128.42.134.846.257 1.274.376.146.041.292.087.441.126.411.109.827.204 1.242.298.169.037.333.082.503.117.403.085.812.155 1.221.226.185.033.366.071.553.1.404.063.812.111 1.222.161.192.024.382.053.576.074.426.044.857.073 1.288.102l.102.008c-3.613 1.869-7.135 3.866-8.393 5.136-1.194 1.207-1.904 3.149-2.324 5.028-.662 2.961 1.387 5.837 4.365 6.245 3.581.491 8.275.79 11.195-.369 5.237-2.077 13.2-9.479 13.2-9.479l9.415-6.946c7.987-5.892 12.254-15.64 11.193-25.572l-1.032-9.662c0-14.14-9.432-27.748-19.94-32.141-9.806-4.101-29.574-15.256-33.613-20.804-8.835-12.137-13.424-20.556-13.424-20.556s1.566-10.297 2.167-16.706C77.544 35.835 60.811 20.61 42.318 20.61a33.11 33.11 0 0 0-12.522 2.452C25.2 13.991 11.155.943 4.504.943c-8.016 0-2.243 18.964-2.243 27.063"
                                                id="c"></path>
                                        </defs>
                                        <g fill="none" fill-rule="evenodd">
                                            <path
                                                d="M83.114 29.835c0 8.099-6.565 14.663-14.664 14.663-8.1 0-14.663-6.564-14.663-14.663S74.272 1.25 82.37 1.25c8.098 0 .743 20.486 .743 28.585"
                                                fill="#283e52"></path>
                                            <path
                                                d="M78.595 28.568c0 7.176-3.875 10.791-9.265 10.791-2.29 0-8.866-6.79-9.762-11.284-1.054-5.287 13.636-19.028 19.027-19.028 5.39 0 0 10.382 0 19.521"
                                                fill="#FFF"></path>
                                            <path
                                                d="M142.644 154.608l-1.031-9.661v-.001c0-14.14-9.433-27.748-19.941-32.141-9.806-4.1-29.574-15.255-33.613-20.803-8.835-12.137-13.424-20.556-13.424-20.556s1.567-10.296 2.167-16.706c1.742-18.598-14.991-33.824-33.484-33.824-4.429 0-8.653.877-12.522 2.454C26.2 14.297 12.156 1.25 5.504 1.25c-8.016 0-2.242 18.963-2.242 27.062 0 6.153 3.753 11.418 9.072 13.594a34.022 34.022 0 0 0-2.471 14.276c.006.153.015.299.023.448a34.485 34.485 0 0 0 .104 1.433c.027.288.057.572.092.854.018.156.037.313.057.468.041.298.086.592.133.884.02.124.039.25.06.374.072.41.149.819.234 1.219l.009.038c.083.39.173.775.267 1.158l.088.338c.073.285.149.569.227.852l.103.36a52.524 52.524 0 0 0 .348 1.156c.11.35.223.7.34 1.05.009.026.017.055.027.082.59 1.765 1.257 3.55 1.944 5.487-.151.21-.072.621.171 1.174-.185.271 13.489 17.636 14.295 17.612.487.526.773.832.773.832a3.393 3.393 0 0 1 .108.816c0 4.95-3.262 5.401-3.262 19.989 0 .912.055 1.83.139 2.752l-.046-.034c0 3.962 7.546 54.276 6.926 54.276-5.41 0-10.988 1.892-11.872 6.006-1.148 5.34 4.386 6.078 9.796 6.078 3.382 0 12.371-4.196 12.371-4.196s1.544-6.442 2.434-14.324c.435-3.853 1.344-10.094 2.16-16.076.433.233.873.456 1.314.672l.293.142c.444.214.893.42 1.346.614l.093.04c.448.192.899.373 1.353.546l.183.07c.488.183.979.356 1.475.517l.056.018c1.04.339 2.098.627 3.171.865h.003c.799.179 1.609.317 2.425.437l.01.814c0 4.125 2.079 23.181 5.333 33.595-5.387.077-9.295 3.67-9.732 6.279-1.099 6.552 4.505 5.607 9.959 5.607s10.35-2.092 10.938-5.607c.187-1.113 2.199-11.758 4.21-22.512 2.314 2.066 3.983 3.539 4.324 3.807l.015.01a34.238 34.238 0 0 0 1.413 1.05 35.97 35.97 0 0 0 2.856 1.81c.043.024.085.05.127.075.454.256.915.5 1.38.736.061.03.122.064.183.094.448.224.903.436 1.362.642l.243.11c.44.193.887.373 1.337.548.103.04.205.083.307.122.432.162.868.314 1.308.46.125.042.248.088.374.128.421.135.846.257 1.274.376.147.04.292.087.441.125.411.11.827.204 1.244.3.167.038.332.08.501.116.403.085.812.156 1.221.227.185.031.367.07.552.099.404.064.814.113 1.223.16.192.025.383.056.576.076.427.045.857.073 1.288.1l.103.01c-3.615 1.868-7.136 3.865-8.394 5.136-1.194 1.207-1.903 3.148-2.324 5.026-.663 2.963 1.387 5.839 4.365 6.246 3.581.49 8.274.79 11.195-.368 5.238-2.077 13.2-9.478 13.2-9.478l9.416-6.947c7.986-5.892 12.253-15.64 11.192-25.573"
                                                fill="#283e52"></path>
                                            <g>
                                                <g transform="translate(1 .377)">
                                                    <mask id="b" fill="#fff">
                                                        <use xlink:href="#a"></use>
                                                    </mask>
                                                    <path
                                                        d="M124.783 201.665c0 11.783-9.331 21.335-20.842 21.335s-20.842-9.552-20.842-21.335c0-11.783 9.33-21.335 20.842-21.335 11.51 0 20.842 9.552 20.842 21.335"
                                                        fill="#FFF" mask="url(#b)"></path>
                                                </g>
                                                <g transform="translate(1 .377)">
                                                    <mask id="d" fill="#fff">
                                                        <use xlink:href="#c"></use>
                                                    </mask>
                                                    <path
                                                        d="M146.162 112.88c0 16.697-13.222 30.233-29.534 30.233-16.31 0-29.532-13.536-29.532-30.232 0-16.697 13.221-30.232 29.532-30.232 16.312 0 29.534 13.535 29.534 30.232"
                                                        fill="#FFF" mask="url(#d)"></path>
                                                </g>
                                            </g>
                                            <g>
                                                <path
                                                    d="M30.956 23.188l-.21.09C26.104 14.208 12.136 1.25 5.506 1.25c-8.017 0-2.242 18.961-2.242 27.06 0 6.149 3.748 11.41 9.06 13.588a34.121 34.121 0 0 0-2.434 10.95c-.005.099-.012.196-.018.294-.023.53-.04 1.062-.04 1.596 0 .494.013.973.03 1.443.006.153.016.298.024.447.017.318.037.632.06.94l.044.493c.028.289.06.573.093.855.02.156.037.313.06.468.04.298.085.592.133.884.02.124.038.25.06.374.072.41.15.818.236 1.218l.01.039c.084.39.175.775.27 1.158.028.113.058.225.087.338a48.561 48.561 0 0 0 .593 2.07c.03.1.063.2.093.299.111.35.226.698.343 1.048.01.027.018.055.027.082.597 1.766 1.271 3.55 1.966 5.489-.154.209-.074.62.171 1.172-.188.272-.367.55-.534.84a16.451 16.451 0 0 0-1.396 3.072h22.038c1.873 0 4.447-9.144 4.648-25.684.15-12.457-5.282-23.825-7.931-28.596"
                                                    fill="#FFF"></path>
                                                <path
                                                    d="M142.644 154.608c1.589-20.518-10.464-37.41-20.972-41.803-9.806-4.1-29.574-15.255-33.613-20.803-8.835-12.137-13.424-20.556-13.424-20.556s1.567-10.296 2.167-16.706c1.742-18.598-14.991-33.824-33.484-33.824-4.429 0-8.653.877-12.522 2.454C26.2 14.297 12.156 1.25 5.504 1.25c-8.016 0-2.243 18.963-2.243 27.062 0 6.153 3.754 11.418 9.073 13.594a34.023 34.023 0 0 0-2.471 14.276c.006.153.015.299.023.448a34.485 34.485 0 0 0 .104 1.433c.027.288.057.572.092.854.018.156.037.313.057.467.041.299.086.593.133.885.02.124.039.25.06.374.072.41.149.819.234 1.219l.009.038c.083.39.173.775.267 1.158l.088.338c.072.285.148.569.227.852l.103.36a52.524 52.524 0 0 0 .348 1.156c.11.35.223.7.34 1.05.009.026.017.055.027.082.59 1.765 1.257 3.55 1.944 5.487-.151.21-.072.621.171 1.174-.185.271 13.489 17.635 14.295 17.612.487.526.773.832.773.832a3.393 3.393 0 0 1 .108.816c0 4.95-3.262 5.401-3.262 19.989 0 .912.055 1.83.139 2.752l-.046-.034c0 3.962 7.546 54.276 6.926 54.276-5.41 0-10.988 1.892-11.872 6.006-1.148 5.34 4.386 6.078 9.796 6.078 3.382 0 12.371-4.196 12.371-4.196s1.544-6.442 2.434-14.324c.435-3.853 1.344-10.094 2.16-16.076.433.233.873.456 1.314.672l.293.142c.444.214.893.42 1.346.614l.093.04a35.724 35.724 0 0 0 1.536.615c.488.184.979.357 1.475.518l.056.018c1.04.339 2.098.626 3.171.865h.003c1.086.242 2.188.43 3.304.564-.013.227 22.788 20.78 24.163 21.856a34.238 34.238 0 0 0 1.428 1.06 35.97 35.97 0 0 0 2.856 1.81c.043.024.085.05.127.075.454.256.915.5 1.38.736.061.03.122.064.183.094.448.224.903.436 1.362.64.081.038.162.076.243.112.44.193.887.373 1.337.548.103.04.205.083.307.122.432.162.868.314 1.308.46.125.042.248.088.374.128.421.135.846.257 1.274.376.147.04.292.087.441.125.411.11.827.204 1.243.3.168.038.333.08.502.116.403.084.812.156 1.221.227.185.031.367.07.552.099.404.064.814.113 1.223.16.192.025.383.056.576.076.427.045.857.073 1.288.1l.103.01c-3.615 1.868-7.136 3.865-8.394 5.136-1.194 1.207-1.903 3.148-2.324 5.026-.662 2.963 1.387 5.839 4.365 6.246 3.581.49 8.274.79 11.195-.368 5.238-2.077 13.2-9.478 13.2-9.478l9.416-6.947c7.986-5.892 10.006-10.263 11.192-25.573z"
                                                    stroke="#283e52" stroke-width="2.5"></path>
                                                <path
                                                    d="M25.328 96.445s41.43 13.128 57.245-15.923M59.514 142.05c-.014.229.12 9.74.12 9.973 0 4.125 2.08 23.18 5.333 33.594-5.388.078-9.295 3.67-9.732 6.28-1.099 6.55 4.505 5.606 9.96 5.606 5.453 0 10.35-2.092 10.937-5.606.326-1.951 6.255-33.135 7.967-42.95"
                                                    stroke="#FFF" stroke-width="2.5"></path>
                                                <path
                                                    d="M28.28 51.87a2.95 2.95 0 1 1-5.901-.002 2.95 2.95 0 0 1 5.9.001"
                                                    fill="#283e52"></path>
                                                <path
                                                    d="M58.443 51.87a2.95 2.95 0 1 1-5.901-.002 2.95 2.95 0 0 1 5.9.001"
                                                    fill="#FFF"></path>
                                                <path
                                                    d="M12.295 74.396c5.741-9.968 23.856-8.552 29.361-8.388 5.506.165 29.815-2.038 29.992 11.413.176 13.454-13.41 14.966-22.595 12.951-7.099-1.558-8.497-3.072-8.497-3.072s-3.785 4.177-15.862 3.876c-7.883-.199-18.876-5.535-12.399-16.78"
                                                    fill="#283e52"></path>
                                                <path
                                                    d="M42.172 68.324h-4.965a2.614 2.614 0 0 1-2.554-3.17l.273-1.248a2.614 2.614 0 0 1 2.553-2.057H41.9c1.228 0 2.292.857 2.553 2.057l.272 1.248a2.613 2.613 0 0 1-2.553 3.17"
                                                    fill="#FFF"></path>
                                                <path
                                                    d="M26.408 25.574C24.474 19.245 11.9 7.99 6.938 7.99c-5.574 0-.51 14.101-.51 19.675 0 4.676 3.178 10.258 7.492 11.937a33.08 33.08 0 0 1 12.488-14.028"
                                                    fill="#283e52"></path>
                                            </g>
                                        </g>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Shelter Column -->
                <div class="col-lg-6">
                    <div class="h-100 p-4 p-lg-5 border-start border-5 border-light-blue rounded-end">
                        <div class="d-flex flex-column h-100">
                            <h3 class="mb-4">Are you a shelter or rescue?</h3>
                            <div class="row flex-grow-1 align-items-center">
                                <div class="col-md-8 mb-4 mb-md-0">
                                    <p class="mb-4">
                                        We'd love to talk to you about joining our community of Good Shelters & Rescues.
                                        We connect you with educated potential new owners to help find great, forever
                                        homes for your dogs in need.
                                    </p>
                                    <a class="d-inline-flex align-items-center text-decoration-none border-bottom border-dark pb-1"
                                        href="/join-as-shelter-or-rescue"
                                        title="Learn more about breeders on Good Dog">
                                        Learn More
                                        <svg class="ms-2" width="16" height="16" viewBox="0 0 16 16"
                                            fill="currentColor">
                                            <path d="M8 0L6.59 1.41 12.17 7H0v2h12.17l-5.58 5.59L8 16l8-8-8-8z" />
                                        </svg>
                                    </a>
                                </div>
                                <div class="col-md-4 text-center text-md-end">
                                    <svg viewBox="0 0 188 190" width="120" class="img-fluid"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <defs>
                                            <path id="a-pup-shelter" d="M.456.174h24.378V40H.456z"></path>
                                        </defs>
                                        <g fill="none" fill-rule="evenodd">
                                            <g transform="translate(46 136.392)">
                                                <mask id="b-pup-shelter" fill="#fff">
                                                    <use xlink:href="#a-pup-shelter"></use>
                                                </mask>
                                                <path
                                                    d="M9.013.174l2.038 27.575s-6.122 3.097-8.339 5.315C.494 35.28.046 39.036.786 39.777c.741.74 24.048-.593 24.048-.593V5.562"
                                                    fill="#8CD0FF" mask="url(#b-pup-shelter)"></path>
                                            </g>
                                            <path
                                                d="M44.634 70.401c12.965 0 23.475-13.182 23.475-26.146 0-12.966-10.51-23.476-23.475-23.476-12.965 0-23.029 10.518-23.475 23.476C20.952 50.255 0 75.686 0 75.686s.34 11.728 6.661 18.05l3.587-4.373 3.851 8.591 4.262-5.764 5.22 5.764 4.38-5.444 6.093 4.068 3.471-6.604 4.167 4.166 2.942-23.74z"
                                                fill="#8CD0FF"></path>
                                            <path
                                                d="M41.723.598l-2.652 25.17 18.482-.777s-1.107-5.25-4.676-11.808S41.723.598 41.723.598"
                                                fill="#8CD0FF"></path>
                                            <path
                                                d="M21.46 8.738l3.195 25.107 17.81-4.999s-2.282-4.854-7.26-10.419c-4.979-5.564-13.746-9.689-13.746-9.689M136.284 71.368s18.549-.572 20.326-14.794c1.124-8.995-1.387-17.912-3.384-23.25-.697-1.865 1.609-3.386 3.044-2.006a19.588 19.588 0 0 1 2.198 2.528c4.427 6.006 9.203 17.466 9.203 25.521 0 15.011-6.512 23.467-6.512 23.467l-24.875-11.466z"
                                                fill="#8CD0FF"></path>
                                            <path
                                                d="M58.185 155.196l7.982 9.413 9.414-9.413 9.116 9.413 9.413-9.413 9.413 9.413 9.413-9.413 9.117 9.413 9.413-9.413 9.414 9.413 9.413-9.413 9.116 9.413 9.413-9.413 9.413 9.413 9.413-9.413s.648-17.846-5.563-38.858c-9.196-31.106-26.66-47.714-50.083-44.607-23.423 3.108-31.37-.277-40.478-8.293-13.022-11.463-26.28-30.43-26.28-30.43l-20.61 37.393S56.2 80.534 54.02 91.44c-5.707 28.54-9.797 40.984-8.02 59.155 1.539 15.728 2.266 14.016 2.266 14.016l9.92-9.415z"
                                                fill="#8CD0FF"></path>
                                            <path
                                                d="M41.723.598s8.842 16.243 7.25 25.049M53.716 87.51s22.04 5.684 41.43-23.49"
                                                stroke="#FFF" stroke-width="2.5"></path>
                                            <path
                                                d="M13.414 78.692H7.291a3.057 3.057 0 0 1 0-6.111h6.123a3.056 3.056 0 0 1 0 6.111M55.03 48.071l-2.745-2.745-2.658 2.745-2.744-2.745-2.744 2.745-2.745-2.745-2.657 2.745-2.745-2.745-2.744 2.745-4.807-4.808-.025.026 2.441-2.293 2.327 2.744 2.744-2.744 2.658 2.744 2.745-2.744 2.744 2.744 2.744-2.744 2.658 2.744 2.744-2.744 2.745 2.744z"
                                                fill="#FFF"></path>
                                            <path
                                                d="M167.67 153.552l6.215 8.302s-7.401 3.055-9.327 4.98c-1.927 1.927-2.691 5.459-1.903 6.248.79.79 25.012-.963 25.012-.963l-.018-16.923"
                                                fill="#8CD0FF"></path>
                                        </g>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Screening Section -->
<section class="screening-section">
    <div class="screening-content">
        <div class="screening-left">
            <h2 class="screening-title">
                We <u>screen</u> every member of our community for <u>quality</u>
                and make their practices transparent.
            </h2>
        </div>
        <div class="screening-right">
            <h5 class="screening-subtitle">Why it's important.</h5>

            <div class="screening-tabs">
                <button class="screening-tab active" data-tab="health">Health</button>
                <button class="screening-tab" data-tab="behavior">Behavior</button>
                <button class="screening-tab" data-tab="welfare">Welfare</button>
            </div>

            <div class="screening-panel active" id="health-panel">
                <p>Members of our community prioritize the well-being of their dogs above all else. Good Breeders
                    are passionate about the health of their dogs, providing necessary care to give them the best
                    chance at a long and healthy life.</p>
            </div>

            <div class="screening-panel" id="behavior-panel">
                <p>Our partners do their best to make sure their dogs comfortably transition into your home. From
                    playing with enrichment toys to proper socialization, they work hard to ensure each dog has a
                    shot at a well-adjusted life.</p>
            </div>

            <div class="screening-panel" id="welfare-panel">
                <p>Irresponsible sources lead to inhumane treatment of dogs. Together, we can put an end to
                    irresponsible practices, and give all dogs the happy, healthy, belly rub-filled lives they
                    deserve.</p>
            </div>
        </div>
    </div>
</section>

    <section class="breeder-slider-section py-5" style="background-color: #f8f9fa;">
        <div class="container">
            <div class="row align-items-center">
                <!-- Left Side: Breeder Info -->
                <div class="col-lg-6">
                    <div class="breeder-info mb-5">
                        <h2 class="breeder-title mb-4" style="color: #572212; font-weight: 700;">Dave's Poodles</h2>
                        <p class="breeder-description lead mb-4">
                            Family-owned poodle breeder specializing in healthy, well-socialized Standard and Miniature Poodles. Our puppies are raised with love in a home environment.
                        </p>
                        
                        <div class="health-guarantee mb-4 p-4" style="background-color: #e9ecef; border-radius: 10px;">
                            <h5 class="mb-3" style="color: #572212;"><i class="fas fa-heartbeat me-2"></i> Puppy Health Guarantee</h5>
                            <ul class="breeder-features list-unstyled">
                                <li class="mb-2"><i class="fas fa-shield-alt text-success me-2"></i> 2-year genetic health guarantee</li>
                                <li class="mb-2"><i class="fas fa-syringe text-success me-2"></i> Up-to-date vaccinations</li>
                                <li class="mb-2"><i class="fas fa-stethoscope text-success me-2"></i> Vet-checked before adoption</li>
                                <li class="mb-2"><i class="fas fa-dna text-success me-2"></i> DNA tested parents</li>
                                <li><i class="fas fa-notes-medical text-success me-2"></i> 30-day pet insurance included</li>
                            </ul>
                        </div>
                        
                        <ul class="breeder-features list-unstyled mb-4">
                            <li class="mb-2"><i class="fas fa-certificate text-primary me-2"></i> Licensed Breeder</li>
                            <li class="mb-2"><i class="fas fa-paw text-primary me-2"></i> AKC Registered</li>
                            <li class="mb-2"><i class="fas fa-home text-primary me-2"></i> Accepts Visits by Appointment</li>
                            <li class="mb-2"><i class="fas fa-award text-primary me-2"></i> 15+ Years of Breeding Experience</li>
                            <li><i class="fas fa-star text-primary me-2"></i> 4.9/5 (128 reviews)</li>
                        </ul>
                        
                        <a href="/breederprofile/1" class="btn btn-primary mt-3 px-4 py-2" style="background-color: #572212; border: none;">
                            Visit Profile <i class="fas fa-external-link-alt ms-2"></i>
                        </a>
                    </div>
                </div>
    
                <!-- Right Side: Breeder Cover Image -->
                <div class="col-lg-6">
                    <div class="breeder-image mb-5">
                        <img src="https://images.unsplash.com/photo-1594149929911-78975a43d4f5?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" 
                             alt="Dave's Poodles" 
                             class="img-fluid rounded shadow-lg" 
                             style="border: 5px solid white; box-shadow: 0 10px 20px rgba(0,0,0,0.1);">
                        <div class="text-center mt-3">
                            <span class="badge bg-light text-dark me-2"><i class="fas fa-dog me-1"></i> Standard Poodles</span>
                            <span class="badge bg-light text-dark me-2"><i class="fas fa-dog me-1"></i> Miniature Poodles</span>
                            <span class="badge bg-light text-dark"><i class="fas fa-palette me-1"></i> Various Colors</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer Section -->

    @include('footer')




    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script>
        // Simple dropdown functionality
        const accountArea = document.getElementById('accountArea');
        const dropdownMenu = document.getElementById('dropdownMenu');
        const dropdownIcon = document.getElementById('dropdownIcon');
        const overlay = document.getElementById('overlay');

        // Hover shows dropdown normally
        accountArea.addEventListener('mouseenter', () => {
            if (!dropdownMenu.classList.contains('clicked')) {
                dropdownMenu.style.display = 'block';
            }
        });

        accountArea.addEventListener('mouseleave', () => {
            if (!dropdownMenu.classList.contains('clicked')) {
                dropdownMenu.style.display = 'none';
            }
        });

        // Click shows dropdown with blur and changes icon
        accountArea.addEventListener('click', (e) => {
            e.stopPropagation();

            if (dropdownMenu.classList.contains('clicked')) {
                // Close dropdown
                dropdownMenu.classList.remove('clicked');
                dropdownMenu.style.display = 'none';
                overlay.style.display = 'none';
                dropdownIcon.classList.remove('fa-chevron-up');
                dropdownIcon.classList.add('fa-chevron-down');
            } else {
                // Open dropdown
                dropdownMenu.classList.add('clicked');
                dropdownMenu.style.display = 'block';
                overlay.style.display = 'block';
                dropdownIcon.classList.remove('fa-chevron-down');
                dropdownIcon.classList.add('fa-chevron-up');
            }
        });

        // Close when clicking outside
        document.addEventListener('click', () => {
            if (dropdownMenu.classList.contains('clicked')) {
                dropdownMenu.classList.remove('clicked');
                dropdownMenu.style.display = 'none';
                overlay.style.display = 'none';
                dropdownIcon.classList.remove('fa-chevron-up');
                dropdownIcon.classList.add('fa-chevron-down');
            }
        });

        // Sticky nav on scroll
        window.addEventListener('scroll', () => {
            const stickyNav = document.getElementById('stickyNav');
            const header = document.querySelector('header');

            if (window.scrollY > header.offsetHeight - 100) {
                stickyNav.style.display = 'block';
            } else {
                stickyNav.style.display = 'none';
            }
        });

        // Tab switching
        const tabs = document.querySelectorAll('.tabs div');
        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                tabs.forEach(t => t.classList.remove('active'));
                tab.classList.add('active');
            });
        });

        // Slider functionality
        document.addEventListener('DOMContentLoaded', function() {
            const sliderTrack = document.querySelector('.slider-track');
            const slides = document.querySelectorAll('.slide');
            const dots = document.querySelectorAll('.slider-dot');
            const prevBtn = document.querySelector('.prev-btn');
            const nextBtn = document.querySelector('.next-btn');

            let currentIndex = 0;
            const slideWidth = slides[0].offsetWidth + 20; // width + gap

            function updateSlider() {
                sliderTrack.style.transform = `translateX(-${currentIndex * slideWidth}px)`;

                // Update dots
                dots.forEach((dot, index) => {
                    dot.classList.toggle('active', index === currentIndex);
                });
            }

            // Next button
            nextBtn.addEventListener('click', () => {
                currentIndex = (currentIndex + 1) % slides.length;
                updateSlider();
            });

            // Previous button
            prevBtn.addEventListener('click', () => {
                currentIndex = (currentIndex - 1 + slides.length) % slides.length;
                updateSlider();
            });

            // Dot navigation
            dots.forEach(dot => {
                dot.addEventListener('click', () => {
                    currentIndex = parseInt(dot.dataset.index);
                    updateSlider();
                });
            });

            
            // Check if there are validation errors
            @if ($errors->any())
                // Show the modal if it's not already visible
                var modal = new bootstrap.Modal(document.getElementById('breederModal'));
                modal.show();
            @endif
        });
    </script>
    <script>
        document.querySelector('.newsletter-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const email = this.querySelector('input').value;
            alert(`Thanks for subscribing with ${email}!`);
            this.reset();
        });
    </script>
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
        // Screening tabs functionality
document.addEventListener('DOMContentLoaded', function() {
    const screeningTabs = document.querySelectorAll('.screening-tab');
    const screeningPanels = document.querySelectorAll('.screening-panel');

    screeningTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            // Remove active class from all tabs and panels
            screeningTabs.forEach(t => t.classList.remove('active'));
            screeningPanels.forEach(panel => panel.classList.remove('active'));
            
            // Add active class to clicked tab
            this.classList.add('active');
            
            // Show corresponding panel
            const tabId = this.getAttribute('data-tab');
            document.getElementById(tabId + '-panel').classList.add('active');
        });
    });
});
    </script>
</body>

</html>
