<x-app-layout title="Edit Resource">

<div class="top-bar">
    <a class="top-button back" href="{{ route('admin.support.details', $resource->id) }}">&larr; Back</a>
    <h2 class="navigation-title">Edit Support Resource</h2>
</div>
<div class="nav-line-separator"></div>

<div class="pane">
    <div class="right-side" style="max-width:580px;">
        <form action="{{ route('admin.support.update', $resource->id) }}" method="POST" class="form-example">
            @csrf @method('PUT')
            <div class="data-info-pane">

                <div class="information">
                    <label class="type">TITLE <span style="color:#ef4444;">*</span></label>
                    <input type="text" name="title" class="content"
                           value="{{ old('title', $resource->title) }}" required>
                    @error('title')<span class="text-danger">{{ $message }}</span>@enderror
                </div>

                <div class="information">
                    <label class="type">TYPE
                        <span style="color:var(--muted);font-weight:400;font-size:.7rem;text-transform:none;margin-left:4px;">(optional)</span>
                    </label>
                    <input type="text" name="type" class="content"
                           value="{{ old('type', $resource->type) }}"
                           placeholder="e.g. Counseling, Workshop, Helpline">
                </div>

                <div class="information">
                    <label class="type">LINK / URL
                        <span style="color:var(--muted);font-weight:400;font-size:.7rem;text-transform:none;margin-left:4px;">(optional)</span>
                    </label>
                    <input type="url" name="url" class="content"
                           value="{{ old('url', $resource->url) }}"
                           placeholder="https://…">
                    @error('url')<span class="text-danger">{{ $message }}</span>@enderror
                </div>

                <div class="information">
                    <label class="type">DESCRIPTION
                        <span style="color:var(--muted);font-weight:400;font-size:.7rem;text-transform:none;margin-left:4px;">(optional)</span>
                    </label>
                    <textarea name="description" class="content" rows="5"
                              style="width:100%;padding:10px;">{{ old('description', $resource->description) }}</textarea>
                </div>

            </div>
            <input class="add-button" type="submit" value="Save Changes">
        </form>
    </div>
</div>

</x-app-layout>
