<?php
require_once 'koneksi.php';

// Cek apakah user sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

// Ambil data user dari database
$query = "SELECT * FROM users WHERE username = ?";
$stmt = mysqli_prepare($koneksi, $query);
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

if (!$user) {
    session_destroy();
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil - Sistem Akademik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</head>
<body class="bg-light">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">
                <i class="bi bi-mortarboard-fill"></i> Sistem Akademik
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">
                            <i class="bi bi-house-fill"></i> Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="profil.php">
                            <i class="bi bi-person-fill"></i> Profil
                        </a>
                    </li>
                    <li class="nav-item">
                        <span class="nav-link">
                            <i class="bi bi-person-circle"></i> <?php echo htmlspecialchars($user['nama']); ?>
                        </span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <!-- Profile Header Card -->
                <div class="card bg-primary text-white shadow mb-4">
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
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle-fill"></i> <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle-fill"></i> <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <!-- Edit Profile Card -->
                <div class="card shadow">
                    <div class="card-header bg-white border-0 pt-4">
                        <h5 class="mb-0"><i class="bi bi-pencil-square text-primary"></i> Edit Profil</h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="update_profil.php" method="POST" id="formProfil">
                            <!-- Nama -->
                            <div class="mb-3">
                                <label for="nama" class="form-label fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
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

                            <h6 class="mb-3 text-primary"><i class="bi bi-key"></i> Ubah Password (Opsional)</h6>
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

                            <div class="d-grid gap-2 d-md-flex justify-content-md-between">
                                <a href="index.php" class="btn btn-secondary btn-lg">
                                    <i class="bi bi-arrow-left"></i> Kembali
                                </a>
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="bi bi-save"></i> Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Info Card -->
                <div class="card border-info mt-4">
                    <div class="card-body">
                        <h6 class="text-info"><i class="bi bi-shield-check"></i> Informasi Keamanan</h6>
                        <ul class="mb-0 small">
                            <li>Password Anda akan dienkripsi dengan aman</li>
                            <li>Email dan username tidak dapat diubah untuk keamanan akun</li>
                            <li>Pastikan menggunakan password yang kuat (minimal 6 karakter)</li>
                            <li>Jangan bagikan password Anda kepada siapapun</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle Password Visibility
        document.getElementById('togglePasswordLama').addEventListener('click', function() {
            togglePassword('password_lama', this);
        });
        document.getElementById('togglePasswordBaru').addEventListener('click', function() {
            togglePassword('password_baru', this);
        });
        document.getElementById('toggleKonfirmasiPassword').addEventListener('click', function() {
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
        document.getElementById('formProfil').addEventListener('submit', function(e) {
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
</body>
</html>