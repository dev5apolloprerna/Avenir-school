@extends('layouts.admin')
@section('title', isset($faq) ? 'Edit FAQ' : 'Add FAQ')

@section('content')
<div class="card" style="max-width:760px">
    <div class="card-body p-4">
        <h5 class="mb-4">{{ isset($faq) ? 'Edit FAQ' : 'Add FAQ' }}</h5>

        <form method="POST" action="{{ isset($faq) ? route('admin.faqs.update', $faq) : route('admin.faqs.store') }}">
            @csrf
            @isset($faq) @method('PUT') @endisset

            <div class="mb-3">
                <label for="question" class="form-label">Question</label>
                <input type="text" name="question" id="question" class="form-control" value="{{ old('question', $faq->question ?? '') }}" maxlength="255" required>
            </div>

            <div class="mb-3">
                <label for="answer" class="form-label">Answer</label>
                <textarea name="answer" id="answer" rows="6" class="form-control" required>{{ old('answer', $faq->answer ?? '') }}</textarea>
            </div>

            <div class="mb-3" style="max-width:200px">
                <label for="sort_order" class="form-label">Display order</label>
                <input type="number" min="0" name="sort_order" id="sort_order" class="form-control" value="{{ old('sort_order', $faq->sort_order ?? 0) }}">
                <div class="form-text">Smaller numbers show first.</div>
            </div>

            @include('admin.partials.status-switch', ['status' => $faq->status ?? true])

            <div class="d-flex gap-2 mt-4">
                <button class="btn btn-primary">{{ isset($faq) ? 'Save changes' : 'Add FAQ' }}</button>
                <a href="{{ route('admin.faqs.index') }}" class="btn btn-light border">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
