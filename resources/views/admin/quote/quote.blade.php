<x-app-layout title="Quotes">

<style>
/* AI Panel */
.ai-panel {
    background: linear-gradient(135deg, #0a1931 0%, #1c2a4d 100%);
    border-radius: 16px; padding: 24px 28px; margin-bottom: 28px;
    border: 1.5px solid rgba(240,196,25,.2);
    box-shadow: 0 8px 32px rgba(10,25,49,.2);
}
.ai-badge {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 4px 12px; border-radius: 999px;
    background: rgba(240,196,25,.15); border: 1px solid rgba(240,196,25,.35);
    color: #f0c419; font-size: .7rem; font-weight: 800;
    text-transform: uppercase; letter-spacing: .5px;
}
.ai-row {
    display: flex; gap: 10px; flex-wrap: wrap; align-items: flex-end; margin: 16px 0 10px;
}
.ai-theme-input {
    flex: 1; min-width: 200px;
    padding: 10px 14px;
    background: rgba(255,255,255,.08); border: 1.5px solid rgba(255,255,255,.15);
    border-radius: 9px; color: #fff; font-size: .9rem; font-family: inherit;
}
.ai-theme-input::placeholder { color: rgba(255,255,255,.35); }
.ai-theme-input:focus { border-color: rgba(240,196,25,.5); outline: none; }
.ai-select {
    padding: 10px 12px; min-width: 90px;
    background: rgba(255,255,255,.08); border: 1.5px solid rgba(255,255,255,.15);
    border-radius: 9px; color: #fff; font-size: .88rem; font-family: inherit; cursor: pointer;
}
.ai-select:focus { border-color: rgba(240,196,25,.5); outline: none; }
.ai-select option { background: #0a1931; }
.btn-generate {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 10px 22px;
    background: linear-gradient(135deg, #c9a227, #f0c419);
    color: #0a1931; border: none; border-radius: 9px;
    font-size: .88rem; font-weight: 800; cursor: pointer;
    transition: transform .2s, box-shadow .2s; white-space: nowrap;
}
.btn-generate:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(201,162,39,.4); }
.btn-generate:disabled { opacity: .6; cursor: not-allowed; transform: none; box-shadow: none; }
.ai-spinner { width:16px;height:16px;border:2px solid rgba(10,25,49,.3);
              border-top-color:#0a1931;border-radius:50%;animation:spin .7s linear infinite;display:none; }
@keyframes spin { to { transform: rotate(360deg); } }

/* Options row */
.ai-opts { display:flex;gap:16px;flex-wrap:wrap;margin-bottom:4px; }
.ai-opt-label {
    display: flex; align-items: center; gap: 7px;
    font-size: .8rem; font-weight: 600; color: rgba(255,255,255,.7); cursor: pointer;
}
.ai-opt-label input[type="checkbox"] { width:15px;height:15px;accent-color:#f0c419;cursor:pointer; }

/* Previews */
.ai-previews { display:none;flex-direction:column;gap:10px;margin-top:14px; }
.ai-previews.visible { display:flex; }
.ai-preview-item {
    background: rgba(255,255,255,.06); border: 1.5px solid rgba(255,255,255,.1);
    border-radius: 12px; padding: 16px 18px;
    display: flex; align-items: flex-start; justify-content: space-between; gap: 14px;
}
.ai-preview-item .quote-block { flex: 1; }
.ai-preview-label { font-size:.62rem;font-weight:800;color:#f0c419;
                    text-transform:uppercase;letter-spacing:.5px;margin-bottom:7px; }
.ai-preview-quote { font-size:.94rem;font-style:italic;color:rgba(255,255,255,.92);line-height:1.65;margin-bottom:4px; }
.ai-preview-author{ font-size:.78rem;font-weight:700;color:rgba(255,255,255,.5); }
.btn-save-one {
    display:inline-flex;align-items:center;gap:5px;padding:7px 14px;
    background:#f0c419;color:#0a1931;border:none;border-radius:8px;
    font-size:.75rem;font-weight:800;cursor:pointer;transition:opacity .18s;
    white-space:nowrap;flex-shrink:0;
}
.btn-save-one:hover { opacity:.88; }
.ai-save-all-row { display:none;align-items:center;gap:10px;margin-top:10px;flex-wrap:wrap; }
.ai-save-all-row.visible { display:flex; }
.btn-save-all {
    display:inline-flex;align-items:center;gap:6px;padding:9px 20px;
    background:#f0c419;color:#0a1931;border:none;border-radius:9px;
    font-size:.84rem;font-weight:800;cursor:pointer;transition:opacity .18s;
}
.btn-save-all:hover { opacity:.88; }
.btn-regen {
    display:inline-flex;align-items:center;gap:6px;padding:9px 16px;
    background:rgba(255,255,255,.1);color:rgba(255,255,255,.8);
    border:1.5px solid rgba(255,255,255,.2);border-radius:9px;
    font-size:.84rem;font-weight:700;cursor:pointer;transition:background .2s;
}
.btn-regen:hover { background:rgba(255,255,255,.18); }
.ai-error-msg { color:#fca5a5;font-size:.82rem;margin-top:10px;display:none; }

/* Quote table */
.quote-table { width:100%;border-collapse:collapse;background:#fff;border-radius:14px;
               overflow:hidden;box-shadow:var(--shadow);border:1.5px solid var(--border); }
.quote-table thead tr { background:linear-gradient(135deg,#0a1931,#1c2a4d); }
.quote-table thead th { padding:13px 16px;font-size:.68rem;font-weight:800;color:#f0c419;
                        text-transform:uppercase;letter-spacing:.6px;text-align:left;border:none; }
.quote-table tbody tr { border-bottom:1px solid var(--border);transition:background .15s; }
.quote-table tbody tr:last-child { border-bottom:none; }
.quote-table tbody tr:hover { background:#fef9e7; }
.quote-table td { padding:14px 16px;font-size:.88rem;color:var(--text);vertical-align:middle; }
</style>

<div class="top-bar">
    <h2 class="navigation-title">Quotes</h2>
    <a href="{{ route('admin.quote.add') }}" class="top-button add">
        <i class="fas fa-plus"></i> Add Manually
    </a>
</div>
<div class="nav-line-separator"></div>

{{-- ── AI PANEL ── --}}
<div class="ai-panel">
    <div style="display:flex;align-items:center;gap:10px;margin-bottom:6px;">
        <span class="ai-badge"><i class="fas fa-wand-magic-sparkles"></i> AI Powered</span>
        <div>
            <div style="color:#fff;font-size:.95rem;font-weight:700;">AI Quote Generator</div>
            <div style="color:rgba(255,255,255,.5);font-size:.75rem;">
                Generate 1, 5, 10, or 20 original quotes — then save, edit, or regenerate
            </div>
        </div>
    </div>

    <div class="ai-row">
        <input type="text" id="ai-theme" class="ai-theme-input"
               placeholder="Theme (e.g. hope, resilience, anxiety, student stress…)"
               value="mental health, hope, and student resilience">
        <select id="ai-count" class="ai-select" title="Number of quotes to generate">
            <option value="1">1 Quote</option>
            <option value="5">5 Quotes</option>
            <option value="10">10 Quotes</option>
            <option value="20">20 Quotes</option>
        </select>
        <button id="btn-generate" class="btn-generate" onclick="generateQuotes()">
            <span id="gen-label"><i class="fas fa-wand-magic-sparkles"></i> Generate</span>
            <div class="ai-spinner" id="gen-spinner"></div>
        </button>
    </div>

    {{-- Options --}}
    <div class="ai-opts">
        <label class="ai-opt-label">
            <input type="checkbox" id="opt-real-author" checked>
            Attribute to a real historical person when possible
        </label>
        <label class="ai-opt-label">
            <input type="checkbox" id="opt-guidance">
            Focus on student guidance / mental wellness
        </label>
    </div>

    {{-- Error --}}
    <div class="ai-error-msg" id="ai-error-msg">
        <i class="fas fa-circle-exclamation me-1"></i><span id="ai-error-text"></span>
    </div>

    {{-- Previews list --}}
    <div class="ai-previews" id="ai-previews"></div>

    {{-- Save-all row --}}
    <div class="ai-save-all-row" id="ai-save-all-row">
        <button class="btn-save-all" onclick="saveAllQuotes()">
            <i class="fas fa-floppy-disk"></i> Save All
        </button>
        <button class="btn-regen" onclick="generateQuotes()">
            <i class="fas fa-rotate-right"></i> Regenerate
        </button>
    </div>
</div>

{{-- Hidden bulk-save form --}}
<form id="bulk-save-form" action="{{ route('admin.quote.store') }}" method="POST" style="display:none;">
    @csrf
    <input type="hidden" name="quote"  id="bulk-quote-val">
    <input type="hidden" name="author" id="bulk-author-val">
</form>

{{-- ── QUOTES TABLE ── --}}
<div style="overflow-x:auto;">
    <table class="quote-table">
        <thead>
            <tr><th>#</th><th>Quote</th><th>Author</th><th>Added</th><th>Actions</th></tr>
        </thead>
        <tbody>
            @forelse($quotes as $i => $quote)
            <tr>
                <td style="color:#9ca3af;font-size:.75rem;">{{ $i+1 }}</td>
                <td>
                    <div style="font-style:italic;color:#374151;line-height:1.55;">
                        "{{ Str::limit($quote->quote, 150) }}"
                    </div>
                </td>
                <td style="font-size:.8rem;font-weight:700;color:var(--muted);white-space:nowrap;">
                    — {{ $quote->author ?? 'Unknown' }}
                </td>
                <td style="color:#9ca3af;font-size:.75rem;white-space:nowrap;">
                    {{ $quote->created_at->format('M d, Y') }}
                </td>
                <td style="white-space:nowrap;">
                    <a href="{{ route('admin.quote.edit', $quote->id) }}"
                       class="btn-tbl btn-tbl-edit">
                        <i class="fas fa-pen"></i>
                    </a>
                    <form id="del-q-{{ $quote->id }}"
                          action="{{ route('admin.quote.destroy', $quote->id) }}"
                          method="POST" style="display:inline;margin-left:5px;">
                        @csrf @method('DELETE')
                    </form>
                    <button type="button"
                            class="btn-tbl btn-tbl-del"
                            onclick="confirmDelete('del-q-{{ $quote->id }}','this quote')">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align:center;padding:48px;color:#9ca3af;">
                    <i class="fas fa-quote-left" style="font-size:2rem;display:block;margin-bottom:10px;"></i>
                    No quotes yet. Use the AI generator above or add one manually.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<script>
const GENERATE_URL = '{{ route('admin.quote.ai_generate') }}';
const STORE_URL    = '{{ route('admin.quote.store') }}';
const CSRF         = '{{ csrf_token() }}';
const EDIT_URL     = '{{ route('admin.quote.add') }}';

let generatedQuotes = [];

async function generateQuotes() {
    const btn    = document.getElementById('btn-generate');
    const label  = document.getElementById('gen-label');
    const sp     = document.getElementById('gen-spinner');
    const errMsg = document.getElementById('ai-error-msg');
    const errTxt = document.getElementById('ai-error-text');

    btn.disabled = true; label.style.display='none'; sp.style.display='block';
    errMsg.style.display='none';
    document.getElementById('ai-previews').classList.remove('visible');
    document.getElementById('ai-save-all-row').classList.remove('visible');
    document.getElementById('ai-previews').innerHTML = '';

    const theme       = document.getElementById('ai-theme').value.trim() || 'mental health, hope, and student resilience';
    const count       = parseInt(document.getElementById('ai-count').value, 10);
    const realAuthor  = document.getElementById('opt-real-author').checked;
    const guidance    = document.getElementById('opt-guidance').checked;

    const fullTheme = (guidance ? 'student mental health and guidance office context about ' : '') + theme;

    try {
        const promises = [];
        for (let i = 0; i < count; i++) {
            promises.push(
                fetch(GENERATE_URL, {
                    method: 'POST',
                    headers: { 'Content-Type':'application/json','X-CSRF-TOKEN':CSRF,'Accept':'application/json' },
                    body: JSON.stringify({ theme: fullTheme, real_author: realAuthor }),
                }).then(r => r.json())
            );
        }
        const results = await Promise.all(promises);

        generatedQuotes = results.filter(d => d.quote && !d.error);
        const errors    = results.filter(d => d.error);

        if (generatedQuotes.length === 0) {
            errTxt.textContent = errors[0]?.error || 'Generation failed. Please try again.';
            errMsg.style.display = 'block';
            return;
        }
        if (errors.length > 0) {
            errTxt.textContent = `${errors.length} of ${count} quote(s) failed.`;
            errMsg.style.display = 'block';
        }

        renderPreviews();

    } catch(e) {
        errTxt.textContent = 'Network error. Please try again.';
        errMsg.style.display = 'block';
    } finally {
        btn.disabled=false; label.style.display='inline'; sp.style.display='none';
    }
}

function renderPreviews() {
    const container = document.getElementById('ai-previews');
    container.innerHTML = '';
    generatedQuotes.forEach((q, idx) => {
        const div = document.createElement('div');
        div.className = 'ai-preview-item';
        div.id = `preview-${idx}`;
        div.innerHTML = `
            <div class="quote-block">
                <div class="ai-preview-label"><i class="fas fa-robot" style="margin-right:4px;"></i>Generated Quote ${generatedQuotes.length > 1 ? (idx+1) + ' of ' + generatedQuotes.length : ''}</div>
                <div class="ai-preview-quote">"${escHtml(q.quote)}"</div>
                <div class="ai-preview-author">— ${escHtml(q.author || 'Guidance Services Office')}</div>
            </div>
            <div style="display:flex;flex-direction:column;gap:6px;flex-shrink:0;">
                <button class="btn-save-one" onclick="saveSingle(${idx})">
                    <i class="fas fa-floppy-disk"></i> Save
                </button>
                <button class="btn-save-one" style="background:rgba(255,255,255,.12);color:rgba(255,255,255,.8);border:1px solid rgba(255,255,255,.2);"
                        onclick="editSingle(${idx})">
                    <i class="fas fa-pen"></i> Edit
                </button>
            </div>`;
        container.appendChild(div);
    });
    container.classList.add('visible');
    document.getElementById('ai-save-all-row').classList.toggle('visible', generatedQuotes.length > 1);
}

function escHtml(str) {
    return String(str).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}

async function saveSingle(idx) {
    const q = generatedQuotes[idx];
    if (!q) return;
    const res = await fetch(STORE_URL, {
        method:'POST',
        headers:{'Content-Type':'application/json','X-CSRF-TOKEN':CSRF,'Accept':'application/json',
                 'X-Requested-With':'XMLHttpRequest'},
        body: JSON.stringify({ quote: q.quote, author: q.author }),
    });
    if (res.ok || res.status===302) {
        const el = document.getElementById(`preview-${idx}`);
        if(el){ el.style.opacity='.4'; el.style.pointerEvents='none';
                el.querySelector('.quote-block').innerHTML += '<div style="color:#86efac;font-size:.75rem;margin-top:6px;"><i class="fas fa-check"></i> Saved</div>'; }
    } else {
        // Fallback: submit via hidden form
        document.getElementById('bulk-quote-val').value  = q.quote;
        document.getElementById('bulk-author-val').value = q.author;
        document.getElementById('bulk-save-form').submit();
    }
}

async function saveAllQuotes() {
    for (let i = 0; i < generatedQuotes.length; i++) {
        await saveSingle(i);
    }
    setTimeout(() => location.reload(), 900);
}

function editSingle(idx) {
    const q = generatedQuotes[idx];
    if (!q) return;
    const params = new URLSearchParams({ quote: q.quote, author: q.author });
    window.location.href = EDIT_URL + '?' + params.toString();
}
</script>

</x-app-layout>
