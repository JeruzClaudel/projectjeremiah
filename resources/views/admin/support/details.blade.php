
<x-app-layout title="Resource Details">
<div class="top-bar">
    <a class="top-button back" href="{{ route('admin.support.index') }}">&larr; BACK</a>
    <h2 class="navigation-title">Support Resource Details</h2>
</div>
<div class="nav-line-separator"></div>
<div class="pane"><div class="data-info-pane" style="max-width:600px;">
    <div class="information"><label class="type">TITLE</label><p class="content">{{ $resource->title }}</p></div>
    @if($resource->type)
    <div class="information"><label class="type">TYPE</label><p class="content">{{ $resource->type }}</p></div>
    @endif
    @if($resource->url)
    <div class="information"><label class="type">URL</label>
        <p class="content"><a href="{{ $resource->url }}" target="_blank">{{ $resource->url }}</a></p>
    </div>
    @endif
    @if($resource->slots !== null)
    <div class="information"><label class="type">SLOTS</label><p class="content">{{ $resource->slots }}</p></div>
    @endif
    @if($resource->description)
    <div class="information"><label class="type">DESCRIPTION</label>
        <p class="content" style="white-space:pre-wrap;">{{ $resource->description }}</p>
    </div>
    @endif
    <div style="display:flex;gap:10px;margin-top:16px;flex-wrap:wrap;">
        <a href="{{ route('admin.support.edit',$resource->id) }}" class="add-button" style="text-decoration:none;">EDIT</a>
        <form id="del-support-{{ $resource->id }}"
              action="{{ route('admin.support.delete',$resource->id) }}" method="POST" style="margin:0;">
            @csrf @method('DELETE')
        </form>
        <button type="button" class="add-button" style="background:#dc2626;border-color:#dc2626;"
                onclick="confirmDelete('del-support-{{ $resource->id }}','this resource')">DELETE</button>
    </div>
</div></div>
</x-app-layout>
