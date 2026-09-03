<x-app-layout title="Counselor Details">

<div class="top-bar">
    <a class="top-button back" href="{{ route('admin.counselor.dashboard') }}">&larr; Back</a>
    <h2 class="navigation-title">Counselor Details</h2>
    <div style="margin-left:auto;display:flex;gap:8px;">
        <a href="{{ route('admin.counselor.edit', $counselor->id) }}" class="top-button back">
            <i class="fas fa-pen"></i> Edit
        </a>
        <form id="del-cns-{{ $counselor->id }}"
              action="{{ route('admin.counselor.delete', $counselor->id) }}"
              method="POST" style="margin:0;">
            @csrf @method('DELETE')
        </form>
        <button type="button" class="top-button back"
                style="color:#dc2626;border-color:#fecaca;background:#fef2f2;"
                onclick="confirmDelete('del-cns-{{ $counselor->id }}','{{ addslashes($counselor->name) }}')">
            <i class="fas fa-trash"></i> Delete
        </button>
    </div>
</div>
<div class="nav-line-separator"></div>

<div style="display:flex;gap:24px;flex-wrap:wrap;align-items:flex-start;">

    {{-- Left: image + name card --}}
    <div style="width:220px;flex-shrink:0;">
        <div style="background:#fff;border:1.5px solid var(--border);border-radius:16px;
                    overflow:hidden;box-shadow:var(--shadow);text-align:center;">
            @if($counselor->image)
                <img src="{{ asset('storage/'.$counselor->image) }}"
                     alt="{{ $counselor->name }}"
                     style="width:100%;height:220px;object-fit:cover;border-bottom:2px solid var(--gold);">
            @else
                <div style="width:100%;height:220px;background:linear-gradient(135deg,var(--navy),var(--navy2));
                            display:flex;align-items:center;justify-content:center;
                            font-size:4rem;font-weight:800;color:var(--gold);
                            border-bottom:2px solid var(--gold);">
                    {{ strtoupper(substr($counselor->name,0,1)) }}
                </div>
            @endif
            <div style="padding:16px 14px;">
                <div style="font-size:1rem;font-weight:800;color:var(--navy);margin-bottom:4px;">
                    {{ $counselor->name }}
                </div>
                @if($counselor->position)
                <div style="font-size:.8rem;color:var(--muted);margin-bottom:4px;">{{ $counselor->position }}</div>
                @endif
                <span style="display:inline-flex;align-items:center;gap:4px;
                             padding:3px 10px;background:var(--gold3);color:#92400e;
                             border:1px solid rgba(201,162,39,.3);border-radius:999px;
                             font-size:.68rem;font-weight:700;">
                    <i class="fas fa-graduation-cap" style="font-size:.6rem;"></i> Guidance Counselor
                </span>
            </div>
        </div>
    </div>

    {{-- Right: info + schedule --}}
    <div style="flex:1;min-width:280px;display:flex;flex-direction:column;gap:16px;">

        {{-- Contact info card --}}
        <div style="background:#fff;border:1.5px solid var(--border);border-radius:14px;
                    padding:20px 22px;box-shadow:var(--shadow);">
            <div style="font-size:.72rem;font-weight:800;color:var(--muted);
                         text-transform:uppercase;letter-spacing:.5px;margin-bottom:14px;">
                Contact Information
            </div>
            @foreach([
                ['fas fa-building-columns','Department / College',$counselor->college ?? '—'],
                ['fas fa-envelope',        'Email',               $counselor->email   ?? '—'],
                ['fas fa-video',           'MS Teams',            $counselor->ms_teams_account ?? '—'],
            ] as [$icon,$label,$value])
            <div style="display:flex;align-items:flex-start;gap:12px;padding:10px 0;
                        border-bottom:1px solid var(--border);">
                <div style="width:34px;height:34px;border-radius:9px;background:var(--light);
                            display:flex;align-items:center;justify-content:center;
                            color:var(--navy);font-size:.85rem;flex-shrink:0;">
                    <i class="{{ $icon }}"></i>
                </div>
                <div>
                    <div style="font-size:.68rem;font-weight:700;color:var(--muted);
                                text-transform:uppercase;letter-spacing:.3px;">{{ $label }}</div>
                    <div style="font-size:.9rem;font-weight:600;color:var(--text);margin-top:2px;">
                        {{ $value }}
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Weekly schedule --}}
        <div style="background:#fff;border:1.5px solid var(--border);border-radius:14px;
                    padding:20px 22px;box-shadow:var(--shadow);">
            <div style="font-size:.72rem;font-weight:800;color:var(--muted);
                         text-transform:uppercase;letter-spacing:.5px;margin-bottom:14px;">
                Weekly Availability
            </div>
            <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:10px;">
                @foreach(['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'] as $day)
                @php $ds = $counselor->schedules->where('day_of_week',$day); @endphp
                <div style="background:{{ $ds->isNotEmpty() ? '#f0fdf4' : '#f9fafb' }};
                            border:1.5px solid {{ $ds->isNotEmpty() ? '#bbf7d0' : 'var(--border)' }};
                            border-radius:10px;padding:12px 14px;">
                    <div style="font-size:.68rem;font-weight:800;
                                color:{{ $ds->isNotEmpty() ? '#166534' : '#9ca3af' }};
                                text-transform:uppercase;letter-spacing:.4px;margin-bottom:5px;">
                        {{ $day }}
                    </div>
                    @if($ds->isNotEmpty())
                        @foreach($ds as $sch)
                        <div style="font-size:.82rem;font-weight:600;color:#111827;
                                    display:flex;align-items:center;gap:4px;">
                            <i class="fas fa-clock" style="color:#16a34a;font-size:.6rem;"></i>
                            {{ \Carbon\Carbon::parse($sch->start_time)->format('h:i A') }}
                            &mdash;
                            {{ \Carbon\Carbon::parse($sch->end_time)->format('h:i A') }}
                        </div>
                        @endforeach
                    @else
                        <div style="font-size:.8rem;color:#9ca3af;">Not Available</div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>

    </div>
</div>

</x-app-layout>
