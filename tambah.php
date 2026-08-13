<?php
require_once __DIR__ . '/../config/koneksi.php';
require_once __DIR__ . '/../includes/cek_login.php';
cekLogin();

$kategoriList = $koneksi->query("SELECT * FROM kategori WHERE status = 'aktif' ORDER BY nama")->fetchAll();
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kode        = trim($_POST['kode'] ?? '');
    $nama_buku   = trim($_POST['nama_buku'] ?? '');
    $kategori_id = $_POST['kategori_id'] ?? '';
    $penulis     = trim($_POST['penulis'] ?? '');

    if ($kode === '' || $nama_buku === '' || $kategori_id === '' || $penulis === '') {
        $error = 'Semua field wajib diisi.';
    } else {
        // cek duplikasi kode buku
        $cek = $koneksi->prepare("SELECT COUNT(*) AS jml FROM buku WHERE kode = ?");
        $cek->execute([$kode]);
        if ($cek->fetch()['jml'] > 0) {
            $error = 'Kode buku sudah digunakan.';
        } else {
            $stmt = $koneksi->prepare("INSERT INTO buku (kode, nama_buku, kategori_id, penulis) VALUES (?, ?, ?, ?)");
            $stmt->execute([$kode, $nama_buku, $kategori_id, $penulis]);
            header('Location: index.php?sukses=' . urlencode('Buku berhasil ditambahkan'));
            exit;
        }
    }
}

$judul_halaman = 'Tambah Buku';
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/navbar.php';
?>
<div class="container">
    <h3 class="mb-4">Tambah Buku</h3>
    <?php if ($error): ?><div class="alert alert-danger"><?= htmlspecialchars($error) ?></div><?php endif; ?>
    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Kode Buku</label>
                    <input type="text" name="kode" class="form-control" value="<?= htmlspecialchars($_POST['kode'] ?? '') ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nama Buku</label>
                    <input type="text" name="nama_buku" class="form-control" value="<?= htmlspecialchars($_POST['nama_buku'] ?? '') ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Kategori</label>
                    <select name="kategori_id" class="form-select" required>
                        <option value="">-- Pilih Kategori --</option>
                        <?php foreach ($kategoriList as $kat): ?>
                            <option value="<?= $kat['id'] ?>"><?= htmlspecialchars($kat['nama']) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (empty($kategoriList)): ?>
                        <div class="form-text text-danger">Belum ada kategori aktif. Tambahkan kategori terlebih dahulu.</div>
                    <?php endif; ?>
                </div>
                <div class="mb-3">
                    <label class="form-label">Penulis</label>
                    <input type="text" name="penulis" class="form-control" value="<?= htmlspecialchars($_POST['penulis'] ?? '') ?>" required>
                </div>
                <button type="submit" class="btn btn-primary" <?= empty($kategoriList) ? 'disabled' : '' ?>>Simpan</button>
                <a href="index.php" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
