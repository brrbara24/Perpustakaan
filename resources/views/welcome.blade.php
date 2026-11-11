@extends('layouts.app')

@section('content')
    <div class="card narrow" style="text.align.center">
        <h1>Perpustakaan Sekolah Digital</h1>
        <p>Pilih jenis login.</p>
        <p>
            <a class="btn" href="/admin/login">Login Segabai Admin</a>
            <a class="btn btn-green" href="{{route('siswa.login')}}">Login Sebagai Siswa</a>
        </p>
    </div>
@endsection