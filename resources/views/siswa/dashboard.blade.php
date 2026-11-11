@extends('layouts.app')
@section('title', 'Dashboard Siswa')

@section('content')
    <h2>Halo, {{ auth()->user()->name }}</h2>

    <div class="grid">
        <div class="card"><div>Sedang dipinjam</div><div class="stat">{{ $dipinjam }}</div></div>
        <div class="card"><div>Total peminjaman</div><div class="stat">{{ $total }}</div></div>
        <div class="card"><div>Judul buku tersedia</div><div class="stat">{{ $tersedia }}</div></div>
        <div class="card"><div>Total denda</div><div class="stat">Rp {{ number_format($denda, 0, ',', '.') }}</div></div>
    </div>

    <div class="card">
        <h3>Riwayat terbaru</h3>
        <table>
            <tr><th>Buku</th><th>Tanggal Pinjam</th><th>Jatuh Tempo</th><th>Status</th></tr>
            @forelse ($riwayat as $r)
                <tr>
                    <td>{{ $r->book->title }}</td>
                    <td>{{ $r->loan_date->format('d M Y') }}</td>
                    <td>{{ $r->due_date->format('d M Y') }}</td>
                    <td>{{ ucfirst($r->status) }}</td>
                </tr>
            @empty
                <tr><td colspan="4">Belum ada transaksi.</td></tr>
            @endforelse
        </table>
    </div>
@endsection