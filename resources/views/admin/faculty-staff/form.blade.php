@extends('layouts.admin')
@section('title', isset($item) ? 'Edit faculty/staff profile' : 'Add faculty/staff profile')

@section('content')
<div class="card" style="max-width:900px">
    <div class="card-body p-4">
        <h5 class="mb-4">{{ isset($item) ? 'Edit faculty/staff profile' : 'Add faculty/staff profile' }}</h5>
        <form method="POST" enctype="multipart/form-data" action="{{ isset($item) ? route('admin.faculty-staff.update', $item) : route('admin.faculty-staff.store') }}">
            @csrf
            @isset($item) @method('PUT') @endisset
            <div class="row g-3 mb-3">
                <div class="col-md-6"><label for="name" class="form-label">Name</label><input id="name" name="name" class="form-control" required maxlength="150" value="{{ old('name', $item->name ?? '') }}"></div>
                <div class="col-md-6"><label for="designation" class="form-label">Designation</label><input id="designation" name="designation" class="form-control" required maxlength="150" value="{{ old('designation', $item->designation ?? '') }}"></div>
            </div>
            <div class="row g-3 mb-3">
                <div class="col-md-8"><label for="qualification" class="form-label">Qualification</label><input id="qualification" name="qualification" class="form-control" maxlength="255" value="{{ old('qualification', $item->qualification ?? '') }}"></div>
                <div class="col-md-4"><label for="sort_order" class="form-label">Display order</label><input id="sort_order" name="sort_order" type="number" min="0" max="9999" class="form-control" required value="{{ old('sort_order', $item->sort_order ?? 0) }}"></div>
            </div>
            <div class="row g-3 mb-3">
                <div class="col-md-6"><label for="email" class="form-label">Email</label><input id="email" name="email" type="email" class="form-control" value="{{ old('email', $item->email ?? '') }}"></div>
                <div class="col-md-6"><label for="phone" class="form-label">Phone</label><input id="phone" name="phone" class="form-control" maxlength="30" value="{{ old('phone', $item->phone ?? '') }}"></div>
            </div>
            <div class="mb-3"><label for="short_description" class="form-label">Short description</label><textarea id="short_description" name="short_description" rows="3" maxlength="1000" class="form-control">{{ old('short_description', $item->short_description ?? '') }}</textarea></div>
            <div class="mb-3"><label for="detailed_description" class="form-label">Detailed description</label><textarea id="detailed_description" name="detailed_description" rows="9" class="form-control rich-editor">{{ old('detailed_description', $item->detailed_description ?? '') }}</textarea></div>
            <div class="mb-3"><label for="image" class="form-label">Profile image{{ isset($item) ? '' : ' *' }}</label><input id="image" name="image" type="file" accept="image/jpeg,image/png,image/webp" class="form-control" {{ isset($item) ? '' : 'required' }}>
                <div class="form-text">JPG, PNG or WebP, up to 4 MB.</div>@if(isset($item) && $item->image)<img src="{{ $item->image_url }}" class="img-preview mt-2" alt="Current image">@endif
            </div>
            @include('admin.partials.status-switch', ['status' => $item->status ?? true])
            <div class="d-flex gap-2 mt-4"><button class="btn btn-primary">{{ isset($item) ? 'Save changes' : 'Add profile' }}</button><a href="{{ route('admin.faculty-staff.index') }}" class="btn btn-light border">Cancel</a></div>
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