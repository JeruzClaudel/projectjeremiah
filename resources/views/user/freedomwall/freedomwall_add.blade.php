@extends('layouts.user')

@section('styles')
    @vite('resources/css/styles.css')
@endsection

@section('content')

<!-- Hero Section -->
<div class="emergency-header text-center page-container" style="min-height: 40vh; background: linear-gradient(135deg, #0a1931 0%, #1c2a4d 50%, #2a3f6b 100%); overflow: hidden; border-radius: 30px;">
    <!-- Decorative floating shapes -->
    <div class="position-absolute top-0 start-0 w-100 h-100">
        <div class="floating-shape" style="position: absolute; width: 100px; height: 100px; background: rgba(255, 255, 255, 0.1); border-radius: 50%; top: 10%; left: 15%; animation: float 6s ease-in-out infinite;"></div>
        <div class="floating-shape" style="position: absolute; width: 150px; height: 150px; background: rgba(255, 255, 255, 0.05); border-radius: 50%; top: 40%; left: 70%; animation: float 8s ease-in-out infinite alternate;"></div>
        <div class="floating-shape" style="position: absolute; width: 80px; height: 80px; background: rgba(255, 255, 255, 0.08); border-radius: 50%; top: 70%; left: 30%; animation: float 7s ease-in-out infinite;"></div>
    </div>

    <div class="container hero-content text-center position-relative">
       <h1 class="display-5 fw-bold text-gold e-hayag-title">e-Hayag</h1>
        <p class="lead welcome-subheading">
            Welcome to e-Hayag – your safe space to express your thoughts, feelings, and experiences without fear of judgment.
            Here you may pour out whatever is in your heart – joy, sadness, hope, frustration, gratitude, confusion, or anything in between.
            Whether you're working through a challenge, carrying a heavy burden, having a bad day, revisiting past experiences, or simply reflecting on your current situation, this is your personal corner of comfort and honesty.
        </p>
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


<!-- Call to Action -->
<div class="text-center mt-5">
    <div class="top-bar mb-3">
        <h2 class="navigation-title text-gold"><em>Ready to express your thoughts?</h2></em>
    </div>
    <a href="{{ route('user.freedomwall.create') }}" class="btn btn-primary px-4 py-2">
        <i class="fas fa-heart me-2"></i> Click Here
    </a>
 
</div>


<!-- How to Use Section -->
<div class="container mt-5 page-container">
    <div class="card info-card p-4 page-container">
        <h4 class="mb-3 text-blue"><i class="fas fa-info-circle me-2 text-gold"></i> How to Use this Space:</h4>
        <p class="mb-3"><strong class="text-gold">Fear not – this will only be seen by your guidance counselors.</strong></p>

        <ul class="mb-3" style="line-height: 1.8;">
            <li><strong>Be honest:</strong> Share what you truly feel. No filters needed.</li>
            <li><strong>Be kind:</strong> To yourself and to others. This is a judgment-free zone.</li>
            <li><strong>Stay anonymous if you wish:</strong> You don’t need to sign your name. What matters is that you feel heard.</li>
        </ul>

        <div class="text-center mt-4">
            <p class="text-muted fst-italic">Take a moment. Breathe. Write.<br>Here, you are heard. You are valued. You are home.</p>
        </div>
    </div>
</div>


@endsection
