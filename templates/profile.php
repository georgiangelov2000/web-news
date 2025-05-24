<?php
$pageTitle = 'Profile';
include __DIR__ . '/layouts/header.php';
$customCss = '/assets/profile.css';
?>

<?php if (isset($customCss)): ?>
    <link rel="stylesheet" href="<?= htmlspecialchars($customCss) ?>">
<?php endif; ?>

<div class="profile-container">
    <div class="profile-header">
        <div class="avatar">
            <img src="<?= htmlspecialchars($user->avatar ?? '/assets/default-avatar.png') ?>" alt="Avatar">
        </div>
        <div class="profile-info">
            <h2><?= htmlspecialchars($user->username) ?></h2>
            <p><i class="bi bi-envelope text-secondary me-1"></i><?= htmlspecialchars($user->email) ?></p>
            <span class="badge bg-primary">Your Profile</span>
        </div>
    </div>

    <nav class="profile-actions-nav mt-3">
        <ul class="nav nav-pills">
            <li class="nav-item">
                <a class="nav-link" href="/api/posts/create"><i class="bi bi-plus-circle me-1"></i>Create Post</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/api/posts/create"><i class="bi bi-plus-circle me-1"></i>Update Profile</a>
            </li>
        </ul>
    </nav>

    <div class="profile-details">
        <div class="stat-group mb-3 mt-4">
            <div class="stat-item"><i class="bi bi-calendar-event me-1"></i><span>Member since
                    <strong><?= date('Y-m-d', strtotime($user->created_at ?? 'now')) ?></strong></span></div>
            <div class="stat-item"><i class="bi bi-pencil-square me-1"></i><span>Posts
                    <strong><?= $user->posts_count ?? '--' ?></strong></span></div>
            <div class="stat-item"><i class="bi bi-star-fill me-1"></i><span>Favorites
                    <strong><?= $user->favorites_count ?? '--' ?></strong></span></div>
        </div>
    </div>

    <div class="user-favorites mt-5">
        <h4 class="mb-3"><i class="bi bi-star-fill me-2"></i>Your Favorites</h4>

        <!-- Tabs -->
        <ul class="nav nav-tabs" id="favoritesTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="fav-posts-tab" data-bs-toggle="tab" data-bs-target="#fav-posts"
                    type="button" role="tab" aria-controls="fav-posts" aria-selected="true">
                    Favorite Posts
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="fav-topics-tab" data-bs-toggle="tab" data-bs-target="#fav-topics"
                    type="button" role="tab" aria-controls="fav-topics" aria-selected="false">
                    Favorite Topics
                </button>
            </li>
        </ul>

        <!-- Tab content -->
        <div class="tab-content border border-top-0 p-3 bg-light" id="favoritesTabContent">
            <!-- Tab 1: Favorite Posts -->
            <div class="tab-pane fade show active" id="fav-posts" role="tabpanel" aria-labelledby="fav-posts-tab">
                <?php if (!empty($posts)): ?>
                    <ul class="list-group">
                        <?php foreach ($posts as $post): ?>
                            <li class="list-group-item">
                                <span class="text-muted small"><?= date('Y-m-d H:i', strtotime($post->created_at)) ?></span>
                                <div>
                                    <a href="/api/post/<?= htmlspecialchars($post->alias) ?>"
                                        class="fw-semibold"><?= htmlspecialchars($post->title) ?></a>
                                </div>
                                <div class="small text-secondary">
                                    <?= mb_strimwidth(strip_tags($post->body), 0, 120, '...') ?>
                                </div>
                                <div>
                                    <a href="/api/post/<?= htmlspecialchars($post->alias) ?>"
                                        class="small text-decoration-underline">View Post</a>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <div class="text-muted">You have no favorite posts yet.</div>
                <?php endif; ?>
            </div>

            <!-- Tab 2: Favorite Topics -->
            <div class="tab-pane fade" id="fav-topics" role="tabpanel" aria-labelledby="fav-topics-tab">
                <?php if (!empty($posts)): ?>
                    <ul class="list-group">
                        <?php foreach ($posts as $topic): ?>
                            <li class="list-group-item">
                                <span class="text-muted small"><?= date('Y-m-d H:i', strtotime($post->created_at)) ?></span>
                                <div>
                                    <a href="/api/posts/<?= htmlspecialchars($post->id) ?>"
                                        class="fw-semibold"><?= htmlspecialchars($post->title) ?></a>
                                </div>
                                <div class="small text-secondary">
                                    <?= mb_strimwidth(strip_tags($post->body), 0, 120, '...') ?>
                                </div>
                                <div>
                                    <a href="/api/posts/<?= htmlspecialchars($post->id) ?>"
                                        class="small text-decoration-underline">View Post</a>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <div class="text-muted">You have no favorite topics yet.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>

</div>

<?php include __DIR__ . '/layouts/footer.php'; ?>