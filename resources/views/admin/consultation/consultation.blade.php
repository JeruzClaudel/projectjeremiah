@vite('resources/css/style1.css')
@vite('resources/js/message.js')
<x-app-layout>
    <div class="top-bar">
        <h2 class="navigation-title">Manage Consultation Links</h2>
        <a class="top-button add" href="{{ route('admin.consultation.add')}}">&#65291 ADD CONSULTATION LINKS</a>
    </div>
    <div class="nav-line-separator"></div>
    <div class="data-container">
        @foreach ($consultations as $consultation)
            <div class="data-entry">
                <div class="data-info">
                    <p class="content">{{ $consultation['name'] }}</p>
                    <p class="type">Request Link:
                    <a href="{{ $consultation['request_link'] }}" target="_blank" rel="noopener noreferrer">
                            {{ $consultation['request_link'] }}
                        </a></p>
                    <div class="line-separator"></div>
                    <a class="detail-button" href="{{ route('admin.consultation.details', [ 'id' => $consultation['id'] ]) }}">VIEW</a>
                </div>
            </div>
        @endforeach
    </div>
    <x-alert></x-alert>
</x-app-layout>
