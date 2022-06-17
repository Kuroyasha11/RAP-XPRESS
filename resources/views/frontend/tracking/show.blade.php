@extends('frontend.layouts.main')

@section('container')
    <div class="row">
        <h1 class="text-center mb-5">Paket {{ $package->nama }}</h1>

        <div class="container">
            <div class="row">
                @auth
                    @can('admin')
                        <a href="/dashboard/pengiriman/{{ $package->slug }}" class="btn btn-danger">CEK</a>
                    @elsecan('mitra')
                        @if (auth()->user()->partner_id == 1)
                            {{-- Kurir --}}
                            @if ($courier)
                                @if ($package->terima == 1 && $courier->titik1 == 1)
                                    <a href="/dashboard/cek-paket/paket/{{ $package->slug }}" class="btn btn-danger">CEK</a>
                                @endif
                            @endif
                        @elseif (auth()->user()->partner_id == 2)
                            {{-- Olshop --}}
                            <a href="/dashboard/paket/{{ $package->slug }}" class="btn btn-danger">CEK</a>
                        @endif
                    @endcan
                @endauth
                {{-- @if (auth()->user()->is_admin == 1)
                @elseif (auth()->user()->is_mitra == 1)
                    @if (auth()->user()->partner_id == 1) --}}
                {{-- Kurir --}}
                {{-- @if ($courier)
                            @if ($package->terima == 1 && $courier->titik1 == 1)
                                <a href="/dashboard/cek-paket/paket/{{ $package->slug }}" class="btn btn-danger">CEK</a>
                            @endif
                        @endif
                    @elseif (auth()->user()->partner_id == 2) --}}
                {{-- Olshop --}}
                {{-- <a href="/dashboard/paket/{{ $package->slug }}" class="btn btn-danger">CEK</a>
                    @endif
                @endif --}}
                <table class="table mt-3">
                    <thead>
                        <tr align="center">
                            <th scope="col">Data</th>
                            <th scope="col">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Pemohon</td>
                            <td>: <strong>{{ $package->author->name }}</strong></td>
                        </tr>
                        <tr>
                            <td>Pemohon</td>
                            <td>: <strong>{{ $package->namapenerima }}</strong></td>
                        </tr>
                        <tr>
                            <td>Paket</td>
                            <td>: {{ $package->nama }}</td>
                        </tr>
                        <tr>
                            <td>Jumlah</td>
                            <td>: {{ $package->jumlah }}</td>
                        </tr>
                        {{-- <tr>
                            <td>Alamat Tujuan</td>
                            <td>: {{ $package->alamat }}</td>
                        </tr> --}}
                        <tr>
                            <td>Keterangan</td>
                            <td>: {{ $package->keterangan }}</td>
                        </tr>
                        <tr>
                            <td>Kelas Pengiriman</td>
                            <td>: {{ $package->shipping->nama }} @if ($package->cod == 1)
                                    | COD (Cash On Delivery)
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>Ongkos Pengiriman</td>
                            <td>: @IDR($package->shipping->harga)</td>
                        </tr>
                        @if ($package->cod)
                            <tr>
                                <td><b>Total COD</b></td>
                                <td>: <b>@IDR($package->shipping->harga + $package->hargapaket)</b></td>
                            </tr>
                            {{-- @else
                            <tr>
                                <td><b>Total yang harus diterima kurir dari olshop</b></td>
                                <td>: <b>@IDR($package->shipping->harga)</b></td>
                            </tr> --}}
                        @endif
                        <tr>
                            <td>Kurir yang mengantar</td>
                            <td>:
                                @if ($courier)
                                    {{ $courier->author->name }}
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Lokasi Paket Anda </strong></td>
                            <td>: @if (!$package->pick_up_id && !$package->courier_id)
                                    <a href="#" class="btn btn-primary btn-sm">Belum diproses</a>
                                @elseif ($package->pick_up_id && !$package->courier_id)
                                    @if ($pickup->titik1 == 0 && $package->diambil == 0)
                                        <a href="#" class="btn btn-primary btn-sm">Belum diproses</a>
                                    @elseif ($pickup->titik1 == 1 && $package->diambil == 0)
                                        <a href="#" class="btn btn-primary btn-sm">Proses</a>
                                    @elseif ($pickup->titik1 == 1 && $package->diambil == 1)
                                        <a href="#" class="btn btn-primary btn-sm">Paket telah diambil dari Olshop, dan
                                            berada di Gudang pengiriman</a>
                                    @endif
                                @elseif ($package->pick_up_id && $package->courier_id)
                                    @if ($courier->titik1 == 0 && $package->selesai == 0)
                                        <a href="#" class="btn btn-primary btn-sm">Paket telah diambil dari Olshop, dan
                                            berada di Gudang pengiriman</a>
                                    @elseif ($courier->titik1 == 1 && $package->selesai == 0)
                                        <a href="#" class="btn btn-primary btn-sm">Paket sedang dikirim kurir ke
                                            customer</a>
                                    @elseif ($courier->titik1 == 1 && $package->selesai == 1)
                                        <a href="#" class="btn btn-success btn-sm">Paket telah diterima oleh customer</a>
                                    @endif
                                @elseif (!$package->pick_up_id && $package->courier_id)
                                    @if ($courier->titik1 == 0 && $package->selesai == 0)
                                        <a href="#" class="btn btn-primary btn-sm">Paket telah berada digudang
                                            pengiriman</a>
                                    @elseif ($courier->titik1 == 1 && $package->selesai == 0)
                                        <a href="#" class="btn btn-primary btn-sm">Paket sedang dikirim kurir ke
                                            customer</a>
                                    @elseif ($courier->titik1 == 1 && $package->selesai == 1)
                                        <a href="#" class="btn btn-success btn-sm">Paket telah diterima oleh customer</a>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
