@extends('layouts.admin')
@section('title', isset($slider) ? 'Edit slider' : 'Add slider')

@section('content')
@php $type = old('type', $slider->type ?? 'image'); @endphp

<div class="card" style="max-width:760px">
    <div class="card-body p-4">
        <h5 class="mb-4">{{ isset($slider) ? 'Edit slider' : 'Add slider' }}</h5>

        <form method="POST" enctype="multipart/form-data"
              action="{{ isset($slider) ? route('admin.sliders.update', $slider) : route('admin.sliders.store') }}">
            @csrf
            @isset($slider) @method('PUT') @endisset

            <div class="mb-3">
                <label for="title" class="form-label">Title <span class="text-secondary">(optional)</span></label>
                <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $slider->title ?? '') }}" maxlength="150">
            </div>

            <div class="mb-3">
                <span class="form-label d-block">Slider type</span>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="type" id="typeImage" value="image" {{ $type === 'image' ? 'checked' : '' }}>
                    <label class="form-check-label" for="typeImage">Image</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="type" id="typeVideo" value="video" {{ $type === 'video' ? 'checked' : '' }}>
                    <label class="form-check-label" for="typeVideo">Video URL</label>
                </div>
            </div>

            <div class="mb-3" id="imageBox">
                <label for="image" class="form-label">Image</label>
                <input type="file" name="image" id="image" class="form-control" accept="image/*">
                <div class="form-text">JPG, PNG or WebP, up to 4 MB. Wide images (for example 1600 × 600) look best.</div>
                @if (isset($slider) && $slider->image)
                    <img src="{{ $slider->image_url }}" class="img-preview mt-2" alt="Current image">
                    <div class="form-text">Current image. Choose a new file only if you want to replace it.</div>
                @endif
            </div>

            <div class="mb-3" id="videoBox">
                <label for="video_url" class="form-label">Video URL</label>
                <input type="url" name="video_url" id="video_url" class="form-control" placeholder="https://www.youtube.com/watch?v=..."
                       value="{{ old('video_url', $slider->video_url ?? '') }}">
                <div class="form-text">YouTube, Vimeo or a direct video link.</div>
            </div>

            <div class="mb-3" style="max-width:200px">
                <label for="sort_order" class="form-label">Display order</label>
                <input type="number" min="0" name="sort_order" id="sort_order" class="form-control" value="{{ old('sort_order', $slider->sort_order ?? 0) }}">
                <div class="form-text">Smaller numbers show first.</div>
            </div>

            @include('admin.partials.status-switch', ['status' => $slider->status ?? true])

            <div class="d-flex gap-2 mt-4">
                <button class="btn btn-primary">{{ isset($slider) ? 'Save changes' : 'Add slider' }}</button>
                <a href="{{ route('admin.sliders.index') }}" class="btn btn-light border">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // show the image box or the video box depending on the selected type
    function toggleSliderType() {
        const isVideo = document.getElementById('typeVideo').checked;
        document.getElementById('imageBox').style.display = isVideo ? 'none' : '';
        document.getElementById('videoBox').style.display = isVideo ? '' : 'none';
    }
    document.querySelectorAll('input[name="type"]').forEach(r => r.addEventListener('change', toggleSliderType));
    toggleSliderType();
</script>
@endpush
