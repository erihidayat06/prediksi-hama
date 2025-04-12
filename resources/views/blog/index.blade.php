@extends('layoute.main')

@section('content')
    <style>
        .carousel-item {
            position: relative;
        }

        .carousel-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            /* Warna hitam transparan */
            z-index: 1;
        }

        .carousel-caption {
            position: absolute;
            z-index: 2;
        }

        .carousel-item img {
            height: 400px;
            /* Sesuaikan tinggi */
            object-fit: cover;
            /* Hindari distorsi */
        }
    </style>

    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-md-8">
                {{-- Berita Utama dengan Carousel --}}
                <div id="beritaUtamaCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @foreach ($blogs as $index => $blog)
                            <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                <div class="carousel-overlay"></div> <!-- Overlay -->
                                <a href="/blog/{{ $blog->slug }}">
                                    <img src="{{ asset($blog->gambar) }}" class="d-block w-100"
                                        alt="Berita Utama {{ $index + 1 }}">
                                    <div class="carousel-caption  text-start">
                                        <h2 class=" fw-bold">{{ $blog->judul }}</h2>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>

                    <button class="carousel-control-prev" type="button" data-bs-target="#beritaUtamaCarousel"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#beritaUtamaCarousel"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>

                {{-- Berita Trending --}}
                <div class="berita-trending mt-4">
                    <h2>Berita Trending</h2>
                    <div class="row row-cols-2 row-cols-lg-4">
                        @foreach ($trendingBlogs as $index => $trending)
                            <div class="col">
                                <a class="text-decoration-none" href="/blog/{{ $trending->slug }}">
                                    <div class="card h-100">
                                        <img src="{{ asset($trending->gambar) }}" class="card-img-top"
                                            alt="Berita Trending ">
                                        <div class="card-body">
                                            <p class="card-title fw-bold">{{ Str::limit($trending->judul, 15, '...') }}</p>
                                            {{-- <p class="card-text">Ringkasan trending {{ $i }}...</p> --}}
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Berita Terbaru --}}
                <div class="berita-terbaru mt-4">
                    <h2>Berita Terbaru</h2>
                    <div class="row ">
                        @foreach ($blogs as $index => $blog)
                            <div class="col-md-6 mb-2"> {{-- Dua kolom pada ukuran medium ke atas --}}
                                <a href="/blog/{{ $blog->slug }}"
                                    class="list-group-item list-group-item-action d-flex align-items-center p-3 border rounded shadow-sm mb-3">
                                    <img src="{{ asset($blog->gambar) }}" class="me-3 flex-shrink-0 rounded" width="50"
                                        alt="Berita Terbaru {{ Str::limit($blog->judul, 30, '...') }}">
                                    <div class="judul-berita">
                                        {{ Str::limit($blog->judul, 30, '...') }}
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                {{-- Sidebar --}}
                <div class="sidebar">
                    <h3>Berita Populer</h3>
                    <ul class="list-group">
                        @foreach ($popularBlogs as $index => $popular)
                            <a
                                href="/blog/{{ $popular->slug }}"class="list-group-item list-group-item-action d-flex align-items-center">
                                <img src="{{ asset($popular->gambar) }}" class="me-3" width="50"
                                    alt="Berita Terbaru {{ $popular->judul }}">
                                {{ Str::limit($popular->judul, 30, '...') }}
                            </a>
                        @endforeach
                    </ul>

                    {{-- <h3>Kategori</h3>
                    <ul class="list-group">
                        <li class="list-group-item"><a href="#">Politik</a></li>
                        <li class="list-group-item"><a href="#">Olahraga</a></li>
                        <li class="list-group-item"><a href="#">Teknologi</a></li>
                    </ul> --}}
                </div>
            </div>
        </div>
    </div>
@endsection
