@extends('login.layouts.main')

@section('container')
    <div class="col-md-9 col-lg-8 mx-auto">
        @if (session()->has('gagal'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{-- session loginError adalah mengambil pesan dari logincontroller --}}
                {{ session('gagal') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <h3 class="login-heading mb-4">Welcome back!</h3>

        <form action="/login" method="post">
            @csrf
            <div class="form-floating mb-3">
                <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username"
                    placeholder="username" autofocus required value="{{ old('username') }}">
                <label for="username">Username</label>
                @error('username')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-floating mb-3">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                <label for="password">Password</label>
            </div>
            <div class="d-grid">
                <button class="btn btn-lg btn-primary btn-login text-uppercase fw-bold mb-2" type="submit">Sign in</button>
            </div>
        </form>
        {{-- <small class="d-block text-center mt-3">
            Belum mempunyai akun? <a href="/register">
                Daftar Sekarang!
            </a>
        </small> --}}
        <div class="d-flex justify-content-end mt-3">
            <a href="/" class="btn btn-primary text-decoration-none">Kembali</a>
        </div>
    </div>
@endsection
