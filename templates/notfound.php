<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>404 - Not Found</title>
    <style>
        body {
            background: #f6f8fa;
            color: #222;
            font-family: 'Segoe UI', Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 480px;
            margin: 8vh auto;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08);
            text-align: center;
            padding: 3rem 2.2rem 2.2rem 2.2rem;
        }
        h1 {
            font-size: 2.3rem;
            color: #e74c3c;
            margin-bottom: 1.2rem;
        }
        p {
            font-size: 1.15rem;
            margin: 0.7em 0 0.3em 0;
        }
        .template {
            color: #888;
            font-size: 1em;
        }
        .icon {
            font-size: 3.7rem;
            color: #e74c3c;
            margin-bottom: 0.7rem;
            line-height: 1;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="icon">🚫</div>
        <h1>404 - Not Found</h1>
        <p>The requested view or resource could not be found.</p>
        <?php if (isset($template)): ?>
            <p class="template">
                Template: <strong><?= htmlspecialchars($template) ?></strong>
            </p>
        <?php endif; ?>
    </div>
</body>
</html>