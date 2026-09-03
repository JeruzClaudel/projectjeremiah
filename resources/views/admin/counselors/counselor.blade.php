<x-app-layout title="Counselors">

<style>
.cns-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
    gap: 18px;
    margin-bottom: 40px;
}
.cns-card {
    background: #fff;
    border: 1.5px solid var(--border);
    border-radius: 16px;
    overflow: hidden;
    box-shadow: var(--shadow);
    transition: transform .22s, box-shadow .22s, border-color .22s;
    display: flex;
    flex-direction: column;
    text-decoration: none;
    color: inherit;
}
.cns-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow2);
    border-color: var(--gold2);
    text-decoration: none;
    color: inherit;
}
.cns-img-wrap {
    width: 100%;
    height: 180px;
    overflow: hidden;
    background: linear-gradient(135deg, var(--navy), var(--navy2));
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
    border-bottom: 2px solid var(--gold);
}
.cns-img-wrap img {
    width: 100%; height: 100%;
    object-fit: cover;
}
.cns-initials {
    font-size: 2.8rem; font-weight: 800;
    color: var(--gold); letter-spacing: -1px;
}
.cns-body {
    padding: 16px 16px 20px;
    flex: 1;
    display: flex; flex-direction: column; gap: 3px;
}
.cns-name     { font-size: .98rem; font-weight: 800; color: var(--navy); }
.cns-position { font-size: .78rem; font-weight: 600; color: var(--muted); }
.cns-college  { font-size: .74rem; color: var(--muted); }
.cns-badge    {
    display: inline-flex; align-items: center; gap: 4px;
    margin-top: 8px; padding: 3px 10px;
    background: var(--gold3); color: #92400e;
    border: 1px solid rgba(201,162,39,.3);
    border-radius: 999px; font-size: .68rem; font-weight: 700;
    align-self: flex-start;
}
.cns-actions {
    display: flex; gap: 6px;
    padding: 0 16px 16px;
}
.btn-cns-view {
    flex: 1;
    display: flex; align-items: center; justify-content: center; gap: 5px;
    padding: 8px;
    background: var(--navy);
    color: var(--gold);
    border-radius: 9px;
    font-size: .78rem; font-weight: 700;
    text-decoration: none;
    transition: opacity .18s;
}
.btn-cns-view:hover { opacity: .85; color: var(--gold); text-decoration: none; }
.btn-cns-edit {
    display: flex; align-items: center; justify-content: center; gap: 5px;
    padding: 8px 12px;
    background: #eff6ff; color: #1d4ed8;
    border: 1px solid #bfdbfe;
    border-radius: 9px;
    font-size: .78rem; font-weight: 700;
    text-decoration: none;
    transition: background .18s;
}
.btn-cns-edit:hover { background: #dbeafe; color: #1e40af; text-decoration: none; }
</style>

<div class="top-bar">
    <h2 class="navigation-title">Counselors</h2>
    <div style="display:flex;gap:8px;margin-left:auto;">
        <a href="{{ route('admin.counselor.export') }}" class="top-button back">
            <i class="fas fa-file-excel"></i> Export
        </a>
        <a href="{{ route('admin.counselor.add') }}" class="top-button add">
            <i class="fas fa-plus"></i> Add Counselor
        </a>
    </div>
</div>
<div class="nav-line-separator"></div>

{{-- Stats strip --}}
<div style="display:flex;align-items:center;gap:16px;margin-bottom:22px;flex-wrap:wrap;">
    <div style="background:#fff;border:1.5px solid var(--border);border-radius:12px;
                padding:14px 20px;display:flex;align-items:center;gap:12px;box-shadow:var(--shadow);">
        <div style="width:40px;height:40px;border-radius:10px;
                    background:linear-gradient(135deg,var(--navy),var(--navy2));
                    display:flex;align-items:center;justify-content:center;color:var(--gold);font-size:.95rem;">
            <i class="fas fa-user-tie"></i>
        </div>
        <div>
            <div style="font-size:.65rem;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.4px;">Total</div>
            <div style="font-size:1.5rem;font-weight:800;color:var(--navy);line-height:1;">{{ $counselors->count() }}</div>
        </div>
    </div>
    <div style="font-size:.82rem;color:var(--muted);">
        Click a card to view full profile, schedule, and contact info.
    </div>
</div>

{{-- Import strip --}}
<div style="background:#fff;border:1.5px dashed var(--border);border-radius:12px;
            padding:14px 20px;margin-bottom:22px;display:flex;align-items:center;
            justify-content:space-between;gap:14px;flex-wrap:wrap;">
    <div style="font-size:.82rem;color:var(--muted);">
        <i class="fas fa-file-import" style="color:var(--navy);margin-right:6px;"></i>
        Import counselors from an Excel file
    </div>
    <form method="POST" action="{{ route('admin.counselor.import') }}"
          enctype="multipart/form-data"
          style="display:flex;align-items:center;gap:8px;flex-wrap:wrap;margin:0;">
        @csrf
        <input type="file" name="import_file" accept=".xlsx,.xls,.csv" required
               style="font-size:.78rem;border:1px solid var(--border);border-radius:7px;padding:5px 8px;">
        <button type="submit"
                style="display:inline-flex;align-items:center;gap:6px;padding:7px 16px;
                       background:var(--navy);color:var(--gold);border:none;border-radius:8px;
                       font-size:.78rem;font-weight:700;cursor:pointer;">
            <i class="fas fa-upload"></i> Import
        </button>
    </form>
</div>

{{-- Counselor grid --}}
@forelse($counselors as $counselor)
@if($loop->first)
<div class="cns-grid">
@endif

<div class="cns-card">
    {{-- Image / initials --}}
    <div class="cns-img-wrap">
        @if($counselor->image)
            <img src="{{ asset('storage/' . $counselor->image) }}"
                 alt="{{ $counselor->name }}">
        @else
            <div class="cns-initials">{{ strtoupper(substr($counselor->name, 0, 1)) }}</div>
        @endif
    </div>

    {{-- Info body --}}
    <div class="cns-body">
        <div class="cns-name">{{ $counselor->name }}</div>
        @if($counselor->position)
        <div class="cns-position">{{ $counselor->position }}</div>
        @endif
        @if($counselor->college)
        <div class="cns-college"><i class="fas fa-building-columns" style="font-size:.65rem;margin-right:3px;"></i>{{ $counselor->college }}</div>
        @endif
        @if($counselor->email)
        <div style="font-size:.72rem;color:var(--muted);margin-top:2px;">
            <i class="fas fa-envelope" style="font-size:.62rem;margin-right:3px;"></i>{{ $counselor->email }}
        </div>
        @endif
        <span class="cns-badge"><i class="fas fa-graduation-cap" style="font-size:.6rem;"></i> Guidance Counselor</span>
    </div>

    {{-- Actions --}}
    <div class="cns-actions">
        <a href="{{ route('admin.counselor.details', $counselor->id) }}" class="btn-cns-view">
            <i class="fas fa-eye"></i> View
        </a>
        <a href="{{ route('admin.counselor.edit', $counselor->id) }}" class="btn-cns-edit">
            <i class="fas fa-pen"></i>
        </a>
    </div>
</div>

@if($loop->last)
</div>
@endif

@empty
<div style="text-align:center;padding:64px 20px;background:#fff;border-radius:16px;
            border:1.5px solid var(--border);box-shadow:var(--shadow);">
    <div style="width:72px;height:72px;border-radius:50%;
                background:linear-gradient(135deg,var(--navy),var(--navy2));
                display:flex;align-items:center;justify-content:center;
                margin:0 auto 16px;color:var(--gold);font-size:1.8rem;">
        <i class="fas fa-user-tie"></i>
    </div>
    <div style="font-size:1rem;font-weight:700;color:var(--navy);margin-bottom:8px;">No counselors yet</div>
    <div style="font-size:.84rem;color:var(--muted);margin-bottom:20px;">
        Add your first guidance counselor to get started.
    </div>
    <a href="{{ route('admin.counselor.add') }}"
       style="display:inline-flex;align-items:center;gap:7px;padding:10px 22px;
              background:var(--navy);color:var(--gold);border-radius:10px;
              font-size:.88rem;font-weight:700;text-decoration:none;">
        <i class="fas fa-plus"></i> Add Counselor
    </a>
</div>
@endforelse

</x-app-layout>
