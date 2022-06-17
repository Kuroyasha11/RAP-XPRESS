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
        <a href="/dashboard/pengambilan-paket/{{ $paket->pick_up_id }}" class="btn btn-success"><i
                class="bi bi-arrow-left-circle"></i> Back</a>
        @if ($paket->diambil == 0 && $paket->selesai == 0)
            @if ($pickup)
                @if ($pickup->titik1 == 1 && $pickup->titik2 == 0 && $pickup->selesai == 0)
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
                    <td>Nama Pemohon/Toko</td>
                    <td>: {{ $paket->author->name }}</td>
                </tr>
                <tr>
                    <td>Nomor Pemohon/Toko </td>
                    <td>: <a href="https://wa.me/62{{ $user->account->wa }}" class="text-decoration-none text-black"
                            target="_blank">
                            +62{{ $user->account->wa }}
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
                    <td>Alamat Pengambilan</td>
                    <td>: {{ $user->account->alamat }} <a
                            href="https://www.google.com/maps/place/{{ $user->account->alamat }}"
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
                    <td>: @if ($pickup)
                            {{ $pickup->author->name }}
                        @else
                            Kurir belum dipilih
                        @endif

                    </td>
                </tr>
                @if ($paket->cod)
                    <tr>
                        <td><b>Total COD</b> <label class="text-muted">Kurir membayar ke Olshop, dan Kurir menerima
                                pembayaran dari Admin</label></td>
                        <td>: <b>@IDR($paket->shipping->harga + $paket->hargapaket)</b></td>
                    </tr>
                @else
                    <tr>
                        <td><b>Total yang harus diterima kurir dari olshop dan disetor ke Admin</b></td>
                        <td>: <b>@IDR($paket->shipping->harga)</b></td>
                    </tr>
                @endif
                @if ($paket->diambil == 1)
                    <tr>
                        <td> Foto</td>
                        <td>: <div class="mb-3">
                                <img src="{{ asset('storage/' . $paket->foto) }}" class="img-preview img-fluid mb-3"
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
                    <h5 class="modal-title" id="staticBackdropLabel">Paket telah diambil dari Olshop</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/dashboard/pengambilan-paket/paket/{{ $paket->slug }}" method="post"
                        class="mb-5" enctype="multipart/form-data">
                        @method('put')
                        @csrf
                        <div class="mb-3">
                            {{-- <label for="diambil" class="form-label">Diambil</label> --}}
                            <input class="form-control" type="hidden" name="diambil" id="diambil" placeholder="diambil"
                                value="1">
                        </div>
                        <div class="mb-3">
                            <input type="hidden" name="oldImage" value="{{ $paket->foto }}">
                            @if ($paket->foto)
                                <img src="{{ asset('storage/' . $paket->foto) }}" class="img-preview img-fluid mb-3"
                                    width="300" height="450">
                            @else
                                <img class="img-preview img-fluid mb-3" width="300" height="450">
                            @endif
                            <input class="form-control @error('foto') is-invalid @enderror" type="file" id="foto"
                                name="foto" onchange="previewImage()">
                            @error('foto')
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
                    <form action="/dashboard/pengambilan-paket/paket/{{ $paket->slug }}" method="post"
                        class="d-inline" enctype="multipart/form-data">
                        @method('put')
                        @csrf
                        <input type="hidden" name="diambil" id="diambil" value="1">
                        <div class="mb-3">
                            <input type="hidden" name="oldImage" value="{{ $paket->foto }}">
                            @if ($paket->foto)
                                <img src="{{ asset('storage/' . $paket->foto) }}" class="img-preview img-fluid mb-3"
                                    width="79" height="108">
                            @else
                                <img class="img-preview img-fluid mb-3" width="79" height="108">
                            @endif
                            <input class="form-control @error('foto') is-invalid @enderror" type="file" id="foto"
                                name="foto" onchange="previewImage()">
                            <label for="foto" class="form-label">Maksimal ukuran foto : 2MB</label>
                            @error('foto')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')"> Selesai
                    </button>
                    </form>
                </div>
            </div> --}}
        </div>
    </div>

    <script>
        function previewImage() {
            const foto = document.querySelector('#foto');
            const imgPreview = document.querySelector('.img-preview');

            imgPreview.style.display = 'block';

            const oFReader = new FileReader();
            oFReader.readAsDataURL(foto.files[0]);

            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result;
            }

        }
    </script>
@endsection
