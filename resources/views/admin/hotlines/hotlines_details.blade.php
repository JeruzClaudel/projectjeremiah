<x-app-layout title="Hotline Details">

<div class="top-bar">
    <a class="top-button back" href="{{ route('admin.hotline.dashboard') }}">&larr; Back</a>
    <h2 class="navigation-title">Hotline Details</h2>
    <div style="margin-left:auto;display:flex;gap:8px;">
        <a href="{{ route('admin.hotline.edit', $hotlines->id) }}" class="top-button back">
            <i class="fas fa-pen"></i> Edit
        </a>
        <form id="del-hl-{{ $hotlines->id }}"
              action="{{ route('admin.hotline.delete', $hotlines->id) }}"
              method="POST" style="margin:0;">
            @csrf @method('DELETE')
        </form>
        <button type="button"
                class="top-button back"
                style="color:#dc2626;border-color:#fecaca;background:#fef2f2;"
                onclick="confirmDelete('del-hl-{{ $hotlines->id }}','hotline &quot;{{ addslashes($hotlines->name) }}&quot;')">
            <i class="fas fa-trash"></i> Delete
        </button>
    </div>
</div>
<div class="nav-line-separator"></div>

<div style="max-width:600px;">
    <div style="background:#fff;border:1.5px solid var(--border);border-radius:16px;
                overflow:hidden;box-shadow:var(--shadow);">

        {{-- Red header --}}
        <div style="background:linear-gradient(135deg,#7f1d1d,#b91c1c);padding:22px 26px;
                    display:flex;align-items:center;gap:14px;">
            <div style="width:52px;height:52px;border-radius:50%;
                        background:rgba(255,255,255,.15);border:1.5px solid rgba(255,255,255,.3);
                        display:flex;align-items:center;justify-content:center;
                        color:#fff;font-size:1.3rem;flex-shrink:0;">
                <i class="fas fa-phone-alt"></i>
            </div>
            <div>
                <div style="font-size:1.15rem;font-weight:800;color:#fff;">{{ $hotlines->name }}</div>
                @if($hotlines->availability)
                <div style="font-size:.75rem;color:rgba(255,255,255,.6);margin-top:4px;">
                    <i class="fas fa-clock" style="font-size:.65rem;margin-right:4px;"></i>{{ $hotlines->availability }}
                </div>
                @endif
            </div>
        </div>

        {{-- Info rows --}}
        <div style="padding:6px 0;">
            @foreach([
                ['fas fa-phone',   'Phone Number', $hotlines->phone_number ?? null, '#fef2f2','#fecaca','#dc2626'],
                ['fas fa-envelope','Email',        $hotlines->email        ?? null, '#eef4ff','#bfdbfe','#1d4ed8'],
                ['fas fa-globe',   'Website',      $hotlines->site_link    ?? null, '#f0fdf4','#bbf7d0','#16a34a'],
            ] as [$ico,$lbl,$val,$bg,$border,$col])
            @if($val)
            <div style="display:flex;align-items:center;gap:14px;padding:14px 24px;
                        border-bottom:1px solid var(--border);">
                <div style="width:40px;height:40px;border-radius:10px;background:{{ $bg }};
                            border:1px solid {{ $border }};
                            display:flex;align-items:center;justify-content:center;
                            color:{{ $col }};font-size:.9rem;flex-shrink:0;">
                    <i class="{{ $ico }}"></i>
                </div>
                <div>
                    <div style="font-size:.65rem;font-weight:800;color:var(--muted);
                                 text-transform:uppercase;letter-spacing:.4px;">{{ $lbl }}</div>
                    @if($lbl === 'Website')
                        <a href="{{ $val }}" target="_blank"
                           style="font-size:.92rem;font-weight:700;color:var(--navy);word-break:break-all;">
                            {{ $val }}
                        </a>
                    @else
                        <div style="font-size:.92rem;font-weight:600;color:var(--text);margin-top:2px;">
                            {{ $val }}
                        </div>
                    @endif
                </div>
            </div>
            @endif
            @endforeach
        </div>

    </div>
</div>

</x-app-layout>
