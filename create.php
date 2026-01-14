<?php
if (!isset($db) && file_exists(__DIR__ . '/koneksi.php')) {
    require_once 'koneksi.php';
}

$result_prodi = mysqli_query($db, "SELECT id, nama_prodi, jenjang FROM program_studi ORDER BY nama_prodi");
?>

<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="mb-4">
            <h3 class="fw-bold">
                <i class="bi bi-person-plus-fill text-primary me-2"></i>Form Input Data Mahasiswa
            </h3>
            <p class="text-muted">Lengkapi form di bawah untuk menambahkan data mahasiswa baru</p>
        </div>

        <form method="POST" action="proses.php" id="formMahasiswa">
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-person-badge me-2"></i>Data Identitas</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label fw-semibold">
                            NIM <span class="text-danger">*</span>
                        </label>
                        <div class="col-sm-9">
                            <input type="text" name="nim" class="form-control" 
                                   placeholder="Contoh: 2024001" required maxlength="20">
                            <small class="text-muted">Nomor Induk Mahasiswa</small>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label fw-semibold">
                            Nama Lengkap <span class="text-danger">*</span>
                        </label>
                        <div class="col-sm-9">
                            <input type="text" name="nama" class="form-control" 
                                   placeholder="Nama lengkap mahasiswa" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label fw-semibold">
                            Tanggal Lahir <span class="text-danger">*</span>
                        </label>
                        <div class="col-sm-9">
                            <input type="date" name="tgl_lahir" class="form-control" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label fw-semibold">
                            Alamat <span class="text-danger">*</span>
                        </label>
                        <div class="col-sm-9">
                            <textarea name="alamat" rows="4" class="form-control" 
                                      placeholder="Alamat lengkap mahasiswa" required></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-success text-white">
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
                                    <option value="<?php echo $prodi['id']; ?>">
                                        <?php echo htmlspecialchars($prodi['nama_prodi'] . ' (' . $prodi['jenjang'] . ')'); ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                            <small class="text-muted">Pilih program studi yang diambil</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary btn-lg px-5">
                    <i class="bi bi-save me-2"></i>Simpan Data
                </button>
                <button type="reset" class="btn btn-warning btn-lg px-4">
                    <i class="bi bi-arrow-clockwise me-2"></i>Reset
                </button>
                <a href="index.php?p=list" class="btn btn-secondary btn-lg px-4">
                    <i class="bi bi-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('formMahasiswa').addEventListener('submit', function(e) {
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