@vite('resources/css/style1.css')
<x-app-layout>
        <div class="top-bar">
            <a class="top-button back" href="{{ route('admin.consultation.dashboard') }}">&larr; BACK</a>
            <h2 class="navigation-title">Add Consultation Link</h2>
        </div>
        <div class="nav-line-separator"></div>
        <div class="pane">
            <div class="right-side">
                <form action="{{ route('admin.consultation.details', $consultations->id) }}" method="POST" class="form-example">
                    @csrf
                    @method('PUT')
                    <div class="data-info-pane">
                        <div class="information name">
                            <label class="type" for="name">CONSULTATION LINK NAME</label>
                            <input type="text" id="name" name="name" class="content" value="{{ $consultations->name }}"/>
                        </div>

                        <div class="information">
                            <label class="type" for="description">DESCRIPTION</label>
                            <textarea id="description" name="description" class="content" rows="4" style="width: 100%; padding: 10px;">{{$consultations['description']}}</textarea>
                        </div>

                        <div class="information">
                            <label class="type" for="request-link">REQUEST LINK</label>
                            <input type="text" id="request-link" name="request_link" class="content" value="{{ $consultations->request_link }}"/>
                        </div>
                    </div>
                    <input class="add-button" type="submit" value="SAVE CHANGES" />
                </form>
            </div>
        </div>
</x-app-layout>
