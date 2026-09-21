@extends('layouts.admin')
@section('title', 'Photo gallery')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Photo gallery</h4>
    <a href="{{ route('admin.photo-galleries.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i> Add album</a>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
            <tr><th>#</th><th>Cover</th><th>Title</th><th>Photos</th><th>Status</th><th class="text-end">Actions</th></tr>
            </thead>
            <tbody>
            @forelse ($galleries as $gallery)
                <tr>
                    <td>{{ $galleries->firstItem() + $loop->index }}</td>
                    <td><img src="{{ $gallery->cover_url }}" class="thumb" alt=""></td>
                    <td class="fw-medium">{{ $gallery->title }}</td>
                    <td>{{ $gallery->images_count }}</td>
                    <td>@include('admin.partials.status-badge', ['status' => $gallery->status])</td>
                    <td class="text-end text-nowrap">
                        <a href="{{ route('admin.photo-galleries.images.index', $gallery) }}" class="btn btn-sm btn-success" title="Upload multiple images">
                            <i class="bi bi-cloud-upload me-1"></i> Add images
                        </a>
                        <a href="{{ route('admin.photo-galleries.edit', $gallery) }}" class="btn btn-sm btn-outline-primary" title="Edit"><i class="bi bi-pencil"></i></a>
                        @include('admin.partials.delete-form', [
                            'action'  => route('admin.photo-galleries.destroy', $gallery),
                            'message' => 'Delete this album and all ' . $gallery->images_count . ' photos inside it? This cannot be undone.',
                        ])
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center text-secondary py-5">No albums yet. Create an album, then use "Add images" to fill it.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $galleries->links() }}</div>
@endsection
