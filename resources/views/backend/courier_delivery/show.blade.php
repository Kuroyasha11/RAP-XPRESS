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
    <h2>Kurir Pengiriman Paket RAP-XPRESS - {{ $kurir->nama }}</h2>
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
                    <td>Kode Kurir</td>
                    <td>: {{ $kurir->nama }}</td>
                </tr>
                <tr>
                    <td>Driver</td>
                    <td>: {{ $kurir->author->name }}</td>
                </tr>
                <tr>
                    <td>Daerah</td>
                    <td>: {{ $kurir->alamat }}</td>
                </tr>
                <tr>
                    <td>Jumlah</td>
                    <td>: @if ($packages->count())
                            {{ $packages->count() }}
                        @else
                            Tidak ada Paket
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Keterangan</td>
                    <td>: @if ($kurir->titik1 == 0 && $kurir->titik2 == 0 && $kurir->selesai == 0)
                            <a href="#" class="btn btn-primary btn-sm">Belum di Proses</a>
                        @elseif ($kurir->titik1 == 1 && $kurir->titik2 == 0 && $kurir->selesai == 0)
                            <a href="#" class="btn btn-primary btn-sm">Proses</a>
                        @elseif ($kurir->titik1 == 1 && $kurir->titik2 == 1 && $kurir->selesai == 0)
                            <a href="#" class="btn btn-primary btn-sm">Proses</a>
                        @elseif ($kurir->titik1 == 1 && $kurir->titik2 == 1 && $kurir->selesai == 1)
                            <a href="#" class="btn btn-success btn-sm">Selesai</a>
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="col-lg-5">
        <a href="/dashboard/pengiriman-paket" class="btn btn-success"><i class="bi bi-arrow-left-circle"></i> Back</a>

        @if ($kurir->titik1 == 1 && $kurir->titik2 == 0 && $kurir->selesai == 0)
            <form action="/dashboard/pengiriman-paket/{{ $kurir->id }}" class="d-inline" method="post">
                @method('put')
                @csrf
                <input type="hidden" name="titik2" value="1">
                <button type="submit" class="btn btn-danger" name="submit" onclick="return confirm('Are you sure?')"><i
                        class="bi bi-check"></i> Selesai</button>
            </form>
        @endif
    </div>
    <div class="table-responsive col-lg-15 mb-5">
        <table class="table table-sm">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Resi</th>
                    <th scope="col">Nama Penerima</th>
                    {{-- <th scope="col">Nomor Penerima</th> --}}
                    <th scope="col">Nama Barang</th>
                    <th scope="col">Jenis Pengiriman</th>
                    <th scope="col">Jumlah</th>
                    {{-- <th scope="col">Alamat</th> --}}
                    {{-- <th scope="col">Keterangan</th> --}}
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if ($packages->count())
                    @foreach ($packages as $package)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <div class="d-flex justify-content-center">
                                    <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($package->slug, 'C39', 1, 35) }}"
                                        alt="{{ $package->slug }}" />
                                </div>
                                <div class="d-flex justify-content-center">
                                    <strong>{{ $package->slug }}</strong>
                                </div>
                            </td>
                            <td>{{ $package->namapenerima }}</td>
                            {{-- <td>
                                <a href="https://wa.me/62{{ $package->no_hp }}" class="text-decoration-none text-black"
                                    target="_blank">
                                    +62{{ $package->no_hp }}
                                </a>
                            </td> --}}
                            <td>{{ $package->nama }}</td>
                            <td>{{ $package->shipping->nama }} @if ($package->cod == 1)
                                    | COD (Cash on Delivery)
                                @endif
                            </td>
                            <td>{{ $package->jumlah }}</td>
                            {{-- <td>{{ $package->alamat }}</td> --}}
                            {{-- <td>{{ $package->keterangan }}</td> --}}
                            <td>
                                <a href="/dashboard/pengiriman-paket/paket/{{ $package->slug }}"
                                    class="btn btn-danger btn-sm">
                                    <i class="bi bi-eye"></i> Lihat
                                </a>
                                @if ($package->selesai == 1)
                                    <a href="#" class="btn btn-success btn-sm"><i class="bi bi-check"></i> Selesai</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="7">
                            <p class="text-center fs-4">Tidak ada Paket</p>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>


@endsection
