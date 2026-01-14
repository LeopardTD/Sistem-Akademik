<?php
require_once 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: register.php");
    exit();
}

$nama = trim($_POST['nama']);
$email = trim(strtolower($_POST['email']));
$username = trim(strtolower($_POST['username']));
$password = $_POST['password'];
$konfirmasi_password = $_POST['konfirmasi_password'];

$errors = [];

// ============================================
// VALIDASI INPUT
// ============================================

if (empty($nama)) {
    $errors[] = "Nama lengkap harus diisi";
} elseif (strlen($nama) < 3) {
    $errors[] = "Nama minimal 3 karakter";
} elseif (!preg_match("/^[a-zA-Z\s]+$/", $nama)) {
    $errors[] = "Nama hanya boleh mengandung huruf dan spasi";
}

if (empty($email)) {
    $errors[] = "Email harus diisi";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Format email tidak valid";
}

if (empty($username)) {
    $errors[] = "Username harus diisi";
} elseif (strlen($username) < 4) {
    $errors[] = "Username minimal 4 karakter";
} elseif (!preg_match("/^[a-zA-Z0-9_]+$/", $username)) {
    $errors[] = "Username hanya boleh mengandung huruf, angka, dan underscore";
}

if (empty($password)) {
    $errors[] = "Password harus diisi";
} elseif (strlen($password) < 6) {
    $errors[] = "Password minimal 6 karakter";
}

if ($password !== $konfirmasi_password) {
    $errors[] = "Konfirmasi password tidak cocok dengan password";
}

if (!empty($errors)) {
    $_SESSION['error'] = implode("<br>", $errors);
    header("Location: register.php");
    exit();
}

// ============================================
// CEK DUPLIKASI EMAIL DAN USERNAME
// ============================================

$check_email_query = "SELECT id FROM users WHERE email = ?";
$stmt_email = mysqli_prepare($koneksi, $check_email_query);
mysqli_stmt_bind_param($stmt_email, "s", $email);
mysqli_stmt_execute($stmt_email);
$result_email = mysqli_stmt_get_result($stmt_email);

if (mysqli_num_rows($result_email) > 0) {
    $_SESSION['error'] = "Email sudah terdaftar. Gunakan email lain atau <a href='login.php'>login</a>";
    header("Location: register.php");
    exit();
}

$check_username_query = "SELECT id FROM users WHERE username = ?";
$stmt_username = mysqli_prepare($koneksi, $check_username_query);
mysqli_stmt_bind_param($stmt_username, "s", $username);
mysqli_stmt_execute($stmt_username);
$result_username = mysqli_stmt_get_result($stmt_username);

if (mysqli_num_rows($result_username) > 0) {
    $_SESSION['error'] = "Username sudah digunakan. Pilih username lain";
    header("Location: register.php");
    exit();
}

// ============================================
// PROSES REGISTRASI
// ============================================

$password_hash = password_hash($password, PASSWORD_DEFAULT);

$insert_query = "INSERT INTO users (nama, email, username, password, created_at, updated_at) 
                 VALUES (?, ?, ?, ?, NOW(), NOW())";

$stmt_insert = mysqli_prepare($koneksi, $insert_query);

if ($stmt_insert) {
    mysqli_stmt_bind_param($stmt_insert, "ssss", $nama, $email, $username, $password_hash);
    
    if (mysqli_stmt_execute($stmt_insert)) {
        $_SESSION['success'] = "Registrasi berhasil! Silakan login dengan akun Anda.";
        
        header("Location: login.php");
        exit();
        
    } else {
        $_SESSION['error'] = "Terjadi kesalahan saat registrasi. Silakan coba lagi.";
        error_log("Register Error: " . mysqli_error($koneksi));
        header("Location: register.php");
        exit();
    }
    
    mysqli_stmt_close($stmt_insert);
    
} else {
    $_SESSION['error'] = "Terjadi kesalahan sistem. Silakan coba lagi.";
    error_log("Prepare Statement Error: " . mysqli_error($koneksi));
    header("Location: register.php");
    exit();
}

mysqli_close($koneksi);
?>