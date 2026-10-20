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
                    <input type="password" id="password" name="password" required>
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
</body>

</html>
