@extends('layouts.admin')
@section('title', isset($video) ? 'Edit video' : 'Add video')

@section('content')
<div class="card" style="max-width:640px">
    <div class="card-body p-4">
        <h5 class="mb-4">{{ isset($video) ? 'Edit video' : 'Add video' }}</h5>

        <form method="POST" action="{{ isset($video) ? route('admin.video-galleries.update', $video) : route('admin.video-galleries.store') }}">
            @csrf
            @isset($video) @method('PUT') @endisset

            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $video->title ?? '') }}" maxlength="150" required>
            </div>

            <div class="mb-3">
                <label for="video_url" class="form-label">Video URL</label>
                <input type="url" name="video_url" id="video_url" class="form-control" placeholder="https://www.youtube.com/watch?v=..."
                       value="{{ old('video_url', $video->video_url ?? '') }}" required>
                <div class="form-text">YouTube, Vimeo or a direct video link.</div>
            </div>

            @include('admin.partials.status-switch', ['status' => $video->status ?? true])

            <div class="d-flex gap-2 mt-4">
                <button class="btn btn-primary">{{ isset($video) ? 'Save changes' : 'Add video' }}</button>
                <a href="{{ route('admin.video-galleries.index') }}" class="btn btn-light border">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
