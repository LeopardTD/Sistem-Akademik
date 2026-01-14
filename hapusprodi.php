<?php
include("koneksi.php");
cek_login();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    // Cek apakah ada mahasiswa yang terkait dengan program studi ini
    $cek_mahasiswa = mysqli_query($db, "SELECT COUNT(*) as total FROM mahasiswa WHERE program_studi_id = $id");
    $result = mysqli_fetch_assoc($cek_mahasiswa);
    
    if ($result['total'] > 0) {
        $_SESSION['prodi_error'] = "Tidak dapat menghapus program studi karena masih ada {$result['total']} mahasiswa yang terdaftar di program studi ini. Hapus atau pindahkan mahasiswa terlebih dahulu.";
    } else {
        $stmt = mysqli_prepare($db, "DELETE FROM program_studi WHERE id = ?");
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "i", $id);
            
            if (mysqli_stmt_execute($stmt)) {
                if (mysqli_stmt_affected_rows($stmt) > 0) {
                    $_SESSION['prodi_success'] = "Program studi berhasil dihapus dari sistem.";
                } else {
                    $_SESSION['prodi_error'] = "Data dengan ID $id tidak ditemukan.";
                }
            } else {
                $_SESSION['prodi_error'] = "Gagal menghapus data.";
            }
            
            mysqli_stmt_close($stmt);
        } else {
            $_SESSION['prodi_error'] = "Terjadi kesalahan sistem.";
        }
    }
} else {
    $_SESSION['prodi_error'] = "ID tidak valid.";
}

header("Location: index.php?p=listprodi");
exit;
?>