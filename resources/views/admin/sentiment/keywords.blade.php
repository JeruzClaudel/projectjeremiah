
<x-app-layout title="Sentiment Keywords">
<style>
.kw-table { width:100%;border-collapse:collapse;background:#fff;border-radius:14px;
            overflow:hidden;box-shadow:0 2px 10px rgba(0,0,0,.06);border:1.5px solid #e5e7eb; }
.kw-table thead tr { background:linear-gradient(135deg,#0a1931,#1c2a4d); }
.kw-table thead th { padding:13px 16px;font-size:.72rem;font-weight:800;color:#f0c419;
                     text-transform:uppercase;letter-spacing:.6px;text-align:left;border:none; }
.kw-table tbody tr { border-bottom:1px solid #f3f4f6;transition:background .15s; }
.kw-table tbody tr:hover { background:#fef9e7; }
.kw-table td { padding:12px 16px;font-size:.9rem;color:#374151;vertical-align:middle; }
.cat-badge { display:inline-flex;align-items:center;padding:3px 12px;border-radius:999px;
             font-size:.7rem;font-weight:800;text-transform:uppercase; }
.cat-high_risk { background:#7f1d1d;color:#fca5a5; }
.cat-negative  { background:#fef2f2;color:#dc2626;border:1px solid #fecaca; }
.cat-positive  { background:#f0fdf4;color:#166534;border:1px solid #bbf7d0; }
.add-form { background:#fff;border:1.5px solid #e5e7eb;border-radius:14px;
            padding:20px 24px;margin-bottom:22px; }
</style>

<div class="top-bar">
    <h2 class="navigation-title">Sentiment Keywords</h2>
</div>
<div class="nav-line-separator"></div>

@if(session('added'))   <div style="background:#f0fdf4;border:1.5px solid #bbf7d0;border-radius:9px;padding:10px 14px;margin-bottom:16px;color:#166534;font-size:.85rem;">✅ {{ session('added') }}</div>@endif
@if(session('updated')) <div style="background:#fef9e7;border:1.5px solid rgba(201,162,39,.3);border-radius:9px;padding:10px 14px;margin-bottom:16px;color:#92400e;font-size:.85rem;">✅ {{ session('updated') }}</div>@endif
@if(session('deleted')) <div style="background:#fef2f2;border:1.5px solid #fecaca;border-radius:9px;padding:10px 14px;margin-bottom:16px;color:#dc2626;font-size:.85rem;">🗑 {{ session('deleted') }}</div>@endif

{{-- Add form --}}
<div class="add-form">
    <h4 style="font-size:.82rem;font-weight:800;color:#0a1931;text-transform:uppercase;letter-spacing:.4px;margin-bottom:14px;">Add Keyword</h4>
    <form method="POST" action="{{ route('admin.sentiment.keywords.store') }}" style="display:flex;gap:10px;flex-wrap:wrap;align-items:flex-end;">
        @csrf
        <div style="flex:2;min-width:160px;">
            <label style="font-size:.75rem;font-weight:700;color:#6b7280;display:block;margin-bottom:5px;">Keyword</label>
            <input type="text" name="word" placeholder="e.g. hopeless" required
                   style="width:100%;padding:9px 12px;border:1.5px solid #e5e7eb;border-radius:8px;font-size:.9rem;">
        </div>
        <div style="flex:1;min-width:140px;">
            <label style="font-size:.75rem;font-weight:700;color:#6b7280;display:block;margin-bottom:5px;">Category</label>
            <select name="category" required
                    style="width:100%;padding:9px 12px;border:1.5px solid #e5e7eb;border-radius:8px;font-size:.9rem;">
                <option value="high_risk">High Risk</option>
                <option value="negative">Negative</option>
                <option value="positive">Positive</option>
            </select>
        </div>
        <button type="submit" style="padding:9px 22px;background:#0a1931;color:#f0c419;border:none;
                border-radius:8px;font-weight:700;font-size:.88rem;cursor:pointer;">
            <i class="fas fa-plus"></i> Add
        </button>
    </form>
</div>

<div style="overflow-x:auto;">
    <table class="kw-table">
        <thead>
            <tr><th>#</th><th>Keyword</th><th>Category</th><th>Actions</th></tr>
        </thead>
        <tbody>
            @forelse($keywords as $i => $kw)
            <tr>
                <td style="color:#9ca3af;font-size:.8rem;">{{ $i+1 }}</td>
                <td style="font-weight:600;font-family:monospace;">{{ $kw->word }}</td>
                <td>
                    <span class="cat-badge cat-{{ $kw->category }}">
                        {{ str_replace('_',' ',$kw->category) }}
                    </span>
                </td>
                <td>
                    {{-- Inline edit --}}
                    <form method="POST" action="{{ route('admin.sentiment.keywords.update',$kw->id) }}"
                          style="display:inline-flex;gap:6px;align-items:center;">
                        @csrf @method('PUT')
                        <input type="text" name="word" value="{{ $kw->word }}"
                               style="padding:5px 8px;border:1.5px solid #e5e7eb;border-radius:6px;font-size:.82rem;width:120px;">
                        <select name="category" style="padding:5px 8px;border:1.5px solid #e5e7eb;border-radius:6px;font-size:.82rem;">
                            <option value="high_risk" {{ $kw->category=='high_risk'?'selected':'' }}>High Risk</option>
                            <option value="negative"  {{ $kw->category=='negative' ?'selected':'' }}>Negative</option>
                            <option value="positive"  {{ $kw->category=='positive' ?'selected':'' }}>Positive</option>
                        </select>
                        <button type="submit" style="padding:5px 12px;background:#0a1931;color:#f0c419;
                                border:none;border-radius:6px;font-size:.78rem;font-weight:700;cursor:pointer;">Save</button>
                    </form>
                    <form id="del-kw-{{ $kw->id }}" method="POST"
                          action="{{ route('admin.sentiment.keywords.delete',$kw->id) }}" style="display:inline;">
                        @csrf @method('DELETE')
                    </form>
                    <button type="button"
                            onclick="confirmDelete('del-kw-{{ $kw->id }}','keyword &quot;{{ addslashes($kw->word) }}&quot;')"
                            style="padding:5px 12px;background:#fef2f2;color:#dc2626;border:1px solid #fecaca;
                                   border-radius:6px;font-size:.78rem;font-weight:700;cursor:pointer;margin-left:4px;">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
            @empty
            <tr><td colspan="4" style="text-align:center;padding:40px;color:#9ca3af;">No keywords yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
</x-app-layout>
