<?php
require_once __DIR__ . '/../config/koneksi.php';
require_once __DIR__ . '/../includes/cek_login.php';
cekLogin();

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: index.php');
    exit;
}

$stmt = $koneksi->prepare("SELECT * FROM buku WHERE id = ?");
$stmt->execute([$id]);
$buku = $stmt->fetch();
if (!$buku) {
    header('Location: index.php');
    exit;
}
$
$kategoriList = $koneksi->query("SELECT * FROM kategori ORDER BY nama")->fetchAll();
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kode = trim($_POST['kode'] ?? '');
    $nama_buku = trim($_POST['nama_buku'] ?? '');
    $kategori_id = $_POST['kategori_id'] ?? '';
    $penulis = trim($_POST['penulis'] ?? '');

    if ($kode == '' || $nama_buku === '' || $kategori_id === '' || $penulis == '') {
        $error = 'Semua field wajib diisi.';
    } else {
        $cek = $koneksi->prepare("SELECT COUNT(*) AS jml FROM buku WHERE kode = ? AND id != ?");
        $cek->execute([$kode, $id]);
        if ($cek->fetch()['jml'] > 0) {
            $error = 'kode buku sudah digunakan oleh buku lain.';
        } else {
            $stmt = $koneksi->prepare("UPDATE buku SET kode  = ?, nama_buku =?, kategori_id = ?, penulis = ? WHERE id = ?");
            $stmt->execute([$kode, $nama_buku, $kategori_id, $penulis, $id]);
            header('Location: index.php?sukses=' . urlencode('Buku berhasil diperbarui'));
            exit;
        }
    }
}

$judul_halaman = 'Edit Buku';
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/navbar.php';
?>
<div class="container">
    <h3 class="mb-4">Edit Buku</h3>
    <?php if ($error): ?><div class=" alert alert-danger"><?=htmlspecialchars($error) ?></div><?php endif; ?>
    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Kode Buku</label>
                    <input type="text" name="kode" class="form-control" value="<?= htmlspecialchars($_POST['kode'] ?? $buku['kode']) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nama Buku</label>
                    <input type="text" name="nama_buku" class="form-control" value="<?= htmlspecialchars($_POST['nama_buku'] ?? $buku['nama_buku']) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Kategori</label>
                    <select name="kategori_id" class="form-select" required>
                        <option value="">-- Pilih Kategori --</option>
                        <?php foreach ($kategoriList as $kat): ?>
                            <option value="<?= $kat['id'] ?>" <?= $kat['id'] == $buku['kategori_id'] ? 'selected' : '' ?>><?= htmlspecialchars($kat['nama']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
				<div class="mb-3">
					<label class="form-label">Penulis</label>
					<input type="text" name="penulis" class="form-control" value="<?= htmlspecialchars($_POST['penulis'] ?? $buku['penulis']) ?>" required>
				</div>
				<button type="submit" class="btn btn-primary">Update</button>
				<a href="index.php" class="btn btn-secondary">Batal</a>
			</form>
		</div>
	</div>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
				