<x-app-layout title="Post Details">

<style>
/* ── AI Analysis Card ── */
.ai-analysis-card {
    background: linear-gradient(135deg,#0a1931 0%,#1c2a4d 100%);
    border-radius: 16px; padding: 24px 28px; margin-top: 24px;
    border: 1.5px solid rgba(201,162,39,.25);
    box-shadow: 0 8px 28px rgba(10,25,49,.2);
}
.ai-card-header { display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px;margin-bottom:18px; }
.ai-badge { display:inline-flex;align-items:center;gap:6px;padding:4px 12px;border-radius:999px;
            background:rgba(240,196,25,.15);border:1px solid rgba(240,196,25,.35);
            color:#f0c419;font-size:.68rem;font-weight:800;text-transform:uppercase;letter-spacing:.5px; }
.btn-ai-analyse {
    display:inline-flex;align-items:center;gap:7px;padding:9px 20px;
    background:linear-gradient(135deg,#c9a227,#f0c419);color:#0a1931;
    border:none;border-radius:9px;font-size:.82rem;font-weight:800;cursor:pointer;
    transition:transform .2s,box-shadow .2s;
}
.btn-ai-analyse:hover { transform:translateY(-2px);box-shadow:0 6px 18px rgba(201,162,39,.4); }
.btn-ai-analyse:disabled { opacity:.6;cursor:not-allowed;transform:none;box-shadow:none; }
.ai-spinner-sm { width:15px;height:15px;border:2px solid rgba(10,25,49,.25);
                 border-top-color:#0a1931;border-radius:50%;
                 animation:spin .7s linear infinite;display:none; }
@keyframes spin { to { transform:rotate(360deg); } }

/* Result grid */
.ai-results-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
    gap: 12px; margin-top: 16px;
}
.ai-stat-box {
    background: rgba(255,255,255,.06); border: 1px solid rgba(255,255,255,.1);
    border-radius: 12px; padding: 14px 16px;
}
.ai-stat-box.flagged { border-color:rgba(239,68,68,.5);background:rgba(239,68,68,.1); }
.asb-label { font-size:.62rem;font-weight:800;color:rgba(255,255,255,.4);
             text-transform:uppercase;letter-spacing:.5px;margin-bottom:6px; }
.asb-value { font-size:1rem;font-weight:800;color:#fff;line-height:1.2; }
.asb-value.sent-positive  { color:#86efac; }
.asb-value.sent-negative  { color:#fca5a5; }
.asb-value.sent-high_risk { color:#f87171;font-size:1.05rem; }
.asb-value.sent-neutral   { color:#d1d5db; }

/* Confidence bar */
.conf-bar-bg   { background:rgba(255,255,255,.1);border-radius:999px;height:5px;overflow:hidden;margin-top:6px; }
.conf-bar-fill { height:100%;border-radius:999px;background:linear-gradient(90deg,#c9a227,#f0c419);transition:width .6s ease; }

/* Counselor note */
.ai-note-box {
    margin-top: 14px;
    background: rgba(255,255,255,.06); border: 1px solid rgba(255,255,255,.1);
    border-left: 4px solid #c9a227; border-radius: 0 12px 12px 0;
    padding: 14px 18px;
}
.ai-note-label { font-size:.62rem;font-weight:800;color:#f0c419;
                 text-transform:uppercase;letter-spacing:.5px;margin-bottom:6px; }
.ai-note-text  { color:rgba(255,255,255,.88);font-size:.88rem;line-height:1.7;font-style:italic; }

/* Error box */
.ai-error { margin-top:12px;padding:11px 16px;background:rgba(220,38,38,.15);
            border:1px solid rgba(220,38,38,.3);border-radius:9px;
            color:#fca5a5;font-size:.82rem;font-weight:600;display:none; }

/* Post card */
.post-meta-row { display:flex;align-items:center;gap:14px;flex-wrap:wrap;margin-bottom:18px; }
.post-avatar { width:52px;height:52px;border-radius:50%;
               background:linear-gradient(135deg,#0a1931,#1c2a4d);
               color:#f0c419;font-size:1.2rem;font-weight:800;
               display:flex;align-items:center;justify-content:center;flex-shrink:0; }
.post-body-box { background:var(--light);border:1.5px solid var(--border);border-radius:11px;
                 padding:18px 20px;line-height:1.8;font-size:.93rem;
                 color:var(--text);white-space:pre-wrap;margin-bottom:6px; }
</style>

<div class="top-bar">
    <a href="{{ route('admin.freedomwall.freedomwall') }}" class="top-button back">
        ← Back to Posts
    </a>
    <h2 class="navigation-title">Post Detail</h2>
</div>
<div class="nav-line-separator"></div>

<div class="modern-card">

    {{-- Post header --}}
    <div class="post-meta-row">
        <div class="post-avatar">{{ strtoupper(substr($post->postName, 0, 1)) }}</div>
        <div style="flex:1;">
            <div style="font-size:1.05rem;font-weight:700;color:var(--navy);margin-bottom:5px;">
                {{ $post->postName }}
            </div>
            <div style="display:flex;flex-wrap:wrap;gap:5px;margin-bottom:4px;">
                @if($post->program)
                    <span class="chip program">{{ $post->program }}</span>
                @endif
                @if($post->year_level)
                    <span class="chip year">{{ $post->year_level }}</span>
                @endif
                @php $s = $post->sentiment ?? 'neutral'; @endphp
                <span class="chip sentiment {{ in_array($s,['positive','negative','neutral']) ? $s : 'risk' }}">
                    🔤 {{ strtoupper(str_replace('_',' ',$s)) }}
                </span>
                @if($post->ai_sentiment)
                    @php $as = $post->ai_sentiment; @endphp
                    <span class="chip sentiment {{ in_array($as,['positive','negative','neutral']) ? $as : 'risk' }}">
                        🤖 {{ strtoupper(str_replace('_',' ',$as)) }}
                    </span>
                @endif
                @if($post->ai_flagged)
                    <span class="chip" style="background:#7f1d1d;color:#fca5a5;animation:pulse 1.5s infinite;">
                        🚨 FLAGGED
                    </span>
                @endif
            </div>
            <div style="font-size:.72rem;color:var(--muted);margin-bottom:3px;">
                {{ $post->created_at->format('F d, Y • h:i A') }}
            </div>
            @if($post->student_email)
            <div style="display:inline-flex;align-items:center;gap:5px;margin-top:4px;
                        padding:4px 10px;background:#f0f9ff;border:1px solid #bae6fd;
                        border-radius:7px;font-size:.72rem;font-weight:600;color:#0369a1;">
                <i class="fas fa-envelope" style="font-size:.65rem;"></i>
                {{ $post->student_email }}
            </div>
            @endif
        </div>
    </div>

    <div class="modern-divider"></div>

    {{-- Post body --}}
    <div class="post-body-box">{{ $post->post }}</div>

    {{-- ═══ AI ANALYSIS PANEL ═══ --}}
    <div class="ai-analysis-card" id="ai-card">
        <div class="ai-card-header">
            <div>
                <span class="ai-badge"><i class="fas fa-brain"></i> AI Sentiment Analysis</span>
                <div style="color:rgba(255,255,255,.5);font-size:.78rem;margin-top:6px;">
                    @if($post->ai_sentiment)
                        Last analysed {{ $post->updated_at->diffForHumans() }}
                    @else
                        This post has not been analysed by AI yet.
                    @endif
                </div>
            </div>
            <button class="btn-ai-analyse" id="btn-analyse" onclick="runAI()">
                <span id="btn-label">
                    <i class="fas fa-wand-magic-sparkles"></i>
                    {{ $post->ai_sentiment ? 'Re-Analyse' : 'Analyse with AI' }}
                </span>
                <div class="ai-spinner-sm" id="btn-spinner"></div>
            </button>
        </div>

        {{-- Results --}}
        <div id="ai-results" style="{{ $post->ai_sentiment ? '' : 'display:none;' }}">
            <div class="ai-results-grid">
                {{-- Sentiment --}}
                <div class="ai-stat-box" id="box-sentiment">
                    <div class="asb-label">AI Sentiment</div>
                    <div class="asb-value sent-{{ $post->ai_sentiment ?? 'neutral' }}" id="val-sentiment">
                        {{ $post->ai_sentiment ? strtoupper(str_replace('_',' ',$post->ai_sentiment)) : '—' }}
                    </div>
                </div>

                {{-- Emotion --}}
                <div class="ai-stat-box" id="box-emotion">
                    <div class="asb-label">Emotion Category</div>
                    <div class="asb-value" id="val-emotion"
                         style="color:#f0c419;text-transform:capitalize;">
                        {{ $post->ai_emotion_category ?? '—' }}
                    </div>
                </div>

                {{-- Confidence --}}
                <div class="ai-stat-box" id="box-confidence">
                    <div class="asb-label">Confidence</div>
                    <div class="asb-value" id="val-confidence">
                        {{ $post->ai_confidence !== null ? $post->ai_confidence.'%' : '—' }}
                    </div>
                    <div class="conf-bar-bg">
                        <div class="conf-bar-fill" id="conf-bar"
                             style="width:{{ $post->ai_confidence ?? 0 }}%;"></div>
                    </div>
                </div>

                {{-- Risk Flag --}}
                <div class="ai-stat-box {{ $post->ai_flagged ? 'flagged' : '' }}" id="box-flagged">
                    <div class="asb-label">Risk Flag</div>
                    <div class="asb-value" id="val-flagged">
                        @if($post->ai_flagged)
                            🚨 FLAGGED — Needs Attention
                        @else
                            ✅ No Immediate Risk
                        @endif
                    </div>
                </div>
            </div>

            {{-- Counselor Note --}}
            <div class="ai-note-box" id="note-box"
                 style="{{ $post->ai_counselor_note ? '' : 'display:none;' }}">
                <div class="ai-note-label">
                    <i class="fas fa-user-nurse me-1"></i> Counselor Note (AI Generated)
                </div>
                <div class="ai-note-text" id="val-note">
                    {{ $post->ai_counselor_note ?? '' }}
                </div>
            </div>
        </div>

        <div class="ai-error" id="ai-error"></div>
    </div>

    {{-- Delete --}}
    <div class="modern-actions" style="margin-top:20px;">
        <form id="del-post-form"
              action="{{ route('admin.freedomwall.destroy', $post->id) }}"
              method="POST" style="margin:0;">
            @csrf @method('DELETE')
        </form>
        <button type="button" class="modern-delete-btn"
                onclick="confirmDelete('del-post-form','this post')">
            <i class="fas fa-trash"></i> Delete Post
        </button>
    </div>
</div>

<script>
async function runAI() {
    const btn    = document.getElementById('btn-analyse');
    const label  = document.getElementById('btn-label');
    const sp     = document.getElementById('btn-spinner');
    const res_el = document.getElementById('ai-results');
    const err_el = document.getElementById('ai-error');

    btn.disabled        = true;
    label.style.display = 'none';
    sp.style.display    = 'block';
    err_el.style.display= 'none';

    try {
        const res  = await fetch('{{ route('admin.freedomwall.ai_analyze', $post->id) }}', {
            method:  'POST',
            headers: { 'Content-Type':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}','Accept':'application/json' },
        });
        const data = await res.json();

        if (!res.ok || !data.success) throw new Error(data.error || 'Unknown error');

        // Update sentiment
        const sentClass = 'asb-value sent-' + (data.ai_sentiment || 'neutral');
        const sentEl = document.getElementById('val-sentiment');
        sentEl.textContent = (data.ai_sentiment || '—').replace('_',' ').toUpperCase();
        sentEl.className   = sentClass;

        // Emotion
        document.getElementById('val-emotion').textContent = data.ai_emotion_category || '—';

        // Confidence
        document.getElementById('val-confidence').textContent = data.ai_confidence !== null ? data.ai_confidence + '%' : '—';
        document.getElementById('conf-bar').style.width = (data.ai_confidence || 0) + '%';

        // Flag
        const flagBox = document.getElementById('box-flagged');
        const flagVal = document.getElementById('val-flagged');
        if (data.ai_flagged) {
            flagBox.classList.add('flagged');
            flagVal.textContent = '🚨 FLAGGED — Needs Attention';
        } else {
            flagBox.classList.remove('flagged');
            flagVal.textContent = '✅ No Immediate Risk';
        }

        // Note
        const noteBox = document.getElementById('note-box');
        const noteVal = document.getElementById('val-note');
        if (data.ai_counselor_note) {
            noteVal.textContent     = data.ai_counselor_note;
            noteBox.style.display   = 'block';
        }

        res_el.style.display = 'block';
        document.getElementById('btn-label').innerHTML = '<i class="fas fa-wand-magic-sparkles"></i> Re-Analyse';

    } catch (e) {
        err_el.textContent    = '⚠ ' + e.message;
        err_el.style.display  = 'block';
    } finally {
        btn.disabled        = false;
        label.style.display = 'inline';
        sp.style.display    = 'none';
    }
}
</script>

</x-app-layout>
