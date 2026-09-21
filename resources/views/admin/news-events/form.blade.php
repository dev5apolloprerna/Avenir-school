@extends('layouts.admin')
@section('title', isset($item) ? 'Edit news / event' : 'Add news / event')

@section('content')
@php $type = old('type', $item->type ?? request('type', 'news')); @endphp

<div class="card" style="max-width:820px">
    <div class="card-body p-4">
        <h5 class="mb-4">{{ isset($item) ? 'Edit news / event' : 'Add news / event' }}</h5>

        <form method="POST" enctype="multipart/form-data"
              action="{{ isset($item) ? route('admin.news-events.update', $item) : route('admin.news-events.store') }}">
            @csrf
            @isset($item) @method('PUT') @endisset

            <div class="row g-3 mb-3">
                <div class="col-md-4">
                    <label for="type" class="form-label">Type</label>
                    <select name="type" id="type" class="form-select">
                        <option value="news"  {{ $type === 'news'  ? 'selected' : '' }}>News</option>
                        <option value="event" {{ $type === 'event' ? 'selected' : '' }}>Event</option>
                    </select>
                </div>
                <div class="col-md-8">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $item->title ?? '') }}" maxlength="200" required>
                </div>
            </div>

            <div class="row g-3 mb-3" id="eventFields">
                <div class="col-md-4">
                    <label for="event_date" class="form-label">Event date</label>
                    <input type="date" name="event_date" id="event_date" class="form-control"
                           value="{{ old('event_date', isset($item) && $item->event_date ? $item->event_date->format('Y-m-d') : '') }}">
                </div>
                <div class="col-md-8">
                    <label for="location" class="form-label">Location <span class="text-secondary">(optional)</span></label>
                    <input type="text" name="location" id="location" class="form-control" value="{{ old('location', $item->location ?? '') }}" maxlength="200">
                </div>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" rows="8" class="form-control" required>{{ old('description', $item->description ?? '') }}</textarea>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Image <span class="text-secondary">(optional)</span></label>
                <input type="file" name="image" id="image" class="form-control" accept="image/*">
                <div class="form-text">JPG, PNG or WebP, up to 4 MB.</div>
                @if (isset($item) && $item->image)
                    <img src="{{ $item->image_url }}" class="img-preview mt-2" alt="Current image">
                    <div class="form-text">Current image. Choose a new file only if you want to replace it.</div>
                @endif
            </div>

            @include('admin.partials.status-switch', ['status' => $item->status ?? true])

            <div class="d-flex gap-2 mt-4">
                <button class="btn btn-primary">{{ isset($item) ? 'Save changes' : 'Publish' }}</button>
                <a href="{{ route('admin.news-events.index') }}" class="btn btn-light border">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // date and location are only needed for events
    function toggleEventFields() {
        document.getElementById('eventFields').style.display =
            document.getElementById('type').value === 'event' ? '' : 'none';
    }
    document.getElementById('type').addEventListener('change', toggleEventFields);
    toggleEventFields();
</script>
@endpush
