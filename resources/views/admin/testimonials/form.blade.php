@extends('layouts.admin')
@section('title', isset($testimonial) ? 'Edit testimonial' : 'Add testimonial')

@section('content')
<div class="card" style="max-width:760px">
    <div class="card-body p-4">
        <h5 class="mb-4">{{ isset($testimonial) ? 'Edit testimonial' : 'Add testimonial' }}</h5>

        <form method="POST" enctype="multipart/form-data"
              action="{{ isset($testimonial) ? route('admin.testimonials.update', $testimonial) : route('admin.testimonials.store') }}">
            @csrf
            @isset($testimonial) @method('PUT') @endisset

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $testimonial->name ?? '') }}" maxlength="100" required>
                </div>
                <div class="col-md-6">
                    <label for="designation" class="form-label">Designation <span class="text-secondary">(optional)</span></label>
                    <input type="text" name="designation" id="designation" class="form-control" placeholder="Parent of Class 5" value="{{ old('designation', $testimonial->designation ?? '') }}" maxlength="100">
                </div>
            </div>

            <div class="mb-3">
                <label for="message" class="form-label">Message</label>
                <textarea name="message" id="message" rows="5" class="form-control" required>{{ old('message', $testimonial->message ?? '') }}</textarea>
            </div>

            <div class="mb-3">
                <label for="photo" class="form-label">Photo <span class="text-secondary">(optional)</span></label>
                <input type="file" name="photo" id="photo" class="form-control" accept="image/*">
                <div class="form-text">JPG, PNG or WebP, up to 2 MB.</div>
                @if (isset($testimonial) && $testimonial->photo)
                    <img src="{{ $testimonial->photo_url }}" class="img-preview mt-2" alt="Current photo">
                @endif
            </div>

            @include('admin.partials.status-switch', ['status' => $testimonial->status ?? true])

            <div class="d-flex gap-2 mt-4">
                <button class="btn btn-primary">{{ isset($testimonial) ? 'Save changes' : 'Add testimonial' }}</button>
                <a href="{{ route('admin.testimonials.index') }}" class="btn btn-light border">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
