<?php

declare(strict_types=1);

/**
 * Renders PHP pages to static HTML for GitHub Pages deployment.
 * GitHub Pages serves static files only — PHP runs here at build time.
 */

$root = dirname(__DIR__);
$outputDir = $root . '/public';

function renderPage(string $file, callable $bootstrap): string
{
    $bootstrap();
    ob_start();
    include $file;
    return ob_get_clean();
}

function writeFile(string $path, string $contents): void
{
    $dir = dirname($path);
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
    file_put_contents($path, $contents);
}

function copyDirectory(string $source, string $destination): void
{
    if (!is_dir($destination)) {
        mkdir($destination, 0755, true);
    }

    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($source, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::SELF_FIRST
    );

    foreach ($iterator as $item) {
        $target = $destination . DIRECTORY_SEPARATOR . $iterator->getSubPathName();

        if ($item->isDir()) {
            if (!is_dir($target)) {
                mkdir($target, 0755, true);
            }
        } else {
            copy($item->getPathname(), $target);
        }
    }
}

function rewriteLinksForStatic(string $html): string
{
    $replacements = [
        'href="index.php"' => 'href="index.html"',
        'href="pets.php"' => 'href="pets.html"',
        'href="logout.php"' => 'href="logout.html"',
        'action="index.php"' => 'action="index.html"',
    ];

    return str_replace(array_keys($replacements), array_values($replacements), $html);
}

function removeDirectory(string $dir): void
{
    if (!is_dir($dir)) {
        return;
    }

    $items = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::CHILD_FIRST
    );

    foreach ($items as $item) {
        if ($item->isDir()) {
            rmdir($item->getPathname());
        } else {
            unlink($item->getPathname());
        }
    }

    rmdir($dir);
}

echo "Building static site for GitHub Pages...\n";

removeDirectory($outputDir);
mkdir($outputDir, 0755, true);

require_once $root . '/includes/auth.php';
require_once $root . '/includes/config.php';

// Login page (no session)
$indexHtml = renderPage($root . '/index.php', function (): void {
    if (session_status() === PHP_SESSION_ACTIVE) {
        session_destroy();
    }
});
$indexHtml = rewriteLinksForStatic($indexHtml);
$indexHtml = str_replace(
    '</body>',
    '    <script src="assets/js/static-auth.js"></script>' . "\n</body>",
    $indexHtml
);
writeFile($outputDir . '/index.html', $indexHtml);

// Pets page (simulate logged-in session)
$petsHtml = renderPage($root . '/pets.php', function (): void {
    startSession();
    $_SESSION['user'] = [
        'email' => MOCK_USER['email'],
        'name' => MOCK_USER['name'],
    ];
});
$petsHtml = rewriteLinksForStatic($petsHtml);
writeFile($outputDir . '/pets.html', $petsHtml);

// Simple logout redirect page
$logoutHtml = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="0;url=index.html">
    <title>Logging out...</title>
</head>
<body>
    <p>Logging out... <a href="index.html">Continue</a></p>
    <script>
        localStorage.removeItem('petpal_authenticated');
        window.location.href = 'index.html';
    </script>
</body>
</html>
HTML;
writeFile($outputDir . '/logout.html', $logoutHtml);

// Copy assets
copyDirectory($root . '/assets', $outputDir . '/assets');

// GitHub Pages: skip Jekyll processing
writeFile($outputDir . '/.nojekyll', '');

echo "Static site written to public/\n";
echo "  - index.html\n";
echo "  - pets.html\n";
echo "  - logout.html\n";
echo "  - assets/\n";
