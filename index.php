<?php
include("koneksi.php");
cek_login(); // Proteksi halaman
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sistem Informasi Akademik</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background-color: #f8f9fa;
        }
        .navbar {
            background: var(--primary-gradient) !important;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .content-wrapper {
            flex: 1;
            padding: 30px 0;
        }
        .main-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            min-height: 500px;
        }
        footer {
            background: var(--primary-gradient);
            margin-top: auto;
        }
        .nav-link.active {
            background-color: rgba(255,255,255,0.2) !important;
            border-radius: 5px;
        }
        .btn-gradient {
            background: var(--primary-gradient);
            border: none;
            color: white;
        }
        .btn-gradient:hover {
            opacity: 0.9;
            color: white;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="index.php">
                <i class="bi bi-mortarboard-fill me-2"></i>Sistem Akademik
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
                    data-bs-target="#navbarNav" aria-controls="navbarNav" 
                    aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link <?php echo (!isset($_GET['p']) || $_GET['p'] == 'home') ? 'active' : ''; ?>" 
                           href="index.php?p=home">
                            <i class="bi bi-house-door-fill me-1"></i>Home
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle <?php echo (isset($_GET['p']) && in_array($_GET['p'], ['list','create','edit'])) ? 'active' : ''; ?>" 
                           href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-people-fill me-1"></i>Mahasiswa
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="index.php?p=list">
                                <i class="bi bi-list-ul me-2"></i>Daftar Mahasiswa</a></li>
                            <li><a class="dropdown-item" href="index.php?p=create">
                                <i class="bi bi-person-plus-fill me-2"></i>Tambah Mahasiswa</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle <?php echo (isset($_GET['p']) && in_array($_GET['p'], ['listprodi','createprodi','editprodi'])) ? 'active' : ''; ?>" 
                           href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-building me-1"></i>Program Studi
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="index.php?p=listprodi">
                                <i class="bi bi-list-ul me-2"></i>Daftar Program Studi</a></li>
                            <li><a class="dropdown-item" href="index.php?p=createprodi">
                                <i class="bi bi-plus-circle me-2"></i>Tambah Program Studi</a></li>
                        </ul>
                    </li>
                </ul>
                <div class="d-flex align-items-center">
                    <span class="navbar-text me-3">
                        <i class="bi bi-person-circle me-1"></i>
                        <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong>
                    </span>
                    <a href="logout.php" class="btn btn-outline-light btn-sm" 
                       onclick="return confirm('Yakin ingin logout?');">
                        <i class="bi bi-box-arrow-right me-1"></i>Logout
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="content-wrapper">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="card main-card">
                        <div class="card-body p-4">
                            <?php
                            $page = isset($_GET['p']) ? $_GET['p'] : 'home';
                            
                            switch($page) {
                                case 'home':
                                    include 'home.php';
                                    break;
                                case 'list':
                                    include 'list.php';
                                    break;
                                case 'create':
                                    include 'create.php';
                                    break;
                                case 'edit':
                                    include 'edit.php';
                                    break;
                                case 'listprodi':
                                    include 'listprodi.php';
                                    break;
                                case 'createprodi':
                                    include 'createprodi.php';
                                    break;
                                case 'editprodi':
                                    include 'editprodi.php';
                                    break;
                                default:
                                    include 'home.php';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="text-white text-center py-3">
        <div class="container">
            <p class="mb-0">
                <i class="bi bi-c-circle me-1"></i>2024 Sistem Informasi Akademik</i>
            </p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>