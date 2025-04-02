<style>
    .btn-main {
        --bs-btn-color: #F4EEA9;
        --bs-btn-bg: #519259;
        --bs-btn-border-color: #519259;
        --bs-btn-hover-color: #F4EEA9;
        --bs-btn-hover-bg: #457d4c;
        --bs-btn-hover-border-color: #48854f;
        --bs-btn-focus-shadow-rgb: 49, 132, 253;
        --bs-btn-active-color: #F4EEA9;
        --bs-btn-active-bg: #48854f;
        --bs-btn-active-border-color: #457d4c;
        --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
        --bs-btn-disabled-color: #F4EEA9;
        --bs-btn-disabled-bg: #519259;
        --bs-btn-disabled-border-color: #519259;
        border-radius: 20px;
        padding: 5px 10px;
    }

    .bg-main {
        background-color: #064635;


    }

    .text-main {
        color: #F0BB62;
    }

    .text-sub {
        color: #519259;
    }
</style>
<nav class="navbar navbar-expand-lg bg-main fixed-top d-none d-lg-block" data-bs-theme="dark">
    <div class="container">
        <a class="navbar-brand text-main" href="/">Pedia</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse ms-auto" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link text-main {{ Request::is('/') ? 'fw-bold' : '' }}" href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-main {{ Request::is('blog') ? 'fw-bold ' : '' }}" href="/blog">Blog</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-main {{ Request::is('informasi') ? 'fw-bold' : '' }}"
                        href="/informasi">Informasi
                        Komoditas</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-main" href="#">Market Place</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-main" href="/login">Login</a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-sm btn-main mt-1 ms-3 align-items-center" href="/register">Sign up</a>
                </li>
                {{-- <li class="nav-item">
                    <a class="nav-link {{ Request::is('resistensi') ? 'active' : '' }}"
                        href="/resistensi">Resistensi</a>
                </li> --}}
            </ul>

        </div>
    </div>

</nav>

<nav class="navbar d-block d-lg-none bg-success">
    <div class="container-fluid">
        <!-- Tombol Kembali dan Teks Dinamis -->
        <a class="navbar-brand d-flex align-items-center" href="javascript:history.back();">
            <i class="bi bi-arrow-left text-white"></i>
            <span class="text-white ms-2" style="font-size: 15px;">
                @if (Request::is('gap/' . $tanaman->nm_tanaman))
                    Good Agricultural Practice
                @elseif (Request::is('info-komoditi/' . $tanaman->nm_tanaman))
                    Info Komoditi
                @elseif (Request::is('panduan-pestisida/' . $tanaman->nm_tanaman))
                    Panduan Penggunaan Pestisida
                @elseif (Request::is('sebaran-hama/' . $tanaman->nm_tanaman))
                    Sebaran Hama dan Penyakit
                @elseif (Request::is('bio-hama/' . $tanaman->nm_tanaman))
                    Bio Informasi Hama dan Penyakit
                @elseif (Request::is('kondisi-iklim/' . $tanaman->nm_tanaman))
                    Kondisi Iklim
                @endif
            </span>
        </a>
    </div>
</nav>
