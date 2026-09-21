@extends('layouts.admin')
@section('title', "Principal's message")

@section('content')
<div class="card" style="max-width:820px">
    <div class="card-body p-4">
        <h5 class="mb-4">Principal's message</h5>

        <form method="POST" action="{{ route('admin.principal.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label for="name" class="form-label">Principal's name</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $principal->name ?? '') }}" required>
                </div>
                <div class="col-md-6">
                    <label for="designation" class="form-label">Designation <span class="text-secondary">(optional)</span></label>
                    <input type="text" name="designation" id="designation" class="form-control" placeholder="Principal" value="{{ old('designation', $principal->designation ?? '') }}">
                </div>
            </div>

            <div class="mb-3">
                <label for="message" class="form-label">Message</label>
                <textarea name="message" id="message" rows="9" class="form-control" required>{{ old('message', $principal->message ?? '') }}</textarea>
            </div>

            <div class="mb-4">
                <label for="photo" class="form-label">Photo</label>
                <input type="file" name="photo" id="photo" class="form-control" accept="image/*" {{ ($principal && $principal->photo) ? '' : 'required' }}>
                <div class="form-text">JPG, PNG or WebP, up to 2 MB.</div>
                @if ($principal && $principal->photo)
                    <img src="{{ $principal->photo_url }}" class="img-preview mt-2" alt="Current photo">
                    <div class="form-text">Current photo. Choose a new file only if you want to replace it.</div>
                @endif
            </div>

            <button class="btn btn-primary">Save message</button>
        </form>
    </div>
</div>
@endsection
