<?php
require 'config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function isAuthorized($user)
{
    return $_SESSION['user']['role'] === 'admin' || $_SESSION['user']['id'] == $user['id'];
}
function isAuthenticated(): void
{
    if (!isset($_SESSION['user'])) {
        header("Location: index.php?error=Vui lòng đăng nhập");
        exit();
    }
}
function rememberToken(): void {
    global $pdo;
    if (!isset($_SESSION['user']) && isset($_COOKIE['remember_token'])) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE remember_token = :token");
        $stmt->execute(['token' => $_COOKIE['remember_token']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($user) {
            $_SESSION['user'] = $user;
        }
    }
}




