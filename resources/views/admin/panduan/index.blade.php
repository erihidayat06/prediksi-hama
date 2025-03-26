@extends('admin.layouts.main')

@section('content')
    <div class="container mt-4">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <h5 class="fw-bold">Good Agricultural Practice</h5>
                </div>

                <a href="{{ route('panduan.create', ['tanaman' => $tanaman->nm_tanaman]) }}" class="btn btn-primary mb-3">
                    Tambah Kegiatan
                </a>

                <div class="table-responsive">
                    <table class="table datatable">
                        <thead class="table-dark">
                            <tr>
                                <th>Gambar</th>
                                <th>Hama</th>
                                <th>Insektisida Resisten</th>
                                <th>Insektisida Cross Resisten</th>
                                <th>Saran Insektisida</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($panduans as $panduan)
                                <tr>
                                    <td>
                                        <img src="{{ asset($panduan->bio->gambar) }}" class="img-fluid" width="100"
                                            alt="Gambar Hama">
                                    </td>
                                    <td>{{ $panduan->bio->nm_hama }}</td>
                                    <td>{{ $panduan->insektisida->nm_insektisida ?? '-' }}</td>

                                    <!-- Insektisida Cross Resisten -->
                                    <td>
                                        @foreach ($panduan->insektisida->cross_resistens_names ?? [] as $index => $name)
                                            <a href="#" class="btn btn-link text-decoration-none p-0"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalDetail-{{ $panduan->id }}-{{ $index }}">
                                                {{ $name }}
                                            </a>
                                            @if (!$loop->last)
                                                ,
                                            @endif
                                        @endforeach
                                    </td>

                                    <!-- Saran Insektisida -->
                                    <td>
                                        @foreach ($panduan->insektisida->saran_insektisida_names ?? [] as $index => $name)
                                            <a href="#" class="btn btn-link text-decoration-none p-0"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalDetail-{{ $panduan->id }}-saran-{{ $index }}">
                                                {{ $name }}
                                            </a>
                                            @if (!$loop->last)
                                                ,
                                            @endif
                                        @endforeach
                                    </td>

                                    <td>
                                        <a href="{{ route('panduan.edit', ['gap' => $panduan->id, 'tanaman' => $tanaman->nm_tanaman]) }}"
                                            class="btn btn-warning btn-sm">
                                            Edit
                                        </a>
                                        <form action="{{ route('panduan.destroy', $panduan->id) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                        </form>
                                    </td>
                                </tr>

                                <!-- Modal Looping untuk Cross Resisten -->
                                @foreach ($panduan->insektisida->cross_resistens_names ?? [] as $index => $name)
                                    <div class="modal fade" id="modalDetail-{{ $panduan->id }}-{{ $index }}"
                                        tabindex="-1" aria-labelledby="modalDetailLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Detail Golongan</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <strong>Nama Golongan:</strong>
                                                    <p>{{ $name }}</p>

                                                    <strong>Bahan:</strong>
                                                    <p>{!! htmlspecialchars_decode($panduan->insektisida->cross_resistens_bahan[$index] ?? '-') !!}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                <!-- Modal Looping untuk Saran Insektisida -->
                                @foreach ($panduan->insektisida->saran_insektisida_names ?? [] as $index => $name)
                                    <div class="modal fade" id="modalDetail-{{ $panduan->id }}-saran-{{ $index }}"
                                        tabindex="-1" aria-labelledby="modalDetailLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Detail Golongan</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <strong>Nama Golongan:</strong>
                                                    <p>{{ $name }}</p>

                                                    <strong>Bahan:</strong>
                                                    <p>{!! htmlspecialchars_decode($panduan->insektisida->saran_insektisida_bahan[$index] ?? '-') !!}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
