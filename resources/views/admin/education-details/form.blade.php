@extends('layouts.admin')
@section('title', isset($item) ? 'Edit education detail' : 'Add education detail')

@section('content')
<div class="card" style="max-width:900px">
    <div class="card-body p-4">
        <h5 class="mb-4">{{ isset($item) ? 'Edit education detail' : 'Add education detail' }}</h5>
        <form method="POST" enctype="multipart/form-data" action="{{ isset($item) ? route('admin.education-details.update', $item) : route('admin.education-details.store') }}">
            @csrf
            @isset($item) @method('PUT') @endisset
            <div class="row g-3 mb-3">
                <div class="col-md-7"><label for="title" class="form-label">Title</label><input id="title" name="title" class="form-control" maxlength="200" required value="{{ old('title', $item->title ?? '') }}"></div>
                <div class="col-md-5"><label for="sort_order" class="form-label">Display order</label><input id="sort_order" name="sort_order" type="number" min="0" max="9999" class="form-control" required value="{{ old('sort_order', $item->sort_order ?? 0) }}"></div>
            </div>
            <div class="mb-3"><label for="subtitle" class="form-label">Subtitle</label><input id="subtitle" name="subtitle" class="form-control" maxlength="255" value="{{ old('subtitle', $item->subtitle ?? '') }}"></div>
            <div class="mb-3"><label for="description" class="form-label">Description</label><textarea id="description" name="description" class="form-control rich-editor" rows="10" required>{{ old('description', $item->description ?? '') }}</textarea>
                <div class="form-text">Use the toolbar to format the website content.</div>
            </div>
            <div class="mb-3"><label for="image" class="form-label">Image{{ isset($item) ? '' : ' *' }}</label><input id="image" name="image" type="file" accept="image/jpeg,image/png,image/webp" class="form-control" {{ isset($item) ? '' : 'required' }}>
                <div class="form-text">JPG, PNG or WebP, up to 4 MB.</div>@if(isset($item) && $item->image)<img src="{{ $item->image_url }}" class="img-preview mt-2" alt="Current image">@endif
            </div>
            @include('admin.partials.status-switch', ['status' => $item->status ?? true])
            <div class="d-flex gap-2 mt-4"><button class="btn btn-primary">{{ isset($item) ? 'Save changes' : 'Add detail' }}</button><a href="{{ route('admin.education-details.index') }}" class="btn btn-light border">Cancel</a></div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
<script>
    ClassicEditor.create(document.querySelector('.rich-editor')).catch(error => console.error(error));
</script>
@endpush