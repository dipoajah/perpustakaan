<?php
require_once __DIR__ . '/../config/koneksi.php';
require_once __DIR__ . '/../includes/cek_login.php';
cekRole(['admin']);

$id = $_GET['id'] ?? null;

if ($id && $id != $_SESSION['user_id']) {
    $stmt = $koneksi->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$id]);
    header('Location: index.php?sukses=' . urlencode('User berhasil dihapus'));
    exit;
}

header('Location: index.php?error=' . urlencode('Tidak bisa menghapus akun sendiri'));
exit;
