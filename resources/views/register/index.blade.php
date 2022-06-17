@extends('login.layouts.main')

@section('container')
    <div class="col-md-9 col-lg-8 mx-auto">
        <h3 class="login-heading mb-4">Pendaftaran menjadi Mitra RAP-XPRESS!</h3>
        @if (session()->has('berhasil'))
            <div class="alert alert-success col-lg-8" role="alert">
                {{ session('berhasil') }}
            </div>
        @endif
        @if (session()->has('gagal'))
            <div class="alert alert-danger col-lg-8" role="alert">
                {{ session('gagal') }}
            </div>
        @endif
        <form action="/register" method="post">
            @csrf
            <div class="form-floating mb-3">
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                    placeholder="name" autofocus required value="{{ old('name') }}">
                <label for="name">Nama</label>
                @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-floating mb-3">
                <input type="hidden" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug"
                    placeholder="slug" required value="{{ old('slug') }}" readonly>
                <label for="slug">Slug</label>
                @error('slug')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-floating mb-3">
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                    placeholder="email" required value="{{ old('email') }}">
                <label for="email">Email</label>
                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-floating mb-3">
                <input type="number" class="form-control @error('no_hp') is-invalid @enderror" id="no_hp" name="no_hp"
                    placeholder="no_hp" required value="{{ old('no_hp') }}">
                <label for="no_hp">Nomor Handphone</label>
                @error('no_hp')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-floating mb-3">
                <input type="number" class="form-control @error('ktp_sim') is-invalid @enderror" id="ktp_sim" name="ktp_sim"
                    placeholder="ktp_sim" required value="{{ old('ktp_sim') }}">
                <label for="ktp_sim">KTP/SIM</label>
                @error('ktp_sim')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="partner" class="form-label">Partner</label>
                <select class="form-select" name="partner_id">
                    @foreach ($partners as $partner)
                        @if (old('partner_id') == $partner->id)
                            <option value="{{ $partner->id }}" selected>{{ $partner->name }}</option>
                        @else
                            <option value="{{ $partner->id }}">{{ $partner->name }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="form-floating mb-3">
                <input type="hidden" class="form-control" id="password" name="password" placeholder="Password"
                    value="12345678">
                {{-- <label for="password">Password</label> --}}
            </div>
            <div class="d-grid">
                <button class="btn btn-lg btn-primary btn-login text-uppercase fw-bold mb-2" type="submit">Register</button>
            </div>
        </form>
        <small class="d-block text-center mt-3">
            Anda seorang Mitra? <a href="/login">
                Login Sekarang!
            </a>
        </small>
        <div class="d-flex justify-content-evenly mt-3">
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#persyaratan">
                Persyaratan
            </button>
            <a href="{{ url()->previous() }}" class="btn btn-primary text-decoration-none">Kembali</a>
        </div>
    </div>

    <div class="modal fade" id="persyaratan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Persyaratan Daftar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-hover">
                        <thead>
                            <tr align="center">
                                <th scope="col">NO</th>
                                <th scope="col">KURIR</th>
                                <th scope="col">ONLINE SHOP</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row" align="center">1</th>
                                <td>KTP</td>
                                <td>KTP</td>
                            </tr>
                            <tr>
                                <th scope="row" align="center">2</th>
                                <td>SIM</td>
                                <td>FOTO OLSHOP (Social Media)</td>
                            </tr>
                            <tr>
                                <th scope="row" align="center">3</th>
                                <td>STNK</td>
                                <td>PETA LOKASI OLSHOP</td>
                            </tr>
                            <tr>
                                <th scope="row" align="center">4</th>
                                <td>SKCK</td>
                            </tr>
                            <tr>
                                <th scope="row" align="center">5</th>
                                <td>KK</td>
                            </tr>
                        </tbody>
                    </table>
                    <p class="text-muted d-flex justify-content-center">
                        Asli dan Fotocopy.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // FETCH API
        const name = document.querySelector('#name');
        const slug = document.querySelector('#slug');

        name.addEventListener('change', function() {
            fetch('/register/checkSlug?name=' + name.value)
                .then(response => response.json())
                .then(data => slug.value = data.slug)
        });
    </script>
@endsection
