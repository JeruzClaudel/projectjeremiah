<x-app-layout title="Hotlines">

<style>
.hl-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 16px;
    margin-bottom: 40px;
}
.hl-card {
    background: #fff;
    border: 1.5px solid var(--border);
    border-radius: 14px;
    overflow: hidden;
    box-shadow: var(--shadow);
    transition: transform .22s, box-shadow .22s, border-color .22s;
    display: flex;
    flex-direction: column;
}
.hl-card:hover { transform: translateY(-4px); box-shadow: var(--shadow2); border-color: #fecaca; }
.hl-card-top {
    background: linear-gradient(135deg, #7f1d1d, #b91c1c);
    padding: 18px 20px;
    display: flex; align-items: center; gap: 14px;
}
.hl-icon {
    width: 44px; height: 44px; border-radius: 50%;
    background: rgba(255,255,255,.15); border: 1.5px solid rgba(255,255,255,.3);
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-size: 1.1rem; flex-shrink: 0;
}
.hl-name  { font-size: .98rem; font-weight: 800; color: #fff; }
.hl-avail { font-size: .72rem; color: rgba(255,255,255,.6); margin-top: 2px; }
.hl-body  { padding: 16px 20px; flex: 1; display: flex; flex-direction: column; gap: 8px; }
.hl-row   { display: flex; align-items: center; gap: 9px; font-size: .84rem; color: var(--text); }
.hl-row i { width: 16px; text-align: center; color: #dc2626; font-size: .8rem; }
.hl-row a { color: var(--navy); font-weight: 600; text-decoration: none; }
.hl-row a:hover { text-decoration: underline; }
.hl-footer {
    display: flex; gap: 6px; padding: 12px 20px;
    border-top: 1px solid var(--border); background: var(--light);
}
.btn-hl-view {
    flex: 1; display: flex; align-items: center; justify-content: center; gap: 5px;
    padding: 8px; background: #7f1d1d; color: #fff;
    border-radius: 8px; font-size: .78rem; font-weight: 700;
    text-decoration: none; transition: opacity .18s;
}
.btn-hl-view:hover { opacity: .85; color: #fff; text-decoration: none; }
.btn-hl-edit {
    display: flex; align-items: center; justify-content: center;
    padding: 8px 14px;
    background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe;
    border-radius: 8px; font-size: .78rem; font-weight: 700;
    text-decoration: none; transition: background .15s;
}
.btn-hl-edit:hover { background: #dbeafe; color: #1e40af; text-decoration: none; }
</style>

<div class="top-bar">
    <h2 class="navigation-title">Emergency Hotlines</h2>
    <a href="{{ route('admin.hotline.add') }}" class="top-button add">
        <i class="fas fa-plus"></i> Add Hotline
    </a>
</div>
<div class="nav-line-separator"></div>

{{-- Count strip --}}
<div style="font-size:.82rem;color:var(--muted);margin-bottom:18px;">
    <strong style="color:var(--navy);">{{ count($hotlines) }}</strong> hotline{{ count($hotlines)!==1?'s':'' }} configured
</div>

{{-- Cards --}}
@forelse($hotlines as $hotline)
@if($loop->first)<div class="hl-grid">@endif

<div class="hl-card">
    <div class="hl-card-top">
        <div class="hl-icon"><i class="fas fa-phone-alt"></i></div>
        <div>
            <div class="hl-name">{{ $hotline->name }}</div>
            @if($hotline->availability)
            <div class="hl-avail">
                <i class="fas fa-clock" style="font-size:.6rem;margin-right:3px;"></i>
                {{ $hotline->availability }}
            </div>
            @endif
        </div>
    </div>

    <div class="hl-body">
        @if($hotline->phone_number)
        <div class="hl-row">
            <i class="fas fa-phone"></i>
            <span style="font-size:.9rem;font-weight:700;color:#dc2626;">{{ $hotline->phone_number }}</span>
        </div>
        @endif
        @if($hotline->email)
        <div class="hl-row">
            <i class="fas fa-envelope"></i>
            <span>{{ $hotline->email }}</span>
        </div>
        @endif
        @if($hotline->site_link)
        <div class="hl-row">
            <i class="fas fa-globe"></i>
            <a href="{{ $hotline->site_link }}" target="_blank">Visit Website</a>
        </div>
        @endif
    </div>

    <div class="hl-footer">
        <a href="{{ route('admin.hotline.details', $hotline->id) }}" class="btn-hl-view">
            <i class="fas fa-eye"></i> View
        </a>
        <a href="{{ route('admin.hotline.edit', $hotline->id) }}" class="btn-hl-edit">
            <i class="fas fa-pen"></i>
        </a>
    </div>
</div>

@if($loop->last)</div>@endif

@empty
<div style="text-align:center;padding:56px 20px;background:#fff;border-radius:14px;
            border:1.5px solid var(--border);box-shadow:var(--shadow);">
    <div style="width:68px;height:68px;border-radius:50%;background:linear-gradient(135deg,#7f1d1d,#b91c1c);
                display:flex;align-items:center;justify-content:center;
                margin:0 auto 14px;color:#fff;font-size:1.6rem;">
        <i class="fas fa-phone-alt"></i>
    </div>
    <div style="font-size:.98rem;font-weight:700;color:var(--navy);margin-bottom:8px;">No hotlines yet</div>
    <div style="font-size:.84rem;color:var(--muted);margin-bottom:18px;">
        Add emergency hotlines that students can reach during a crisis.
    </div>
    <a href="{{ route('admin.hotline.add') }}"
       style="display:inline-flex;align-items:center;gap:7px;padding:10px 22px;
              background:#7f1d1d;color:#fff;border-radius:10px;
              font-size:.88rem;font-weight:700;text-decoration:none;">
        <i class="fas fa-plus"></i> Add Hotline
    </a>
</div>
@endforelse

</x-app-layout>
