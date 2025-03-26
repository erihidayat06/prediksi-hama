@extends('admin.layouts.main')

@section('content')
    <div class="container mt-4">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <h5 class="fw-bold">Good Agricultural Practice</h5>
                </div>
                <a href="{{ route('insektisida.create') }}" class="btn btn-primary mb-3">Tambah Kegiatan</a>
                <div class="table-responsive">
                    <table class="table datatable">
                        <thead class="table-dark">
                            <tr>
                                <th>Insektisida Resisten</th>
                                <th>Insektisida Cross Resisten</th>
                                <th>Saran Insektisida</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($insektisidas as $insektisida)
                                <tr>
                                    <!-- Nama Insektisida -->
                                    <td>{{ $insektisida->nm_insektisida }}</td>

                                    <!-- Insektisida Cross Resisten -->
                                    <td>
                                        @foreach ($insektisida->cross_resistens_names ?? [] as $index => $name)
                                            <a href="#" class="btn btn-link text-decoration-none p-0"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalCross-{{ $insektisida->id }}-{{ $index }}">
                                                {{ $name }}
                                            </a>
                                            @if (!$loop->last)
                                                ,
                                            @endif
                                        @endforeach
                                    </td>

                                    <!-- Saran Insektisida -->
                                    <td>
                                        @foreach ($insektisida->saran_insektisida_names ?? [] as $index => $name)
                                            <a href="#" class="btn btn-link text-decoration-none p-0"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalSaran-{{ $insektisida->id }}-{{ $index }}">
                                                {{ $name }}
                                            </a>
                                            @if (!$loop->last)
                                                ,
                                            @endif
                                        @endforeach
                                    </td>

                                    <!-- Aksi -->
                                    <td>
                                        <a href="{{ route('insektisida.edit', $insektisida->id) }}"
                                            class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('insektisida.destroy', $insektisida->id) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                        </form>
                                    </td>
                                </tr>

                                <!-- Modal untuk Cross Resisten -->
                                @foreach ($insektisida->cross_resistens_names ?? [] as $index => $name)
                                    <div class="modal fade" id="modalCross-{{ $insektisida->id }}-{{ $index }}"
                                        tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Detail Cross Resisten: {{ $name }}</h5>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p><strong>Bahan:</strong> {!! $insektisida->cross_resistens_bahan[$index] ?? 'Tidak tersedia' !!}</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Tutup</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                <!-- Modal untuk Saran Insektisida -->
                                @foreach ($insektisida->saran_insektisida_names ?? [] as $index => $name)
                                    <div class="modal fade" id="modalSaran-{{ $insektisida->id }}-{{ $index }}"
                                        tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Saran Insektisida: {{ $name }}</h5>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p><strong>Bahan:</strong> {!! $insektisida->saran_insektisida_bahan[$index] ?? 'Tidak tersedia' !!}</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Tutup</button>
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
