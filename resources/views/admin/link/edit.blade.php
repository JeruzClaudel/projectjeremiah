<x-app-layout title="Edit Link">

<div class="top-bar">
    <a class="top-button back" href="{{ route('admin.link.details', $link->id) }}">&larr; Back</a>
    <h2 class="navigation-title">Edit Quick Link</h2>
</div>
<div class="nav-line-separator"></div>

<div style="max-width:560px;">
    <div style="background:#fff;border:1.5px solid var(--border);border-radius:16px;
                overflow:hidden;box-shadow:var(--shadow);">

        {{-- Header --}}
        <div style="background:linear-gradient(135deg,var(--navy),var(--navy2));
                    padding:18px 22px;display:flex;align-items:center;gap:12px;">
            <div style="width:40px;height:40px;border-radius:10px;
                        background:rgba(240,196,25,.15);border:1px solid rgba(240,196,25,.3);
                        display:flex;align-items:center;justify-content:center;
                        color:var(--gold);font-size:.95rem;flex-shrink:0;">
                @if($link->icon)<i class="{{ $link->icon }}"></i>@else<i class="fas fa-link"></i>@endif
            </div>
            <div>
                <div style="font-size:.95rem;font-weight:700;color:#fff;">{{ $link->name }}</div>
                <div style="font-size:.72rem;color:rgba(255,255,255,.5);margin-top:2px;">
                    Edit link details below
                </div>
            </div>
        </div>

        {{-- Form --}}
        <div style="padding:22px 24px;">
            <form action="{{ route('admin.link.update', $link->id) }}" method="POST">
                @csrf @method('PUT')

                <div class="information" style="margin-bottom:16px;">
                    <label class="type">LINK NAME <span style="color:#ef4444;">*</span></label>
                    <input type="text" name="name" class="content"
                           value="{{ old('name', $link->name) }}" required
                           placeholder="e.g. Guidance Office Portal">
                    @error('name')<span class="text-danger">{{ $message }}</span>@enderror
                </div>

                <div class="information" style="margin-bottom:16px;">
                    <label class="type">URL <span style="color:#ef4444;">*</span></label>
                    <input type="url" name="url" class="content"
                           value="{{ old('url', $link->url) }}" required
                           placeholder="https://…">
                    @error('url')<span class="text-danger">{{ $message }}</span>@enderror
                </div>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:16px;">
                    <div class="information">
                        <label class="type">CATEGORY</label>
                        <input type="text" name="category" class="content"
                               value="{{ old('category', $link->category) }}"
                               placeholder="e.g. Counseling">
                    </div>
                    <div class="information">
                        <label class="type">ICON CLASS</label>
                        <input type="text" name="icon" class="content"
                               value="{{ old('icon', $link->icon) }}"
                               placeholder="fas fa-link"
                               id="icon-input"
                               oninput="updateIconPreview(this.value)">
                    </div>
                </div>

                {{-- Icon preview --}}
                <div style="margin-bottom:16px;padding:10px 14px;background:var(--light);
                            border:1px solid var(--border);border-radius:9px;
                            display:flex;align-items:center;gap:10px;">
                    <div id="icon-preview"
                         style="width:34px;height:34px;border-radius:8px;
                                background:linear-gradient(135deg,var(--navy),var(--navy2));
                                display:flex;align-items:center;justify-content:center;
                                color:var(--gold);font-size:.9rem;">
                        <i id="icon-el" class="{{ $link->icon ?: 'fas fa-link' }}"></i>
                    </div>
                    <span style="font-size:.78rem;color:var(--muted);">
                        Icon preview — use any
                        <a href="https://fontawesome.com/icons" target="_blank"
                           style="color:var(--navy);font-weight:600;">Font Awesome</a> class
                    </span>
                </div>

                {{-- Active toggle --}}
                <div style="padding:14px 16px;background:var(--light);border:1.5px solid var(--border);
                            border-radius:10px;margin-bottom:20px;">
                    <label style="display:flex;align-items:center;gap:10px;cursor:pointer;margin:0;">
                        <div style="position:relative;width:44px;height:24px;flex-shrink:0;">
                            <input type="checkbox" name="is_active" value="1"
                                   id="is-active-toggle"
                                   {{ old('is_active', $link->is_active) ? 'checked' : '' }}
                                   style="opacity:0;width:0;height:0;position:absolute;"
                                   onchange="updateToggle(this)">
                            <div id="toggle-track"
                                 style="position:absolute;inset:0;border-radius:12px;cursor:pointer;
                                        background:{{ $link->is_active ? '#0a1931' : '#e5e7eb' }};
                                        transition:background .2s;"
                                 onclick="document.getElementById('is-active-toggle').click()">
                                <div id="toggle-thumb"
                                     style="position:absolute;top:3px;width:18px;height:18px;
                                            border-radius:50%;background:#fff;
                                            transition:left .2s;
                                            left:{{ $link->is_active ? '23px' : '3px' }};"></div>
                            </div>
                        </div>
                        <div>
                            <div style="font-size:.84rem;font-weight:700;color:var(--navy);">
                                Active — show in public footer
                            </div>
                            <div style="font-size:.72rem;color:var(--muted);">
                                When active, this link appears in the site footer for students
                            </div>
                        </div>
                    </label>
                </div>

                <div style="display:flex;gap:10px;">
                    <button type="submit"
                            style="flex:1;padding:11px;background:linear-gradient(135deg,var(--navy),var(--navy2));
                                   color:var(--gold);border:none;border-radius:10px;
                                   font-size:.9rem;font-weight:700;cursor:pointer;transition:opacity .18s;"
                            onmouseover="this.style.opacity='.88'"
                            onmouseout="this.style.opacity='1'">
                        <i class="fas fa-floppy-disk me-2"></i> Save Changes
                    </button>
                    <a href="{{ route('admin.link.details', $link->id) }}"
                       style="padding:11px 20px;background:var(--light);color:var(--text);
                              border:1.5px solid var(--border);border-radius:10px;
                              font-size:.9rem;font-weight:600;text-decoration:none;
                              display:flex;align-items:center;">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function updateIconPreview(cls) {
    const el = document.getElementById('icon-el');
    el.className = cls.trim() || 'fas fa-link';
}
function updateToggle(cb) {
    document.getElementById('toggle-track').style.background  = cb.checked ? '#0a1931' : '#e5e7eb';
    document.getElementById('toggle-thumb').style.left        = cb.checked ? '23px'    : '3px';
}
</script>

</x-app-layout>
