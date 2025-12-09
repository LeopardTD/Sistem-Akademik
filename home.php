<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card shadow">
            <div class="card-body d-flex flex-column" style="min-height: 500px;">
                <h1 class="text-center mb-4">Selamat Datang di Sistem Informasi Akademik</h1>
                <p class="lead text-center">Sistem Manajemen Data Mahasiswa</p>
                <hr>
                <p>
                    Sistem ini digunakan untuk mengelola data mahasiswa yang mencakup informasi 
                    NIM, nama mahasiswa, tanggal lahir, dan alamat. Anda dapat melakukan operasi 
                    CRUD (Create, Read, Update, Delete) pada data mahasiswa.
                </p>
                
                <div class="row mt-4 mt-auto">
                    <div class="col-md-4 mb-3">
                        <div class="card h-100 border-primary">
                            <div class="card-body text-center">
                                <h5 class="card-title">📋 Lihat Data</h5>
                                <p class="card-text">Lihat daftar seluruh data mahasiswa yang terdaftar</p>
                                <a href="index.php?p=list" class="btn btn-primary">Lihat Daftar</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card h-100 border-success">
                            <div class="card-body text-center">
                                <h5 class="card-title">➕ Tambah Data</h5>
                                <p class="card-text">Tambahkan data mahasiswa baru ke dalam sistem</p>
                                <a href="index.php?p=create" class="btn btn-success">Tambah Data</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card h-100 border-info">
                            <div class="card-body text-center">
                                <h5 class="card-title">📊 Statistik</h5>
                                <p class="card-text">Total mahasiswa terdaftar dalam sistem</p>
                                <?php
                                $result = mysqli_query($db, "SELECT COUNT(*) as total FROM mahasiswa");
                                $row = mysqli_fetch_assoc($result);
                                ?>
                                <h3 class="text-primary"><?php echo $row['total']; ?> Mahasiswa</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>