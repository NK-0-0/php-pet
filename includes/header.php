<?php

declare(strict_types=1);

require_once __DIR__ . '/config.php';

/** @var string $pageTitle */
$pageTitle = $pageTitle ?? APP_NAME;
/** @var string $activePage */
$activePage = $activePage ?? '';
$user = $user ?? null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?> | <?= htmlspecialchars(APP_NAME) ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header class="site-header">
        <div class="container header-inner">
            <a href="<?= $user ? 'pets.php' : 'index.php' ?>" class="logo">
                <span class="logo-icon">🐾</span>
                <?= htmlspecialchars(APP_NAME) ?>
            </a>
            <?php if ($user): ?>
                <nav class="nav">
                    <a href="pets.php" class="<?= $activePage === 'pets' ? 'active' : '' ?>">My Pets</a>
                    <a href="logout.php" class="nav-logout">Log out</a>
                </nav>
            <?php endif; ?>
        </div>
    </header>
    <main class="container">
