<?php
$pageTitle = "My Favorite Posts";
$customCss = '/assets/favorites.css';
include __DIR__ . '/layouts/header.php';
?>

<?php if (isset($customCss)): ?>
  <link rel="stylesheet" href="<?= htmlspecialchars($customCss) ?>">
<?php endif; ?>


<section class="fav-hero">
    <h1><i class="bi bi-star-fill text-warning"></i> My Favorites</h1>
    <p class="desc">All posts you <span style="color:#b38d00;">starred</span> are listed here.</p>
</section>

<section class="fav-list-section">
    <?php if (count($favPosts)): ?>
        <?php foreach ($favPosts as $post): ?>
            <div class="fav-card">
                <div class="fav-card-img">
                    <a href="/api/posts/<?= $post->id ?>">
                        <img src="<?= $post->image_url ?? 'https://images.unsplash.com/photo-1519125323398-675f0ddb6308?w=600&q=80' ?>"
                             alt="<?= $post->title ?>">
                    </a>
                </div>
                <div class="fav-card-body">
                    <a class="fav-card-title" href="/api/post/<?= $post->alias ?>">
                        <?= $post->title ?>
                    </a>
                    <div class="fav-card-meta">
                        <i class="bi bi-clock"></i> <?= $post->created_at ?>
                        <span class="mx-2">•</span>
                        <i class="bi bi-person-circle"></i> <?= $post->username ?>
                    </div>
                    <div class="fav-card-excerpt">
                        <?= (mb_strimwidth(strip_tags($post->body), 0, 120, '...')) ?>
                    </div>
                    <div class="fav-card-actions">
                        <a class="btn"
                           href="/api/posts/<?= ($post->id) ?>/favorite"
                           title="Remove from Favorites">
                            <i class="bi bi-star-fill text-warning"></i> Unfavorite
                        </a>
                        <a class="btn" href="/api/post/<?= ($post->alias) ?>" title="Read More">
                            <i class="bi bi-book"></i> Read
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="empty-state">
            <i class="bi bi-star text-warning" style="font-size:2.7rem;"></i><br>
            You have not added any favorites yet.<br>
            Go to <a href="/posts" style="color:#b38d00;text-decoration:underline;">All Posts</a> to add some!
        </div>
    <?php endif; ?>
</section>

<?php include __DIR__ . '/layouts/footer.php'; ?>