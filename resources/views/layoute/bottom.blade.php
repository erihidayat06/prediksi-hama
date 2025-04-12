<nav class="navbar navbar-dark bg-main fixed-bottom  d-block d-lg-none">
    <div class="container-fluid d-flex justify-content-around">
        <a href="/" class="text-light text-center">
            <i class="bi bi-house-door"></i><br>Home
        </a>
        @auth
            @if (auth()->user()->is_admin)
                <a class="text-light text-center" href="/admin"><i class="bi bi-person-circle"></i><br>Admin</a>
            @endif
        @else
            <a class="text-light text-center" href="/login">
                <i class="bi bi-person-circle"></i><br>Profil
            </a>
        @endauth
    </div>
</nav>
