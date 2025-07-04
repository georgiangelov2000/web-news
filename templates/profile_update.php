<?php
include __DIR__ . '/layouts/header.php';

$pageTitle = 'Update Profile';
$customCss = '/assets/profile.css';
$profile = $data['profile'] ?? null;
$errors = $data['errors'] ?? [];

if (isset($customCss)): ?>
    <link rel="stylesheet" href="<?= htmlspecialchars($customCss) ?>">
<?php endif; ?>

<section class="profile-update">
    <div class="container">
        <h1><?= htmlspecialchars($pageTitle) ?></h1>
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST" action="/profile/update" class="profile-form" enctype="multipart/form-data">
            <input type="hidden" name="_method" value="PUT">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" id="username" name="username" class="form-control"
                       value="<?= htmlspecialchars($profile->username ?? '') ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" name="email" class="form-control"
                       value="<?= htmlspecialchars($profile->email ?? '') ?>" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">New Password (leave blank to keep current)</label>
                <input type="password" id="password" name="password" class="form-control">
            </div>
            <div class="mb-3">
                <label for="profile_image" class="form-label">Profile Image</label>
                <input type="file" id="profile_image" name="profile_image" class="form-control" accept="image/*">
                <?php if (!empty($profile->profile_image)): ?>
                    <div class="mt-2">
                        <img src="<?= htmlspecialchars($profile->profile_image) ?>" alt="Current Profile Image" class="img-thumbnail" style="max-width:120px;">
                        <div><small>Current image</small></div>
                    </div>
                <?php endif; ?>
            </div>
            <button type="submit" class="btn btn-primary">Update Profile</button>
        </form>
    </div>
</section>
<?php
include __DIR__ . '/layouts/footer.php';
// End of profile update template