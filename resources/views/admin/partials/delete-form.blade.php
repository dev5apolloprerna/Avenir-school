<form method="POST" action="{{ $action }}" class="d-inline"
      onsubmit="return confirm({{ \Illuminate\Support\Js::from($message ?? 'Delete this item? This cannot be undone.') }})">
    @csrf
    @method('DELETE')
    <button class="btn btn-sm btn-outline-danger" title="Delete"><i class="bi bi-trash"></i></button>
</form>
