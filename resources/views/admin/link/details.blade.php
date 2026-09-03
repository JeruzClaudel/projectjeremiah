
<x-app-layout title="Link Details">
<div class="top-bar">
    <a class="top-button back" href="{{ route('admin.link.index') }}">&larr; BACK</a>
    <h2 class="navigation-title">Link Details</h2>
</div>
<div class="nav-line-separator"></div>
<div class="pane"><div class="data-info-pane" style="max-width:600px;">
    <div class="information"><label class="type">NAME</label><p class="content">{{ $link->name }}</p></div>
    <div class="information"><label class="type">URL</label>
        <p class="content"><a href="{{ $link->url }}" target="_blank">{{ $link->url }}</a></p>
    </div>
    <div class="information"><label class="type">CATEGORY</label><p class="content">{{ $link->category ?? '—' }}</p></div>
    <div class="information"><label class="type">ICON CLASS</label><p class="content">{{ $link->icon ?? '—' }}</p></div>
    <div class="information"><label class="type">STATUS</label>
        <p class="content">{{ $link->is_active ? 'Active' : 'Inactive' }}</p>
    </div>
    <div style="display:flex;gap:10px;margin-top:16px;flex-wrap:wrap;">
        <a href="{{ route('admin.link.edit',$link->id) }}" class="add-button" style="text-decoration:none;">EDIT</a>
        <form id="del-link-{{ $link->id }}"
              action="{{ route('admin.link.destroy',$link->id) }}" method="POST" style="margin:0;">
            @csrf @method('DELETE')
        </form>
        <button type="button" class="add-button" style="background:#dc2626;border-color:#dc2626;"
                onclick="confirmDelete('del-link-{{ $link->id }}','this link')">DELETE</button>
    </div>
</div></div>
</x-app-layout>
