<nav class="navbar navbar-dark bg-main fixed-bottom  d-block d-lg-none">
    <div class="container-fluid d-flex justify-content-around">
        <a href="/" class="text-light text-center">
            <i class="bi bi-house-door"></i><br>Home
        </a>
        <a href="/marketplace" class="text-light text-center">
            <i class="bi bi-search"></i><br>Search
        </a>
        @auth
            @if (auth()->user()->is_admin)
                <a class="text-light text-center" href="/admin">Admin</a>
            @endif
        @endauth
    </div>
</nav>
