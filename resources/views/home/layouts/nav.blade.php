@php
    $images = [
        'padi' => '/img/pngtree-rice-plant-illustration-png-image_6120558.png',
        'cabai' => '/img/chilli-303865_1280.png',
        'bawang-merah' => '/img/pngtree-cartoon-onion-png-image_5880025.png',
    ];
    $imageSrc = $images[$tanaman->nm_tanaman] ?? '/img/default.png'; // Default jika tidak ditemukan
@endphp

<style>
    .nav-color {

        padding: 10px
    }
</style>

<div class="nav-color">

    <div class="dropdown mt-3 ms-lg-5 ms-2">
        <button class="btn btn-outline-success dropdown-toggle " type="button" data-bs-toggle="dropdown"
            aria-expanded="false">
            <img src="{{ $imageSrc }}" alt="" width="30px"> <span
                class="fw-bold">{{ $tanaman->nm_tanaman }}</span>
        </button>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="/{{ request()->segment(1) }}/padi">
                    <img src="/img/pngtree-rice-plant-illustration-png-image_6120558.png" width="30px" alt="">
                    <span> Padi</span>
                </a></li>
            <li><a class="dropdown-item" href="/{{ request()->segment(1) }}/cabai">
                    <img src="/img/chilli-303865_1280.png" alt="" width="30px">
                    <span> Cabai</span>
                </a></li>
            <li><a class="dropdown-item" href="/{{ request()->segment(1) }}/bawang-merah">
                    <img src="/img/pngtree-cartoon-onion-png-image_5880025.png" width="30px" alt="">
                    <span> Bawang Merah</span>
                </a></li>
        </ul>
    </div>
    <hr>

    <style>
        /* Container untuk grid layout */
        .custom-container {
            display: grid;
            grid-template-columns: repeat(6, minmax(250px, 1fr));
        }

        /* Agar kartu tidak menyusut */
        .custom-card {
            flex: 0 0 auto;
        }

        /* Styling kartu */
        .custom-card {
            display: flex;
            border-radius: 16px;
            border: 3px solid green;
            background-color: #e6f4ea;
            padding: 10px;
            text-align: center;
            transition: 0.3s ease-in-out;
            width: 220px;
            height: 60px;
            /* Tinggi lebih besar agar teks tidak terlalu mepet */
            gap: 5px;
            margin: 5px !important;
            /* Jarak antara gambar dan teks */
        }

        .custom-card-active {
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.5);
        }

        /* Gambar dalam kartu */
        .custom-card img {
            max-width: 30px;
            height: 30px;
        }

        /* Judul dalam kartu */
        .custom-card span {
            font-weight: bold;
            text-align: start;
            font-size: 0.8rem;
            align-content: center;
            margin: 0;
            line-height: 1.2;
            /* Jarak antar teks agar lebih rapat */
        }

        /* RESPONSIVE */
        @media (max-width: 992px) {
            .custom-container {
                grid-template-columns: repeat(, 1fr);
                max-width: 100%;
            }

            .custom-card {
                max-width: 200px;
                height: auto;
                padding: 10px;
            }

            .custom-card span {
                font-size: 0.6rem;
            }

            .custom-card img {
                max-width: 35%;
            }
        }

        @media (max-width: 576px) {
            .custom-container {
                overflow-x: auto;
                grid-template-columns: repeat(6, 1fr);
            }

            .custom-card {
                max-width: 180px;
                height: auto;
                padding: 10px;
                gap: 2px;
            }

            .custom-card span {
                font-size: 0.6rem;
            }

            .custom-card img {
                max-width: 20px;
                height: 20px;
            }
        }
    </style>
    <div class="container">
        <div class="wrapper d-flex justify-content-center">
            <div class="custom-container mt-2">
                <a href="/gap/{{ $tanaman->nm_tanaman }}"
                    class="custom-card text-decoration-none  m-3  {{ Request::is('gap/' . $tanaman->nm_tanaman) ? 'custom-card-active' : '' }}"
                    id="link-gap">
                    <img src="/img/icons8-approval-100.png" alt="">
                    <span class="text-sub ms-2 fw-bold">Good Agricultural Practice</span>
                </a>
                <a href="/info-komoditi/{{ $tanaman->nm_tanaman }}"
                    class="custom-card text-decoration-none  m-3  {{ Request::is('info-komoditi/' . $tanaman->nm_tanaman) ? 'custom-card-active' : '' }}"
                    id="link-komoditi">
                    <img src="/img/icons8-futures-100.png" alt="">
                    <span class="text-sub ms-2 fw-bold">Info Komoditi</span>
                </a>
                <a href="/panduan-pestisida/{{ $tanaman->nm_tanaman }}"
                    class="custom-card text-decoration-none  m-3  {{ Request::is('panduan-pestisida/' . $tanaman->nm_tanaman) ? 'custom-card-active' : '' }}"
                    id="link-pestisida">
                    <img src="/img/icons8-task-100.png" alt="">
                    <span class="text-sub ms-2 fw-bold">Panduan Penggunaan Pestisida</span>
                </a>
                <a href="/sebaran-hama/{{ $tanaman->nm_tanaman }}"
                    class="custom-card text-decoration-none  m-3  {{ Request::is('sebaran-hama/' . $tanaman->nm_tanaman) ? 'custom-card-active' : '' }}"
                    id="link-sebaran">
                    <img src="/img/icons8-country-100.png" alt="">
                    <span class="text-sub ms-2 fw-bold">Sebaran Hama dan Penyakit</span>
                </a>
                <a href="/bio-hama/{{ $tanaman->nm_tanaman }}"
                    class="custom-card text-decoration-none  m-3  {{ Request::is('bio-hama/' . $tanaman->nm_tanaman) ? 'custom-card-active' : '' }}"
                    id="link-bio">
                    <img src="/img/icons8-slug-eating-100.png" alt="">
                    <span class="text-sub ms-2 fw-bold">Bio Informasi Hama dan Penyakit</span>
                </a>
                <a href="/kondisi-iklim/{{ $tanaman->nm_tanaman }}"
                    class="custom-card text-decoration-none  m-3 {{ Request::is('kondisi-iklim/' . $tanaman->nm_tanaman) ? 'custom-card-active' : '' }}"
                    id="link-iklim">
                    <img src="/img/icons8-nature-100.png" alt="">
                    <span class="text-sub ms-2 fw-bold">Kondisi Iklim</span>
                </a>
            </div>
        </div>
    </div>
    <hr>
</div>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        let activeCard = document.querySelector(".custom-card-active");

        if (activeCard) {
            activeCard.scrollIntoView({
                behavior: "smooth",
                inline: "center"
            });
        }
    });
</script>
