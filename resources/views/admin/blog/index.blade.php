@extends('admin.layouts.main')

@section('content')
    <div class="container mt-4">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <h5 class="fw-bold">Daftar blog</h5>
                </div>

                <a href="/admin/blog/create" class="btn btn-sm btn-success">Tambah blog</a>
                <!-- Tabel -->
                <div class="tab-pane fade show active" id="table" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Gambar</th>
                                    <th>Judul</th>
                                    <th>Isi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($blogs as $index => $blog)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td><img src="{{ asset($blog->gambar) }}" alt="Gambar" class="img-thumbnail"
                                                width="100">
                                        </td>
                                        <td>{{ $blog->judul }}</td>
                                        <td>{!! Str::limit($blog->isi, 100, '...') !!}</td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <button class="ms-2 btn btn-info btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#blogModal{{ $blog->id }}">Lihat</button>
                                                <a href="{{ route('blog.edit', $blog->id) }}"
                                                    class="ms-2 btn btn-primary btn-sm">Edit</a>
                                                <form action="{{ route('blog.destroy', $blog->id) }}" method="POST"
                                                    style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="ms-2 btn btn-danger btn-sm"
                                                        onclick="return confirm('Apakah yakin akan di hapus')">Hapus</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Modal for Viewing blog -->
                                    <div class="modal fade" id="blogModal{{ $blog->id }}" tabindex="-1"
                                        aria-labelledby="blogModalLabel{{ $blog->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="blogModalLabel{{ $blog->id }}">
                                                        {{ $blog->judul }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <img src="{{ asset($blog->gambar) }}" alt="Gambar"
                                                            class="img-fluid mb-3" width="100%">
                                                    </div>
                                                    <div class="mb-3">

                                                        <p>{!! $blog->isi !!}</p>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Tutup</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
