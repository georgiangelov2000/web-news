<?php
$pageTitle = "Forgot Password";
include __DIR__ . '/layouts/header.php';
?>

<div class="container mt-5" style="max-width:420px;">
  <h2 class="mb-4"><i class="bi bi-lock"></i> Forgot Password</h2>
  <?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
  <?php elseif (!empty($success)): ?>
    <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
  <?php endif; ?>
  <form method="post" action="/forgot-password">
    <div class="mb-3">
      <label for="email" class="form-label">Email address</label>
      <input type="email" class="form-control" name="email" id="email" required value="<?= htmlspecialchars($old['email'] ?? '') ?>">
    </div>
    <button type="submit" class="btn btn-primary w-100">Send Reset Link</button>
    <p class="mt-3 small">
      <a href="/login"><i class="bi bi-arrow-left"></i> Back to Login</a>
    </p>
  </form>
</div>

<?php include __DIR__ . '/layouts/footer.php'; ?>