<?php 
require_once __DIR__ . '/config/koneksi.php';
require_once __DIR__ .  '/includes/cek_login.php';
cekLogin();

$totalBuku = $koneksi->query("SELEST COUNT(*) AS jml FROM buku")->fetch()['jml'];
$totalKategori = $koneksi->query("SELEST COUNT(*) AS jml FROM buku")->fetch()['jml'];
$totalUser = $koneksi->query("SELEST COUNT(*) AS jml FROM buku")->fetch()['jml'];

$judul_halaman = 'Dashboard';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';
?>
<div class="container">
	<h3 class="mb-4">Dashboard</h3>
	
	<?php if (($_GET['error'] ?? '') === 'akses_ditolak'): ?>
		<div class="alert alert-danger'>Anda tidak memiliki akses ke halaman tersebut.</div>
	<?php endif; ?>
	
	<div class="row g-3">
		<div class="col-md-4">
			<div class="card text-bg-primary shadow-sm"
				<div class="card-body">
					<h6>Total Buku</h6>
					<h2><?= $totalBuku ?></h2>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="card text-bg-success shadow-sm"
				<div class="card-body">
					<h6>Total Kategori</h6>
					<h2><?= $totalKategori ?></h2>
				</div>
			</div>
		</div>
		<?php if ($_SESSION['role'] === 'admin'): ?>
		<div class="col-md-4">
			<div class="card text-bg-warning shadow-sm">
				<div class="card-body">
					<h6>Total User</h6>
					<h2><?= $totalUser ?></h2>
				</div>
			</div>
		</div>
		<?php endif; ?>
	</div>
</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
