<?php
if (!isset($db) && file_exists(__DIR__ . '/koneksi.php')) {
    require_once 'koneksi.php';
}

$nim = isset($_GET['nim']) ? sanitize($db, $_GET['nim']) : '';

if (empty($nim)) {
    echo '<div class="alert alert-warning">
            <i class="bi bi-exclamation-triangle me-2"></i>NIM tidak valid!
          </div>
          <a href="index.php?p=list" class="btn btn-secondary">Kembali</a>';
    exit;
}

$edit = mysqli_query($db, "SELECT * FROM mahasiswa WHERE nim='{$nim}'");
$data = mysqli_fetch_assoc($edit);
$result_prodi = mysqli_query($db, "SELECT id, nama_prodi, jenjang FROM program_studi ORDER BY nama_prodi");
?>

<div class="row justify-content-center">
    <div class="col-lg-10">
        <?php if (!$data): ?>
            <div class="alert alert-warning">
                <i class="bi bi-exclamation-triangle me-2"></i>Data tidak ditemukan!
            </div>
            <div class="text-center">
                <a href="index.php?p=list" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-2"></i>Kembali ke Daftar
                </a>
            </div>
        <?php else: ?>
            <div class="mb-4">
                <h3 class="fw-bold">
                    <i class="bi bi-pencil-square text-warning me-2"></i>Edit Data Mahasiswa
                </h3>
                <p class="text-muted">Perbarui informasi data mahasiswa</p>
            </div>

            <form method="POST" action="update.php" id="formEditMahasiswa">
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-header bg-warning">
                        <h5 class="mb-0"><i class="bi bi-person-badge me-2"></i>Data Identitas</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label fw-semibold">NIM</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" 
                                       value="<?php echo htmlspecialchars($data['nim']); ?>" readonly>
                                <input type="hidden" name="nim_lama" 
                                       value="<?php echo htmlspecialchars($data['nim']); ?>">
                                <small class="text-muted">NIM tidak dapat diubah</small>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label fw-semibold">
                                Nama Lengkap <span class="text-danger">*</span>
                            </label>
                            <div class="col-sm-9">
                                <input type="text" name="nama" class="form-control"
                                       value="<?php echo htmlspecialchars($data['nama']); ?>" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label fw-semibold">
                                Tanggal Lahir <span class="text-danger">*</span>
                            </label>
                            <div class="col-sm-9">
                                <input type="date" name="tgl_lahir" class="form-control"
                                       value="<?php echo htmlspecialchars($data['tgl_lahir']); ?>" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label fw-semibold">
                                Alamat <span class="text-danger">*</span>
                            </label>
                            <div class="col-sm-9">
                                <textarea name="alamat" rows="4" class="form-control" required><?php 
                                    echo htmlspecialchars($data['alamat']); 
                                ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="bi bi-building me-2"></i>Data Akademik</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label fw-semibold">
                                Program Studi <span class="text-danger">*</span>
                            </label>
                            <div class="col-sm-9">
                                <select name="program_studi_id" class="form-select" required>
                                    <option value="">-- Pilih Program Studi --</option>
                                    <?php while($prodi = mysqli_fetch_assoc($result_prodi)): ?>
                                        <option value="<?php echo $prodi['id']; ?>"
                                            <?php echo (isset($data['program_studi_id']) && 
                                                       $data['program_studi_id'] == $prodi['id']) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($prodi['nama_prodi'] . ' (' . $prodi['jenjang'] . ')'); ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-center">
                    <button type="submit" name="submit" class="btn btn-primary btn-lg px-5">
                        <i class="bi bi-save me-2"></i>Simpan Perubahan
                    </button>
                    <a href="index.php?p=list" class="btn btn-secondary btn-lg px-4">
                        <i class="bi bi-x-circle me-2"></i>Batal
                    </a>
                </div>
            </form>
        <?php endif; ?>
    </div>
</div>

<script>
document.getElementById('formEditMahasiswa')?.addEventListener('submit', function(e) {
    if (!confirm('Yakin ingin menyimpan perubahan data mahasiswa ini?')) {
        e.preventDefault();
    }
});
</script>