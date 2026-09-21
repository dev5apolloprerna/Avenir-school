@extends('layouts.admin')
@section('title', 'News & events')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <h4 class="mb-0">News &amp; events</h4>
    <a href="{{ route('admin.news-events.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i> Add news or event</a>
</div>

<ul class="nav nav-pills mb-3">
    <li class="nav-item"><a class="nav-link {{ ! $type ? 'active' : '' }}" href="{{ route('admin.news-events.index') }}">All</a></li>
    <li class="nav-item"><a class="nav-link {{ $type === 'news' ? 'active' : '' }}" href="{{ route('admin.news-events.index', ['type' => 'news']) }}">News</a></li>
    <li class="nav-item"><a class="nav-link {{ $type === 'event' ? 'active' : '' }}" href="{{ route('admin.news-events.index', ['type' => 'event']) }}">Events</a></li>
</ul>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead><tr><th>#</th><th>Image</th><th>Title</th><th>Type</th><th>Event date</th><th>Status</th><th class="text-end">Actions</th></tr></thead>
            <tbody>
            @forelse ($items as $item)
                <tr>
                    <td>{{ $items->firstItem() + $loop->index }}</td>
                    <td>
                        @if ($item->image_url)
                            <img src="{{ $item->image_url }}" class="thumb" alt="">
                        @else
                            <span class="text-secondary">—</span>
                        @endif
                    </td>
                    <td style="min-width:220px">
                        <div class="fw-medium">{{ $item->title }}</div>
                        @if ($item->location)<div class="text-secondary small"><i class="bi bi-geo-alt"></i> {{ $item->location }}</div>@endif
                    </td>
                    <td><span class="badge {{ $item->type === 'event' ? 'text-bg-warning' : 'text-bg-info' }}">{{ ucfirst($item->type) }}</span></td>
                    <td>{{ $item->event_date ? $item->event_date->format('d M Y') : '—' }}</td>
                    <td>@include('admin.partials.status-badge', ['status' => $item->status])</td>
                    <td class="text-end text-nowrap">
                        <a href="{{ route('admin.news-events.edit', $item) }}" class="btn btn-sm btn-outline-primary" title="Edit"><i class="bi bi-pencil"></i></a>
                        @include('admin.partials.delete-form', ['action' => route('admin.news-events.destroy', $item)])
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center text-secondary py-5">Nothing here yet. Add school news or an upcoming event.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $items->links() }}</div>
@endsection
