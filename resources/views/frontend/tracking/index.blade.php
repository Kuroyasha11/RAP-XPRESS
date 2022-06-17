@extends('frontend.layouts.main')

@section('container')
    <div class="row">
        <h1 class="text-center mb-5">CARI PAKET MU DIMANA</h1>

        <div class="row justify-content-center mb-3">
            <div class="col-md-5">
                <form action="/tracking" method="get">
                    <label for="search" class="form-label"><strong>KODE RESI :</strong></label>
                    <div class="input-group mb-2">
                        <input type="number" class="form-control" placeholder="Tracking" name="search" id="search">
                        <button class="btn btn-danger" type="submit"><i class="bi bi-search"></i></button>
                    </div>
                </form>
            </div>
        </div>

        <div class="container">
            <div class="row justify-content-center">
                @foreach ($packages as $package)
                    @php
                        $courier = App\Models\Courier::getCourierByCourierIdTracking($package->courier_id);
                    @endphp
                    <div class="col-sm-6 mt-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">{{ $package->nama }}</h5>
                                <p class="card-text">
                                <table class="table table-borderless">
                                    <tr>
                                        <td> Toko </td>
                                        <td>: <a href="{{ url('/online-shop/' . $package->author->slug) }}"
                                                class="text-decoration-none text-black">
                                                {{ $package->author->name }}
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td> Kurir </td>
                                        <td>: @if ($package->courier_id)
                                                {{ $courier->author->name }}
                                            @else
                                                Kurir belum dipilih
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                                </p>
                                <a href="/tracking/{{ $package->slug }}" class="btn btn-success" target="_blank">Check</a>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
@endsection
