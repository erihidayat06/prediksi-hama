@extends('admin.layouts.main')

@section('content')
    <div class="container mt-4">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <h5 class="fw-bold">Tambah Kegiatan Tanaman</h5>
                </div>
                <form action="{{ route('gap.store', ['tanaman' => $tanaman->nm_tanaman]) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="gambar" class="form-label">Gambar</label>
                        <input type="file" class="form-control @error('gambar') is-invalid @enderror" id="gambar"
                            name="gambar" onchange="previewImage(event)">
                        @error('gambar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <img id="preview" src="#" class="img-fluid mt-2 d-none" width="150">
                    </div>
                    <div class="mb-3">
                        <label for="usia" class="form-label">Usia</label>
                        <input type="text" class="form-control @error('usia') is-invalid @enderror" id="usia"
                            name="usia" value="{{ old('usia') }}">
                        @error('usia')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="kegiatan" class="form-label">Kegiatan</label>
                        <input type="text" class="form-control @error('kegiatan') is-invalid @enderror" id="kegiatan"
                            name="kegiatan" value="{{ old('kegiatan') }}">
                        @error('kegiatan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <input id="keterangan" type="hidden" name="keterangan"
                            class="@error('keterangan') is-invalid @enderror" value="{{ old('keterangan') }}">
                        <trix-editor input="keterangan"></trix-editor>

                        @error('keterangan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <input type="hidden" name="tanaman_id" value="{{ $tanaman->id }}">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('gap.index', ['tanaman' => $tanaman->nm_tanaman]) }}"
                        class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>

    <script>
        function previewImage(event) {
            var input = event.target;
            var reader = new FileReader();
            reader.onload = function() {
                var img = document.getElementById('preview');
                img.src = reader.result;
                img.classList.remove('d-none');
            };
            reader.readAsDataURL(input.files[0]);
        }
    </script>
@endsection
