<?php
include("koneksi.php");

$nim = isset($_GET['nim']) ? mysqli_real_escape_string($db, $_GET['nim']) : '';
$edit = mysqli_query($db, "SELECT * FROM mahasiswa WHERE nim='{$nim}'");
$data = mysqli_fetch_assoc($edit);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Edit Data Mahasiswa</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body d-flex flex-column" style="min-height: 500px;">
                    <h4 class="card-title mb-4 text-center">Edit Data Mahasiswa</h4>

                    <?php if (!$data): ?>
                        <div class="alert alert-warning">Data tidak ditemukan.</div>
                        <div class="text-center">
                            <a href="index.php?p=list" class="btn btn-secondary">Kembali ke Daftar</a>
                        </div>
                    <?php else: ?>
                        <form method="POST" action="update.php" class="flex-grow-1 d-flex flex-column">
                            <div class="mb-3 row">
                                <label for="nim" class="col-sm-2 col-form-label">NIM</label>
                                <div class="col-sm-10">
                                    <input type="text" id="nim" name="nim" class="form-control" 
                                           value="<?php echo htmlspecialchars($data['nim']); ?>" readonly>
                                    <input type="hidden" name="nim_lama" value="<?php echo htmlspecialchars($data['nim']); ?>">
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="nama_mhs" class="col-sm-2 col-form-label">Nama Mahasiswa</label>
                                <div class="col-sm-10">
                                    <input type="text" id="nama_mhs" name="nama_mhs" class="form-control"
                                           value="<?php echo htmlspecialchars($data['nama_mhs']); ?>" required>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="tgl_lahir" class="col-sm-2 col-form-label">Tanggal Lahir</label>
                                <div class="col-sm-10">
                                    <input type="date" id="tgl_lahir" name="tgl_lahir" class="form-control"
                                           value="<?php echo htmlspecialchars($data['tgl_lahir']); ?>" required>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                                <div class="col-sm-10">
                                    <textarea id="alamat" name="alamat" rows="5" class="form-control" required><?php
                                        echo htmlspecialchars($data['alamat']);
                                    ?></textarea>
                                </div>
                            </div>

                            <div class="text-center mt-auto">
                                <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
                                <button type="button" class="btn btn-secondary" onclick="history.back();">Batal</button>
                                <a href="index.php?p=list" class="btn btn-outline-secondary">Lihat Daftar</a>
                            </div>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>