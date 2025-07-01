@vite('resources/css/style1.css')

<x-app-layout>
    <div class="top-bar">
        <h2 class="navigation-title">Manage Counselors</h2>
        <a class="top-button add" href="{{ route('admin.counselor.add')}}">&#65291 ADD COUNSELOR</a>
    </div>
  
    <div class="nav-line-separator"></div>
    
   <div class="pane">
        <div class="counselor-grid">
            @foreach($counselors as $counselor)
                <div class="counselor-card">

                    {{-- FOR DEBUGGING --}}
                   {{--  <p>Stored path: {{ $counselor->image }}</p>
                    <p>Full URL: {{ asset('storage/' . $counselor->image) }}</p>
                    <img src="{{ asset('storage/' . $counselor->image) }}" alt="Test image"> --}}


                    {{-- <div class="counselor-image"> --}}
                    <a href="{{ route('admin.counselor.details', $counselor->id) }}" class="details-button">
                        @if($counselor->image)
                            <img src="{{ asset('storage/' . $counselor->image) }}" alt="{{ $counselor->name }}">
                        @else
                            <img src="{{ asset('images/default-avatar.png') }}" alt="Default Image">
                        @endif
                   {{--  </div> --}}
                    <div class="counselor-details">
                        <h3 class="counselor-name">{{ $counselor->name }}</h3>
                        <p class="counselor-position">{{ $counselor->position }}</p>
                        <p class="counselor-college">{{ $counselor->college }}</p>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    
    <x-alert></x-alert>
</x-app-layout>
