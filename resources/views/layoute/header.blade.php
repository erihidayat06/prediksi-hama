<nav class="navbar navbar-expand-lg " data-bs-theme="dark" style="background-color: var(--bs-primary-bg-subtle)">
    <div class="container">
        <a class="navbar-brand" href="#">Pedia</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse ms-auto" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('/') ? 'active' : '' }}" href="/">Sebaran</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('informasi') ? 'active' : '' }}" href="/informasi">Bio
                        Informasi Hama Dan Penyakiet</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Informasi Komoditas Penting</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Goot Agricultural Practice</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Market Place</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">kerja Sama antar Daerah</a>
                </li>
                {{-- <li class="nav-item">
                    <a class="nav-link {{ Request::is('resistensi') ? 'active' : '' }}"
                        href="/resistensi">Resistensi</a>
                </li> --}}
            </ul>

        </div>
    </div>
</nav>
