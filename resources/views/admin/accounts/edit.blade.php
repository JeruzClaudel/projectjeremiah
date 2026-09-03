
<x-app-layout title="Edit Account">
<div class="top-bar">
    <a class="top-button back" href="{{ route('admin.accounts.index') }}">&larr; BACK</a>
    <h2 class="navigation-title">Edit Account</h2>
</div>
<div class="nav-line-separator"></div>

<div class="pane">
    <div class="right-side" style="max-width:520px;">
        <form action="{{ route('admin.accounts.update',$account) }}" method="POST" class="form-example">
            @csrf @method('PUT')
            <div class="data-info-pane">
                <div class="information">
                    <label class="type">NAME</label>
                    <input type="text" name="name" class="content"
                           value="{{ old('name',$account->name) }}" required>
                    @error('name')<small class="text-danger">{{ $message }}</small>@enderror
                </div>
                <div class="information">
                    <label class="type">EMAIL</label>
                    <input type="email" name="email" class="content"
                           value="{{ old('email',$account->email) }}" required>
                    @error('email')<small class="text-danger">{{ $message }}</small>@enderror
                </div>
                <div class="information">
                    <label class="type">NEW PASSWORD <small style="font-weight:400;color:#9ca3af;">(leave blank to keep current)</small></label>
                    <input type="password" name="password" class="content">
                    @error('password')<small class="text-danger">{{ $message }}</small>@enderror
                </div>
                <div class="information">
                    <label class="type">CONFIRM NEW PASSWORD</label>
                    <input type="password" name="password_confirmation" class="content">
                </div>
            </div>
            <input class="add-button" type="submit" value="SAVE CHANGES">
        </form>
    </div>
</div>
</x-app-layout>
