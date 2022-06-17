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
        <a href="/dashboard/registration/" class="btn btn-success"><i class="bi bi-arrow-left-circle"></i> Back</a>
        <a href="/dashboard/registration/{{ $partner->slug }}/edit" class="btn btn-warning"><i class="bi bi-pencil"></i>
            Edit</a>
        <form action="/dashboard/registration/{{ $partner->slug }}" method="post" class="d-inline">
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
                <tr align="center">
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
                    <td>: +62{{ $partner->no_hp }}
                        @php
                            $pesan = 'Dear ' . $partner->name . '.%0A%0ATerima kasih telah mendaftar sebagai mitra.%0ASilahkan datang ke kantor RAP-XPRESS untuk menyelesaikan pendaftaran dengan membawa persyaratan sebagai berikut:%0AMitra Kurir%0A1. KTP%0A2. SIM%0A3. STNK%0A4. SKCK%0A5. KK%0A%0AMitra Olshop (Online-Shop)%0A1. KTP%0A2. Foto Olshop (Social Media)%0A3. Peta lokasi olshop%0A%0ASemua persyaratan diatas asli dan fotocopy.%0A%0AAlamat Kantor : Jl. Raya Perum PNS Pemkot No.3, RT.36, RW.07, Kel. Gandus, Kec. Gandus, Palembang, 30149.%0A%0AAdmin RAP-XPRESS';
                        @endphp
                        <a href="https://wa.me/62{{ $partner->no_hp }}?text={{ str_replace(' ', '%20', $pesan) }}"
                            class="text-decoration-none btn btn-success" target="_blank">
                            <i class="bi bi-whatsapp"></i>Hubungi
                        </a>
                        {{-- <a href="https://wa.me/62{{ $partner->no_hp }}?text=Dear%20{{ str_replace(' ', '%20', $partner->name) }}.%0ATerima%20kasih%20telah%20mendaftar%20sebagai%20mitra.%0ASilahkan%20datang%20ke%20kantor%20RAP-XPRESS%20untuk%20menyelesaikan%20pendaftaran.%0ASilahkan%20membawa%20persyaratan%20yang%20ada%20dibawah%20ini:%0AMitra%20Kurir%0A1.%20KTP%0A2.%20SIM%0A3.%20STNK%0A4.%20SKCK%0A5.%20KK%0A%0AMitra%20Olshop%20(Online-Shop)%0A1.%20KTP%0A2.%20Foto%20Olshop%20(Social%20Media)%0A3.%20Peta%20lokasi%20olshop%0A%0ASemua%20persyaratan%20diatas%20Asli%20dan%20Fotocopy.%0A%0A%0AAdmin%20RAP-XPRESS"
                            class="text-decoration-none btn btn-success" target="_blank">
                            <i class="bi bi-whatsapp"></i>Hubungi
                        </a> --}}
                        {{-- <a href="https://wa.me/62{{ $partner->no_hp }}" class="text-decoration-none text-black"
                            target="_blank">
                            +62{{ $partner->no_hp }}
                        </a> --}}
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
