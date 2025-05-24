<?php
$pageTitle = 'Profile';
include __DIR__ . '/layouts/header.php';
?>

<style>
/* Professional Profile Styles */
.profile-container {
    margin: 2rem auto 3rem auto;
    background: #fff;
    border-radius: 18px;
    box-shadow: 0 6px 26px rgba(33,52,96,0.11), 0 2px 10px rgba(33,52,96,0.09);
    padding: 2.5rem 2rem 2rem 2rem;
    position: relative;
    transition: box-shadow 0.2s;
}
.profile-header {
    display: flex;
    align-items: center;
    gap: 2.2rem;
    margin-bottom: 1.8rem;
}
.avatar img {
    width: 110px;
    height: 110px;
    border-radius: 50%;
    border: 3px solid #ffe484;
    object-fit: cover;
    background: #fafbfc;
    box-shadow: 0 2px 12px rgba(255, 228, 132, 0.09);
}
.profile-info h2 {
    margin: 0 0 0.4rem 0;
    color: #213460;
    font-weight: 700;
    font-size: 2rem;
    letter-spacing: 0.01em;
}
.profile-info p {
    margin: 0 0 0.2rem 0;
    color: #4a5670;
    font-size: 1.07rem;
}
.badge.bg-primary {
    background: linear-gradient(90deg, #ffe484 60%, #ffecb3 100%)!important;
    color: #876800!important;
    font-weight: 600;
    font-size: 1rem;
    border-radius: 0.47em;
    padding: 0.36em 1em;
    margin-top: 0.3em;
    box-shadow: 0 2px 8px rgba(255, 228, 132, 0.13);
    letter-spacing: 0.015em;
}
.profile-details {
    font-size: 1.05rem;
    color: #3e4667;
    margin-top: 2.3rem;
    border-top: 1px solid #f1f1f6;
    padding-top: 1.2rem;
}
.profile-details .stat-group {
    display: flex;
    gap: 2.5rem;
    margin-bottom: 1rem;
}
.profile-details .stat-item {
    font-size: 1.08rem;
    color: #8c98b8;
    display: flex;
    align-items: center;
    gap: 0.6em;
}
.profile-details .stat-item strong {
    color: #213460;
    font-weight: 600;
    font-size: 1.13rem;
}

.profile-actions-nav {
    margin-bottom: 1.9rem;
    margin-top: 0.2rem;
}
.profile-actions-nav .nav-pills .nav-link {
    font-weight: 500;
    font-size: 1.07rem;
    border-radius: 2em;
    padding: 0.5em 1.5em;
    color: #213460;
    background: #f8fafb;
    transition: all 0.13s;
    margin-right: 0.5em;
}
.profile-actions-nav .nav-pills .nav-link.active,
.profile-actions-nav .nav-pills .nav-link:focus,
.profile-actions-nav .nav-pills .nav-link:hover {
    background: linear-gradient(90deg, #ffe484 60%, #ffecb3 100%);
    color: #876800;
    box-shadow: 0 2px 8px rgba(255, 228, 132, 0.10);
}

.user-comments {
    max-width: 700px;
    margin: 2.5rem auto 0 auto;
    background: #f8fafb;
    border-radius: 16px;
    box-shadow: 0 1px 6px rgba(33,52,96,0.06);
    padding: 2rem 2rem 1.5rem 2rem;
}
.user-comments h4 {
    color: #213460;
    font-weight: 600;
}
.user-comments .list-group-item {
    background: #fff;
    border: 1px solid #f1f1f6;
    border-radius: 10px;
    margin-bottom: 0.75rem;
    box-shadow: 0 1px 4px rgba(33,52,96,0.04);
}
.user-comments .list-group-item .text-muted {
    font-size: 0.93rem;
}
.user-comments .list-group-item a {
    color: #876800;
    font-size: 0.96rem;
    text-decoration: underline;
}
.user-comments .list-group-item a:hover {
    color: #213460;
}

@media (max-width: 600px) {
    .profile-container { padding: 1rem 0.4rem; }
    .profile-header { flex-direction: column; gap: 1.3rem;}
    .avatar img { width: 72px; height: 72px;}
    .profile-info h2 { font-size: 1.25rem;}
    .user-comments { padding: 1rem 0.4rem 0.5rem 0.4rem;}
}
</style>

<div class="profile-container">
    <div class="profile-header">
        <div class="avatar">
            <img src="<?= htmlspecialchars($user->avatar ?? 'data:image/jpeg;base64,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') ?>"
                 alt="Avatar" >
        </div>
        <div class="profile-info">
            <h2><?= htmlspecialchars($user->username) ?></h2>
            <p>
                <i class="bi bi-envelope text-secondary me-1"></i>
                <?= htmlspecialchars($user->email) ?>
            </p>
            <span class="badge bg-primary">Your Profile</span>
        </div>
    </div>
    <!-- User actions navigation -->
    <nav class="profile-actions-nav">
        <ul class="nav nav-pills">
            <li class="nav-item">
                <a class="nav-link" href="/api/posts/create">
                    <i class="bi bi-plus-circle me-1"></i> Create Post
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/api/posts">
                    <i class="bi bi-card-list me-1"></i> My Posts
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/api/posts/favorites">
                    <i class="bi bi-star-fill me-1"></i> My Favorites
                </a>
            </li>
        </ul>
    </nav>
    <div class="profile-details">
        <div class="stat-group mb-3">
            <div class="stat-item">
                <i class="bi bi-calendar-event me-1"></i>
                <span>Member since <strong><?= date('Y-m-d', strtotime($user->created_at ?? 'now')) ?></strong></span>
            </div>
            <!-- Example stats, you can fetch actual values if available -->
            <div class="stat-item">
                <i class="bi bi-pencil-square me-1"></i>
                <span>Posts <strong><?= $user->posts_count ?? '--' ?></strong></span>
            </div>
            <div class="stat-item">
                <i class="bi bi-star-fill me-1"></i>
                <span>Favorites <strong><?= $user->favorites_count ?? '--' ?></strong></span>
            </div>
        </div>
        <!-- Add more stats, recent activity, user posts, etc. -->
    </div>
</div>

<div class="user-posts mt-5">
    <h4 class="mb-3"><i class="bi bi-card-list me-2"></i>Your Posts</h4>
    <?php if (!empty($posts)): ?>
        <ul class="list-group">
            <?php foreach ($posts as $post): ?>
                <li class="list-group-item">
                    <span class="text-muted small"><?= date('Y-m-d H:i', strtotime($post->created_at)) ?></span>
                    <div>
                        <a href="/api/posts/<?= htmlspecialchars($post->id) ?>" class="fw-semibold"><?= htmlspecialchars($post->title) ?></a>
                    </div>
                    <div class="small text-secondary">
                        <?= mb_strimwidth(strip_tags($post->body), 0, 120, '...') ?>
                    </div>
                    <div>
                        <a href="/api/posts/<?= htmlspecialchars($post->id) ?>" class="small text-decoration-underline">View Post</a>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <div class="text-muted">You haven't written any posts yet.</div>
    <?php endif; ?>
</div>

<?php
include __DIR__ . '/layouts/footer.php';
?>