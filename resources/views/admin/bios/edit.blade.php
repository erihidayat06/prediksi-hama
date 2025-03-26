@extends('admin.layouts.main')

@section('content')
    <div class="container mt-4">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <h5 class="fw-bold">Edit Bio Informasi</h5>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('bio.update', ['bio' => $bio->id, 'tanaman' => $tanaman->nm_tanaman]) }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="gambar" class="form-label">Gambar</label>
                        <input type="file" class="form-control @error('gambar') is-invalid @enderror" name="gambar"
                            id="gambarInput" accept="image/*" onchange="previewImage(event)">

                        @error('gambar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        <!-- Preview Gambar -->
                        <div class="mt-3">
                            <img id="gambarPreview" src="{{ asset($bio->gambar) }}" class="img-thumbnail" width="200"
                                @if (!$bio->gambar) style="display: none;" @endif>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="nm_hama" class="form-label">Nama Hama</label>
                        <input type="text" class="form-control @error('nm_hama') is-invalid @enderror" name="nm_hama"
                            value="{{ old('nm_hama', $bio->nm_hama) }}">
                        @error('nm_hama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="order" class="form-label">Order</label>
                        <input type="text" class="form-control @error('order') is-invalid @enderror" name="order"
                            value="{{ old('order', $bio->order) }}">
                        @error('order')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="suborder" class="form-label">Suborder</label>
                        <input type="text" class="form-control @error('suborder') is-invalid @enderror" name="suborder"
                            value="{{ old('suborder', $bio->suborder) }}">
                        @error('suborder')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="families" class="form-label">Families</label>
                        <input type="text" class="form-control @error('families') is-invalid @enderror" name="families"
                            value="{{ old('families', $bio->families) }}">
                        @error('families')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="genus" class="form-label">Genus</label>
                        <input type="text" class="form-control @error('genus') is-invalid @enderror" name="genus"
                            value="{{ old('genus', $bio->genus) }}">
                        @error('genus')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="species" class="form-label">Species</label>
                        <input type="text" class="form-control @error('species') is-invalid @enderror" name="species"
                            value="{{ old('species', $bio->species) }}">
                        @error('species')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <input id="deskripsi" type="hidden" name="deskripsi"
                            class="@error('deskripsi') is-invalid @enderror"
                            value="{{ old('deskripsi', $bio->deskripsi) }}">
                        <trix-editor input="deskripsi"></trix-editor>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                    <a href="{{ route('bio.index', ['tanaman' => $tanaman->nm_tanaman]) }}"
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
                var imgElement = document.getElementById('gambarPreview');
                imgElement.src = reader.result;
                imgElement.style.display = "block";
            };

            if (input.files[0]) {
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
