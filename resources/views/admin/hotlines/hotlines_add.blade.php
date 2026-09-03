<x-app-layout title="Add Hotline">

<div class="top-bar">
    <a class="top-button back" href="{{ route('admin.hotline.dashboard') }}">&larr; Back</a>
    <h2 class="navigation-title">Add Hotline</h2>
</div>
<div class="nav-line-separator"></div>

<div class="pane">
    <div class="right-side" style="max-width:560px;">
        <form action="{{ url('admin/hotlines/add') }}" method="POST" class="form-example">
            @csrf
            <div class="data-info-pane">

                <div class="information">
                    <label class="type">HOTLINE NAME <span style="color:#ef4444;">*</span></label>
                    <input type="text" name="name" class="content"
                           value="{{ old('name') }}"
                           placeholder="e.g. National Crisis Hotline" required>
                    @error('name')<span class="text-danger">{{ $message }}</span>@enderror
                </div>

                <div class="information">
                    <label class="type">PHONE NUMBER <span style="color:#ef4444;">*</span></label>
                    <input type="text" name="phone_number" class="content"
                           value="{{ old('phone_number') }}"
                           placeholder="e.g. 1553 or +63-2-8xxx-xxxx" required>
                    @error('phone_number')<span class="text-danger">{{ $message }}</span>@enderror
                </div>

                <div class="information">
                    <label class="type">EMAIL <span style="color:#ef4444;">*</span></label>
                    <input type="email" name="email" class="content"
                           value="{{ old('email') }}"
                           placeholder="support@example.org" required>
                    @error('email')<span class="text-danger">{{ $message }}</span>@enderror
                </div>

                <div class="information">
                    <label class="type">AVAILABILITY <span style="color:#ef4444;">*</span></label>
                    <input type="text" name="availability" class="content"
                           value="{{ old('availability') }}"
                           placeholder="e.g. 24/7 or Mon–Fri 8AM–5PM" required>
                    @error('availability')<span class="text-danger">{{ $message }}</span>@enderror
                </div>

                <div class="information">
                    <label class="type">WEBSITE LINK
                        <span style="color:var(--muted);font-weight:400;font-size:.7rem;text-transform:none;margin-left:4px;">(optional)</span>
                    </label>
                    <input type="url" name="site_link" class="content"
                           value="{{ old('site_link') }}"
                           placeholder="https://…">
                    @error('site_link')<span class="text-danger">{{ $message }}</span>@enderror
                </div>

            </div>
            <input class="add-button" type="submit" value="Add Hotline">
        </form>
    </div>
</div>

</x-app-layout>
