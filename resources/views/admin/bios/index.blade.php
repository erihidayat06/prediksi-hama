@extends('admin.layouts.main')

@section('content')
    <div class="container mt-4">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <h5 class="fw-bold">Data Bio Informasi</h5>
                </div>
                <a href="{{ route('bio.create', ['tanaman' => $tanaman->nm_tanaman]) }}" class="btn btn-primary mb-3">Tambah
                    Hama</a>
                <div class="table-responsive">
                    <table class="table datatable">
                        <thead class="table-dark">
                            <tr>
                                <th>Gambar</th>
                                <th>Nama Hama</th>
                                <th>Order</th>
                                <th>Suborder</th>
                                <th>Families</th>
                                <th>Genus</th>
                                <th>Species</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bios as $bio)
                                <tr>
                                    <td><img src="{{ asset($bio->gambar) }}" class="img-fluid" width="100"></td>
                                    <td>{{ $bio->nm_hama }}</td>
                                    <td>{{ $bio->order }}</td>
                                    <td>{{ $bio->suborder }}</td>
                                    <td>{{ $bio->families }}</td>
                                    <td>{{ $bio->genus }}</td>
                                    <td>{{ $bio->species }}</td>
                                    <td>
                                        <button class="btn btn-info btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#modalDeskripsi{{ $bio->id }}">
                                            Lihat Deskripsi
                                        </button>
                                        <a href="{{ route('bio.edit', ['bio' => $bio->id, 'tanaman' => $tanaman->nm_tanaman]) }}"
                                            class="btn btn-warning btn-sm">
                                            Edit
                                        </a>
                                        <form action="{{ route('bio.destroy', $bio->id) }}" method="POST" class="d-inline"
                                            onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                        </form>
                                    </td>
                                </tr>

                                <!-- Modal Deskripsi -->
                                <div class="modal fade" id="modalDeskripsi{{ $bio->id }}" tabindex="-1"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">{{ $bio->nm_hama }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>{!! $bio->deskripsi !!}</p>
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
