@extends('home.marketplace.layouts.main')

@section('content')
    <style>
        .add-image-box {
            width: 100px;
            height: 100px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px dashed #ccc;
            cursor: pointer;
            font-size: 24px;
            font-weight: bold;
            color: #777;
            transition: 0.3s;
        }

        .add-image-box:hover {
            border-color: #007bff;
            color: #007bff;
        }

        .img-preview {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border: 1px solid #ddd;
            border-radius: 5px;
            position: relative;
        }

        .remove-image {
            position: absolute;
            top: 2px;
            right: 5px;
            background: red;
            color: white;
            border: none;
            font-size: 12px;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }
    </style>

    <div class="container mt-5 mb-5">
        <div class="row row-cols-1 row-cols-lg-2">
            @include('home.marketplace.layouts.menu')
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            {{-- Gambar (Multi-Upload, Maksimal 5) --}}
                            <div class="mb-3">
                                <label class="form-label">Gambar (Maksimal 5)</label>
                                <div id="preview-container" class="d-flex flex-wrap gap-2">
                                    <div class="add-image-box" onclick="triggerFileInput()">
                                        <span>+</span>
                                    </div>
                                </div>
                                <input type="file" id="gambar" name="gambar[]" accept="image/*" multiple
                                    class="d-none" onchange="previewImages(event)">
                                @error('gambar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Judul --}}
                            <div class="mb-3">
                                <label for="judul" class="form-label">Judul</label>
                                <input class="form-control @error('judul') is-invalid @enderror" type="text"
                                    name="judul" id="judul" value="{{ old('judul') }}">
                                @error('judul')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- No Telepon --}}
                            <div class="mb-3">
                                <label for="no_tlp" class="form-label">No Telepon</label>
                                <input class="form-control @error('no_tlp') is-invalid @enderror" type="text"
                                    name="no_tlp" id="no_tlp" value="{{ old('no_tlp') }}">
                                @error('no_tlp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Harga --}}
                            <div class="mb-3">
                                <label for="harga" class="form-label">Harga</label>
                                <input class="form-control @error('harga') is-invalid @enderror" type="text"
                                    name="harga" id="harga" value="{{ old('harga') }}">
                                @error('harga')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Satuan --}}
                            <div class="mb-3">
                                <label for="satuan" class="form-label">Satuan</label>
                                <select name="satuan" id="satuan"
                                    class="form-select @error('satuan') is-invalid @enderror">
                                    <option value="">-- Pilih Satuan --</option>
                                    <option value="kg" {{ old('satuan') == 'kg' ? 'selected' : '' }}>Kilogram (kg)
                                    </option>
                                    <option value="g" {{ old('satuan') == 'g' ? 'selected' : '' }}>Gram (g)</option>
                                    <option value="ltr" {{ old('satuan') == 'ltr' ? 'selected' : '' }}>Liter (ltr)
                                    </option>
                                    <option value="pcs" {{ old('satuan') == 'pcs' ? 'selected' : '' }}>Pcs</option>
                                    <option value="ikat" {{ old('satuan') == 'ikat' ? 'selected' : '' }}>Ikat</option>
                                    <!-- Tambahkan satuan lain sesuai kebutuhan -->
                                </select>
                                @error('satuan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Kecamatan --}}
                            <div class="mb-3">
                                <label for="kecamatan" class="form-label">Kecamatan</label>
                                <select class="form-select @error('kecamatan') is-invalid @enderror" name="kecamatan"
                                    id="kecamatan">
                                    <option value="">-- Pilih Kecamatan --</option>
                                    @foreach ($kecamatans as $kecamatan)
                                        <option value="{{ $kecamatan->kecamatan }}"
                                            {{ old('kecamatan') == $kecamatan->kecamatan ? 'selected' : '' }}>
                                            {{ $kecamatan->kecamatan }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('kecamatan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>



                            {{-- Desa --}}
                            <div class="mb-3">
                                <label for="desa" class="form-label">Desa</label>
                                <input class="form-control @error('desa') is-invalid @enderror" type="text"
                                    name="desa" id="desa" value="{{ old('desa') }}">
                                @error('desa')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Alamat --}}
                            <div class="mb-3">
                                <label for="alamat" class="form-label">Alamat</label>
                                <textarea class="form-control @error('alamat') is-invalid @enderror" name="alamat" id="alamat" rows="3">{{ old('alamat') }}</textarea>
                                @error('alamat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Deskripsi --}}
                            <div class="mb-3">
                                <label for="deskripsi" class="form-label">Deskripsi</label>
                                <textarea class="form-control @error('deskripsi') is-invalid @enderror" name="deskripsi" id="deskripsi" rows="4">{{ old('deskripsi') }}</textarea>
                                @error('deskripsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            {{-- User ID (Hidden) --}}
                            <input type="hidden" name="user_id" value="{{ auth()->id() }}">

                            {{-- Submit --}}
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let totalFiles = 0;
        let fileList = [];

        function triggerFileInput() {
            document.getElementById('gambar').click();
        }

        function previewImages(event) {
            let previewContainer = document.getElementById('preview-container');
            let files = event.target.files;

            if (totalFiles + files.length > 5) {
                alert("Maksimal hanya 5 gambar yang dapat diunggah.");
                return;
            }

            Array.from(files).forEach((file, index) => {
                if (totalFiles >= 5) return;

                let reader = new FileReader();
                reader.onload = function(e) {
                    let div = document.createElement('div');
                    div.classList.add('position-relative');

                    let imgElement = document.createElement('img');
                    imgElement.src = e.target.result;
                    imgElement.classList.add('img-preview');

                    let removeBtn = document.createElement('button');
                    removeBtn.innerText = '×';
                    removeBtn.classList.add('remove-image');
                    removeBtn.onclick = function() {
                        previewContainer.removeChild(div);
                        fileList.splice(index, 1);
                        totalFiles--;
                        updateFileInput();
                    };

                    div.appendChild(imgElement);
                    div.appendChild(removeBtn);
                    previewContainer.insertBefore(div, previewContainer.lastElementChild);

                    fileList.push(file);
                    totalFiles++;

                    updateFileInput();
                };
                reader.readAsDataURL(file);
            });

            event.target.value = "";
        }

        function updateFileInput() {
            let input = document.getElementById('gambar');
            let newFileList = new DataTransfer();

            fileList.forEach(file => newFileList.items.add(file));
            input.files = newFileList.files;
        }
    </script>
@endsection
