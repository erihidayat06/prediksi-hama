@extends('admin.layouts.main')

@section('content')
    <div class="container mt-4">
        <h2 class="mb-3">Tambah Blog</h2>

        <div class="card">
            <div class="card-body">
                <a href="{{ route('blog.index') }}" class="btn btn-secondary mb-3 mt-3">Kembali</a>
                <form action="{{ route('blog.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="gambar" class="form-label">Gambar</label>
                        <input type="file" class="form-control @error('gambar') is-invalid @enderror" id="gambar"
                            name="gambar" onchange="previewImage()">
                        @error('gambar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="gambar-preview" class="form-label">Preview Gambar</label>
                        <div id="gambar-preview" class="text-center">
                            <img id="preview-img" src="" alt="Preview Gambar"
                                style="display: none; width: 100%; max-width: 300px;">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="judul" class="form-label">Judul</label>
                        <input type="text" class="form-control @error('judul') is-invalid @enderror" id="judul"
                            name="judul" value="{{ old('judul') }}">
                        @error('judul')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="isi" class="form-label">Isi Blog</label>
                        <input id="isi" type="hidden" name="isi" class="@error('isi') is-invalid @enderror"
                            value="{{ old('isi') }}">
                        <trix-editor class="form-control @error('isi') is-invalid @enderror" input="isi"></trix-editor>
                        @error('isi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Function to display image preview
        function previewImage() {
            const file = document.getElementById('gambar').files[0];
            const reader = new FileReader();

            reader.onload = function(e) {
                const previewImg = document.getElementById('preview-img');
                previewImg.src = e.target.result;
                previewImg.style.display = 'block'; // Show the image
            };

            if (file) {
                reader.readAsDataURL(file);
            }
        }
    </script>
@endsection
