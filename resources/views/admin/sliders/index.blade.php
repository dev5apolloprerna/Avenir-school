@extends('layouts.admin')
@section('title', 'Sliders')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Sliders</h4>
    <a href="{{ route('admin.sliders.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i> Add slider</a>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
            <tr>
                <th>#</th><th>Preview</th><th>Title</th><th>Type</th><th>Order</th><th>Status</th><th class="text-end">Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($sliders as $slider)
                <tr>
                    <td>{{ $sliders->firstItem() + $loop->index }}</td>
                    <td>
                        @if ($slider->type === 'image')
                            <img src="{{ $slider->image_url }}" class="thumb" alt="">
                        @elseif ($slider->thumbnail_url)
                            <img src="{{ $slider->thumbnail_url }}" class="thumb" alt="">
                        @else
                            <a href="{{ $slider->video_url }}" target="_blank" rel="noopener" class="small">Open video</a>
                        @endif
                    </td>
                    <td>{{ $slider->title ?: '—' }}</td>
                    <td><span class="badge {{ $slider->type === 'video' ? 'text-bg-warning' : 'text-bg-light border' }}">{{ ucfirst($slider->type) }}</span></td>
                    <td>{{ $slider->sort_order }}</td>
                    <td>@include('admin.partials.status-badge', ['status' => $slider->status])</td>
                    <td class="text-end text-nowrap">
                        <a href="{{ route('admin.sliders.edit', $slider) }}" class="btn btn-sm btn-outline-primary" title="Edit"><i class="bi bi-pencil"></i></a>
                        @include('admin.partials.delete-form', ['action' => route('admin.sliders.destroy', $slider)])
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center text-secondary py-5">No sliders yet. Add one to show on the home page.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $sliders->links() }}</div>
@endsection
