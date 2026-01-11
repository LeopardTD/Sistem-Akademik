<?php
include("koneksi.php");
cek_login();

$success = false;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['nama_prodi']) && !empty($_POST['jenjang'])) {
        
        $nama_prodi = sanitize($db, $_POST['nama_prodi']);
        $jenjang = sanitize($db, $_POST['jenjang']);
        $akreditasi = !empty($_POST['akreditasi']) ? sanitize($db, $_POST['akreditasi']) : NULL;
        $keterangan = !empty($_POST['keterangan']) ? sanitize($db, $_POST['keterangan']) : NULL;

        // Cek apakah program studi sudah ada
        $cek = mysqli_query($db, "SELECT id FROM program_studi WHERE nama_prodi='$nama_prodi' AND jenjang='$jenjang'");
        if (mysqli_num_rows($cek) > 0) {
            $error = 'Program studi dengan nama dan jenjang yang sama sudah terdaftar!';
        } else {
            // Build query
            if ($akreditasi !== NULL && $keterangan !== NULL) {
                $sql = "INSERT INTO program_studi (nama_prodi, jenjang, akreditasi, keterangan)
                        VALUES ('$nama_prodi', '$jenjang', '$akreditasi', '$keterangan')";
            } elseif ($akreditasi !== NULL) {
                $sql = "INSERT INTO program_studi (nama_prodi, jenjang, akreditasi)
                        VALUES ('$nama_prodi', '$jenjang', '$akreditasi')";
            } elseif ($keterangan !== NULL) {
                $sql = "INSERT INTO program_studi (nama_prodi, jenjang, keterangan)
                        VALUES ('$nama_prodi', '$jenjang', '$keterangan')";
            } else {
                $sql = "INSERT INTO program_studi (nama_prodi, jenjang)
                        VALUES ('$nama_prodi', '$jenjang')";
            }

            if (mysqli_query($db, $sql)) {
                $success = true;
            } else {
                $error = 'Gagal menyimpan data: ' . mysqli_error($db);
            }
        }
    } else {
        $error = 'Nama Program Studi dan Jenjang wajib diisi!';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Hasil Pengiriman - Program Studi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body class="bg-light">
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0">
                <div class="card-body p-5">
                    <?php if ($success): ?>
                        <div class="text-center mb-4">
                            <i class="bi bi-check-circle-fill text-success" style="font-size: 5rem;"></i>
                        </div>
                        <h3 class="text-center fw-bold mb-3">Data Berhasil Disimpan!</h3>
                        <div class="alert alert-success" role="alert">
                            <i class="bi bi-info-circle me-2"></i>
                            Program studi <strong><?php echo htmlspecialchars($nama_prodi); ?> (<?php echo htmlspecialchars($jenjang); ?>)</strong> 
                            telah berhasil ditambahkan ke sistem.
                        </div>
                        <div class="d-flex justify-content-center gap-3 mt-4">
                            <a href="index.php?p=listprodi" class="btn btn-primary btn-lg">
                                <i class="bi bi-list-ul me-2"></i>Lihat Daftar Program Studi
                            </a>
                            <a href="index.php?p=createprodi" class="btn btn-success btn-lg">
                                <i class="bi bi-plus-circle me-2"></i>Tambah Data Lagi
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="text-center mb-4">
                            <i class="bi bi-x-circle-fill text-danger" style="font-size: 5rem;"></i>
                        </div>
                        <h3 class="text-center fw-bold mb-3">Gagal Menyimpan Data</h3>
                        <div class="alert alert-danger" role="alert">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            <?php echo htmlspecialchars($error); ?>
                        </div>
                        <div class="d-flex justify-content-center gap-3 mt-4">
                            <a href="index.php?p=createprodi" class="btn btn-warning btn-lg">
                                <i class="bi bi-arrow-left me-2"></i>Kembali ke Form
                            </a>
                            <a href="index.php?p=listprodi" class="btn btn-secondary btn-lg">
                                <i class="bi bi-list-ul me-2"></i>Lihat Daftar
                            </a>
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