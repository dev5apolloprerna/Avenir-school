{{-- old() is empty on first load, so use the saved value; after a failed validation use what the user had --}}
<div class="form-check form-switch mb-3">
    <input class="form-check-input" type="checkbox" role="switch" name="status" id="status" value="1"
           {{ (old() ? old('status') : ($status ?? true)) ? 'checked' : '' }}>
    <label class="form-check-label" for="status">Show on website</label>
</div>
