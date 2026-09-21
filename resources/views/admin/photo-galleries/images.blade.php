@extends('layouts.admin')
@section('title', $photoGallery->title . ' – images')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <h4 class="mb-0">{{ $photoGallery->title }} <span class="text-secondary fs-6 fw-normal">– manage images</span></h4>
    <a href="{{ route('admin.photo-galleries.index') }}" class="btn btn-light border"><i class="bi bi-arrow-left me-1"></i> Back to albums</a>
</div>

{{-- Multiple upload --}}
<div class="card mb-4">
    <div class="card-body p-4">
        <h6 class="mb-3">Upload multiple images</h6>
        <form method="POST" action="{{ route('admin.photo-galleries.images.store', $photoGallery) }}" enctype="multipart/form-data">
            @csrf
            <input type="file" name="images[]" id="images" class="form-control" accept="image/*" multiple required>
            <div class="form-text mb-3">Select up to 20 images at once (hold Ctrl or Shift, or select all). JPG, PNG or WebP, 4 MB each.</div>

            <div id="preview" class="d-flex flex-wrap gap-2 mb-3"></div>

            <button class="btn btn-primary"><i class="bi bi-cloud-upload me-1"></i> Upload images</button>
        </form>
    </div>
</div>

{{-- Existing images --}}
<h6 class="mb-3">Photos in this album ({{ $images->total() }})</h6>
<div class="row g-3">
    @forelse ($images as $image)
        <div class="col-6 col-md-4 col-lg-3 col-xl-2">
            <div class="card h-100">
                <a href="{{ $image->image_url }}" target="_blank" rel="noopener">
                    <img src="{{ $image->image_url }}" class="card-img-top" style="height:130px;object-fit:cover" alt="">
                </a>
                <div class="card-body p-2 text-end">
                    @include('admin.partials.delete-form', [
                        'action'  => route('admin.gallery-images.destroy', $image),
                        'message' => 'Delete this photo?',
                    ])
                </div>
            </div>
        </div>
    @empty
        <div class="col-12"><div class="alert alert-light border mb-0">No photos in this album yet. Use the form above to upload some.</div></div>
    @endforelse
</div>
<div class="mt-3">{{ $images->links() }}</div>
@endsection

@push('scripts')
<script>
    // small preview of the files chosen for upload
    document.getElementById('images').addEventListener('change', function (e) {
        const box = document.getElementById('preview');
        box.innerHTML = '';
        Array.from(e.target.files).forEach(function (file) {
            const img = document.createElement('img');
            img.src = URL.createObjectURL(file);
            img.className = 'thumb';
            box.appendChild(img);
        });
    });
</script>
@endpush
