@extends('home.marketplace.layouts.main')

@section('content')
    @if (!request()->has('q'))
        <!-- Start Hero Area -->
        <section class="hero-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-12 custom-padding-right">
                        <div class="slider-head">
                            <!-- Start Hero Slider -->
                            <div class="hero-slider">
                                <!-- Start Single Slider -->
                                <div class="single-slider"
                                    style="
                    background-image: url(/img/bg-padi.jpg);
                  ">
                                    <div class="content">
                                        <h2>
                                            <span>Harga Termurah</span>
                                            Langsung dari petani
                                        </h2>
                                        <p>
                                            Daoatkan padi berkualitas yang dijual langsung dari petani yang ada di brebes
                                        </p>

                                        <div class="button">
                                            <a href="product-grids.html" class="btn">Shop Now</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Single Slider -->
                                <!-- Start Single Slider -->
                                <div class="single-slider"
                                    style="
                    background-image: url(/img/bg-bawang.jpg);
                  ">
                                    <div class="content">
                                        <h2>
                                            <span>Bawang Asli Brebes</span>
                                            Tak Perlu diragukan Kualitasnya
                                        </h2>
                                        <p>
                                            Di Panen langsung olah petani brebes. Bawang yang terkenal dibrebes
                                        </p>
                                        <div class="button">
                                            <a href="product-grids.html" class="btn">Shop Now</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Single Slider -->
                            </div>
                            <!-- End Hero Slider -->
                        </div>
                    </div>
                    <div class="col-lg-4 col-12">
                        <div class="row">
                            <div class="col-lg-12 col-md-6 col-12 md-custom-padding">
                                <!-- Start Small Banner -->
                                <div class="hero-small-banner"
                                    style="
                    background-image: url('/img/bg-bibt.png');
                  ">
                                    <div class="content">
                                        <h2>
                                            <span>Dapatkan bibit berkualitas</span>
                                            Yang dirawat dengan baik
                                        </h2>

                                    </div>
                                </div>
                                <!-- End Small Banner -->
                            </div>
                            <div class="col-lg-12 col-md-6 col-12">
                                <!-- Start Small Banner -->
                                <div class="hero-small-banner style2">
                                    <div class="content">
                                        <h2>Weekly Sale!</h2>
                                        <p>
                                            Saving up to 50% off all online store items this week.
                                        </p>
                                        <div class="button">
                                            <a class="btn" href="product-grids.html">Shop Now</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- Start Small Banner -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Hero Area -->
    @endif

    <!-- Start Trending Product Area -->
    <section class="trending-product section" style="margin-top: 12px">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h2>Produk</h2>
                        @if (request()->has('q'))
                            <p class="text-muted">Hasil pencarian untuk: <strong>{{ request('q') }}</strong></p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="row">
                @foreach ($produk as $item)
                    <div class="col-lg-3 col-md-6 col-12">
                        <!-- Start Single Product -->
                        <div class="single-product">
                            <div class="product-image">
                                <img src="{{ asset('storage/' . json_decode($item->gambar, true)[0]) }}"
                                    alt="{{ Str::limit($item->judul, 50, '...') }}" />
                                <div class="button">
                                    <a href="{{ route('produk.show', $item->slug) }}" class="btn"><i
                                            class="bi bi-eye"></i>
                                        Lihat</a>
                                </div>
                            </div>
                            <div class="product-info">
                                <span class="category">{{ $item->kecamatan }}, {{ $item->desa }}</span>
                                <h4 class="title">
                                    <a
                                        href="{{ route('produk.show', $item->slug) }}">{{ Str::limit($item->judul, 50, '...') }}</a>
                                </h4>

                                <div class="price">
                                    <span>Rp {{ number_format($item->harga, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                        <!-- End Single Product -->
                    </div>
                @endforeach


            </div>
        </div>
    </section>
    <!-- End Trending Product Area -->
@endsection
