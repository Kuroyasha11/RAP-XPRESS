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
                <tbody>
                    <tr align="CENTER">
                        <td>1</td>
                        <td align="LEFT">Ricky Andrean</td>
                        <td>2</td>
                        <td>5</td>
                        <td>7</td>
                        <td>12 Juni 2022 - 18 Juni 2022</td>
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

    {{-- <script>
        $(function (){
            $.ajaxSetup({
                headeers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            })
        })
    </script> --}}
@endsection
