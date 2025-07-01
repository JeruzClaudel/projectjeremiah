@vite('resources/css/style1.css')
@vite('resources/js/message.js')
<x-app-layout>
    <div class="top-bar">
        <h2 class="navigation-title">Manage Services</h2>
        <a class="top-button add" href="{{ route('admin.services.add')}}">&#65291 ADD SERVICES</a>
    </div>
    <div class="nav-line-separator"></div>
    <div class="data-container">
        @foreach ($services as $service)
            <div class="data-entry">
                <div class="data-info">
                    <p class="content">{{ $service['name'] }}</p>
                    <p class="type">Descrption: {{ Str::limit(strip_tags($service['description']), 50) }}</p>
                    <p> </p>
                    
                    <div class="line-separator"></div>
                    <a class="detail-button" href="{{ route('admin.services.details', [ 'id' => $service['id'] ]) }}">VIEW</a>
                </div>
            </div>
        @endforeach
    </div>
    <x-alert></x-alert>
</x-app-layout>
