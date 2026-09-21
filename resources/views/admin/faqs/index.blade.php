@extends('layouts.admin')
@section('title', 'FAQs')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">FAQs</h4>
    <a href="{{ route('admin.faqs.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i> Add FAQ</a>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead><tr><th>#</th><th>Question</th><th>Answer</th><th>Order</th><th>Status</th><th class="text-end">Actions</th></tr></thead>
            <tbody>
            @forelse ($faqs as $faq)
                <tr>
                    <td>{{ $faqs->firstItem() + $loop->index }}</td>
                    <td class="fw-medium" style="min-width:220px">{{ $faq->question }}</td>
                    <td class="text-secondary">{{ \Illuminate\Support\Str::limit($faq->answer, 90) }}</td>
                    <td>{{ $faq->sort_order }}</td>
                    <td>@include('admin.partials.status-badge', ['status' => $faq->status])</td>
                    <td class="text-end text-nowrap">
                        <a href="{{ route('admin.faqs.edit', $faq) }}" class="btn btn-sm btn-outline-primary" title="Edit"><i class="bi bi-pencil"></i></a>
                        @include('admin.partials.delete-form', ['action' => route('admin.faqs.destroy', $faq)])
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center text-secondary py-5">No FAQs yet. Add the questions parents ask most often.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $faqs->links() }}</div>
@endsection
