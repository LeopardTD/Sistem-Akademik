<?php
if (!isset($db) && file_exists(__DIR__ . '/koneksi.php')) {
    require_once 'koneksi.php';
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    echo '<div class="alert alert-warning">
            <i class="bi bi-exclamation-triangle me-2"></i>ID tidak valid!
          </div>
          <a href="index.php?p=listprodi" class="btn btn-secondary">Kembali</a>';
    exit;
}

$edit = mysqli_query($db, "SELECT * FROM program_studi WHERE id = $id");
$data = mysqli_fetch_assoc($edit);
?>

<div class="row justify-content-center">
    <div class="col-lg-10">
        <?php if (!$data): ?>
            <div class="alert alert-warning">
                <i class="bi bi-exclamation-triangle me-2"></i>Data tidak ditemukan!
            </div>
            <div class="text-center">
                <a href="index.php?p=listprodi" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-2"></i>Kembali ke Daftar
                </a>
            </div>
        <?php else: ?>
            <div class="mb-4">
                <h3 class="fw-bold">
                    <i class="bi bi-pencil-square text-warning me-2"></i>Edit Program Studi
                </h3>
                <p class="text-muted">Perbarui informasi program studi</p>
            </div>

            <form method="POST" action="updateprodi.php" id="formEditProdi">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($data['id']); ?>">
                
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-warning">
                        <h5 class="mb-0"><i class="bi bi-building me-2"></i>Data Program Studi</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label fw-semibold">
                                Nama Program Studi <span class="text-danger">*</span>
                            </label>
                            <div class="col-sm-9">
                                <input type="text" name="nama_prodi" class="form-control"
                                       value="<?php echo htmlspecialchars($data['nama_prodi']); ?>" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label fw-semibold">
                                Jenjang <span class="text-danger">*</span>
                            </label>
                            <div class="col-sm-9">
                                <select name="jenjang" class="form-select" required>
                                    <option value="">-- Pilih Jenjang --</option>
                                    <option value="D3" <?php echo ($data['jenjang'] == 'D3') ? 'selected' : ''; ?>>D3 (Diploma 3)</option>
                                    <option value="D4" <?php echo ($data['jenjang'] == 'D4') ? 'selected' : ''; ?>>D4 (Diploma 4)</option>
                                    <option value="S1" <?php echo ($data['jenjang'] == 'S1') ? 'selected' : ''; ?>>S1 (Sarjana)</option>
                                    <option value="S2" <?php echo ($data['jenjang'] == 'S2') ? 'selected' : ''; ?>>S2 (Magister)</option>
                                    <option value="S3" <?php echo ($data['jenjang'] == 'S3') ? 'selected' : ''; ?>>S3 (Doktor)</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label fw-semibold">
                                Akreditasi
                            </label>
                            <div class="col-sm-9">
                                <select name="akreditasi" class="form-select">
                                    <option value="">-- Pilih Akreditasi --</option>
                                    <option value="A" <?php echo (isset($data['akreditasi']) && $data['akreditasi'] == 'A') ? 'selected' : ''; ?>>A (Unggul)</option>
                                    <option value="B" <?php echo (isset($data['akreditasi']) && $data['akreditasi'] == 'B') ? 'selected' : ''; ?>>B (Baik Sekali)</option>
                                    <option value="C" <?php echo (isset($data['akreditasi']) && $data['akreditasi'] == 'C') ? 'selected' : ''; ?>>C (Baik)</option>
                                    <option value="Belum Terakreditasi" <?php echo (isset($data['akreditasi']) && $data['akreditasi'] == 'Belum Terakreditasi') ? 'selected' : ''; ?>>Belum Terakreditasi</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label fw-semibold">
                                Keterangan
                            </label>
                            <div class="col-sm-9">
                                <textarea name="keterangan" rows="4" class="form-control"><?php 
                                    echo htmlspecialchars($data['keterangan'] ?? ''); 
                                ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-center">
                    <button type="submit" name="submit" class="btn btn-primary btn-lg px-5">
                        <i class="bi bi-save me-2"></i>Simpan Perubahan
                    </button>
                    <a href="index.php?p=listprodi" class="btn btn-secondary btn-lg px-4">
                        <i class="bi bi-x-circle me-2"></i>Batal
                    </a>
                </div>
            </form>
        <?php endif; ?>
    </div>
</div>

<script>
document.getElementById('formEditProdi')?.addEventListener('submit', function(e) {
    if (!confirm('Yakin ingin menyimpan perubahan program studi ini?')) {
        e.preventDefault();
    }
});
</script>