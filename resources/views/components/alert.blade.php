@if(session('updated'))
    <div class="floating-window updated">
        <p>{{ session('updated') }}</p>
    </div>
@endif
@if(session('added'))
    <div class="floating-window added">
        <p>{{ session('added') }}</p>
    </div>
@endif
@if(session('deleted'))
    <div class="floating-window deleted">
        <p>{{ session('deleted') }}</p>
    </div>
@endif