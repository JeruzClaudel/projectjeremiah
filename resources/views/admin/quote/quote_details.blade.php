@vite('resources/css/style1.css')
@vite('resources/js/message.js')
<x-app-layout>
        <div class="top-bar">
            <a class="top-button back" href="{{ route('admin.quote.index') }}">&larr; BACK</a>
            <h2 class="navigation-title">Quote - {{ $quote['author'] }}</h2>
        </div>
        <div class="nav-line-separator"></div>
        <div class="pane">
            <div class="right-side">
                <div class="data-info-pane">
                    <div class="information name">
                        <p class="type">Author:</p>
                        <p class="content">{{ $quote['author'] }}</p>
                    </div>
                    <div class="line-separator"></div>
                    <div class="information">
                        <p class="type">Quote:</p>
                        <p class="content">{{ $quote['quote'] }}</p>
                    </div>
                    <div class="line-separator"></div>
                   

                </div>
                <div class="action">
                <form class="edit-form" action="{{ route('admin.quote.edit', ['id' => $quote->id]) }}" method="GET">
                    <input class="add-button" type="submit" value="EDIT QUOTE" />
                </form>

                <form action="{{ route('admin.quote.destroy', ['id' => $quote->id]) }}" method="POST">
                    @csrf
                    @method('delete')
                    <input class="hidden" name="id" value="{{ $quote->id }}"/>
                    <input class="add-button remove" type="submit" value="REMOVE QUOTE" />
                </form>
                </div>
            </div>
        </div>
        <x-alert></x-alert>
</x-app-layout>
