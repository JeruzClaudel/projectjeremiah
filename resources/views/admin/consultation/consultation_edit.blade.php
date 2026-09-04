<x-app-layout title="Edit Consultation">

<div class="top-bar">
    <a class="top-button back" href="{{ route('admin.consultation.details', $consultations->id) }}">&larr; Back</a>
    <h2 class="navigation-title">Edit Consultation Link</h2>
</div>
<div class="nav-line-separator"></div>

<div class="pane">
    <div class="right-side" style="max-width:580px;">
        <form action="{{ route('admin.consultation.details', $consultations->id) }}" method="POST" class="form-example">
            @csrf @method('PUT')
            <div class="data-info-pane">

                <div class="information">
                    <label class="type">NAME <span style="color:#ef4444;">*</span></label>
                    <input type="text" name="name" class="content"
                           value="{{ old('name', $consultations->name) }}" required>
                    @error('name')<span class="text-danger">{{ $message }}</span>@enderror
                </div>

                <div class="information">
                    <label class="type">DESCRIPTION
                        <span style="color:var(--muted);font-weight:400;font-size:.7rem;text-transform:none;margin-left:4px;">(optional)</span>
                    </label>
                    <textarea name="description" class="content" rows="4"
                              style="width:100%;padding:10px;">{{ old('description', $consultations->description) }}</textarea>
                </div>

                <div class="information">
                    <label class="type">REQUEST LINK <span style="color:#ef4444;">*</span></label>
                    <input type="url" name="request_link" class="content"
                           value="{{ old('request_link', $consultations->request_link) }}"
                           placeholder="https://…"
                           required>
                    @error('request_link')<span class="text-danger">{{ $message }}</span>@enderror
                </div>

            </div>
            <input class="add-button" type="submit" value="Save Changes">
        </form>
    </div>
</div>

</x-app-layout>
