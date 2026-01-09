<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex,nofollow">
    <link rel="icon" type="image/svg+xml" href="./favicon.svg">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="style.css?v=4">
    <title><?= t('app_title') ?></title>
</head>
<body>
    <div class="layout">
        <main class="main-content">
            <?php include __DIR__ . '/partials/header.php'; ?>
            <?php include __DIR__ . '/partials/message.php'; ?>
            <?php include __DIR__ . '/partials/upload-form.php'; ?>
        </main>

        <?php include __DIR__ . '/partials/sidebar.php'; ?>
        <?php include __DIR__ . '/partials/modal.php'; ?>

        <button class="sidebar-toggle" id="sidebarToggle">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/>
            </svg>
            <span><?= $fileCount ?></span>
        </button>

        <footer class="footer">
            <a href="https://brnt.cz" target="_blank" rel="noopener">
                <img src="./brnt-logo-w.png" alt="brnt.cz">
            </a>
        </footer>
    </div>

    <script src="app.js?v=1"></script>
</body>
</html>
