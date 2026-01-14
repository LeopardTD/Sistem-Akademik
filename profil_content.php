<?php
// Ambil data user dari database
$username = $_SESSION['username'];
$query = "SELECT * FROM users WHERE username = ?";
$stmt = mysqli_prepare($db, $query);
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

if (!$user) {
    echo '<div class="alert alert-danger">User tidak ditemukan!</div>';
    exit();
}
?>

<div class="row justify-content-center">
    <div class="col-lg-10">
        <!-- Profile Header -->
        <div class="card bg-primary text-white shadow-sm mb-4">
            <div class="card-body text-center py-5">
                <div class="bg-white text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                     style="width: 100px; height: 100px;">
                    <i class="bi bi-person-fill display-3"></i>
                </div>
                <h3 class="mb-2"><?php echo htmlspecialchars($user['nama']); ?></h3>
                <p class="mb-1"><i class="bi bi-envelope"></i> <?php echo htmlspecialchars($user['email']); ?></p>
                <p class="mb-0 small"><i class="bi bi-person-badge"></i> Username: <?php echo htmlspecialchars($user['username']); ?></p>
            </div>
        </div>

        <!-- Alert Messages -->
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show">
                <i class="bi bi-check-circle-fill me-2"></i>
                <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- Edit Profile Card -->
        <div class="card shadow-sm">
            <div class="card-header bg-white border-0 pt-4">
                <h5 class="mb-0">
                    <i class="bi bi-pencil-square text-primary me-2"></i>Edit Profil
                </h5>
            </div>
            <div class="card-body p-4">
                <form action="update_profil.php" method="POST" id="formProfil">
                    <!-- Nama -->
                    <div class="mb-3">
                        <label for="nama" class="form-label fw-bold">
                            Nama Lengkap <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control" id="nama" name="nama" 
                               value="<?php echo htmlspecialchars($user['nama']); ?>" required>
                        <div class="invalid-feedback">Nama harus diisi minimal 3 karakter.</div>
                    </div>

                    <!-- Email (Read Only) -->
                    <div class="mb-3">
                        <label for="email" class="form-label fw-bold">Email</label>
                        <input type="email" class="form-control bg-light" id="email" 
                               value="<?php echo htmlspecialchars($user['email']); ?>" readonly>
                        <div class="form-text">
                            <i class="bi bi-info-circle"></i> Email tidak dapat diubah untuk keamanan akun
                        </div>
                    </div>

                    <!-- Username (Read Only) -->
                    <div class="mb-4">
                        <label for="username" class="form-label fw-bold">Username</label>
                        <input type="text" class="form-control bg-light" id="username" 
                               value="<?php echo htmlspecialchars($user['username']); ?>" readonly>
                        <div class="form-text">
                            <i class="bi bi-info-circle"></i> Username tidak dapat diubah
                        </div>
                    </div>

                    <hr class="my-4">

                    <h6 class="mb-3 text-primary">
                        <i class="bi bi-key me-2"></i>Ubah Password (Opsional)
                    </h6>
                    <p class="text-muted small mb-3">Kosongkan jika tidak ingin mengubah password</p>

                    <!-- Password Lama -->
                    <div class="mb-3">
                        <label for="password_lama" class="form-label">Password Lama</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password_lama" name="password_lama">
                            <button class="btn btn-outline-secondary" type="button" id="togglePasswordLama">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                        <div class="form-text">Wajib diisi jika ingin mengubah password</div>
                    </div>

                    <!-- Password Baru -->
                    <div class="mb-3">
                        <label for="password_baru" class="form-label">Password Baru</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password_baru" name="password_baru">
                            <button class="btn btn-outline-secondary" type="button" id="togglePasswordBaru">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                        <div class="form-text">Minimal 6 karakter</div>
                        <div class="invalid-feedback">Password minimal 6 karakter.</div>
                    </div>

                    <!-- Konfirmasi Password -->
                    <div class="mb-4">
                        <label for="konfirmasi_password" class="form-label">Konfirmasi Password Baru</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="konfirmasi_password" name="konfirmasi_password">
                            <button class="btn btn-outline-secondary" type="button" id="toggleKonfirmasiPassword">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                        <div class="invalid-feedback">Password tidak cocok.</div>
                    </div>

                    <div class="d-flex gap-2 justify-content-between">
                        <a href="index.php" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-2"></i>Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-2"></i>Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Info Card -->
        <div class="alert alert-info border-0 shadow-sm mt-4">
            <h6 class="alert-heading">
                <i class="bi bi-shield-check me-2"></i>Informasi Keamanan
            </h6>
            <ul class="mb-0 small">
                <li>Password Anda akan dienkripsi dengan aman</li>
                <li>Email dan username tidak dapat diubah untuk keamanan akun</li>
                <li>Pastikan menggunakan password yang kuat (minimal 6 karakter)</li>
                <li>Jangan bagikan password Anda kepada siapapun</li>
            </ul>
        </div>
    </div>
</div>

<script>
// Toggle Password Visibility
document.getElementById('togglePasswordLama')?.addEventListener('click', function() {
    togglePassword('password_lama', this);
});
document.getElementById('togglePasswordBaru')?.addEventListener('click', function() {
    togglePassword('password_baru', this);
});
document.getElementById('toggleKonfirmasiPassword')?.addEventListener('click', function() {
    togglePassword('konfirmasi_password', this);
});

function togglePassword(fieldId, button) {
    const field = document.getElementById(fieldId);
    const icon = button.querySelector('i');
    if (field.type === 'password') {
        field.type = 'text';
        icon.classList.remove('bi-eye');
        icon.classList.add('bi-eye-slash');
    } else {
        field.type = 'password';
        icon.classList.remove('bi-eye-slash');
        icon.classList.add('bi-eye');
    }
}

// Form Validation
document.getElementById('formProfil')?.addEventListener('submit', function(e) {
    const nama = document.getElementById('nama').value.trim();
    const passwordLama = document.getElementById('password_lama').value;
    const passwordBaru = document.getElementById('password_baru').value;
    const konfirmasiPassword = document.getElementById('konfirmasi_password').value;

    let isValid = true;

    // Validasi Nama
    if (nama.length < 3) {
        document.getElementById('nama').classList.add('is-invalid');
        isValid = false;
    } else {
        document.getElementById('nama').classList.remove('is-invalid');
    }

    // Validasi Password (jika diisi)
    if (passwordBaru || passwordLama || konfirmasiPassword) {
        if (!passwordLama) {
            alert('Password lama harus diisi jika ingin mengubah password');
            isValid = false;
        }
        if (passwordBaru.length > 0 && passwordBaru.length < 6) {
            document.getElementById('password_baru').classList.add('is-invalid');
            isValid = false;
        } else {
            document.getElementById('password_baru').classList.remove('is-invalid');
        }
        if (passwordBaru !== konfirmasiPassword) {
            document.getElementById('konfirmasi_password').classList.add('is-invalid');
            alert('Konfirmasi password tidak cocok dengan password baru');
            isValid = false;
        } else {
            document.getElementById('konfirmasi_password').classList.remove('is-invalid');
        }
    }

    if (!isValid) {
        e.preventDefault();
    }
});
</script>