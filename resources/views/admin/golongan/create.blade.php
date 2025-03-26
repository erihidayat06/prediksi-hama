@extends('admin.layouts.main')

@section('content')
    <div class="container mt-4">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <h5 class="fw-bold">Tambah Data Golongan</h5>
                </div>
                <form action="{{ route('golongan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="nm_golongan" class="form-label">Nama Golongan</label>
                        <input type="text" class="form-control @error('nm_golongan') is-invalid @enderror"
                            id="nm_golongan" name="nm_golongan" value="{{ old('nm_golongan') }}">
                        @error('nm_golongan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="bahan" class="form-label">Bahan</label>


                        <input id="bahan" type="hidden" name="bahan" class="@error('bahan') is-invalid @enderror"
                            value="{{ old('bahan') }}">
                        <trix-editor input="bahan"></trix-editor>
                        @error('bahan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('golongan.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
@endsection
