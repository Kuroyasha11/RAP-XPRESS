@extends('backend.layouts.main')

@section('container')
    <h2>{{ $package->nama }}</h2>
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
        <div class="mt-3 mb-3">
            <a href="/dashboard/paket/{{ $package->slug }}" class="btn btn-success"><i class="bi bi-arrow-left-circle"></i>
                Kembali</a>
        </div>
    </div>

    <div class="col-lg-15">
        <form action="/dashboard/paket/{{ $package->slug }}" method="post">
            @method('put')
            @csrf
            <div class="mb-3">
                <label for="namapenerima" class="form-label">Nama Penerima</label>
                <input type="text" class="form-control @error('namapenerima') is-invalid @enderror" name="namapenerima"
                    id="namapenerima" placeholder="Nama Penerima"
                    value="{{ old('namapenerima', $package->namapenerima) }}" autofocus required>
                @error('namapenerima')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="no_hp" class="form-label">Nomor Penerima</label>
                <input type="number" class="form-control @error('no_hp') is-invalid @enderror" name="no_hp" id="no_hp"
                    placeholder="Nomor Penerima" value="{{ old('no_hp', $package->no_hp) }}" required>
                @error('no_hp')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Barang</label>
                <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" id="nama"
                    placeholder="Nama" value="{{ old('nama', $package->nama) }}" autofocus required>
                @error('nama')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="jumlah" class="form-label">Jumlah</label>
                <input type="number" class="form-control @error('jumlah') is-invalid @enderror" name="jumlah" id="jumlah"
                    placeholder="Jumlah" value="{{ old('jumlah', $package->jumlah) }}" required>
                @error('jumlah')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="hargapaket" class="form-label">Harga Paket</label>
                <input type="number" class="form-control @error('hargapaket') is-invalid @enderror" name="hargapaket"
                    id="hargapaket" placeholder="Harga" value="{{ old('hargapaket', $package->hargapaket) }}" required>
                <label for="hargapaket" class="form-label text-muted">input "0" jika tidak ada
                    harga</label>
                @error('hargapaket')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat yang dituju</label>
                <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="5"
                    placeholder="Alamat" required>{{ old('alamat', $package->alamat) }}</textarea>
                @error('alamat')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="keterangan" class="form-label">Keterangan</label>
                <input type="text" class="form-control @error('keterangan') is-invalid @enderror" name="keterangan"
                    id="keterangan" placeholder="Keterangan" value="{{ old('keterangan', $package->keterangan) }}">
                @error('keterangan')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="shipping" class="form-label">Kelas Pengiriman</label>
                <select class="form-select @error('shipping_id') is-invalid @enderror" name="shipping_id">
                    @foreach ($shipping as $ship)
                        @if (old('shipping_id', $package->shipping_id) == $ship->id)
                            <option value="{{ $ship->id }}" selected>
                                {{ $ship->nama }}</option>
                        @else
                            <option value="{{ $ship->id }}">
                                {{ $ship->nama }}
                            </option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <input class="form-input" type="checkbox" value="1" id="cod" name="cod"
                    @if ($package->cod == 1) checked @endif>
                <label class="form-label" for="cod">
                    <strong> COD (Cash on Delivery)</strong>
                </label>
            </div>
            <label for="shipping" class="form-label text-muted">
                {{-- @IDR adalah format custom, ada di AppServiceProvider.php --}}
                Keterangan :
                @foreach ($shipping as $ship)
                    <p>- {{ $ship->keterangan }} :<strong> @IDR($ship->harga)</strong></p>
                @endforeach
            </label>
            <div class="mb-3">
                <button type="submit" class="btn btn-primary" name="submit"><i class="bi bi-save"></i> Update</button>
            </div>
        </form>

    </div>
@endsection
