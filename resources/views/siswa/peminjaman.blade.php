@extends('layouts.app')
@section('title', 'Peminjaman Buku')

@section('content')
    <h2>Peminjaman Buku</h2>

    <div class="card">
        <form method="GET" action="{{ route('siswa.peminjaman') }}" style="display:flex; gap:8px">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari judul atau penulis">
            <button class="btn" type="submit">Cari</button>
        </form>
    </div>

    <div class="card">
        <table>
            <tr><th>Judul</th><th>Penulis</th><th>Penerbit</th><th>Tahun</th><th>Stok</th><th></th></tr>
            @forelse ($books as $b)
                <tr>
                    <td>{{ $b->title }}</td>
                    <td>{{ $b->author }}</td>
                    <td>{{ $b->publisher }}</td>
                    <td>{{ $b->year }}</td>
                    <td>{{ $b->stock }}</td>
                    <td>
                        <form method="POST" action="{{ route('siswa.pinjam') }}">
                            @csrf
                            <input type="hidden" name="book_id" value="{{ $b->id }}">
                            <button class="btn btn-green" type="submit">Pinjam</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6">Tidak ada buku yang tersedia.</td></tr>
            @endforelse
        </table>
    </div>
@endsection