
<x-app-layout title="Add Link">
<div class="top-bar">
    <a class="top-button back" href="{{ route('admin.link.index') }}">&larr; BACK</a>
    <h2 class="navigation-title">Add Quick Link</h2>
</div>
<div class="nav-line-separator"></div>
<div class="pane"><div class="right-side" style="max-width:520px;">
    <form action="{{ route('admin.link.store') }}" method="POST" class="form-example">
        @csrf
        <div class="data-info-pane">
            <div class="information"><label class="type">NAME</label>
                <input type="text" name="name" class="content" value="{{ old('name') }}" required>
                @error('name')<small class="text-danger">{{ $message }}</small>@enderror
            </div>
            <div class="information"><label class="type">URL</label>
                <input type="url" name="url" class="content" value="{{ old('url') }}" required placeholder="https://...">
                @error('url')<small class="text-danger">{{ $message }}</small>@enderror
            </div>
            <div class="information"><label class="type">CATEGORY</label>
                <input type="text" name="category" class="content" value="{{ old('category') }}" placeholder="e.g. Counseling, Emergency">
            </div>
            <div class="information"><label class="type">ICON CLASS <small style="font-weight:400;color:#9ca3af;">(Font Awesome class, e.g. fas fa-phone)</small></label>
                <input type="text" name="icon" class="content" value="{{ old('icon') }}" placeholder="fas fa-link">
            </div>
            <div class="information">
                <label style="display:flex;align-items:center;gap:8px;cursor:pointer;font-size:.85rem;font-weight:600;color:#374151;">
                    <input type="checkbox" name="is_active" value="1"
                           {{ old('is_active',true) ? 'checked' : '' }}
                           style="width:16px;height:16px;accent-color:#0a1931;">
                    Active (visible on public site)
                </label>
            </div>
        </div>
        <input class="add-button" type="submit" value="ADD LINK">
    </form>
</div></div>
</x-app-layout>
