@vite('resources/css/style1.css')
@vite('resources/js/message.js')
<x-app-layout>
    <div class="top-bar">
        <h2 class="navigation-title">Manage Emergency Hotlines</h2>
        <a class="top-button add" href="{{ route('admin.hotline.add')}}">&#65291 ADD HOTLINE</a>
    </div>
    <div class="nav-line-separator"></div>
    <div class="data-container">
        @foreach ($hotlines as $hotline)
            <div class="data-entry">
                <div class="data-info">
                    <p class="content">{{ $hotline['name'] }}</p>
                    <p class="type">{{ $hotline['phone_number'] }}</p>
                    <p class="type">{{ $hotline['email'] }}</p>
                    <p class="type">{{ $hotline['availability'] }}</p>
                    <p class="type">{{ $hotline['site_link'] }}</p>
                    <div class="line-separator"></div>
                    <a class="detail-button" href="{{ route('admin.hotline.details', [ 'id' => $hotline['id'] ]) }}">VIEW</a>
                </div>
            </div>
        @endforeach
    </div>
    <x-alert></x-alert>
</x-app-layout>
