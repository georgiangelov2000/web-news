<?php
$pageTitle = "User for " . htmlspecialchars($resource);
include __DIR__ . '/layout/header.php';
?>

<h1>User for <?= htmlspecialchars($resource) ?></h1>
<?php if (isset($data['name'])): ?>
    <p><strong>Name:</strong> <?= htmlspecialchars($data['name']) ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($data['email']) ?></p>
    <p><strong>Username:</strong> <?= htmlspecialchars($data['username']) ?></p>
<?php else: ?>
    <pre><?= htmlspecialchars(print_r($data, true)) ?></pre>
<?php endif; ?>

<?php
include __DIR__ . '/layout/footer.php';
?>