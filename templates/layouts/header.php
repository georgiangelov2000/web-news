<?php
use App\Session\Session;
$session = $GLOBALS['session'] ?? new Session(__DIR__ . '/storage/session');
$userId = $session->get('user_id');
$userName = $session->get('user_name');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>
        <?php
        $defaultTitle = 'Modern PHP Web App by Georgi Angelov';
        if (isset($pageTitle) && $pageTitle) {
            echo htmlspecialchars($pageTitle) . ' | ' . $defaultTitle;
        } else {
            echo $defaultTitle;
        }
        ?>
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- SEO Meta Tags -->
    <meta name="description" content="<?= isset($pageDescription) ? htmlspecialchars($pageDescription) : 'A modern PHP web application featuring Bootstrap 5, fast performance, and user-friendly design. Developed by Georgi Angelov.' ?>">
    <meta name="keywords" content="PHP, Web Application, Bootstrap, Modern Design, Georgi Angelov, Responsive, SEO, User Experience">
    <meta name="author" content="Georgi Angelov">
    <meta property="og:title" content="<?= isset($pageTitle) ? htmlspecialchars($pageTitle) . ' | ' : '' ?>Modern PHP Web App by Georgi Angelov">
    <meta property="og:description" content="<?= isset($pageDescription) ? htmlspecialchars($pageDescription) : 'A modern PHP web application featuring Bootstrap 5, fast performance, and user-friendly design. Developed by Georgi Angelov.' ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= htmlspecialchars($_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); ?>">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= isset($pageTitle) ? htmlspecialchars($pageTitle) . ' | ' : '' ?>Modern PHP Web App by Georgi Angelov">
    <meta name="twitter:description" content="<?= isset($pageDescription) ? htmlspecialchars($pageDescription) : 'A modern PHP web application featuring Bootstrap 5, fast performance, and user-friendly design. Developed by Georgi Angelov.' ?>">
    <link rel="canonical" href="<?= htmlspecialchars($_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); ?>">
    <!-- Favicon: Cool Rocket -->
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32'%3E%3Cg%3E%3Cellipse cx='16' cy='16' rx='13' ry='15' fill='%232c3e50'/%3E%3Cpath d='M16 6L19 16L16 19L13 16L16 6Z' fill='%23f39c12'/%3E%3Cellipse cx='16' cy='22' rx='2' ry='1.5' fill='%23e74c3c'/%3E%3C/g%3E%3C/svg%3E">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastr@2.1.4/build/toastr.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="/assets/main.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />
</head>

<body>
    <header>
        <?php
        $session = $GLOBALS['session'];
        ?>
        <nav class="navbar navbar-expand-lg amazon-navbar mb-4 py-2">
            <div class="container">
                <a class="navbar-brand" href="/">
                    <i class="bi bi-lightning-charge-fill text-warning me-1"></i> My App
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <?php
                    if ($session->get('user_id')) {
                        require __DIR__ . '/authenticated.php';
                    } else {
                        require __DIR__ . '/guest.php';
                    }
                    ?>
                </div>
            </div>
        </nav>

    </header>
    <main class="container">