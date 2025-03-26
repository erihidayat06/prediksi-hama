@extends('admin.layouts.main')

@section('content')
    <div class="container mt-4">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <h5 class="fw-bold">Good Agricultural Practice</h5>
                </div>
                <a href="{{ route('golongan.create') }}" class="btn btn-primary mb-3">Tambah
                    Kegiatan</a>
                <div class="table-responsive">
                    <table class="table datatable">
                        <thead class="table-dark">
                            <tr>
                                <th>Nama Golongan</th>
                                <th>Bahan Aktive</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($golongans as $golongan)
                                <tr>

                                    <td>{{ $golongan->nm_golongan }}</td>
                                    <td> <button class="btn btn-info btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#modalKeterangan{{ $golongan->id }}">
                                            Lihat Keterangan
                                        </button></td>
                                    <td>

                                        <a href="{{ route('golongan.edit', $golongan->id) }}"
                                            class="btn btn-warning btn-sm">
                                            Edit
                                        </a>
                                        <form action="{{ route('golongan.destroy', $golongan->id) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                        </form>
                                    </td>
                                </tr>

                                <!-- Modal Keterangan -->
                                <div class="modal fade" id="modalKeterangan{{ $golongan->id }}" tabindex="-1"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Keterangan Kegiatan</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>{!! $golongan->bahan !!}</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Tutup</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Modal -->
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
