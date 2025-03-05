@extends('layoute.main')

@section('content')
    <style>
        .card-container {
            position: relative;
            top: -80px;
            /* Angka ini bisa disesuaikan untuk menyesuaikan posisi */
            z-index: 10;
        }

        .card2 {
            height: 100%;
            /* Pastikan semua card memiliki tinggi penuh */
            display: flex;
            align-items: stretch;
            /* Membuat tinggi card mengikuti isi terpanjang */
        }



        /* Pastikan semua card-body sejajar */
        .cord-body2 {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            gap: 5px;
            /* Jarak antara ikon dan teks */
            height: 100%;
        }

        /* Khusus untuk card Market Place - Turunkan ikon dan teks */
        .card-2:nth-child(4) i {
            margin-top: 5px;
            /* Turunkan ikon sedikit */
        }

        /* Pastikan semua teks memiliki tinggi yang sama */
        .cord-body2 p {
            min-height: 50px;
            /* Sesuaikan tinggi teks agar sejajar */
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        /* Khusus untuk card Market Place - Turunkan teks agar sejajar */
        .card-2:nth-child(4) p {
            margin-top: 10px;
            /* Sesuaikan angka ini jika masih kurang */
        }
    </style>
    @php
        $tanamanTerpilih = request('tanaman', 'cabai'); // Default 'cabai' jika tidak ada di URL
    @endphp
    <!-- Tambahkan CSS untuk Overlay -->
    <section class="section  bg-main">
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

                <div class="col-lg-6 text-end d-none d-lg-block" style="margin: 50px 0px">
                    @include('peta')
                </div>
            </div>
        </div>
    </section>



    <!-- Card dibuat "mengambang" di antara kedua section -->
    <div class="container card-container">
        <div class="row row-cols-1 row-cols-lg-4 g-3">
            <div class="col text-center">
                <div class="card card-2 rounded-4 shadow border border-0">
                    <div class="card-body cord-body2">
                        <p><i class="bi bi-info-circle text-sub fs-2"></i></p>
                        <p class="text-sub fw-bold">Informasi <br> Penyebaran Hama</p>
                    </div>
                </div>
            </div>
            <div class="col text-center">
                <div class="card card-2 rounded-4 shadow border border-0">
                    <div class="card-body cord-body2">
                        <p><i class="bi bi-calendar2-week text-sub fs-2"></i></p>
                        <p class="text-sub fw-bold">Good <br> Agricultural Practice</p>
                    </div>
                </div>
            </div>
            <div class="col text-center">
                <div class="card card-2 rounded-4 shadow border border-0">
                    <div class="card-body cord-body2">
                        <p><i class="bi bi-card-checklist text-sub fs-2"></i></p>
                        <p class="text-sub fw-bold">Informasi <br> Komoditas Penting</p>
                    </div>
                </div>
            </div>
            <div class="col text-center">
                <div class="card card-2 rounded-4 shadow border border-0">
                    <div class="card-body cord-body2">
                        <p><i class="bi bi-shop text-sub fs-2"></i></p>
                        <p class="text-sub fw-bold">Market Place</p>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="container mt-5 mb-5" id="prediksi">


        <div class="text-center mt-3">

            <ul class="nav  mb-3 nav-underline justify-content-center" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a href="#" class="nav-link active text-sub fw-bold" id="pills-home-tab" data-bs-toggle="pill"
                        data-bs-target="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Geografi
                        hama dan
                        penyakit</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a href="#" class="nav-link text-sub fw-bold" id="pills-profile-tab" data-bs-toggle="pill"
                        data-bs-target="#pills-profile" role="tab" aria-controls="pills-profile"
                        aria-selected="false">Bio Informasi Hama
                        Dan Penyakit</a>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab"
                    tabindex="0">
                    <h2 class="mb-4 text-center">Perkiraan Penyebaran Hama Kabupaten Brebes dari
                        {{ now()->subDays(14)->format('d F Y') }} s.d
                        {{ now()->addDays(7)->format('d F Y') }}</h2>


                    <form id="tanamanForm" action="/">
                        <select class="form-select" id="tanamanSelect" name="tanaman">
                            <option value="cabai" {{ $tanamanTerpilih == 'cabai' ? 'selected' : '' }}>Cabai
                            </option>
                            <option value="Padi" {{ $tanamanTerpilih == 'Padi' ? 'selected' : '' }}>Padi</option>
                            <option value="bawang merah" {{ $tanamanTerpilih == 'bawang merah' ? 'selected' : '' }}>
                                Bawang Merah
                            </option>
                        </select>
                    </form>

                    <script>
                        document.getElementById("tanamanSelect").addEventListener("change", function() {
                            this.form.submit(); // Kirim form saat memilih tanaman
                        });
                    </script>
                    <div class="row">
                        <div class="col-lg-8">
                            @include('peta')
                        </div>
                        <div class="col-lg-4  d-flex align-items-center">
                            <div class="card text-start w-100">
                                <div class="card-body">
                                    <h3 class="card-title">
                                        Prediksi hama !
                                    </h3>
                                    @if ($tanamanTerpilih == 'cabai')
                                        <ul class="p-0">
                                            <li class="list-group-item"><i class="bi bi-square-fill merah-text"></i> Thrips
                                                SPP
                                            </li>
                                            <li class="list-group-item"><i class="bi bi-square-fill hijau-text"></i> Bemesia
                                                Tabacci
                                            </li>
                                            <li class="list-group-item"><i class="bi bi-square-fill oren-text"></i> Lalat
                                                Buah
                                            </li>
                                        </ul>
                                    @elseif ($tanamanTerpilih == 'Padi')
                                        <ul class="p-0">
                                            <li class="list-group-item"><i class="bi bi-square-fill merah-text"></i> Wereng
                                                Batang
                                            </li>
                                            <li class="list-group-item"><i class="bi bi-square-fill hijau-text"></i>
                                                Penggerek
                                                batang padi
                                                Tabacci
                                            </li>
                                            <li class="list-group-item"><i class="bi bi-square-fill oren-text"></i> Padi
                                                Cokelat
                                            </li>
                                            <li class="list-group-item"><i class="bi bi-square-fill kuning-text"></i> Walang
                                                sangit
                                            </li>
                                        </ul>
                                    @else
                                        <ul class="p-0">
                                            <li class="list-group-item"><i class="bi bi-square-fill merah-text"></i> Thrips
                                                tabacci
                                            </li>
                                            <li class="list-group-item"><i class="bi bi-square-fill hijau-text"></i> Ulat
                                                Bawang
                                                Merah

                                            </li>
                                            <li class="list-group-item"><i class="bi bi-square-fill oren-text"></i>
                                                Fusarium
                                            </li>
                                        </ul>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab"
                    tabindex="0">
                    @include('cuaca')

                </div>
            </div>

        </div>
    </div>
    </div>

    <div class="bg-main">
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

            <h2 class="mt-3 fw-bold text-sub">Berita Terkini</h2>
            <div class="row row-cols-1 row-cols-md-3 g-4">
                <div class="col">
                    <div class="card">
                        <img src="..." class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Card title</h5>
                            <p class="card-text">This is a longer card with supporting text below as a natural lead-in to
                                additional content. This content is a little bit longer.</p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card">
                        <img src="..." class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Card title</h5>
                            <p class="card-text">This is a longer card with supporting text below as a natural lead-in to
                                additional content. This content is a little bit longer.</p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card">
                        <img src="..." class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Card title</h5>
                            <p class="card-text">This is a longer card with supporting text below as a natural lead-in to
                                additional content.</p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card">
                        <img src="..." class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Card title</h5>
                            <p class="card-text">This is a longer card with supporting text below as a natural lead-in to
                                additional content. This content is a little bit longer.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <footer class="bg-main mt-5 text-center text-main">
        &copy; 2025
    </footer>
@endsection
