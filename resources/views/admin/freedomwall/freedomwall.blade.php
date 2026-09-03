<x-app-layout title="e-Hayag Posts">

<style>
/* Filter */
.filter-card { background:#fff;border:1.5px solid var(--border);border-radius:14px;
               padding:16px 20px;margin-bottom:18px;box-shadow:var(--shadow); }
.filter-row  { display:flex;gap:10px;flex-wrap:wrap;align-items:flex-end; }
.filter-group{ display:flex;flex-direction:column;gap:4px;flex:1;min-width:130px; }
.filter-group label { font-size:.72rem;font-weight:700;color:var(--muted); }
.filter-group input[type="date"],
.filter-group select {
    padding:8px 12px;border:1.5px solid var(--border);border-radius:8px;
    font-size:.84rem;background:#fff;font-family:inherit;
}
.filter-group input:focus,.filter-group select:focus { border-color:var(--navy);outline:none; }

/* View toggle buttons */
.view-toggle {
    display: inline-flex;
    border: 1.5px solid var(--border);
    border-radius: 9px;
    overflow: hidden;
    background: var(--light);
}
.view-toggle button {
    padding: 6px 13px;
    border: none;
    background: transparent;
    color: var(--muted);
    font-size: .82rem;
    cursor: pointer;
    display: flex; align-items: center; gap: 5px;
    transition: background .15s, color .15s;
    font-family: inherit;
}
.view-toggle button.active {
    background: var(--navy);
    color: var(--gold);
}
.view-toggle button:first-child { border-right: 1px solid var(--border); }

/* ── CARD MODE ── */
.posts-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 14px;
    margin-bottom: 20px;
}
.post-card {
    background: #fff; border: 1.5px solid var(--border);
    border-radius: 13px; padding: 0;
    box-shadow: var(--shadow); display: flex; flex-direction: column;
    transition: transform .2s, box-shadow .2s, border-color .2s;
    overflow: hidden;
}
.post-card:hover { transform: translateY(-3px); box-shadow: var(--shadow2); border-color: var(--gold2); }
.post-card.s-positive  { border-top: 3px solid #22c55e; }
.post-card.s-negative  { border-top: 3px solid #ef4444; }
.post-card.s-high_risk { border-top: 3px solid #7f1d1d; }
.post-card.s-neutral   { border-top: 3px solid #9ca3af; }
.pc-body { padding: 14px 16px; flex: 1; }
.pc-header { display:flex;align-items:center;gap:10px;margin-bottom:9px; }
.pc-avatar {
    width:38px;height:38px;border-radius:50%;
    background:linear-gradient(135deg,var(--navy),var(--navy2));
    color:var(--gold);font-weight:800;font-size:.9rem;
    display:flex;align-items:center;justify-content:center;flex-shrink:0;
}
.pc-name  { font-size:.88rem;font-weight:700;color:var(--navy); }
.pc-email { font-size:.68rem;color:var(--muted);margin-top:1px;display:flex;align-items:center;gap:3px; }
.pc-text {
    font-size:.82rem;color:#374151;line-height:1.6;
    display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;
    overflow:hidden;margin-bottom:9px;
    background:var(--light);border-radius:7px;padding:9px 11px;
}
.pc-chips { display:flex;flex-wrap:wrap;gap:4px;margin-bottom:3px; }
.pc-chip {
    display:inline-flex;align-items:center;gap:3px;
    padding:2px 8px;border-radius:999px;font-size:.6rem;font-weight:700;
}
.chip-prog  { background:#eef4ff;color:#1d4ed8;border:1px solid #bfdbfe; }
.chip-year  { background:#f0fdf4;color:#166534;border:1px solid #bbf7d0; }
.chip-pos   { background:#f0fdf4;color:#166534;border:1px solid #bbf7d0; }
.chip-neg   { background:#fef2f2;color:#dc2626;border:1px solid #fecaca; }
.chip-risk  { background:#7f1d1d;color:#fca5a5; }
.chip-neu   { background:#f3f4f6;color:#6b7280;border:1px solid #e5e7eb; }
.chip-ai    { background:linear-gradient(135deg,#0a1931,#1c2a4d);color:#f0c419; }
.chip-flag  { background:#7f1d1d;color:#fca5a5;animation:pulse 1.5s infinite; }
.pc-footer {
    display:flex;align-items:center;justify-content:space-between;
    padding:9px 16px;border-top:1px solid var(--border);background:var(--light);
}
.pc-date { font-size:.68rem;color:var(--muted); }
.pc-view-btn {
    display:inline-flex;align-items:center;gap:4px;padding:5px 12px;border-radius:7px;
    background:var(--navy);color:var(--gold);font-size:.72rem;font-weight:700;
    text-decoration:none;transition:opacity .18s;
}
.pc-view-btn:hover { opacity:.85;color:var(--gold);text-decoration:none; }

/* ── LIST MODE ── */
.posts-list { display:flex;flex-direction:column;gap:6px;margin-bottom:20px; }
.post-row {
    background:#fff;border:1.5px solid var(--border);border-radius:10px;
    display:flex;align-items:center;gap:14px;padding:11px 16px;
    box-shadow:0 1px 4px rgba(0,0,0,.04);
    transition:background .15s,border-color .15s;
    overflow:hidden;position:relative;
}
.post-row::before {
    content:'';position:absolute;left:0;top:0;bottom:0;width:4px;
}
.post-row.s-positive::before  { background:#22c55e; }
.post-row.s-negative::before  { background:#ef4444; }
.post-row.s-high_risk::before { background:#7f1d1d; }
.post-row.s-neutral::before   { background:#9ca3af; }
.post-row:hover { background:#fef9e7;border-color:var(--gold2); }
.pr-avatar {
    width:34px;height:34px;border-radius:50%;flex-shrink:0;
    background:linear-gradient(135deg,var(--navy),var(--navy2));
    color:var(--gold);font-weight:800;font-size:.82rem;
    display:flex;align-items:center;justify-content:center;
}
.pr-main { flex:1;min-width:0; }
.pr-name  { font-size:.86rem;font-weight:700;color:var(--navy);white-space:nowrap;overflow:hidden;text-overflow:ellipsis; }
.pr-email { font-size:.68rem;color:var(--muted); }
.pr-excerpt {
    font-size:.8rem;color:#374151;
    white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:320px;
    margin-top:2px;
}
.pr-meta { display:flex;flex-direction:column;align-items:flex-end;gap:4px;flex-shrink:0; }
.pr-date { font-size:.68rem;color:var(--muted);white-space:nowrap; }
.pr-chips{ display:flex;gap:4px;flex-wrap:wrap;justify-content:flex-end; }

/* ── Compact pagination ── */
.pagination-wrap nav { display:flex;justify-content:center; }
.pagination-wrap nav ul,
.pagination-wrap nav div[role="navigation"] {
    display: flex; gap: 4px; list-style: none;
    margin: 0; padding: 0; align-items: center; flex-wrap: wrap; justify-content: center;
}
.pagination-wrap span[aria-current="page"] span,
.pagination-wrap a,
.pagination-wrap button,
.pagination-wrap span {
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    min-width: 32px !important;
    height: 32px !important;
    padding: 0 10px !important;
    border-radius: 7px !important;
    font-size: .78rem !important;
    font-weight: 600 !important;
    border: 1.5px solid var(--border) !important;
    background: #fff !important;
    color: var(--text) !important;
    text-decoration: none !important;
    transition: all .15s !important;
    cursor: pointer !important;
}
.pagination-wrap a:hover { background: var(--light) !important; border-color: var(--navy) !important; }
.pagination-wrap span[aria-current="page"] span {
    background: var(--navy) !important;
    color: var(--gold) !important;
    border-color: var(--navy) !important;
    font-weight: 700 !important;
}
.pagination-wrap span[aria-disabled="true"] span {
    opacity: .4 !important;
    cursor: not-allowed !important;
}

@keyframes pulse { 0%,100%{opacity:1} 50%{opacity:.6} }
@keyframes spin   { to { transform:rotate(360deg); } }
</style>

<div class="top-bar">
    <h2 class="navigation-title">e-Hayag Posts</h2>
    <div style="display:flex;gap:8px;margin-left:auto;align-items:center;">

        {{-- View toggle --}}
        <div class="view-toggle" id="view-toggle">
            <button id="btn-card" onclick="setView('card')" title="Card view">
                <i class="fas fa-grip"></i> Cards
            </button>
            <button id="btn-list" onclick="setView('list')" title="List view">
                <i class="fas fa-list"></i> List
            </button>
        </div>

        <a href="{{ route('admin.freedomwall.highrisk') }}" class="top-button back"
           style="color:#dc2626;border-color:#fecaca;background:#fef2f2;">
            <i class="fas fa-triangle-exclamation"></i> High-Risk
        </a>
        <a href="{{ route('admin.freedomwall.export', request()->query()) }}" class="top-button add">
            <i class="fas fa-file-excel"></i> Export
        </a>
    </div>
</div>
<div class="nav-line-separator"></div>

{{-- Filters --}}
<div class="filter-card">
    <form method="GET" action="{{ route('admin.freedomwall.freedomwall') }}">
        {{-- preserve view mode across filter submits --}}
        <input type="hidden" name="view" id="filter-view-input" value="{{ request('view','card') }}">
        <div class="filter-row">
            <div class="filter-group">
                <label>Start Date</label>
                <input type="date" name="start_date" value="{{ request('start_date') }}">
            </div>
            <div class="filter-group">
                <label>End Date</label>
                <input type="date" name="end_date" value="{{ request('end_date') }}">
            </div>
            <div class="filter-group">
                <label>Sentiment</label>
                <select name="sentiment">
                    <option value="">All Sentiments</option>
                    @foreach(['positive','negative','neutral','high_risk'] as $s)
                    <option value="{{ $s }}" {{ request('sentiment')===$s?'selected':'' }}>
                        {{ ucfirst(str_replace('_',' ',$s)) }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="filter-group">
                <label>Program</label>
                <select name="program">
                    <option value="">All Programs</option>
                    @foreach(['ABCOMM','BMMA','BSCRIM','BSESS','BSPsych','BSA','BSAIS','BSTM','BSBA-DM','BSArch','BSCE','BSCpE','BSIT','BSCS','BSIS','GRADE-11','GRADE-12'] as $p)
                    <option value="{{ $p }}" {{ request('program')===$p?'selected':'' }}>{{ $p }}</option>
                    @endforeach
                </select>
            </div>
            <div style="display:flex;gap:7px;align-items:flex-end;">
                <button type="submit" class="filter-button"><i class="fas fa-filter"></i> Filter</button>
                <a href="{{ route('admin.freedomwall.freedomwall') }}"
                   style="padding:8px 13px;background:#f3f4f6;color:var(--text);border-radius:8px;
                          font-size:.78rem;font-weight:600;text-decoration:none;white-space:nowrap;">Reset</a>
                <a href="{{ route('admin.freedomwall.freedomwall', ['start_date'=>now()->toDateString(),'end_date'=>now()->toDateString()]) }}"
                   style="padding:8px 13px;background:var(--navy);color:var(--gold);border-radius:8px;
                          font-size:.78rem;font-weight:700;text-decoration:none;white-space:nowrap;">Today</a>
            </div>
        </div>
    </form>
</div>

{{-- Toolbar row --}}
<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px;flex-wrap:wrap;gap:10px;">
    <div style="font-size:.82rem;color:var(--muted);">
        <strong style="color:var(--navy);">{{ $entries->total() }}</strong> posts found
        &nbsp;·&nbsp; page {{ $entries->currentPage() }} of {{ $entries->lastPage() }}
    </div>
    <button id="bulk-ai-btn" onclick="bulkAnalyse()"
            style="display:inline-flex;align-items:center;gap:7px;padding:7px 16px;
                   background:linear-gradient(135deg,#0a1931,#1c2a4d);color:#f0c419;
                   border:none;border-radius:9px;font-size:.8rem;font-weight:700;cursor:pointer;">
        <i class="fas fa-brain"></i>
        <span id="bulk-label">AI Analyse</span>
        <span id="bulk-spinner" style="display:none;width:13px;height:13px;border:2px solid rgba(240,196,25,.3);
              border-top-color:#f0c419;border-radius:50%;animation:spin .7s linear infinite;"></span>
    </button>
</div>

{{-- ── CARD VIEW ── --}}
<div id="view-cards">
    <div class="posts-grid">
        @forelse($entries as $post)
        @php $s = $post->sentiment ?? 'neutral'; @endphp
        <div class="post-card s-{{ $s }}">
            <div class="pc-body">
                <div class="pc-header">
                    <div class="pc-avatar">{{ strtoupper(substr($post->postName,0,1)) }}</div>
                    <div>
                        <div class="pc-name">{{ $post->postName }}</div>
                        @if($post->student_email)
                        <div class="pc-email">
                            <i class="fas fa-envelope" style="font-size:.58rem;"></i>
                            {{ $post->student_email }}
                        </div>
                        @endif
                    </div>
                </div>
                <div class="pc-text">{{ $post->post }}</div>
                <div class="pc-chips">
                    @if($post->program)<span class="pc-chip chip-prog">{{ $post->program }}</span>@endif
                    @if($post->year_level)<span class="pc-chip chip-year">{{ $post->year_level }}</span>@endif
                    @php $sc = match($s){ 'positive'=>'pos','negative'=>'neg','high_risk'=>'risk',default=>'neu' }; @endphp
                    <span class="pc-chip chip-{{ $sc }}">🔤 {{ strtoupper(str_replace('_',' ',$s)) }}</span>
                    @if($post->ai_sentiment)
                        <span class="pc-chip chip-ai">🤖 {{ strtoupper(str_replace('_',' ',$post->ai_sentiment)) }}</span>
                    @endif
                    @if($post->ai_flagged)
                        <span class="pc-chip chip-flag">🚨 FLAGGED</span>
                    @endif
                </div>
            </div>
            <div class="pc-footer">
                <div class="pc-date">
                    <i class="fas fa-clock" style="font-size:.58rem;margin-right:2px;"></i>
                    {{ $post->created_at->format('M d, Y • h:i A') }}
                </div>
                <a href="{{ route('admin.freedomwall.details', $post->id) }}" class="pc-view-btn">
                    <i class="fas fa-eye"></i> View
                </a>
            </div>
        </div>
        @empty
        <div style="grid-column:1/-1;text-align:center;padding:52px;background:#fff;
                    border-radius:14px;border:1.5px solid var(--border);color:#9ca3af;">
            <i class="fas fa-comment-slash" style="font-size:2rem;display:block;margin-bottom:10px;"></i>
            No posts found.
        </div>
        @endforelse
    </div>
</div>

{{-- ── LIST VIEW ── --}}
<div id="view-list" style="display:none;">
    <div class="posts-list">
        @forelse($entries as $post)
        @php $s = $post->sentiment ?? 'neutral'; @endphp
        <div class="post-row s-{{ $s }}">
            <div class="pr-avatar">{{ strtoupper(substr($post->postName,0,1)) }}</div>
            <div class="pr-main">
                <div class="pr-name">{{ $post->postName }}</div>
                @if($post->student_email)
                <div class="pr-email">
                    <i class="fas fa-envelope" style="font-size:.6rem;margin-right:3px;"></i>{{ $post->student_email }}
                </div>
                @endif
                <div class="pr-excerpt">{{ $post->post }}</div>
            </div>
            <div class="pr-meta">
                <div class="pr-date">{{ $post->created_at->format('M d, Y') }}</div>
                <div class="pr-chips">
                    @if($post->program)<span class="pc-chip chip-prog" style="font-size:.58rem;">{{ $post->program }}</span>@endif
                    @php $sc = match($s){ 'positive'=>'pos','negative'=>'neg','high_risk'=>'risk',default=>'neu' }; @endphp
                    <span class="pc-chip chip-{{ $sc }}" style="font-size:.58rem;">{{ strtoupper(str_replace('_',' ',$s)) }}</span>
                    @if($post->ai_flagged)<span class="pc-chip chip-flag" style="font-size:.58rem;">🚨</span>@endif
                </div>
                <a href="{{ route('admin.freedomwall.details', $post->id) }}" class="pc-view-btn" style="padding:4px 11px;font-size:.7rem;">
                    <i class="fas fa-eye"></i> View
                </a>
            </div>
        </div>
        @empty
        <div style="text-align:center;padding:48px;background:#fff;border-radius:12px;
                    border:1.5px solid var(--border);color:#9ca3af;">
            <i class="fas fa-comment-slash" style="font-size:2rem;display:block;margin-bottom:10px;"></i>
            No posts found.
        </div>
        @endforelse
    </div>
</div>

{{-- Compact pagination --}}
<div class="pagination-wrap">
    {{ $entries->appends(request()->except('page'))->links() }}
</div>

<script>
// ── View mode (card / list) ───────────────────────────────────
const VIEW_KEY = 'ehayag_view_mode';

function setView(mode) {
    localStorage.setItem(VIEW_KEY, mode);
    applyView(mode);
    // Update hidden input so filter form preserves mode
    const inp = document.getElementById('filter-view-input');
    if (inp) inp.value = mode;
}

function applyView(mode) {
    const cards  = document.getElementById('view-cards');
    const list   = document.getElementById('view-list');
    const btnC   = document.getElementById('btn-card');
    const btnL   = document.getElementById('btn-list');
    if (!cards || !list) return;

    if (mode === 'list') {
        cards.style.display = 'none';
        list.style.display  = 'block';
        btnC.classList.remove('active');
        btnL.classList.add('active');
    } else {
        cards.style.display = 'block';
        list.style.display  = 'none';
        btnC.classList.add('active');
        btnL.classList.remove('active');
    }
}

document.addEventListener('DOMContentLoaded', function () {
    // URL param takes priority, then localStorage, then default card
    const urlMode = '{{ request('view', '') }}';
    const saved   = urlMode || localStorage.getItem(VIEW_KEY) || 'card';
    applyView(saved);
});

// ── Bulk AI ───────────────────────────────────────────────────
async function bulkAnalyse() {
    const btn   = document.getElementById('bulk-ai-btn');
    const label = document.getElementById('bulk-label');
    const sp    = document.getElementById('bulk-spinner');
    btn.disabled = true; label.textContent = 'Analysing…'; sp.style.display = 'inline-block';
    try {
        const res  = await fetch('{{ route('admin.freedomwall.ai_bulk_analyze') }}', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json', 'Content-Type': 'application/json' },
        });
        const data = await res.json();
        label.textContent = data.message || 'Done';
        setTimeout(() => location.reload(), 1200);
    } catch(e) {
        label.textContent = 'Error — try again';
    } finally {
        btn.disabled = false; sp.style.display = 'none';
    }
}
</script>

</x-app-layout>
