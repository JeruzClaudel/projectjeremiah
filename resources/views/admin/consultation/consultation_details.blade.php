<x-app-layout title="Consultation Details">

<div class="top-bar">
    <a class="top-button back" href="{{ route('admin.consultation.dashboard') }}">&larr; Back</a>
    <h2 class="navigation-title">Consultation Details</h2>
    <div style="margin-left:auto;display:flex;gap:8px;">
        <a href="{{ route('admin.consultation.edit', $consultation->id) }}" class="top-button back">
            <i class="fas fa-pen"></i> Edit
        </a>
        <form id="del-consult-{{ $consultation->id }}"
              action="{{ route('admin.consultation.delete', $consultation->id) }}"
              method="POST" style="margin:0;">
            @csrf @method('DELETE')
        </form>
        <button type="button"
                class="top-button back"
                style="color:#dc2626;border-color:#fecaca;background:#fef2f2;"
                onclick="confirmDelete('del-consult-{{ $consultation->id }}','consultation &quot;{{ addslashes($consultation->name) }}&quot;')">
            <i class="fas fa-trash"></i> Delete
        </button>
    </div>
</div>
<div class="nav-line-separator"></div>

<div style="max-width:640px;">
    <div style="background:#fff;border:1.5px solid var(--border);border-radius:16px;
                overflow:hidden;box-shadow:var(--shadow);">

        {{-- Header stripe --}}
        <div style="background:linear-gradient(135deg,var(--navy),var(--navy2));
                    padding:20px 26px;display:flex;align-items:center;gap:14px;">
            <div style="width:46px;height:46px;border-radius:12px;
                        background:rgba(240,196,25,.15);border:1.5px solid rgba(240,196,25,.35);
                        display:flex;align-items:center;justify-content:center;
                        color:var(--gold);font-size:1.1rem;flex-shrink:0;">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div>
                <div style="font-size:1.05rem;font-weight:800;color:var(--gold);">
                    {{ $consultation->name }}
                </div>
                <div style="font-size:.72rem;color:rgba(255,255,255,.5);margin-top:3px;">
                    Added {{ $consultation->created_at->format('F d, Y') }}
                </div>
            </div>
        </div>

        {{-- Description --}}
        @if($consultation->description)
        <div style="padding:20px 26px;border-bottom:1px solid var(--border);">
            <div style="font-size:.68rem;font-weight:800;color:var(--muted);
                         text-transform:uppercase;letter-spacing:.4px;margin-bottom:8px;">
                Description
            </div>
            <p style="font-size:.92rem;color:var(--text);line-height:1.75;white-space:pre-wrap;">{{ $consultation->description }}</p>
        </div>
        @endif

        {{-- Request link --}}
        <div style="padding:20px 26px;">
            <div style="font-size:.68rem;font-weight:800;color:var(--muted);
                         text-transform:uppercase;letter-spacing:.4px;margin-bottom:10px;">
                Request / Booking Link
            </div>
            <a href="{{ $consultation->request_link }}" target="_blank"
               style="display:inline-flex;align-items:center;gap:8px;
                      padding:10px 18px;background:var(--navy);color:var(--gold);
                      border-radius:10px;font-size:.85rem;font-weight:700;text-decoration:none;
                      transition:opacity .18s;margin-bottom:8px;"
               onmouseover="this.style.opacity='.85'"
               onmouseout="this.style.opacity='1'">
                <i class="fas fa-arrow-up-right-from-square"></i> Open Link
            </a>
            <div style="font-size:.72rem;color:var(--muted);word-break:break-all;margin-top:4px;">
                {{ $consultation->request_link }}
            </div>
        </div>

    </div>
</div>

</x-app-layout>
