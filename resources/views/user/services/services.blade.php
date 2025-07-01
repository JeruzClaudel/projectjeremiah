{{-- @extends('layouts.user')
    
@section('styles')
    @vite('resources/css/styles.css')
@endsection

@section('content')

<div class="container my-5 page-container">

    <!-- SERVICES OFFERED -->
    <div class="card shadow-lg rounded p-4 mb-5 bg-white">
        <h2 class="mb-4 text-gold text-center">Services Offered</h2>
        <div class="row" id="services-list">
            @foreach($services as $index => $service)
                <div class="col-md-4 mb-4 {{ $index >= 3 ? 'hidden-service' : '' }}">
                    <a href="{{ route('user.services.details', $service->id) }}" class="text-decoration-none">
                        <div class="card service-card h-100 p-3 text-center border-0 shadow-sm page-container">
                            <h4 class="text-blue mb-2">{{ $service->name }}</h4>
                            <p class="text-muted">{{ Str::limit(strip_tags($service->description), 120, '...') }}</p>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>

        @if(count($services) > 3)
            <div class="text-center mt-3">
                <button id="toggle-services-btn" class="btn bg-gold text-blue fw-bold px-4 py-2">Show All Services</button>
            </div>
        @endif
    </div>


    <!-- COUNSELOR INFORMATION -->
    <div class="card shadow-lg rounded p-4 mb-5 bg-white">
        <h2 class="mb-4 text-gold text-center">Meet Our Counselors</h2>

        <div id="counselors-container" class="mt-3" style="display: none;">
            <div class="row">
                @foreach($counselors as $counselor)
                    <div class="col-md-4 mb-4 page-container">
                        <div class="card counselor-card text-center border-0 shadow-sm p-3 h-100">
                            <a href="{{ route('user.counselors.details', $counselor->id) }}" class="text-decoration-none text-dark">
                                <img src="{{ asset('storage/' . $counselor->image) }}" alt="{{ $counselor->name }}" class="teacher-avatar mb-3">
                                <h4 class="text-blue">{{ $counselor->name }}</h4>
                                <p class="text-muted">{{ $counselor->position }}</p>
                                <p class="text-muted">{{ $counselor->college }}</p>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="text-center mt-3">
            <button id="toggle-counselors-btn" class="btn bg-gold text-blue fw-bold px-4 py-2">Meet Our Counselors</button>
        </div>
    </div>


    <!-- CONSULTATION LINKS -->
    <div class="card shadow-lg rounded p-4 bg-white">
        <h2 class="mb-4 text-gold text-center">Consultation Links</h2>
        <div class="row justify-content-center">
            @foreach($consultations as $consultation)
                <div class="col-md-6 mb-4">
                    <div class="card border-0 consultation-link shadow-sm p-4 text-center">
                        <h4 class="text-blue mb-2">{{ $consultation->name }}</h4>
                        <p class="text-muted">{{ $consultation->description }}</p>
                        <a href="{{ $consultation->request_link }}" target="_blank" class="btn bg-blue text-gold fw-bold px-4">
                            Request Here <i class="fas fa-external-link-alt ms-2"></i>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

</div>

@endsection


@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const servicesBtn = document.getElementById('toggle-services-btn');
        const hiddenServices = document.querySelectorAll('.hidden-service');

        if (servicesBtn) {
            servicesBtn.addEventListener('click', function () {
                const isHidden = hiddenServices[0].style.display === 'none' || hiddenServices[0].style.display === '';
                hiddenServices.forEach(service => {
                    service.style.display = isHidden ? 'block' : 'none';
                });
                servicesBtn.textContent = isHidden ? 'Show Less' : 'Show All Services';
            });
        }

        const counselorsBtn = document.getElementById('toggle-counselors-btn');
        const container = document.getElementById('counselors-container');

        counselorsBtn.addEventListener('click', function () {
            container.style.display = 'block';
            counselorsBtn.style.display = 'none';
        });
    });
</script>
@endsection

 --}}
















{{-- DIIFERENT UI --}}

@extends('layouts.user')
    
@section('styles')
    @vite('resources/css/styles.css')
    <style>
        :root {
            --gold: #ffd700;
            --blue: #1e40af;
            --light-blue: #dbeafe;
            --dark-blue: #1e3a8a;
            --gradient-gold: linear-gradient(135deg, #ffd700 0%, #ffed4e 100%);
            --gradient-blue: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
            --shadow-soft: 0 10px 25px rgba(0,0,0,0.1);
            --shadow-hover: 0 20px 40px rgba(0,0,0,0.15);
        }

        .page-hero {
            background: var(--gradient-blue);
            color: white;
            padding: 4rem 0;
            margin-bottom: 3rem;
            position: relative;
            overflow: hidden;
        }

        .page-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="25" cy="75" r="1" fill="white" opacity="0.05"/><circle cx="75" cy="25" r="1" fill="white" opacity="0.05"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.3;
        }

        .hero-content {
            position: relative;
            z-index: 1;
        }

        .section-card {
            background: white;
            border-radius: 20px;
            box-shadow: var(--shadow-soft);
            border: none;
            margin-bottom: 3rem;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .section-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-hover);
        }

        .section-header {
            background: var(--gradient-gold);
            color: var(--dark-blue);
            padding: 2rem;
            margin: -1.5rem -1.5rem 2rem -1.5rem;
            text-align: center;
            position: relative;
        }

        .section-header::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 0;
            border-left: 20px solid transparent;
            border-right: 20px solid transparent;
            border-top: 10px solid var(--gold);
        }

        .service-card {
            background: white;
            border-radius: 15px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 2px solid transparent;
            position: relative;
            overflow: hidden;
        }

        .service-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--gradient-gold);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.3s ease;
        }

        .service-card:hover::before {
            transform: scaleX(1);
        }

        .service-card:hover {
            transform: translateY(-8px) scale(1.03);
            box-shadow: var(--shadow-hover);
            border-color: var(--gold);
        }

        .service-icon {
            width: 60px;
            height: 60px;
            background: var(--gradient-blue);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            transition: all 0.3s ease;
        }

        .service-card:hover .service-icon {
            background: var(--gradient-gold);
            transform: rotate(360deg);
        }

        .counselor-card {
            background: white;
            border-radius: 20px;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .hidden-service {
    display: none;
}

        .counselor-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: var(--gradient-gold);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .counselor-card:hover::before {
            opacity: 0.1;
        }

        .counselor-card:hover {
            transform: translateY(-10px) rotateY(5deg);
            box-shadow: var(--shadow-hover);
        }

        .teacher-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid var(--gold);
            transition: all 0.3s ease;
            margin: 0 auto;
            display: block;
        }

        .counselor-card:hover .teacher-avatar {
            border-color: var(--blue);
            transform: scale(1.1);
        }

        .consultation-link {
            background: linear-gradient(135deg, white 0%, #f8fafc 100%);
            border-radius: 20px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .consultation-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.8), transparent);
            transition: left 0.6s;
        }

        .consultation-link:hover::before {
            left: 100%;
        }

        .consultation-link:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-hover);
        }

        .btn-primary {
            background: var(--gradient-blue);
            border: none;
            border-radius: 25px;
            padding: 12px 30px;
            font-weight: 600;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(30, 64, 175, 0.3);
        }

        .btn-secondary {
            background: var(--gradient-gold);
            color: var(--dark-blue);
            border: none;
            border-radius: 25px;
            padding: 12px 30px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(255, 215, 0, 0.3);
            color: var(--dark-blue);
        }

        .fade-in {
            opacity: 0;
            transform: translateY(30px);
            animation: fadeInUp 0.6s ease forwards;
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .stagger-animation .fade-in:nth-child(1) { animation-delay: 0.1s; }
        .stagger-animation .fade-in:nth-child(2) { animation-delay: 0.2s; }
        .stagger-animation .fade-in:nth-child(3) { animation-delay: 0.3s; }
        .stagger-animation .fade-in:nth-child(4) { animation-delay: 0.4s; }
        .stagger-animation .fade-in:nth-child(5) { animation-delay: 0.5s; }
        .stagger-animation .fade-in:nth-child(6) { animation-delay: 0.6s; }

        .pulse-icon {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .floating {
            animation: floating 3s ease-in-out infinite;
        }

        @keyframes floating {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        @media (max-width: 768px) {
            .page-hero {
                padding: 2rem 0;
            }
            
            .section-card {
                margin-bottom: 2rem;
            }
            
            .service-card:hover {
                transform: translateY(-4px) scale(1.02);
            }
            
            .counselor-card:hover {
                transform: translateY(-5px);
            }
        }
    </style>
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
       <h1 class="display-3 fw-bold mb-4" style="text-shadow: 2px 2px 8px rgba(0,0,0,0.3);">Welcome to Our Counseling Center</h1>
        <p class="lead mb-0" style="font-size: 1.3rem;">Empowering students through professional guidance and support</p>
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





<div class="container page-container">

    <!-- SERVICES OFFERED -->
    <div class="section-card p-5">
        <div class="section-header">
            <h2 class="display-5 fw-bold mb-0">
                <i class="fas fa-hand-holding-heart me-3 pulse-icon"></i>
                Services Offered
            </h2>
        </div>
        
        <div class="row stagger-animation" id="services-list">
            @foreach($services as $index => $service)
                <div class="col-lg-4 col-md-6 mb-4 fade-in {{ $index >= 3 ? 'hidden-service' : '' }}">
                    <a href="{{ route('user.services.details', $service->id) }}" class="text-decoration-none">
                        <div class="service-card h-100 p-4 text-center shadow-sm">
                            <div class="service-icon">
                                <i class="fas fa-{{-- {{ $this->getServiceIcon($index) }} --}} text-white fs-4"></i>
                            </div>
                            <h4 class="text-blue mb-3 fw-bold">{{ $service->name }}</h4>
                            <p class="text-muted mb-0">{{ Str::limit(strip_tags($service->description), 120, '...') }}</p>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>

        @if(count($services) > 3)
            <div class="text-center mt-4">
                <button id="toggle-services-btn" class="btn btn-secondary px-5 py-3">
                    <i class="fas fa-plus me-2"></i>Show All Services
                </button>
            </div>
        @endif
    </div>

    <!-- COUNSELOR INFORMATION -->
    <div class="section-card p-5">
        <div class="section-header">
            <h2 class="display-5 fw-bold mb-0">
                <i class="fas fa-users me-3 pulse-icon"></i>
                Meet Our Expert Counselors
            </h2>
        </div>

        <div id="counselors-container" class="mt-4" style="display: none;">
            <div class="row stagger-animation">
                @foreach($counselors as $counselor)
                    <div class="col-lg-4 col-md-6 mb-4 fade-in">
                        <div class="counselor-card text-center shadow-sm p-4 h-100">
                            <a href="{{ route('user.counselors.details', $counselor->id) }}" class="text-decoration-none text-dark">
                                <img src="{{ asset('storage/' . $counselor->image) }}" alt="{{ $counselor->name }}" class="teacher-avatar mb-3">
                                <h4 class="text-blue fw-bold mb-2">{{ $counselor->name }}</h4>
                                <p class="text-muted fw-semibold mb-1">{{ $counselor->position }}</p>
                                <p class="text-muted small">{{ $counselor->college }}</p>
                                <div class="mt-3">
                                    <span class="badge bg-light text-blue px-3 py-2">
                                        <i class="fas fa-graduation-cap me-1"></i>Expert Counselor
                                    </span>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="text-center mt-4">
            <button id="toggle-counselors-btn" class="btn btn-primary px-5 py-3">
                <i class="fas fa-user-friends me-2"></i>Meet Our Counselors
            </button>
        </div>
    </div>

    <!-- CONSULTATION LINKS -->
    <div class="section-card p-5">
        <div class="section-header">
            <h2 class="display-5 fw-bold mb-0">
                <i class="fas fa-calendar-check me-3 pulse-icon"></i>
                Schedule Your Consultation
            </h2>
        </div>
        
        <div class="row justify-content-center">
            @foreach($consultations as $consultation)
                <div class="col-lg-6 col-md-8 mb-4">
                    <div class="consultation-link shadow-sm p-5 text-center h-100">
                        <div class="mb-4">
                            <i class="fas fa-comments text-blue fs-1 mb-3"></i>
                            <h4 class="text-blue mb-3 fw-bold">{{ $consultation->name }}</h4>
                            <p class="text-muted mb-4">{{ $consultation->description }}</p>
                        </div>
                        <a href="{{ $consultation->request_link }}" target="_blank" class="btn btn-primary px-5 py-3">
                            <i class="fas fa-external-link-alt me-2"></i>Request Consultation
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

</div>

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Services toggle functionality
        const servicesBtn = document.getElementById('toggle-services-btn');
        const hiddenServices = document.querySelectorAll('.hidden-service');

        if (servicesBtn) {
            servicesBtn.addEventListener('click', function () {
                const isHidden = hiddenServices[0].style.display === 'none' || hiddenServices[0].style.display === '';
                
                hiddenServices.forEach((service, index) => {
                    if (isHidden) {
                        setTimeout(() => {
                            service.style.display = 'block';
                            service.classList.add('fade-in');
                        }, index * 100);
                    } else {
                        service.style.display = 'none';
                        service.classList.remove('fade-in');
                    }
                });
                
                const icon = servicesBtn.querySelector('i');
                if (isHidden) {
                    servicesBtn.innerHTML = '<i class="fas fa-minus me-2"></i>Show Less';
                } else {
                    servicesBtn.innerHTML = '<i class="fas fa-plus me-2"></i>Show All Services';
                }
            });
        }

        // Counselors toggle functionality
        const counselorsBtn = document.getElementById('toggle-counselors-btn');
        const container = document.getElementById('counselors-container');

        counselorsBtn.addEventListener('click', function () {
            container.style.display = 'block';
            counselorsBtn.style.display = 'none';
            
            // Trigger staggered animation for counselor cards
            const counselorCards = container.querySelectorAll('.fade-in');
            counselorCards.forEach((card, index) => {
                setTimeout(() => {
                    card.style.animationDelay = `${index * 0.1}s`;
                }, 100);
            });
        });

        // Intersection Observer for scroll animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('fade-in');
                }
            });
        }, observerOptions);

        // Observe all sections for scroll animations
        document.querySelectorAll('.section-card').forEach(section => {
            observer.observe(section);
        });

        // Add smooth scrolling
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Add loading states to buttons
        document.querySelectorAll('.btn').forEach(btn => {
            btn.addEventListener('click', function() {
                if (this.getAttribute('href') && this.getAttribute('target') === '_blank') {
                    const originalText = this.innerHTML;
                    this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Opening...';
                    setTimeout(() => {
                        this.innerHTML = originalText;
                    }, 2000);
                }
            });
        });
    });

    // Helper function for service icons (you can customize this based on your services)
    function getServiceIcon(index) {
        const icons = [
            'user-graduate', 'heart', 'brain', 'hands-helping', 
            'comments', 'shield-alt', 'lightbulb', 'users',
            'smile', 'book-open', 'puzzle-piece', 'star'
        ];
        return icons[index % icons.length];
    }
</script>
@endsection


