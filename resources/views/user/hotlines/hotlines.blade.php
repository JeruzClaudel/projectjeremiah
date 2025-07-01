@extends('layouts.user')

@section('styles')
    @vite('resources/css/styles.css')
@endsection

@section('content')

<div class="emergency-header text-center page-container" style="min-height: 40vh; background: linear-gradient(135deg, #0a1931 0%, #1c2a4d 50%, #2a3f6b 100%); overflow: hidden; border-radius: 20px; ">
    <!-- Decorative floating shapes -->
    <div class="position-absolute top-0 start-0 w-100 h-100">
        <div class="floating-shape" style="position: absolute; width: 100px; height: 100px; background: rgba(255, 255, 255, 0.1); border-radius: 50%; top: 10%; left: 15%; animation: float 6s ease-in-out infinite;"></div>
        <div class="floating-shape" style="position: absolute; width: 150px; height: 150px; background: rgba(255, 255, 255, 0.05); border-radius: 50%; top: 40%; left: 70%; animation: float 8s ease-in-out infinite alternate;"></div>
        <div class="floating-shape" style="position: absolute; width: 80px; height: 80px; background: rgba(255, 255, 255, 0.08); border-radius: 50%; top: 70%; left: 30%; animation: float 7s ease-in-out infinite;"></div>
    </div>

    <div class="container hero-content text-center position-relative">
        <h1 class="display-3 fw-bold mb-4" style="text-shadow: 2px 2px 8px rgba(0,0,0,0.3);">Emergency Hotlines</h1>
        <p class="lead mb-0 " style="font-size: 1.3rem;">If you or someone you know is in crisis, immediate help is available.
            These resources provide 24/7 support when you need it most.</p>
    </div>
</div>

<!-- Floating animation -->
<style>
@keyframes float {
    0% { transform: translateY(0px); }
    50% { transform: translateY(-20px); }
    100% { transform: translateY(0px); }
}
</style>
<br>

<div class="container mb-5 page-container">
    <div class="danger-alert text-danger">
        <h5><i class="fas fa-exclamation-triangle me-2"></i>In Case of Immediate Danger</h5>
        <p>If you or someone else is in immediate danger, call 911 or go to your nearest emergency room.</p>
    </div>

    <div class="row g-4 page-container">
        @foreach($entries as $entry)
        <div class="col-md-6 col-lg-4">
            <div class="card hotline-card border-{{ $loop->iteration % 2 == 0 ? 'primary' : 'danger' }}">
                <div class="badge">24/7</div>
                <div class="card-body text-center">
                    <i class="fas {{ $entry->icon ?? 'fa-heart' }} text-{{ $loop->iteration % 2 == 0 ? 'primary' : 'danger' }}"></i>
                    <h5 class="card-title mt-2 fw-bold">{{ $entry->name }}</h5>
                    <p class="text-muted mb-1">{{ $entry->description }}</p>
                    <p class="text-muted small mb-2">{{ $entry->email }}</p>
                    <p class="text-danger fw-semibold">{{ $entry->phone_number }}</p>
                    <small class="d-block text-muted">{{ $entry->availability ?? 'Available 24/7' }}</small>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Additional Resources -->
    <div class="mt-5 page-container">
        <div class="additional-resources">
            <h4 class="fw-bold mb-4">Additional Support Resources</h4>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div>
                        <div class="resource-icon bg-light text-primary"><i class="fas fa-book-medical"></i></div>
                        <div class="resource-label">Mental Health First Aid</div>
                        <p class="text-muted">Learn to recognize signs of mental health crises</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div>
                        <div class="resource-icon bg-light text-success"><i class="fas fa-heart"></i></div>
                        <div class="resource-label">Self-Help Resources</div>
                        <p class="text-muted">Apps and tools for managing stress and anxiety</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div>
                        <div class="resource-icon bg-light text-purple"><i class="fas fa-users"></i></div>
                        <div class="resource-label">Support Groups</div>
                        <p class="text-muted">Connect with others who understand your experiences</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
