@extends('layouts.admin')
@section('title', 'Video gallery')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Video gallery</h4>
    <a href="{{ route('admin.video-galleries.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i> Add video</a>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead><tr><th>#</th><th>Preview</th><th>Title</th><th>Link</th><th>Status</th><th class="text-end">Actions</th></tr></thead>
            <tbody>
            @forelse ($videos as $video)
                <tr>
                    <td>{{ $videos->firstItem() + $loop->index }}</td>
                    <td>
                        @if ($video->thumbnail_url)
                            <img src="{{ $video->thumbnail_url }}" class="thumb" alt="">
                        @else
                            <span class="badge text-bg-secondary">Video</span>
                        @endif
                    </td>
                    <td class="fw-medium">{{ $video->title }}</td>
                    <td><a href="{{ $video->video_url }}" target="_blank" rel="noopener" class="small">Open video</a></td>
                    <td>@include('admin.partials.status-badge', ['status' => $video->status])</td>
                    <td class="text-end text-nowrap">
                        <a href="{{ route('admin.video-galleries.edit', $video) }}" class="btn btn-sm btn-outline-primary" title="Edit"><i class="bi bi-pencil"></i></a>
                        @include('admin.partials.delete-form', ['action' => route('admin.video-galleries.destroy', $video)])
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center text-secondary py-5">No videos yet. Add a YouTube link to get started.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $videos->links() }}</div>
@endsection
