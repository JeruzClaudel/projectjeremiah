@extends('layouts.user')
@section('title', 'Thank You — e-Hayag')

@section('content')

<div class="section">
    <div class="shell">
        <div class="submitted-hero">
            <div class="submitted-check">✓</div>
            <h1>Your voice has been heard.</h1>
            <p>Thank you for sharing with us. What you wrote matters, and it will be read with care by your guidance counselors. You are not alone, and reaching out is a courageous step.</p>
        </div>

        <div class="card" style="padding:24px 28px;border-left:4px solid var(--gold);margin-bottom:24px;max-width:700px;">
            <h3 style="margin-bottom:8px;">What happens next?</h3>
            <p style="color:var(--muted);font-size:.9rem;line-height:1.75;">
                Your post is confidential and will only be seen by your guidance counselors. They read every submission with compassion and use them to better understand how to support students like you.
            </p>
        </div>

        <div class="action-next-grid" style="max-width:700px;">
            <a href="{{ route('user.services') }}" class="action-next-card">
                <div class="action-next-icon" style="background:var(--gold-soft);color:var(--navy);">✦</div>
                <div>
                    <strong style="display:block;color:var(--navy);font-size:.9rem;">Explore Services</strong>
                    <span style="font-size:.78rem;color:var(--muted);">Find counseling &amp; support programs</span>
                </div>
            </a>
            <a href="{{ route('user.hotline') }}" class="action-next-card">
                <div class="action-next-icon" style="background:var(--gold);color:var(--navy);">!</div>
                <div>
                    <strong style="display:block;color:var(--navy);font-size:.9rem;">Emergency Hotlines</strong>
                    <span style="font-size:.78rem;color:var(--muted);">24/7 crisis support resources</span>
                </div>
            </a>
            <a href="{{ route('user.freedomwall.add') }}" class="action-next-card">
                <div class="action-next-icon" style="background:var(--sky);color:var(--navy);">✎</div>
                <div>
                    <strong style="display:block;color:var(--navy);font-size:.9rem;">Write Again</strong>
                    <span style="font-size:.78rem;color:var(--muted);">Share another thought or feeling</span>
                </div>
            </a>
            <a href="{{ route('home') }}" class="action-next-card">
                <div class="action-next-icon" style="background:var(--sky-2);color:var(--navy);">⌂</div>
                <div>
                    <strong style="display:block;color:var(--navy);font-size:.9rem;">Go to Home</strong>
                    <span style="font-size:.78rem;color:var(--muted);">Back to the main page</span>
                </div>
            </a>
        </div>

        <p style="text-align:center;font:italic .9rem Georgia,serif;color:var(--muted);margin-top:28px;">
            "Every step forward is progress. Every conversation matters. You are not alone on this journey."
        </p>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(isset($isHighRisk) && $isHighRisk)
<script>
document.addEventListener('DOMContentLoaded', function () {
    const contactUrl = '{{ $highRiskUrl ?? route('user.services') }}';
    @if(isset($randomQuote) && $randomQuote)
    const quoteHtml = '<p style="font-size:.95rem;font-style:italic;color:var(--navy);margin-bottom:5px;">"{{ addslashes($randomQuote->quote) }}"</p><p style="font-size:.8rem;color:var(--muted);margin-bottom:10px;">— {{ addslashes($randomQuote->author ?? '') }}</p><hr style="margin:10px 0;border-color:#e5e7eb;">';
    @else
    const quoteHtml = '';
    @endif
    Swal.fire({
        html: '<div style="text-align:center;">' + quoteHtml + '<p style="font-size:.9rem;color:var(--ink,#000);line-height:1.7;">We hear you, and we care. A guidance counselor is here to support you.</p></div>',
        confirmButtonText: 'Reach Out to a Counselor',
        confirmButtonColor: '#31428A',
        showCancelButton: true,
        cancelButtonText: 'Maybe later',
        cancelButtonColor: '#888',
    }).then(r => { if (r.isConfirmed) window.open(contactUrl, '_blank'); });
});
</script>
@elseif(isset($randomQuote) && $randomQuote)
<script>
document.addEventListener('DOMContentLoaded', function () {
    Swal.fire({
        html: '<p style="font-size:1rem;font-style:italic;color:#000;">"{{ addslashes($randomQuote->quote) }}"</p><p style="font-size:.85rem;color:#666;margin-top:6px;">— {{ addslashes($randomQuote->author ?? 'Guidance Services Office') }}</p>',
        icon: 'info',
        confirmButtonText: 'Talk to a Counselor',
        cancelButtonText: 'Maybe later',
        showCancelButton: true,
        confirmButtonColor: '#31428A',
        cancelButtonColor: '#888',
    }).then(r => { if (r.isConfirmed) window.location.href = '{{ route('user.services') }}'; });
});
</script>
@endif

<script>
if (window.history && window.history.replaceState) {
    window.history.replaceState(null, '', window.location.href);
}
window.addEventListener('pageshow', function (e) {
    if (e.persisted) window.location.replace('{{ route('user.freedomwall.add') }}');
});
</script>
@endsection
