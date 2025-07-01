@vite('resources/css/style1.css')
@vite('resources/js/message.js')
<x-app-layout>
    <div class="top-bar">
        <h2 class="navigation-title">Manage Quotes</h2>
        <a class="top-button add" href="{{ route('admin.quote.add')}}">&#65291 ADD QUOTE</a>
    </div>
    <div class="nav-line-separator"></div>
    <div class="data-container">
        @foreach ($quotes as $quote)
            <div class="data-entry">
                <div class="data-info">
                    <p class="content">{{ $quote['author'] }}</p>
                    <p class="type">{{ $quote['quote'] }}</p>
                    <div class="line-separator"></div>
                    <a class="detail-button" href="{{ route('admin.quote.details', [ 'id' => $quote['id'] ]) }}">VIEW</a>
                </div>
            </div>
        @endforeach
    </div>
    <x-alert></x-alert>
</x-app-layout>
