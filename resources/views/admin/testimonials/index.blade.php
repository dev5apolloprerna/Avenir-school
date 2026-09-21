@extends('layouts.admin')
@section('title', 'Testimonials')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Testimonials</h4>
    <a href="{{ route('admin.testimonials.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i> Add testimonial</a>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead><tr><th>#</th><th>Photo</th><th>Name</th><th>Message</th><th>Status</th><th class="text-end">Actions</th></tr></thead>
            <tbody>
            @forelse ($testimonials as $t)
                <tr>
                    <td>{{ $testimonials->firstItem() + $loop->index }}</td>
                    <td>
                        @if ($t->photo_url)
                            <img src="{{ $t->photo_url }}" class="thumb-round" alt="">
                        @else
                            <span class="avatar">{{ strtoupper(mb_substr($t->name, 0, 1)) }}</span>
                        @endif
                    </td>
                    <td>
                        <div class="fw-medium">{{ $t->name }}</div>
                        <div class="text-secondary small">{{ $t->designation }}</div>
                    </td>
                    <td class="text-secondary">{{ \Illuminate\Support\Str::limit($t->message, 90) }}</td>
                    <td>@include('admin.partials.status-badge', ['status' => $t->status])</td>
                    <td class="text-end text-nowrap">
                        <a href="{{ route('admin.testimonials.edit', $t) }}" class="btn btn-sm btn-outline-primary" title="Edit"><i class="bi bi-pencil"></i></a>
                        @include('admin.partials.delete-form', ['action' => route('admin.testimonials.destroy', $t)])
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center text-secondary py-5">No testimonials yet. Add what parents and students say about the school.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $testimonials->links() }}</div>
@endsection
