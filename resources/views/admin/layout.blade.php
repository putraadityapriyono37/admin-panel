<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Panel Admin')</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>

<body @isset($currentMicrosite) style="--accent: {{ $currentMicrosite->settings['color'] ?? '#7a5230' }}" @endisset>
    <a class="skip-link" href="#konten">Lompat ke konten</a>

    <div class="wrap">
        <div class="topbar">
            <span class="brand">Panel Admin</span>

            @if (auth('admin')->user()->isSuperAdmin())
                <nav aria-label="Navigasi super admin">
                    <a class="nav-link" href="{{ route('admin.super.dashboard') }}"
                        @if (request()->routeIs('admin.super.dashboard')) aria-current="page" @endif>Dashboard</a>
                    <a class="nav-link" href="{{ route('admin.microsites.index') }}"
                        @if (request()->routeIs('admin.microsites.*')) aria-current="page" @endif>Microsite</a>
                    <a class="nav-link" href="{{ route('admin.admins.index') }}"
                        @if (request()->routeIs('admin.admins.*')) aria-current="page" @endif>Akun Admin</a>
                </nav>
            @endif

            @isset($currentMicrosite)
                <span class="microsite-name">{{ $currentMicrosite->name }}</span>
            @endisset

            <form class="spacer" method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button class="btn btn-secondary btn-sm" type="submit">Keluar</button>
            </form>
        </div>

        @isset($currentMicrosite)
            <nav class="subnav" aria-label="Navigasi {{ $currentMicrosite->name }}">
                <a class="nav-link" href="{{ route('admin.dashboard', $currentMicrosite) }}"
                    @if (request()->routeIs('admin.dashboard')) aria-current="page" @endif>Ringkasan</a>
                <a class="nav-link" href="{{ route('admin.info.edit', $currentMicrosite) }}"
                    @if (request()->routeIs('admin.info.*')) aria-current="page" @endif>Info Restoran</a>
                <a class="nav-link" href="{{ route('admin.categories.index', $currentMicrosite) }}"
                    @if (request()->routeIs('admin.categories.*')) aria-current="page" @endif>Kategori</a>
                <a class="nav-link" href="{{ route('admin.menu-items.index', $currentMicrosite) }}"
                    @if (request()->routeIs('admin.menu-items.*')) aria-current="page" @endif>Menu</a>
                <a class="nav-link" href="{{ route('admin.galleries.index', $currentMicrosite) }}"
                    @if (request()->routeIs('admin.galleries.*')) aria-current="page" @endif>Galeri</a>
                <a class="nav-link" href="{{ route('admin.promos.index', $currentMicrosite) }}"
                    @if (request()->routeIs('admin.promos.*')) aria-current="page" @endif>Promo</a>
                <a class="nav-link" href="{{ route('admin.orders.index', $currentMicrosite) }}"
                    @if (request()->routeIs('admin.orders.*')) aria-current="page" @endif>Pesanan</a>
            </nav>
        @endisset

        @if (session('status'))
            <div class="alert alert-ok" role="status">{{ session('status') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-err" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <main id="konten">
            @yield('content')
        </main>
    </div>
</body>

</html>
