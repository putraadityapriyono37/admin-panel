<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Panel Admin')</title>
    <style>
        body {
            font-family: sans-serif;
            max-width: 900px;
            margin: 0 auto;
            padding: 16px;
        }

        nav {
            display: flex;
            gap: 16px;
            align-items: center;
            padding-bottom: 12px;
            border-bottom: 1px solid #ccc;
            margin-bottom: 16px;
        }

        nav form {
            margin-left: auto;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 6px 8px;
            text-align: left;
        }

        .ok {
            background: #e6f7e6;
            padding: 8px;
            margin-bottom: 12px;
        }

        .err {
            background: #fde8e8;
            padding: 8px;
            margin-bottom: 12px;
        }

        .field {
            margin-bottom: 10px;
        }

        .field label {
            display: block;
        }

        .inline {
            display: inline;
        }
    </style>
</head>

<body>
    <nav>
        <strong>Panel Admin</strong>
        @if (auth('admin')->user()->isSuperAdmin())
            <a href="{{ route('admin.super.dashboard') }}">Dashboard</a>
            <a href="{{ route('admin.microsites.index') }}">Microsite</a>
            <a href="{{ route('admin.admins.index') }}">Akun Admin</a>
        @endif
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit">Keluar</button>
        </form>
    </nav>

    @if (session('status'))
        <div class="ok">{{ session('status') }}</div>
    @endif

    @if ($errors->any())
        <div class="err">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @yield('content')
</body>

</html>
