<?php
$pageTitle = 'Create Post';
include __DIR__ . '/layouts/header.php';
?>

<style>
.create-post-wrapper {
    max-width: 740px;
    margin: 60px auto;
    background: #fff;
    border-radius: 18px;
    box-shadow: 0 4px 28px rgba(33,52,96,0.12), 0 1.5px 6px rgba(33,52,96,0.07);
    padding: 44px 32px 32px 32px;
}

@media (max-width: 600px) {
    .create-post-wrapper { padding: 20px 12px; }
}

.create-post-wrapper h1 {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 1.5rem;
    color: #213460;
    text-align: center;
}

.form-label {
    font-weight: 600;
    color: #213460;
}

.form-control {
    border-radius: 12px;
    border: 1.5px solid #e4e7ef;
    padding: 12px;
    font-size: 1.04rem;
    background-color: #fafafa;
}

.form-control:focus {
    border-color: #ffe484;
    background: #fff;
    box-shadow: 0 0 0 0.1rem rgba(255, 228, 132, 0.25);
}

.btn-primary {
    background: linear-gradient(90deg, #ffd814 60%, #ffecb3 100%);
    border: none;
    border-radius: 50px;
    color: #876800;
    font-weight: 600;
    padding: 10px 28px;
    transition: background 0.2s;
}

.btn-primary:hover {
    background: #ffe484;
    color: #213460;
}

.btn-secondary {
    border-radius: 50px;
    padding: 10px 24px;
    border: 1.5px solid #dcdcdc;
    background: #f8fafb;
    color: #213460;
    font-weight: 500;
    transition: all 0.2s ease-in-out;
}

.btn-secondary:hover {
    background: #f0f0f0;
    color: #b38d00;
}
</style>

<div class="create-post-wrapper">
    <h1><i class="bi bi-pencil-square me-2"></i> Create New Post</h1>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="/posts/create">
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text"
                   class="form-control"
                   id="title"
                   name="title"
                   value="<?= htmlspecialchars($old['title'] ?? '') ?>"
                   placeholder="Enter post title"
                   required>
        </div>

        <div class="mb-3">
            <label for="body" class="form-label">Body</label>
            <textarea class="form-control"
                      id="body"
                      name="body"
                      rows="6"
                      placeholder="Write your post content..."
                      required><?= htmlspecialchars($old['body'] ?? '') ?></textarea>
        </div>

        <div class="d-flex gap-3">
            <button type="submit" class="btn btn-primary"><i class="bi bi-upload me-1"></i> Publish</button>
            <a href="/posts" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Cancel</a>
        </div>
    </form>
</div>

<?php include __DIR__ . '/layouts/footer.php'; ?>
