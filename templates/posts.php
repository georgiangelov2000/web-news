<?php
$pageTitle = 'Posts';
include __DIR__ . '/layouts/header.php';

// Extract pagination data
$posts = $data['posts'] ?? [];
$currentPage = $data['current_page'] ?? 1;
$perPage = $data['per_page'] ?? 10;
$totalItems = $data['total_items'] ?? 0;
$totalPages = $data['total_pages'] ?? 1;
?>

<h4 class="mb-4">Posts</h4>

<div class="row g-4">
  <div class="slick-slider mb-5  bg-white rounded" id="slider1">
    <?php foreach ($posts as $post): ?>
      <div class="widget-post">
        <div class="card h-100 amazon-fancy-box border-0">
          <!-- Post Meta as Badge -->
          <span
            class="badge rounded-pill bg-warning text-dark mb-2 px-3 py-2 d-inline-flex align-items-center post-widget-badge">
            <i class="bi bi-clock me-1"></i>
            <?= isset($post['created_at']) ? htmlspecialchars($post['created_at']) : '' ?>
            <span class="mx-2">|</span>
            <i class="bi bi-person-circle me-1"></i>
            <?= isset($post['username']) ? htmlspecialchars($post['username']) : '' ?>
          </span>
          <div class="card-img-top bg-light d-flex align-items-center justify-content-center">
            <img src="https://images.unsplash.com/photo-1519125323398-675f0ddb6308?w=400&q=80" alt="Default product image"
              class="img-fluid" style="object-fit: contain;">
          </div>
          <div class="card-body px-4 pb-2 pt-3">
            <h6 class="card-title fw-bold mb-2 widget-title"><?= htmlspecialchars($post['title']) ?></h6>
            <p class="card-text text-secondary widget-text">
              <?= nl2br(htmlspecialchars($post['body'])) ?>
            </p>
          </div>
          <div class="card-footer bg-white border-0 pb-3 px-4">
            <div class="d-flex justify-content-between align-items-center mb-2">
              <div class="btn-group-widget-actions" role="group" aria-label="Post actions">
                <a class="btn btn-outline-warning btn-sm<?= !empty($post['is_favorite']) ? ' active' : '' ?>"
                  href="/posts/<?= $post['id'] ?? 0 ?>/favorite"
                  title="<?= !empty($post['is_favorite']) ? 'Remove from Favorites' : 'Add to Favorites' ?>">
                  <i class="bi bi-star<?= !empty($post['is_favorite']) ? '-fill text-warning' : '' ?>"></i>
                </a>

                <a class="btn btn-outline-success btn-sm" href="/posts/<?= $post['id'] ?? 0 ?>/like" title="Like">
                  <i class="bi bi-hand-thumbs-up"></i>
                </a>

                <a class="btn btn-outline-danger btn-sm" href="/posts/<?= $post['id'] ?? 0 ?>/dislike" title="Dislike">
                  <i class="bi bi-hand-thumbs-down"></i>
                </a>

                <a class="btn btn-outline-primary btn-sm" href="/posts/<?= $post['id'] ?? 0 ?>/share" title="Share">
                  <i class="bi bi-share"></i>
                </a>

                <a class="btn btn-outline-secondary btn-sm" href="/posts/<?= $post['id'] ?? 0 ?>/report" title="Report">
                  <i class="bi bi-flag"></i>
                </a>
              </div>
            </div>

            <!-- Fancy count display -->
            <div class="d-flex text-center small text-muted mb-2">
              <div style="margin-right: 1rem;">
                <i class="bi bi-hand-thumbs-up-fill text-success me-1"></i>
                <?= (int) ($post['likes'] ?? 0) ?> Likes
              </div>
              <div style="margin-right: 1rem;">
                <i class="bi bi-hand-thumbs-down-fill text-danger me-1"></i>
                <?= (int) ($post['dislikes'] ?? 0) ?> Dislikes
              </div>
              <div style="margin-right: 1rem;">
                <i class="bi bi-share-fill text-primary me-1"></i>
                <?= (int) ($post['shares'] ?? 0) ?> Shares
              </div>
            </div>

            <a class="btn btn-warning btn-sm rounded-pill shadow-sm w-100 mt-1"
              href="/api/post/<?= $post['alias'] ?? 0 ?>">Open post</a>
          </div>

        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <!-- Slider 2 -->
  <div class="slick-slider mb-5  bg-white rounded" id="slider2">
    <?php foreach ($posts as $post): ?>
      <div class="widget-post">
        <!-- You can change card content or keep same as above -->
        <div class="card h-100 amazon-fancy-box border-0">
          <!-- Post Meta as Badge -->
          <span
            class="badge rounded-pill bg-warning text-dark mb-2 px-3 py-2 d-inline-flex align-items-center post-widget-badge">
            <i class="bi bi-clock me-1"></i>
            <?= isset($post['created_at']) ? htmlspecialchars($post['created_at']) : '' ?>
            <span class="mx-2">|</span>
            <i class="bi bi-person-circle me-1"></i>
            <?= isset($post['username']) ? htmlspecialchars($post['username']) : '' ?>
          </span>
          <div class="card-img-top bg-light d-flex align-items-center justify-content-center">
            <img src="https://images.unsplash.com/photo-1519125323398-675f0ddb6308?w=400&q=80" alt="Default product image"
              class="img-fluid" style="object-fit: contain;">
          </div>
          <div class="card-body px-4 pb-2 pt-3">
            <h5 class="card-title fw-bold mb-2 widget-title"><?= htmlspecialchars($post['title']) ?></h5>
            <p class="card-text text-secondary widget-text">
              <?= nl2br(htmlspecialchars($post['body'])) ?>
            </p>
          </div>
          <div class="card-footer bg-white border-0 pb-3 px-4">
            <div class="d-flex justify-content-between align-items-center mb-2">
              <div class="btn-group-widget-actions" role="group" aria-label="Post actions">
                <a class="btn btn-outline-warning btn-sm<?= !empty($post['is_favorite']) ? ' active' : '' ?>"
                  href="/posts/<?= $post['id'] ?? 0 ?>/favorite"
                  title="<?= !empty($post['is_favorite']) ? 'Remove from Favorites' : 'Add to Favorites' ?>">
                  <i class="bi bi-star<?= !empty($post['is_favorite']) ? '-fill text-warning' : '' ?>"></i>
                </a>
                <a class="btn btn-outline-success btn-sm" href="/posts/<?= $post['id'] ?? 0 ?>/like" title="Like">
                  <i class="bi bi-hand-thumbs-up"></i>
                </a>
                <a class="btn btn-outline-danger btn-sm" href="/posts/<?= $post['id'] ?? 0 ?>/dislike" title="Dislike">
                  <i class="bi bi-hand-thumbs-down"></i>
                </a>
                <a class="btn btn-outline-primary btn-sm" href="/posts/<?= $post['id'] ?? 0 ?>/share" title="Share">
                  <i class="bi bi-share"></i>
                </a>
                <a class="btn btn-outline-secondary btn-sm" href="/posts/<?= $post['id'] ?? 0 ?>/report" title="Report">
                  <i class="bi bi-flag"></i>
                </a>
              </div>
            </div>
            <a class="btn btn-warning btn-sm rounded-pill shadow-sm w-100 mt-1"
              href="/api/post/<?= $post['alias'] ?? 0 ?>">Open
              post</a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <!-- Slider 3 -->
  <div class="slick-slider mb-5  bg-white rounded" id="slider3">
    <?php foreach ($posts as $post): ?>
      <div class="widget-post">
        <!-- You can change card content or keep same as above -->
        <div class="card h-100 amazon-fancy-box border-0">
          <!-- Post Meta as Badge -->
          <span
            class="badge rounded-pill bg-warning text-dark mb-2 px-3 py-2 d-inline-flex align-items-center post-widget-badge">
            <i class="bi bi-clock me-1"></i>
            <?= isset($post['created_at']) ? htmlspecialchars($post['created_at']) : '' ?>
            <span class="mx-2">|</span>
            <i class="bi bi-person-circle me-1"></i>
            <?= isset($post['username']) ? htmlspecialchars($post['username']) : '' ?>
          </span>
          <div class="card-img-top bg-light d-flex align-items-center justify-content-center">
            <img src="https://images.unsplash.com/photo-1519125323398-675f0ddb6308?w=400&q=80" alt="Default product image"
              class="img-fluid" style="object-fit: contain;">
          </div>
          <div class="card-body px-4 pb-2 pt-3">
            <h5 class="card-title fw-bold mb-2 widget-title"><?= htmlspecialchars($post['title']) ?></h5>
            <p class="card-text text-secondary widget-text">
              <?= nl2br(htmlspecialchars($post['body'])) ?>
            </p>
          </div>
          <div class="card-footer bg-white border-0 pb-3 px-4">
            <div class="d-flex justify-content-between align-items-center mb-2">
              <div class="btn-group-widget-actions" role="group" aria-label="Post actions">
                <a class="btn btn-outline-warning btn-sm btn-post-favorite<?= !empty($post['is_favorite']) ? ' active' : '' ?>"
                  role="button" data-post-id="<?= $post['id'] ?? 0 ?>"
                  title="<?= !empty($post['is_favorite']) ? 'Remove from Favorites' : 'Add to Favorites' ?>">
                  <i class="bi bi-star<?= !empty($post['is_favorite']) ? '-fill text-warning' : '' ?>"></i>
                </a>
                <a class="btn btn-outline-success btn-sm btn-post-like" role="button"
                  data-post-id="<?= $post['id'] ?? 0 ?>" title="Like">
                  <i class="bi bi-hand-thumbs-up"></i>
                </a>
                <a class="btn btn-outline-danger btn-sm btn-post-dislike" role="button"
                  data-post-id="<?= $post['id'] ?? 0 ?>" title="Dislike">
                  <i class="bi bi-hand-thumbs-down"></i>
                </a>
                <a class="btn btn-outline-primary btn-sm btn-post-share" role="button"
                  data-post-id="<?= $post['id'] ?? 0 ?>" title="Share">
                  <i class="bi bi-share"></i>
                </a>
                <a class="btn btn-outline-secondary btn-sm btn-post-report" role="button"
                  data-post-id="<?= $post['id'] ?? 0 ?>" title="Report">
                  <i class="bi bi-flag"></i>
                </a>
              </div>
            </div>
            <a class="btn btn-warning btn-sm rounded-pill shadow-sm w-100 mt-1"
              href="/api/post/<?= $post['alias'] ?? 0 ?>">Open
              post</a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <!-- Pagination Controls -->
  <?php if ($totalPages > 1): ?>
    <nav aria-label="Posts pagination" class="mt-4">
      <ul class="pagination justify-content-center amazon-pagination">
        <li class="page-item <?= $currentPage <= 1 ? 'disabled' : '' ?>">
          <a class="page-link" href="/api/posts/<?= $currentPage - 1 ?>" tabindex="-1">
            <i class="bi bi-chevron-left"></i>
          </a>
        </li>
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
          <li class="page-item <?= $i == $currentPage ? 'active' : '' ?>">
            <a class="page-link" href="/api/posts/<?= $i ?>"><?= $i ?></a>
          </li>
        <?php endfor; ?>
        <li class="page-item <?= $currentPage >= $totalPages ? 'disabled' : '' ?>">
          <a class="page-link" href="/api/posts/<?= $currentPage + 1 ?>">
            <i class="bi bi-chevron-right"></i>
          </a>
        </li>
      </ul>
    </nav>
  <?php endif; ?>

  <?php
  include __DIR__ . '/layouts/footer.php';
  ?>