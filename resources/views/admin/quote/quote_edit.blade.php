<x-app-layout title="Edit Quote">

<div class="top-bar">
    <a class="top-button back" href="{{ route('admin.quote.details', $quote->id) }}">&larr; Back</a>
    <h2 class="navigation-title">Edit Quote</h2>
</div>
<div class="nav-line-separator"></div>

<div class="pane">
    <div class="right-side" style="max-width:580px;">
        <form action="{{ route('admin.quote.update', $quote->id) }}" method="POST" class="form-example">
            @csrf @method('PUT')
            <div class="data-info-pane">

                <div class="information">
                    <label class="type">AUTHOR
                        <span style="color:var(--muted);font-weight:400;font-size:.7rem;text-transform:none;margin-left:4px;">(optional)</span>
                    </label>
                    <input type="text" name="author" class="content"
                           value="{{ old('author', $quote->author) }}"
                           placeholder="e.g. Nelson Mandela or Guidance Services Office">
                    @error('author')<span class="text-danger">{{ $message }}</span>@enderror
                </div>

                <div class="information">
                    <label class="type">QUOTE TEXT <span style="color:#ef4444;">*</span></label>
                    <textarea name="quote" class="content" rows="6"
                              style="width:100%;padding:10px;min-height:140px;"
                              required>{{ old('quote', $quote->quote) }}</textarea>
                    @error('quote')<span class="text-danger">{{ $message }}</span>@enderror
                </div>

            </div>
            <input class="add-button" type="submit" value="Save Changes">
        </form>
    </div>
</div>

</x-app-layout>
