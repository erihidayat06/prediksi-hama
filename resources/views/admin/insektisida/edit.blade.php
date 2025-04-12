@extends('admin.layouts.main')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <div class="container mt-4">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <h5 class="fw-bold">Edit Data Resistensi</h5>
                </div>
                <form action="{{ route('insektisida.update', $insektisida->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="nm_insektisida" class="form-label">Nama Bahan aktif</label>
                        <input type="text" class="form-control @error('nm_insektisida') is-invalid @enderror"
                            id="nm_insektisida" name="nm_insektisida"
                            value="{{ old('nm_insektisida', $insektisida->nm_insektisida) }}">
                        @error('nm_insektisida')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    @php
                        $selectedCrossResistens = json_decode($insektisida->cross_resistens, true) ?? [];
                        $selectedSaranInsektisida = json_decode($insektisida->saran_insektisida, true) ?? [];
                    @endphp

                    <div class="mb-3">
                        <label for="cross_resistens" class="form-label">Cross Resistens</label>
                        <select class="js-example-basic-multiple form-select @error('cross_resistens') is-invalid @enderror"
                            name="cross_resistens[]" multiple="multiple" style="width: 100%">
                            @foreach ($golongans as $golongan)
                                <option value="{{ $golongan->id }}"
                                    {{ in_array($golongan->id, $selectedCrossResistens) ? 'selected' : '' }}>
                                    {{ $golongan->nm_golongan }}
                                </option>
                            @endforeach
                        </select>
                        @error('cross_resistens')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="saran_insektisida" class="form-label">Saran Insektisida</label>
                        <select
                            class="js-example-basic-multiple form-select @error('saran_insektisida') is-invalid @enderror"
                            name="saran_insektisida[]" multiple="multiple" style="width: 100%">
                            @foreach ($golongans as $golongan)
                                <option value="{{ $golongan->id }}"
                                    {{ in_array($golongan->id, $selectedSaranInsektisida) ? 'selected' : '' }}>
                                    {{ $golongan->nm_golongan }}
                                </option>
                            @endforeach
                        </select>
                        @error('saran_insektisida')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('insektisida.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2({
                placeholder: "Pilih opsi",
                allowClear: true
            });
        });
    </script>
@endsection
