@extends('layouts.user')

@section('styles')
    @vite('resources/css/styles.css')
@endsection

@section('content')

<!-- Floating decorative shapes -->
<div class="floating-shapes">
    <div class="shape">
        <i class="fas fa-graduation-cap fa-3x" style="color: rgba(240,196,25,0.1);"></i>
    </div>
    <div class="shape">
        <i class="fas fa-heart fa-2x" style="color: rgba(240,196,25,0.1);"></i>
    </div>
    <div class="shape">
        <i class="fas fa-lightbulb fa-2x" style="color: rgba(240,196,25,0.1);"></i>
    </div>
</div>

<div class="container my-5 page-container">
 <!-- Enhanced Welcome Header -->
<div id="guidanceCarousel" class="carousel slide welcome-header position-relative" data-bs-ride="carousel" data-bs-interval="3000" style="min-height: 60vh; background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); overflow: hidden;">
    <!-- Decorative floating shapes -->
    <div class="position-absolute top-0 start-0 w-100 h-100">
        <div class="floating-shape" style="position: absolute; width: 100px; height: 100px; background: rgba(255, 255, 255, 0.1); border-radius: 50%; top: 10%; left: 15%; animation: float 6s ease-in-out infinite;"></div>
        <div class="floating-shape" style="position: absolute; width: 150px; height: 150px; background: rgba(255, 255, 255, 0.05); border-radius: 50%; top: 40%; left: 70%; animation: float 8s ease-in-out infinite alternate;"></div>
        <div class="floating-shape" style="position: absolute; width: 80px; height: 80px; background: rgba(255, 255, 255, 0.08); border-radius: 50%; top: 70%; left: 30%; animation: float 7s ease-in-out infinite;"></div>
    </div>

    <!-- Carousel content -->
    <div class="carousel-inner position-relative w-100 h-100">
        <!-- Slide 1: PROJECT JEREMIAH -->
        <div class="carousel-item active">
            <div class="d-flex flex-column justify-content-center align-items-center text-center h-100">
                <h1 class="welcome-title">PROJECT JEREMIAH</h1>
             <p class="lead mb-0" style="font-size: 1.3rem; max-width: 700px; margin: 0 auto;"><em>"Call unto me, and I will answer thee, and shew thee great and mighty things, which thou knowest not."</em></p>
                <a class="btn btn-success mt-4" href="{{-- {{ route('user.projectJeremiah') }} --}}">Learn More</a>
            </div>
        </div>

        <!-- Slide 2: Guidance Office Services -->
        <div class="carousel-item">
            <div class="d-flex flex-column justify-content-center align-items-center text-center h-100">
                <h1 class="display-3 fw-bold mb-3" style="text-shadow: 2px 2px 8px rgba(0,0,0,0.3);">Guidance Office Services</h1>
                <p class="lead mb-0" style="font-size: 1.3rem; max-width: 700px; margin: 0 auto;">Discover our range of counseling services, academic support programs, and peer mediation.</p>
                <a class="btn btn-primary mt-4" href="{{ route('user.services') }}">Explore Services</a>
            </div>
        </div>

        <!-- Slide 3: e-Hayag -->
        <div class="carousel-item">
            <div class="d-flex flex-column justify-content-center align-items-center text-center h-100">
                <h1 class="display-3 fw-bold mb-3" style="text-shadow: 2px 2px 8px rgba(0,0,0,0.3);">e-Hayag Platform</h1>
                 <p class="lead mb-0" style="font-size: 1.3rem; max-width: 700px; margin: 0 auto;">Your safe and anonymous space to share thoughts and experiences. Express yourself freely and find support.</p>
                <a class="btn btn-primary mt-4" href="{{ route('user.freedomwall.add') }}">Share Anonymously</a>
            </div>
        </div>

        <!-- Slide 4: Emergency Support -->
        <div class="carousel-item">
            <div class="d-flex flex-column justify-content-center align-items-center text-center h-100">
                <h1 class="display-3 fw-bold mb-3" style="text-shadow: 2px 2px 8px rgba(0,0,0,0.3);">Emergency Support</h1>
                <p class="lead mb-0" style="font-size: 1.3rem; max-width: 700px; margin: 0 auto;">Access 24/7 mental health crisis support and emergency resources. You're never alone — help is always here.</p>
                <a class="btn btn-danger mt-4" href="{{ route('user.hotline') }}">Get Help Now</a>
            </div>
        </div>
    </div>

    <!-- Controls -->
    <button class="carousel-control-prev" type="button" data-bs-target="#guidanceCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#guidanceCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>

<!-- Floating animation style -->
<style>
@keyframes float {
    0% { transform: translateY(0px); }
    50% { transform: translateY(-20px); }
    100% { transform: translateY(0px); }
}
</style>


    <!-- Enhanced Card Options -->
    <div class="row justify-content-center g-4">
        <!-- Services -->
        <div class="col-lg-4 col-md-6">
            <div class="card option-card services-card">
                <div class="card-content text-center">
                    <div class="icon-wrapper">
                        <i class="fas fa-hands-helping fa-4x"></i>
                    </div>
                    <h4 class="card-title">Comprehensive Services</h4>
                    <p class="card-description">
                        Discover our range of counseling services, academic support programs, and peer mediation designed to help you thrive in every aspect of your educational journey.
                    </p>
                    <a class="btn card-btn" href="{{ route('user.services') }}">Explore Services</a>
                </div>
            </div>
        </div>

        <!-- e-Hayag -->
        <div class="col-lg-4 col-md-6">
            <div class="card option-card ehayag-card">
                <div class="card-content text-center">
                    <div class="icon-wrapper">
                        <i class="fas fa-comments fa-4x"></i>
                    </div>
                    <h4 class="card-title">e-Hayag Platform</h4>
                    <p class="card-description">
                        Your safe, anonymous digital space to share thoughts, concerns, and experiences. Express yourself freely without judgment in our secure environment.
                    </p>
                    <a class="btn card-btn" href="{{ route('user.freedomwall.add') }}">Share Anonymously</a>
                </div>
            </div>
        </div>

        <!-- Emergency Hotline -->
        <div class="col-lg-4 col-md-6">
            <div class="card option-card emergency-card">
                <div class="card-content text-center">
                    <div class="icon-wrapper">
                        <i class="fas fa-phone-alt fa-4x"></i>
                    </div>
                    <h4 class="card-title">Emergency Support</h4>
                    <p class="card-description">
                        Access 24/7 mental health crisis support and emergency resources. Professional help is always available when you need immediate assistance.
                    </p>
                    <a class="btn card-btn" href="{{ route('user.hotline') }}">Get Help Now</a>
                    </div>
            </div>
        </div>
    </div>

    <!-- Additional motivational section -->
    <div class="text-center mt-5 pt-4">
        <p class="lead" style="color: #e8e8e8; font-style: italic; opacity: 0.8;">
            "Every step forward is progress. Every conversation matters. You're not alone on this journey."
        </p>
    </div>
</div>

@endsection