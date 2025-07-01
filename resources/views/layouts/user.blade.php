<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Guidance Office Services')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    @yield('styles')
</head>
<body>

{{-- FOR PREVENTING F12 --}}    
<script>
  document.addEventListener('contextmenu', event => event.preventDefault());
  document.onkeydown = function(e) {
    if (e.key === "F12" || (e.ctrlKey && e.shiftKey && e.key === 'I')) {
      return false;
    }
  };
</script>

    <!-- Main Content -->
    <div class="p-4">

        <!-- "Project Jeremiah" link now part of scrollable content -->
        <div class="mb-3">
            <a href="#" class="btn btn-light fw-bold" data-bs-toggle="offcanvas" data-bs-target="#sidebar" aria-controls="sidebar">
               PROJECT JEREMIAH
            </a>
        </div>

        <main>
            @yield('content')
        </main>

        <footer class="mt-5">
            <div class="container text-center">
                <div class="mb-3">
                    <a href="#" class="text-blue mx-2"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="text-blue mx-2"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-blue    mx-2"><i class="fab fa-instagram"></i></a>
                </div>
                <p class="mb-0">&copy; 2025 Guidance Office Services. All rights reserved.</p>
            </div>
        </footer>
    </div>

    <!-- Sidebar as offcanvas -->
    <div class="offcanvas offcanvas-start bg-blue text-white" tabindex="-1" id="sidebar">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title fw-bold">
                <a class="nav-link text-white" href="{{ route('home') }}">
                    <i class="fas fa-school me-2"></i>PROJECT JEREMIAH</h5>
                </a>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body p-3">
            <ul class="nav flex-column">
                <li class="nav-item mb-2">
                    <a class="nav-link text-white" href="{{ route('user.hotline') }}">
                        <i class="fas fa-phone-alt me-1"></i>Emergency Hotlines
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link text-white" href="{{ route('user.services') }}">
                        <i class="fas fa-concierge-bell me-1"></i>Services
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link text-white" href="{{ route('user.freedomwall.add') }}">
                        <i class="fas fa-file me-1"></i>e-Hayag
                    </a>
                </li>

                {{-- LOGIN --}}
                {{-- @guest
                <li class="nav-item mb-2">
                    <a class="nav-link text-white" href="{{ route('login') }}">
                        <i class="fas fa-sign-in-alt me-1"></i>Login
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link text-white" href="{{ route('register') }}">
                        <i class="fas fa-user-plus me-1"></i>Register
                    </a>
                </li>
                @else
                <li class="nav-item dropdown mb-2">
                    <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user me-1"></i>{{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="fas fa-sign-out-alt me-1"></i>Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
                @endguest --}}
            </ul>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
