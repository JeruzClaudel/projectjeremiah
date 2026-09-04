<x-app-layout title="Add Consultation">

<div class="top-bar">
    <a class="top-button back" href="{{ route('admin.consultation.dashboard') }}">&larr; Back</a>
    <h2 class="navigation-title">Add Consultation Link</h2>
</div>
<div class="nav-line-separator"></div>

<div class="pane">
    <div class="right-side" style="max-width:580px;">
        <form action="{{ url('admin/consultation/add') }}" method="POST" class="form-example">
            @csrf
            <div class="data-info-pane">

                <div class="information">
                    <label class="type">NAME <span style="color:#ef4444;">*</span></label>
                    <input type="text" name="name" class="content"
                           value="{{ old('name') }}"
                           placeholder="e.g. Individual Counseling Booking"
                           required>
                    @error('name')<span class="text-danger">{{ $message }}</span>@enderror
                </div>

                <div class="information">
                    <label class="type">DESCRIPTION
                        <span style="color:var(--muted);font-weight:400;font-size:.7rem;text-transform:none;margin-left:4px;">(optional)</span>
                    </label>
                    <textarea name="description" class="content" rows="4"
                              style="width:100%;padding:10px;"
                              placeholder="Briefly describe what this consultation link is for…">{{ old('description') }}</textarea>
                </div>

                <div class="information">
                    <label class="type">REQUEST LINK <span style="color:#ef4444;">*</span></label>
                    <input type="url" name="request_link" class="content"
                           value="{{ old('request_link') }}"
                           placeholder="https://forms.gle/… or https://teams.microsoft.com/…"
                           required>
                    @error('request_link')<span class="text-danger">{{ $message }}</span>@enderror
                    <small style="font-size:.72rem;color:var(--muted);margin-top:4px;display:block;">
                        Paste the full URL for the booking form or scheduling link.
                    </small>
                </div>

            </div>
            <input class="add-button" type="submit" value="Add Consultation Link">
        </form>
    </div>
</div>

</x-app-layout>
