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
    <h2>Paket yang telah diterima!</h2>

    <div class="row justify-content-start mb-3">
        <div class="col-lg-3">
            <form action="/dashboard/pengiriman" method="get">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Search.." name="search" id="search">
                    <button class="btn btn-outline-light btn-danger" type="submit"><i class="bi bi-search"></i></button>
                </div>
            </form>
        </div>
    </div>

    <div class="table-responsive col-lg-15 mb-5">
        <div class="d-flex justify-content-end">
            {{ $requests->links() }}
        </div>
        <table class="table table-striped table-sm">
            <thead>
                <tr align="center">
                    <th scope="col">No</th>
                    <th scope="col">Pemohon</th>
                    {{-- <th scope="col">Nama Penerima</th> --}}
                    {{-- <th scope="col">Nomor Penerima</th> --}}
                    <th scope="col">Nama Barang</th>
                    <th scope="col">Jenis Pengiriman</th>
                    {{-- <th scope="col">Jumlah</th> --}}
                    <th scope="col">Alamat</th>
                    {{-- <th scope="col">Kurir</th> --}}
                    {{-- <th scope="col">Keterangan</th> --}}
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if ($requests->count())
                    @foreach ($requests as $request)
                        @php
                            $courier = App\Models\Courier::getCourierByCourierId($request->courier_id);
                            $pickup = App\Models\PickUp::getPickUpByPickUpId($request->pick_up_id);
                        @endphp
                        <tr>
                            <th align="CENTER">{{ $requests->firstItem() - 1 + $loop->iteration }}</th>
                            <td><b>{{ $request->namapemohon }}</b></td>
                            {{-- <td>{{ $request->namapenerima }}</td> --}}
                            {{-- <td>
                                <a href="https://wa.me/62{{ $request->no_hp }}" class="text-decoration-none text-black"
                                    target="_blank">
                                    +62{{ $request->no_hp }}
                                </a>
                            </td> --}}
                            <td>{{ $request->nama }}</td>
                            <td>{{ $request->shipping->nama }} @if ($request->cod == 1)
                                    | COD (Cash on Delivery)
                                @endif
                            </td>
                            {{-- <td align="CENTER">{{ $request->jumlah }}</td> --}}
                            <td>{{ $request->alamat }}</td>
                            {{-- <td>
                                @if ($request->courier_id)
                                    {{ $courier->author->name }}
                                @else
                                    Kurir belum dipilih
                                @endif
                            </td> --}}
                            {{-- <td>{{ $request->keterangan }}</td> --}}
                            <td>
                                <a href="/dashboard/pengiriman/{{ $request->slug }}" class="btn btn-danger btn-sm">
                                    <i class="bi bi-eye"></i> Lihat
                                </a>
                                @if ($request->terima == 0 && $request->diambil == 0 && $request->selesai == 0)
                                    <a href="#" class="btn btn-primary btn-sm">Belum di Proses</a>
                                @elseif ($request->terima == 1 && $request->diambil == 0 && $request->selesai == 0)
                                    <a href="#" class="btn btn-primary btn-sm">Proses</a>
                                @elseif ($request->terima == 1 && $request->diambil == 1 && $request->selesai == 0)
                                    <a href="#" class="btn btn-primary btn-sm">Proses</a>
                                @elseif ($request->terima == 1 && $request->diambil == 1 && $request->selesai == 1)
                                    <a href="#" class="btn btn-success btn-sm">Selesai</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="6">
                            <p class="text-center fs-4">Tidak ada Paket</p>
                        </td>
                    </tr>
                @endif

            </tbody>
        </table>
    </div>

@endsection
