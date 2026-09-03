<x-app-layout title="Service Details">

<div class="top-bar">
    <a class="top-button back" href="{{ route('admin.services.dashboard') }}">&larr; Back</a>
    <h2 class="navigation-title">Service Details</h2>
    <div style="margin-left:auto;display:flex;gap:8px;">
        <a href="{{ route('admin.services.edit', $services->id) }}" class="top-button back">
            <i class="fas fa-pen"></i> Edit
        </a>
        <form id="del-svc-{{ $services->id }}"
              action="{{ route('admin.services.delete', $services->id) }}"
              method="POST" style="margin:0;">
            @csrf @method('DELETE')
        </form>
        <button type="button"
                class="top-button back"
                style="color:#dc2626;border-color:#fecaca;background:#fef2f2;"
                onclick="confirmDelete('del-svc-{{ $services->id }}','service &quot;{{ addslashes($services->name) }}&quot;')">
            <i class="fas fa-trash"></i> Delete
        </button>
    </div>
</div>
<div class="nav-line-separator"></div>

<div style="max-width:720px;">
    <div style="background:#fff;border:1.5px solid var(--border);border-radius:16px;
                overflow:hidden;box-shadow:var(--shadow);">

        {{-- Header stripe --}}
        <div style="background:linear-gradient(135deg,var(--navy),var(--navy2));
                    padding:22px 26px;display:flex;align-items:center;gap:14px;">
            <div style="width:48px;height:48px;border-radius:12px;
                        background:rgba(240,196,25,.15);border:1.5px solid rgba(240,196,25,.35);
                        display:flex;align-items:center;justify-content:center;
                        color:var(--gold);font-size:1.2rem;flex-shrink:0;">
                <i class="fas fa-hands-holding-heart"></i>
            </div>
            <div>
                <div style="font-size:1.1rem;font-weight:800;color:var(--gold);">
                    {{ $services->name }}
                </div>
                <div style="font-size:.75rem;color:rgba(255,255,255,.55);margin-top:3px;">
                    Added {{ $services->created_at->format('F d, Y') }}
                </div>
            </div>
        </div>

        {{-- Description --}}
        <div style="padding:24px 26px;border-bottom:1px solid var(--border);">
            <div style="font-size:.68rem;font-weight:800;color:var(--muted);
                         text-transform:uppercase;letter-spacing:.5px;margin-bottom:10px;">
                Description
            </div>
            <div style="font-size:.92rem;color:var(--text);line-height:1.8;white-space:pre-wrap;">{{ $services->description }}</div>
        </div>

        {{-- Consultation link --}}
        <div style="padding:20px 26px;">
            <div style="font-size:.68rem;font-weight:800;color:var(--muted);
                         text-transform:uppercase;letter-spacing:.5px;margin-bottom:10px;">
                Consultation / Request Link
            </div>
            @if($services->consultations_id)
                <a href="{{ $services->consultations_id }}" target="_blank"
                   style="display:inline-flex;align-items:center;gap:8px;
                          padding:10px 20px;background:var(--navy);color:var(--gold);
                          border-radius:10px;font-size:.85rem;font-weight:700;text-decoration:none;
                          transition:opacity .18s;"
                   onmouseover="this.style.opacity='.85'"
                   onmouseout="this.style.opacity='1'">
                    <i class="fas fa-arrow-up-right-from-square"></i> Open Link
                </a>
                <div style="font-size:.72rem;color:var(--muted);margin-top:8px;word-break:break-all;">
                    {{ $services->consultations_id }}
                </div>
            @else
                <div style="display:inline-flex;align-items:center;gap:6px;
                             padding:8px 14px;background:var(--light);border:1px solid var(--border);
                             border-radius:8px;font-size:.82rem;color:var(--muted);">
                    <i class="fas fa-link-slash"></i> No consultation link attached
                </div>
            @endif
        </div>

    </div>
</div>

</x-app-layout>
