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
    <h2>Kurir Pengambilan Paket RAP-XPRESS - {{ $pickup->nama }}</h2>
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
    <div class="col-lg-5">
        <a href="/dashboard/pickup/{{ $pickup->id }}" class="btn btn-success"><i class="bi bi-arrow-left-circle"></i>
            Back</a>
        @if ($pickup->titik1 == 0 && $pickup->titik2 == 0 && $pickup->selesai == 0)
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                <i class="bi bi-plus-circle"></i>
                Add Item
            </button>
            <form action="/dashboard/pickup/kurir/{{ $pickup->id }}" class="d-inline" method="post">
                @method('put')
                @csrf
                <input type="hidden" name="titik1" value="1">
                <button type="submit" class="btn btn-primary" name="submit" onclick="return confirm('Are you sure?')"><i
                        class="bi bi-check"></i> Terima</button>
            </form>
            <p class="text-muted">Terima apabila Paket siap diambil oleh Kurir</p>
        @elseif($pickup->titik1 == 1 && $pickup->titik2 == 0 && $pickup->selesai == 0)
            <form action="/dashboard/pickup/kurir/{{ $pickup->id }}" class="d-inline" method="post">
                @method('put')
                @csrf
                <input type="hidden" name="titik1" value="0">
                <button type="submit" class="btn btn-danger" name="submit" onclick="return confirm('Are you sure?')"><i
                        class="bi bi-check"></i> Batal</button>
            </form>
            <p class="text-muted">Batalkan apabila Paket tidak jadi diambil oleh Kurir</p>
        @endif

        @if ($pickup->titik1 == 1 && $pickup->titik2 == 1 && $pickup->selesai == 0)
            <form action="/dashboard/pickup/selesai/{{ $pickup->id }}" class="d-inline" method="post">
                @method('put')
                @csrf
                <input type="hidden" name="selesai" value="1">
                <button type="submit" class="btn btn-danger" name="submit" onclick="return confirm('Are you sure?')"><i
                        class="bi bi-check"></i> Selesai</button>
            </form>
        @endif
    </div>

    <div class="table-responsive col-lg-15 mb-5">
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Kode Resi</th>
                    <th scope="col">Nama Barang</th>
                    <th scope="col">Jenis Pengiriman</th>
                    <th scope="col">Jumlah</th>
                    <th scope="col">Alamat</th>
                    <th scope="col">Keterangan</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if ($packages->count())
                    @foreach ($packages as $package)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $package->slug }}</td>
                            <td>{{ $package->nama }}</td>
                            <td>{{ $package->shipping->nama }} @if ($package->cod == 1)
                                    | COD (Cash on Delivery)
                                @endif
                            </td>
                            <td>{{ $package->jumlah }}</td>
                            <td>{{ $package->alamat }}</td>
                            <td>{{ $package->keterangan }}</td>
                            <td>
                                @if ($pickup->titik1 == 0 && $pickup->titik2 == 0 && $pickup->selesai == 0)
                                    <form action="/dashboard/pickup/paket/delete/{{ $package->slug }}" method="post"
                                        class="d-inline">
                                        @method('put')
                                        @csrf
                                        <button class="btn btn-danger" onclick="return confirm('Are you sure?')">
                                            <i class="bi bi-x-circle"></i> Delete
                                        </button>
                                    </form>
                                @elseif ($package->diambil == 1 && $package->selesai == 0)
                                    <a href="/dashboard/pengiriman/{{ $package->slug }}" class="btn btn-success btn-sm"
                                        target="_blank"><i class="bi bi-check"
                                            onclick="return confirm('Are you sure?')"></i>Selesai</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="8">
                            <p class="text-center fs-4">Tidak ada Paket</p>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>


    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Paket</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/dashboard/pickup/paket/{{ $pickup->id }}" method="post">
                        @method('put')
                        @csrf
                        <div class="mb-3">
                            <label for="id" class="form-label">Paket Tersedia :</label>
                            <select class="form-select @error('id') is-invalid @enderror" name="id">
                                @if ($paket->count())
                                    @foreach ($paket as $item)
                                        @if (old('id') == $item->id)
                                            <option value="{{ $item->id }}" selected>
                                                {{ $item->nama }} @if ($item->cod == 1)
                                                    | COD (Cash on Delivery)
                                                @endif
                                            </option>
                                        @else
                                            <option value="{{ $item->id }}">
                                                {{ $item->nama }} @if ($item->cod == 1)
                                                    | COD (Cash on Delivery)
                                                @endif
                                            </option>
                                        @endif
                                    @endforeach
                                @else
                                    <option value="0" selected>Tidak ada Paket</option>
                                @endif
                            </select>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Tambah</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
