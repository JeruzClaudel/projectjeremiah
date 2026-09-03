<x-app-layout title="Analytics">

<style>
.filter-card { background:#fff;border:1.5px solid var(--border);border-radius:14px;padding:18px 22px;margin-bottom:22px;box-shadow:var(--shadow); }
.chart-grid  { display:grid;grid-template-columns:repeat(auto-fill,minmax(340px,1fr));gap:18px;margin-bottom:22px; }
.chart-card  { background:#fff;border:1.5px solid var(--border);border-radius:14px;padding:20px 22px;box-shadow:var(--shadow); }
.chart-title { font-size:.72rem;font-weight:800;color:var(--muted);text-transform:uppercase;letter-spacing:.5px;margin-bottom:14px; }

/* Year quick-select pills */
.year-pills { display:flex;flex-wrap:wrap;gap:6px;align-items:center;margin-bottom:10px; }
.year-pill {
    display:inline-flex;align-items:center;padding:4px 13px;border-radius:999px;
    font-size:.78rem;font-weight:700;cursor:pointer;
    border:1.5px solid var(--border);background:#fff;color:var(--text);
    text-decoration:none;transition:all .15s;
}
.year-pill:hover { border-color:var(--navy);color:var(--navy);text-decoration:none; }
.year-pill.active { background:var(--navy);color:var(--gold);border-color:var(--navy); }
.year-pill.all    { background:var(--light); }
</style>

<div class="top-bar">
    <h2 class="navigation-title">e-Hayag Analytics</h2>
    <a href="{{ route('admin.freedomwall.analytics_export') }}" class="top-button add">
        <i class="fas fa-file-excel"></i> Export
    </a>
</div>
<div class="nav-line-separator"></div>

{{-- Filters --}}
<div class="filter-card">

    {{-- Year quick-select pills (built dynamically) --}}
    <div style="margin-bottom:14px;">
        <div style="font-size:.7rem;font-weight:800;color:var(--muted);text-transform:uppercase;
                     letter-spacing:.4px;margin-bottom:7px;">Quick Year Filter</div>
        <div class="year-pills">
            <a href="{{ route('admin.freedomwall.analytics', array_merge(request()->except(['year','start_date','end_date','page']), [])) }}"
               class="year-pill all {{ !request('year') ? 'active' : '' }}">
                All Time
            </a>
            @foreach(array_reverse($yearOptions ?? [now()->year]) as $yr)
            <a href="{{ route('admin.freedomwall.analytics', array_merge(request()->except(['year','start_date','end_date','page']), ['year' => $yr])) }}"
               class="year-pill {{ request('year') == $yr ? 'active' : '' }}">
                {{ $yr }}
            </a>
            @endforeach
        </div>
    </div>

    <form method="GET" action="{{ route('admin.freedomwall.analytics') }}">
        {{-- Preserve active year when submitting the detailed filter --}}
        @if(request('year'))
            <input type="hidden" name="year" value="{{ request('year') }}">
        @endif
        <div style="display:flex;gap:12px;flex-wrap:wrap;align-items:flex-end;">
            {{-- Program --}}
            <div style="flex:1;min-width:140px;display:flex;flex-direction:column;gap:4px;">
                <label style="font-size:.72rem;font-weight:700;color:var(--muted);">Program</label>
                <select name="program" style="padding:8px 12px;border:1.5px solid var(--border);border-radius:8px;font-size:.84rem;background:#fff;">
                    <option value="">All Programs</option>
                    @foreach(['ABCOMM','BMMA','BSCRIM','BSESS','BSPsych','BSA','BSAIS','BSTM','BSBA-DM','BSArch','BSCE','BSCpE','BSIT','BSCS','BSIS','GRADE-11','GRADE-12'] as $p)
                        <option value="{{ $p }}" {{ request('program')==$p?'selected':'' }}>{{ $p }}</option>
                    @endforeach
                </select>
            </div>
            {{-- Year Level --}}
            <div style="flex:1;min-width:120px;display:flex;flex-direction:column;gap:4px;">
                <label style="font-size:.72rem;font-weight:700;color:var(--muted);">Year Level</label>
                <select name="year_level" style="padding:8px 12px;border:1.5px solid var(--border);border-radius:8px;font-size:.84rem;background:#fff;">
                    <option value="">All Years</option>
                    @foreach(['1st Year','2nd Year','3rd Year','4th Year'] as $y)
                        <option value="{{ $y }}" {{ request('year_level')==$y?'selected':'' }}>{{ $y }}</option>
                    @endforeach
                </select>
            </div>
            {{-- Date range (only shown when no year pill is active) --}}
            @if(!request('year'))
            <div style="flex:1;min-width:140px;display:flex;flex-direction:column;gap:4px;">
                <label style="font-size:.72rem;font-weight:700;color:var(--muted);">From</label>
                <input type="date" name="start_date" value="{{ request('start_date') }}"
                       style="padding:8px 12px;border:1.5px solid var(--border);border-radius:8px;font-size:.84rem;">
            </div>
            <div style="flex:1;min-width:140px;display:flex;flex-direction:column;gap:4px;">
                <label style="font-size:.72rem;font-weight:700;color:var(--muted);">To</label>
                <input type="date" name="end_date" value="{{ request('end_date') }}"
                       style="padding:8px 12px;border:1.5px solid var(--border);border-radius:8px;font-size:.84rem;">
            </div>
            @endif
            <div style="display:flex;gap:8px;align-items:flex-end;">
                <button type="submit" class="filter-button"><i class="fas fa-filter"></i> Apply</button>
                <a href="{{ route('admin.freedomwall.analytics') }}"
                   style="padding:8px 14px;background:#f3f4f6;color:var(--text);border-radius:8px;
                          font-size:.8rem;font-weight:600;text-decoration:none;white-space:nowrap;">Reset</a>
            </div>
        </div>
    </form>

    {{-- Active filter info strip --}}
    @if(request('year') || request('program') || request('start_date'))
    <div style="margin-top:12px;padding:8px 14px;background:var(--gold3);border:1px solid rgba(201,162,39,.25);
                border-radius:8px;font-size:.78rem;color:#92400e;display:flex;align-items:center;gap:8px;flex-wrap:wrap;">
        <i class="fas fa-filter" style="font-size:.7rem;"></i>
        <strong>Active filters:</strong>
        @if(request('year')) <span>Year: <strong>{{ request('year') }}</strong></span>@endif
        @if(request('program')) <span>Program: <strong>{{ request('program') }}</strong></span>@endif
        @if(request('year_level')) <span>Year Level: <strong>{{ request('year_level') }}</strong></span>@endif
        @if(request('start_date')) <span>From: <strong>{{ request('start_date') }}</strong></span>@endif
        @if(request('end_date')) <span>To: <strong>{{ request('end_date') }}</strong></span>@endif
    </div>
    @endif
</div>

{{-- Charts --}}
<div class="chart-grid">
    <div class="chart-card">
        <div class="chart-title">Posts by Program</div>
        <canvas id="programChart" height="220"></canvas>
    </div>
    <div class="chart-card">
        <div class="chart-title">Sentiment Breakdown</div>
        <canvas id="sentimentChart" height="220"></canvas>
    </div>
    <div class="chart-card">
        <div class="chart-title">Posts by Year Level</div>
        <canvas id="yearChart" height="220"></canvas>
    </div>
    <div class="chart-card">
        <div class="chart-title">AI Emotion Categories</div>
        <canvas id="emotionChart" height="220"></canvas>
    </div>
</div>

<div class="chart-card" style="margin-bottom:24px;">
    <div class="chart-title">
        @if(request('year'))
            Monthly Posts — {{ request('year') }}
        @else
            Monthly Posts (Last 12 Months)
        @endif
    </div>
    <canvas id="monthlyChart" height="120"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const chartDefaults = {
    responsive: true, maintainAspectRatio: true,
    plugins: { legend: { position: 'bottom', labels: { font: { size: 11 } } } }
};

new Chart(document.getElementById('programChart'), {
    type: 'bar',
    data: {
        labels: {!! json_encode($programLabels) !!},
        datasets: [{ label: 'Posts', data: {!! json_encode($programCounts) !!},
            backgroundColor: 'rgba(10,25,49,.75)', borderRadius: 5 }]
    },
    options: { ...chartDefaults, plugins: { legend: { display: false } } }
});

new Chart(document.getElementById('sentimentChart'), {
    type: 'doughnut',
    data: {
        labels: {!! json_encode($sentimentLabels->map(fn($l)=>strtoupper(str_replace('_',' ',$l)))) !!},
        datasets: [{ data: {!! json_encode($sentimentCounts) !!},
            backgroundColor: ['#22c55e','#f59e0b','#ef4444','#6b7280'],
            borderWidth: 2, borderColor: '#fff' }]
    },
    options: chartDefaults
});

new Chart(document.getElementById('yearChart'), {
    type: 'bar',
    data: {
        labels: {!! json_encode($yearLabels) !!},
        datasets: [{ label: 'Posts', data: {!! json_encode($yearCounts) !!},
            backgroundColor: 'rgba(201,162,39,.8)', borderRadius: 5 }]
    },
    options: { ...chartDefaults, plugins: { legend: { display: false } } }
});

new Chart(document.getElementById('emotionChart'), {
    type: 'pie',
    data: {
        labels: {!! json_encode($emotionLabels->map(fn($l)=>ucfirst($l))) !!},
        datasets: [{ data: {!! json_encode($emotionCounts) !!},
            backgroundColor: ['#6366f1','#06b6d4','#f59e0b','#ef4444','#22c55e','#8b5cf6','#ec4899'],
            borderWidth: 2, borderColor: '#fff' }]
    },
    options: chartDefaults
});

new Chart(document.getElementById('monthlyChart'), {
    type: 'line',
    data: {
        labels: {!! json_encode($monthlyLabels) !!},
        datasets: [{ label: 'Posts', data: {!! json_encode($monthlyCounts) !!},
            borderColor: '#0a1931', backgroundColor: 'rgba(10,25,49,.1)',
            tension: .35, fill: true, pointRadius: 4 }]
    },
    options: { ...chartDefaults, plugins: { legend: { display: false } } }
});
</script>

</x-app-layout>
