<?php
$post = $data['post'] ?? null;
$pageTitle = isset($post->title) ? htmlspecialchars($post->title) : 'Post';
include __DIR__ . '/layouts/header.php';

$post = $data['post'] ?? [];
$comments = $data['comments'] ?? [];
$favIds = $data['favIds'] ?? [];
$customCss = '/assets/comments.css';
// Mockup comments for design
?>

<?php if (isset($customCss)): ?>
  <link rel="stylesheet" href="<?= htmlspecialchars($customCss) ?>">
<?php endif; ?>

<!-- Hero section -->
<section class="post-hero">
    <div class="container">
        <div class="post-meta">
            <span><i class="bi bi-clock"></i> <?= htmlspecialchars($post->created_at ?? '') ?></span>
            <span class="mx-2">•</span>
            <span><i class="bi bi-person-circle"></i> <?= htmlspecialchars($post->username ?? '') ?></span>
        </div>
        <h1><?= htmlspecialchars($post->title ?? '') ?></h1>
        <img src="<?= htmlspecialchars($post->image_url ?? 'https://images.unsplash.com/photo-1519125323398-675f0ddb6308?w=600&q=80') ?>"
            alt="Post image" class="hero-image img-fluid shadow-sm mt-2">
    </div>
</section>

<!-- Main content card -->
<div class="post-content-card">
    <div class="post-body">
        <?= nl2br(htmlspecialchars($post->body))?>
    </div>
    <div class="post-actions">
        <?php
            $favorited = in_array($post->id, $favIds);
        ?>
        <a class="btn<?= $favorited ? ' active' : '' ?>" href="/posts/<?= $post->id ?? 0 ?>/favorite"
            title="<?= $favorited ? 'Remove from Favorites' : 'Add to Favorites' ?>">
            <i class="bi bi-star<?= $favorited ? '-fill text-warning' : '' ?>"></i> Favorite
        </a>
        <a class="btn" href="/posts/<?= $post->id ?? 0 ?>/like" title="Like">
            <i class="bi bi-hand-thumbs-up"></i> Like
        </a>
        <a class="btn" href="/posts/<?= $post->id ?? 0 ?>/dislike" title="Dislike">
            <i class="bi bi-hand-thumbs-down"></i> Dislike
        </a>
        <a class="btn" href="/posts/<?= $post->id ?? 0 ?>/share" title="Share">
            <i class="bi bi-share"></i> Share
        </a>
        <a class="btn" href="/posts/<?= $post->id ?? 0 ?>/report" title="Report">
            <i class="bi bi-flag"></i> Report
        </a>
    </div>
    <a class="back-link" href="/posts"><i class="bi bi-arrow-left"></i> Back to posts</a>
</div>

<!-- Comments section -->
<div class="comments-section">
    <h3><i class="bi bi-chat-left-text me-1"></i> Comments</h3>

    <!-- Comment form -->
    <form id="comment-form" class="comment-form mb-4" method="post" action="/posts/<?= $post->id ?? 0 ?>/comment">
        <div class="mb-2">
            <textarea id="comment-body" name="body" placeholder="Write your comment..." required></textarea>
        </div>
        <button type="submit" class="btn"><i class="bi bi-send"></i> Post Comment</button>
    </form>


    <!-- Comment list -->
    <ul class="comment-list">
        <?php if (!empty($comments)): ?>
            <?php foreach ($comments as $comment): ?>
                <li class="comment">
                    <div class="comment-user">
                        <i class="bi bi-person-circle"></i>
                        <?= htmlspecialchars($comment['username'] ?? 'Anonymous') ?>
                    </div>
                    <span class="comment-date">
                        <i class="bi bi-clock"></i>
                        <?= htmlspecialchars($comment['created_at'] ?? '') ?>
                    </span>
                    <div class="comment-body">
                        <?= nl2br(htmlspecialchars($comment['body'] ?? '')) ?>
                    </div>
                </li>
            <?php endforeach; ?>
        <?php else: ?>
            <li class="comment text-center text-muted" style="background:transparent;box-shadow:none;">
                No comments yet. Be the first to comment!
            </li>
        <?php endif; ?>
    </ul>
</div>

<?php include __DIR__ . '/layouts/footer.php'; ?>