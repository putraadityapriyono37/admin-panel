<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Login Admin</title>
</head>

<body>
    <h1>Login Admin</h1>
    <form method="POST" action="{{ route('admin.login') }}">
        @csrf
        <div><label>Username <input type="text" name="username" value="{{ old('username') }}" required
                    autofocus></label></div>
        <div><label>Password <input type="password" name="password" required></label></div>
        <div><label><input type="checkbox" name="remember"> Ingat saya</label></div>
        @error('username')
            <p style="color: red">{{ $message }}</p>
        @enderror
        <button type="submit">Masuk</button>
    </form>
</body>

</html>
