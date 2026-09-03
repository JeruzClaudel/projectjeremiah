
<x-app-layout title="Manage Accounts">
<style>
.accounts-table { width:100%;border-collapse:collapse;background:#fff;border-radius:14px;
    overflow:hidden;box-shadow:0 2px 10px rgba(0,0,0,.06);border:1.5px solid #e5e7eb; }
.accounts-table thead tr { background:linear-gradient(135deg,#0a1931,#1c2a4d); }
.accounts-table thead th { padding:13px 16px;font-size:.72rem;font-weight:800;color:#f0c419;
    text-transform:uppercase;letter-spacing:.6px;text-align:left;border:none; }
.accounts-table tbody tr { border-bottom:1px solid #f3f4f6;transition:background .15s; }
.accounts-table tbody tr:hover { background:#fef9e7; }
.accounts-table td { padding:13px 16px;font-size:.9rem;color:#374151;vertical-align:middle; }
.btn-edit { display:inline-flex;align-items:center;gap:5px;padding:6px 13px;background:#eff6ff;
    color:#1d4ed8;border:1px solid #bfdbfe;border-radius:7px;font-size:.78rem;font-weight:700;
    text-decoration:none;transition:background .15s;margin-right:5px; }
.btn-edit:hover { background:#dbeafe;color:#1e40af;text-decoration:none; }
.btn-del2 { display:inline-flex;align-items:center;gap:5px;padding:6px 13px;background:#fef2f2;
    color:#dc2626;border:1px solid #fecaca;border-radius:7px;font-size:.78rem;font-weight:700;
    cursor:pointer;transition:background .15s; }
.btn-del2:hover { background:#fee2e2; }
.you-badge { display:inline-flex;align-items:center;padding:2px 8px;background:#f0fdf4;
    color:#166534;border:1px solid #bbf7d0;border-radius:999px;font-size:.65rem;font-weight:700;margin-left:6px; }
</style>

<div class="top-bar">
    <h2 class="navigation-title">Manage Accounts</h2>
    <a href="{{ route('admin.accounts.create') }}" class="top-button add">
        <i class="fas fa-plus"></i> Add Account
    </a>
</div>
<div class="nav-line-separator"></div>

@if(session('success'))
    <div style="background:#f0fdf4;border:1.5px solid #bbf7d0;border-radius:9px;padding:10px 16px;margin-bottom:16px;color:#166534;font-size:.88rem;">
        ✅ {{ session('success') }}
    </div>
@endif

@php $protectedIds = array_map('intval', explode(',', config('app.protected_admin_ids','1,2'))); @endphp

<div style="overflow-x:auto;">
    <table class="accounts-table">
        <thead>
            <tr><th>#</th><th>Name</th><th>Email</th><th>Created</th><th>Actions</th></tr>
        </thead>
        <tbody>
            @forelse($accounts as $i => $account)
            <tr>
                <td style="color:#9ca3af;font-size:.8rem;">{{ $i+1 }}</td>
                <td>
                    <span style="font-weight:700;color:#111827;">{{ $account->name }}</span>
                    @if($account->id === auth()->id())
                        <span class="you-badge">You</span>
                    @endif
                    @if(in_array($account->id,$protectedIds))
                        <span style="display:inline-flex;align-items:center;gap:3px;padding:2px 8px;
                            background:#fef9e7;color:#c9a227;border:1px solid rgba(201,162,39,.35);
                            border-radius:999px;font-size:.62rem;font-weight:800;margin-left:5px;">
                            <i class="fas fa-shield-halved" style="font-size:.55rem;"></i> System
                        </span>
                    @endif
                </td>
                <td style="color:#6b7280;">{{ $account->email }}</td>
                <td style="color:#9ca3af;font-size:.8rem;">{{ $account->created_at->format('M d, Y') }}</td>
                <td>
                    <a href="{{ route('admin.accounts.edit',$account) }}" class="btn-edit">
                        <i class="fas fa-pen"></i> Edit
                    </a>
                    @if($account->id !== auth()->id() && !in_array($account->id,$protectedIds))
                        <form id="del-acc-{{ $account->id }}"
                              action="{{ route('admin.accounts.destroy',$account) }}"
                              method="POST" style="display:inline;margin:0;">
                            @csrf @method('DELETE')
                        </form>
                        <button type="button" class="btn-del2"
                                onclick="confirmDelete('del-acc-{{ $account->id }}','{{ addslashes($account->name) }}\'s account')">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    @elseif(in_array($account->id,$protectedIds))
                        <span style="padding:5px 12px;background:#f3f4f6;color:#9ca3af;border-radius:7px;
                                     font-size:.75rem;font-weight:600;border:1px solid #e5e7eb;">
                            <i class="fas fa-lock" style="font-size:.65rem;"></i> Protected
                        </span>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="5" style="text-align:center;padding:40px;color:#9ca3af;">No accounts found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
</x-app-layout>
