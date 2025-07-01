@vite('resources/css/style1.css')
<x-app-layout>
        <div class="top-bar">
            <a class="top-button back" href="{{ route('admin.hotline.dashboard') }}">&larr; BACK</a>
            <h2 class="navigation-title">Hotlines - Add</h2>
        </div>
        <div class="nav-line-separator"></div>
        <div class="pane">
            <div class="right-side">
                <form action="" method="POST" class="form-example">
                    @csrf
                    <div class="data-info-pane">
                        <div class="information name">
                            <label class="type" for="name">HOTLINE NAME</label>
                            <input type="text" id="name" name="name" class="content"/>
                        </div>
                        <div class="information">
                            <label class="type" for="phone-number">PHONE NUMBER</label>
                            <input type="text" id="phone-number" name="phone_number" class="content"/>
                        </div>
                        <div class="information">
                            <label class="type" for="email">EMAIL</label>
                            <input type="text" id="email" name="email" class="content"/>
                        </div>
                        <div class="information">
                            <label class="type" for="availability">AVAILABILITY</label>
                            <input type="text" id="availability" name="availability" class="content"/>
                        </div>
                        <div class="information">
                            <label class="type" for="site_link">SITE LINK</label>
                            <input type="text" id="site_link" name="site_link" class="content"/>
                        </div>
                    </div>
                    <input class="add-button" type="submit" value="CONFIRM" />
                </form>
            </div>
        </div>
</x-app-layout>
