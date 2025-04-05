<style>
    .btn-main {
        --bs-btn-color: #F4EEA9 !important;
        --bs-btn-bg: #519259 !important;
        --bs-btn-border-color: #519259 !important;
        --bs-btn-hover-color: #F4EEA9 !important;
        --bs-btn-hover-bg: #457d4c !important;
        --bs-btn-hover-border-color: #48854f !important;
        --bs-btn-focus-shadow-rgb: 49, 132, 253 !important;
        --bs-btn-active-color: #F4EEA9 !important;
        --bs-btn-active-bg: #48854f !important;
        --bs-btn-active-border-color: #457d4c !important;
        --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125) !important;
        --bs-btn-disabled-color: #F4EEA9 !important;
        --bs-btn-disabled-bg: #519259 !important;
        --bs-btn-disabled-border-color: #519259 !important;
        border-radius: 20px !important;
        padding: 5px 10px !important;
    }

    .btn-main-sub {
        --bs-btn-color: #F4EEA9 !important;
        --bs-btn-bg: #084e3c !important;
        --bs-btn-border-color: #064635 !important;
        --bs-btn-hover-color: #F4EEA9 !important;
        --bs-btn-hover-bg: #084e3c !important;
        --bs-btn-hover-border-color: #084e3c !important;
        --bs-btn-focus-shadow-rgb: 49, 132, 253 !important;
        --bs-btn-active-color: #F4EEA9 !important;
        --bs-btn-active-bg: #084e3c !important;
        --bs-btn-active-border-color: #084e3c !important;
        --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125) !important;
        --bs-btn-disabled-color: #F4EEA9 !important;
        --bs-btn-disabled-bg: #064635 !important;
        --bs-btn-disabled-border-color: #064635 !important;
        border-radius: 20px !important;
        padding: 5px 10px !important;
    }

    .bg-main {
        background-color: #064635 !important;


    }

    .text-main {
        color: #F0BB62 !important;
    }

    .text-sub {
        color: #519259 !important;
    }
</style>
<nav class="navbar navbar-expand-lg bg-main d-none d-lg-block" data-bs-theme="dark">
    <div class="container">
        <a class="navbar-brand text-main" href="/"><img src="/img/logo-pedia-main.png" alt=""
                width="80px"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class=" justify-content-end" id="navbarNav">
            <ul class="navbar-nav {{ Request::is('marketplace*') ? 'p-3' : '' }} ">
                <li class="nav-item">
                    <a class="nav-link text-main {{ Request::is('/') ? 'fw-bold' : '' }}" href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-main {{ Request::is('blog') ? 'fw-bold ' : '' }}" href="/blog">Blog</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-main {{ Request::is('marketplace*') ? 'fw-bold ' : '' }}"
                        href="/marketplace">Market Place</a>
                </li>
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-main" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            {{ auth()->user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="/">Profile</a></li> {{-- You can add profile link --}}
                            <li class="nav-item">
                                <a class="dropdown-item" href="/marketplace/produk-saya">
                                    Produk
                                    saya</a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link text-main" href="{{ route('login') }}">Login</a>
                    </li>

                    <li class="nav-item">
                        <a class="btn btn-main mt-1 ms-2  {{ Request::is('marketplace*') ? 'd-none' : '' }}"
                            href="{{ route('register') }}">Sign up</a>
                    </li>
                @endauth


                {{-- <li class="nav-item">
                    <a class="nav-link {{ Request::is('resistensi') ? 'active' : '' }}"
                        href="/resistensi">Resistensi</a>
                </li> --}}
            </ul>

        </div>
    </div>
</nav>

<nav class="navbar bg-main  d-block d-lg-none ">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold text-white" href="#">Pedia</a>
    </div>
</nav>
