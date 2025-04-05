@extends('admin.layouts.main')

@section('content')
    <div class="container mt-4">
        <h2 class="mb-3">Edit Blog</h2>

        <div class="card">
            <div class="card-body">

                <a href="{{ route('blog.index') }}" class="btn btn-secondary mb-3 mt-3">Kembali</a>

                <form action="{{ route('blog.update', $blog->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="gambar" class="form-label">Gambar</label>
                        <input type="file" class="form-control @error('gambar') is-invalid @enderror" id="gambar"
                            name="gambar" onchange="previewImage()">

                        @if ($blog->gambar)
                            <div class="mt-2">
                                <img src="{{ asset($blog->gambar) }}" alt="Gambar" class="img-thumbnail" width="100">
                            </div>
                        @endif

                        @error('gambar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="judul" class="form-label">Judul</label>
                        <input type="text" class="form-control @error('judul') is-invalid @enderror" id="judul"
                            name="judul" value="{{ old('judul', $blog->judul) }}">
                        @error('judul')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="isi" class="form-label">Isi Blog</label>
                        <input id="isi" type="hidden" name="isi" class="@error('isi') is-invalid @enderror"
                            value="{{ old('isi', $blog->isi) }}">
                        <trix-editor class="form-control @error('isi') is-invalid @enderror" input="isi"></trix-editor>
                        @error('isi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
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
                const previewImg = document.createElement('img');
                previewImg.src = e.target.result;
                previewImg.classList.add('img-thumbnail');
                previewImg.style.maxWidth = '100px'; // Ensure the preview image isn't too large
                const previewContainer = document.querySelector('.form-control').parentElement.querySelector('.mt-2');
                previewContainer.innerHTML = ''; // Clear the old image
                previewContainer.appendChild(previewImg); // Append the new image
            };

            if (file) {
                reader.readAsDataURL(file);
            }
        }
    </script>
@endsection
