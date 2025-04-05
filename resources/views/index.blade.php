@extends('layoute.main')

@section('content')
    @php
        $tanamanTerpilih = request('tanaman', 'cabai'); // Default 'cabai' jika tidak ada di URL
    @endphp
    <!-- Tambahkan CSS untuk Overlay -->
    <section class="section  bg-main  rounded-bottom d-none d-lg-block">
        <div class="container">
            <div class="row row-cols-1 row-cols-lg-2 ">
                <div class="col-lg-6" style="margin: 260px 0px;">
                    <div class="text-main ">
                        <h1 class="fw-bold">
                            PREDIKSI PENYEBARAN HAMA <br>
                            KABUPATEN BREBES
                        </h1>
                        <a href="#prediksi" class="btn btn-main px-4 mt-5">
                            Lihat Prediksi
                        </a>
                    </div>
                </div>

                <div class="col-lg-6 text-end " style="margin: 50px 0px">
                    @include('homepeta')
                </div>
            </div>
        </div>
    </section>



    <div class="text-center">
        <h2 class="fw-bold text-sub p-5">Brebes Plant Pest and Disease Mapping</h2>
    </div>
    <style>
        .border-green {
            border: 5px solid #519259 !important;
        }

        .background-green {
            background-color: #EBFFFD !important;
        }

        /* Wrapper utama agar konten tetap di tengah */
        .wrapper {
            display: flex;
            justify-content: center;
        }

        /* Container untuk grid layout */
        .custom-container-commodity {
            display: grid;
            grid-template-columns: repeat(3, minmax(180px, 1fr));
            gap: 30px;
        }

        /* Styling kartu komoditas */
        .custom-card-commodity {
            border-radius: 16px;
            border: 5px solid green;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 12px;
            text-align: center;
            transition: 0.3s ease-in-out;
            max-width: 300px;
            height: 170px;
            cursor: pointer;
            position: relative;
        }

        /* Pastikan gambar berada di tengah */
        .custom-card-commodity img {
            max-width: 40%;
            height: auto;
            margin: auto;
        }

        /* Buat teks mentok di bawah */
        .custom-card-commodity h3 {
            font-weight: bold;
            font-size: 1.5rem;
            margin-top: auto;
            margin: 0px;
            padding: 0px;
        }

        /* Hilangkan default radio button */
        .custom-card-commodity input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
        }

        /* Tambahkan shadow hanya ke card yang dipilih */
        .custom-card-commodity:has(input:checked) {
            box-shadow: 6px 6px 0px #4e807b;
        }


        /* RESPONSIVE */
        @media (max-width: 992px) {
            .custom-container-commodity {
                grid-template-columns: repeat(3, minmax(160px, 1fr));
            }

            .custom-card-commodity {
                max-width: 180px;
            }

            .custom-card-commodity h3 {
                font-size: 0.9rem;
            }

            .custom-card-commodity img {
                max-width: 100%;
            }
        }

        @media (max-width: 576px) {
            .custom-container-commodity {
                grid-template-columns: repeat(3, minmax(90px, 0.5fr));
            }

            .custom-card-commodity {
                max-width: 130px;
                padding: 5px;
                height: 110px;
            }

            .custom-card-commodity h3 {
                font-size: 0.9rem;
            }

            .custom-card-commodity img {
                max-width: 70%;
            }
        }
    </style>

    <div class="container">
        <div class="wrapper">
            <div class="custom-container-commodity">
                <label class="custom-card-commodity">
                    <input type="radio" name="commodity" value="padi" checked>
                    <img src="/img/pngtree-rice-plant-illustration-png-image_6120558.png" alt="">
                    <h3 class="text-sub">Padi</h3>
                </label>

                <label class="custom-card-commodity">
                    <input type="radio" name="commodity" value="cabai">
                    <img src="/img/chilli-303865_1280.png" alt="">
                    <h3 class="text-sub">Cabai</h3>
                </label>

                <label class="custom-card-commodity">
                    <input type="radio" name="commodity" value="bawang-merah">
                    <img src="/img/pngtree-cartoon-onion-png-image_5880025.png" alt="">
                    <h3 class="text-sub">Bawang Merah</h3>
                </label>
            </div>
        </div>
    </div>





    <style>
        /* Container untuk grid layout */
        .custom-container {
            display: grid;
            grid-template-columns: repeat(3, minmax(200px, 1fr));


        }

        /* Styling kartu */
        .custom-card {
            border-radius: 16px;
            border: 5px solid green;
            background-color: #e6f4ea;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
            padding: 12px;
            text-align: center;
            transition: 0.3s ease-in-out;
            max-width: 220px;
        }

        /* Gambar dalam kartu */
        .custom-card img {
            margin-bottom: 5px;
            max-width: 25%;
            height: auto;
        }

        /* Judul dalam kartu */
        .custom-card h5 {
            font-weight: bold;
            margin: 0;
            font-size: 0.9rem;
        }

        /* RESPONSIVE */
        @media (max-width: 992px) {
            .custom-container {
                grid-template-columns: repeat(2, 1fr);
                max-width: 100%;
            }

            .custom-card {
                max-width: 200px;
            }

            .custom-card h5 {
                font-size: 0.85rem;
            }

            .custom-card img {
                max-width: 30%;
            }
        }

        @media (max-width: 576px) {
            .custom-container {
                grid-template-columns: repeat(2, 1fr);
            }

            .custom-card {
                max-width: 180px;
                height: auto;
                padding: 10px;
            }

            .custom-card h5 {
                font-size: 0.8rem;
            }

            .custom-card img {
                max-width: 25%;
            }
        }
    </style>


    <div class="wrapper d-flex justify-content-center">
        <div class="custom-container mt-4">
            <a href="" class="custom-card text-decoration-none m-3" id="link-gap">
                <img src="/img/icons8-approval-100.png" alt="">
                <h5 class="text-sub fw-bold">Good Agricultural Practice</h5>
            </a>
            <a href="" class="custom-card text-decoration-none m-3" id="link-komoditi">
                <img src="/img/icons8-futures-100.png" alt="">
                <h5 class="text-sub fw-bold">Info Komoditi</h5>
            </a>
            <a href="" class="custom-card text-decoration-none m-3" id="link-pestisida">
                <img src="/img/icons8-task-100.png" alt="">
                <h5 class="text-sub fw-bold">Panduan Penggunaan Pestisida</h5>
            </a>
            <a href="" class="custom-card text-decoration-none m-3" id="link-sebaran">
                <img src="/img/icons8-country-100.png" alt="">
                <h5 class="text-sub fw-bold">Sebaran Hama dan Penyakit</h5>
            </a>
            <a href="" class="custom-card text-decoration-none m-3" id="link-bio">
                <img src="/img/icons8-slug-eating-100.png" alt="">
                <h5 class="text-sub fw-bold">Bio Informasi Hama dan Penyakit</h5>
            </a>
            <a href="" class="custom-card text-decoration-none m-3" id="link-iklim">
                <img src="/img/icons8-nature-100.png" alt="">
                <h5 class="text-sub fw-bold">Kondisi Iklim</h5>
            </a>
        </div>
    </div>

    <!-- Include jQuery jika belum ada -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            const links = {
                "link-gap": "/gap/",
                "link-komoditi": "/info-komoditi/",
                "link-pestisida": "/panduan-pestisida/",
                "link-sebaran": "/sebaran-hama/",
                "link-bio": "/bio-hama/",
                "link-iklim": "/kondisi-iklim/"
            };

            function updateLinks() {
                let selectedCommodity = $('input[name="commodity"]:checked').val();
                $.each(links, function(id, baseHref) {
                    $("#" + id).attr("href", baseHref + selectedCommodity);
                });
            }

            $('input[name="commodity"]').change(updateLinks);
            updateLinks(); // Set href saat halaman pertama kali dimuat
        });
    </script>

    <div class="bg-main mt-5">
        <div class="container">
            <div class="row row-cols-1 row-cols-lg-2 align-items-center text-center text-lg-start">
                <div class="col-lg-8 mb-4 text-center">
                    <h1 class="text-main fw-bold mt-3">“Tandur becik, panen apik”</h1>
                    <p class="text-main">
                        Dalam dunia pertanian, menjaga kesehatan tanaman adalah kunci keberhasilan.
                        Jangan biarkan penyakit merusak jerih payah Anda! Kami hadir untuk memberikan solusi terbaik,
                        mulai dari informasi penyebaran penyakit hingga produk perlindungan tanaman berkualitas.
                        Mari bersama wujudkan pertanian yang sehat dan berkelanjutan!
                    </p>
                </div>
                <div class="col-lg-4 text-center">
                    <img src="https://png.pngtree.com/png-vector/20240724/ourmid/pngtree-agrarian-fertilizers-and-farming-pest-control-png-image_13046265.png"
                        alt="" class="img-fluid mx-auto d-block" style="max-width: 80%;">
                </div>
            </div>
        </div>
    </div>

    <section>
        <div class="container">

            <h3 class="mt-3 fw-bold text-sub">Berita Terkini</h3>

            @if ($blogs->count() > 0)
                <div class="row row-cols-1 row-cols-md-3 row-cols-lg-5 g-4">
                    @foreach ($blogs as $blog)
                        <div class="col">
                            <a href="{{ route('blog.show.home', $blog->slug) }}" class="text-decoration-none">
                                <div class="card">
                                    <img src="{{ asset($blog->gambar) }}" class="card-img-top" alt="{{ $blog->judul }}">
                                    <div class="card-body">
                                        <p class="card-title fw-bold text-capitalize">
                                            {{ Str::limit($blog->judul, 30, '...') }}
                                        </p>
                                        <p class="text-secondary" style="font-size: 14px">
                                            {{ $blog->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-muted text-center mt-3">Tidak ada berita terkini.</p>
            @endif

        </div>
    </section>


    {{-- <footer class="bg-main mt-5 text-center text-main">
        &copy; 2025
    </footer> --}}
@endsection
