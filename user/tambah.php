<?php
require_once __DIR__ . '/../config/koneksi.php';
require_once __DIR__ . '/../includes/cek_login.php';
cekRole(['admin']);

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $role     = $_POST['role'] ?? 'operator';

    if ($username === '' || $password === '') {
        $error = 'Username dan password wajib diisi.';
    } else {
        $cek = $koneksi->prepare("SELECT COUNT(*) AS jml FROM users WHERE username = ?");
        $cek->execute([$username]);
        if ($cek->fetch()['jml'] > 0) {
            $error = 'Username sudah digunakan.';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $koneksi->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
            $stmt->execute([$username, $hash, $role]);
            header('Location: index.php?sukses=' . urlencode('User berhasil ditambahkan'));
            exit;
        }
    }
}

$judul_halaman = 'Tambah User';
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/navbar.php';
?>
<div class="container">
    <h3 class="mb-4">Tambah User</h3>
    <?php if ($error): ?><div class="alert alert-danger"><?= htmlspecialchars($error) ?></div><?php endif; ?>
    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Role</label>
                    <select name="role" class="form-select">
                        <option value="admin">Admin</option>
                        <option value="operator" selected>Operator</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="index.php" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
