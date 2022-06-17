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
    <div class="col-lg-5">
        <a href="/dashboard/pickup" class="btn btn-success"><i class="bi bi-arrow-left-circle"></i> Back</a>
        @if ($pickup->titik1 == 0 && $pickup->titik2 == 0 && $pickup->selesai == 0)
            <a href="/dashboard/pickup/{{ $pickup->id }}/edit" class="btn btn-warning"><i class="bi bi-pencil"></i>
                Edit</a>
            @if (!$packages->count())
                <form action="/dashboard/pickup/{{ $pickup->id }}" method="post" class="d-inline">
                    @method('delete')
                    @csrf
                    <button class="btn btn-danger" onclick="return confirm('Are you sure?')">
                        <i class="bi bi-x-circle"></i> Delete
                    </button>
                </form>
            @endif
        @endif

        <a href="/dashboard/pickup/paket/{{ $pickup->id }}" class="btn btn-primary"><i class="bi bi-eye"></i>
            Check</a>
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
                    <td>Kode Kurir</td>
                    <td>: {{ $pickup->nama }}</td>
                </tr>
                <tr>
                    <td>Driver</td>
                    <td>: {{ $pickup->author->name }}</td>
                </tr>
                <tr>
                    <td>Daerah</td>
                    <td>: {{ $pickup->alamat }}</td>
                </tr>
                <tr>
                    <td>Paket yang diambil</td>
                    <td>
                        @foreach ($packages as $package)
                            <li>{{ $package->nama }}</li>
                        @endforeach
                    </td>
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
                    <td>: @if ($pickup->titik1 == 0 && $pickup->titik2 == 0 && $pickup->selesai == 0)
                            <a href="#" class="btn btn-primary btn-sm">Belum di Proses</a>
                        @elseif ($pickup->titik1 == 1 && $pickup->titik2 == 0 && $pickup->selesai == 0)
                            <a href="#" class="btn btn-primary btn-sm">Proses</a>
                        @elseif ($pickup->titik1 == 1 && $pickup->titik2 == 1 && $pickup->selesai == 0)
                            <a href="#" class="btn btn-primary btn-sm">Proses</a>
                        @elseif ($pickup->titik1 == 1 && $pickup->titik2 == 1 && $pickup->selesai == 1)
                            <a href="#" class="btn btn-success btn-sm">Selesai</a>
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

@endsection
