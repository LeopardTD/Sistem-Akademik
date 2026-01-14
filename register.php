<?php

// Jika sudah login, redirect ke index
if (isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Sistem Akademik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</head>
<body class="bg-primary">
    <div class="container">
        <div class="row justify-content-center min-vh-100 align-items-center py-5">
            <div class="col-md-6 col-lg-5">
                <!-- Header Card -->
                <div class="card shadow-lg border-0 mb-3">
                    <div class="card-body bg-primary text-white text-center py-4">
                        <i class="bi bi-person-plus-fill display-1 mb-3"></i>
                        <h3 class="mb-1">Daftar Akun Baru</h3>
                        <p class="mb-0">Sistem Informasi Akademik</p>
                    </div>
                </div>

                <!-- Form Card -->
                <div class="card shadow-lg border-0">
                    <div class="card-body p-4">
                        <!-- Alert Messages -->
                        <?php if (isset($_SESSION['error'])): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-triangle-fill"></i> 
                                <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <?php if (isset($_SESSION['success'])): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="bi bi-check-circle-fill"></i> 
                                <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <form action="proses_register.php" method="POST" id="formRegister" class="needs-validation" novalidate>
                            <!-- Nama Lengkap -->
                            <div class="mb-3">
                                <label for="nama" class="form-label">
                                    <i class="bi bi-person text-primary"></i> Nama Lengkap <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" id="nama" name="nama" 
                                       placeholder="Masukkan nama lengkap" required minlength="3">
                                <div class="invalid-feedback">Nama minimal 3 karakter dan hanya boleh huruf</div>
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <label for="email" class="form-label">
                                    <i class="bi bi-envelope text-primary"></i> Email <span class="text-danger">*</span>
                                </label>
                                <input type="email" class="form-control" id="email" name="email" 
                                       placeholder="nama@email.com" required>
                                <div class="invalid-feedback">Email tidak valid</div>
                            </div>

                            <!-- Username -->
                            <div class="mb-3">
                                <label for="username" class="form-label">
                                    <i class="bi bi-person-badge text-primary"></i> Username <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" id="username" name="username" 
                                       placeholder="Masukkan username" required minlength="4" pattern="[a-zA-Z0-9_]+">
                                <div class="form-text">Minimal 4 karakter, hanya huruf, angka, dan underscore</div>
                                <div class="invalid-feedback">Username minimal 4 karakter (huruf, angka, underscore)</div>
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <label for="password" class="form-label">
                                    <i class="bi bi-lock text-primary"></i> Password <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="password" name="password" 
                                           placeholder="Masukkan password" required minlength="6">
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                                <div class="progress mt-2" style="height: 5px;">
                                    <div class="progress-bar" id="passwordStrength" role="progressbar" style="width: 0%"></div>
                                </div>
                                <div class="form-text">Minimal 6 karakter</div>
                                <div class="invalid-feedback">Password minimal 6 karakter</div>
                            </div>

                            <!-- Konfirmasi Password -->
                            <div class="mb-3">
                                <label for="konfirmasi_password" class="form-label">
                                    <i class="bi bi-lock-fill text-primary"></i> Konfirmasi Password <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="konfirmasi_password" 
                                           name="konfirmasi_password" placeholder="Ulangi password" required>
                                    <button class="btn btn-outline-secondary" type="button" id="toggleKonfirmasi">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                                <div class="invalid-feedback">Password tidak cocok</div>
                            </div>

                            <!-- Terms & Conditions -->
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="terms" required>
                                <label class="form-check-label small" for="terms">
                                    Saya setuju dengan <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">syarat dan ketentuan</a>
                                </label>
                            </div>

                            <!-- Submit Button -->
                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="bi bi-person-plus"></i> Daftar Sekarang
                                </button>
                            </div>

                            <!-- Login Link -->
                            <div class="text-center">
                                <p class="mb-0 text-muted">Sudah punya akun? 
                                    <a href="login.php" class="text-decoration-none fw-bold">Login di sini</a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Security Info -->
                <div class="alert alert-info mt-3 border-0 shadow-sm" role="alert">
                    <h6 class="alert-heading"><i class="bi bi-shield-check"></i> Informasi Keamanan</h6>
                    <ul class="mb-0 small">
                        <li>Password akan dienkripsi dengan aman</li>
                        <li>Email dan username tidak dapat diubah setelah registrasi</li>
                        <li>Gunakan password yang kuat (minimal 6 karakter)</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Terms Modal -->
    <div class="modal fade" id="termsModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Syarat dan Ketentuan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <h6>1. Penggunaan Akun</h6>
                    <p>Anda bertanggung jawab untuk menjaga kerahasiaan akun dan password Anda.</p>
                    
                    <h6>2. Privasi Data</h6>
                    <p>Data pribadi Anda akan dijaga kerahasiaannya dan hanya digunakan untuk keperluan akademik.</p>
                    
                    <h6>3. Kewajiban Pengguna</h6>
                    <p>Pengguna wajib memberikan informasi yang benar dan akurat saat registrasi.</p>
                    
                    <h6>4. Pelanggaran</h6>
                    <p>Akun dapat dinonaktifkan jika terbukti melakukan pelanggaran atau penyalahgunaan sistem.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle Password Visibility
        document.getElementById('togglePassword').addEventListener('click', function() {
            togglePasswordVisibility('password', this);
        });
        
        document.getElementById('toggleKonfirmasi').addEventListener('click', function() {
            togglePasswordVisibility('konfirmasi_password', this);
        });

        function togglePasswordVisibility(fieldId, button) {
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

        // Password Strength Indicator
        document.getElementById('password').addEventListener('input', function() {
            const password = this.value;
            const strengthBar = document.getElementById('passwordStrength');
            
            let strength = 0;
            if (password.length >= 6) strength += 25;
            if (password.length >= 8) strength += 25;
            if (/[A-Z]/.test(password)) strength += 25;
            if (/[0-9]/.test(password)) strength += 15;
            if (/[^A-Za-z0-9]/.test(password)) strength += 10;
            
            strengthBar.style.width = strength + '%';
            strengthBar.className = 'progress-bar';
            
            if (strength <= 30) {
                strengthBar.classList.add('bg-danger');
            } else if (strength <= 60) {
                strengthBar.classList.add('bg-warning');
            } else {
                strengthBar.classList.add('bg-success');
            }
        });

        // Form Validation
        document.getElementById('formRegister').addEventListener('submit', function(e) {
            const nama = document.getElementById('nama').value.trim();
            const email = document.getElementById('email').value.trim();
            const username = document.getElementById('username').value.trim();
            const password = document.getElementById('password').value;
            const konfirmasi = document.getElementById('konfirmasi_password').value;
            
            let isValid = true;

            // Validasi Nama (hanya huruf dan spasi)
            if (nama.length < 3 || !/^[a-zA-Z\s]+$/.test(nama)) {
                document.getElementById('nama').classList.add('is-invalid');
                isValid = false;
            } else {
                document.getElementById('nama').classList.remove('is-invalid');
            }

            // Validasi Email
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                document.getElementById('email').classList.add('is-invalid');
                isValid = false;
            } else {
                document.getElementById('email').classList.remove('is-invalid');
            }

            // Validasi Username
            if (username.length < 4 || !/^[a-zA-Z0-9_]+$/.test(username)) {
                document.getElementById('username').classList.add('is-invalid');
                isValid = false;
            } else {
                document.getElementById('username').classList.remove('is-invalid');
            }

            // Validasi Password
            if (password.length < 6) {
                document.getElementById('password').classList.add('is-invalid');
                isValid = false;
            } else {
                document.getElementById('password').classList.remove('is-invalid');
            }

            // Validasi Konfirmasi Password
            if (password !== konfirmasi) {
                document.getElementById('konfirmasi_password').classList.add('is-invalid');
                alert('Password dan konfirmasi password tidak cocok!');
                isValid = false;
            } else {
                document.getElementById('konfirmasi_password').classList.remove('is-invalid');
            }

            if (!isValid) {
                e.preventDefault();
            }
        });
    </script>
</body>
</html>