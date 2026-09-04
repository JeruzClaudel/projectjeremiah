@extends('layouts.user')
@section('title', 'Services — Project Jeremiah')

@section('content')

<div class="page-hero">
    <div class="shell">
        <div class="breadcrumbs">Project Jeremiah / Services</div>
        <h1>Support for where you are.</h1>
        <p>Every student's needs are different. Explore the kind of support that feels right for you today — with no judgment and no pressure.</p>
    </div>
</div>

{{-- Services --}}
<div class="section">
    <div class="shell">
        <div class="section-heading">
            <div>
                <p class="eyebrow">What we offer</p>
                <h2>Services offered</h2>
            </div>
            <p>Professional and student-centered support, with a gentle first step for every concern.</p>
        </div>

        @php $icons = ['◌','✧','⌁','↗','!','♧','♡','⌖']; @endphp

        <div class="services-list">
            @forelse($services as $i => $service)
            <a href="{{ route('user.services.details', $service->id) }}"
               class="card service-card card-hover" style="text-decoration:none;color:inherit;">
                <div class="icon-box {{ $i % 2 === 1 ? 'icon-box-alt' : '' }}">
                    {{ $icons[$i % count($icons)] }}
                </div>
                <h3>{{ $service->name }}</h3>
                <p>{{ Str::limit(strip_tags($service->description ?? ''), 110, '…') }}</p>
                <span class="text-link">Learn more →</span>
            </a>
            @empty
            <div class="card" style="grid-column:1/-1;padding:48px;text-align:center;color:var(--muted);">
                No services have been added yet.
            </div>
            @endforelse
        </div>
    </div>
</div>

{{-- Counselors --}}
@if(isset($counselors) && $counselors->count())
<div class="section section-alt">
    <div class="shell">
        <div class="section-heading">
            <div>
                <p class="eyebrow">People who listen</p>
                <h2>Meet our counselors</h2>
            </div>
            <p>Our guidance counselors are here to support your academic, personal, and mental wellness journey.</p>
        </div>

        <div class="counselor-grid-pub">
            @foreach($counselors as $counselor)
            <a href="{{ route('user.counselors.details', $counselor->id) }}"
               class="card counselor-pub card-hover" style="text-decoration:none;color:inherit;display:block;">
                <div class="counselor-pub-top">
                    @if($counselor->image)
                        <img src="{{ asset('storage/'.$counselor->image) }}"
                             alt="{{ $counselor->name }}"
                             class="counselor-pub-avatar"
                             style="width:98px;height:98px;object-fit:cover;border-radius:50%;border:5px solid white;z-index:1;position:relative;">
                    @else
                        <div class="counselor-pub-avatar">
                            {{ strtoupper(substr($counselor->name, 0, 2)) }}
                        </div>
                    @endif
                </div>
                <div class="counselor-pub-info">
                    <div class="counselor-role">{{ $counselor->position ?? 'Guidance Counselor' }}</div>
                    <h3>{{ $counselor->name }}</h3>
                    @if($counselor->college)
                    <p>{{ $counselor->college }}</p>
                    @endif
                    <span class="text-link">Consult {{ explode(' ', $counselor->name)[0] }} →</span>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</div>
@endif

{{-- Consultations --}}
@if(isset($consultations) && $consultations->count())
<div class="section">
    <div class="shell">
        <div class="section-heading">
            <div>
                <p class="eyebrow">Choose your channel</p>
                <h2>Consultation links</h2>
            </div>
        </div>
        <div class="consult-grid-pub">
            @php $cIcons = ['◷','⌁','⌂','⌖','→']; @endphp
            @foreach($consultations as $i => $c)
            <a href="{{ $c->request_link }}" target="_blank"
               class="card consult-pub card-hover" style="text-decoration:none;color:inherit;">
                <div class="icon-box">{{ $cIcons[$i % count($cIcons)] }}</div>
                <strong>{{ $c->name }}</strong>
                @if($c->description)
                    <p style="font-size:.75rem;color:var(--muted);margin-top:6px;">{{ Str::limit($c->description,60) }}</p>
                @endif
                <small>Open link →</small>
            </a>
            @endforeach
        </div>
    </div>
</div>
@endif

@endsection
