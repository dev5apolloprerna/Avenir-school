@extends('layouts.admin')
@section('title', 'Faculty & staff')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Faculty &amp; staff</h4>
    <a href="{{ route('admin.faculty-staff.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i> Add profile</a>
</div>
<div class="card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Photo</th>
                    <th>Name</th>
                    <th>Designation</th>
                    <th>Contact</th>
                    <th>Order</th>
                    <th>Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($items as $item)
                <tr>
                    <td>{{ $items->firstItem() + $loop->index }}</td>
                    <td><img src="{{ $item->image_url }}" class="thumb-round" alt=""></td>
                    <td class="fw-medium">{{ $item->name }}</td>
                    <td>{{ $item->designation }}</td>
                    <td>
                        <div>{{ $item->email ?: '—' }}</div>
                        <div class="small text-secondary">{{ $item->phone }}</div>
                    </td>
                    <td>{{ $item->sort_order }}</td>
                    <td>@include('admin.partials.status-badge', ['status' => $item->status])</td>
                    <td class="text-end text-nowrap"><a href="{{ route('admin.faculty-staff.edit', $item) }}" class="btn btn-sm btn-outline-primary" title="Edit"><i class="bi bi-pencil"></i></a> @include('admin.partials.delete-form', ['action' => route('admin.faculty-staff.destroy', $item)])</td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center text-secondary py-5">No faculty or staff profiles yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $items->links() }}</div>
@endsection