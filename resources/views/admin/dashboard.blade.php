<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Dashboard {{ $microsite->name }}</title>
</head>

<body>
    <h1>Dashboard {{ $microsite->name }}</h1>
    <p>Halo, {{ auth('admin')->user()->name }}</p>
    <form method="POST" action="{{ route('admin.logout') }}">
        @csrf
        <button type="submit">Keluar</button>
    </form>
</body>

</html>
