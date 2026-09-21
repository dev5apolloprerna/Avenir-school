@extends('layouts.admin')
@section('title', isset($gallery) ? 'Edit album' : 'Add album')

@section('content')
<div class="card" style="max-width:640px">
    <div class="card-body p-4">
        <h5 class="mb-4">{{ isset($gallery) ? 'Edit album' : 'Add album' }}</h5>

        <form method="POST" enctype="multipart/form-data"
              action="{{ isset($gallery) ? route('admin.photo-galleries.update', $gallery) : route('admin.photo-galleries.store') }}">
            @csrf
            @isset($gallery) @method('PUT') @endisset

            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $gallery->title ?? '') }}" maxlength="150" required>
            </div>

            <div class="mb-3">
                <label for="cover_image" class="form-label">Cover image</label>
                <input type="file" name="cover_image" id="cover_image" class="form-control" accept="image/*" {{ isset($gallery) ? '' : 'required' }}>
                <div class="form-text">One image shown for this album. JPG, PNG or WebP, up to 4 MB.</div>
                @isset($gallery)
                    <img src="{{ $gallery->cover_url }}" class="img-preview mt-2" alt="Current cover">
                    <div class="form-text">Current cover. Choose a new file only if you want to replace it.</div>
                @endisset
            </div>

            @include('admin.partials.status-switch', ['status' => $gallery->status ?? true])

            @if (! isset($gallery))
                <div class="alert alert-info py-2 small">After saving, use <strong>Add images</strong> on the album list to upload many photos at once.</div>
            @endif

            <div class="d-flex gap-2 mt-4">
                <button class="btn btn-primary">{{ isset($gallery) ? 'Save changes' : 'Create album' }}</button>
                <a href="{{ route('admin.photo-galleries.index') }}" class="btn btn-light border">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
