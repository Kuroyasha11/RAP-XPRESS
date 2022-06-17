@extends('backend.layouts.main')

@section('container')

    {{-- <h1 class="mb-3">{{ $request->nama }}</h1> --}}
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
        <a href="/dashboard/pengiriman" class="btn btn-success"><i class="bi bi-arrow-left-circle"></i> Back</a>
        @if ($request->terima == 1 && $request->diambil == 0 && $request->selesai == 0)
            @if (!$pickup && !$courier)
                <a href="/dashboard/pengiriman/{{ $request->slug }}/edit" class="btn btn-warning"><i
                        class="bi bi-pencil"></i> Edit</a>
                <form action="/dashboard/pengiriman/{{ $request->slug }}" method="post" class="d-inline">
                    @method('delete')
                    @csrf
                    <button class="btn btn-danger" onclick="return confirm('Are you sure?')">
                        <i class="bi bi-x-circle"></i> Delete
                    </button>
                </form>
            @else
            @endif
        @endif
        <a href="/dashboard/paket/resi/{{ $request->slug }}" class="btn btn-danger" target="_blank">
            <i class="bi bi-printer"></i> PRINT</a>
        <label for="text-muted">Note: Kertas A6</label>
        {{-- <form action="/dashboard/pengiriman/selesai/{{ $request->slug }}" method="post" class="d-inline">
                        @method('put')
                        @csrf
                        <input type="hidden" name="selesai" id="terima" value="1">
                        <button class="btn btn-primary" onclick="return confirm('Are you sure?')">
                            <i class="bi bi-check"></i> Finish
                        </button>
                    </form> --}}
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
                    <td>Resi</td>
                    <td>: @if ($request->terima == 0)
                            -
                        @else
                            <div class="d-flex justify-content-center">
                                <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($request->slug, 'C39', 1, 35) }}"
                                    alt="{{ $request->slug }}" />
                            </div>
                            <div class="d-flex justify-content-center">
                                <strong>{{ $request->slug }}</strong>
                            </div>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Pemohon</td>
                    <td>: <strong>{{ $request->namapemohon }}</strong></td>
                </tr>
                <tr>
                    <td>Nomor Pemohon</td>
                    <td>: <a href="https://wa.me/62{{ $request->telepon }}" class="text-decoration-none text-black"
                            target="_blank">
                            +62{{ $request->telepon }}
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>Nama Penerima</td>
                    <td>: {{ $request->namapenerima }}</td>
                </tr>
                <tr>
                    <td>Nomor Penerima</td>
                    <td>: <a href="https://wa.me/62{{ $request->no_hp }}" class="text-decoration-none text-black"
                            target="_blank">
                            +62{{ $request->no_hp }}
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>Paket</td>
                    <td>: {{ $request->nama }}</td>
                </tr>
                <tr>
                    <td>Jumlah</td>
                    <td>: {{ $request->jumlah }}</td>
                </tr>
                <tr>
                    <td>Harga Paket</td>
                    <td>: @IDR($request->hargapaket)</td>
                </tr>
                <tr>
                    <td>Alamat Tujuan</td>
                    <td>: {{ $request->alamat }} <a href="https://www.google.com/maps/place/{{ $request->alamat }}"
                            class=" btn btn-success text-decoration-none text-black" target="_blank">
                            <i class="bi bi-geo-alt-fill"></i> MAP
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>Keterangan</td>
                    <td>: {{ $request->keterangan }}</td>
                </tr>
                <tr>
                    <td>Kelas Pengiriman</td>
                    <td>: {{ $request->shipping->nama }} @if ($request->cod == 1)
                            | COD (Cash On Delivery)
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Ongkos Pengiriman</td>
                    <td>: @IDR($request->shipping->harga)</td>
                </tr>
                <tr>
                    <td>Kurir yang mengambil</td>
                    <td>:
                        @if ($pickup)
                            {{ $pickup->author->name }}
                        @else
                            -
                        @endif
                    </td>
                </tr>
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
                @if ($request->cod)
                    @if ($request->author->id_admin)
                        <tr>
                            <td><b>Total COD</b> <label class="text-muted">kurir pengantar menerima pembayaran dari
                                    Customer, dan kurir
                                    pengantar menyetor uang ke Admin</label></td>
                            <td>: <b>@IDR($request->shipping->harga + $request->hargapaket)</b></td>
                        </tr>
                    @else
                        <tr>
                            <td><b>Total COD</b> <label class="text-muted">Kurir pengambil membayar ke Olshop, Kurir
                                    pengambil menerima
                                    pembayaran dari admin, kurir pengantar menerima pembayaran dari Customer, dan kurir
                                    pengantar menyetor uang ke Admin</label></td>
                            <td>: <b>@IDR($request->shipping->harga + $request->hargapaket)</b></td>
                        </tr>
                    @endif
                @else
                    @if ($request->author->is_admin)
                        <tr>
                            <td>Total</td>
                            <td>: <b>@IDR($request->shipping->harga)</b></td>
                        </tr>
                    @else
                        <tr>
                            <td>
                                <b>Total</b> <label class="text-muted">Kurir pengambil menerima pembayaran dari Olshop,
                                    Kurir
                                    pengambil menyetor pembayaran ke admin</label>
                            </td>
                            <td>: <b>@IDR($request->shipping->harga)</b></td>
                        </tr>
                    @endif
                @endif
                @if ($request->diambil == 1 && $request->selesai == 1)
                    <tr>
                        <td> Foto Delivery</td>
                        <td>: <div class="mb-3">
                                <img src="{{ asset('storage/' . $request->image) }}" class="img-preview img-fluid mb-3"
                                    width="350" height="500">
                            </div>
                        </td>
                    </tr>
                @elseif ($request->diambil == 1 && $request->selesai == 0)
                    <tr>
                        <td> Foto Pick Up</td>
                        <td>: <div class="mb-3">
                                <img src="{{ asset('storage/' . $request->foto) }}" class="img-preview img-fluid mb-3"
                                    width="350" height="500">
                            </div>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

@endsection
