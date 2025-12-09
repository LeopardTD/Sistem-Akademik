<?php
include("koneksi.php");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sistem Informasi Akademik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex flex-column" style="min-height: 100vh;">
<nav class="navbar navbar-expand-lg bg-primary navbar-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">Sistem Akademik</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link <?php echo (!isset($_GET['p']) || $_GET['p'] == 'home') ? 'active' : ''; ?>" 
             href="index.php?p=home">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php echo (isset($_GET['p']) && $_GET['p'] == 'list') ? 'active' : ''; ?>" 
             href="index.php?p=list">Data Mahasiswa</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php echo (isset($_GET['p']) && $_GET['p'] == 'create') ? 'active' : ''; ?>" 
             href="index.php?p=create">Tambah Data</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- Main content wrapper dengan flex-grow -->
<div class="container my-5 flex-grow-1">
  <div class="row justify-content-center">
    <div class="col-md-11">
      <div class="card shadow">
        <div class="card-body">
          <?php
            $page = isset($_GET['p']) ? $_GET['p'] : 'home';
          
            if($page == 'home') include 'home.php';
            if($page == 'list') include 'list.php';
            if($page == 'create') include 'create.php';
            if($page == 'edit') include 'edit.php';
          ?>
        </div>
      </div>
    </div>
  </div>
</div>

<footer class="bg-dark text-white text-center py-3 mt-5">
    <p class="mb-0">&copy; 2024 Sistem Informasi Akademik</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>