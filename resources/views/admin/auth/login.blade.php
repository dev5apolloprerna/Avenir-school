<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin login | School Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Public Sans', system-ui, sans-serif; min-height: 100vh; background: #17382f; display:flex; align-items:center; justify-content:center; padding:1rem; }
        .login-card { width:100%; max-width:410px; border:0; border-radius:.9rem; box-shadow: 0 20px 50px rgba(0,0,0,.28); }
        .login-mark { width:54px; height:54px; border-radius:50%; background:#f2b632; color:#17382f; display:inline-flex; align-items:center; justify-content:center; font-size:1.6rem; }
        .btn-login { background:#1f6b57; border-color:#1f6b57; color:#fff; font-weight:600; }
        .btn-login:hover { background:#17594a; border-color:#17594a; color:#fff; }
        .form-control:focus { border-color:#1f6b57; box-shadow:0 0 0 .2rem rgba(31,107,87,.18); }
    </style>
</head>
<body>
<div class="card login-card">
    <div class="card-body p-4 p-md-5">
        <div class="text-center mb-4">
            <span class="login-mark"><i class="bi bi-mortarboard-fill"></i></span>
            <h1 class="h4 fw-bold mt-3 mb-1">Admin login</h1>
            <p class="text-secondary mb-0">Sign in to manage the school website.</p>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger py-2">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('admin.login.submit') }}">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required autofocus autocomplete="username">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" required autocomplete="current-password">
            </div>
            <div class="form-check mb-4">
                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                <label class="form-check-label" for="remember">Keep me signed in</label>
            </div>
            <button class="btn btn-login w-100 py-2">Sign in</button>
        </form>
    </div>
</div>
</body>
</html>
