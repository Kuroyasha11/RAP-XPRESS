@extends('backend.layouts.main')

@section('container')
    @if (session()->has('berhasil'))
        <div class="alert alert-success col-lg-8" role="alert">
            {{ session('berhasil') }}
        </div>
    @endif
    @if (session()->has('gagal'))
        <div class="alert alert-danger col-lg-8" role="alert">
            {{ session('gagal') }}
        </div>
    @endif
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Mitra RAP-XPRESS</h1>
    </div>
    <div class="table-responsive col-lg-15">
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Partner</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($partners as $partner)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $partner->name }}</td>
                        <td>{{ $partner->partner->name }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
