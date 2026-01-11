<?php
include("koneksi.php");
cek_login();

$nim = isset($_GET['nim']) ? sanitize($db, $_GET['nim']) : '';

if (!empty($nim)) {
    // Menggunakan prepared statement untuk keamanan
    $stmt = mysqli_prepare($db, "DELETE FROM mahasiswa WHERE nim = ?");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $nim);
        
        if (mysqli_stmt_execute($stmt)) {
            if (mysqli_stmt_affected_rows($stmt) > 0) {
                $_SESSION['delete_success'] = "Data mahasiswa dengan NIM $nim berhasil dihapus.";
            } else {
                $_SESSION['delete_error'] = "Data dengan NIM $nim tidak ditemukan.";
            }
        } else {
            $_SESSION['delete_error'] = "Gagal menghapus data.";
        }
        
        mysqli_stmt_close($stmt);
    } else {
        $_SESSION['delete_error'] = "Terjadi kesalahan sistem.";
    }
} else {
    $_SESSION['delete_error'] = "NIM tidak valid.";
}

header("Location: index.php?p=list");
exit;
?>