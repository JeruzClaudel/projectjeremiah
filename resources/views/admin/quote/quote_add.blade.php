@vite('resources/css/style1.css')
<x-app-layout>
        <div class="top-bar">
            <a class="top-button back" href="{{ route('admin.quote.index') }}">&larr; BACK</a>
            <h2 class="navigation-title">Quote - Add</h2>
        </div>
        <div class="nav-line-separator"></div>
        <div class="pane">
            <div class="right-side">
                <form action="{{route('admin.quote.store')}}" method="POST" class="form-example">
                    @csrf
                    <div class="data-info-pane">
                        <div class="information name">
                            <label class="type" for="author">AUTHOR</label>
                            <input type="text" id="author" name="author" class="content"/>
                        </div>

                         <div class="information name">
                            <label class="type" for="quote">QUOTE</label>
                            <textarea id="quote" name="quote" class="content" rows="4" style="width: 100%; padding: 10px;"></textarea>
                        </div>
                       
                    </div>
                    <input class="add-button" type="submit" value="SUBMIT" />
                </form>
            </div>
        </div>
</x-app-layout>
