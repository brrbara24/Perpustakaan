@extends('layouts.app')
@section('title', 'Daftar Anggota')

@section('content')
    <div class="card narrow">
        <h2>Daftar Anggota</h2>

        <form method="POST" action="{{ route('siswa.daftar') }}">
            @csrf

            @foreach ([
                ['name', 'Nama Lengkap', 'text'],
                ['email', 'Email', 'email'],
                ['kelas', 'Kelas', 'text'],
            ] as [$field, $label, $type])
                <label>{{ $label }}</label>
                <input type="{{ $type }}" name="{{ $field }}" value="{{ old($field) }}">
                @error($field)
                    <small style="color:#991b1b">{{ $message }}</small>
                @enderror
            @endforeach

            <label>Password</label>
            <input type="password" name="password">
            @error('password')
                <small style="color:#991b1b">{{ $message }}</small>
            @enderror

            <label>Ulangi Password</label>
            <input type="password" name="password_confirmation">

            <p><button class="btn" type="submit">Daftar</button></p>
        </form>

        <p>Sudah punya akun? <a href="{{ route('siswa.login') }}">Login</a></p>
    </div>
@endsection