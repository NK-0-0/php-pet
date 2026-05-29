<?php

declare(strict_types=1);

require_once __DIR__ . '/config.php';

function startSession(): void
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

function isLoggedIn(): bool
{
    startSession();
    return isset($_SESSION['user']);
}

function currentUser(): ?array
{
    startSession();
    return $_SESSION['user'] ?? null;
}

function login(string $email, string $password): bool
{
    startSession();

    if ($email === MOCK_USER['email'] && $password === MOCK_USER['password']) {
        $_SESSION['user'] = [
            'email' => MOCK_USER['email'],
            'name' => MOCK_USER['name'],
        ];
        return true;
    }

    return false;
}

function logout(): void
{
    startSession();
    $_SESSION = [];
    session_destroy();
}

function requireLogin(): void
{
    if (!isLoggedIn()) {
        header('Location: index.php');
        exit;
    }
}
