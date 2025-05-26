<?php
$pageTitle = '404 - Not Found';
include __DIR__ . '/layouts/header.php';
?>

<style>
.not-found-wrapper {
    margin: 80px auto 60px auto;
    background: #fff;
    border-radius: 18px;
    box-shadow: 0 4px 28px rgba(33,52,96,0.12), 0 1.5px 6px rgba(33,52,96,0.07);
    max-width: 450px;
    padding: 48px 36px 36px 36px;
    text-align: center;
    position: relative;
}

@media (max-width: 600px) {
    .not-found-wrapper { padding: 28px 12px; }
}

.not-found-wrapper .icon {
    font-size: 3.5rem;
    margin-bottom: 1.2rem;
    color: #ffd814;
    display: inline-block;
    line-height: 1;
    filter: drop-shadow(0 2px 8px rgba(33,52,96,0.09));
}
.not-found-wrapper h1 {
    font-size: 2.1rem;
    font-weight: 700;
    color: #213460;
    margin-bottom: 0.9rem;
    letter-spacing: -1px;
}
.not-found-wrapper .subtitle {
    font-size: 1.13rem;
    color: #7a879a;
    margin-bottom: 1.7rem;
}
.not-found-wrapper .template {
    color: #b8bdc9;
    font-size: 0.97rem;
    margin-bottom: 0.7rem;
}
.not-found-wrapper .btn-primary {
    margin-top: 1.2rem;
    background: linear-gradient(90deg, #ffd814 60%, #ffecb3 100%);
    border: none;
    border-radius: 50px;
    color: #876800;
    font-weight: 600;
    padding: 10px 28px;
    transition: background 0.2s;
    text-decoration: none;
    display: inline-block;
}
.not-found-wrapper .btn-primary:hover {
    background: #ffe484;
    color: #213460;
}
</style>

<div class="not-found-wrapper">
    <div class="icon">🤷‍♂️</div>
    <h1>404 – Not Found</h1>
    <div class="subtitle">
        Sorry, the page or resource you’re looking for doesn’t exist or has been moved.
    </div>
    <!-- <?php if (isset($template)): ?>
        <div class="template">
            Template: <strong><?= htmlspecialchars($template) ?></strong>
        </div>
    <?php endif; ?> -->
    <a href="/posts" class="btn btn-primary">← Go to Home</a>
</div>

<?php include __DIR__ . '/layouts/footer.php'; ?>