@extends('layouts.user')

@section('styles')
    @vite('resources/css/styles.css')
@endsection

@section('content')
<div class="e-hayag-container page-container bg-blue">
    <div class="top-bar">
        <h2 class="navigation-title">e-Hayag</h2>
    </div>
    <center>
       <p>Share your thoughts, feelings, and experiences anonymously. <br>This is a safe space where your voice matters and your privacy is protected.
        </p>
    </center>
    <div class="nav-line-separator"></div>

    <div class="form-wrapper page-container">
        <form action="{{ route('freedomwall.store') }}" method="POST" class="freedom-form">
            @csrf
            <div class="form-group">
                <label for="postName" class="form-label">Post Name <small>(optional)</small></label>
                <input type="text" id="postName" name="postName" class="form-input" placeholder="e.g., Concerned Student">
            </div>

            <div class="form-group">
                <label for="post" class="form-label">Post</label>
                <textarea id="post" name="post" class="form-textarea" rows="5" placeholder="Express yourself..."></textarea>
            </div>

            <div class="form-group">
                <button type="submit" class="submit-button">Confirm</button>
            </div>
        </form>
    </div>
</div>

<x-alert />
@endsection
