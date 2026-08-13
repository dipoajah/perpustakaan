<?php
require_once __DIR__ . '/../config/koneksi.php';
require_once __DIR__ . '/../includes/cek_login.php';
cekRole(['admin']);

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: index.php');
    exit;
}

$stmt = $koneksi->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$id]);
$user = $stmt->fetch();
if (!$user) {
    header('Location: index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $role     = $_POST['role'] ?? 'operator';

    if ($username === '') {
        $error = 'Username wajib diisi.';
    } else {
        $cek = $koneksi->prepare("SELECT COUNT(*) AS jml FROM users WHERE username = ? AND id != ?");
        $cek->execute([$username, $id]);
        if ($cek->fetch()['jml'] > 0) {
            $error = 'Username sudah digunakan oleh user lain.';
        } else {
            if ($password !== '') {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $koneksi->prepare("UPDATE users SET username = ?, password = ?, role = ? WHERE id = ?");
                $stmt->execute([$username, $hash, $role, $id]);
            } else {
                $stmt = $koneksi->prepare("UPDATE users SET username = ?, role = ? WHERE id = ?");
                $stmt->execute([$username, $role, $id]);
            }
            header('Location: index.php?sukses=' . urlencode('User berhasil diperbarui'));
            exit;
        }
    }
}

$judul_halaman = 'Edit User';
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/navbar.php';
?>
<div class="container">
    <h3 class="mb-4">Edit User</h3>
    <?php if ($error): ?><div class="alert alert-danger"><?= htmlspecialchars($error) ?></div><?php endif; ?>
    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($_POST['username'] ?? $user['username']) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password <small class="text-muted">(kosongkan jika tidak ingin mengubah)</small></label>
                    <input type="password" name="password" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Role</label>
                    <select name="role" class="form-select">
                        <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                        <option value="operator" <?= $user['role'] === 'operator' ? 'selected' : '' ?>>Operator</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="index.php" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
