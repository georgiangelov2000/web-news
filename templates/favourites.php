<?php
$pageTitle = "My Favorite Posts";
include __DIR__ . '/layouts/header.php';
?>

<style>
.fav-hero {
    background: linear-gradient(100deg, #ffe484 20%, #f8fafb 100%);
    padding: 52px 0 28px 0;
    border-radius: 0 0 32px 32px;
    text-align: center;
    box-shadow: 0 6px 32px rgba(33,52,96,0.08);
}
.fav-hero h1 {
    font-size: 2.4rem;
    font-weight: 800;
    color: #213460;
    margin-bottom: 8px;
    letter-spacing: -1.2px;
}
.fav-hero .desc {
    font-size: 1.15rem;
    color: #876800;
    margin-bottom: 30px;
}

.fav-list-section {
    max-width: 920px;
    margin: -52px auto 40px auto;
    padding: 0 8px;
}
.fav-card {
    background: #fff;
    border-radius: 18px;
    box-shadow: 0 4px 24px rgba(33,52,96,0.09);
    margin-bottom: 28px;
    display: flex;
    flex-direction: row;
    align-items: stretch;
    overflow: hidden;
    transition: box-shadow 0.15s, transform 0.15s;
}
.fav-card:hover {
    box-shadow: 0 8px 36px rgba(33,52,96,0.13);
    transform: translateY(-2px) scale(1.01);
}
.fav-card-img {
    flex: 0 0 160px;
    background: #f8fafb;
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 140px;
    border-right: 1.5px solid #ffe484;
    padding: 0;
}
.fav-card-img img {
    max-width: 130px;
    max-height: 110px;
    object-fit: contain;
    border-radius: 10px;
}
.fav-card-body {
    flex: 1 1 auto;
    padding: 20px 24px 18px 24px;
    display: flex;
    flex-direction: column;
    justify-content: center;
}
.fav-card-title {
    font-size: 1.2rem;
    font-weight: bold;
    margin: 0 0 7px 0;
    color: #213460;
}
.fav-card-meta {
    color: #b38d00;
    font-size: 0.99rem;
    margin-bottom: 10px;
}
.fav-card-excerpt {
    color: #4a5670;
    font-size: 1.04rem;
    margin-bottom: 10px;
    overflow: hidden;
    text-overflow: ellipsis;
}
.fav-card-actions {
    margin-top: auto;
    display: flex;
    gap: 10px;
}
.fav-card-actions .btn {
    border-radius: 50px;
    font-size: 0.97rem;
    padding: 5px 18px;
    background: #f8fafb;
    color: #876800;
    border: 1.2px solid #ffe484;
}
.fav-card-actions .btn:hover, .fav-card-actions .btn.active {
    background: #ffe484;
    color: #213460;
    text-decoration: none;
}
@media (max-width: 700px) {
    .fav-card { flex-direction: column; }
    .fav-card-img { border-right: none; border-bottom: 1.5px solid #ffe484; }
    .fav-card-body { padding: 18px 12px 14px 12px; }
}
.empty-state {
    text-align: center;
    color: #b38d00;
    padding: 64px 0 44px 0;
    font-size: 1.17rem;
    font-weight: 500;
}
</style>

<section class="fav-hero">
    <h1><i class="bi bi-star-fill text-warning"></i> My Favorites</h1>
    <p class="desc">All posts you <span style="color:#b38d00;">starred</span> are listed here.</p>
</section>

<section class="fav-list-section">
    <?php if (count($favPosts)): ?>
        <?php foreach ($favPosts as $post): ?>
            <div class="fav-card">
                <div class="fav-card-img">
                    <a href="/posts/<?= $post->id ?>">
                        <img src="<?= $post->image_url ?? 'https://images.unsplash.com/photo-1519125323398-675f0ddb6308?w=600&q=80' ?>"
                             alt="<?= $post->title ?>">
                    </a>
                </div>
                <div class="fav-card-body">
                    <a class="fav-card-title" href="/posts/<?= $post->id ?>">
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
                        <a class="btn<?= in_array($post->id, $favIds) ? ' active' : '' ?>"
                           href="/posts/<?= ($post->id) ?>/favorite"
                           title="Remove from Favorites">
                            <i class="bi bi-star-fill text-warning"></i> Unfavorite
                        </a>
                        <a class="btn" href="/posts/<?= ($post->id) ?>" title="Read More">
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