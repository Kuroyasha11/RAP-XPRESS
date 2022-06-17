@extends('backend.layouts.main')

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">{{ $partner->name }}</h1>
    </div>

    <div class="col-lg-5">
        <div class="mt-3 mb-3">
            <a href="/dashboard/registration/{{ $partner->slug }}" class="btn btn-success"><i
                    class="bi bi-arrow-left-circle"></i> Back</a>
        </div>
    </div>
    <div class="col-lg-15">
        <form action="/dashboard/registration/{{ $partner->slug }}" method="post" class="mb-5"
            enctype="multipart/form-data">
            @method('put')
            @csrf
            <div class="mb-3">
                <div class="mb-3">
                    <label for="partner" class="form-label">Partner</label>
                    <select class="form-select" name="partner_id">
                        @foreach ($partners as $p)
                            @if (old('partner_id', $partner->partner_id) == $p->id)
                                <option value="{{ $p->id }}" selected>{{ $p->name }}</option>
                            @else
                                <option value="{{ $p->id }}">{{ $p->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">Nama</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                        autofocus value="{{ old('name', $partner->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <input type="hidden" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug"
                        value="{{ old('slug', $partner->slug) }}" readonly>
                    @error('slug')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="no_hp" class="form-label">Nomor Handphone</label>
                    <input type="number" class="form-control @error('no_hp') is-invalid @enderror" id="no_hp" name="no_hp"
                        value="{{ old('no_hp', $partner->no_hp) }}" required>
                    @error('no_hp')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="ktp_sim" class="form-label">KTP/SIM</label>
                    <input type="number" class="form-control @error('ktp_sim') is-invalid @enderror" id="ktp_sim"
                        name="ktp_sim" value="{{ old('ktp_sim', $partner->ktp_sim) }}" required>
                    @error('ktp_sim')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                        value="{{ old('email', $partner->email) }}" required>
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control @error('username') is-invalid @enderror" id="username"
                        name="username" placeholder="Username" required
                        value="{{ old('username', $partner->username) }}">
                    @error('username')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Foto</label>
                    <input type="hidden" name="oldImage" value="{{ $partner->image }}">
                    @if ($partner->image)
                        <img src="{{ asset('storage/' . $partner->image) }}"
                            class="img-preview img-fluid mb-3 col-sm-5 d-block" width="79" height="108">
                    @else
                        <img class="img-preview img-fluid mb-3 col-sm-5" width="79" height="108">
                    @endif
                    <input class="form-control @error('image') is-invalid @enderror" type="file" id="image" name="image"
                        onchange="previewImage()">
                    @error('image')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" value="1" id="is_mitra" name="is_mitra"
                        @if ($partner->is_mitra) checked @endif>
                    <label class="form-check-label" for="is_mitra">
                        Mitra
                    </label>
                </div>
                <div class="mb-3">
                    <input class="form-control" type="hidden" value="{{ $partner->id }}" id="user_id" name="user_id">
                </div>
                <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Update</button>
        </form>
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
