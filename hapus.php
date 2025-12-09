<?php
include("koneksi.php");

$nim = isset($_GET['nim']) ? mysqli_real_escape_string($db, $_GET['nim']) : '';

if (!empty($nim)) {
    $stmt = mysqli_prepare($db, "DELETE FROM mahasiswa WHERE nim = ?");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $nim);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
}

header("Location: index.php?p=list");
exit;
?>