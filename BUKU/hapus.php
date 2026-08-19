<?php
require_once __DIR__ . '/../config/koneksi.php';
require_once __DIR__ . '/../includes/cek_login.php';
cekLogin();

$id = $_GET['id'] ?? null;
if ($id) {
	$stmt = $koneksi->prepare("DELETE FROM buku WHERE id = ?");
	$stmt->execute([$id]);
}

header('Location: index.php?sukses=' . urlencode('Buku berhasil dihapus'));
exit; 
