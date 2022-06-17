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
    <h2>Request Kurir RAP-XPRESS</h2>
    <div class="row justify-content-start mb-3">
        <div class="col-lg-3">
            <form action="/dashboard/paket" method="get">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Search.." name="search" id="search">
                    <button class="btn btn-outline-light btn-danger" type="submit"><i class="bi bi-search"></i></button>
                </div>
            </form>
        </div>
    </div>
    <div class="text-muted my-3"><strong>Note : Apabila paket telah diproses, silahkan print resi dan
            persiapkan paket. Kurir akan datang ambil paket segera. Hub: Admin via WA untuk info lebih
            lanjut.</strong></div>
    <div class="col-lg-5">
        <div class="d-flex justify-content-between">
            <a href="/dashboard/paket/create" class="btn btn-success"><i class="bi bi-plus-circle"></i> Request</a>
            {{ $packages->links() }}
        </div>
    </div>
    <div class="table-responsive col-lg-15 mb-5">
        <table class="table table-striped table-sm">
            <thead>
                <tr align="CENTER">
                    <th scope="col">No</th>
                    <th scope="col">Nomor Resi</th>
                    <th scope="col">Nama Penerima</th>
                    {{-- <th scope="col">Nomor Penerima</th> --}}
                    <th scope="col">Nama Barang</th>
                    <th scope="col">Jenis Pengiriman</th>
                    {{-- <th scope="col">Jumlah</th> --}}
                    {{-- <th scope="col">Harga</th> --}}
                    {{-- <th scope="col">Alamat</th> --}}
                    {{-- <th scope="col">Keterangan</th> --}}
                    <th scope="col">Kurir Pengambil</th>
                    <th scope="col">Kurir Pengirim</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if ($packages->count())
                    @foreach ($packages as $package)
                        @php
                            $courier = App\Models\Courier::getCourierByCourierId($package->courier_id);
                            $pickup = App\Models\PickUp::getPickUpByPickUpId($package->pick_up_id);
                        @endphp
                        <tr>
                            <td>{{ $packages->firstItem() - 1 + $loop->iteration }}</td>
                            @if ($package->terima == 1)
                                <td align="CENTER">{{ $package->slug }}</td>
                            @else
                                <td align="CENTER"> - </td>
                            @endif
                            <td>{{ $package->namapenerima }}</td>
                            {{-- <td><a href="https://wa.me/62{{ $package->no_hp }}" class="text-decoration-none text-black"
                                    target="_blank">
                                    +62{{ $package->no_hp }}
                                </a>
                            </td> --}}
                            <td>{{ $package->nama }}</td>
                            <td>{{ $package->shipping->nama }} @if ($package->cod == 1)
                                    | COD (Cash on Delivery)
                                @endif
                            </td>
                            {{-- <td align="CENTER">{{ $package->jumlah }}</td> --}}
                            {{-- <td align="END">{{ $package->hargapaket }}</td> --}}
                            {{-- <td>{{ $package->alamat }}</td> --}}
                            {{-- <td>{{ $package->keterangan }}</td> --}}
                            <td>
                                @if ($pickup)
                                    {{ $pickup->author->name }}
                                @else
                                    Kurir belum dipilih
                                @endif
                            </td>
                            <td>
                                @if ($courier)
                                    {{ $courier->author->name }}
                                @else
                                    Kurir belum dipilih
                                @endif
                            </td>
                            <td>
                                <a href="/dashboard/paket/{{ $package->slug }}" class="btn btn-danger">
                                    <i class="bi bi-eye"></i> Lihat
                                </a>
                                @if ($package->terima == 0 && $package->diambil == 0 && $package->selesai == 0)
                                    <a href="#" class="btn btn-primary">Belum di Proses</a>
                                @elseif ($package->terima == 1 && $package->diambil == 0 && $package->selesai == 0)
                                    <a href="#" class="btn btn-primary">Proses</a>
                                @elseif ($package->terima == 1 && $package->diambil == 1 && $package->selesai == 0)
                                    <a href="#" class="btn btn-primary">Proses</a>
                                @elseif ($package->terima == 1 && $package->diambil == 1 && $package->selesai == 1)
                                    <a href="#" class="btn btn-success">Selesai</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="8">
                            <p class="text-center fs-4">Tidak ada Paket</p>
                        </td>
                    </tr>
                @endif

            </tbody>
        </table>
    </div>


@endsection
