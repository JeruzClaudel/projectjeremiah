
<x-app-layout title="Support Resources">
<div class="top-bar">
    <h2 class="navigation-title">Support Resources</h2>
    <a href="{{ route('admin.support.add') }}" class="top-button add">&#65291; ADD RESOURCE</a>
</div>
<div class="nav-line-separator"></div>

@if(session('success'))
    <div style="background:#f0fdf4;border:1.5px solid #bbf7d0;border-radius:9px;padding:10px 16px;margin-bottom:16px;color:#166534;font-size:.88rem;">✅ {{ session('success') }}</div>
@endif

<div class="data-container">
    @forelse($resources as $resource)
        <div class="data-entry">
            <div class="data-info">
                <p class="content">{{ $resource->title }}</p>
                @if($resource->type)<p class="type">{{ $resource->type }}</p>@endif
                @if($resource->url)
                    <p class="type"><a href="{{ $resource->url }}" target="_blank">{{ $resource->url }}</a></p>
                @endif
                @if($resource->slots !== null)<p class="type">Slots: {{ $resource->slots }}</p>@endif
                <div class="line-separator"></div>
                <a class="detail-button" href="{{ route('admin.support.details',$resource->id) }}">VIEW</a>
            </div>
        </div>
    @empty
        <p style="color:#9ca3af;padding:20px;">No support resources yet.</p>
    @endforelse
</div>
</x-app-layout>
