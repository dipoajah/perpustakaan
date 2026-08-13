<?php
require_once __DIR__ . '/../config/koneksi.php';
require_once __DIR__ . '/../includes/cek_login.php';
cekLogin();

$id = $_GET['id'] ?? null;

if ($id) {
    // Cek apakah kategori masih dipakai oleh buku
    $cek = $koneksi->prepare("SELECT COUNT(*) AS jml FROM buku WHERE kategori_id = ?");
    $cek->execute([$id]);
    $jml = $cek->fetch()['jml'];

    if ($jml > 0) {
        header('Location: index.php?sukses=' . urlencode('Kategori tidak bisa dihapus karena masih digunakan oleh buku'));
        exit;
    }

    $stmt = $koneksi->prepare("DELETE FROM kategori WHERE id = ?");
    $stmt->execute([$id]);
}

header('Location: index.php?sukses=' . urlencode('Kategori berhasil dihapus'));
exit;
