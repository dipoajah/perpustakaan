<?php
define('BASE_URL', '/perpustakaan/');

$host = 'localhost';
$dbname = 'db_perpustakaan';
$dbuser = 'root';
$dbpass = '';

try {
	$koneksi = new PDO(
		"mysql:host={$host};dbname={$dbname};charset=utf8mb4",
		$dbuser,
		$dbpass
	);
	$koneksi->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$koneksi->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
	die("Koneksi database gagal: " .$e->getMessage());
}