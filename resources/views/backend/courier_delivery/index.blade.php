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
    <h2>{{ auth()->user()->name }}</h2>
    <div class="row justify-content-start mb-3">
        <div class="col-lg-3">
            <form action="/dashboard/pengiriman-paket" method="get">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Search.." name="search" id="search">
                    <button class="btn btn-outline-light btn-danger" type="submit"><i class="bi bi-search"></i></button>
                </div>
            </form>
        </div>
    </div>
    <div class="table-responsive col-lg-15 mb-5">
        <div class="d-flex justify-content-end">
            {{ $couriers->links() }}
        </div>
        <table class="table table-striped table-sm">
            <thead>
                <tr align="center">
                    <th scope="col">No</th>
                    <th scope="col">Kode Kurir</th>
                    {{-- <th scope="col">Kurir</th> --}}
                    <th scope="col">Daerah</th>
                    {{-- <th scope="col">Paket</th> --}}
                    <th scope="col">Jumlah</th>
                    <th scope="col">Keterangan</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if ($couriers->count())
                    @foreach ($couriers as $courier)
                        @php
                            $packages = App\Models\Package::getPackageByCourierIdindex($courier->id);
                        @endphp
                        <tr>
                            <th class="text-center">{{ $couriers->firstItem() - 1 + $loop->iteration }}
                            </th>
                            <td>{{ $courier->nama }}</td>
                            {{-- <td><b>{{ $courier->author->name }}</b></td> --}}
                            <td>{{ $courier->alamat }}</td>
                            {{-- <td>
                                <ul>
                                    @foreach ($packages as $package)
                                        <li>{{ $package->nama }}</li>
                                    @endforeach
                                </ul>
                            </td> --}}
                            <td align="center">
                                @if ($packages->count())
                                    {{ $packages->count() }}
                                @else
                                    <p class="text-center">Tidak ada Paket</p>
                                @endif
                            </td>
                            <td align="center">
                                @if ($courier->titik1 == 0 && $courier->titik2 == 0 && $courier->selesai == 0)
                                    <p class="btn btn-primary">Belum di Proses</p>
                                @elseif ($courier->titik1 == 1 && $courier->titik2 == 0 && $courier->selesai == 0)
                                    <p class="btn btn-primary">Proses</p>
                                @elseif ($courier->titik1 == 1 && $courier->titik2 == 1 && $courier->selesai == 0)
                                    <p class="btn btn-primary">Proses</p>
                                @elseif ($courier->titik1 == 1 && $courier->titik2 == 1 && $courier->selesai == 1)
                                    <p class="btn btn-success">Selesai</p>
                                @endif
                            </td>
                            <td>
                                <a href="/dashboard/pengiriman-paket/{{ $courier->id }}" class="btn btn-danger btn-sm">
                                    <i class="bi bi-eye"></i> Lihat
                                </a>
                                @if ($courier->selesai == 1)
                                    <a href="#" class="btn btn-success btn-sm">Selesai</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="6">
                            <p class="text-center fs-4">Tidak ada Paket tersedia</p>
                        </td>
                    </tr>
                @endif

            </tbody>
        </table>
    </div>

@endsection
