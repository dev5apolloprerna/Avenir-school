@extends('layouts.admin')
@section('title', 'Profile & password')

@section('content')
<div class="row g-4">
    {{-- Profile --}}
    <div class="col-lg-7">
        <div class="card">
            <div class="card-body p-4">
                <h5 class="mb-4">Profile</h5>
                <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="d-flex align-items-center gap-3 mb-4">
                        @if ($user->photo_url)
                            <img src="{{ $user->photo_url }}" class="thumb-round" style="width:72px;height:72px" alt="">
                        @else
                            <span class="avatar" style="width:72px;height:72px;font-size:1.6rem">{{ strtoupper(mb_substr($user->name, 0, 1)) }}</span>
                        @endif
                        <div class="flex-grow-1">
                            <label for="photo" class="form-label mb-1">Profile photo</label>
                            <input type="file" name="photo" id="photo" class="form-control" accept="image/*">
                            <div class="form-text">JPG, PNG or WebP, up to 2 MB.</div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                    </div>
                    <div class="mb-4">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
                    </div>
                    <button class="btn btn-primary">Save profile</button>
                </form>
            </div>
        </div>
    </div>

    {{-- Change password --}}
    <div class="col-lg-5">
        <div class="card">
            <div class="card-body p-4">
                <h5 class="mb-4">Change password</h5>
                <form method="POST" action="{{ route('admin.profile.password') }}">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Current password</label>
                        <input type="password" name="current_password" id="current_password" class="form-control" required autocomplete="current-password">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">New password</label>
                        <input type="password" name="password" id="password" class="form-control" required minlength="8" autocomplete="new-password">
                        <div class="form-text">At least 8 characters.</div>
                    </div>
                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label">Confirm new password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required autocomplete="new-password">
                    </div>
                    <button class="btn btn-primary">Change password</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
