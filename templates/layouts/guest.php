<ul class="navbar-nav ms-auto align-items-lg-center">
    <li class="nav-item"><a class="nav-link<?= $_SERVER['REQUEST_URI'] === '/' ? ' active' : '' ?>" href="/"><i class="bi bi-house-door-fill me-1"></i>Home</a></li>
    <li class="nav-item"><a class="nav-link<?= strpos($_SERVER['REQUEST_URI'], '/posts') === 0 ? ' active' : '' ?>" href="/posts"><i class="bi bi-card-list me-1"></i>Posts</a></li>
    <li class="nav-item"><a class="nav-link<?= strpos($_SERVER['REQUEST_URI'], '/posts/create') === 0 ? ' active' : '' ?>" href="/posts/create"><i class="bi bi-plus-circle me-1"></i>Create</a></li>
    <li class="nav-item dropdown ms-2">
        <a class="btn btn-sm btn-outline-dark dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-person-circle me-1"></i> Account
        </a>
        <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="/login"><i class="bi bi-box-arrow-in-right me-1"></i>Login</a></li>
            <li><a class="dropdown-item" href="/register"><i class="bi bi-person-plus-fill me-1"></i>Register</a></li>
        </ul>
    </li>
</ul>
