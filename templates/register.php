<?php
$pageTitle = "Register";
include __DIR__ . '/layouts/header.php';
?>

<div class="container mt-5" style="max-width:420px;">
  <h2 class="mb-4">Register</h2>
  <?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>
  <form method="post" action="/api/register">
    <div class="mb-3">
      <label for="username" class="form-label">Username</label>
      <input type="text" class="form-control" name="username" id="username" required value="<?= htmlspecialchars($old['username'] ?? '') ?>">
    </div>
    <div class="mb-3">
      <label for="email" class="form-label">Email</label>
      <input type="email" class="form-control" name="email" id="email" required value="<?= htmlspecialchars($old['email'] ?? '') ?>">
    </div>
    <div class="mb-3">
      <label for="password" class="form-label">Password</label>
      <input type="password" class="form-control" name="password" id="password" required>
    </div>
    <button type="submit" class="btn btn-primary w-100">Register</button>
    <p class="mt-3 small">Already have an account? <a href="/api/login">Login</a></p>
  </form>
</div>

<?php include __DIR__ . '/layouts/footer.php'; ?>