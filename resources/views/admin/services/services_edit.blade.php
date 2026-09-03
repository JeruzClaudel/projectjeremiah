<x-app-layout title="Edit Service">

<div class="top-bar">
    <a class="top-button back" href="{{ route('admin.services.dashboard') }}">&larr; Back</a>
    <h2 class="navigation-title">Edit Service</h2>
</div>
<div class="nav-line-separator"></div>

<div class="pane">
    <div class="right-side" style="max-width:620px;">
        <form action="{{ route('admin.services.update', $services->id) }}" method="POST" class="form-example">
            @csrf
            @method('PUT')
            <div class="data-info-pane">

                {{-- Name --}}
                <div class="information">
                    <label class="type">SERVICE NAME <span style="color:#ef4444;">*</span></label>
                    <input type="text" name="name" class="content"
                           value="{{ old('name', $services->name) }}"
                           required>
                    @error('name')<span class="text-danger">{{ $message }}</span>@enderror
                </div>

                {{-- Description --}}
                <div class="information">
                    <label class="type">DESCRIPTION <span style="color:#ef4444;">*</span></label>
                    <textarea name="description" class="content" rows="8"
                              style="width:100%;padding:10px;min-height:180px;"
                              required>{{ old('description', $services->description) }}</textarea>
                    @error('description')<span class="text-danger">{{ $message }}</span>@enderror
                </div>

                {{-- Consultation link — optional free-text URL --}}
                @php
                    $hasLink  = old('has_link') || (!empty($services->consultations_id));
                    $linkVal  = old('consultations_id', $services->consultations_id ?? '');
                @endphp
                <div class="information">
                    <label class="type">CONSULTATION / REQUEST LINK
                        <span style="color:var(--muted);font-weight:400;font-size:.7rem;text-transform:none;margin-left:4px;">(optional)</span>
                    </label>

                    <div style="display:flex;align-items:center;gap:10px;margin-bottom:8px;">
                        <input type="checkbox" id="has_link" name="has_link" value="1"
                               {{ $hasLink ? 'checked' : '' }}
                               onchange="toggleLink(this)"
                               style="width:16px;height:16px;accent-color:var(--navy);cursor:pointer;">
                        <label for="has_link" style="font-size:.82rem;font-weight:600;color:var(--text);cursor:pointer;margin:0;">
                            Attach a consultation or request link to this service
                        </label>
                    </div>

                    <div id="link-wrap" style="{{ $hasLink ? '' : 'display:none;' }}">
                        <input type="url" name="consultations_id" id="consultations_id"
                               class="content"
                               value="{{ $linkVal }}"
                               placeholder="https://forms.gle/… or https://teams.microsoft.com/…"
                               style="width:100%;">
                        <div style="font-size:.74rem;color:var(--muted);margin-top:5px;line-height:1.5;">
                            Paste the full URL of a Google Form, MS Teams link, or any scheduling page.
                        </div>
                        @error('consultations_id')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                </div>

            </div>
            <input class="add-button" type="submit" value="Save Changes">
        </form>
    </div>
</div>

<script>
function toggleLink(cb) {
    const wrap  = document.getElementById('link-wrap');
    const input = document.getElementById('consultations_id');
    wrap.style.display = cb.checked ? 'block' : 'none';
    if (!cb.checked) input.value = '';
}
</script>

</x-app-layout>
