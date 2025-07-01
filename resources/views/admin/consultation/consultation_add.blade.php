@vite('resources/css/style1.css')
<x-app-layout>
        <div class="top-bar">
            <a class="top-button back" href="{{ route('admin.consultation.dashboard') }}">&larr; BACK</a>
            <h2 class="navigation-title">Add Consultation Link</h2>
        </div>
        <div class="nav-line-separator"></div>
        <div class="pane">
            <div class="right-side">
                <form action="{{ route('admin.consultation.add') }}" method="POST" class="form-example">
                    @csrf
                    <div class="data-info-pane">
                        <div class="information name">
                            <label class="type" for="name">CONSULTATION LINK NAME</label>
                            <input type="text" id="name" name="name" class="content"/>
                        </div>
                        <div class="information">
                            <label class="type" for="description">DESCRIPTION</label>
                            <textarea id="description" name="description" class="content" rows="4" style="width: 100%; padding: 10px;"></textarea>
                        </div>
                        <div class="information">
                            <label class="type" for="request-link">REQUEST LINK</label>
                            <input type="text" id="request-link" name="request_link" class="content"/>
                        </div>
                    </div>
                    <input class="add-button" type="submit" value="CONFIRM" />
                </form>
            </div>
        </div>
</x-app-layout>
