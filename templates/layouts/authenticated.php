<?php
$userName = $GLOBALS['session']->get('user_name');
$userId = $GLOBALS['session']->get('user_id');
?>
<ul class="navbar-nav ms-auto align-items-lg-center">
    <li class="nav-item"><a class="nav-link<?= $_SERVER['REQUEST_URI'] === '/' ? ' active' : '' ?>" href="/"><i class="bi bi-house-door-fill me-1"></i>Home</a></li>
    <li class="nav-item"><a class="nav-link<?= strpos($_SERVER['REQUEST_URI'], '/posts') === 0 ? ' active' : '' ?>" href="/posts"><i class="bi bi-card-list me-1"></i>Posts</a></li>
    <li class="nav-item"><a class="nav-link<?= strpos($_SERVER['REQUEST_URI'], '/users') === 0 ? ' active' : '' ?>" href="/users"><i class="bi bi-people-fill me-1"></i>Users</a></li>
    <li class="nav-item dropdown ms-2">
        <a class="btn btn-sm btn-outline-dark dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-person-circle me-1"></i> <?= htmlspecialchars($userName ?? 'Account') ?>
        </a>
        <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="/profile"><i class="bi bi-person-badge me-1"></i>Profile</a></li>
            <li><a class="dropdown-item" href="/logout"><i class="bi bi-box-arrow-right me-1"></i>Logout</a></li>
        </ul>
    </li>
</ul>
