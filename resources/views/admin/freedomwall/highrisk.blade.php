<x-app-layout title="High-Risk Posts">

<style>
.risk-card {
    background: #fff; border: 2px solid rgba(239,68,68,.22);
    border-radius: 14px; padding: 20px 22px; margin-bottom: 16px;
    position: relative; overflow: hidden;
    box-shadow: 0 3px 12px rgba(239,68,68,.07);
    max-width: 860px; margin-left: auto; margin-right: auto;
}
.risk-card::before {
    content:''; position:absolute; top:0; left:0; width:5px; height:100%;
    background: linear-gradient(180deg, #ef4444, #b91c1c);
}
.risk-card.alerted { border-color: rgba(34,197,94,.3); }
.risk-card.alerted::before { background: linear-gradient(180deg, #22c55e, #16a34a); }
.risk-avatar {
    width:44px; height:44px; border-radius:50%;
    background: linear-gradient(135deg, #7f1d1d, #b91c1c);
    color:#fca5a5; display:flex; align-items:center;
    justify-content:center; font-size:1rem; font-weight:800; flex-shrink:0;
}
.rchip { display:inline-flex;align-items:center;padding:3px 9px;border-radius:999px;
         font-size:.68rem;font-weight:700;margin-right:4px;margin-bottom:4px; }
.rchip.risk    { background:#7f1d1d;color:#fca5a5; }
.rchip.program { background:#eef4ff;color:#1d4ed8; }
.rchip.year    { background:#f0fdf4;color:#166534; }
.rchip.alerted { background:#f0fdf4;color:#166534;border:1px solid #bbf7d0; }
.post-body {
    background:#fef2f2; border:1px solid #fecaca; border-radius:9px;
    padding:12px 16px; font-size:.88rem; line-height:1.7;
    color:#374151; white-space:pre-wrap; margin:10px 0;
}
.ai-note {
    background:linear-gradient(135deg,#0a1931,#1c2a4d); border-radius:9px;
    padding:11px 16px; font-size:.84rem; line-height:1.6;
    color:rgba(255,255,255,.85); font-style:italic;
    border-left:4px solid #c9a227; margin-bottom:10px;
}
.btn-view {
    display:inline-flex;align-items:center;gap:5px;padding:6px 14px;
    background:linear-gradient(135deg,#0a1931,#1c2a4d);color:#f0c419;
    border-radius:7px;font-size:.78rem;font-weight:700;text-decoration:none;transition:opacity .2s;
}
.btn-view:hover { opacity:.85;color:#f0c419;text-decoration:none; }
.empty-state {
    text-align:center;padding:56px 20px;background:#fff;border-radius:14px;
    border:1.5px solid var(--border);max-width:440px;margin:0 auto;
}

/* ── Compact Alert Panel ── */
.alert-panel {
    max-width:860px; margin:0 auto 22px;
    background:#fff; border:1.5px solid var(--border);
    border-radius:14px; box-shadow:var(--shadow);
    overflow:hidden;
}
.alert-panel-header {
    display:flex; align-items:center; justify-content:space-between;
    padding:14px 20px; cursor:pointer;
    background: linear-gradient(135deg,#0a1931,#1c2a4d);
    user-select:none;
}
.alert-panel-header .aph-left {
    display:flex; align-items:center; gap:10px;
}
.alert-panel-header .aph-badge {
    display:inline-flex;align-items:center;gap:5px;
    padding:3px 10px;border-radius:999px;
    background:rgba(240,196,25,.18);border:1px solid rgba(240,196,25,.35);
    color:#f0c419;font-size:.68rem;font-weight:800;text-transform:uppercase;letter-spacing:.4px;
}
.alert-panel-header .aph-title {
    font-size:.9rem; font-weight:700; color:#fff;
}
.alert-panel-header .aph-sub {
    font-size:.72rem; color:rgba(255,255,255,.45);
}
.alert-panel-header .aph-arrow {
    color:rgba(255,255,255,.5); font-size:.85rem;
    transition:transform .25s;
}
.alert-panel-header .aph-arrow.open { transform:rotate(180deg); }
.alert-panel-body {
    padding:18px 20px; display:none;
}
.alert-panel-body.open { display:block; }

/* Recipient mini-chips */
.mini-chips { display:flex;flex-wrap:wrap;gap:6px;margin-bottom:12px; }
.mini-chip {
    display:inline-flex;align-items:center;gap:5px;
    padding:4px 11px;border-radius:999px;
    background:#f3f4f6;border:1.5px solid var(--border);
    color:var(--text);font-size:.75rem;font-weight:600;cursor:pointer;
    transition:all .15s; user-select:none;
}
.mini-chip.selected {
    background:var(--navy);color:var(--gold);border-color:var(--navy);
}
.mini-chip input[type="checkbox"] { display:none; }

/* Post mini-list */
.mini-post-list { display:flex;flex-direction:column;gap:5px;margin-bottom:14px; }
.mini-post-row {
    display:flex;align-items:center;gap:8px;
    padding:8px 12px;border-radius:8px;
    background:var(--light);border:1px solid var(--border);
    cursor:pointer; transition:background .15s;
    font-size:.82rem;
}
.mini-post-row:hover { background:#fef9e7; }
.mini-post-row input[type="checkbox"] {
    width:15px;height:15px;accent-color:var(--navy);cursor:pointer;flex-shrink:0;
}
.mini-post-row .mpr-name  { font-weight:600;color:var(--navy); }
.mini-post-row .mpr-time  { font-size:.7rem;color:var(--muted); }
.mini-post-row .mpr-sent  { margin-left:auto;font-size:.68rem;font-weight:700;
                              color:#16a34a;display:flex;align-items:center;gap:3px; }
.mini-post-row .mpr-new   { margin-left:auto;font-size:.68rem;font-weight:700;
                              color:var(--muted); }

.btn-send-compact {
    display:inline-flex;align-items:center;gap:7px;padding:9px 20px;
    background:linear-gradient(135deg,#0a1931,#1c2a4d);color:var(--gold);
    border:none;border-radius:9px;font-size:.84rem;font-weight:700;
    cursor:pointer;transition:opacity .18s;
}
.btn-send-compact:hover { opacity:.86; }
.btn-send-compact:disabled { opacity:.45;cursor:not-allowed; }
.btn-send-spinner { width:14px;height:14px;border:2px solid rgba(240,196,25,.25);
                    border-top-color:var(--gold);border-radius:50%;
                    animation:spin .7s linear infinite;display:none; }
@keyframes spin { to { transform:rotate(360deg); } }
.send-result { margin-top:10px;padding:9px 14px;border-radius:8px;
               font-size:.82rem;font-weight:600;display:none; }
.send-result.ok  { background:#f0fdf4;border:1px solid #bbf7d0;color:#166534; }
.send-result.err { background:#fef2f2;border:1px solid #fecaca;color:#dc2626; }

.auto-alert-badge {
    display:inline-flex;align-items:center;gap:5px;padding:4px 10px;
    border-radius:999px;background:#f0fdf4;border:1px solid #bbf7d0;
    color:#166534;font-size:.68rem;font-weight:700;
}
</style>

<div class="top-bar">
    <div>
        <h2 class="navigation-title">🚨 High-Risk Posts — Today</h2>
        <p style="color:var(--muted);font-size:.82rem;margin-top:2px;">
            Flagged by keyword or AI on {{ now()->format('F j, Y') }}
        </p>
    </div>
    <a href="{{ route('admin.freedomwall.analytics') }}" class="top-button back">← Analytics</a>
</div>
<div class="nav-line-separator"></div>

@if($posts->count() === 0)
    <div class="empty-state">
        <div style="font-size:2.8rem;margin-bottom:14px;">✅</div>
        <h3 style="font-size:1.05rem;font-weight:700;color:var(--navy);margin-bottom:6px;">No high-risk posts today</h3>
        <p style="color:var(--muted);font-size:.86rem;margin-bottom:16px;">
            No posts flagged by keyword or AI for today.
        </p>
        <a href="{{ route('admin.freedomwall.freedomwall') }}" class="btn-view">View All Posts</a>
    </div>
@endif

{{-- ══ COMPACT ALERT PANEL — always visible ══ --}}
<div class="alert-panel">
    {{-- Collapsible header --}}
    <div class="alert-panel-header" onclick="toggleAlertPanel()">
        <div class="aph-left">
            <span class="aph-badge"><i class="fas fa-bell"></i> Email Alert</span>
            <div>
                <div class="aph-title">Alert Counselors by Email</div>
                <div class="aph-sub">
                    @if($alertRecipients->count())
                        {{ $alertRecipients->count() }} recipient{{ $alertRecipients->count()>1?'s':'' }} configured
                        ·
                    @endif
                    Auto-send is <strong style="color:{{ $alertRecipients->count() ? '#86efac' : '#fca5a5' }};">
                        {{ $alertRecipients->count() ? 'ON' : 'OFF (no recipients set)' }}
                    </strong>
                    @if($alertRecipients->count())
                        <span class="auto-alert-badge" style="margin-left:6px;">
                            <i class="fas fa-robot" style="font-size:.6rem;"></i> Auto-sending enabled
                        </span>
                    @endif
                </div>
            </div>
        </div>
        <i class="fas fa-chevron-down aph-arrow" id="aph-arrow"></i>
    </div>

    {{-- Collapsible body --}}
    <div class="alert-panel-body" id="alert-body">

        <p style="font-size:.8rem;color:var(--muted);line-height:1.6;margin-bottom:14px;">
            <i class="fas fa-robot" style="color:var(--navy);margin-right:5px;"></i>
            <strong>Automatic alerts</strong> are sent when a post is detected as high-risk (keyword or AI).
            Use this panel to <strong>manually re-send</strong> or send for specific posts.
            Each post can only be alerted <em>once</em> — already-alerted posts show in green.
        </p>

        {{-- Recipients --}}
        @if($alertRecipients->count() || $counselors->count())
        <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:8px;margin-bottom:7px;">
            <div style="font-size:.68rem;font-weight:800;color:var(--muted);text-transform:uppercase;letter-spacing:.4px;">
                Recipients
            </div>
            <button type="button" onclick="saveRecipientSelection()"
                    id="btn-save-recipients"
                    style="display:inline-flex;align-items:center;gap:5px;
                           padding:4px 12px;border-radius:7px;
                           background:#f0fdf4;color:#166534;border:1px solid #bbf7d0;
                           font-size:.72rem;font-weight:700;cursor:pointer;transition:all .18s;"
                    title="Save current selection so it persists after refresh">
                <i class="fas fa-floppy-disk"></i> Save Selection
            </button>
        </div>
        <div class="mini-chips" id="mini-recipient-list">
            @foreach($alertRecipients as $email)
            <label class="mini-chip selected">
                <input type="checkbox" value="{{ $email }}" checked>
                <i class="fas fa-envelope" style="font-size:.6rem;"></i>
                {{ Str::limit($email, 28) }}
            </label>
            @endforeach
            @foreach($counselors as $c)
                @if(!$alertRecipients->contains($c->email))
                <label class="mini-chip">
                    <input type="checkbox" value="{{ $c->email }}">
                    <i class="fas fa-user-tie" style="font-size:.6rem;"></i>
                    {{ $c->name }}
                </label>
                @endif
            @endforeach
        </div>
        <div id="save-recipients-result"
             style="display:none;font-size:.72rem;font-weight:600;
                    padding:6px 12px;border-radius:7px;margin-bottom:8px;"></div>
        @else
        <div style="padding:10px 14px;background:var(--light);border:1px solid var(--border);
                    border-radius:8px;margin-bottom:14px;font-size:.8rem;color:var(--muted);">
            <i class="fas fa-info-circle me-1"></i>
            No recipients configured. Add them in
            <a href="{{ route('admin.settings.index') }}" style="color:var(--navy);font-weight:600;">Settings</a>.
        </div>
        @endif

        {{-- Posts --}}
        <div style="font-size:.68rem;font-weight:800;color:var(--muted);text-transform:uppercase;
                     letter-spacing:.4px;margin-bottom:7px;">Posts to Alert About</div>
        @if($posts->count() > 0)
        <div class="mini-post-list" id="mini-post-list">
            @foreach($posts as $post)
            @php $alerted = in_array($post->id, $alertedIds); @endphp
            <label class="mini-post-row" style="{{ $alerted ? 'opacity:.55;cursor:not-allowed;' : '' }}">
                <input type="checkbox" class="mini-post-cb" value="{{ $post->id }}"
                       {{ !$alerted ? 'checked' : 'disabled' }}>
                <div>
                    <div class="mpr-name">{{ $post->postName }}</div>
                    <div class="mpr-time">{{ $post->created_at->format('h:i A') }}
                        @if($post->program) · {{ $post->program }}@endif</div>
                </div>
                @if($alerted)
                    <div class="mpr-sent"><i class="fas fa-check-circle"></i> Sent</div>
                @else
                    <div class="mpr-new"><i class="fas fa-clock"></i> Pending</div>
                @endif
            </label>
            @endforeach
        </div>
        @else
        <div style="padding:10px 14px;background:var(--light);border:1px solid var(--border);
                    border-radius:8px;margin-bottom:14px;font-size:.8rem;color:var(--muted);">
            <i class="fas fa-circle-check" style="color:#16a34a;margin-right:5px;"></i>
            No high-risk posts today — nothing to alert about yet.
            Alerts will appear here automatically when a post is flagged.
        </div>
        @endif

        {{-- Send button --}}
        <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
            <button id="btn-send" class="btn-send-compact" onclick="sendAlerts()">
                <span id="send-label"><i class="fas fa-paper-plane"></i> Send Alert</span>
                <div class="btn-send-spinner" id="send-spinner"></div>
            </button>
            <span style="font-size:.72rem;color:var(--muted);">
                Only unalerted posts will be sent.
            </span>
        </div>
        <div class="send-result" id="send-result"></div>
    </div>
</div>

{{-- Posts section — only when posts exist --}}
@if($posts->count() > 0)

{{-- ══ COUNT ══ --}}
<p style="font-size:.78rem;font-weight:700;color:var(--muted);text-transform:uppercase;
           letter-spacing:.5px;margin-bottom:16px;max-width:860px;margin-left:auto;margin-right:auto;">
    {{ $posts->count() }} post{{ $posts->count()>1?'s':'' }} flagged today
</p>

{{-- ══ POST CARDS ══ --}}
@foreach($posts as $post)
@php $alerted = in_array($post->id, $alertedIds); @endphp
<div class="risk-card {{ $alerted ? 'alerted' : '' }}">
    <div style="display:flex;align-items:flex-start;gap:12px;margin-bottom:10px;">
        <div class="risk-avatar">{{ strtoupper(substr($post->postName,0,1)) }}</div>
        <div style="flex:1;">
            <div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap;margin-bottom:4px;">
                <span style="font-weight:700;color:#111827;">{{ $post->postName }}</span>
                @if($alerted)
                    <span class="rchip alerted">
                        <i class="fas fa-check-circle" style="font-size:.6rem;"></i> Alert Sent
                    </span>
                @endif
            </div>
            @if($post->student_email)
            <div style="font-size:.7rem;color:var(--muted);margin-bottom:5px;">
                <i class="fas fa-envelope" style="font-size:.6rem;margin-right:3px;"></i>
                {{ $post->student_email }}
            </div>
            @endif
            <div style="display:flex;flex-wrap:wrap;">
                @if($post->program)<span class="rchip program">{{ $post->program }}</span>@endif
                @if($post->year_level)<span class="rchip year">{{ $post->year_level }}</span>@endif
                <span class="rchip risk">🔤 {{ strtoupper(str_replace('_',' ',$post->sentiment)) }}</span>
                @if($post->ai_sentiment)
                    <span class="rchip risk">🤖 {{ strtoupper(str_replace('_',' ',$post->ai_sentiment)) }}</span>
                @endif
                @if($post->ai_emotion_category)
                    <span class="rchip" style="background:#fef3c7;color:#92400e;border:1px solid #fde68a;">
                        {{ ucfirst($post->ai_emotion_category) }}
                    </span>
                @endif
                @if($post->ai_confidence)
                    <span class="rchip" style="background:#f0f9ff;color:#0369a1;border:1px solid #bae6fd;">
                        {{ $post->ai_confidence }}% confidence
                    </span>
                @endif
            </div>
            <div style="font-size:.7rem;color:var(--muted);margin-top:3px;">
                {{ $post->created_at->format('h:i A') }}
            </div>
        </div>
    </div>

    <div class="post-body">{{ $post->post }}</div>

    @if($post->ai_counselor_note)
    <div class="ai-note">
        <div style="font-size:.6rem;font-weight:800;color:#f0c419;text-transform:uppercase;
                     letter-spacing:.5px;margin-bottom:4px;font-style:normal;">
            <i class="fas fa-brain me-1"></i>AI Counselor Note
        </div>
        {{ $post->ai_counselor_note }}
    </div>
    @endif

    <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:8px;">
        <div style="font-size:.74rem;color:var(--muted);">
            @if(!$post->ai_sentiment)
                <span style="color:#f59e0b;">
                    <i class="fas fa-triangle-exclamation"></i> No AI analysis —
                    <a href="{{ route('admin.freedomwall.details',$post->id) }}" style="color:#f59e0b;">analyse now</a>
                </span>
            @else
                AI analysed {{ $post->updated_at->diffForHumans() }}
            @endif
        </div>
        <a href="{{ route('admin.freedomwall.details', $post->id) }}" class="btn-view">
            <i class="fas fa-eye"></i> View
        </a>
    </div>
</div>
@endforeach

@endif {{-- end posts > 0 --}}

<script>
// ── Toggle panel ──────────────────────────────────────────────
function toggleAlertPanel() {
    const body  = document.getElementById('alert-body');
    const arrow = document.getElementById('aph-arrow');
    body.classList.toggle('open');
    arrow.classList.toggle('open');
}
// Open by default when there are unalerted posts
@php $hasUnsent = $posts->count() && count($alertedIds) < $posts->count(); @endphp
@if($hasUnsent)
document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('alert-body').classList.add('open');
    document.getElementById('aph-arrow').classList.add('open');
});
@endif

// ── Chip toggle ───────────────────────────────────────────────
document.querySelectorAll('.mini-chip').forEach(function (chip) {
    chip.addEventListener('click', function (e) {
        e.preventDefault();
        const cb = this.querySelector('input[type="checkbox"]');
        cb.checked = !cb.checked;
        this.classList.toggle('selected', cb.checked);
    });
});

// ── Send alert ────────────────────────────────────────────────
async function sendAlerts() {
    const btn     = document.getElementById('btn-send');
    const label   = document.getElementById('send-label');
    const spinner = document.getElementById('send-spinner');
    const result  = document.getElementById('send-result');

    const recipients = Array.from(
        document.querySelectorAll('#mini-recipient-list input[type="checkbox"]:checked')
    ).map(cb => cb.value).filter(Boolean);

    const postIds = Array.from(
        document.querySelectorAll('#mini-post-list .mini-post-cb:checked:not(:disabled)')
    ).map(cb => parseInt(cb.value)).filter(Boolean);

    if (!recipients.length) { showR('err','Select at least one recipient.'); return; }
    if (!postIds.length)     { showR('err','No new posts selected (all may already be alerted).'); return; }

    btn.disabled         = true;
    label.style.display  = 'none';
    spinner.style.display= 'block';
    result.style.display = 'none';

    try {
        const res  = await fetch('{{ route('admin.freedomwall.send_alert') }}', {
            method: 'POST',
            headers: { 'Content-Type':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}','Accept':'application/json' },
            body:   JSON.stringify({ post_ids: postIds, recipients }),
        });
        const data = await res.json();
        showR(data.success ? 'ok' : 'err', (data.success ? '✅ ' : '❌ ') + (data.message || 'Done'));
        if (data.success) setTimeout(() => location.reload(), 1500);
    } catch(e) {
        showR('err', 'Network error — please try again.');
    } finally {
        btn.disabled          = false;
        label.style.display   = 'inline';
        spinner.style.display = 'none';
    }
}

function showR(type, msg) {
    const el = document.getElementById('send-result');
    el.textContent   = msg;
    el.className     = 'send-result ' + (type === 'ok' ? 'ok' : 'err');
    el.style.display = 'block';
}

// ── Save recipient selection to system_settings ───────────────
async function saveRecipientSelection() {
    const btn    = document.getElementById('btn-save-recipients');
    const result = document.getElementById('save-recipients-result');

    const selected = Array.from(
        document.querySelectorAll('#mini-recipient-list input[type="checkbox"]:checked')
    ).map(cb => cb.value).filter(Boolean);

    if (!selected.length) {
        result.textContent    = '⚠ Select at least one recipient first.';
        result.style.cssText  = 'display:block;background:#fef9e7;border:1px solid rgba(201,162,39,.3);color:#92400e;font-size:.72rem;font-weight:600;padding:6px 12px;border-radius:7px;margin-bottom:8px;';
        setTimeout(() => result.style.display = 'none', 3000);
        return;
    }

    const orig = btn.innerHTML;
    btn.innerHTML   = '<i class="fas fa-spinner fa-spin"></i> Saving…';
    btn.disabled    = true;
    result.style.display = 'none';

    try {
        const res  = await fetch('{{ route('admin.settings.alert_recipients') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            },
            body: JSON.stringify({ alert_recipients: selected.join(',') }),
        });

        if (res.ok || res.redirected) {
            btn.innerHTML         = '<i class="fas fa-check"></i> Saved!';
            btn.style.background  = '#0a1931';
            btn.style.color       = '#f0c419';
            btn.style.borderColor = '#0a1931';
            result.textContent    = '✅ Recipients saved — selection will persist after refresh.';
            result.style.cssText  = 'display:block;background:#f0fdf4;border:1px solid #bbf7d0;color:#166534;font-size:.72rem;font-weight:600;padding:6px 12px;border-radius:7px;margin-bottom:8px;';
            setTimeout(() => {
                btn.innerHTML         = orig;
                btn.style.background  = '';
                btn.style.color       = '';
                btn.style.borderColor = '';
                result.style.display  = 'none';
            }, 3000);
        } else {
            throw new Error('Save failed');
        }
    } catch(e) {
        result.textContent   = '❌ Could not save. Please try again.';
        result.style.cssText = 'display:block;background:#fef2f2;border:1px solid #fecaca;color:#dc2626;font-size:.72rem;font-weight:600;padding:6px 12px;border-radius:7px;margin-bottom:8px;';
        btn.innerHTML        = orig;
        setTimeout(() => result.style.display = 'none', 3000);
    } finally {
        btn.disabled = false;
    }
}
</script>

</x-app-layout>
