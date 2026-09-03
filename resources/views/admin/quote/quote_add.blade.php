<x-app-layout title="Add Quote">
<div class="top-bar">
    <a class="top-button back" href="{{ route('admin.quote.index') }}">&larr; Back</a>
    <h2 class="navigation-title">Add Quote</h2>
</div>
<div class="nav-line-separator"></div>

<div class="pane">
    <div class="right-side" style="max-width:580px;">
        <form action="{{ route('admin.quote.store') }}" method="POST" class="form-example">
            @csrf
            <div class="data-info-pane">
                <div class="information">
                    <label class="type">AUTHOR</label>
                    <input type="text" name="author" class="content"
                           value="{{ old('author', request('author')) }}"
                           placeholder="e.g. Nelson Mandela">
                    @error('author')<span class="text-danger">{{ $message }}</span>@enderror
                </div>
                <div class="information">
                    <label class="type">QUOTE</label>
                    <textarea name="quote" class="content" rows="6"
                              style="width:100%;padding:10px;"
                              placeholder="Enter the quote text…" required>{{ old('quote', request('quote')) }}</textarea>
                    @error('quote')<span class="text-danger">{{ $message }}</span>@enderror
                </div>
            </div>
            <input class="add-button" type="submit" value="Save Quote">
        </form>
    </div>
</div>
</x-app-layout>
