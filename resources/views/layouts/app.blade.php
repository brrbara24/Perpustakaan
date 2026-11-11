<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Perpustakaan Sekolah Digital')</title>
    <style>
        * { box-sizing: border-box; }
        body { font-family: system-ui, Arial, sans-serif; margin: 0; background: #f3f4f6; color: #1f2937; }
        nav { background: #1e3a8a; color: #fff; padding: 12px 24px; display: flex; gap: 16px; align-items: center; flex-wrap: wrap; }
        nav a { color: #fff; text-decoration: none; }
        nav .spacer { flex: 1; }
        nav form { margin: 0; }
        main { max-width: 960px; margin: 24px auto; padding: 0 16px; }
        .card { background: #fff; border-radius: 8px; padding: 20px; box-shadow: 0 1px 3px rgba(0,0,0,.1); margin-bottom: 16px; }
        .grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; }
        .stat { font-size: 32px; font-weight: 700; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 8px; border-bottom: 1px solid #e5e7eb; text-align: left; }
        label { display: block; margin: 10px 0 4px; }
        input { width: 100%; padding: 8px; border: 1px solid #d1d5db; border-radius: 6px; }
        .btn { display: inline-block; background: #1e3a8a; color: #fff; border: 0; padding: 8px 16px; border-radius: 6px; cursor: pointer; text-decoration: none; }
        .btn-green { background: #15803d; }
        .alert { padding: 10px 14px; border-radius: 6px; margin-bottom: 12px; }
        .ok { background: #dcfce7; color: #166534; }
        .err { background: #fee2e2; color: #991b1b; }
        .narrow { max-width: 420px; margin: 32px auto; }
    </style>
</head>
<body>
    <nav>
        <strong>Perpustakaan Sekolah Digital</strong>
        @auth
            @if (auth()->user()->role === 'siswa')
                <a href="{{ route('siswa.dashboard') }}">Dashboard</a>
                <a href="{{ route('siswa.peminjaman') }}">Peminjaman Buku</a>
                <a href="{{ route('siswa.pengembalian') }}">Pengembalian Buku</a>
                <span class="spacer"></span>
                <span>{{ auth()->user()->name }}</span>
                <form method="POST" action="{{ route('siswa.logout') }}">
                    @csrf
                    <button class="btn" type="submit">Keluar</button>
                </form>
            @endif
        @endauth
    </nav>

    <main>
        @if (session('success'))
            <div class="alert ok">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert err">{{ session('error') }}</div>
        @endif

        @yield('content')
    </main>
</body>
</html>