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

        <div class="col-lg-5 d-flex">
            <form action="/dashboard/laporan" method="post">
                @csrf
                <label for="form-label">Pencarian data berdasarkan tanggal:</label>
                <input type="date" class="form-control" name="tanggal1">
                <input type="date" class="form-control" name="tanggal2">
                <button type="submit" class="btn btn-danger">Cari</button>
            </form>
        </div>

        <table id="example" class="table table-striped table-bordered display nowrap" style="100%">
            <thead>
                <tr align="CENTER">
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

    {{-- DATA TABLES --}}
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#example').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });
        });
    </script>

@endsection
