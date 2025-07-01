@vite('resources/css/style1.css')
@vite('resources/js/message.js')
<x-app-layout>
        <div class="top-bar">
            <a class="top-button back" href="{{ route('admin.hotline.dashboard') }}">&larr; BACK</a>
            <h2 class="navigation-title">Hotlines - {{ $hotlines['name'] }}</h2>
        </div>
        <div class="nav-line-separator"></div>
        <div class="pane">
            <div class="right-side">
                <div class="data-info-pane">
                    <div class="information name">
                        <p class="type">NAME</p>
                        <p class="content">{{ $hotlines['name'] }}</p>
                    </div>
                    <div class="line-separator"></div>
                    <div class="information">
                        <p class="type">PHONE NUMBER</p>
                        <p class="content">{{ $hotlines['phone_number'] }}</p>
                    </div>
                    <div class="line-separator"></div>
                    <div class="information">
                        <p class="type">EMAIL</p>
                        <p class="content">{{ $hotlines['email'] }}</p>
                    </div>
                    <div class="line-separator"></div>
                    <div class="information">
                        <p class="type">AVAILABILITY</p>
                        <p class="content">{{ $hotlines['availability'] }}</p>
                    </div>
                    <div class="line-separator"></div>
                    <div class="information">
                        <p class="type">SITE LINK</p>
                        <p class="content">{{ $hotlines['site_link'] }}</p>
                    </div>
                </div>
                <div class="action">
                <form class="delete-form" action="{{ route('admin.hotline.edit', ['id' => $hotlines->id]) }}" method="GET">
                    <input class="add-button" type="submit" value="EDIT HOTLINE" />
                </form>
                <form action="{{ route('admin.hotline.delete', ['id' => $hotlines->id]) }}" method="POST">
                    @csrf
                    @method('delete')
                    <input class="hidden" name="id" value="{{ $hotlines->id }}"/>
                    <input class="add-button remove" type="submit" value="REMOVE HOTLINE" />
                </form>
                </div>
            </div>
        </div>
        <x-alert></x-alert>
</x-app-layout>
