<x-app-layout title="Quick Links">

<style>
.links-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 16px;
    margin-bottom: 40px;
}
.link-card {
    background: #fff;
    border: 1.5px solid var(--border);
    border-radius: 14px;
    padding: 20px 20px 16px;
    box-shadow: var(--shadow);
    display: flex;
    flex-direction: column;
    gap: 10px;
    transition: transform .22s, box-shadow .22s, border-color .22s;
}
.link-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow2);
    border-color: var(--gold2);
}
.link-card-top {
    display: flex;
    align-items: flex-start;
    gap: 14px;
}
.link-icon-wrap {
    width: 44px; height: 44px;
    border-radius: 11px;
    background: linear-gradient(135deg, var(--navy), var(--navy2));
    display: flex; align-items: center; justify-content: center;
    color: var(--gold); font-size: 1rem;
    flex-shrink: 0;
}
.link-name {
    font-size: .98rem; font-weight: 800; color: var(--navy);
    margin-bottom: 3px;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    max-width: 180px;
}
.link-category {
    font-size: .72rem; font-weight: 600; color: var(--muted);
}
.link-url {
    font-size: .76rem; color: #0369a1;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    display: block;
    background: #f0f9ff; border: 1px solid #bae6fd;
    border-radius: 7px; padding: 5px 10px;
    text-decoration: none;
}
.link-url:hover { background: #e0f2fe; }
.link-card-footer {
    display: flex; align-items: center;
    justify-content: space-between;
    padding-top: 8px;
    border-top: 1px solid var(--border);
}
.link-actions { display: flex; gap: 6px; }
.btn-lnk {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 6px 13px; border-radius: 8px;
    font-size: .75rem; font-weight: 700;
    cursor: pointer; transition: background .15s;
    text-decoration: none; border: none;
}
.btn-lnk-view { background: var(--navy); color: var(--gold); }
.btn-lnk-view:hover { opacity: .85; color: var(--gold); text-decoration: none; }
.btn-lnk-edit { background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; }
.btn-lnk-edit:hover { background: #dbeafe; color: #1e40af; }
.btn-lnk-del  { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }
.btn-lnk-del:hover  { background: #fee2e2; }
</style>

<div class="top-bar">
    <h2 class="navigation-title">Quick Links</h2>
    <a href="{{ route('admin.link.add') }}" class="top-button add">
        <i class="fas fa-plus"></i> Add Link
    </a>
</div>
<div class="nav-line-separator"></div>

{{-- Summary strip --}}
<div style="display:flex;align-items:center;gap:14px;margin-bottom:22px;flex-wrap:wrap;">
    <div style="background:#fff;border:1.5px solid var(--border);border-radius:12px;
                padding:12px 18px;display:flex;align-items:center;gap:10px;box-shadow:var(--shadow);">
        <div style="width:36px;height:36px;border-radius:9px;
                    background:linear-gradient(135deg,var(--navy),var(--navy2));
                    display:flex;align-items:center;justify-content:center;color:var(--gold);font-size:.85rem;">
            <i class="fas fa-link"></i>
        </div>
        <div>
            <div style="font-size:.62rem;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.4px;">Total Links</div>
            <div style="font-size:1.4rem;font-weight:800;color:var(--navy);line-height:1;">{{ $links->count() }}</div>
        </div>
    </div>
    <div style="background:#fff;border:1.5px solid var(--border);border-radius:12px;
                padding:12px 18px;display:flex;align-items:center;gap:10px;box-shadow:var(--shadow);">
        <div style="width:36px;height:36px;border-radius:9px;background:#f0fdf4;
                    display:flex;align-items:center;justify-content:center;color:#16a34a;font-size:.85rem;">
            <i class="fas fa-circle-check"></i>
        </div>
        <div>
            <div style="font-size:.62rem;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.4px;">Active</div>
            <div style="font-size:1.4rem;font-weight:800;color:#166534;line-height:1;">{{ $links->where('is_active',true)->count() }}</div>
        </div>
    </div>
</div>

{{-- Cards grid --}}
@forelse($links as $link)
@if($loop->first)<div class="links-grid">@endif

<div class="link-card">
    <div class="link-card-top">
        <div class="link-icon-wrap">
            @if($link->icon)
                <i class="{{ $link->icon }}"></i>
            @else
                <i class="fas fa-link"></i>
            @endif
        </div>
        <div style="flex:1;min-width:0;">
            <div class="link-name" title="{{ $link->name }}">{{ $link->name }}</div>
            @if($link->category)
            <div class="link-category">
                <i class="fas fa-tag" style="font-size:.6rem;margin-right:3px;"></i>{{ $link->category }}
            </div>
            @endif
        </div>
        {{-- Active toggle badge --}}
        @if($link->is_active)
            <span style="background:#f0fdf4;color:#166534;border:1px solid #bbf7d0;
                         padding:3px 9px;border-radius:999px;font-size:.65rem;font-weight:700;
                         white-space:nowrap;flex-shrink:0;">
                <i class="fas fa-circle" style="font-size:.5rem;"></i> Active
            </span>
        @else
            <span style="background:#f3f4f6;color:#9ca3af;border:1px solid var(--border);
                         padding:3px 9px;border-radius:999px;font-size:.65rem;font-weight:700;
                         white-space:nowrap;flex-shrink:0;">
                Inactive
            </span>
        @endif
    </div>

    {{-- URL chip --}}
    <a href="{{ $link->url }}" target="_blank" class="link-url" title="{{ $link->url }}">
        <i class="fas fa-arrow-up-right-from-square" style="font-size:.65rem;margin-right:4px;"></i>
        {{ $link->url }}
    </a>

    {{-- Footer actions --}}
    <div class="link-card-footer">
        <span style="font-size:.7rem;color:var(--muted);">
            Added {{ $link->created_at->format('M d, Y') }}
        </span>
        <div class="link-actions">
            <a href="{{ route('admin.link.details', $link->id) }}" class="btn-lnk btn-lnk-view">
                <i class="fas fa-eye"></i> View
            </a>
            <a href="{{ route('admin.link.edit', $link->id) }}" class="btn-lnk btn-lnk-edit">
                <i class="fas fa-pen"></i>
            </a>
            <form id="del-link-{{ $link->id }}"
                  action="{{ route('admin.link.destroy', $link->id) }}"
                  method="POST" style="margin:0;">
                @csrf @method('DELETE')
            </form>
            <button type="button" class="btn-lnk btn-lnk-del"
                    onclick="confirmDelete('del-link-{{ $link->id }}','link &quot;{{ addslashes($link->name) }}&quot;')">
                <i class="fas fa-trash"></i>
            </button>
        </div>
    </div>
</div>

@if($loop->last)</div>@endif

@empty
<div style="text-align:center;padding:64px 20px;background:#fff;border-radius:16px;
            border:1.5px solid var(--border);box-shadow:var(--shadow);">
    <div style="width:64px;height:64px;border-radius:50%;
                background:linear-gradient(135deg,var(--navy),var(--navy2));
                display:flex;align-items:center;justify-content:center;
                margin:0 auto 14px;color:var(--gold);font-size:1.5rem;">
        <i class="fas fa-link"></i>
    </div>
    <div style="font-size:.98rem;font-weight:700;color:var(--navy);margin-bottom:7px;">No links yet</div>
    <div style="font-size:.84rem;color:var(--muted);margin-bottom:18px;">
        Add quick links for resources, forms, or external tools.
    </div>
    <a href="{{ route('admin.link.add') }}"
       style="display:inline-flex;align-items:center;gap:7px;padding:10px 22px;
              background:var(--navy);color:var(--gold);border-radius:10px;
              font-size:.88rem;font-weight:700;text-decoration:none;">
        <i class="fas fa-plus"></i> Add First Link
    </a>
</div>
@endforelse

</x-app-layout>
