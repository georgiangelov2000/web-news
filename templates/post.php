<?php
$pageTitle = isset($data['post']['title']) ? htmlspecialchars($data['post']['title']) : 'Post';
include __DIR__ . '/layouts/header.php';

$post = $data['post'] ?? [];
// $comments = $data['comments'] ?? [];
// Mockup comments for design
$comments = [
    [
        'username' => 'Alice',
        'created_at' => '2025-05-21 10:20',
        'body' => 'Great article! I learned a lot. Thanks for sharing.',
    ],
    [
        'username' => 'Bob',
        'created_at' => '2025-05-21 11:05',
        'body' => 'I have a question: what about edge cases?',
    ],
    [
        'username' => 'Charlie',
        'created_at' => '2025-05-21 13:40',
        'body' => "Nice post! Looking forward to more content like this.\nKeep it up!",
    ],
];
?>

<style>
.post-hero {
    background: linear-gradient(100deg, #faf9f6 70%, #ffe484 100%);
    padding: 48px 0 24px 0;
    border-radius: 0 0 36px 36px;
    text-align: center;
    position: relative;
}
.post-hero .post-meta {
    color: #876800;
    font-size: 1rem;
    margin-bottom: 0.7rem;
    opacity: 0.98;
}
.post-hero h1 {
    font-size: 2.7rem;
    font-weight: 800;
    color: #213460;
    margin-bottom: 0.3em;
    letter-spacing: -1.2px;
}
.post-hero .hero-image {
    max-width: 360px;
    max-height: 240px;
    object-fit: cover;
    border-radius: 16px;
    margin: 28px auto 0 auto;
    box-shadow: 0 4px 24px rgba(33,52,96,0.11);
    background: #fff;
}
@media (max-width: 600px) {
    .post-hero h1 { font-size: 1.45rem; }
    .post-hero .hero-image { max-width: 100%; }
}
.post-content-card {
    margin: -64px auto 32px auto;
    background: #fff;
    border-radius: 18px;
    box-shadow: 0 4px 28px rgba(33,52,96,0.12), 0 1.5px 6px rgba(33,52,96,0.07);
    padding: 44px 32px 32px 32px;
    max-width: 740px;
    position: relative;
    z-index: 2;
}
@media (max-width: 600px) {
    .post-content-card { padding: 20px 8px; }
}
.post-content-card .post-body {
    font-size: 1.13rem;
    color: #4a5670;
    line-height: 1.82;
    margin-bottom: 2rem;
    white-space: pre-line;
}
.post-actions {
    display: flex;
    gap: 12px;
    margin-bottom: 0.5rem;
    flex-wrap: wrap;
}
.post-actions .btn {
    border-radius: 50px;
    padding: 7px 20px;
    font-size: 1.04rem;
    font-weight: 500;
    background: #f8fafb;
    border: 1.5px solid #e4e7ef;
    color: #876800;
    transition: background 0.13s, color 0.13s, border 0.13s;
}
.post-actions .btn:hover, .post-actions .btn.active {
    background: #ffe484;
    color: #213460;
    border-color: #ffe484;
}
.back-link {
    display: inline-block;
    margin-top: 16px;
    color: #213460;
    font-weight: 600;
    text-decoration: none;
    transition: color 0.16s;
}
.back-link:hover { color: #b38d00; text-decoration: underline; }

.comments-section {
    max-width: 740px;
    margin: 0 auto 64px auto;
    background: #f8fafb;
    border-radius: 16px;
    box-shadow: 0 2px 12px rgba(33,52,96,0.08);
    padding: 36px 28px 28px 28px;
}
@media (max-width: 600px) {
    .comments-section { padding: 14px 4px; }
}
.comments-section h3 {
    font-size: 1.3rem;
    font-weight: 700;
    color: #213460;
    margin-bottom: 1.2rem;
}
.comment-form {
    margin-bottom: 2.2rem;
    background: #fffbe6;
    border-radius: 10px;
    padding: 20px 18px 14px 18px;
    box-shadow: 0 1.5px 6px rgba(255,228,132,0.05);
}
.comment-form textarea {
    width: 100%;
    border-radius: 8px;
    border: 1.5px solid #ffe484;
    padding: 10px;
    font-size: 1.04rem;
    resize: vertical;
    min-height: 56px;
    margin-bottom: 10px;
}
.comment-form .btn {
    border-radius: 50px;
    padding: 7px 26px;
    background: linear-gradient(90deg, #ffd814 60%, #ffecb3 100%) !important;
    color: #876800 !important;
    font-weight: 600;
    border: none;
    box-shadow: 0 2px 10px rgba(255, 228, 132, 0.09);
    transition: background 0.18s, color 0.18s, box-shadow 0.18s;
}
.comment-form .btn:hover { background: #ffe484 !important; color: #b38d00 !important; }
.comment-list {
    list-style: none;
    margin: 0;
    padding: 0;
}
.comment {
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 1.5px 6px rgba(33,52,96,0.05);
    padding: 18px 18px 16px 18px;
    margin-bottom: 18px;
    position: relative;
}
.comment .comment-user {
    font-weight: 600;
    color: #213460;
    font-size: 1.05rem;
    margin-bottom: 2px;
}
.comment .comment-date {
    font-size: 0.93rem;
    color: #b38d00;
    margin-bottom: 5px;
    display: block;
}
.comment .comment-body {
    color: #4a5670;
    font-size: 1.01rem;
    line-height: 1.6;
    white-space: pre-line;
}
</style>

<!-- Hero section -->
<section class="post-hero">
    <div class="container">
        <div class="post-meta">
            <span><i class="bi bi-clock"></i> <?= isset($post['created_at']) ? htmlspecialchars($post['created_at']) : '' ?></span>
            <span class="mx-2">•</span>
            <span><i class="bi bi-person-circle"></i> <?= isset($post['username']) ? htmlspecialchars($post['username']) : '' ?></span>
        </div>
        <h1><?= htmlspecialchars($post['title'] ?? '') ?></h1>
        <img src="<?= htmlspecialchars($post['image_url'] ?? 'https://images.unsplash.com/photo-1519125323398-675f0ddb6308?w=600&q=80') ?>"
             alt="Post image"
             class="hero-image img-fluid shadow-sm mt-2">
    </div>
</section>

<!-- Main content card -->
<div class="post-content-card">
    <div class="post-body">
        <?= isset($post['body']) ? nl2br(htmlspecialchars($post['body'])) : '' ?>
    </div>
    <div class="post-actions">
        <a class="btn<?= !empty($post['is_favorite']) ? ' active' : '' ?>"
           href="/posts/<?= $post['id'] ?? 0 ?>/favorite"
           title="<?= !empty($post['is_favorite']) ? 'Remove from Favorites' : 'Add to Favorites' ?>">
            <i class="bi bi-star<?= !empty($post['is_favorite']) ? '-fill text-warning' : '' ?>"></i> Favorite
        </a>
        <a class="btn" href="/posts/<?= $post['id'] ?? 0 ?>/like" title="Like">
            <i class="bi bi-hand-thumbs-up"></i> Like
        </a>
        <a class="btn" href="/posts/<?= $post['id'] ?? 0 ?>/dislike" title="Dislike">
            <i class="bi bi-hand-thumbs-down"></i> Dislike
        </a>
        <a class="btn" href="/posts/<?= $post['id'] ?? 0 ?>/share" title="Share">
            <i class="bi bi-share"></i> Share
        </a>
        <a class="btn" href="/posts/<?= $post['id'] ?? 0 ?>/report" title="Report">
            <i class="bi bi-flag"></i> Report
        </a>
    </div>
    <a class="back-link" href="/posts"><i class="bi bi-arrow-left"></i> Back to posts</a>
</div>

<!-- Comments section -->
<div class="comments-section">
    <h3><i class="bi bi-chat-left-text me-1"></i> Comments</h3>
    <!-- Comment form -->
    <form class="comment-form mb-4" method="post" action="/posts/<?= $post['id'] ?? 0 ?>/comment">
        <div class="mb-2">
            <textarea name="body" placeholder="Write your comment..." required></textarea>
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
            <li class="comment text-center text-muted" style="background:transparent;box-shadow:none;">No comments yet. Be the first to comment!</li>
        <?php endif; ?>
    </ul>
</div>

<?php include __DIR__ . '/layouts/footer.php'; ?>