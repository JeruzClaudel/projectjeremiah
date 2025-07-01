@vite('resources/css/style1.css')
@vite('resources/js/message.js')

<x-app-layout>
    <div class="top-bar">
        <h2 class="navigation-title">POST DETAILS</h2>
    </div>

    <div class="nav-line-separator"></div>

     <a class="detail-button" href="{{ route('admin.freedomwall.freedomwall') }}">← BACK TO POSTS</a>
     <br><br>

    <div class="data-container">
        <div class="data-entry">
            <div class="data-info">
                <h3 class="content">{{ $post->postName }}</h3>
                <p class="type"><strong>Post:</strong></p>
                <p class="full-content">{{ $post->post }}</p>

                <p class="type"><strong>Created at:</strong> {{ \Carbon\Carbon::parse($post->created_at)->format('M d, Y h:i A') }}</p>

                <div class="line-separator"></div>

                <form action="{{ route('admin.freedomwall.destroy', $post->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this post?');">
                    @csrf
                    @method('DELETE')
                    <br>
                    <button type="submit" class="delete-button">DELETE POST</button>
                </form>
            </div>
        </div>
    </div>

    <x-alert></x-alert>
</x-app-layout>
