<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Dashboard Super Admin</title>
</head>

<body>
    <h1>Dashboard Super Admin</h1>
    <p>Halo, {{ auth('admin')->user()->name }}</p>
    <ul>
        @foreach ($microsites as $microsite)
            <li><a href="{{ route('admin.dashboard', $microsite) }}">{{ $microsite->name }}</a></li>
        @endforeach
    </ul>
    <form method="POST" action="{{ route('admin.logout') }}">
        @csrf
        <button type="submit">Keluar</button>
    </form>
</body>

</html>
