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
    <div class="welcome-header">
        <h1 class="welcome-title">Welcome to the Guidance Office</h1>
        <p class="welcome-subtitle">
            Your trusted partner in academic success, personal growth, and mental wellness.<br>
            We're here to support every step of your journey with compassion and expertise.
        </p>
    </div>

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




{{-- @section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: 'Hello!',
                text: 'This is a test popup.',
                icon: 'info',
                denyButtonText: 'Next Page',
                cancelButtonText: 'Cancel'
            });
        });
    </script>
@endsection
 --}}

@section('scripts')
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if($randomQuote)
        <script>
            Swal.fire({
                title: '{{ $randomQuote->quote }}',
                text: '{{ $randomQuote->author }}',
                icon: 'success',
                showCancelButton: true,
                /*showDenyButton: true, */
                confirmButtonText: 'Need someone to talk?',
               /*  denyButtonText: 'Need help?',
                cancelButtonText: 'Cancel' */
            }).then((result) => {
                if (result.isConfirmed) { 
                    window.location.href = "{{ route('user.services') }}";
                } else if (result.isDenied) {
                    
                }
            });
        </script>
    @endif
@endsection
