<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Pastikan user sudah login, kalau belum tendang ke halaman login
 */
function cekLogin()
{
    if (!isset($_SESSION['user_id'])) {
        header('Location: ' . BASE_URL . 'auth/login.php');
        exit;
    }
}

/**
 * Pastikan role user sesuai dengan yang diizinkan.
 * Contoh: cekRole(['admin']) hanya izinkan admin.
 */
function cekRole(array $allowedRoles)
{
    cekLogin();
    if (!in_array($_SESSION['role'], $allowedRoles)) {
        header('Location: ' . BASE_URL . 'index.php?error=akses_ditolak');
        exit;
    }
}
?>