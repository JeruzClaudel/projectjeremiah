@extends('layouts.user')
@section('title', 'Hotlines — Project Jeremiah')

@section('content')

<div class="hotline-hero">
    <div class="shell">
        <div class="breadcrumbs">Project Jeremiah / Hotlines</div>
        <h1>Need immediate help?</h1>
        <p>Reach out. Help is available. Find a support line below, or contact your local emergency services if you are in immediate danger.</p>
    </div>
</div>

<div class="section">
    <div class="shell">
        <div class="section-heading">
            <div>
                <p class="eyebrow">You do not have to handle this alone</p>
                <h2>Support hotlines</h2>
            </div>
            <p>These resources provide 24/7 support when you need it most.</p>
        </div>

        <div class="hotline-grid">
            @forelse($entries as $entry)
            <div class="card hotline-card-pub card-hover">
                <span class="tag">Emergency</span>
                <h3>{{ $entry->name }}</h3>
                @if($entry->phone_number)
                    <div class="hotline-phone">{{ $entry->phone_number }}</div>
                @endif
                @if($entry->email)
                    <p style="font-size:.8rem;color:var(--muted);margin-top:4px;">{{ $entry->email }}</p>
                @endif
                <div class="hotline-availability">
                    {{ $entry->availability ?? 'Available 24/7' }}
                </div>
                <div class="hotline-actions">
                    @if($entry->phone_number)
                    <a class="btn btn-primary btn-sm" href="tel:{{ preg_replace('/[^0-9+]/','',$entry->phone_number) }}">Call now</a>
                    @endif
                    @if($entry->site_link)
                    <a class="btn btn-secondary btn-sm" href="{{ route('user.hotline.details', $entry->id) }}">Details</a>
                    @endif
                </div>
            </div>
            @empty
            <div class="card" style="grid-column:1/-1;padding:48px;text-align:center;color:var(--muted);">
                No hotlines have been added yet.
            </div>
            @endforelse
        </div>
    </div>
</div>

{{-- Additional Support Resources --}}
@if(isset($resources) && $resources->count())
<div class="section section-alt">
    <div class="shell">
        <div class="section-heading">
            <div>
                <p class="eyebrow">More ways to find support</p>
                <h2>Additional support resources</h2>
            </div>
        </div>
        <div class="resource-grid-pub">
            @foreach($resources as $resource)
            <div class="card resource-card-pub card-hover">
                <div class="icon-box">
                    @php $icons = ['◌','✧','♧','☼','⌖','→','♡','⌁']; @endphp
                    {{ $icons[$loop->index % count($icons)] }}
                </div>
                <h3>{{ $resource->title }}</h3>
                @if($resource->description)
                    <p>{{ Str::limit($resource->description, 90) }}</p>
                @else
                    <p style="flex:1;"></p>
                @endif
                @if($resource->url)
                    <a class="text-link" href="{{ $resource->url }}" target="_blank">Learn more →</a>
                @endif
            </div>
            @endforeach
        </div>

        <div class="emergency-bar">
            <div class="em-icon">!</div>
            <div>
                <strong>If you are in immediate danger or experiencing an emergency</strong>
                <p>Contact your local emergency services or go to the nearest emergency facility.</p>
            </div>
        </div>
    </div>
</div>
@else
<div class="section section-alt">
    <div class="shell">
        <div class="section-heading">
            <div>
                <p class="eyebrow">More ways to find support</p>
                <h2>Additional support resources</h2>
            </div>
        </div>
        <div class="resource-grid-pub">
            @foreach([['◌','Guidance Office','Connect with your campus guidance team.',null],['✧','Mental Health','Learn about care and wellbeing.',null],['♧','Student Support','Find practical help for student life.',null],['☼','Self-Help','Small tools for difficult moments.',null],['!','Emergency Services','Get urgent help when you need it.','tel:911']] as [$ico,$title,$desc,$url])
            <div class="card resource-card-pub card-hover">
                <div class="icon-box">{{ $ico }}</div>
                <h3>{{ $title }}</h3>
                <p>{{ $desc }}</p>
                @if($url)<a class="text-link" href="{{ $url }}">→</a>@endif
            </div>
            @endforeach
        </div>
        <div class="emergency-bar">
            <div class="em-icon">!</div>
            <div>
                <strong>If you are in immediate danger or experiencing an emergency</strong>
                <p>Contact your local emergency services or go to the nearest emergency facility.</p>
            </div>
        </div>
    </div>
</div>
@endif

@endsection
