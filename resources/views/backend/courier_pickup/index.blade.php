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
            <form action="/dashboard/pengambilan-paket" method="get">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Search.." name="search" id="search">
                    <button class="btn btn-outline-light btn-danger" type="submit"><i class="bi bi-search"></i></button>
                </div>
            </form>
        </div>
    </div>
    <div class="table-responsive col-lg-15 mb-5">
        <div class="d-flex justify-content-end">
            {{ $pickup->links() }}
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
                @if ($pickup->count())
                    @foreach ($pickup as $pick)
                        @php
                            $packages = App\Models\Package::getPackageByPickUpIdindex($pick->id);
                        @endphp
                        <tr>
                            <th class="text-center">{{ $pickup->firstItem() - 1 + $loop->iteration }}
                            </th>
                            <td>{{ $pick->nama }}</td>
                            {{-- <td><b>{{ $pick->author->name }}</b></td> --}}
                            <td>{{ $pick->alamat }}</td>
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
                                @if ($pick->titik1 == 0 && $pick->titik2 == 0 && $pick->selesai == 0)
                                    <p class="btn btn-primary">Belum di Proses</p>
                                @elseif ($pick->titik1 == 1 && $pick->titik2 == 0 && $pick->selesai == 0)
                                    <p class="btn btn-primary">Proses</p>
                                @elseif ($pick->titik1 == 1 && $pick->titik2 == 1 && $pick->selesai == 0)
                                    <p class="btn btn-primary">Proses</p>
                                @elseif ($pick->titik1 == 1 && $pick->titik2 == 1 && $pick->selesai == 1)
                                    <p class="btn btn-success">Selesai</p>
                                @endif
                            </td>
                            <td>
                                <a href="/dashboard/pengambilan-paket/{{ $pick->id }}" class="btn btn-danger btn-sm">
                                    <i class="bi bi-eye"></i> Lihat
                                </a>
                                {{-- @if ($pick->selesai == 1)
                                    <a href="#" class="btn btn-success btn-sm">Selesai</a>
                                @endif --}}
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
