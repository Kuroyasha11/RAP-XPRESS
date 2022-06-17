@extends('backend.layouts.main')

@section('container')
    {{-- <h1 class="mb-3">{{ $package->nama }}</h1> --}}
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
        <a href="/dashboard/paket" class="btn btn-success"><i class="bi bi-arrow-left-circle"></i> Back</a>
        @if ($package->terima == 0 && $package->diambil == 0 && $package->selesai == 0)
            <a href="/dashboard/paket/{{ $package->slug }}/edit" class="btn btn-warning"><i class="bi bi-pencil"></i>
                Edit</a>
            <form action="/dashboard/paket/{{ $package->slug }}" method="post" class="d-inline">
                @method('delete')
                @csrf
                <button class="btn btn-danger" onclick="return confirm('Are you sure?')">
                    <i class="bi bi-x-circle"></i> Delete
                </button>
            </form>
        @elseif ($package->terima == 1 && $package->diambil == 0 && $package->selesai == 0)
            <a href="/dashboard/paket/resi/{{ $package->slug }}" class="btn btn-danger" target="_blank">
                <i class="bi bi-printer"></i> PRINT</a>
            <label for="text-muted">Note: Kertas A6</label>
        @endif
        <p class="text-muted">Apabila paket ingin dibatalkan silahkan hubungin wa admin yang ada dibagian bawah website.
            Terima Kasih</p>
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
                    <td>: @if ($package->terima == 0)
                            -
                        @else
                            <div class="d-flex justify-content-center">
                                <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($package->slug, 'C39', 1, 35) }}"
                                    alt="{{ $package->slug }}" />
                            </div>
                            <div class="d-flex justify-content-center">
                                <strong>{{ $package->slug }}</strong>
                            </div>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Nama Penerima</td>
                    <td>: {{ $package->namapenerima }}</td>
                </tr>
                <tr>
                    <td>Nomor Penerima</td>
                    <td>: <a href="https://wa.me/62{{ $package->no_hp }}" class="text-decoration-none text-black"
                            target="_blank">
                            +62{{ $package->no_hp }}
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>Paket</td>
                    <td>: {{ $package->nama }}</td>
                </tr>
                <tr>
                    <td>Jumlah</td>
                    <td>: {{ $package->jumlah }}</td>
                </tr>
                <tr>
                    <td>Harga Paket</td>
                    <td>: @IDR($package->hargapaket)</td>
                </tr>
                <tr>
                    <td>Alamat Tujuan</td>
                    <td>: {{ $package->alamat }} <a href="https://www.google.com/maps/place/{{ $package->alamat }}"
                            class=" btn btn-success text-decoration-none text-black" target="_blank">
                            <i class="bi bi-geo-alt-fill"></i> MAP
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>Keterangan</td>
                    <td>: {{ $package->keterangan }}</td>
                </tr>
                <tr>
                    <td>Kelas Pengiriman</td>
                    <td>: {{ $package->shipping->nama }} @if ($package->cod == 1)
                            | COD (Cash On Delivery)
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Ongkos Pengiriman</td>
                    <td>: @IDR($package->shipping->harga)</td>
                </tr>
                @if ($package->cod)
                    <tr>
                        <td>Olshop menerima pembayaran dari Kurir</td>
                        <td>: <b>@IDR($package->shipping->harga + $package->hargapaket)</b></td>
                    </tr>
                @else
                    <tr>
                        <td><b>Total yang harus dibayar ke kurir</b></td>
                        <td>: <b>@IDR($package->shipping->harga)</b></td>
                    </tr>
                @endif
                <tr>
                    <td>Kurir Pengambil</td>
                    <td>: @if ($pickup)
                            {{ $pickup->author->name }}
                        @else
                            Kurir belum dipilih
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Kurir Pengantar</td>
                    <td>: @if ($courier)
                            {{ $courier->author->name }}
                        @else
                            Kurir belum dipilih
                        @endif
                    </td>
                </tr>
                @if ($package->selesai == 1)
                    <tr>
                        <td> Foto</td>
                        <td>: <div class="mb-3">
                                <img src="{{ asset('storage/' . $package->image) }}" class="img-preview img-fluid mb-3"
                                    width="350" height="500">
                            </div>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
@endsection
