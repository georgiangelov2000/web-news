<?php
$pageTitle = 'Profile';
include __DIR__ . '/layouts/header.php';
$customCss = '/assets/profile.css';
?>

<?php if (isset($customCss)): ?>
    <link rel="stylesheet" href="<?= htmlspecialchars($customCss) ?>">
<?php endif; ?>

<div class="profile-container">
    <div class="profile-header">
        <div class="avatar">
            <img class="img-fluid rounded" src="<?= htmlspecialchars($user->avatar ?? 'data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wCEAAkGBwgHBgkIBwgKCgkLDRYPDQwMDRsUFRAWIB0iIiAdHx8kKDQsJCYxJx8fLT0tMTU3Ojo6Iys/RD84QzQ5OjcBCgoKDQwNGg8PGjclHyU3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3N//AABEIALgAwwMBIgACEQEDEQH/xAAbAAEBAAMBAQEAAAAAAAAAAAAABQMEBgECB//EADMQAQABAwEECQQBAwUAAAAAAAABAgMEEQU0U3ISFBUhMVGRobEyM3HBQRNSYSIkQkWD/8QAFQEBAQAAAAAAAAAAAAAAAAAAAAL/xAAUEQEAAAAAAAAAAAAAAAAAAAAA/9oADAMBAAIRAxEAPwD9hAUkAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAS9rZlduqLNqej3a1THiqIO199nlgGKmxlVxFUUXZie/Xv73vVsvh3fSV3G3a1yR8PjJzLGPOlyrWr+2O+QRerZfDu+knVsvh3fSVextHHvVRTFU01T4RVGmrbBzvVsvh3fSTq2Xw7vpLogHO9Wy+Hd9JOrZfDu+kuiAc71bL4d30k6tl8O76S6IBzlNzJxLkazXRPjpV4Sv492L1mi5EadKNdPJK25961yy39mbja/E/Mg2gAAAAAAAAAAAEHa++zywvIO199nlgFe3V0MKiv+21E+zna6prqmqqdapnWZdJjxFWLbifCbcRPohZeJcxq5iaZmj/jVANZ0Wz7tV3Dt1Vd9XhM/hCsWLl+uKbdEz/n+IdFj2osWaLUd/Rjx8wZAfNy5TaomuudKY8ZAuXKbVE11zpTHjL5sXqL9uLludYn2Qs7Mqyq+7WLcfTT+5fGJk14tzpU98T9VPmDpBjsXqL9uLludYn2ZARtufetcst/Zm42vxPzLQ25961yy39mbja/E/Mg2gAAAAAAAAAAAEHa++zywvIO199nlgFnG3a1yR8MrFjbta5I+H3crpt0TXXMRTHjIFVVNumaqpimmP5nufTn8/Mqyq9I7rceFP7ln2dtD+lH9K/P+iPpq8gV7lym1RNdc6Ux4ygZ2ZVlV92sW4+mn9yZ2ZVlV92sW4+mn9y1QAAZ8TKrxbnSp76Z+qnzdBYvUX7cXLc6xPs5hQ2LVMZNVOs6TRrMA+tufetcst/Zm42vxPzLQ25961yy39mbja/E/Mg2gAAAAAAAAAAAEHa++zywvIO199nlgFixVFOJbqq7oi3Ez6Iudm1ZVekaxbjwp/cq//Xf+P6c9pPkDwe6T5Gk+QPB7pPkaT5A8Huk+RpPkDxQ2LvdXJPzDQ0nyb+xY/wB3VyT8wD625961yy39mbja/E/MtDbn3rXLLf2ZuNr8T8yDaAAAAAAAAAAAAQtsRpmz/mmF1rZuHRl0xrPRrjwqBjx83GixbpquxExTETEsnXsXjUp/Y93iUe52Pe4lHuCh17F41J17F41Kf2Pe4lHudj3uJR7godexeNSdexeNSn9j3uJR7nY97iUe4KHXsXjUnXsXjUp/Y97iUe52Pe4lHuCh17F41J17F41Kf2Pe4lHudj3uJR7gx7Wv2792ibVXSiKe+VTZsaYNrXyn5aVnZE9OJvXImnyp/lVpiKaYppjSIjSIB6AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD/9k=') ?>" alt="Avatar">
        </div>
        <div class="profile-info">
            <h2><?= htmlspecialchars($user->username) ?></h2>
            <p><i class="bi bi-envelope text-secondary me-1"></i><?= htmlspecialchars($user->email) ?></p>
            <span class="badge bg-primary">Your Profile</span>
        </div>
    </div>

    <nav class="profile-actions-nav mt-3">
        <ul class="nav nav-pills">
            <li class="nav-item">
                <a class="nav-link" href="/posts/create"><i class="bi bi-plus-circle me-1"></i>Create Post</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/profile/update"><i class="bi bi-plus-circle me-1"></i>Update Profile</a>
            </li>
        </ul>
    </nav>

    <div class="profile-details">
        <div class="stat-group mb-3 mt-4">
            <div class="stat-item"><i class="bi bi-calendar-event me-1"></i><span>Member since
                    <strong><?= date('Y-m-d', strtotime($user->created_at ?? 'now')) ?></strong></span></div>
            <div class="stat-item"><i class="bi bi-pencil-square me-1"></i><span>Posts
                    <strong><?= $user->posts_count ?? '--' ?></strong></span></div>
            <div class="stat-item"><i class="bi bi-star-fill me-1"></i><span>Favorites
                    <strong><?= $user->favorites_count ?? '--' ?></strong></span></div>
        </div>
    </div>

    <div class="user-favorites mt-5">
        <h4 class="mb-3"><i class="bi bi-star-fill me-2"></i>Classified posts</h4>

        <!-- Tabs -->
        <ul class="nav nav-tabs" id="favoritesTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="my-posts-tab" data-bs-toggle="tab" data-bs-target="#my-posts"
                    type="button" role="tab" aria-controls="my-posts" aria-selected="true">
                    My Posts
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="fav-posts-tab" data-bs-toggle="tab" data-bs-target="#fav-posts"
                    type="button" role="tab" aria-controls="fav-posts" aria-selected="false">
                    Favorite Posts
                </button>
            </li>
        </ul>

        <!-- Tab content -->
        <div class="tab-content border border-top-0 p-3 bg-light" id="favoritesTabContent">
            <!-- Tab 1: My Posts -->
            <div class="tab-pane fade show active" id="my-posts" role="tabpanel" aria-labelledby="my-posts-tab">
                <?php if (!empty($posts)): ?>
                    <ul class="list-group">
                        <?php foreach ($posts as $post): ?>
                            <li class="list-group-item">
                                <div class="mb-2">
                                    <img src="<?= htmlspecialchars($post->image ?: 'data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wCEAAkGBwgHBgkIBwgKCgkLDRYPDQwMDRsUFRAWIB0iIiAdHx8kKDQsJCYxJx8fLT0tMTU3Ojo6Iys/RD84QzQ5OjcBCgoKDQwNGg8PGjclHyU3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3N//AABEIALgAwwMBIgACEQEDEQH/xAAbAAEBAAMBAQEAAAAAAAAAAAAABQMEBgECB//EADMQAQABAwEECQQBAwUAAAAAAAABAgMEEQU0U3ISFBUhMVGRobEyM3HBQRNSYSIkQkWD/8QAFQEBAQAAAAAAAAAAAAAAAAAAAAL/xAAUEQEAAAAAAAAAAAAAAAAAAAAA/9oADAMBAAIRAxEAPwD9hAUkAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAS9rZlduqLNqej3a1THiqIO199nlgGKmxlVxFUUXZie/Xv73vVsvh3fSV3G3a1yR8PjJzLGPOlyrWr+2O+QRerZfDu+knVsvh3fSVextHHvVRTFU01T4RVGmrbBzvVsvh3fSTq2Xw7vpLogHO9Wy+Hd9JOrZfDu+kuiAc71bL4d30k6tl8O76S6IBzlNzJxLkazXRPjpV4Sv492L1mi5EadKNdPJK25961yy39mbja/E/Mg2gAAAAAAAAAAAEHa++zywvIO199nlgFe3V0MKiv+21E+zna6prqmqqdapnWZdJjxFWLbifCbcRPohZeJcxq5iaZmj/jVANZ0Wz7tV3Dt1Vd9XhM/hCsWLl+uKbdEz/n+IdFj2osWaLUd/Rjx8wZAfNy5TaomuudKY8ZAuXKbVE11zpTHjL5sXqL9uLludYn2Qs7Mqyq+7WLcfTT+5fGJk14tzpU98T9VPmDpBjsXqL9uLludYn2ZARtufetcst/Zm42vxPzLQ25961yy39mbja/E/Mg2gAAAAAAAAAAAEHa++zywvIO199nlgFnG3a1yR8MrFjbta5I+H3crpt0TXXMRTHjIFVVNumaqpimmP5nufTn8/Mqyq9I7rceFP7ln2dtD+lH9K/P+iPpq8gV7lym1RNdc6Ux4ygZ2ZVlV92sW4+mn9yZ2ZVlV92sW4+mn9y1QAAZ8TKrxbnSp76Z+qnzdBYvUX7cXLc6xPs5hQ2LVMZNVOs6TRrMA+tufetcst/Zm42vxPzLQ25961yy39mbja/E/Mg2gAAAAAAAAAAAEHa++zywvIO199nlgFixVFOJbqq7oi3Ez6Iudm1ZVekaxbjwp/cq//Xf+P6c9pPkDwe6T5Gk+QPB7pPkaT5A8Huk+RpPkDxQ2LvdXJPzDQ0nyb+xY/wB3VyT8wD625961yy39mbja/E/MtDbn3rXLLf2ZuNr8T8yDaAAAAAAAAAAAAQtsRpmz/mmF1rZuHRl0xrPRrjwqBjx83GixbpquxExTETEsnXsXjUp/Y93iUe52Pe4lHuCh17F41J17F41Kf2Pe4lHudj3uJR7godexeNSdexeNSn9j3uJR7nY97iUe4KHXsXjUnXsXjUp/Y97iUe52Pe4lHuCh17F41J17F41Kf2Pe4lHudj3uJR7gx7Wv2792ibVXSiKe+VTZsaYNrXyn5aVnZE9OJvXImnyp/lVpiKaYppjSIjSIB6AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD/9k=') ?>"
                                        alt="Post image" class="img-fluid rounded mb-2"
                                        style="max-height: 200px; object-fit: cover;">
                                </div>
                                <span class="text-muted small"><?= date('Y-m-d H:i', strtotime($post->created_at)) ?></span>
                                <div>
                                    <a href="/post/<?= htmlspecialchars($post->alias) ?>"
                                        class="fw-semibold"><?= htmlspecialchars($post->title) ?></a>
                                </div>
                                <div class="small text-secondary">
                                    <?= mb_strimwidth(strip_tags($post->body), 0, 120, '...') ?>
                                </div>
                                <div>
                                    <a href="/post/<?= htmlspecialchars($post->alias) ?>"
                                        class="small text-decoration-underline">View Post</a>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <div class="text-muted">You have no favorite topics yet.</div>
                <?php endif; ?>
            </div>

            <!-- Tab 2: Favorite Posts -->
            <div class="tab-pane fade" id="fav-posts" role="tabpanel" aria-labelledby="fav-posts-tab">
                <?php if (!empty($favoritePosts)): ?>
                    <ul class="list-group">
                        <?php foreach ($favoritePosts as $post): ?>
                            <li class="list-group-item">
                                <div class="mb-2">
                                    <img src="<?= htmlspecialchars($post->image ?: 'data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wCEAAkGBwgHBgkIBwgKCgkLDRYPDQwMDRsUFRAWIB0iIiAdHx8kKDQsJCYxJx8fLT0tMTU3Ojo6Iys/RD84QzQ5OjcBCgoKDQwNGg8PGjclHyU3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3N//AABEIALgAwwMBIgACEQEDEQH/xAAbAAEBAAMBAQEAAAAAAAAAAAAABQMEBgECB//EADMQAQABAwEECQQBAwUAAAAAAAABAgMEEQU0U3ISFBUhMVGRobEyM3HBQRNSYSIkQkWD/8QAFQEBAQAAAAAAAAAAAAAAAAAAAAL/xAAUEQEAAAAAAAAAAAAAAAAAAAAA/9oADAMBAAIRAxEAPwD9hAUkAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAS9rZlduqLNqej3a1THiqIO199nlgGKmxlVxFUUXZie/Xv73vVsvh3fSV3G3a1yR8PjJzLGPOlyrWr+2O+QRerZfDu+knVsvh3fSVextHHvVRTFU01T4RVGmrbBzvVsvh3fSTq2Xw7vpLogHO9Wy+Hd9JOrZfDu+kuiAc71bL4d30k6tl8O76S6IBzlNzJxLkazXRPjpV4Sv492L1mi5EadKNdPJK25961yy39mbja/E/Mg2gAAAAAAAAAAAEHa++zywvIO199nlgFe3V0MKiv+21E+zna6prqmqqdapnWZdJjxFWLbifCbcRPohZeJcxq5iaZmj/jVANZ0Wz7tV3Dt1Vd9XhM/hCsWLl+uKbdEz/n+IdFj2osWaLUd/Rjx8wZAfNy5TaomuudKY8ZAuXKbVE11zpTHjL5sXqL9uLludYn2Qs7Mqyq+7WLcfTT+5fGJk14tzpU98T9VPmDpBjsXqL9uLludYn2ZARtufetcst/Zm42vxPzLQ25961yy39mbja/E/Mg2gAAAAAAAAAAAEHa++zywvIO199nlgFnG3a1yR8MrFjbta5I+H3crpt0TXXMRTHjIFVVNumaqpimmP5nufTn8/Mqyq9I7rceFP7ln2dtD+lH9K/P+iPpq8gV7lym1RNdc6Ux4ygZ2ZVlV92sW4+mn9yZ2ZVlV92sW4+mn9y1QAAZ8TKrxbnSp76Z+qnzdBYvUX7cXLc6xPs5hQ2LVMZNVOs6TRrMA+tufetcst/Zm42vxPzLQ25961yy39mbja/E/Mg2gAAAAAAAAAAAEHa++zywvIO199nlgFixVFOJbqq7oi3Ez6Iudm1ZVekaxbjwp/cq//Xf+P6c9pPkDwe6T5Gk+QPB7pPkaT5A8Huk+RpPkDxQ2LvdXJPzDQ0nyb+xY/wB3VyT8wD625961yy39mbja/E/MtDbn3rXLLf2ZuNr8T8yDaAAAAAAAAAAAAQtsRpmz/mmF1rZuHRl0xrPRrjwqBjx83GixbpquxExTETEsnXsXjUp/Y93iUe52Pe4lHuCh17F41J17F41Kf2Pe4lHudj3uJR7godexeNSdexeNSn9j3uJR7nY97iUe4KHXsXjUnXsXjUp/Y97iUe52Pe4lHuCh17F41J17F41Kf2Pe4lHudj3uJR7gx7Wv2792ibVXSiKe+VTZsaYNrXyn5aVnZE9OJvXImnyp/lVpiKaYppjSIjSIB6AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD/9k=') ?>"
                                        alt="Post image" class="img-fluid rounded mb-2"
                                        style="max-height: 200px; object-fit: cover;">
                                </div>
                                <span class="text-muted small"><?= date('Y-m-d H:i', strtotime($post->created_at)) ?></span>
                                <div>
                                    <a href="/post/<?= htmlspecialchars($post->alias) ?>"
                                        class="fw-semibold"><?= htmlspecialchars($post->title) ?></a>
                                </div>
                                <div class="small text-secondary">
                                    <?= mb_strimwidth(strip_tags($post->body), 0, 120, '...') ?>
                                </div>
                                <div>
                                    <a href="/post/<?= htmlspecialchars($post->alias) ?>"
                                        class="small text-decoration-underline">View Post</a>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <div class="text-muted">You have no favorite posts yet.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>

</div>

<?php include __DIR__ . '/layouts/footer.php'; ?>