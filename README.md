# Sistem Informasi Akademik

Sistem Informasi Akademik berbasis web menggunakan PHP dan MySQL untuk mengelola data mahasiswa dan program studi.

## 🚀 Fitur
- Login Admin
- Manajemen Data Mahasiswa (CRUD)
- Manajemen Data Program Studi (CRUD)
- Dashboard Statistik
- Responsive Design

## 🛠️ Teknologi yang Digunakan
- PHP 7.4+
- MySQL
- Bootstrap 5
- JavaScript

## 📋 Prasyarat
Sebelum menjalankan aplikasi, pastikan sudah terinstall:
- XAMPP (atau software serupa dengan PHP & MySQL)
- Web Browser (Chrome, Firefox, Edge, dll)
- Git (untuk clone repository)

## 📥 Cara Instalasi

### 1. Clone Repository
```bash
git clone https://github.com/LeopardTD/Sistem-Akademik.git
```

### 2. Pindahkan ke Folder htdocs
Pindahkan folder `Sistem-Akademik` ke:
```
C:\xampp\htdocs\
```
Atau rename folder menjadi `akademi`:
```
C:\xampp\htdocs\akademi\
```

### 3. Import Database
1. Buka phpMyAdmin: `http://localhost/phpmyadmin`
2. Buat database baru dengan nama: `db_akademik`
3. Import file `database.sql` yang ada di folder root project
   - Klik database `db_akademik`
   - Pilih tab "Import"
   - Pilih file `database.sql`
   - Klik "Go"

### 4. Konfigurasi Koneksi Database
Buka file `koneksi.php` dan sesuaikan jika perlu:
```php
<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "db_akademik";

$koneksi = mysqli_connect($host, $user, $pass, $db);
?>
```

### 5. Jalankan Aplikasi
1. Start Apache dan MySQL di XAMPP Control Panel
2. Buka browser dan akses: `http://localhost/akademi/`

## 🔐 Login Default
```
Username: admin
Password: admin
```

## 📁 Struktur Folder
```
akademi/
├── authenticate.php
├── create.php
├── createprodi.php
├── edit.php
├── editprodi.php
├── hapus.php
├── hapusprodi.php
├── home.php
├── index.php
├── koneksi.php
├── list.php
├── listprodi.php
├── login.php
├── logout.php
├── proses.php
├── prosesprodi.php
├── update.php
├── updateprodi.php
├── database.sql
└── README.md
```

## 👨‍💻 Pembuat
- Nama: Zikra Revanzha
- NIM: 2411082025
- Kelas: TRPL 2C

## 📝 Lisensi
Project ini dibuat untuk keperluan akademik.
```