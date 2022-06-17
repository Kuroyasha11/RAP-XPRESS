@extends('backend.layouts.main')

@section('container')

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

    <div class="d-inline-flex">
        {{-- <form action="/dashboard/slide" method="post">
            @csrf
            <input type="hidden" name="keterangan" id="keterangan" value="New Slide">
            <button type="submit" class="btn btn-success" onclick="return confirm('Are you sure?')"><i
                    class="bi bi-plus"></i> Tambah</button>
        </form> --}}.
        <a href="/dashboard/slide/create" class="btn btn-success"><i class="bi bi-plus"></i> Tambah</a>
    </div>
    <div class="table-responsive col-lg-15 mb-5">
        <table class="table table-striped table-sm">
            <thead>
                <tr align="CENTER">
                    <th scope="col">No</th>
                    <th scope="col">Keterangan</th>
                    <th scope="col">Gambar</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if ($slide->count())
                    @foreach ($slide as $item)
                        <tr align="CENTER">
                            <td>Slide {{ $loop->iteration }}</td>

                            <td>{{ $item->keterangan }}</td>
                            <td>
                                @if ($item->image)
                                    <img src="{{ asset('storage/' . $item->image) }}"
                                        class="img-preview adh img-fluid mb-3" width="100" height="100">
                                @else
                                    Kosong
                                @endif
                            </td>
                            <td>
                                <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                    data-bs-target="#staticBackdrop{{ $item->id }}">
                                    <i class="bi bi-pencil"></i> Edit
                                </button>
                                <form action="/dashboard/slide/{{ $item->id }}" method="post" class="d-inline">
                                    @method('delete')
                                    @csrf
                                    <button class="btn btn-danger" onclick="return confirm('Are you sure?')">
                                        <i class="bi bi-x-circle"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <div class="modal fade" id="staticBackdrop{{ $item->id }}" data-bs-backdrop="static"
                            data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="staticBackdropLabel">Ganti Foto
                                            Slide ke-{{ $item->id }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="/dashboard/slide/{{ $item->id }}" method="post"
                                            class="mb-5" enctype="multipart/form-data">
                                            @method('put')
                                            @csrf
                                            <div class="mb-3">
                                                <label for="keterangan" class="form-label">Keterangan</label>
                                                <input class="form-control" type="text" name="keterangan" id="keterangan"
                                                    placeholder="Keterangan"
                                                    value="{{ old('keterangan', $item->keterangan) }}">
                                            </div>
                                            <div class="mb-3">
                                                <input type="hidden" name="oldImage" value="{{ $item->image }}">
                                                @if ($item->image)
                                                    <img src="{{ asset('storage/' . $item->image) }}"
                                                        class="img-preview adh img-fluid mb-3" width="300" height="450">
                                                @else
                                                    <img class="img-preview adh img-fluid mb-3" width="300" height="450">
                                                @endif
                                                <input class="form-control @error('image') is-invalid @enderror" type="file"
                                                    id="image" name="image" onchange="previewImage()">
                                                @error('image')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-save"></i> Update
                                        </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <tr>
                        <td colspan="4">
                            <p class="text-center fs-4">Tidak ada Slide</p>
                        </td>
                    </tr>
                @endif

            </tbody>
        </table>
    </div>

    <script>
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
