<?php
$pageTitle = "Login";
include __DIR__ . '/layouts/header.php';
?>

<div class="container mt-5" style="max-width:420px;">
  <h2 class="mb-4">Login</h2>
  <?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>
  <form method="post" action="/login">
    <div class="mb-3">
      <label for="username" class="form-label">Username or Email</label>
      <input type="text" class="form-control" name="username" id="username" required value="<?= htmlspecialchars($old['username'] ?? '') ?>">
    </div>
    <div class="mb-3">
      <label for="password" class="form-label">Password</label>
      <input type="password" class="form-control" name="password" id="password" required>
    </div>
    <button type="submit" class="btn btn-primary w-100">Login</button>
    <div class="d-flex justify-content-between mt-3 small">
      <span>Don't have an account? <a href="/register">Register</a></span>
      <a href="/forgot-password">Forgot password?</a>
    </div>
  </form>
</div>

<?php include __DIR__ . '/layouts/footer.php'; ?>