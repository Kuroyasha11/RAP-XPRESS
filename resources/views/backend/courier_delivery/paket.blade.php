@extends('backend.layouts.main')

@section('container')

    {{-- <h1 class="mb-3">{{ $paket->nama }}</h1> --}}
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
        <a href="/dashboard/pengiriman-paket/{{ $paket->courier_id }}" class="btn btn-success"><i
                class="bi bi-arrow-left-circle"></i> Back</a>
        @if ($paket->diambil == 1 && $paket->selesai == 0)
            @if ($courier)
                @if ($courier->titik1 == 1 && $courier->titik2 == 0 && $courier->selesai == 0)
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                        <i class="bi bi-check"></i> Selesai
                    </button>
                @endif
            @endif
        @endif
    </div>
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
                    <td>Resi</td>
                    <td>: @if ($paket->terima == 0)
                            -
                        @else
                            <div class="d-flex justify-content-center">
                                <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($paket->slug, 'C39', 1, 35) }}"
                                    alt="{{ $paket->slug }}" />
                            </div>
                            <div class="d-flex justify-content-center">
                                <strong>{{ $paket->slug }}</strong>
                            </div>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Nama Penerima</td>
                    <td>: {{ $paket->namapenerima }}</td>
                </tr>
                <tr>
                    <td>Nomor Penerima</td>
                    <td>: <a href="https://wa.me/62{{ $paket->no_hp }}" class="text-decoration-none text-black"
                            target="_blank">
                            +62{{ $paket->no_hp }}
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>Paket</td>
                    <td>: {{ $paket->nama }}</td>
                </tr>
                <tr>
                    <td>Jumlah</td>
                    <td>: {{ $paket->jumlah }}</td>
                </tr>
                <tr>
                    <td>Harga Paket</td>
                    <td>: @IDR($paket->hargapaket)</td>
                </tr>
                <tr>
                    <td>Alamat Tujuan</td>
                    <td>: {{ $paket->alamat }} <a href="https://www.google.com/maps/place/{{ $paket->alamat }}"
                            class=" btn btn-success text-decoration-none text-black" target="_blank">
                            <i class="bi bi-geo-alt-fill"></i> MAP
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>Keterangan</td>
                    <td>: {{ $paket->keterangan }}</td>
                </tr>
                <tr>
                    <td>Kelas Pengiriman</td>
                    <td>: {{ $paket->shipping->nama }} @if ($paket->cod == 1)
                            | COD (Cash On Delivery)
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Ongkos Pengiriman</td>
                    <td>: @IDR($paket->shipping->harga)</td>
                </tr>
                <tr>
                    <td>Kurir</td>
                    <td>: @if ($courier)
                            {{ $courier->author->name }}
                        @else
                            Kurir belum dipilih
                        @endif

                    </td>
                </tr>
                @if ($paket->cod)
                    <tr>
                        <td><b>Total COD</b> <label class="text-muted">Kurir menerima pembayaran dari Customer, dan
                                Kurir menyetor pembayaran ke Admin</label></td>
                        <td>: <b>@IDR($paket->shipping->harga + $paket->hargapaket)</b></td>
                    </tr>
                    {{-- @else
                    <tr>
                        <td><b>Total yang harus diterima kurir dari olshop</b></td>
                        <td>: <b>@IDR($paket->shipping->harga)</b></td>
                    </tr> --}}
                @endif
                @if ($paket->selesai == 1)
                    <tr>
                        <td> image</td>
                        <td>: <div class="mb-3">
                                <img src="{{ asset('storage/' . $paket->image) }}" class="img-preview  img-fluid mb-3"
                                    width="350" height="500">
                            </div>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>


    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Paket telah sampai ke customer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/dashboard/pengiriman-paket/paket/{{ $paket->slug }}" method="post"
                        class="mb-5" enctype="multipart/form-data">
                        @method('put')
                        @csrf
                        <div class="mb-3">
                            {{-- <label for="selesai" class="form-label">Selesai</label> --}}
                            <input class="form-control" type="hidden" name="selesai" id="selesai" placeholder="Selesai"
                                value="1">
                        </div>
                        <div class="mb-3">
                            <input type="hidden" name="oldImage" value="{{ $paket->image }}">
                            @if ($paket->image)
                                <img src="{{ asset('storage/' . $paket->image) }}" class="img-preview img-fluid mb-3"
                                    width="300" height="450">
                            @else
                                <img class="img-preview img-fluid mb-3" width="300" height="450">
                            @endif
                            <input class="form-control @error('image') is-invalid @enderror" type="file" id="image"
                                name="image" onchange="previewImage()">
                            @error('image')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">
                        <i class="bi bi-save"></i> Selesai
                    </button>
                    </form>
                </div>
            </div>
            {{-- <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Paket telah sampai ke customer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/dashboard/pengiriman-paket/paket/{{ $paket->slug }}" method="post"
                        class="d-inline" enctype="multipart/form-data">
                        @method('put')
                        @csrf
                        <input type="hidden" name="selesai" id="selesai" value="1">
                        <div class="mb-3">
                            <input type="hidden" name="oldImage" value="{{ $paket->image }}">
                            @if ($paket->image)
                                <img src="{{ asset('storage/' . $paket->image) }}" class="img-preview img-fluid mb-3"
                                    width="79" height="108">
                            @else
                                <img class="img-preview img-fluid mb-3" width="79" height="108">
                            @endif
                            <input class="form-control @error('image') is-invalid @enderror" type="file" id="image"
                                name="image" onchange="previewImage()">
                            <label for="image" class="form-label">Maksimal ukuran image : 2MB</label>
                            @error('image')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" onclick="return confirm('Are you sure?')"> Selesai
                    </button>
                    </form>
                </div>
            </div> --}}
        </div>
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
