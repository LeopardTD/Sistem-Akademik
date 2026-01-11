<div class="mb-4">
    <h3 class="fw-bold">
        <i class="bi bi-people-fill text-primary me-2"></i>Daftar Mahasiswa
    </h3>
    <p class="text-muted">Kelola dan lihat data mahasiswa yang terdaftar</p>
</div>

<?php if (isset($_SESSION['delete_success'])): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <i class="bi bi-check-circle-fill me-2"></i>
        <?php echo htmlspecialchars($_SESSION['delete_success']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php unset($_SESSION['delete_success']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['delete_error'])): ?>
    <div class="alert alert-danger alert-dismissible fade show">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        <?php echo htmlspecialchars($_SESSION['delete_error']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php unset($_SESSION['delete_error']); ?>
<?php endif; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <a href="index.php?p=create" class="btn btn-success">
        <i class="bi bi-person-plus-fill me-2"></i>Tambah Data Mahasiswa
    </a>
    
    <form class="d-flex" method="GET" action="index.php">
        <input type="hidden" name="p" value="list">
        <input class="form-control me-2" type="search" placeholder="Cari NIM atau Nama" 
               name="q" value="<?php echo isset($_GET['q']) ? htmlspecialchars($_GET['q']) : ''; ?>">
        <button class="btn btn-outline-primary" type="submit">
            <i class="bi bi-search"></i>
        </button>
    </form>
</div>

<?php
// Handle pencarian
$search = isset($_GET['q']) ? sanitize($db, $_GET['q']) : '';
$where_clause = '';

if (!empty($search)) {
    $where_clause = "WHERE m.nim LIKE '%$search%' OR m.nama LIKE '%$search%'";
}

$tampil = mysqli_query($db, "SELECT m.*, p.nama_prodi, p.jenjang 
                             FROM mahasiswa m 
                             LEFT JOIN program_studi p ON m.program_studi_id = p.id 
                             $where_clause
                             ORDER BY m.nim ASC");

$total_data = mysqli_num_rows($tampil);
?>

<?php if (!empty($search)): ?>
    <div class="alert alert-info alert-dismissible fade show">
        <i class="bi bi-info-circle me-2"></i>
        Menampilkan hasil pencarian untuk: <strong><?php echo htmlspecialchars($search); ?></strong>
        (<?php echo $total_data; ?> data ditemukan)
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-primary">
                    <tr>
                        <th class="text-center" style="width: 50px;">No</th>
                        <th style="width: 120px;">NIM</th>
                        <th>Nama Mahasiswa</th>
                        <th style="width: 200px;">Program Studi</th>
                        <th class="text-center" style="width: 130px;">Tanggal Lahir</th>
                        <th style="width: 250px;">Alamat</th>
                        <th class="text-center" style="width: 150px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                if ($total_data == 0) {
                    echo "<tr><td colspan='7' class='text-center py-4'>
                            <i class='bi bi-inbox' style='font-size: 3rem; opacity: 0.3;'></i>
                            <p class='text-muted mt-2'>Tidak ada data mahasiswa</p>
                          </td></tr>";
                } else {
                    $no = 1;
                    while ($data = mysqli_fetch_assoc($tampil)) {
                        $nim = htmlspecialchars($data['nim']);
                        $nama = htmlspecialchars($data['nama']);
                        $alamat = htmlspecialchars($data['alamat']);
                        
                        // Format tanggal lahir
                        $tgl_lahir = '-';
                        if (!empty($data['tgl_lahir']) && $data['tgl_lahir'] !== '0000-00-00') {
                            $dt = DateTime::createFromFormat('Y-m-d', $data['tgl_lahir']);
                            if ($dt !== false) {
                                $tgl_lahir = $dt->format('d/m/Y');
                            }
                        }

                        // Format program studi
                        $prodi_display = '<span class="badge bg-secondary">Belum Ada</span>';
                        if (!empty($data['nama_prodi'])) {
                            $prodi_display = '<strong>' . htmlspecialchars($data['nama_prodi']) . '</strong><br>' .
                                           '<small class="text-muted">' . htmlspecialchars($data['jenjang'] ?? '') . '</small>';
                        }

                        echo "<tr>
                                <td class='text-center fw-semibold'>{$no}</td>
                                <td><span class='badge bg-info'>{$nim}</span></td>
                                <td>{$nama}</td>
                                <td>{$prodi_display}</td>
                                <td class='text-center'>{$tgl_lahir}</td>
                                <td><small>{$alamat}</small></td>
                                <td class='text-center'>
                                    <a href='index.php?p=edit&nim={$nim}' class='btn btn-sm btn-warning' title='Edit'>
                                        <i class='bi bi-pencil-square'></i>
                                    </a>
                                    <a href='hapus.php?nim={$nim}' class='btn btn-sm btn-danger' 
                                       onclick=\"return confirm('Yakin ingin menghapus data {$nama}?');\" title='Hapus'>
                                        <i class='bi bi-trash-fill'></i>
                                    </a>
                                </td>
                              </tr>";
                        $no++;
                    }
                }
                ?>
                </tbody>
            </table>
        </div>
        
        <?php if ($total_data > 0): ?>
            <div class="mt-3 text-muted">
                <small>
                    <i class="bi bi-info-circle me-1"></i>
                    Menampilkan <?php echo $total_data; ?> data mahasiswa
                </small>
            </div>
        <?php endif; ?>
    </div>
</div>