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

    <div class="d-flex col-lg-5">
        <select name="kurir" id="kurir" class="form-select">
            <option>Pilih Kurir...</option>
            @foreach ($kurir as $item)
                <option value="{{ $item->id }}">{{ $item->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">DataTable with default features</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kurir</th>
                        <th>Paket Diambil</th>
                        <th>Paket Dikirim</th>
                        <th>Total Paket</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody id="data_table">
                    <tr align="CENTER">
                        <td colspan="6">Silahkan pilih data laporan</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Kurir</th>
                        <th>Paket Diambil</th>
                        <th>Paket Dikirim</th>
                        <th>Total Paket</th>
                        <th>Tanggal</th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->

    <script>
        $(function() {
            $.ajaxSetup({
                headeers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(function() {

                $('#kurir').on('change', function() {
                    let nama_kurir = $('#kurir').val();

                    console.log(nama_kurir);
                })
            });






        });
    </script>
@endsection
