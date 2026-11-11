@extends('layouts.app')
@section('title', 'Login Siswa')

@section('content')
    <div class="card narrow">
        <h2>Login Siswa</h2>

        @error('email')
            <div class="alert err">{{ $message }}</div>
        @enderror

        <form method="POST" action="{{ route('siswa.login') }}">
            @csrf
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus>

            <label>Password</label>
            <input type="password" name="password" required>

            <p><button class="btn" type="submit">Masuk</button></p>
        </form>

        <p>Belum menjadi anggota? <a href="{{ route('siswa.daftar') }}">Daftar anggota</a></p>
    </div>
@endsection