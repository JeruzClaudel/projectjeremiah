@extends('layouts.user')
@section('title', 'Emergency Hotlines')

@section('content')

<div class="pub-hero fade-up">
    <div class="hero-inner">
        <div style="display:inline-flex;align-items:center;gap:8px;
                    padding:5px 16px;border:1px solid rgba(239,68,68,.45);
                    border-radius:999px;background:rgba(239,68,68,.12);
                    color:#fca5a5;font-size:.78rem;font-weight:700;
                    text-transform:uppercase;letter-spacing:.5px;margin-bottom:18px;">
            <i class="fas fa-circle-exclamation"></i> Crisis &amp; Emergency Support
        </div>
        <h1 style="color:#fca5a5;">Emergency Hotlines</h1>
        <p>If you or someone you know is in crisis, immediate help is available.<br>
           These resources provide 24/7 support when you need it most.</p>
    </div>
</div>

{{-- Danger banner --}}
<div class="danger-box mb-4 fade-up">
    <div style="display:flex;align-items:center;gap:10px;">
        <i class="fas fa-triangle-exclamation" style="font-size:1.2rem;flex-shrink:0;"></i>
        <div>
            <strong>In Case of Immediate Danger</strong><br>
            If you or someone else is in immediate danger, call <strong>911</strong>
            or go to your nearest emergency room immediately.
        </div>
    </div>
</div>

{{-- Hotline cards --}}
<div class="row g-3 mb-5">
    @forelse($entries as $entry)
    <div class="col-lg-4 col-md-6 fade-up" style="animation-delay:{{ $loop->index * .08 }}s">
        <div class="hotline-card">
            <div class="hc-icon"><i class="fas fa-phone-alt"></i></div>
            <h5>{{ $entry->name }}</h5>
            @if($entry->phone_number)
                <div class="hc-phone"><i class="fas fa-phone me-1"></i>{{ $entry->phone_number }}</div>
            @endif
            @if($entry->email)
                <div style="font-size:.82rem;color:var(--muted);margin-top:4px;">
                    <i class="fas fa-envelope me-1"></i>{{ $entry->email }}
                </div>
            @endif
            <div class="hc-avail">
                <i class="fas fa-clock"></i>
                {{ $entry->availability ?? 'Available 24/7' }}
            </div>
            @if($entry->site_link)
            <div style="margin-top:12px;">
                <a href="{{ route('user.hotline.details', $entry->id) }}"
                   style="display:inline-flex;align-items:center;gap:6px;padding:7px 16px;
                          background:var(--navy);color:var(--gold);border-radius:7px;
                          font-size:.8rem;font-weight:700;text-decoration:none;">
                    <i class="fas fa-arrow-right"></i> View Details
                </a>
            </div>
            @endif
        </div>
    </div>
    @empty
    <div class="col-12">
        <div style="text-align:center;padding:52px;background:#fff;border-radius:14px;
                    border:1.5px solid var(--border);color:var(--muted);">
            <i class="fas fa-phone-slash" style="font-size:2rem;display:block;margin-bottom:12px;"></i>
            No hotlines have been added yet.
        </div>
    </div>
    @endforelse
</div>

{{-- Additional Support Resources (from DB) --}}
@if(isset($resources) && $resources->count())
<div style="background:#fff;border-radius:14px;border:1.5px solid var(--border);
            padding:28px 28px 24px;box-shadow:var(--shadow);" class="fade-up">
    <div class="sec-title">Additional Support Resources</div>
    <div class="sec-line"></div>
    <div class="row g-3">
        @foreach($resources as $resource)
        <div class="col-md-4 col-sm-6">
            <div style="display:flex;align-items:flex-start;gap:14px;">
                <div style="width:44px;height:44px;border-radius:11px;flex-shrink:0;
                            background:{{ ['#eef4ff','#f0fdf4','#fdf4ff','#fff7ed','#fef2f2','#fef9e7'][$loop->index % 6] }};
                            display:flex;align-items:center;justify-content:center;font-size:.95rem;
                            color:{{ ['#1d4ed8','#16a34a','#9333ea','#ea580c','#dc2626','#c9a227'][$loop->index % 6] }};">
                    @php
                        $icons = ['fa-book-medical','fa-heart','fa-users','fa-hands-helping','fa-brain','fa-shield-heart'];
                    @endphp
                    <i class="fas {{ $icons[$loop->index % count($icons)] }}"></i>
                </div>
                <div>
                    <div style="font-weight:700;font-size:.9rem;color:var(--navy);margin-bottom:4px;">
                        {{ $resource->title }}
                    </div>
                    @if($resource->description)
                    <div style="font-size:.82rem;color:var(--muted);line-height:1.55;margin-bottom:6px;">
                        {{ Str::limit($resource->description, 100) }}
                    </div>
                    @endif
                    @if($resource->url)
                    <a href="{{ $resource->url }}" target="_blank"
                       style="font-size:.76rem;font-weight:700;color:var(--navy);text-decoration:underline;">
                        Learn more <i class="fas fa-arrow-up-right-from-square" style="font-size:.6rem;"></i>
                    </a>
                    @endif
                    @if($resource->slots !== null)
                    <div style="font-size:.72rem;color:var(--muted);margin-top:3px;">
                        <i class="fas fa-door-open" style="font-size:.65rem;"></i>
                        {{ $resource->slots }} slots available
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@else
{{-- Fallback static cards when no DB resources exist --}}
<div style="background:#fff;border-radius:14px;border:1.5px solid var(--border);
            padding:28px 28px 24px;box-shadow:var(--shadow);" class="fade-up">
    <div class="sec-title">Additional Support Resources</div>
    <div class="sec-line"></div>
    <div class="row g-3">
        @foreach([
            ['fas fa-book-medical','#eef4ff','#1d4ed8','Mental Health First Aid','Learn to recognize signs of mental health crises and how to help.'],
            ['fas fa-heart','#f0fdf4','#16a34a','Self-Help Resources','Apps and tools for managing stress, anxiety, and daily challenges.'],
            ['fas fa-users','#fdf4ff','#9333ea','Support Groups','Connect with peers who understand your experiences and challenges.'],
        ] as [$ico,$bg,$col,$title,$desc])
        <div class="col-md-4">
            <div style="display:flex;align-items:flex-start;gap:14px;">
                <div style="width:44px;height:44px;border-radius:11px;background:{{ $bg }};
                            display:flex;align-items:center;justify-content:center;
                            flex-shrink:0;color:{{ $col }};font-size:.95rem;">
                    <i class="{{ $ico }}"></i>
                </div>
                <div>
                    <div style="font-weight:700;font-size:.9rem;color:var(--navy);margin-bottom:4px;">{{ $title }}</div>
                    <div style="font-size:.82rem;color:var(--muted);">{{ $desc }}</div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

@endsection
