@extends('backend.layouts.main')

@section('container')
    <h1 class="mb-3">{{ $partner->name }}</h1>
    @if (session()->has('berhasil'))
        <div class="alert alert-success col-lg-8" role="alert">
            {{ session('berhasil') }}
        </div>
    @endif
    @if (session()->has('gagal'))
        <div class="alert alert-success col-lg-8" role="alert">
            {{ session('gagal') }}
        </div>
    @endif

    <div class="col-lg-5">
        <a href="/dashboard/partner" class="btn btn-success"><i class="bi bi-arrow-left-circle"></i> Back</a>
        <a href="/dashboard/partner/{{ $partner->slug }}/edit" class="btn btn-warning"><i class="bi bi-pencil"></i>
            Edit</a>
        <form action="/dashboard/partner/{{ $partner->slug }}" method="post" class="d-inline">
            @method('delete')
            @csrf
            <button class="btn btn-danger" onclick="return confirm('Are you sure?')">
                <i class="bi bi-x-circle"></i> Delete
            </button>
        </form>
    </div>

    @if ($partner->image)
        <div class="position-relative">
            <img src="https://source.unsplash.com/1200x400?{{ $partner->partner->name }}" class="img-fluid mt-3"
                alt="{{ $partner->partner->name }}">
            <picture class="position-absolute bottom-0 start-50 translate-middle-x">
                <img src="{{ asset('storage/' . $partner->image) }}" class="img-fluid img-thumbnail rounded-circle"
                    alt="{{ $partner->partner->name }}" width="100">
            </picture>
        </div>
    @else
        <div class="position-relative">
            <img src="https://source.unsplash.com/1200x400?{{ $partner->partner->name }}" class="img-fluid mt-3"
                alt="{{ $partner->partner->name }}">
            <picture class="position-absolute bottom-0 start-50 translate-middle-x">
                <img src="https://source.unsplash.com/100x100?{{ $partner->partner->name }}"
                    class="img-fluid img-thumbnail rounded-circle" alt="{{ $partner->partner->name }}">
            </picture>
        </div>
    @endif

    <div class="table-responsive col-lg-15 mb-5">
        <table class="table table-sm">
            <thead>
                <tr>
                    <th scope="col">Data</th>
                    <th scope="col">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Mitra</td>
                    <td>: {{ $partner->partner->name }}</td>
                </tr>
                <tr>
                    <td>Nama</td>
                    <td>: {{ $partner->name }}</td>
                </tr>
                <tr>
                    <td>Nomor Handphone</td>
                    <td>: <a href="https://wa.me/62{{ $partner->no_hp }}" class="text-decoration-none text-black"
                            target="_blank">
                            +62{{ $partner->no_hp }}
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>KTP/SIM</td>
                    <td>: {{ $partner->ktp_sim }}</td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td>: {{ $partner->email }}</td>
                </tr>
                <tr>
                    <td>Username</td>
                    <td>: {{ $partner->username }}</td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td>: {{ $partner->account->alamat }}</td>
                </tr>
                <tr>
                    <td>Jenis Toko</td>
                    <td>: {{ $partner->account->jenistoko }}</td>
                </tr>
                <tr>
                    <td>WhatsApp</td>
                    <td>: <a href="https://wa.me/62{{ $partner->account->wa }}"
                            class="text-decoration-none text-success">
                            <i class="bi-whatsapp fs-3"></i> <strong>+62{{ $partner->account->wa }} </strong>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>Instagram</td>
                    <td>: <a href="https://instagram.com/{{ $partner->account->ig }}"
                            class="text-decoration-none text-danger">
                            <i class="bi-instagram fs-3"></i> <strong>{{ $partner->account->ig }} </strong>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>Facebook</td>
                    <td>: <a href="https://facebook.com/{{ $partner->account->fb }}"
                            class="text-decoration-none text-primary">
                            <i class="bi-facebook fs-3"></i> <strong>{{ $partner->account->fb }} </strong>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>Foto</td>
                    <td>:
                        @if ($partner->image)
                            <img src="{{ asset('storage/' . $partner->image) }}" alt="{{ $partner->name }}"
                                width="200px" class="rounded">
                        @else
                            BELUM ADA FOTO
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
