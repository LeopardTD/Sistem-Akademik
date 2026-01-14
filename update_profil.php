<?php
require_once 'koneksi.php';

// Cek apakah user sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Cek apakah request dari form
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: profil.php");
    exit();
}

$username = $_SESSION['username'];

// Ambil data dari form
$nama = trim($_POST['nama']);
$password_lama = isset($_POST['password_lama']) ? $_POST['password_lama'] : '';
$password_baru = isset($_POST['password_baru']) ? $_POST['password_baru'] : '';
$konfirmasi_password = isset($_POST['konfirmasi_password']) ? $_POST['konfirmasi_password'] : '';

// Validasi Nama
if (empty($nama) || strlen($nama) < 3) {
    $_SESSION['error'] = "Nama harus diisi minimal 3 karakter";
    header("Location: profil.php");
    exit();
}

// Validasi karakter nama (hanya huruf dan spasi)
if (!preg_match("/^[a-zA-Z\s]+$/", $nama)) {
    $_SESSION['error'] = "Nama hanya boleh mengandung huruf dan spasi";
    header("Location: profil.php");
    exit();
}

// Ambil data user dari database
$query = "SELECT * FROM users WHERE username = ?";
$stmt = mysqli_prepare($koneksi, $query);
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

if (!$user) {
    $_SESSION['error'] = "User tidak ditemukan";
    header("Location: profil.php");
    exit();
}

// Flag untuk cek apakah ada perubahan
$ada_perubahan = false;

// Cek apakah user ingin mengubah password
$ubah_password = !empty($password_lama) || !empty($password_baru) || !empty($konfirmasi_password);

if ($ubah_password) {
    // Validasi password lama harus diisi
    if (empty($password_lama)) {
        $_SESSION['error'] = "Password lama harus diisi jika ingin mengubah password";
        header("Location: profil.php");
        exit();
    }

    // Validasi password baru harus diisi
    if (empty($password_baru)) {
        $_SESSION['error'] = "Password baru harus diisi";
        header("Location: profil.php");
        exit();
    }

    // Validasi panjang password baru
    if (strlen($password_baru) < 6) {
        $_SESSION['error'] = "Password baru minimal 6 karakter";
        header("Location: profil.php");
        exit();
    }

    // Validasi konfirmasi password
    if ($password_baru !== $konfirmasi_password) {
        $_SESSION['error'] = "Konfirmasi password tidak cocok dengan password baru";
        header("Location: profil.php");
        exit();
    }

    // Verifikasi password lama
    if (!password_verify($password_lama, $user['password'])) {
        $_SESSION['error'] = "Password lama tidak sesuai";
        header("Location: profil.php");
        exit();
    }

    // Hash password baru
    $password_hash = password_hash($password_baru, PASSWORD_DEFAULT);
    
    // Update nama dan password
    $update_query = "UPDATE users SET nama = ?, password = ?, updated_at = CURRENT_TIMESTAMP WHERE username = ?";
    $update_stmt = mysqli_prepare($koneksi, $update_query);
    mysqli_stmt_bind_param($update_stmt, "sss", $nama, $password_hash, $username);
    
    if (mysqli_stmt_execute($update_stmt)) {
        $_SESSION['success'] = "Profil dan password berhasil diperbarui";
        $ada_perubahan = true;
    } else {
        $_SESSION['error'] = "Gagal memperbarui profil: " . mysqli_error($koneksi);
    }
    
} else {
    // Hanya update nama jika nama berubah
    if ($nama !== $user['nama']) {
        $update_query = "UPDATE users SET nama = ?, updated_at = CURRENT_TIMESTAMP WHERE username = ?";
        $update_stmt = mysqli_prepare($koneksi, $update_query);
        mysqli_stmt_bind_param($update_stmt, "ss", $nama, $username);
        
        if (mysqli_stmt_execute($update_stmt)) {
            $_SESSION['success'] = "Profil berhasil diperbarui";
            $ada_perubahan = true;
        } else {
            $_SESSION['error'] = "Gagal memperbarui profil: " . mysqli_error($koneksi);
        }
    } else {
        $_SESSION['error'] = "Tidak ada perubahan yang dilakukan";
    }
}

// Redirect kembali ke halaman profil
header("Location: profil.php");
exit();
?>