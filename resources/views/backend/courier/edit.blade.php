@extends('backend.layouts.main')

@section('container')
    <h2>{{ $kurir->nama }}</h2>
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
            <a href="/dashboard/kurir/{{ $kurir->id }}" class="btn btn-success"><i class="bi bi-arrow-left-circle"></i>
                Back</a>
        </div>
    </div>

    <div class="col-lg-15">
        <form action="/dashboard/kurir/{{ $kurir->id }}" method="post">
            @method('put')
            @csrf
            <div class="mb-3">
                <label for="nama" class="form-label">Kode Kurir</label>
                <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" id="nama"
                    placeholder="Kode Kurir" value="{{ old('nama', $kurir->nama) }}" autofocus required>
                @error('nama')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="user_id" class="form-label">Driver Kurir</label>
                <select class="form-select @error('user_id') is-invalid @enderror" name="user_id">
                    @foreach ($users as $user)
                        @if (old('user_id', $kurir->user_id) == $user->id)
                            <option value="{{ $user->id }}" selected>
                                {{ $user->name }}</option>
                        @else
                            <option value="{{ $user->id }}">
                                {{ $user->name }}
                            </option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="alamat" class="form-label">Daerah yang diantar</label>
                <input type="text" class="form-control @error('alamat') is-invalid @enderror" name="alamat" id="alamat"
                    placeholder="Daerah yang diantar" value="{{ old('alamat', $kurir->alamat) }}" required>
                @error('alamat')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-primary" name="submit"><i class="bi bi-save"></i> Update</button>
            </div>
        </form>

    </div>
@endsection
