<div class="text-center mb-5">
    <h1 class="display-4 fw-bold mb-3">
        <i class="bi bi-mortarboard-fill text-primary"></i>
        Selamat Datang di Sistem Informasi Akademik
    </h1>
    <p class="lead text-muted">Kelola data mahasiswa dengan mudah dan efisien</p>
</div>

<div class="row g-4 mb-5">
    <div class="col-md-4">
        <div class="card h-100 border-0 shadow-sm hover-card">
            <div class="card-body text-center p-4">
                <div class="mb-3">
                    <i class="bi bi-clipboard-data-fill text-primary" style="font-size: 3rem;"></i>
                </div>
                <h5 class="card-title fw-bold">Total Mahasiswa</h5>
                <?php
                $result = mysqli_query($db, "SELECT COUNT(*) as total FROM mahasiswa");
                $row = mysqli_fetch_assoc($result);
                ?>
                <h2 class="display-4 text-primary fw-bold"><?php echo $row['total']; ?></h2>
                <p class="text-muted">Mahasiswa terdaftar</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card h-100 border-0 shadow-sm hover-card">
            <div class="card-body text-center p-4">
                <div class="mb-3">
                    <i class="bi bi-building text-success" style="font-size: 3rem;"></i>
                </div>
                <h5 class="card-title fw-bold">Program Studi</h5>
                <?php
                $result_prodi = mysqli_query($db, "SELECT COUNT(*) as total FROM program_studi");
                $row_prodi = mysqli_fetch_assoc($result_prodi);
                ?>
                <h2 class="display-4 text-success fw-bold"><?php echo $row_prodi['total']; ?></h2>
                <p class="text-muted">Program studi tersedia</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card h-100 border-0 shadow-sm hover-card">
            <div class="card-body text-center p-4">
                <div class="mb-3">
                    <i class="bi bi-calendar-check text-info" style="font-size: 3rem;"></i>
                </div>
                <h5 class="card-title fw-bold">Tahun Akademik</h5>
                <h2 class="display-4 text-info fw-bold">2025</h2>
                <p class="text-muted">Periode aktif</p>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <h5 class="card-title fw-bold mb-4">
                    <i class="bi bi-people-fill text-primary me-2"></i>Menu Mahasiswa
                </h5>
                <div class="d-grid gap-3">
                    <a href="index.php?p=list" class="btn btn-outline-primary btn-lg text-start">
                        <i class="bi bi-list-ul me-2"></i>Lihat Daftar Mahasiswa
                    </a>
                    <a href="index.php?p=create" class="btn btn-outline-success btn-lg text-start">
                        <i class="bi bi-person-plus-fill me-2"></i>Tambah Data Mahasiswa
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <h5 class="card-title fw-bold mb-4">
                    <i class="bi bi-building text-success me-2"></i>Menu Program Studi
                </h5>
                <div class="d-grid gap-3">
                    <a href="index.php?p=listprodi" class="btn btn-outline-primary btn-lg text-start">
                        <i class="bi bi-list-ul me-2"></i>Lihat Daftar Program Studi
                    </a>
                    <a href="index.php?p=createprodi" class="btn btn-outline-success btn-lg text-start">
                        <i class="bi bi-plus-circle me-2"></i>Tambah Program Studi
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mt-3">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <h5 class="card-title fw-bold mb-4">
                    <i class="bi bi-info-circle text-info me-2"></i>Tentang Sistem
                </h5>
                <p class="mb-3">
                    Sistem Informasi Akademik ini dirancang untuk memudahkan pengelolaan 
                    data mahasiswa dan program studi secara digital dan efisien.
                </p>
                <div class="row">
                    <div class="col-md-6">
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                Manajemen data mahasiswa
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                Manajemen program studi
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                Interface yang user-friendly
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                Keamanan data terjamin
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                Sistem login/logout
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                Relasi data terintegrasi
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .hover-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.15) !important;
    }
</style>
