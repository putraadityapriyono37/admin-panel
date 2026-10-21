<!DOCTYPE html>
<html lang="id" class="h-full bg-gray-50 dark:bg-gray-900">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        if (localStorage.getItem('theme') === 'dark') {
            document.documentElement.classList.add('dark');
        }
    </script>
</head>

<body class="font-outfit">
    <main class="flex min-h-screen items-center justify-center p-4">
        <div class="w-full max-w-md">
            <h1 class="text-title-sm mb-2 font-semibold text-gray-800 dark:text-white/90">Login Admin</h1>
            <p class="mb-6 text-sm text-gray-500 dark:text-gray-400">
                Masuk untuk mengelola data microsite restoran.
            </p>

            <div class="card p-6 sm:p-10">
                <form method="POST" action="{{ route('admin.login') }}">
                    @csrf
                    <div class="space-y-5">
                        <div>
                            <label class="form-label" for="username">Username<span class="text-error-500">
                                    *</span></label>
                            <input class="input-field" type="text" id="username" name="username"
                                value="{{ old('username') }}" required autofocus>
                        </div>

                        <div>
                            <label class="form-label" for="password">Password<span class="text-error-500">
                                    *</span></label>
                            <div class="relative">
                                <input class="input-field pr-12" type="password" id="password" name="password" required>
                                <button type="button" class="absolute end-2 top-1/2 flex h-9 w-9 -translate-y-1/2 items-center justify-center rounded-lg text-gray-500 hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-white"
                                    data-toggle-password aria-controls="password" aria-label="Tampilkan password"
                                    aria-pressed="false">
                                    <svg data-eye data-eye-open hidden aria-hidden="true" width="20" height="20"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7Z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                    <svg data-eye data-eye-closed aria-hidden="true" width="20" height="20"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M3 3l18 18"></path>
                                        <path
                                            d="M10.6 5.1A10.9 10.9 0 0 1 12 5c6.5 0 10 7 10 7a18.4 18.4 0 0 1-2.7 3.7">
                                        </path>
                                        <path d="M6.2 6.2A18.4 18.4 0 0 0 2 12s3.5 7 10 7a10.7 10.7 0 0 0 5.4-1.4">
                                        </path>
                                        <path d="M9.9 9.9a3 3 0 0 0 4.2 4.2"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div>
                            <label class="inline-flex items-center gap-2 text-sm text-gray-700 dark:text-gray-400">
                                <input class="h-4 w-4 rounded border-gray-300 text-brand-500" type="checkbox"
                                    name="remember">
                                Ingat saya
                            </label>
                        </div>

                        @error('username')
                            <p class="text-sm font-medium text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror

                        <button class="btn btn-primary w-full px-5 py-3.5 text-sm" type="submit">Masuk</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
    <script src="{{ asset('js/admin.js') }}" defer></script>
</body>

</html>
