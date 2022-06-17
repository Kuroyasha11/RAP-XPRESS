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
    <h2>Pendaftaran Mitra!</h2>
    <div class="row justify-content-start mb-3">
        <div class="col-lg-3">
            <form action="/dashboard/registration" method="get">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Search.." name="search" id="search">
                    <button class="btn btn btn-outline-light btn-danger" type="submit"><i class="bi bi-search"></i></button>
                </div>
            </form>
        </div>
    </div>
    <div class="table-responsive col-lg-15 mb-5">
        <div class="d-flex justify-content-end">
            {{ $partners->links() }}
        </div>
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Partner</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @if ($partners->count())
                    @foreach ($partners as $partner)
                        <tr>
                            <td>{{ $partners->firstItem() - 1 + $loop->iteration }}</td>
                            <td>{{ $partner->name }}</td>
                            <td>{{ $partner->partner->name }}</td>
                            <td>
                                <a href="/dashboard/registration/{{ $partner->slug }}" class="btn btn-danger">
                                    <i class="bi bi-eye"></i> Lihat
                                </a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="4">
                            <p class="text-center fs-4">Tidak ada Pendaftar</p>
                        </td>
                    </tr>
                @endif

            </tbody>
        </table>
    </div>

@endsection
