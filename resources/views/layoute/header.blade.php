<nav class="navbar navbar-expand-lg bg-primary" data-bs-theme="dark">
    <div class="container">
        <a class="navbar-brand" href="#">Navbar</a>
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
                        Informasi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">market place</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">kerja sama antar daerah</a>
                </li>
                {{-- <li class="nav-item">
                    <a class="nav-link {{ Request::is('resistensi') ? 'active' : '' }}"
                        href="/resistensi">Resistensi</a>
                </li> --}}
            </ul>

        </div>
    </div>
</nav>
