@extends('layouts.admin')
@section('title', 'Education details')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Education details</h4>
    <a href="{{ route('admin.education-details.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i> Add education detail</a>
</div>
<div class="card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Subtitle</th>
                    <th>Order</th>
                    <th>Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($items as $item)
                <tr>
                    <td>{{ $items->firstItem() + $loop->index }}</td>
                    <td><img src="{{ $item->image_url }}" class="thumb" alt=""></td>
                    <td class="fw-medium">{{ $item->title }}</td>
                    <td>{{ $item->subtitle ?: '—' }}</td>
                    <td>{{ $item->sort_order }}</td>
                    <td>@include('admin.partials.status-badge', ['status' => $item->status])</td>
                    <td class="text-end text-nowrap">
                        <a href="{{ route('admin.education-details.edit', $item) }}" class="btn btn-sm btn-outline-primary" title="Edit"><i class="bi bi-pencil"></i></a>
                        @include('admin.partials.delete-form', ['action' => route('admin.education-details.destroy', $item)])
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-secondary py-5">No education details yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $items->links() }}</div>
@endsection