<style>
    .fixed-bottom {
        position: fixed !important;
        bottom: 0 !important;
    }
</style>


<nav class="navbar-dark bg-main fixed-bottom  d-block d-lg-none">
    <div class="container-fluid d-flex justify-content-around">
        <a href="/" class="text-light text-decoration-none text-center">
            <i class="bi bi-house-door"></i><br>Home
        </a>
        <a href="/marketplace" class="text-light text-decoration-none text-center">
            <i class="bi bi-shop"></i><br>Marketplace
        </a>
        <a href="/blog" class="text-light text-decoration-none text-center">
            <i class="bi bi-newspaper"></i><br>Blog
        </a>
        @auth
            @if (auth()->user()->is_admin)
                <a class="text-light text-decoration-none text-center" href="/admin"><i
                        class="bi bi-person-circle"></i><br>Admin</a>
            @endif
        @else
            <a class="text-light text-decoration-none text-center" href="/login">
                <i class="bi bi-person-circle"></i><br>Profil
            </a>
        @endauth
    </div>
</nav>
