@extends('home.marketplace.layouts.main')

@section('content')
    <div class="container mt-5 mb-5">
        <div class="row row-cols-1 row-cols-lg-2">
            @include('home.marketplace.layouts.menu')
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title fw-bold">
                            <h3>Daftar produk saya</h3>
                        </div>

                        @if ($produks->count())
                            <div class="row row-cols-1 row-cols-md-2 g-4 mt-3">
                                @foreach ($produks as $produk)
                                    @php
                                        $gambar = json_decode($produk->gambar, true);
                                        $gambarPath =
                                            !empty($gambar) && isset($gambar[0])
                                                ? asset('storage/' . ltrim($gambar[0], '/'))
                                                : asset('images/default.png');

                                        $judul =
                                            strlen($produk->judul) > 50
                                                ? substr($produk->judul, 0, 50) . '...'
                                                : $produk->judul;
                                    @endphp

                                    <div class="col">
                                        <div class="card h-100 shadow-sm">
                                            <a href="{{ route('produk.show', $produk->slug) }}">
                                                <img src="{{ $gambarPath }}" class="card-img-top"
                                                    alt="{{ $produk->judul }}" style="height: 200px; object-fit: cover;">
                                            </a>
                                            <div class="card-body">
                                                <h5 class="card-title">
                                                    <a href="{{ route('produk.show', $produk->slug) }}"
                                                        class="text-decoration-none text-dark">
                                                        {{ $judul }}
                                                    </a>
                                                </h5>
                                                <p class="card-text text-success fw-bold">
                                                    Rp {{ number_format($produk->harga, 0, ',', '.') }}
                                                </p>



                                            </div>
                                            <div class="card-footer d-flex justify-content-between align-items-center">
                                                <form action="{{ route('produk.toggleStatus', $produk->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit"
                                                        class="badge border-0 bg-{{ $produk->aktive ? 'success' : 'secondary' }}">
                                                        {{ $produk->aktive ? 'Aktif' : 'Nonaktif' }}
                                                    </button>
                                                </form>

                                                <div>
                                                    <a href="{{ route('produk.edit', $produk->id) }}"
                                                        class="btn btn-sm btn-outline-primary">Edit</a>

                                                    <form action="{{ route('produk.destroy', $produk->id) }}"
                                                        method="POST" class="d-inline"
                                                        onsubmit="return confirm('Yakin ingin menghapus produk ini?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-sm btn-outline-danger">Hapus</button>
                                                    </form>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="alert alert-info mt-3">
                                Belum ada produk yang ditambahkan.
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
