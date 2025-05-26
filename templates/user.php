<?php
$pageTitle = 'Users';
include __DIR__ . '/layouts/header.php';
?>

<h4 class="mb-4">User profile</h4>


<!-- Modern user profile page for current user with their posts -->
<div class="profile-container">
    <div class="profile-header">
        <div class="avatar">
            <img src="<?= htmlspecialchars($user->avatar ?? '/assets/default-avatar.png') ?>" alt="Avatar" />
        </div>
        <div class="profile-info">
            <h2><?= htmlspecialchars($user->username) ?></h2>
            <p><?= htmlspecialchars($user->email) ?></p>
            <span class="badge badge-primary">Profile</span>
        </div>
    </div>
    <hr>
    <div class="posts-section">
        <h3>Posts</h3>
        <?php if (empty($posts)): ?>
            <p>User haven't created any posts yet.</p>
        <?php else: ?>
            <div class="post-list">
                <?php foreach ($posts as $post): ?>
                    <div class="post-card">
                        <h4><?= htmlspecialchars($post->title) ?></h4>
                        <div class="post-meta">
                            <span><?= date('Y-m-d H:i', strtotime($post->created_at)) ?></span>
                        </div>
                        <p><?= nl2br(htmlspecialchars(mb_strimwidth($post->content, 0, 220, '...'))) ?></p>
                        <a class="btn btn-warning" href="/post/<?= $post->id ?>">Read more</a>
                    </div>
                <?php endforeach; ?>
            </div>
            <!-- Pagination -->
            <nav class="amazon-pagination">
                <ul class="pagination">
                    <?php for ($i = 1; $i <= $pagination['last']; $i++): ?>
                        <li class="page-item<?= $i === $pagination['current'] ? ' active' : '' ?>">
                            <a class="page-link" href="<?= $pagination['base_url'] . $i ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>
                </ul>
            </nav>
        <?php endif; ?>
    </div>
</div>


<?php
include __DIR__ . '/layouts/footer.php';
?>