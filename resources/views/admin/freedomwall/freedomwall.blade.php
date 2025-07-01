@vite('resources/css/style1.css')
@vite('resources/js/message.js')
<x-app-layout>
    <div class="top-bar">
        <h2 class="navigation-title">POSTS</h2>
        
    </div>
    <div class="nav-line-separator"></div>

      <!-- Filter Form -->
    <!-- Filter Form -->
<div class="filter-form">
    <form method="GET" action="{{ route('admin.freedomwall.freedomwall') }}">
        <label for="start_date">Start Date:</label>
        <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}">
        <label for="end_date">End Date:</label>
        <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}">

        <button type="submit" class="filter-button">Filter</button>

        <!-- Today Button -->
        <a href="{{ route('admin.freedomwall.freedomwall', ['start_date' => \Carbon\Carbon::now()->toDateString(), 'end_date' => \Carbon\Carbon::now()->toDateString()]) }}"
           class="filter-button">
            <center>Today</center>
        </a>
    </form>
</div>

<!-- Entry Count -->
<div class="entry-count" style="margin: 20px; font-weight: bold;">
    <p>Total Posts: <strong>{{ $entries->total() }}</strong></p>
</div>

    <div class="data-container">
        @foreach ($entries as $post)
            <div class="data-entry">
                <div class="data-info">
                    <p class="content">{{ $post['postName'] }}</p>
                    <p class="type">Post: {{ Str::limit($post['post'], 100) }}</p>
                    <p class="type">Created at: {{ \Carbon\Carbon::parse($post['created_at'])->format('M d, Y h:i A') }}</p>
                    <div class="line-separator"></div>
                    <a class="detail-button" href="{{ route('admin.freedomwall.details', [ 'id' => $post['id'] ]) }}">VIEW</a>
                </div>
            </div>
        @endforeach
    </div>
    <x-alert></x-alert>


    <div class="pagination-links">
    {{ $entries->links() }}
</div>
</x-app-layout>
