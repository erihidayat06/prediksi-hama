@extends('admin.layouts.main')

@section('content')
    <div class="container mt-4">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <h5 class="fw-bold">Good Agricultural Practice</h5>
                </div>
                <a href="{{ route('gap.create', ['tanaman' => $tanaman->nm_tanaman]) }}" class="btn btn-primary mb-3">Tambah
                    Kegiatan</a>
                <div class="table-responsive">
                    <table class="table datatable">
                        <thead class="table-dark">
                            <tr>
                                <th>Gambar</th>
                                <th>Usia</th>
                                <th>Kegiatan</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($gaps as $gap)
                                <tr>
                                    <td><img src="{{ asset($gap->gambar) }}" class="img-fluid" width="100"></td>
                                    <td>{{ $gap->usia }}</td>
                                    <td>{{ $gap->kegiatan }}</td>
                                    <td>{{ $gap->keterangan }}</td>
                                    <td>
                                        <button class="btn btn-info btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#modalKeterangan{{ $gap->id }}">
                                            Lihat Keterangan
                                        </button>
                                        <a href="{{ route('gap.edit', ['gap' => $gap->id, 'tanaman' => $tanaman->nm_tanaman]) }}"
                                            class="btn btn-warning btn-sm">
                                            Edit
                                        </a>
                                        <form action="{{ route('gap.destroy', $gap->id) }}" method="POST" class="d-inline"
                                            onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                        </form>
                                    </td>
                                </tr>

                                <!-- Modal Keterangan -->
                                <div class="modal fade" id="modalKeterangan{{ $gap->id }}" tabindex="-1"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Keterangan Kegiatan</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>{!! $gap->keterangan !!}</p>
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
