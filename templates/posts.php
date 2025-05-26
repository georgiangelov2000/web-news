<?php
$pageTitle = 'Posts';
include __DIR__ . '/layouts/header.php';

// Extract pagination data
$posts = $data['posts'] ?? [];
$favIds = $data['favIds'] ?? [];
$liked = $data['liked'] ?? [];
$disliked = $data['disliked'] ?? [];
$currentPage = $data['current_page'] ?? 1;
$perPage = $data['per_page'] ?? 10;
$totalItems = $data['total_items'] ?? 0;
$totalPages = $data['total_pages'] ?? 1;
?>

<h4 class="mb-4">Posts</h4>

<div class="row g-4">
  <?php
  $chunks = array_chunk($posts, 5);
  foreach ($chunks as $i => $group):
    $sliderId = 'slider' . ($i + 1);
    ?>
    <div class="slick-slider mb-5 bg-white rounded" id="<?= $sliderId ?>">
      <?php foreach ($group as $post): ?>
        <?php
          $favorited = in_array($post['id'], $favIds);
          $liked1 = in_array($post['id'], $liked);
          $disliked1 = in_array($post['id'], $disliked);
        ?>
        <div class="widget-post">
          <div class="card h-100 amazon-fancy-box border-0">
          <span
            class="badge rounded-pill bg-warning text-dark mb-2 px-3 py-2 d-inline-flex align-items-center post-widget-badge">
            <i class="bi bi-clock me-1"></i> <?= htmlspecialchars($post['created_at']) ?>
            <span class="mx-2">|</span>
            <i class="bi bi-person-circle me-1"></i>
            <?php if (!empty($post['promoted']) && $post['promoted'] == 1): ?>
              <span class="badge bg-success ms-2">Promoted</span>
            <?php endif; ?>
          </span>

            <div class="card-img-top bg-light d-flex align-items-center justify-content-center">
              <img src="https://images.unsplash.com/photo-1519125323398-675f0ddb6308?w=400&q=80" alt="Default product image"
                class="img-fluid" style="object-fit: contain;">
            </div>

            <div class="card-body px-4 pb-2 pt-3">
              <h6 class="card-title fw-bold mb-2 widget-title"><?= htmlspecialchars($post['title']) ?></h6>
              <p class="card-text text-secondary widget-text"><?= nl2br(htmlspecialchars($post['body'])) ?></p>
            </div>

            <div class="card-footer bg-white border-0 pb-3 px-4">
              <div class="d-flex justify-content-between align-items-center mb-2">
                <div class="btn-group-widget-actions" role="group">
                  <a class="btn-post-favorite btn btn-outline-warning btn-sm<?= $favorited ? ' active' : '' ?>"
                    role="button" 
                    data-post-id="<?= $post['id'] ?? 0 ?>"
                    title="<?= $favorited ? 'Remove from Favorites' : 'Add to Favorites' ?>"
                  >
                    <i class="bi bi-star<?= $favorited ? '-fill text-warning' : '' ?>"></i>
                  </a>
                  <a 
                    class="btn btn-outline-success btn-sm btn-post-like <?= $liked1 ? ' active' : '' ?>" 
                    role="button" 
                    data-post-id="<?= $post['id'] ?? 0 ?>" 
                    title="Like"
                    title="<?= $liked1 ? 'Remove from Likes' : 'Add to Likes' ?>"
                  >
                    <i class="bi bi-hand-thumbs-up"></i>
                  </a>
                  <a 
                    class="btn btn-outline-danger btn-sm btn-post-dislike <?= $disliked ? ' active' : '' ?>" 
                    role="button" 
                    data-post-id="<?= $post['id'] ?? 0 ?>" 
                    title="Dislike"
                    title="<?= $disliked1 ? 'Remove from Dislikes' : 'Add to Dislikes' ?>"
                  >
                    <i class="bi bi-hand-thumbs-down"></i>
                  </a>
                  <a 
                    class="btn btn-outline-primary btn-sm btn-post-share" 
                    role="button" 
                    data-post-id="<?= $post['id'] ?? 0 ?>" 
                    title="Share"
                  >
                    <i class="bi bi-share"></i>
                  </a>
                  <a 
                    class="btn btn-outline-secondary btn-sm btn-post-report" 
                    role="button" 
                    data-post-id="<?= $post['id'] ?? 0 ?>" 
                    title="Report"
                  >
                    <i class="bi bi-flag"></i>
                  </a>
                </div>
              </div>

              <div class="d-flex text-center small text-muted mb-2">
                <div class="me-3">
                  <i class="bi bi-hand-thumbs-up-fill text-success me-1"></i>
                  <?= (int) ($post['likes'] ?? 0) ?> Likes
                </div>
                <div class="me-3">
                  <i class="bi bi-hand-thumbs-down-fill text-danger me-1"></i>
                  <?= (int) ($post['dislikes'] ?? 0) ?> Dislikes
                </div>
                <div>
                  <i class="bi bi-share-fill text-primary me-1"></i>
                  <?= (int) ($post['shares'] ?? 0) ?> Shares
                </div>
              </div>

              <a class="btn btn-warning btn-sm rounded-pill shadow-sm w-100 mt-1"
                href="/post/<?= $post['alias'] ?? 0 ?>">Open post</a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endforeach; ?>


  <!-- Pagination Controls -->
  <?php if ($totalPages > 1): ?>
    <nav aria-label="Posts pagination" class="mt-4">
      <ul class="pagination justify-content-center amazon-pagination">
        <li class="page-item <?= $currentPage <= 1 ? 'disabled' : '' ?>">
          <a class="page-link" href="/posts/<?= $currentPage - 1 ?>" tabindex="-1">
            <i class="bi bi-chevron-left"></i>
          </a>
        </li>
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
          <li class="page-item <?= $i == $currentPage ? 'active' : '' ?>">
            <a class="page-link" href="/posts/<?= $i ?>"><?= $i ?></a>
          </li>
        <?php endfor; ?>
        <li class="page-item <?= $currentPage >= $totalPages ? 'disabled' : '' ?>">
          <a class="page-link" href="/posts/<?= $currentPage + 1 ?>">
            <i class="bi bi-chevron-right"></i>
          </a>
        </li>
      </ul>
    </nav>
  <?php endif; ?>

  <?php
  include __DIR__ . '/layouts/footer.php';
  ?>