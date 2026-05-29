<?php

declare(strict_types=1);

require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/pets-data.php';

requireLogin();

$user = currentUser();
$pets = getPets();
$stats = getPetStats();
$pageTitle = 'My Pets';
$activePage = 'pets';

require __DIR__ . '/includes/header.php';
?>

<section class="page-header">
    <div>
        <p class="eyebrow">Hello, <?= htmlspecialchars($user['name']) ?>!</p>
        <h1>Your Pet Gallery</h1>
        <p class="hero-text">Browse our mock roster of cute companions.</p>
    </div>
    <div class="stats-bar">
        <?php foreach ($stats as $type => $count): ?>
            <div class="stat">
                <span class="stat-count"><?= $count ?></span>
                <span class="stat-label"><?= htmlspecialchars($type) ?>s</span>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<section class="pet-grid">
    <?php foreach ($pets as $pet): ?>
        <article class="pet-card">
            <div class="pet-emoji"><?= $pet['emoji'] ?></div>
            <div class="pet-info">
                <span class="pet-type"><?= htmlspecialchars($pet['type']) ?></span>
                <h2><?= htmlspecialchars($pet['name']) ?></h2>
                <p class="pet-breed"><?= htmlspecialchars($pet['breed']) ?></p>
                <p class="pet-age"><?= $pet['age'] ?> year<?= $pet['age'] === 1 ? '' : 's' ?> old</p>
                <p class="pet-personality"><?= htmlspecialchars($pet['personality']) ?></p>
            </div>
        </article>
    <?php endforeach; ?>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
