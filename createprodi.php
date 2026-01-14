<?php
if (!isset($db) && file_exists(__DIR__ . '/koneksi.php')) {
    require_once 'koneksi.php';
}
?>

<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="mb-4">
            <h3 class="fw-bold">
                <i class="bi bi-plus-circle text-success me-2"></i>Form Input Program Studi
            </h3>
            <p class="text-muted">Lengkapi form di bawah untuk menambahkan program studi baru</p>
        </div>

        <form method="POST" action="prosesprodi.php" id="formProdi">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="bi bi-building me-2"></i>Data Program Studi</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label fw-semibold">
                            Nama Program Studi <span class="text-danger">*</span>
                        </label>
                        <div class="col-sm-9">
                            <input type="text" name="nama_prodi" class="form-control" 
                                   placeholder="Contoh: Teknik Informatika" required>
                            <small class="text-muted">Nama lengkap program studi</small>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label fw-semibold">
                            Jenjang <span class="text-danger">*</span>
                        </label>
                        <div class="col-sm-9">
                            <select name="jenjang" class="form-select" required>
                                <option value="">-- Pilih Jenjang --</option>
                                <option value="D3">D3 (Diploma 3)</option>
                                <option value="D4">D4 (Diploma 4)</option>
                                <option value="S1">S1 (Sarjana)</option>
                            </select>
                            <small class="text-muted">Pilih jenjang pendidikan</small>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label fw-semibold">
                            Akreditasi
                        </label>
                        <div class="col-sm-9">
                            <select name="akreditasi" class="form-select">
                                <option value="">-- Pilih Akreditasi --</option>
                                <option value="A">A (Unggul)</option>
                                <option value="B">B (Baik Sekali)</option>
                                <option value="C">C (Baik)</option>
                                <option value="Belum Terakreditasi">Belum Terakreditasi</option>
                            </select>
                            <small class="text-muted">Status akreditasi program studi (opsional)</small>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label fw-semibold">
                            Keterangan
                        </label>
                        <div class="col-sm-9">
                            <textarea name="keterangan" rows="4" class="form-control" 
                                      placeholder="Deskripsi atau keterangan tambahan tentang program studi"></textarea>
                            <small class="text-muted">Informasi tambahan (opsional)</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-success btn-lg px-5">
                    <i class="bi bi-save me-2"></i>Simpan Data
                </button>
                <button type="reset" class="btn btn-warning btn-lg px-4">
                    <i class="bi bi-arrow-clockwise me-2"></i>Reset
                </button>
                <a href="index.php?p=listprodi" class="btn btn-secondary btn-lg px-4">
                    <i class="bi bi-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('formProdi').addEventListener('submit', function(e) {
    const requiredFields = this.querySelectorAll('[required]');
    let isValid = true;
    
    requiredFields.forEach(field => {
        if (!field.value.trim()) {
            isValid = false;
            field.classList.add('is-invalid');
        } else {
            field.classList.remove('is-invalid');
        }
    });
    
    if (!isValid) {
        e.preventDefault();
        alert('Mohon lengkapi semua field yang wajib diisi!');
    }
});
</script>