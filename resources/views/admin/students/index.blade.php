<x-app-layout title="Student Accounts">

<style>
.students-table { width:100%;border-collapse:collapse;background:#fff;border-radius:14px;
    overflow:hidden;box-shadow:var(--shadow);border:1.5px solid var(--border); }
.students-table thead tr { background:linear-gradient(135deg,#0a1931,#1c2a4d); }
.students-table thead th { padding:13px 16px;font-size:.68rem;font-weight:800;color:#f0c419;
    text-transform:uppercase;letter-spacing:.6px;text-align:left;border:none; }
.students-table tbody tr { border-bottom:1px solid var(--border);transition:background .15s; }
.students-table tbody tr:hover { background:#fef9e7; }
.students-table td { padding:12px 16px;font-size:.86rem;color:var(--text);vertical-align:middle; }
.status-badge { display:inline-flex;align-items:center;gap:4px;padding:3px 10px;
    border-radius:999px;font-size:.68rem;font-weight:800;text-transform:uppercase; }
.status-active   { background:#f0fdf4;color:#166534;border:1px solid #bbf7d0; }
.status-inactive { background:#fef2f2;color:#991b1b;border:1px solid #fecaca; }
.btn-sm { display:inline-flex;align-items:center;gap:4px;padding:5px 10px;border-radius:6px;
    font-size:.72rem;font-weight:700;cursor:pointer;transition:background .15s;border:none; }
.btn-deactivate { background:#fef2f2;color:#dc2626;border:1px solid #fecaca; }
.btn-activate   { background:#f0fdf4;color:#16a34a;border:1px solid #bbf7d0; }
.btn-del        { background:#fef2f2;color:#dc2626;border:1px solid #fecaca;margin-left:4px; }
</style>

<div class="top-bar">
    <h2 class="navigation-title">Student Accounts</h2>
</div>
<div class="nav-line-separator"></div>

{{-- Stats --}}
@php
    $total    = $students->count();
    $active   = $students->where('is_active',true)->count();
    $inactive = $students->where('is_active',false)->count();
@endphp
<div style="display:flex;gap:12px;margin-bottom:20px;flex-wrap:wrap;">
    @foreach([['Total','fas fa-users',$total,'#0a1931','var(--gold3)'],['Active','fas fa-circle-check',$active,'#166534','#f0fdf4'],['Deactivated','fas fa-ban',$inactive,'#991b1b','#fef2f2']] as [$lbl,$ico,$val,$col,$bg])
    <div style="background:#fff;border:1.5px solid var(--border);border-radius:12px;
                padding:14px 20px;display:flex;align-items:center;gap:12px;box-shadow:var(--shadow);min-width:140px;">
        <div style="width:38px;height:38px;border-radius:10px;background:{{ $bg }};
                    display:flex;align-items:center;justify-content:center;color:{{ $col }};font-size:.9rem;">
            <i class="{{ $ico }}"></i>
        </div>
        <div>
            <div style="font-size:.62rem;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.4px;">{{ $lbl }}</div>
            <div style="font-size:1.5rem;font-weight:800;color:{{ $col }};line-height:1;">{{ $val }}</div>
        </div>
    </div>
    @endforeach
</div>

{{-- Filter bar --}}
<div style="background:#fff;border:1.5px solid var(--border);border-radius:14px;
            padding:16px 20px;margin-bottom:20px;box-shadow:var(--shadow);">
    <form method="GET" action="{{ route('admin.students.index') }}" id="filter-form">
        <div style="display:flex;gap:10px;flex-wrap:wrap;align-items:flex-end;">
            {{-- Search --}}
            <div style="flex:2;min-width:180px;display:flex;flex-direction:column;gap:4px;">
                <label style="font-size:.72rem;font-weight:700;color:var(--muted);">Search</label>
                <div style="position:relative;">
                    <i class="fas fa-search" style="position:absolute;left:10px;top:50%;
                       transform:translateY(-50%);color:var(--muted);font-size:.78rem;pointer-events:none;"></i>
                    <input type="text" name="search" id="search-input"
                           value="{{ request('search') }}"
                           placeholder="Name or email…"
                           autocomplete="off"
                           style="width:100%;padding:8px 12px 8px 32px;
                                  border:1.5px solid var(--border);border-radius:8px;font-size:.84rem;">
                </div>
            </div>
            {{-- Status --}}
            <div style="flex:1;min-width:130px;display:flex;flex-direction:column;gap:4px;">
                <label style="font-size:.72rem;font-weight:700;color:var(--muted);">Status</label>
                <select name="status" id="filter-status"
                        style="padding:8px 12px;border:1.5px solid var(--border);border-radius:8px;font-size:.84rem;background:#fff;">
                    <option value="">All</option>
                    <option value="active"      {{ request('status')==='active'      ?'selected':'' }}>Active</option>
                    <option value="deactivated" {{ request('status')==='deactivated' ?'selected':'' }}>Deactivated</option>
                </select>
            </div>
            {{-- Program --}}
            <div style="flex:1;min-width:140px;display:flex;flex-direction:column;gap:4px;">
                <label style="font-size:.72rem;font-weight:700;color:var(--muted);">Program</label>
                <select name="program" id="filter-program"
                        style="padding:8px 12px;border:1.5px solid var(--border);border-radius:8px;font-size:.84rem;background:#fff;">
                    <option value="">All Programs</option>
                    @foreach(['ABCOMM','BMMA','BSCRIM','BSESS','BSPsych','BSA','BSAIS','BSTM','BSBA-DM','BSArch','BSCE','BSCpE','BSIT','BSCS','BSIS','GRADE-11','GRADE-12'] as $p)
                    <option value="{{ $p }}" {{ request('program')===$p?'selected':'' }}>{{ $p }}</option>
                    @endforeach
                </select>
            </div>
            {{-- Year --}}
            <div style="flex:1;min-width:130px;display:flex;flex-direction:column;gap:4px;">
                <label style="font-size:.72rem;font-weight:700;color:var(--muted);">Year Level</label>
                <select name="year_level" id="filter-year"
                        style="padding:8px 12px;border:1.5px solid var(--border);border-radius:8px;font-size:.84rem;background:#fff;">
                    <option value="">All Years</option>
                    @foreach(['1st Year','2nd Year','3rd Year','4th Year','BUEN - Business and Entrepreneurship','STEM - Science, Technology, Engineering, and Mathematics','ASSH - Arts, Social Sciences, and Humanities'] as $y)
                    <option value="{{ $y }}" {{ request('year_level')===$y?'selected':'' }}>{{ $y }}</option>
                    @endforeach
                </select>
            </div>
            <div style="display:flex;gap:8px;align-items:flex-end;">
                <a href="{{ route('admin.students.index') }}"
                   style="padding:8px 14px;background:#f3f4f6;color:var(--text);border-radius:8px;
                          font-size:.8rem;font-weight:600;text-decoration:none;white-space:nowrap;">
                    Reset
                </a>
            </div>
        </div>
    </form>
</div>

{{-- Live-search result count --}}
<div style="font-size:.8rem;color:var(--muted);margin-bottom:10px;" id="result-count">
    Showing <strong id="visible-count">{{ $students->count() }}</strong>
    of <strong>{{ $total ?? $students->count() }}</strong> students
</div>

{{-- Table --}}
<div style="overflow-x:auto;">
    <table class="students-table">
        <thead>
            <tr>
                <th>#</th><th>Name</th><th>Program</th><th>Year</th>
                <th>Email</th><th>Status</th><th>Registered</th><th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($students as $i => $student)
            <tr class="student-row"
                data-name="{{ strtolower($student->name) }}"
                data-email="{{ strtolower($student->email) }}"
                data-program="{{ strtolower($student->program ?? '') }}"
                data-year="{{ strtolower($student->year_level ?? '') }}"
                data-status="{{ $student->is_active ? 'active' : 'deactivated' }}">
                <td style="color:#9ca3af;font-size:.75rem;">{{ $i+1 }}</td>
                <td style="font-weight:700;color:var(--navy);">{{ $student->name }}</td>
                <td style="color:var(--muted);font-size:.8rem;">{{ $student->program ?? '—' }}</td>
                <td style="color:var(--muted);font-size:.8rem;">{{ $student->year_level ?? '—' }}</td>
                <td style="color:var(--muted);font-size:.8rem;">{{ $student->email }}</td>
                <td>
                    @if($student->is_active)
                        <span class="status-badge status-active">
                            <i class="fas fa-circle" style="font-size:.45rem;"></i> Active
                        </span>
                    @else
                        <span class="status-badge status-inactive">
                            <i class="fas fa-circle" style="font-size:.45rem;"></i> Deactivated
                        </span>
                    @endif
                </td>
                <td style="color:#9ca3af;font-size:.75rem;">{{ $student->created_at->format('M d, Y') }}</td>
                <td>
                    <a href="{{ route('admin.students.edit', $student) }}"
                       class="btn-sm" style="background:#eff6ff;color:#1d4ed8;border:1px solid #bfdbfe;text-decoration:none;margin-right:4px;">
                        <i class="fas fa-pen"></i> Edit
                    </a>
                    <form id="toggle-{{ $student->id }}"
                          action="{{ route('admin.students.toggle_active',$student) }}"
                          method="POST" style="display:inline;margin:0;">
                        @csrf
                        @if($student->is_active)
                            <button type="button" class="btn-sm btn-deactivate"
                                    onclick="confirmDeactivate('toggle-{{ $student->id }}','{{ addslashes($student->name) }}')">
                                <i class="fas fa-ban"></i> Deactivate
                            </button>
                        @else
                            <button type="submit" class="btn-sm btn-activate">
                                <i class="fas fa-check-circle"></i> Activate
                            </button>
                        @endif
                    </form>
                    <form id="del-s-{{ $student->id }}"
                          action="{{ route('admin.students.destroy',$student) }}"
                          method="POST" style="display:inline;margin:0;">
                        @csrf @method('DELETE')
                        <button type="button" class="btn-sm btn-del"
                                onclick="confirmDelete('del-s-{{ $student->id }}','{{ addslashes($student->name) }}\'s account')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align:center;padding:44px;color:#9ca3af;">
                    <i class="fas fa-users" style="font-size:2rem;display:block;margin-bottom:10px;"></i>
                    No students match the current filters.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Deactivation confirmation modal (separate from delete modal) --}}
<div id="deactivate-modal"
     style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);
            z-index:9999;display:none;align-items:center;justify-content:center;padding:16px;">
    <div style="background:#fff;border-radius:18px;padding:32px 28px;max-width:420px;
                width:100%;box-shadow:0 24px 64px rgba(0,0,0,.25);text-align:center;">
        <div style="width:56px;height:56px;background:#fef9e7;border:2px solid rgba(201,162,39,.4);
                    border-radius:50%;display:flex;align-items:center;justify-content:center;
                    margin:0 auto 16px;font-size:1.3rem;color:#c9a227;">
            <i class="fas fa-ban"></i>
        </div>
        <div style="font-size:1.05rem;font-weight:800;color:var(--navy);margin-bottom:8px;">
            Confirm Deactivation
        </div>
        <p id="deactivate-msg"
           style="font-size:.88rem;color:var(--muted);line-height:1.6;margin-bottom:22px;"></p>
        <div style="display:flex;gap:10px;justify-content:center;">
            <button onclick="document.getElementById('deactivate-modal').style.display='none'"
                    style="padding:9px 22px;background:var(--light);border:1.5px solid var(--border);
                           border-radius:9px;font-size:.88rem;font-weight:700;cursor:pointer;">
                Cancel
            </button>
            <button id="deactivate-ok"
                    style="padding:9px 22px;background:linear-gradient(135deg,#c9a227,#f0c419);
                           color:var(--navy);border:none;border-radius:9px;
                           font-size:.88rem;font-weight:800;cursor:pointer;">
                <i class="fas fa-ban me-1"></i> Deactivate
            </button>
        </div>
    </div>
</div>

</x-app-layout>

<script>
function confirmDeactivate(formId, studentName) {
    const modal = document.getElementById('deactivate-modal');
    document.getElementById('deactivate-msg').textContent =
        'Are you sure you want to deactivate ' + studentName + '\'s account? '
        + 'They will no longer be able to post on e-Hayag until reactivated.';
    modal.style.display = 'flex';
    document.getElementById('deactivate-ok').onclick = function () {
        modal.style.display = 'none';
        document.getElementById(formId).submit();
    };
}
document.getElementById('deactivate-modal').addEventListener('click', function (e) {
    if (e.target === this) this.style.display = 'none';
});
(function () {
    const searchInput  = document.getElementById('search-input');
    const statusSel    = document.getElementById('filter-status');
    const programSel   = document.getElementById('filter-program');
    const yearSel      = document.getElementById('filter-year');
    const rows         = document.querySelectorAll('.student-row');
    const countEl      = document.getElementById('visible-count');

    // Submit dropdowns immediately on change (server-side filter)
    [statusSel, programSel, yearSel].forEach(sel => {
        if (sel) sel.addEventListener('change', () => {
            document.getElementById('filter-form').submit();
        });
    });

    // Live search: client-side filter on the currently loaded rows
    if (searchInput) {
        let debounce;
        searchInput.addEventListener('input', function () {
            clearTimeout(debounce);
            debounce = setTimeout(filterRows, 180);
        });
    }

    function filterRows() {
        const q = (searchInput ? searchInput.value.toLowerCase().trim() : '');
        let visible = 0;

        rows.forEach(function (row) {
            const name  = row.dataset.name  || '';
            const email = row.dataset.email || '';
            const match = !q || name.includes(q) || email.includes(q);
            row.style.display = match ? '' : 'none';
            if (match) visible++;
        });

        if (countEl) countEl.textContent = visible;
    }
})();
</script>
