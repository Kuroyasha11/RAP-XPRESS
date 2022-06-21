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

    <div class="table-responsive col-lg-15 mb-5">
        <div class="d-flex justify-content-between">
            {{ $paket->links() }}
        </div>

        <div class="col-lg-5 d-flex justify-content-between">
            <form action="/dashboard/laporan" method="post">
                @csrf
                <label for="form-label">Pencarian data berdasarkan tanggal:</label>
                <input type="date" class="form-control" name="tanggal1">
                <input type="date" class="form-control" name="tanggal2">
                <button type="submit" class="btn btn-danger">Cari</button>
            </form>
            <form action="/dashboard/laporan" method="get">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Cari Kurir.." name="search" id="search">
                    <button class="btn btn-outline-light btn-danger" type="submit"><i class="bi bi-search"></i></button>
                </div>
            </form>
        </div>

        <table class="table table table-striped table-bordered display" id="datatable">
            <thead>
                <tr align="center">
                    <th scope="col">No</th>
                    <th scope="col">Paket</th>
                    <th scope="col">Kurir Pengambilan</th>
                    <th scope="col">Kurir Pengiriman</th>
                    <th scope="col">Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @if ($paket->count())
                    @foreach ($paket as $item)
                        @php
                            $pickup = App\Models\PickUp::getPickUpByPickUpId($item->pick_up_id);
                            $courier = App\Models\Courier::getCourierByCourierId($item->courier_id);
                        @endphp
                        <tr align="CENTER">
                            <th class="text-center">{{ $loop->iteration }}
                            </th>
                            <td>{{ $item->nama }}</td>
                            <td>
                                @if ($pickup)
                                    {{ $pickup->author->name }}
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ $courier->author->name }}</td>
                            <td>
                                {{ $item->created_at->isoFormat('dddd, DD MMMM Y') }}
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5">
                            <p class="text-center fs-4">Tidak ada Laporan Paket Tersedia</p>
                        </td>
                    </tr>
                @endif

            </tbody>
        </table>
    </div>

@endsection
