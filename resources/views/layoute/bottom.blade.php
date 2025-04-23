<style>
    .fixed-bottom {
        position: fixed !important;
        bottom: 0 !important;
    }

    .nav-link.active {
        color: #fff;
        font-weight: bold;
    }
</style>

<nav class="navbar-dark bg-main fixed-bottom d-block d-lg-none">
    <div class="container-fluid d-flex justify-content-around">
        <a href="/"
            class="text-light text-decoration-none text-center nav-link {{ request()->is('/') ? 'active' : '' }}">
            <i class="bi bi-house-door"></i><br>Home
        </a>
        <a href="/marketplace"
            class="text-light text-decoration-none text-center nav-link {{ request()->is('marketplace') ? 'active' : '' }}">
            <i class="bi bi-shop"></i><br>Marketplace
        </a>
        <a href="/blog"
            class="text-light text-decoration-none text-center nav-link {{ request()->is('blog') ? 'active' : '' }}">
            <i class="bi bi-newspaper"></i><br>Blog
        </a>
        @auth
            @if (auth()->user()->is_admin)
                <a href="/admin"
                    class="text-light text-decoration-none text-center nav-link {{ request()->is('admin') ? 'active' : '' }}">
                    <i class="bi bi-person-circle"></i><br>Admin
                </a>
            @endif
        @else
            <a href="/login"
                class="text-light text-decoration-none text-center nav-link {{ request()->is('login') ? 'active' : '' }}">
                <i class="bi bi-person-circle"></i><br>Profil
            </a>
        @endauth
    </div>
</nav>
