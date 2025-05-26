<?php
$pageTitle = 'Users';
include __DIR__ . '/layouts/header.php';

// Extract pagination data
$users = $data['users'] ?? [];
$currentPage = $current_page ?? ($data['current_page'] ?? 1);
$perPage = $per_page ?? ($data['per_page'] ?? 10);
$totalItems = $total_items ?? ($data['total_items'] ?? 0);
$totalPages = $total_pages ?? ($data['total_pages'] ?? 1);
?>

<h4 class="mb-4">Users</h4>

<div class="row g-4">
  <?php
  $chunks = array_chunk($users, 5);

  foreach ($chunks as $i => $group):
    $sliderId = 'slider' . ($i + 1);
    ?>
    <div class="slick-slider mb-5 bg-white rounded" id="<?= $sliderId ?>">
      <?php foreach ($group as $user): ?>
        <div class="widget-post">
          <div class="card h-100 amazon-fancy-box border-0">
            <span
              class="badge rounded-pill bg-warning text-dark mb-2 px-3 py-2 d-inline-flex align-items-center post-widget-badge">
              <i class="bi bi-person-circle me-1"></i>
              <?= htmlspecialchars($user->username ?? $user->name ?? $user->email ?? 'User') ?>
              <?php if (!empty($user->role) && strtolower($user->role) === 'admin'): ?>
                <span class="badge bg-success ms-2">Admin</span>
              <?php endif; ?>
            </span>

            <div class="card-img-top bg-light d-flex align-items-center justify-content-center">
              <?php if (!empty($user->avatar)): ?>
                <img src="<?= htmlspecialchars($user->avatar) ?>" alt="Avatar" class="img-fluid" style="object-fit: contain; width: 100px; height: 100px;">
              <?php else: ?>
                <i class="bi bi-person-circle" style="font-size: 3rem; color: #ccc;"></i>
              <?php endif; ?>
            </div>
            <div class="card-body px-4 pb-2 pt-3">
              <h6 class="card-title fw-bold mb-2 widget-title"><?= htmlspecialchars($user['name'] ?? $user['username'] ?? '-') ?></h6>
              <p class="card-text text-secondary widget-text">
                <?php if (!empty($user['email'])): ?>
                  <span><i class="bi bi-envelope"></i> <?= htmlspecialchars($user['email']) ?></span><br>
                <?php endif; ?>
                <?php if (!empty($user['created_at'])): ?>
                  <span><i class="bi bi-calendar"></i> Joined: <?= htmlspecialchars($user['created_at']) ?></span>
                <?php endif; ?>
              </p>
            </div>

            <div class="card-footer bg-white border-0 pb-3 px-4">
              <div class="d-flex justify-content-between align-items-center mb-2">
                <div role="group">
                  <a class="btn btn-warning btn-sm rounded-pill shadow-sm w-100 mt-1"
                     href="/user/<?= urlencode($user['id']) ?>"
                     title="View Profile">
                    <i class="bi bi-eye"></i> View Profile
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endforeach; ?>


  <!-- Pagination Controls -->
  <?php if ($totalPages > 1): ?>
    <nav aria-label="Users pagination" class="mt-4">
      <ul class="pagination justify-content-center amazon-pagination">
        <li class="page-item <?= $currentPage <= 1 ? 'disabled' : '' ?>">
          <a class="page-link" href="/users/<?= $currentPage - 1 ?>" tabindex="-1">
            <i class="bi bi-chevron-left"></i>
          </a>
        </li>
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
          <li class="page-item <?= $i == $currentPage ? 'active' : '' ?>">
            <a class="page-link" href="/users/<?= $i ?>"><?= $i ?></a>
          </li>
        <?php endfor; ?>
        <li class="page-item <?= $currentPage >= $totalPages ? 'disabled' : '' ?>">
          <a class="page-link" href="/users/<?= $currentPage + 1 ?>">
            <i class="bi bi-chevron-right"></i>
          </a>
        </li>
      </ul>
    </nav>
  <?php endif; ?>

<?php
include __DIR__ . '/layouts/footer.php';
?>