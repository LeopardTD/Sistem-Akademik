<?php
session_start();
require_once 'koneksi.php';

// Cek apakah form sudah disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form dan sanitasi
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    
    // Validasi input tidak boleh kosong
    if (empty($username) || empty($password)) {
        $_SESSION['error'] = "Username dan password harus diisi";
        header("Location: login.php");
        exit();
    }
    
    // Query untuk cek username (gunakan prepared statement untuk keamanan)
    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = mysqli_prepare($koneksi, $query);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if ($result && mysqli_num_rows($result) == 1) {
            $user = mysqli_fetch_assoc($result);
            
            // Verifikasi password dengan password_verify untuk password yang di-hash
            if (password_verify($password, $user['password'])) {
                // Login berhasil
                $_SESSION['username'] = $user['username'];
                $_SESSION['nama'] = $user['nama'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['login_time'] = time();
                
                // Redirect ke halaman home
                header("Location: home.php");
                exit();
            } else {
                // Password salah
                $_SESSION['error'] = "Username atau password salah";
                header("Location: login.php");
                exit();
            }
        } else {
            // Username tidak ditemukan
            $_SESSION['error'] = "Username atau password salah";
            header("Location: login.php");
            exit();
        }
        
        mysqli_stmt_close($stmt);
    } else {
        $_SESSION['error'] = "Terjadi kesalahan sistem";
        header("Location: login.php");
        exit();
    }
} else {
    // Jika bukan POST request, redirect ke login
    header("Location: login.php");
    exit();
}
?>