<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') | School Admin</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        :root {
            --board: #17382f;          /* chalkboard green - sidebar */
            --board-hover: #1f4a3e;
            --chalk: #f2b632;          /* chalk yellow - the one accent */
            --page: #f1f4f3;
            --ink: #1d2b27;
            --bs-body-font-family: 'Public Sans', system-ui, sans-serif;
            --bs-body-color: var(--ink);
            --bs-primary: #1f6b57;
            --bs-primary-rgb: 31, 107, 87;
            --bs-link-color: #1f6b57;
        }
        body { background: var(--page); font-family: var(--bs-body-font-family); }
        .btn-primary { --bs-btn-bg:#1f6b57; --bs-btn-border-color:#1f6b57; --bs-btn-hover-bg:#17594a; --bs-btn-hover-border-color:#17594a; --bs-btn-active-bg:#134a3d; --bs-btn-active-border-color:#134a3d; }
        .btn-outline-primary { --bs-btn-color:#1f6b57; --bs-btn-border-color:#1f6b57; --bs-btn-hover-bg:#1f6b57; --bs-btn-hover-border-color:#1f6b57; --bs-btn-active-bg:#17594a; }
        .form-control:focus, .form-select:focus { border-color:#1f6b57; box-shadow:0 0 0 .2rem rgba(31,107,87,.18); }
        .form-check-input:checked { background-color:#1f6b57; border-color:#1f6b57; }

        .sidebar { width: 250px; min-height: 100vh; background: var(--board); position: fixed; inset: 0 auto 0 0; z-index: 1040; padding: 1.25rem .85rem; overflow-y: auto; transition: transform .2s; }
        .sidebar .brand { color:#fff; font-weight:700; font-size:1.1rem; padding:.25rem .75rem 1.25rem; display:flex; align-items:center; gap:.6rem; }
        .sidebar .brand i { color: var(--chalk); font-size:1.4rem; }
        .sidebar a.nav-item-link { display:flex; align-items:center; gap:.7rem; color:#c9dcd5; text-decoration:none; padding:.6rem .75rem; border-radius:.5rem; margin-bottom:2px; font-weight:500; font-size:.94rem; }
        .sidebar a.nav-item-link:hover { background: var(--board-hover); color:#fff; }
        .sidebar a.nav-item-link.active { background: var(--board-hover); color:#fff; box-shadow: inset 3px 0 0 var(--chalk); }
        .sidebar a.nav-item-link i { font-size:1.05rem; width:1.2rem; text-align:center; }

        .content-wrapper { margin-left: 250px; min-height: 100vh; }
        .topbar { background:#fff; border-bottom:1px solid #dfe6e3; padding:.6rem 1.5rem; }
        .avatar { width:36px; height:36px; border-radius:50%; object-fit:cover; background:var(--board); color:#fff; display:inline-flex; align-items:center; justify-content:center; font-weight:600; }

        .card { border:1px solid #e1e8e5; border-radius:.75rem; }
        .table > :not(caption) > * > * { padding:.8rem 1rem; }
        .table thead th { font-weight:600; color:#4b5d57; background:#f7f9f8; border-bottom-width:1px; white-space:nowrap; }
        .thumb { width:84px; height:56px; object-fit:cover; border-radius:.4rem; border:1px solid #dfe6e3; }
        .thumb-round { width:44px; height:44px; object-fit:cover; border-radius:50%; }
        .img-preview { max-width:220px; max-height:150px; border-radius:.5rem; border:1px solid #dfe6e3; object-fit:cover; }
        .stat-number { font-size:2rem; font-weight:700; line-height:1; }

        @media (max-width: 991.98px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.show { transform: none; }
            .content-wrapper { margin-left: 0; }
        }
    </style>
</head>
<body>

@php
    $menu = [
        ['admin.dashboard',               'bi-grid-1x2',        'Dashboard',         ['admin.dashboard']],
        ['admin.sliders.index',           'bi-collection-play', 'Sliders',           ['admin.sliders.*']],
        ['admin.principal.edit',          'bi-person-badge',    "Principal's message", ['admin.principal.*']],
<<<<<<< HEAD
        ['admin.education-details.index', 'bi-book',            'Education details', ['admin.education-details.*']],
        ['admin.faculty-staff.index',     'bi-people',          'Faculty & staff', ['admin.faculty-staff.*']],
=======
>>>>>>> 9e527c6a216df15a236faedd9f2180225e5f0869
        ['admin.photo-galleries.index',   'bi-images',          'Photo gallery',     ['admin.photo-galleries.*', 'admin.gallery-images.*']],
        ['admin.video-galleries.index',   'bi-camera-video',    'Video gallery',     ['admin.video-galleries.*']],
        ['admin.news-events.index',       'bi-megaphone',       'News & events',     ['admin.news-events.*']],
        ['admin.faqs.index',              'bi-question-circle', 'FAQs',              ['admin.faqs.*']],
        ['admin.testimonials.index',      'bi-chat-quote',      'Testimonials',      ['admin.testimonials.*']],
        ['admin.profile.edit',            'bi-person-gear',     'Profile & password', ['admin.profile.*']],
    ];
    $me = auth()->user();
@endphp

<aside class="sidebar" id="sidebar">
    <div class="brand"><i class="bi bi-mortarboard-fill"></i> School admin</div>
    @foreach ($menu as [$route, $icon, $label, $patterns])
        <a href="{{ route($route) }}" class="nav-item-link {{ request()->routeIs(...$patterns) ? 'active' : '' }}">
            <i class="bi {{ $icon }}"></i> {{ $label }}
        </a>
    @endforeach
</aside>

<div class="content-wrapper">
    <nav class="topbar d-flex justify-content-between align-items-center">
        <button class="btn btn-light d-lg-none" type="button" id="toggleSidebar" aria-label="Open menu"><i class="bi bi-list fs-5"></i></button>
        <span class="d-none d-lg-block text-secondary">@yield('title', 'Dashboard')</span>

        <div class="dropdown">
            <a href="#" class="d-flex align-items-center gap-2 text-decoration-none text-dark dropdown-toggle" data-bs-toggle="dropdown">
                @if ($me->photo_url)
                    <img src="{{ $me->photo_url }}" class="avatar" alt="">
                @else
                    <span class="avatar">{{ strtoupper(mb_substr($me->name, 0, 1)) }}</span>
                @endif
                <span class="d-none d-sm-inline fw-medium">{{ $me->name }}</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                <li><a class="dropdown-item" href="{{ route('admin.profile.edit') }}"><i class="bi bi-person me-2"></i>Profile & password</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button class="dropdown-item text-danger"><i class="bi bi-box-arrow-right me-2"></i>Log out</button>
                    </form>
                </li>
            </ul>
        </div>
    </nav>

    <main class="p-3 p-md-4">
        @include('admin.partials.alerts')
        @yield('content')
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById('toggleSidebar')?.addEventListener('click', function () {
        document.getElementById('sidebar').classList.toggle('show');
    });
</script>
@stack('scripts')
</body>
</html>
