
<x-app-layout title="Create Account">
<div class="top-bar">
    <a class="top-button back" href="{{ route('admin.accounts.index') }}">&larr; BACK</a>
    <h2 class="navigation-title">Add Admin Account</h2>
</div>
<div class="nav-line-separator"></div>

<div class="pane">
    <div class="right-side" style="max-width:520px;">
        <form action="{{ route('admin.accounts.store') }}" method="POST" class="form-example">
            @csrf
            <div class="data-info-pane">
                <div class="information">
                    <label class="type">NAME</label>
                    <input type="text" name="name" class="content" value="{{ old('name') }}" required>
                    @error('name')<small class="text-danger">{{ $message }}</small>@enderror
                </div>
                <div class="information">
                    <label class="type">EMAIL</label>
                    <input type="email" name="email" class="content" value="{{ old('email') }}" required>
                    @error('email')<small class="text-danger">{{ $message }}</small>@enderror
                </div>
                <div class="information">
                    <label class="type">PASSWORD</label>
                    <input type="password" name="password" class="content" required>
                    @error('password')<small class="text-danger">{{ $message }}</small>@enderror
                </div>
                <div class="information">
                    <label class="type">CONFIRM PASSWORD</label>
                    <input type="password" name="password_confirmation" class="content" required>
                </div>
            </div>
            <input class="add-button" type="submit" value="CREATE ACCOUNT">
        </form>
    </div>
</div>
</x-app-layout>
