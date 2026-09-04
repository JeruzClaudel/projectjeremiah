<x-app-layout title="Quote Details">

<div class="top-bar">
    <a class="top-button back" href="{{ route('admin.quote.index') }}">&larr; Back</a>
    <h2 class="navigation-title">Quote Details</h2>
    <div style="margin-left:auto;display:flex;gap:8px;">
        <a href="{{ route('admin.quote.edit', $quote->id) }}" class="top-button back">
            <i class="fas fa-pen"></i> Edit
        </a>
        <form id="del-quote-{{ $quote->id }}"
              action="{{ route('admin.quote.destroy', $quote->id) }}"
              method="POST" style="margin:0;">
            @csrf @method('DELETE')
        </form>
        <button type="button"
                class="top-button back"
                style="color:#dc2626;border-color:#fecaca;background:#fef2f2;"
                onclick="confirmDelete('del-quote-{{ $quote->id }}','this quote')">
            <i class="fas fa-trash"></i> Delete
        </button>
    </div>
</div>
<div class="nav-line-separator"></div>

<div style="max-width:640px;">
    <div style="background:linear-gradient(135deg,var(--navy),var(--navy2));
                border-radius:16px;padding:32px 36px;
                box-shadow:var(--shadow);position:relative;overflow:hidden;">

        {{-- Decorative quote mark --}}
        <div style="position:absolute;right:28px;top:-10px;
                    font:9rem Georgia,serif;color:rgba(240,196,25,.15);
                    line-height:1;pointer-events:none;">"</div>

        {{-- AI badge if applicable --}}
        <div style="display:inline-flex;align-items:center;gap:5px;
                    padding:3px 10px;border-radius:999px;
                    background:rgba(240,196,25,.15);border:1px solid rgba(240,196,25,.3);
                    color:var(--gold);font-size:.65rem;font-weight:800;
                    text-transform:uppercase;letter-spacing:.4px;margin-bottom:20px;">
            <i class="fas fa-quote-left"></i> Quote
        </div>

        {{-- Quote text --}}
        <p style="font-size:1.15rem;font-style:italic;color:rgba(255,255,255,.92);
                   line-height:1.75;margin-bottom:20px;position:relative;z-index:1;">
            "{{ $quote->quote }}"
        </p>

        {{-- Author --}}
        <div style="display:flex;align-items:center;gap:10px;">
            <div style="width:32px;height:2px;background:var(--gold);"></div>
            <div style="font-size:.88rem;font-weight:700;color:var(--gold);">
                {{ $quote->author ?? 'Guidance Services Office' }}
            </div>
        </div>

        {{-- Meta --}}
        <div style="margin-top:16px;padding-top:14px;border-top:1px solid rgba(255,255,255,.1);
                    font-size:.72rem;color:rgba(255,255,255,.35);">
            Added {{ $quote->created_at->format('F d, Y') }}
        </div>
    </div>
</div>

</x-app-layout>
