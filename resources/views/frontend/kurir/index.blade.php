@extends('frontend.layouts.main')

@section('container')

    <div class="row">

        <h1 class="text-center mb-5">Nama - Nama Driver RAP-XPRESS</h1>

        <div class="row justify-content-start mb-3">
            <div class="col-md-3">
                <form action="/kurir" method="get">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Search.." name="search" id="search">
                        <button class="btn btn-outline-secondary" type="submit"><i class="bi bi-search"></i></button>
                    </div>
                </form>
            </div>
        </div>
        <div class="container">
            <div class="row">
                @if ($drivers->count())
                    @foreach ($drivers as $driver)
                        <div class="col-lg-3 mb-3">
                            <div class="card rounded shadow-sm border-1">
                                <div class="card-body p-4">
                                    @if ($driver->image)
                                        <img src="{{ asset('storage/' . $driver->image) }}"
                                            class="img-fluid d-block mx-auto mb-3" alt="{{ $driver->partner->name }}"
                                            style="width:400; height:500;">
                                    @else
                                        <img src="https://source.unsplash.com/400x500?{{ $driver->partner->name }}"
                                            class="img-fluid d-block mx-auto mb-3" alt="{{ $driver->partner->name }}"
                                            style="width:400; height:500;">
                                    @endif
                                    <h5>
                                        {{ $driver->name }}
                                    </h5>
                                    <p class="small text-muted font-italic">{{ $driver->account->alamat }}</p>
                                    {{-- <ul class="list-inline small">
                                    <li class="list-inline-item m-0"><i class="fa fa-star text-success"></i></li>
                                    <li class="list-inline-item m-0"><i class="fa fa-star text-success"></i></li>
                                    <li class="list-inline-item m-0"><i class="fa fa-star text-success"></i></li>
                                    <li class="list-inline-item m-0"><i class="fa fa-star text-success"></i></li>
                                    <li class="list-inline-item m-0"><i class="fa fa-star-o text-success"></i></li>
                                  </ul> --}}
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-center fs-4">No driver found.</p>
                @endif

            </div>
        </div>

        <div class="d-flex justify-content-center">
            {{ $drivers->links() }}
        </div>

    </div>

@endsection
