<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$server = "localhost";
$user = "root";
$password = "";
$nama_database = "db_akademik";

$koneksi = mysqli_connect($server, $user, $password, $nama_database);

$db = $koneksi;

if (!$koneksi) {
    die("Gagal terhubung dengan database: " . mysqli_connect_error());
}

// Fungsi untuk cek login
function cek_login() {
    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
        header("Location: login.php");
        exit;
    }
}

// Fungsi untuk sanitasi input
function sanitize($db, $data) {
    return mysqli_real_escape_string($db, trim($data));
}
?>