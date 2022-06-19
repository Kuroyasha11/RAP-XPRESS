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
        <table class="table table table-striped table-bordered" id="example">
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
                            <td>{{ $item->created_at }}</td>
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

    <script type="text/javascript">
        //fungsi untuk filtering data berdasarkan tanggal 
        var start_date;
        var end_date;
        var DateFilterFunction = (function(oSettings, aData, iDataIndex) {
            var dateStart = parseDateValue(start_date);
            var dateEnd = parseDateValue(end_date);
            //Kolom tanggal yang akan kita gunakan berada dalam urutan 2, karena dihitung mulai dari 0
            //nama depan = 0
            //nama belakang = 1
            //tanggal terdaftar =2
            var evalDate = parseDateValue(aData[2]);
            if ((isNaN(dateStart) && isNaN(dateEnd)) ||
                (isNaN(dateStart) && evalDate <= dateEnd) ||
                (dateStart <= evalDate && isNaN(dateEnd)) ||
                (dateStart <= evalDate && evalDate <= dateEnd)) {
                return true;
            }
            return false;
        });

        // fungsi untuk converting format tanggal dd/mm/yyyy menjadi format tanggal javascript menggunakan zona aktubrowser
        function parseDateValue(rawDate) {
            var dateArray = rawDate.split("/");
            var parsedDate = new Date(dateArray[2], parseInt(dateArray[1]) - 1, dateArray[
                0]); // -1 because months are from 0 to 11   
            return parsedDate;
        }

        $(document).ready(function() {
            //konfigurasi DataTable pada tabel dengan id example dan menambahkan  div class dateseacrhbox dengan dom untuk meletakkan inputan daterangepicker
            var $dTable = $('#example').DataTable({
                "dom": "<'row'<'col-sm-4'l><'col-sm-5' <'datesearchbox'>><'col-sm-3'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>"
            });

            //menambahkan daterangepicker di dalam datatables
            $("div.datesearchbox").html(
                '<div class="input-group"> <div class="input-group-addon"> <i class="glyphicon glyphicon-calendar"></i> </div><input type="text" class="form-control pull-right" id="datesearch" placeholder="Search by date range.."> </div>'
            );

            document.getElementsByClassName("datesearchbox")[0].style.textAlign = "right";

            //konfigurasi daterangepicker pada input dengan id datesearch
            $('#datesearch').daterangepicker({
                autoUpdateInput: false
            });

            //menangani proses saat apply date range
            $('#datesearch').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format(
                    'DD/MM/YYYY'));
                start_date = picker.startDate.format('DD/MM/YYYY');
                end_date = picker.endDate.format('DD/MM/YYYY');
                $.fn.dataTableExt.afnFiltering.push(DateFilterFunction);
                $dTable.draw();
            });

            $('#datesearch').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
                start_date = '';
                end_date = '';
                $.fn.dataTable.ext.search.splice($.fn.dataTable.ext.search.indexOf(DateFilterFunction, 1));
                $dTable.draw();
            });
        });
    </script>

@endsection
