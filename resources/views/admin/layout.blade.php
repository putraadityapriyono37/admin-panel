<!DOCTYPE html>
<html lang="id" class="h-full bg-gray-50 dark:bg-gray-900">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Panel Admin')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('theme', {
                theme: 'light',
                init() {
                    this.theme = localStorage.getItem('theme') === 'dark' ? 'dark' : 'light';
                    this.apply();
                },
                toggle() {
                    this.theme = this.theme === 'dark' ? 'light' : 'dark';
                    localStorage.setItem('theme', this.theme);
                    this.apply();
                },
                apply() {
                    document.documentElement.classList.toggle('dark', this.theme === 'dark');
                },
            });

            Alpine.store('sidebar', {
                isMobileOpen: false,
                toggle() {
                    this.isMobileOpen = !this.isMobileOpen;
                },
                close() {
                    this.isMobileOpen = false;
                },
            });
        });
    </script>
    <script>
        if (localStorage.getItem('theme') === 'dark') {
            document.documentElement.classList.add('dark');
        }
    </script>
</head>

<body class="font-outfit">
    <a href="#konten"
        class="sr-only focus:not-sr-only focus:absolute focus:z-99999 focus:m-2 focus:rounded-lg focus:bg-brand-500 focus:px-4 focus:py-2 focus:text-white">
        Lompat ke konten
    </a>

    <div class="min-h-screen xl:flex">
        <!-- Backdrop sidebar mobile -->
        <div x-data x-show="$store.sidebar.isMobileOpen" x-transition.opacity
            @click="$store.sidebar.close()" class="fixed inset-0 z-9999 bg-black/40 xl:hidden"></div>

        <!-- Sidebar -->
        <aside
            class="fixed inset-y-0 start-0 z-99999 w-[290px] overflow-y-auto border-e border-gray-200 bg-white px-5 py-8 transition-transform duration-300 dark:border-gray-800 dark:bg-gray-900 xl:translate-x-0"
            :class="$store.sidebar.isMobileOpen ? 'translate-x-0' : 'max-xl:-translate-x-full'"
            aria-label="Navigasi utama">
            <div class="mb-8 flex items-center gap-2 px-2">
                <span class="text-lg font-semibold text-gray-800 dark:text-white/90">Panel Admin</span>
                @isset($currentMicrosite)
                    <span class="badge badge-info">{{ $currentMicrosite->name }}</span>
                @endisset
            </div>

            <nav class="flex flex-col gap-4">
                @if (auth('admin')->user()->isSuperAdmin())
                    <div>
                        <h2 class="mb-3 px-3 text-theme-xs font-medium uppercase tracking-wide text-gray-400">
                            Super Admin
                        </h2>
                        <ul class="flex flex-col gap-1">
                            <li>
                                <a class="menu-item {{ request()->routeIs('admin.super.dashboard') ? 'menu-item-active' : 'menu-item-inactive' }}"
                                    href="{{ route('admin.super.dashboard') }}">Dashboard</a>
                            </li>
                            <li>
                                <a class="menu-item {{ request()->routeIs('admin.microsites.*') ? 'menu-item-active' : 'menu-item-inactive' }}"
                                    href="{{ route('admin.microsites.index') }}">Microsite</a>
                            </li>
                            <li>
                                <a class="menu-item {{ request()->routeIs('admin.admins.*') ? 'menu-item-active' : 'menu-item-inactive' }}"
                                    href="{{ route('admin.admins.index') }}">Akun Admin</a>
                            </li>
                        </ul>
                    </div>
                @endif

                @isset($currentMicrosite)
                    <div>
                        <h2 class="mb-3 px-3 text-theme-xs font-medium uppercase tracking-wide text-gray-400">
                            {{ $currentMicrosite->name }}
                        </h2>
                        <ul class="flex flex-col gap-1">
                            <li>
                                <a class="menu-item {{ request()->routeIs('admin.dashboard') ? 'menu-item-active' : 'menu-item-inactive' }}"
                                    href="{{ route('admin.dashboard', $currentMicrosite) }}">Ringkasan</a>
                            </li>
                            <li>
                                <a class="menu-item {{ request()->routeIs('admin.info.*') ? 'menu-item-active' : 'menu-item-inactive' }}"
                                    href="{{ route('admin.info.edit', $currentMicrosite) }}">Info Restoran</a>
                            </li>
                            <li>
                                <a class="menu-item {{ request()->routeIs('admin.categories.*') ? 'menu-item-active' : 'menu-item-inactive' }}"
                                    href="{{ route('admin.categories.index', $currentMicrosite) }}">Kategori</a>
                            </li>
                            <li>
                                <a class="menu-item {{ request()->routeIs('admin.menu-items.*') ? 'menu-item-active' : 'menu-item-inactive' }}"
                                    href="{{ route('admin.menu-items.index', $currentMicrosite) }}">Menu</a>
                            </li>
                            <li>
                                <a class="menu-item {{ request()->routeIs('admin.galleries.*') ? 'menu-item-active' : 'menu-item-inactive' }}"
                                    href="{{ route('admin.galleries.index', $currentMicrosite) }}">Galeri</a>
                            </li>
                            <li>
                                <a class="menu-item {{ request()->routeIs('admin.promos.*') ? 'menu-item-active' : 'menu-item-inactive' }}"
                                    href="{{ route('admin.promos.index', $currentMicrosite) }}">Promo</a>
                            </li>
                            <li>
                                <a class="menu-item {{ request()->routeIs('admin.orders.*') ? 'menu-item-active' : 'menu-item-inactive' }}"
                                    href="{{ route('admin.orders.index', $currentMicrosite) }}">Pesanan</a>
                            </li>
                        </ul>
                    </div>
                @endisset
            </nav>
        </aside>

        <!-- Konten -->
        <div class="flex min-h-screen flex-1 flex-col xl:ms-[290px]">
            <header class="sticky top-0 z-9999 flex w-full items-center justify-between gap-3 border-b border-gray-200 bg-white px-4 py-3 dark:border-gray-800 dark:bg-gray-900 xl:px-6">
                <div class="flex items-center gap-3">
                    <button type="button" class="flex h-11 w-11 items-center justify-center rounded-lg text-gray-500 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-white/5 xl:hidden"
                        @click="$store.sidebar.toggle()" aria-label="Buka menu">
                        <svg width="20" height="14" viewBox="0 0 20 14" fill="none" aria-hidden="true">
                            <path d="M1 1h18M1 7h18M1 13h18" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                        </svg>
                    </button>
                    <h1 class="text-lg font-semibold text-gray-800 dark:text-white/90">@yield('title')</h1>
                </div>

                <div class="flex items-center gap-2">
                    <button type="button" x-data
                        class="flex h-11 w-11 items-center justify-center rounded-full border border-gray-200 text-gray-500 hover:bg-gray-100 hover:text-gray-700 dark:border-gray-800 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-white"
                        @click="$store.theme.toggle()" aria-label="Ganti tema terang atau gelap">
                        <svg class="hidden dark:block" width="18" height="18" viewBox="0 0 20 20" fill="none"
                            aria-hidden="true">
                            <circle cx="10" cy="10" r="4" stroke="currentColor" stroke-width="1.5" />
                            <path
                                d="M10 1.5v2M10 16.5v2M18.5 10h-2M3.5 10h-2M15.8 4.2l-1.4 1.4M5.6 14.4l-1.4 1.4M15.8 15.8l-1.4-1.4M5.6 5.6L4.2 4.2"
                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                        </svg>
                        <svg class="dark:hidden" width="18" height="18" viewBox="0 0 20 20" fill="none" aria-hidden="true">
                            <path
                                d="M17 12.2A7.5 7.5 0 0 1 7.8 3a7.5 7.5 0 1 0 9.2 9.2Z"
                                stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
                        </svg>
                    </button>

                    <span class="hidden text-sm font-medium text-gray-700 dark:text-gray-300 sm:inline">
                        {{ auth('admin')->user()->name }}
                    </span>

                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button class="btn btn-outline px-4 py-3 text-sm" type="submit">Keluar</button>
                    </form>
                </div>
            </header>

            <main id="konten" class="w-full max-w-(--breakpoint-2xl) grow p-4 md:p-6">
                @if (session('status'))
                    <div class="alert-success mb-6" role="status">{{ session('status') }}</div>
                @endif

                @if ($errors->any())
                    <div class="alert-error mb-6" role="alert">
                        <ul class="list-disc space-y-1 pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
</body>

</html>
