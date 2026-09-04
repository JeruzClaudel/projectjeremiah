@extends('layouts.user')
@section('title', 'Home — Project Jeremiah 33:3')

@section('content')

{{-- ── HERO ── --}}
<div class="hero">
    <div class="shell hero-grid">
        <div class="hero-copy">
            <p class="eyebrow">A place to begin</p>
            <h1>You don't have to face it alone.</h1>
            <p>Whatever you are carrying — a difficult day, a school concern, or something you cannot quite put into words yet — you deserve support that listens.</p>
            <div class="actions">
                <a class="btn btn-primary" href="{{ route('user.services') }}">Get Support <span>↗</span></a>
                <a class="btn btn-secondary" href="{{ route('user.freedomwall.add') }}">Share a Concern</a>
            </div>
            <div class="tiny-note"><i></i> A confidential, judgment-free space to begin</div>
        </div>

        {{-- CSS illustration --}}
        <div class="hero-art" aria-label="Illustration of a student reaching out for support">
            <div class="art-sun"></div>
            <div class="art-leaf"></div>
            <div class="art-person">
                <div class="art-hair"></div>
                <div class="art-head"></div>
                <div class="art-body"></div>
                <div class="art-shirt"></div>
                <div class="art-arm"></div>
            </div>
            <div class="art-bubble">You are heard here <span>♡</span></div>
        </div>
    </div>
</div>

{{-- ── VERSE BAND ── --}}
<div class="verse-band">
    <div class="shell verse-grid">
        <div>
            <div class="verse-mark">"</div>
            <h2>Call to Me and I Will Answer You</h2>
            <div class="verse-ref">Jeremiah 33:3</div>
        </div>
        <p>Project Jeremiah is inspired by the promise that reaching out matters. You do not have to make sense of everything before asking for care — we are here to listen, understand, and help you find a next step.</p>
    </div>
</div>

{{-- ── QUICK CARDS ── --}}
<div class="section">
    <div class="shell">
        <div class="care-strip">
            <div class="care-icon">♡</div>
            <div class="care-copy">
                <p class="eyebrow">Start where you are</p>
                <h3>Small steps count.</h3>
                <p>You do not need a perfect explanation or a big reason to reach out. Begin with what feels manageable today.</p>
            </div>
            <a class="text-link" href="{{ route('user.freedomwall.add') }}">Take a first step →</a>
        </div>

        <div class="section-heading" style="margin-top:48px;">
            <div>
                <p class="eyebrow">Find your next step</p>
                <h2>How can we help you?</h2>
            </div>
            <p>You can start wherever feels most comfortable. There is no perfect way to ask for support.</p>
        </div>

        <div class="quick-grid">
            <div class="card quick-card card-hover">
                <div class="icon-box">✦</div>
                <h3>Services</h3>
                <p>Explore available counseling and student support services.</p>
                <a class="text-link" href="{{ route('user.services') }}">View services →</a>
            </div>
            <div class="card quick-card card-hover">
                <div class="icon-box icon-box-alt">✎</div>
                <h3>e-Hayag</h3>
                <p>Have something on your mind? Share your concern safely.</p>
                <a class="text-link" href="{{ route('user.freedomwall.add') }}">Start writing →</a>
            </div>
            <div class="card quick-card card-hover">
                <div class="icon-box">♡</div>
                <h3>Hotlines</h3>
                <p>Find emergency contacts and mental health support hotlines.</p>
                <a class="text-link" href="{{ route('user.hotline') }}">View hotlines →</a>
            </div>
            <div class="card quick-card card-hover">
                <div class="icon-box">＋</div>
                <h3>Register</h3>
                <p>Create an account to use e-Hayag and guidance services.</p>
                <a class="text-link" href="{{ route('student.register') }}">Register →</a>
            </div>
        </div>

        <div class="help-strip">
            <div>
                <strong>Need help now?</strong>
                <span>If this is an emergency, please reach out to immediate support.</span>
            </div>
            <a class="text-link" href="{{ route('user.hotline') }}">See hotlines →</a>
        </div>

        {{-- Random quote from DB --}}
        @if(isset($quote) && $quote)
        <div style="text-align:center;margin-top:40px;padding:28px;background:var(--sky);border-radius:20px;border:1px solid var(--gold);">
            <p style="font:italic 1rem Georgia,serif;color:var(--navy);max-width:560px;margin:0 auto 10px;">"{{ $quote->quote }}"</p>
            @if($quote->author)
            <p style="font-size:.8rem;font-weight:700;color:var(--muted);letter-spacing:.05em;text-transform:uppercase;">— {{ $quote->author }}</p>
            @endif
        </div>
        @endif
    </div>
</div>

@endsection
