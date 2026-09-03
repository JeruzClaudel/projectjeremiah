
<x-app-layout title="Resources">
<div class="top-bar">
    <h2 class="navigation-title">Resources Overview</h2>
    <a href="{{ route('admin.support.add') }}" class="top-button add">&#65291; ADD RESOURCE</a>
</div>
<div class="nav-line-separator"></div>

<div class="data-container">
    @forelse($resources as $resource)
        <div class="data-entry">
            <div class="data-info">
                <p class="content">{{ $resource->title }}</p>
                @if($resource->type)<p class="type">{{ $resource->type }}</p>@endif
                @if($resource->slots !== null)<p class="type">Slots available: {{ $resource->slots }}</p>@endif
                <div class="line-separator"></div>
                <a class="detail-button" href="{{ route('admin.support.details',$resource->id) }}">VIEW</a>
            </div>
        </div>
    @empty
        <div style="text-align:center;padding:48px;color:#9ca3af;">
            <i class="fas fa-folder-open" style="font-size:2rem;display:block;margin-bottom:12px;"></i>
            No resources found.
            <a href="{{ route('admin.support.add') }}" style="color:#0a1931;font-weight:600;">Add one</a>
        </div>
    @endforelse
</div>
</x-app-layout>
