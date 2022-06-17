@extends('frontend.layouts.main')

@section('container')
    <div class="row">

        <h1 class="text-center mb-5">{{ $olshop->name }}</h1>

        @if ($olshop->image)
            <div class="d-flex justify-content-center">
                <img src="{{ asset('storage/' . $olshop->image) }}" class="mt-3 img-thumbnail rounded-circle"
                    alt="{{ $olshop->partner->name }}" width="200">
            </div>
        @else
            <div class="d-flex justify-content-center">
                <img src="https://source.unsplash.com/200x200?{{ $olshop->partner->name }}"
                    class="mt-3 img-thumbnail rounded-circle" alt="{{ $olshop->partner->name }}">
            </div>
        @endif

        <div class="d-flex justify-content-center">
            <table class="table table-sm table-borderless mt-3">
                <thead>
                    <tr align="center">
                        <th scope="col">Data</th>
                        <th scope="col">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Mitra</td>
                        <td>: {{ $olshop->partner->name }}</td>
                    </tr>
                    <tr>
                        <td>Jenis Toko</td>
                        <td>: {{ $olshop->account->jenistoko }}</td>
                    </tr>
                    <tr>
                        <td>Nama</td>
                        <td>: {{ $olshop->name }}</td>
                    </tr>
                    <tr>
                        <td>Nomor Handphone (WA)</td>
                        <td>: <a href="https://wa.me/62{{ $olshop->account->wa }}"
                                class="text-decoration-none text-success">
                                <i class="bi-whatsapp fs-3"></i> <strong>+62{{ $olshop->account->wa }} </strong>
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td>: {{ $olshop->account->alamat }}</td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td>: {{ $olshop->email }}</td>
                    </tr>
                    <tr>
                        <td>Instagram</td>
                        <td>: <a href="https://instagram.com/{{ $olshop->account->ig }}"
                                class="text-decoration-none text-danger">
                                <i class="bi-instagram fs-3"></i> <strong>{{ $olshop->account->ig }} </strong>
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>Facebook</td>
                        <td>: <a href="https://facebook.com/{{ $olshop->account->fb }}"
                                class="text-decoration-none text-primary">
                                <i class="bi-facebook fs-3"></i> <strong>{{ $olshop->account->fb }} </strong>
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <h3>Paket : {{ $packages->count() }}</h3>
        <div class="table-responsive col-lg-15 mb-5">
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Paket</th>
                        <th scope="col">Kurir</th>
                        <th scope="col">Jenis Pengiriman</th>
                        <th scope="col">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($packages->count())
                        @foreach ($packages as $package)
                            @php
                                $courier = App\Models\Courier::getCourierByCourierId($package->courier_id);
                            @endphp
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $package->nama }}</td>
                                <td>
                                    @if ($courier)
                                        {{ $courier->author->name }}
                                    @else
                                        Kurir belum dipilih
                                    @endif
                                </td>
                                <td>{{ $package->shipping->nama }} @if ($package->cod == 1)
                                        | COD (Cash on Delivery)
                                    @endif
                                </td>
                                <td>
                                    @if ($package->selesai)
                                        <a href="#" class="btn btn-success btn-small">SELESAI</a>
                                    @else
                                        <a href="#" class="btn btn-danger btn-small">PROSES</a>
                                    @endif
                                </td>
                                <td>

                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5">
                                <p class="text-center fs-4">Tidak ada Paket yang telah diantar</p>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

    </div>
@endsection
