@extends('admin.layouts.main')

@section('content')
    <div class="container mt-4">

        <a href="{{ route('bio.index', ['tanaman' => $tanaman->nm_tanaman]) }}" class="btn btn-secondary mb-3">Kembali</a>

        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <h5>Tambah Hama</h5>
                </div>
                <form action="{{ route('bio.store', ['tanaman' => $tanaman->nm_tanaman]) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="gambar" class="form-label">Gambar</label>
                        <input type="file" class="form-control @error('gambar') is-invalid @enderror" name="gambar">
                        @error('gambar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="sebaran" class="form-label">Gambar Sebaran</label>
                        <input type="file" class="form-control @error('sebaran') is-invalid @enderror" name="sebaran">
                        @error('sebaran')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="nm_hama" class="form-label">Nama Hama</label>
                        <input type="text" class="form-control @error('nm_hama') is-invalid @enderror" name="nm_hama"
                            value="{{ old('nm_hama') }}">
                        @error('nm_hama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="order" class="form-label">Order</label>
                        <input type="text" class="form-control @error('order') is-invalid @enderror" name="order"
                            value="{{ old('order') }}">
                        @error('order')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="suborder" class="form-label">Suborder</label>
                        <input type="text" class="form-control @error('suborder') is-invalid @enderror" name="suborder"
                            value="{{ old('suborder') }}">
                        @error('suborder')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="families" class="form-label">Families</label>
                        <input type="text" class="form-control @error('families') is-invalid @enderror" name="families"
                            value="{{ old('families') }}">
                        @error('families')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="genus" class="form-label">Genus</label>
                        <input type="text" class="form-control @error('genus') is-invalid @enderror" name="genus"
                            value="{{ old('genus') }}">
                        @error('genus')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="species" class="form-label">Species</label>
                        <input type="text" class="form-control @error('species') is-invalid @enderror" name="species"
                            value="{{ old('species') }}">
                        @error('species')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label ">Deskripsi</label>
                        <input id="deskripsi" type="hidden" name="deskripsi"
                            class="@error('deskripsi') is-invalid @enderror">
                        <trix-editor input="deskripsi">{{ old('deskripsi') }}</trix-editor>
                        {{-- <textarea class="form-control @error('deskripsi') is-invalid @enderror" name="deskripsi">{{ old('deskripsi') }}</textarea> --}}
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </form>
            </div>
        </div>
    </div>
@endsection
