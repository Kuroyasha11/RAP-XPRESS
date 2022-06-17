@extends('backend.layouts.main')

@section('container')
    <h1 class="mb-3">{{ $profile->name }}</h1>
    @if (session()->has('berhasil'))
        <div class="alert alert-success col-lg-15" role="alert">
            {{ session('berhasil') }}
        </div>
    @endif
    @if (session()->has('gagal'))
        <div class="alert alert-danger col-lg-15" role="alert">
            {{ session('gagal') }}
        </div>
    @endif

    <div class="col-lg-5">
        <a href="/dashboard" class="btn btn-success"><i class="bi bi-arrow-left-circle"></i> Back</a>
        @if (auth()->user()->partner_id == 2)
            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                <i class="bi bi-pencil"></i> Edit
            </button>
        @endif
    </div>

    @if ($profile->image)
        <div class="position-relative">
            <img src="https://source.unsplash.com/1200x400?{{ $profile->partner->name }}" class="img-fluid mt-3"
                alt="{{ $profile->partner->name }}">
            <picture class="position-absolute bottom-0 start-50 translate-middle-x">
                <img src="{{ asset('storage/' . $profile->image) }}" class="img-fluid img-thumbnail rounded-circle"
                    alt="{{ $profile->partner->name }}" width="100">
            </picture>
        </div>
    @else
        <div class="position-relative">
            <img src="https://source.unsplash.com/1200x400?{{ $profile->partner->name }}" class="img-fluid mt-3"
                alt="{{ $profile->partner->name }}">
            <picture class="position-absolute bottom-0 start-50 translate-middle-x">
                <img src="https://source.unsplash.com/100x100?{{ $profile->partner->name }}"
                    class="img-fluid img-thumbnail rounded-circle" alt="{{ $profile->partner->name }}">
            </picture>
        </div>
    @endif

    <div class="table-responsive col-lg-15 mb-5">
        <table class="table table-sm">
            <thead>
                <tr align="center">
                    <th scope="col">Data</th>
                    <th scope="col">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Mitra</td>
                    <td>: {{ $profile->partner->name }}</td>
                </tr>
                <tr>
                    <td>Nama</td>
                    <td>: {{ $profile->name }}</td>
                </tr>
                <tr>
                    <td>Nomor Handphone</td>
                    <td>: <a href="https://wa.me/62{{ $profile->no_hp }}" class="text-decoration-none text-black"
                            target="_blank">
                            +62{{ $profile->no_hp }}
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>KTP/SIM</td>
                    <td>: {{ $profile->ktp_sim }}</td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td>: {{ $profile->email }}</td>
                </tr>
                <tr>
                    <td>WhatsApp</td>
                    <td>: <a href="https://wa.me/62{{ $profile->account->wa }}"
                            class="text-decoration-none text-success">
                            <i class="bi-whatsapp fs-3"></i> <strong>+62{{ $profile->account->wa }} </strong>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>Instagram</td>
                    <td>: <a href="https://instagram.com/{{ $profile->account->ig }}"
                            class="text-decoration-none text-danger">
                            <i class="bi-instagram fs-3"></i> <strong>{{ $profile->account->ig }} </strong>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>Facebook</td>
                    <td>: <a href="https://facebook.com/{{ $profile->account->fb }}"
                            class="text-decoration-none text-primary">
                            <i class="bi-facebook fs-3"></i> <strong>{{ $profile->account->fb }} </strong>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>Foto</td>
                    <td>:
                        @if ($profile->image)
                            <img src="{{ asset('storage/' . $profile->image) }}" alt="{{ $profile->name }}"
                                width="200px" class="rounded">
                        @else
                            BELUM ADA FOTO
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">{{ $profile->name }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/dashboard/profile/{{ $profile->slug }}" method="post" class="mb-5"
                        enctype="multipart/form-data">
                        @method('put')
                        @csrf
                        <div class="mb-3">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                    name="name" autofocus value="{{ old('name', $profile->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <input type="hidden" class="form-control @error('slug') is-invalid @enderror" id="slug"
                                    name="slug" value="{{ old('slug', $profile->slug) }}" required readonly>
                                @error('slug')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="no_hp" class="form-label">Nomor Handphone</label>
                                <input type="number" class="form-control @error('no_hp') is-invalid @enderror" id="no_hp"
                                    name="no_hp" value="{{ old('no_hp', $profile->no_hp) }}" required>
                                @error('no_hp')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="alamat" class="form-label">Alamat</label>
                                <input type="text" class="form-control @error('alamat') is-invalid @enderror" id="alamat"
                                    name="alamat" placeholder="Alamat"
                                    value="{{ old('alamat', $profile->account->alamat) }}">
                                @error('alamat')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <label for="alamat" class="form-label text-muted">Note : isi Alamat pengambilan
                                    paket</label>
                            </div>
                            <div class="mb-3">
                                <label for="jenistoko" class="form-label">Jenis Toko</label>
                                <input type="text" class="form-control @error('jenistoko') is-invalid @enderror"
                                    id="jenistoko" name="jenistoko" placeholder="Jenis Toko"
                                    value="{{ old('jenistoko', $profile->account->jenistoko) }}">
                                @error('jenistoko')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <label for="jenistoko" class="form-label text-muted">Note : Abaikan jika mitra adalah
                                    kurir</label>
                            </div>
                            {{-- <div class="mb-3">
                                <label for="username">Username</label>
                                <input type="text" class="form-control @error('username') is-invalid @enderror"
                                    id="username" name="username" placeholder="Username" required
                                    value="{{ old('username', $profile->username) }}">
                                @error('username')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div> --}}
                            {{-- <div class="form-floating mb-3">
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="password" name="password" placeholder="Password">
                                <label for="password">Password</label>
                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div> --}}
                            <div class="mb-3">
                                <input type="hidden" name="oldImage" value="{{ $profile->image }}">
                                @if ($profile->image)
                                    <img src="{{ asset('storage/' . $profile->image) }}"
                                        class="img-preview adh img-fluid mb-3" width="79" height="108">
                                @else
                                    <img class="img-preview adh img-fluid mb-3" width="79" height="108">
                                @endif
                                <input class="form-control @error('image') is-invalid @enderror" type="file" id="image"
                                    name="image" onchange="previewImage()">
                                @error('image')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="wa" class="form-label">WhatsApp</label>
                                <input type="number" class="form-control @error('wa') is-invalid @enderror" id="wa"
                                    name="wa" value="{{ old('wa', $profile->account->wa) }}">
                                @error('wa')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="ig" class="form-label">Instagram</label>
                                <input type="text" class="form-control @error('ig') is-invalid @enderror" id="ig" name="ig"
                                    value="{{ old('ig', $profile->account->ig) }}">
                                @error('ig')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="fb" class="form-label">Facebook</label>
                                <input type="text" class="form-control @error('fb') is-invalid @enderror" id="fb" name="fb"
                                    value="{{ old('fb', $profile->account->fb) }}">
                                @error('fb')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Save</button>
                        </div>
                    </form>
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

        function previewImage() {
            const image = document.querySelector('#image');
            const imgPreview = document.querySelector('.img-preview');

            imgPreview.style.display = 'block';

            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0]);

            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result;
            }

        }
    </script>
@endsection
