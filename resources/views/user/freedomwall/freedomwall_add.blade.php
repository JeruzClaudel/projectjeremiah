@extends('layouts.user')
@section('title', 'e-Hayag — Project Jeremiah')

@section('content')

<div class="shell hayag-layout">
    <div class="hayag-copy">
        <p class="eyebrow">A safe channel to speak up</p>
        <h1>e-Hayag</h1>
        <p>Your voice matters. Your concerns deserve to be heard. e-Hayag is a private, non-judgmental way to let the guidance office know what you are experiencing.</p>
        <div class="actions">
            <a class="btn btn-primary" href="{{ route('user.freedomwall.create') }}">Start Writing <span>↗</span></a>
            <a class="btn btn-secondary" href="{{ route('user.hotline') }}">Need immediate help?</a>
        </div>
    </div>

    <div class="safe-card">
        <div class="icon-box" style="margin-bottom:16px;">✎</div>
        <h3>You can share at your own pace.</h3>
        <p>You do not have to have the right words. Tell us what you can, and an authorized guidance person can help you find a next step.</p>
        <ul class="safe-list">
            <li>Designed with privacy in mind</li>
            <li>Write openly, without judgment</li>
            <li>Seen only by guidance counselors</li>
            <li>Requires your registered student email</li>
        </ul>
    </div>
</div>

<div class="section section-alt">
    <div class="shell">
        <div class="section-heading">
            <div>
                <p class="eyebrow">Before you begin</p>
                <h2>A few things to know</h2>
            </div>
        </div>
        <div class="hayag-info-grid">
            <div class="card hayag-info-card card-hover">
                <div class="icon-box">♡</div>
                <h3>You are welcome here</h3>
                <p>Concerns about school, home, relationships, or how you feel are all valid reasons to reach out.</p>
            </div>
            <div class="card hayag-info-card card-hover">
                <div class="icon-box icon-box-alt">⌁</div>
                <h3>Share only what feels safe</h3>
                <p>Give enough context for support, but never include passwords or information you do not want to share.</p>
            </div>
            <div class="card hayag-info-card card-hover">
                <div class="icon-box">!</div>
                <h3>Not for emergencies</h3>
                <p>For immediate danger or urgent crisis support, please use the Hotlines page or local emergency services.</p>
                <a class="text-link" href="{{ route('user.hotline') }}">View hotlines →</a>
            </div>
            <div class="card hayag-info-card card-hover">
                <div class="icon-box">→</div>
                <h3>Ready when you are</h3>
                <p>Start with a few lines. The guidance office can help from there. Register first if you haven't yet.</p>
                <a class="text-link" href="{{ route('user.freedomwall.create') }}">Start writing →</a>
            </div>
        </div>
    </div>
</div>

@endsection
