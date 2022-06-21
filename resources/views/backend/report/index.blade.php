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
        <div class="col-lg-5" id="date_filter">
            <span id="date-label-from" class="date-label">Tanggal Awal : </span> <input type="text"
                class="data_tange_filter" id="datepicker_from">
            <br>
            <span id="date-label-to" class="date-label">Tanggal Akhir : </span> <input type="text"
                class="data_tange_filter" id="datepicker_to">
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
                                    {{ $pickup->nama }}
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ $courier->nama }}</td>
                            <td>
                                {{ $item->created_at->isoFormat('DD/MM/Y') }}
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

    <script src="/assets/datatables/script.js"></script>

@endsection
