<?php
$pageTitle = 'Update Post';
include __DIR__ . '/layouts/header.php';
?>

<style>
.create-post-wrapper {
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
    <h1><i class="bi bi-pencil-square me-2"></i> Update Post</h1>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text"
                   class="form-control"
                   id="title"
                   name="title"
                   value="<?= htmlspecialchars($old['title'] ?? $post->title ?? '') ?>"
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
                      required><?= htmlspecialchars($old['body'] ?? $post->body ?? '') ?></textarea>
        </div>

        <div class="mb-3">
            <label for="category" class="form-label">Category</label>
            <select class="form-control" id="category" name="category" required>
                <option value="">-- Select category --</option>
                <option value="news" <?= ((isset($old['category']) && $old['category'] === 'news') || (($post->category ?? '') === 'news')) ? 'selected' : '' ?>>News</option>
                <option value="discussion" <?= ((isset($old['category']) && $old['category'] === 'discussion') || (($post->category ?? '') === 'discussion')) ? 'selected' : '' ?>>Discussion</option>
                <option value="tutorial" <?= ((isset($old['category']) && $old['category'] === 'tutorial') || (($post->category ?? '') === 'tutorial')) ? 'selected' : '' ?>>Tutorial</option>
                <option value="question" <?= ((isset($old['category']) && $old['category'] === 'question') || (($post->category ?? '') === 'question')) ? 'selected' : '' ?>>Question</option>
                <option value="other" <?= ((isset($old['category']) && $old['category'] === 'other') || (($post->category ?? '') === 'other')) ? 'selected' : '' ?>>Other</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="tags" class="form-label">Tags (comma-separated)</label>
            <input type="text"
                   class="form-control"
                   id="tags"
                   name="tags"
                   value="<?= htmlspecialchars($old['tags'] ?? $post->tags ?? '') ?>"
                   placeholder="e.g. php, web, tutorial">
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Attach Image (optional)</label>
            <?php if (!empty($post->image)): ?>
                <div class="mb-2">
                    <img src="<?= htmlspecialchars($post->image) ?>" alt="Current Image" style="max-width: 200px; max-height:120px;">
                </div>
            <?php endif; ?>
            <input type="file"
                   class="form-control"
                   id="image"
                   name="image"
                   accept="image/*">
        </div>

        <div class="mb-3">
            <label for="is_published" class="form-label">Publish Status</label>
            <select class="form-control" id="is_published" name="is_published" required>
                <option value="1" <?= ((isset($old['is_published']) && $old['is_published'] == '1') || (($post->is_published ?? '') == '1')) ? 'selected' : '' ?>>Publish now</option>
                <option value="0" <?= ((isset($old['is_published']) && $old['is_published'] == '0') || (($post->is_published ?? '') == '0')) ? 'selected' : '' ?>>Save as draft</option>
            </select>
        </div>

        <div class="d-flex gap-3">
            <button type="submit" class="btn btn-primary"><i class="bi bi-upload me-1"></i> Update</button>
            <a href="/posts" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Cancel</a>
        </div>
    </form>
</div>

<?php include __DIR__ . '/layouts/footer.php'; ?>