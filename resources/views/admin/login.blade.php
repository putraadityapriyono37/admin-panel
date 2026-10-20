<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Admin</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>

<body>
    <main class="login-wrap">
        <h1>Login Admin</h1>
        <div class="card">
            <form method="POST" action="{{ route('admin.login') }}">
                @csrf
                <div class="field">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" value="{{ old('username') }}" required autofocus>
                </div>
                <div class="field">
                    <label for="password">Password</label>
                    <div class="input-group">
                        <input type="password" id="password" name="password" required>
                        <button type="button" class="btn-eye" data-toggle-password aria-controls="password"
                            aria-label="Tampilkan password" aria-pressed="false">
                            <svg data-eye data-eye-open hidden aria-hidden="true" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7Z"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                            <svg data-eye data-eye-closed aria-hidden="true" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 3l18 18"></path>
                                <path d="M10.6 5.1A10.9 10.9 0 0 1 12 5c6.5 0 10 7 10 7a18.4 18.4 0 0 1-2.7 3.7"></path>
                                <path d="M6.2 6.2A18.4 18.4 0 0 0 2 12s3.5 7 10 7a10.7 10.7 0 0 0 5.4-1.4"></path>
                                <path d="M9.9 9.9a3 3 0 0 0 4.2 4.2"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="field">
                    <label class="check"><input type="checkbox" name="remember"> Ingat saya</label>
                </div>
                @error('username')
                    <p class="field-error">{{ $message }}</p>
                @enderror
                <button class="btn btn-primary" type="submit">Masuk</button>
            </form>
        </div>
    </main>
    <script src="{{ asset('js/admin.js') }}" defer></script>
</body>

</html>
