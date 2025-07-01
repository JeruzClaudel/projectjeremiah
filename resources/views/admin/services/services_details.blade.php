@vite('resources/css/style1.css')
@vite('resources/js/message.js')
<x-app-layout>
        <div class="top-bar">
            <a class="top-button back" href="{{ route('admin.services.dashboard') }}">&larr; BACK</a>
            <h2 class="navigation-title">{{ $services['name'] }}</h2>
        </div>
        <div class="nav-line-separator"></div>
        <div class="pane">
            <div class="right-side">
                <div class="data-info-pane">
                    <div class="information name">
                        <p class="type">NAME</p>
                        <p class="content">{{ $services['name'] }}</p>
                    </div>
                    
                    <div class="information name">
                        <p class="type">DESCRIPTION</p>
                        <p class="content">{!! nl2br(e($services['description'])) !!}</p>
                    </div>
                    

                    <div class="line-separator"></div>
                    <div class="information">
                        <p class="type">CONSULTATION LINK: </p>
                       @if ($services['consultations_id'])
                            <a href="{{ route('admin.consultation.details', $services['consultations_id']) }}" target="_blank" rel="noopener noreferrer">
                                View Consultation Link 
                            </a>
                        @else
                            <span>None</span>
                        @endif
                    </div>
                </div>
                <div class="action">
                <form class="delete-form" action="{{ route('admin.services.edit', ['id' => $services->id]) }}" method="GET">
                    <input class="add-button" type="submit" value="EDIT SERVICE" />
                </form>
                <form action="{{ route('admin.services.delete', ['id' => $services->id]) }}" method="POST">
                    @csrf
                    @method('delete')
                    <input class="hidden" name="id" value="{{ $services->id }}"/>
                    <input class="add-button remove" type="submit" value="REMOVE SERVICE" />
                </form>
                </div>
            </div>
        </div>
        <x-alert></x-alert>
</x-app-layout>
