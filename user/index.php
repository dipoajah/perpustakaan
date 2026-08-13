<?php
require_once __DIR__ . '/../config/koneksi.php';
require_once __DIR__ . '/../includes/cek_login.php';
cekRole(['admin']);

$data = $koneksi->query("SELECT * FROM users ORDER BY id DESC")->fetchAll();

$judul_halaman = 'Data User';
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/navbar.php';
?>
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Data User</h3>
        <a href="tambah.php" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Tambah User</a>
    </div>

    <?php if (isset($_GET['sukses'])): ?>
        <div class="alert alert-success"><?= htmlspecialchars($_GET['sukses']) ?></div>
    <?php endif; ?>
    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($_GET['error']) ?></div>
    <?php endif; ?>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Username</th>
                        <th>Role</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($data)): ?>
                        <tr><td colspan="4" class="text-center text-muted">Belum ada data user</td></tr>
                    <?php endif; ?>
                    <?php foreach ($data as $i => $row): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><?= htmlspecialchars($row['username']) ?></td>
                        <td>
                            <span class="badge <?= $row['role'] === 'admin' ? 'bg-danger' : 'bg-info text-dark' ?>">
                                <?= htmlspecialchars($row['role']) ?>
                            </span>
                        </td>
                        <td class="text-end">
                            <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                            <?php if ($row['id'] != $_SESSION['user_id']): ?>
                            <a href="hapus.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus user ini?')"><i class="bi bi-trash"></i></a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
