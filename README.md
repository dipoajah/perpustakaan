# Sistem Perpustakaan — Tim 1

Modul yang dikerjakan Tim 1:
1. **Login** (admin & operator, role-based)
2. **Manajemen Buku** (id, kode, nama buku, kategori, penulis) + Manajemen Kategori (id, nama, status)
3. **Manajemen User** (username, password, role) — khusus admin

Dibangun dengan **PHP Native (PDO + MySQLi-style query pakai PDO)** dan **Bootstrap 5** (via CDN, tanpa perlu npm/composer).

## Struktur Folder

```
perpustakaan/
├── config/
│   └── koneksi.php        # koneksi database & BASE_URL
├── includes/
│   ├── cek_login.php      # fungsi cekLogin() & cekRole()
│   ├── header.php
│   ├── navbar.php
│   └── footer.php
├── auth/
│   ├── login.php
│   ├── proses_login.php
│   └── logout.php
├── buku/                  # CRUD buku
├── kategori/               # CRUD kategori
├── user/                   # CRUD user (khusus admin)
├── index.php               # dashboard
└── database.sql            # skema + data awal
```

## Cara Instalasi (XAMPP/Laragon)

1. Copy folder `perpustakaan` ke `htdocs` (XAMPP) atau `www` (Laragon).
2. Buka phpMyAdmin, import file `database.sql` (otomatis membuat database `db_perpustakaan` beserta data awal).
3. Cek `config/koneksi.php` — sesuaikan `$dbuser`/`$dbpass` jika MySQL kamu pakai password, dan sesuaikan `BASE_URL` jika nama foldernya beda dari `perpustakaan`.
4. Akses lewat browser: `http://localhost/perpustakaan/auth/login.php`

## Akun Default

| Username | Password    | Role     |
|----------|-------------|----------|
| admin    | admin123    | admin    |
| operator | operator123 | operator |

> Password sudah di-hash dengan bcrypt (`password_hash`), **jangan** simpan password polos di database.

## Hak Akses (Role)

- **Admin**: akses penuh — dashboard, buku, kategori, dan manajemen user.
- **Operator**: akses dashboard, buku, dan kategori — **tidak bisa** akses menu Data User (kalau nekat akses URL-nya langsung, akan otomatis di-redirect ke dashboard dengan pesan akses ditolak).

Kalau ternyata pembagian aksesnya harus beda (misal operator cuma boleh lihat data buku tanpa edit/hapus), tinggal kabarin — logikanya ada di `cekRole()` (`includes/cek_login.php`) dan gampang disesuaikan.

## Catatan Teknis

- Password di-hash pakai `password_hash()` / diverifikasi dengan `password_verify()`.
- Semua query pakai **prepared statement (PDO)** supaya aman dari SQL Injection.
- Semua output ke HTML di-`htmlspecialchars()` untuk mencegah XSS.
- Kode buku & username divalidasi unik sebelum insert/update.
- Kategori tidak bisa dihapus kalau masih dipakai oleh data buku (mencegah data buku jadi yatim/orphan).
