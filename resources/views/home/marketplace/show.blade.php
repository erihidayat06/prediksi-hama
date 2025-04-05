@extends('home.marketplace.layouts.main')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Start Item Details -->
    <section class="item-details section">
        <div class="container">
            <div class="top-area">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-12 col-12">
                        <div class="product-images">
                            <main id="gallery">
                                @php
                                    $gambarArray = json_decode($produk->gambar, true) ?? [];
                                    $gambarUtama = !empty($gambarArray)
                                        ? asset('storage/' . $gambarArray[0])
                                        : asset('images/no-image.jpg');
                                @endphp

                                <div class="main-img">
                                    <img src="{{ $gambarUtama }}" id="current" alt="{{ $produk->judul }}"
                                        class="img-fluid main-image" />
                                </div>
                                <div class="images">
                                    @foreach ($gambarArray as $gambar)
                                        <img src="{{ asset('storage/' . $gambar) }}" class="img thumbnail-img"
                                            alt="{{ $produk->judul }}" />
                                    @endforeach
                                </div>
                            </main>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-12">
                        <div class="product-info">
                            <h2 class="title">{{ $produk->judul }}</h2>
                            <p class="category">
                                <i class="lni lni-tag"></i> {{ $produk->kategori->nama ?? 'Uncategorized' }}
                            </p>
                            <h3 class="price">Rp {{ number_format($produk->harga, 0, ',', '.') }}/
                                <span>{{ $produk->satuan }}</span>
                            </h3>
                            <p class="info-text">{{ $produk->deskripsi }}</p>
                            <p><strong>Lokasi:</strong> {{ $produk->desa }}, {{ $produk->kecamatan }}</p>
                            <p><strong>Alamat:</strong> {{ $produk->alamat }}</p>
                            <p><strong>No. Telepon:</strong> {{ $produk->no_tlp }}</p>

                            <div class="bottom-content">
                                <div class="row align-items-end">
                                    <div class="col-lg-6 col-md-6 col-12">
                                        <div class="button cart-button">
                                            @auth
                                                <button class="btn add-to-cart-btn" style="width: 100%"
                                                    data-id="{{ $produk->id }}">
                                                    Add to Cart
                                                </button>
                                            @else
                                                <a href="{{ route('login') }}"
                                                    class="btn add-to-cart-btn d-flex justify-content-center align-items-center"
                                                    style="width: 100%; height: 42px;">
                                                    <span>Add to Cart</span>
                                                </a>

                                            @endauth
                                        </div>
                                    </div>

                                    @auth
                                        <div class="col-lg-6 col-md-6 col-12">
                                            <div class="whatsapp-button">
                                                @php
                                                    $nomorTelepon = preg_replace('/[^0-9]/', '', $produk->no_tlp);
                                                    if (substr($nomorTelepon, 0, 1) === '0') {
                                                        $nomorTelepon = '62' . substr($nomorTelepon, 1);
                                                    }
                                                    $waMessage = urlencode(
                                                        "Halo, saya tertarik dengan produk *{$produk->judul}* dengan harga Rp " .
                                                            number_format($produk->harga, 0, ',', '.') .
                                                            ". Bisa berikan detail lebih lanjut? \n\nLink Produk: " .
                                                            url()->current(),
                                                    );
                                                @endphp
                                                <a href="https://wa.me/{{ $nomorTelepon }}?text={{ $waMessage }}"
                                                    target="_blank" class="btn btn-success" style="width: 100%">
                                                    <i class="lni lni-whatsapp"></i> Hubungi via WhatsApp
                                                </a>
                                            </div>
                                        </div>
                                    @endauth
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="product-details-info">
                <div class="single-block">
                    <div class="row">
                        <div class="col-lg-12 col-12">
                            <div class="info-body">
                                <h4>Deskripsi</h4>
                                <p>{{ $produk->deskripsi }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Item Details -->

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const thumbnails = document.querySelectorAll(".thumbnail-img");
            const cartButtons = document.querySelectorAll(".add-to-cart-btn");

            thumbnails.forEach(img => {
                img.addEventListener("click", (e) => {
                    thumbnails.forEach(img => img.style.opacity = 1);
                    document.getElementById("current").src = e.target.src;
                    e.target.style.opacity = 0.6;
                });
            });

            cartButtons.forEach(button => {
                button.addEventListener("click", function() {
                    const productId = this.getAttribute("data-id");
                    addToCart(productId, this);
                });
            });

            function addToCart(productId, button) {
                // ✅ Cegah klik ganda
                button.disabled = true;
                button.innerHTML =
                    `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`;

                fetch(`/cart/check/${productId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.exists) {
                            alert("Produk sudah ada di keranjang!");
                            return null; // Jangan lanjut fetch add jika sudah ada
                        } else {
                            return fetch(`/cart/add/${productId}`, {
                                method: "POST",
                                headers: {
                                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
                                        .getAttribute("content"),
                                    "Content-Type": "application/json",
                                },
                                body: JSON.stringify({
                                    quantity: 1
                                }),
                            });
                        }
                    })
                    .then(response => response ? response.json() : null)
                    .then(data => {
                        if (data) {
                            alert(data.message || "Produk berhasil ditambahkan ke keranjang!");
                            updateCart(); // ✅ Panggil update
                        }
                    })
                    .catch(error => {
                        console.error("Error:", error);
                        alert("Terjadi kesalahan, silakan coba lagi!");
                    })
                    .finally(() => {
                        // ✅ Kembalikan tombol ke semula
                        button.disabled = false;
                        button.innerHTML = `<i class="lni lni-cart"></i> Tambah`;
                    });
            }
        });
    </script>


    <style>
        .main-image {
            width: 100%;
            max-height: 400px;
            object-fit: cover;
            border-radius: 10px;
        }

        .thumbnail-img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            cursor: pointer;
            border-radius: 5px;
        }

        .thumbnail-img:hover {
            opacity: 0.8;
        }
    </style>
@endsection
