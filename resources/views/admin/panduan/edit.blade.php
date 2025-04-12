@extends('admin.layouts.main')

@section('content')
    <div class="container mt-4">
        <div class="card">
            <div class="card-body">
                <h5 class="fw-bold">Edit Data Panduan</h5>

                <form action="{{ route('panduan.update', ['tanaman' => $tanaman->nm_tanaman, 'panduan' => $panduan->id]) }}"
                    method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Pilih Bio --}}
                    <div class="mb-3">
                        <label for="bio_id" class="form-label">Pilih Bio</label>
                        <select class="form-select @error('bio_id') is-invalid @enderror" name="bio_id">
                            <option value="">-- Pilih Bio --</option>
                            @foreach ($bios as $bio)
                                <option value="{{ $bio->id }}"
                                    {{ old('bio_id', $panduan->bio_id) == $bio->id ? 'selected' : '' }}>
                                    {{ $bio->nm_hama }}
                                </option>
                            @endforeach
                        </select>
                        @error('bio_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Pilih Insektisida --}}
                    <div class="mb-3">
                        <label for="insektisida_id" class="form-label">Pilih Insektisida</label>
                        <select class="form-select @error('insektisida_id') is-invalid @enderror" name="insektisida_id">
                            <option value="">-- Pilih Insektisida --</option>
                            @foreach ($insektisidas as $insektisida)
                                <option value="{{ $insektisida->id }}"
                                    {{ old('insektisida_id', $panduan->insektisida_id) == $insektisida->id ? 'selected' : '' }}>
                                    {{ $insektisida->nm_insektisida }}
                                </option>
                            @endforeach
                        </select>
                        @error('insektisida_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('panduan.index', ['tanaman' => $tanaman->nm_tanaman]) }}"
                        class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
@endsection
