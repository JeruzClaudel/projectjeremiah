@vite('resources/css/style1.css')
<x-app-layout>
        <div class="top-bar">
            <a class="top-button back" href="{{ route('admin.hotline.dashboard') }}">&larr; BACK</a>
            <h2 class="navigation-title">Hotlines - Add</h2>
        </div>
        <div class="nav-line-separator"></div>
        <div class="pane">
            <div class="right-side">
                <form action="{{ route('admin.hotline.details', ['id' => $hotlines->id]) }}" method="POST" class="form-example">
                    @csrf
                    @method('PUT')
                    <div class="data-info-pane">
                        <div class="information name">
                            <label class="type" for="name">HOTLINE NAME</label>
                            <input type="text" id="name" name="name" class="content" value="{{ $hotlines->name }}"/>
                        </div>
                        <div class="information">
                            <label class="type" for="phone-number">PHONE NUMBER</label>
                            <input type="text" id="phone-number" name="phone_number" class="content" value="{{ $hotlines->phone_number }}"/>
                        </div>
                        <div class="information">
                            <label class="type" for="email">EMAIL</label>
                            <input type="text" id="email" name="email" class="content" value="{{ $hotlines->email }}"/>
                        </div>
                        <div class="information">
                            <label class="type" for="availability">AVAILABILITY</label>
                            <input type="text" id="availability" name="availability" class="content" value="{{ $hotlines->availability }}"/>
                        </div>
                        <div class="information">
                            <label class="type" for="site_link">SITE LINK</label>
                            <input type="text" id="site_link" name="site_link" class="content" value="{{ $hotlines->site_link }}"/>
                        </div>
                    </div>
                    <input class="add-button" type="submit" value="SAVE CHANGES" />
                </form>
            </div>
        </div>
</x-app-layout>
