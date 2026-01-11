<?php
include("koneksi.php");
cek_login();

$success = false;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    if (!empty($_POST['id']) && !empty($_POST['nama_prodi']) && !empty($_POST['jenjang'])) {
        
        $id = (int)$_POST['id'];
        $nama_prodi = sanitize($db, $_POST['nama_prodi']);
        $jenjang = sanitize($db, $_POST['jenjang']);
        $akreditasi = !empty($_POST['akreditasi']) ? sanitize($db, $_POST['akreditasi']) : NULL;
        $keterangan = !empty($_POST['keterangan']) ? sanitize($db, $_POST['keterangan']) : NULL;

        // Build update query
        if ($akreditasi !== NULL && $keterangan !== NULL) {
            $sql = "UPDATE program_studi SET 
                    nama_prodi = '$nama_prodi',
                    jenjang = '$jenjang',
                    akreditasi = '$akreditasi',
                    keterangan = '$keterangan'
                    WHERE id = $id";
        } elseif ($akreditasi !== NULL) {
            $sql = "UPDATE program_studi SET 
                    nama_prodi = '$nama_prodi',
                    jenjang = '$jenjang',
                    akreditasi = '$akreditasi',
                    keterangan = NULL
                    WHERE id = $id";
        } elseif ($keterangan !== NULL) {
            $sql = "UPDATE program_studi SET 
                    nama_prodi = '$nama_prodi',
                    jenjang = '$jenjang',
                    akreditasi = NULL,
                    keterangan = '$keterangan'
                    WHERE id = $id";
        } else {
            $sql = "UPDATE program_studi SET 
                    nama_prodi = '$nama_prodi',
                    jenjang = '$jenjang',
                    akreditasi = NULL,
                    keterangan = NULL
                    WHERE id = $id";
        }

        if (mysqli_query($db, $sql)) {
            if (mysqli_affected_rows($db) >= 0) {
                $success = true;
            } else {
                $error = 'Tidak ada perubahan data atau data tidak ditemukan.';
            }
        } else {
            $error = 'Gagal mengupdate data: ' . mysqli_error($db);
        }
    } else {
        $error = 'Semua field wajib diisi!';
    }
} else {
    $error = 'Metode request tidak valid!';
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Hasil Update - Program Studi</title>
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
                        <h3 class="text-center fw-bold mb-3">Data Berhasil Diperbarui!</h3>
                        <div class="alert alert-success" role="alert">
                            <i class="bi bi-info-circle me-2"></i>
                            Program studi <strong><?php echo htmlspecialchars($nama_prodi); ?></strong> 
                            telah berhasil diperbarui.
                        </div>
                        <div class="d-flex justify-content-center gap-3 mt-4">
                            <a href="index.php?p=listprodi" class="btn btn-primary btn-lg">
                                <i class="bi bi-list-ul me-2"></i>Lihat Daftar Program Studi
                            </a>
                            <a href="index.php?p=editprodi&id=<?php echo $id; ?>" class="btn btn-warning btn-lg">
                                <i class="bi bi-pencil-square me-2"></i>Edit Lagi
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="text-center mb-4">
                            <i class="bi bi-x-circle-fill text-danger" style="font-size: 5rem;"></i>
                        </div>
                        <h3 class="text-center fw-bold mb-3">Gagal Memperbarui Data</h3>
                        <div class="alert alert-danger" role="alert">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            <?php echo htmlspecialchars($error); ?>
                        </div>
                        <div class="d-flex justify-content-center gap-3 mt-4">
                            <a href="javascript:history.back()" class="btn btn-warning btn-lg">
                                <i class="bi bi-arrow-left me-2"></i>Kembali
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