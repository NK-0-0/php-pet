<?php

declare(strict_types=1);

require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/config.php';

startSession();

if (isLoggedIn()) {
    header('Location: pets.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (login($email, $password)) {
        header('Location: pets.php');
        exit;
    }

    $error = 'Invalid email or password. Try the demo credentials below.';
}

$pageTitle = 'Sign In';
require __DIR__ . '/includes/header.php';
?>

<section class="hero">
    <div class="hero-content">
        <p class="eyebrow">Welcome to your cozy pet corner</p>
        <h1>Find your favorite furry &amp; feathered friends</h1>
        <p class="hero-text">
            Sign in to browse our adorable collection of dogs, cats, and birds.
            Demo credentials are pre-filled — just click Sign In!
        </p>
    </div>

    <div class="card login-card">
        <h2>Sign In</h2>

        <?php if ($error): ?>
            <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="post" action="index.php" class="login-form">
            <label for="email">Email</label>
            <input
                type="email"
                id="email"
                name="email"
                value="<?= htmlspecialchars(MOCK_USER['email']) ?>"
                required
                autocomplete="username"
            >

            <label for="password">Password</label>
            <input
                type="password"
                id="password"
                name="password"
                value="<?= htmlspecialchars(MOCK_USER['password']) ?>"
                required
                autocomplete="current-password"
            >

            <button type="submit" class="btn btn-primary">Sign In</button>
        </form>

        <p class="hint">
            Demo account: <strong><?= htmlspecialchars(MOCK_USER['email']) ?></strong>
            / <strong><?= htmlspecialchars(MOCK_USER['password']) ?></strong>
        </p>
    </div>
</section>

<section class="pet-preview">
    <h2>Who will you meet?</h2>
    <div class="preview-grid">
        <div class="preview-item"><span>🐕</span><p>Dogs</p></div>
        <div class="preview-item"><span>🐱</span><p>Cats</p></div>
        <div class="preview-item"><span>🐦</span><p>Birds</p></div>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
