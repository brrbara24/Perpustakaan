@extends('layouts.app')
@section('title', 'Pengembalian Buku')

@section('content')
    <h2>Pengembalian Buku</h2>

    <div class="card">
        <h3>Sedang dipinjam</h3>
        <table>
            <tr><th>Buku</th><th>Tanggal Pinjam</th><th>Jatuh Tempo</th><th></th></tr>
            @forelse ($aktif as $l)
                <tr>
                    <td>{{ $l->book->title }}</td>
                    <td>{{ $l->loan_date->format('d M Y') }}</td>
                    <td>{{ $l->due_date->format('d M Y') }}</td>
                    <td>
                        <form method="POST" action="{{ route('siswa.kembalikan', $l) }}">
                            @csrf
                            <button class="btn" type="submit">Kembalikan</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4">Tidak ada buku yang sedang dipinjam.</td></tr>
            @endforelse
        </table>
    </div>

    <div class="card">
        <h3>Riwayat pengembalian</h3>
        <table>
            <tr><th>Buku</th><th>Dipinjam</th><th>Dikembalikan</th><th>Denda</th></tr>
            @forelse ($riwayat as $l)
                <tr>
                    <td>{{ $l->book->title }}</td>
                    <td>{{ $l->loan_date->format('d M Y') }}</td>
                    <td>{{ $l->returned_at?->format('d M Y') }}</td>
                    <td>Rp {{ number_format($l->fine, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr><td colspan="4">Belum ada riwayat.</td></tr>
            @endforelse
        </table>
    </div>
@endsection