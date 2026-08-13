<?php
require_once __DIR__ . '/../config/koneksi.php';
require_once __DIR__ . '/../includes/cek_login.php';
cekLogin();

$data = $koneksi->query("
    SELECT buku.*, kategori.nama AS nama_kategori
    FROM buku
    LEFT JOIN kategori ON buku.kategori_id = kategori.id
    ORDER BY buku.id DESC
")->fetchAll();

$judul_halaman = 'Data Buku';
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/navbar.php';
?>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Data Buku</h3>
        <a href="tambah.php" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Tambah Buku</a>
    </div>

    <?php if (isset($_GET['sukses'])): ?>
        <div class="alert alert-success"><?= htmlspecialchars($_GET['sukses']) ?></div>
    <?php endif; ?>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Kode</th>
                        <th>Nama Buku</th>
                        <th>Kategori</th>
                        <th>Penulis</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($data)): ?>
                        <tr><td colspan="6" class="text-center text-muted">Belum ada data buku</td></tr>
                    <?php endif; ?>
                    <?php foreach ($data as $i => $row): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><?= htmlspecialchars($row['kode']) ?></td>
                        <td><?= htmlspecialchars($row['nama_buku']) ?></td>
                        <td><?= htmlspecialchars($row['nama_kategori'] ?? '-') ?></td>
                        <td><?= htmlspecialchars($row['penulis']) ?></td>
                        <td class="text-end">
                            <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                            <a href="hapus.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus buku ini?')"><i class="bi bi-trash"></i></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
 