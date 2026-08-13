<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
  <div class="container-fluid">
    <a class="navbar-brand" href="<?= BASE_URL ?>index.php">
        <i class="bi bi-book-half"></i> Perpustakaan
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarMain">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link" href="<?= BASE_URL ?>index.php">Dashboard</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= BASE_URL ?>buku/index.php">Data Buku</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= BASE_URL ?>kategori/index.php">Kategori</a>
        </li>
        <?php if (($_SESSION['role'] ?? '') === 'admin'): ?>
        <li class="nav-item">
          <a class="nav-link" href="<?= BASE_URL ?>user/index.php">Data User</a>
        </li>
        <?php endif; ?>
      </ul>
      <ul class="navbar-nav">
        <li class="nav-item d-flex align-items-center text-light me-3">
            <i class="bi bi-person-circle me-1"></i>
            <?= htmlspecialchars($_SESSION['username'] ?? '') ?>
            <span class="badge bg-secondary ms-2"><?= htmlspecialchars($_SESSION['role'] ?? '') ?></span>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= BASE_URL ?>auth/logout.php">
            <i class="bi bi-box-arrow-right"></i> Logout
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>
