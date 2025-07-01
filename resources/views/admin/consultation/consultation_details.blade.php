@vite('resources/css/style1.css')
@vite('resources/js/message.js')
<x-app-layout>
        <div class="top-bar">
            <a class="top-button back" href="{{ route('admin.consultation.dashboard') }}">&larr; BACK</a>
            <h2 class="navigation-title">{{ $consultation['name'] }}</h2>
        </div>
        <div class="nav-line-separator"></div>
        <div class="pane">
            <div class="right-side">
                <div class="data-info-pane">
                    <div class="information name">
                        <p class="type">NAME</p>
                        <p class="content">{{ $consultation['name'] }}</p>
                    </div>
                    
                    <div class="information name">
                        <p class="type">DESCRIPTION</p>
                        <p class="content">{{ $consultation['description'] }}</p>
                    </div>
                    

                    <div class="line-separator"></div>
                    <div class="information">
                        <p class="type">REQUEST LINK</p>
                       <a href="{{ $consultation['request_link'] }}" target="_blank" rel="noopener noreferrer">
                            {{ $consultation['request_link'] }}
                        </a>
                    </div>
                </div>
                <div class="action">
                <form class="delete-form" action="{{ route('admin.consultation.edit', ['id' => $consultation->id]) }}" method="GET">
                    <input class="add-button" type="submit" value="EDIT CONSULTATION LINK" />
                </form>
                <form action="{{ route('admin.consultation.delete', ['id' => $consultation->id]) }}" method="POST">
                    @csrf
                    @method('delete')
                    <input class="hidden" name="id" value="{{ $consultation->id }}"/>
                    <input class="add-button remove" type="submit" value="REMOVE CONSULTATION LINK" />
                </form>
                </div>
            </div>
        </div>
        <x-alert></x-alert>
</x-app-layout>
