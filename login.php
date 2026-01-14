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
    <title>Login - Sistem Akademik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</head>
<body class="bg-primary">
    <div class="container">
        <div class="row justify-content-center min-vh-100 align-items-center py-5">
            <div class="col-md-5 col-lg-4">
                <!-- Header Card -->
                <div class="card shadow-lg border-0 mb-3">
                    <div class="card-body bg-primary text-white text-center py-4">
                        <i class="bi bi-mortarboard-fill display-1 mb-3"></i>
                        <h3 class="mb-1">Sistem Akademik</h3>
                        <p class="mb-0">Silakan login untuk melanjutkan</p>
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

                        <form action="authenticate.php" method="POST">
                            <!-- Username -->
                            <div class="mb-3">
                                <label for="username" class="form-label">
                                    <i class="bi bi-person-fill text-primary"></i> Username
                                </label>
                                <input type="text" class="form-control form-control-lg" id="username" name="username" 
                                       placeholder="Masukkan username" required autofocus>
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <label for="password" class="form-label">
                                    <i class="bi bi-lock-fill text-primary"></i> Password
                                </label>
                                <div class="input-group input-group-lg">
                                    <input type="password" class="form-control" id="password" name="password" 
                                           placeholder="Masukkan password" required>
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Remember Me & Forgot Password -->
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                    <label class="form-check-label small" for="remember">
                                        Ingat saya
                                    </label>
                                </div>
                                <a href="#" class="small text-decoration-none">Lupa password?</a>
                            </div>

                            <!-- Submit Button -->
                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="bi bi-box-arrow-in-right"></i> Login
                                </button>
                            </div>

                            <!-- Divider -->
                            <div class="text-center mb-3">
                                <span class="text-muted">atau</span>
                            </div>

                            <!-- Register Button -->
                            <div class="d-grid">
                                <a href="register.php" class="btn btn-outline-primary btn-lg">
                                    <i class="bi bi-person-plus"></i> Buat Akun Baru
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Footer Info -->
                <div class="text-center mt-3">
                    <p class="mb-0 text-white">
                        <i class="bi bi-shield-check"></i> Data Anda aman dan terenkripsi
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle Password Visibility
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordField = document.getElementById('password');
            const icon = this.querySelector('i');
            
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                passwordField.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        });
    </script>
</body>
</html>