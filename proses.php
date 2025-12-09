<?php
include("koneksi.php");

$success = false;
$error = '';

if (!empty($_POST['nim']) && !empty($_POST['nama_mhs']) && !empty($_POST['tgl_lahir']) && !empty($_POST['alamat'])) 
{
    $nim = mysqli_real_escape_string($db, trim($_POST['nim']));
    $nama_mhs = mysqli_real_escape_string($db, trim($_POST['nama_mhs']));
    $tgl_lahir = mysqli_real_escape_string($db, trim($_POST['tgl_lahir']));
    $alamat = mysqli_real_escape_string($db, trim($_POST['alamat']));

    // Cek apakah NIM sudah ada
    $cek = mysqli_query($db, "SELECT nim FROM mahasiswa WHERE nim='$nim'");
    if (mysqli_num_rows($cek) > 0) {
        $error = 'NIM sudah terdaftar!';
    } else {
        $sql = "INSERT INTO mahasiswa (nim, nama_mhs, tgl_lahir, alamat) 
            VALUES ('$nim', '$nama_mhs', '$tgl_lahir', '$alamat')";

        if (mysqli_query($db, $sql)) {
            $success = true;
        } else {
            $error = mysqli_error($db);
        }
    }
} else {
    $error = 'Data tidak lengkap.';
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Hasil Pengiriman - Data Mahasiswa</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h4 class="card-title mb-4 text-center">Hasil Pengiriman</h4>

                    <?php if ($success): ?>
                        <div class="alert alert-success" role="alert">
                            <h5 class="alert-heading">Berhasil!</h5>
                            <p>Data mahasiswa telah tersimpan.</p>
                        </div>
                        <div class="d-flex justify-content-center gap-2">
                            <a href="index.php?p=list" class="btn btn-primary">Lihat Daftar Mahasiswa</a>
                            <a href="create.php" class="btn btn-outline-secondary">Tambah Data Lagi</a>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-danger" role="alert">
                            <h5 class="alert-heading">Gagal menyimpan data</h5>
                            <p><?php echo htmlspecialchars($error); ?></p>
                        </div>
                        <div class="d-flex justify-content-center gap-2">
                            <a href="create.php" class="btn btn-warning">Kembali ke Form</a>
                            <a href="index.php?p=list" class="btn btn-outline-secondary">Lihat Daftar</a>
                        </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>