@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h4>Masuk ke Sistem</h4>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('login.post') }}" class="needs-validation" novalidate="">
            @csrf
            <div class="form-group">
                <label for="useremail">Username atau Email</label>
                <input id="useremail" type="text" class="form-control @error('useremail') is-invalid @enderror" name="useremail" value="{{ old('useremail') }}" required autofocus tabindex="1" placeholder="sadmin / admin1 / email">
                @error('useremail')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <div class="d-block">
                    <label for="password" class="control-label">Password</label>
                </div>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required tabindex="2" placeholder="Masukkan password">
                @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" name="remember" class="custom-control-input" tabindex="3" id="remember-me">
                    <label class="custom-control-label" for="remember-me">Ingat Saya</label>
                </div>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                    Masuk Sekarang
                </button>
            </div>
        </form>

        <div class="mt-4 p-3 bg-light rounded text-small">
            <strong>Akun Bawaan (Default):</strong><br>
            - Super Admin : <code>sadmin</code> / <code>asd</code><br>
            - Admin Cabang : <code>admin1</code> / <code>asd</code>
        </div>
    </div>
</div>
@endsection
