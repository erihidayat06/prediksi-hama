@extends('layoute.main')

@section('content')
    <div class="container py-5">
        <div class="row">
            <!-- Kolom Kiri: Media Sosial -->
            <div class="col-lg-2 d-none d-lg-block">
                <div class="sticky-top" style="top: 20px;">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h4>Ikuti Kami</h4>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <a href="#" class="text-decoration-none">
                                    <i class="bi bi-facebook me-2"></i> Facebook
                                </a>
                            </li>
                            <li class="list-group-item">
                                <a href="#" class="text-decoration-none">
                                    <i class="bi bi-twitter me-2"></i> Twitter
                                </a>
                            </li>
                            <li class="list-group-item">
                                <a href="#" class="text-decoration-none">
                                    <i class="bi bi-instagram me-2"></i> Instagram
                                </a>
                            </li>
                            <li class="list-group-item">
                                <a href="#" class="text-decoration-none">
                                    <i class="bi bi-youtube me-2"></i> YouTube
                                </a>
                            </li>
                            <li class="list-group-item">
                                <a href="#" class="text-decoration-none">
                                    <i class="bi bi-linkedin me-2"></i> LinkedIn
                                </a>
                            </li>
                        </ul>

                    </div>
                </div>
            </div>

            <!-- Kolom Utama: Blog Detail -->
            <div class="col-lg-7">
                <div class="card border-0 rounded mb-4">
                    <img src="{{ asset($blog->gambar) }}" class="card-img-top" alt="{{ $blog->judul }}">
                    <div class="card-body">
                        <h3 class="card-title mb-4 fw-bold">{{ $blog->judul }}</h3>
                        <p class="text-muted mb-3"><small>Diposting pada: {{ $blog->created_at->format('d M Y') }}. Dilihat:
                                {{ $blog->lihat }}x </small>
                        </p>

                        <div class="blog-content">
                            <div class="keterangan">{!! $blog->isi !!}</div> <!-- Isi blog dengan format -->
                        </div>
                    </div>
                </div>

                <!-- Berita Terkait -->
                <div class="related-blogs">
                    <h3 class="mb-4">Berita Terkait</h3>
                    <div class="row row-cols-2 row-cols-lg-3">
                        @foreach ($relatedBlogs as $related)
                            <div class="col-md-4 mb-3">
                                <a href="{{ route('blog.show.home', $related->slug) }}" class="text-decoration-none">
                                    <div class="card h-100">
                                        <img src="{{ asset($related->gambar) }}" class="card-img-top"
                                            alt="{{ $related->judul }}">
                                        <div class="card-body ">
                                            <h6 class="card-title fw-bold">{{ Str::limit($related->judul, 20, '...') }}</h6>
                                            <p class="card-text">{!! Str::limit($related->isi, 50, '...') . '</div>' !!}</p>

                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Sidebar: Berita Terpopuler (Sticky) -->
            <div class="col-lg-3">
                <div class="sticky-top" style="top: 20px;">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h4>Berita Terpopuler</h4>
                        </div>
                        <ul class="list-group list-group-flush">
                            @foreach ($popularBlogs as $popular)
                                <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <img src="{{ asset($popular->gambar) }}" class="me-3" width="50"
                                        alt="Berita Terbaru {{ $popular->judul }}">
                                    {{ Str::limit($popular->judul, 30, '...') }}
                                </a>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
