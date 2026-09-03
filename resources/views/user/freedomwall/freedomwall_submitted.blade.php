@extends('layouts.user')
@section('title', 'Thank You — e-Hayag')

@section('content')

<div class="submitted-hero fade-up">
    <div class="check-circle"><i class="fas fa-check"></i></div>
    <h1>Your voice has been heard.</h1>
    <p>
        Thank you for sharing with us. What you wrote matters, and it will be read with care
        by your guidance counselors. You are not alone, and reaching out is a courageous step.
    </p>
</div>

{{-- What happens next --}}
<div style="background:#fff;border-radius:14px;border:1.5px solid var(--border);
            border-left:4px solid var(--gold);padding:22px 26px;margin-bottom:24px;
            box-shadow:var(--shadow);" class="fade-up fade-up-d1">
    <div style="font-weight:700;color:var(--navy);margin-bottom:8px;">
        <i class="fas fa-info-circle" style="color:var(--gold);margin-right:7px;"></i>What happens next?
    </div>
    <p style="font-size:.88rem;color:var(--muted);line-height:1.7;margin:0;">
        Your post is confidential and will only be seen by your guidance counselors.
        They read every submission with compassion and use them to better understand
        how to support students like you. If you'd like a personal follow-up, a counselor may reach out.
    </p>
</div>

{{-- Action grid --}}
<div class="row g-3 mb-4 fade-up fade-up-d2">
    @foreach([
        [route('user.services'),         'fas fa-concierge-bell', '#16a34a', '#f0fdf4', 'Explore Services',    'Find counseling & support programs'],
        [route('user.hotline'),           'fas fa-phone-alt',      '#dc2626', '#fff0f0', 'Emergency Hotlines',  '24/7 crisis support resources'],
        [route('user.freedomwall.add'),   'fas fa-comment-dots',   '#1d4ed8', '#eef4ff', 'Write Again',         'Share another thought or feeling'],
        [route('home'),                   'fas fa-house',          '#c9a227', '#fef9e7', 'Go to Home',          'Back to the main page'],
    ] as [$href, $icon, $color, $bg, $label, $sub])
    <div class="col-md-6">
        <a href="{{ $href }}"
           style="display:flex;align-items:center;gap:14px;background:#fff;
                  border:1.5px solid var(--border);border-radius:13px;padding:16px 18px;
                  text-decoration:none;color:inherit;transition:border-color .2s,transform .2s,box-shadow .2s;"
           onmouseover="this.style.borderColor='var(--gold)';this.style.transform='translateY(-3px)';this.style.boxShadow='0 8px 24px rgba(0,0,0,.1)'"
           onmouseout="this.style.borderColor='var(--border)';this.style.transform='';this.style.boxShadow=''">
            <div style="width:44px;height:44px;border-radius:50%;background:{{ $bg }};
                        display:flex;align-items:center;justify-content:center;
                        color:{{ $color }};font-size:1rem;flex-shrink:0;">
                <i class="{{ $icon }}"></i>
            </div>
            <div>
                <div style="font-weight:700;color:var(--navy);font-size:.92rem;">{{ $label }}</div>
                <div style="font-size:.78rem;color:var(--muted);">{{ $sub }}</div>
            </div>
        </a>
    </div>
    @endforeach
</div>

<div style="text-align:center;color:var(--muted);font-style:italic;font-size:.88rem;padding:10px 0;" class="fade-up fade-up-d3">
    "Every step forward is progress. Every conversation matters. You are not alone on this journey."
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(isset($isHighRisk) && $isHighRisk)
<script>
document.addEventListener('DOMContentLoaded', function () {
    const contactUrl = '{{ $highRiskUrl ?? route('user.services') }}';

    @if(isset($randomQuote) && $randomQuote)
    const quoteHtml = '<p style="font-size:.95rem;font-style:italic;color:#111827;margin-bottom:4px;">"{{ addslashes($randomQuote->quote) }}"</p><p style="font-size:.8rem;color:#6b7280;margin-bottom:12px;">— {{ addslashes($randomQuote->author ?? '') }}</p><hr style="margin:10px 0;border-color:#e5e7eb;">';
    @else
    const quoteHtml = '';
    @endif

    Swal.fire({
        html: '<div style="text-align:center;">'
            + '<i class="fas fa-hands-holding-heart" style="font-size:2rem;color:#c9a227;display:block;margin-bottom:12px;"></i>'
            + quoteHtml
            + '<p style="font-size:.9rem;color:#374151;line-height:1.7;margin:0;">We hear you, and we care. A guidance counselor is here to support you. You don\'t have to face this alone.</p>'
            + '</div>',
        showConfirmButton: true,
        confirmButtonText: '<i class="fas fa-comments"></i> Reach Out to a Counselor',
        confirmButtonColor: '#0a1931',
        showCancelButton: true,
        cancelButtonText: 'Maybe later',
        cancelButtonColor: 'transparent',
        didOpen: () => {
            const c = Swal.getCancelButton();
            if (c) {
                c.style.cssText = 'font-size:.72rem!important;color:#9ca3af!important;background:transparent!important;border:none!important;text-decoration:underline!important;box-shadow:none!important;';
            }
        }
    }).then(r => { if (r.isConfirmed) window.open(contactUrl, '_blank'); });
});
</script>

@elseif(isset($randomQuote) && $randomQuote)
<script>
document.addEventListener('DOMContentLoaded', function () {
    Swal.fire({
        html: '<p style="font-size:1rem;font-style:italic;color:#111827;">"{{ addslashes($randomQuote->quote) }}"</p>'
            + '<p style="font-size:.85rem;color:#6b7280;margin-top:6px;">— {{ addslashes($randomQuote->author ?? 'Guidance Services Office') }}</p>',
        icon: 'info',
        showCancelButton: true,
        confirmButtonText: '<i class="fas fa-comments me-1"></i> Talk to a Counselor',
        cancelButtonText: 'Maybe later',
        confirmButtonColor: '#0a1931',
        cancelButtonColor: '#6c757d',
    }).then(r => { if (r.isConfirmed) window.location.href = '{{ route('user.services') }}'; });
});
</script>
@endif

{{-- Prevent back-button return --}}
<script>
if (window.history && window.history.replaceState) {
    window.history.replaceState(null, '', window.location.href);
}
window.addEventListener('pageshow', function (e) {
    if (e.persisted) window.location.replace('{{ route('user.freedomwall.add') }}');
});
</script>
@endsection
