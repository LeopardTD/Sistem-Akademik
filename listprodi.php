<div class="mb-4">
    <h3 class="fw-bold">
        <i class="bi bi-building text-primary me-2"></i>Daftar Program Studi
    </h3>
    <p class="text-muted">Kelola dan lihat data program studi yang tersedia</p>
</div>

<?php if (isset($_SESSION['prodi_success'])): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <i class="bi bi-check-circle-fill me-2"></i>
        <?php echo htmlspecialchars($_SESSION['prodi_success']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php unset($_SESSION['prodi_success']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['prodi_error'])): ?>
    <div class="alert alert-danger alert-dismissible fade show">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        <?php echo htmlspecialchars($_SESSION['prodi_error']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php unset($_SESSION['prodi_error']); ?>
<?php endif; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <a href="index.php?p=createprodi" class="btn btn-success">
        <i class="bi bi-plus-circle me-2"></i>Tambah Program Studi
    </a>
    
    <form class="d-flex" method="GET" action="index.php">
        <input type="hidden" name="p" value="listprodi">
        <input class="form-control me-2" type="search" placeholder="Cari Nama Prodi" 
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
    $where_clause = "WHERE nama_prodi LIKE '%$search%' OR jenjang LIKE '%$search%'";
}

$tampil = mysqli_query($db, "SELECT * FROM program_studi $where_clause ORDER BY nama_prodi ASC");
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
                        <th>Nama Program Studi</th>
                        <th class="text-center" style="width: 120px;">Jenjang</th>
                        <th class="text-center" style="width: 120px;">Akreditasi</th>
                        <th style="width: 250px;">Keterangan</th>
                        <th class="text-center" style="width: 150px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                if ($total_data == 0) {
                    echo "<tr><td colspan='6' class='text-center py-4'>
                            <i class='bi bi-inbox' style='font-size: 3rem; opacity: 0.3;'></i>
                            <p class='text-muted mt-2'>Tidak ada data program studi</p>
                          </td></tr>";
                } else {
                    $no = 1;
                    while ($data = mysqli_fetch_assoc($tampil)) {
                        $id = htmlspecialchars($data['id']);
                        $nama_prodi = htmlspecialchars($data['nama_prodi']);
                        $jenjang = htmlspecialchars($data['jenjang']);
                        $akreditasi = htmlspecialchars($data['akreditasi'] ?? '-');
                        $keterangan = htmlspecialchars($data['keterangan'] ?? '-');
                        
                        // Badge warna untuk jenjang
                        $badge_class = 'bg-primary';
                        if ($jenjang == 'D3') $badge_class = 'bg-info';
                        elseif ($jenjang == 'S1') $badge_class = 'bg-success';
                        elseif ($jenjang == 'S2') $badge_class = 'bg-warning';
                        elseif ($jenjang == 'S3') $badge_class = 'bg-danger';
                        
                        // Badge warna untuk akreditasi
                        $akred_badge = 'bg-secondary';
                        if ($akreditasi == 'A') $akred_badge = 'bg-success';
                        elseif ($akreditasi == 'B') $akred_badge = 'bg-primary';
                        elseif ($akreditasi == 'C') $akred_badge = 'bg-warning';

                        echo "<tr>
                                <td class='text-center fw-semibold'>{$no}</td>
                                <td><strong>{$nama_prodi}</strong></td>
                                <td class='text-center'>
                                    <span class='badge {$badge_class}'>{$jenjang}</span>
                                </td>
                                <td class='text-center'>
                                    <span class='badge {$akred_badge}'>{$akreditasi}</span>
                                </td>
                                <td><small>{$keterangan}</small></td>
                                <td class='text-center'>
                                    <a href='index.php?p=editprodi&id={$id}' class='btn btn-sm btn-warning' title='Edit'>
                                        <i class='bi bi-pencil-square'></i>
                                    </a>
                                    <a href='hapusprodi.php?id={$id}' class='btn btn-sm btn-danger' 
                                       onclick=\"return confirm('Yakin ingin menghapus program studi {$nama_prodi}?');\" title='Hapus'>
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
                    Menampilkan <?php echo $total_data; ?> program studi
                </small>
            </div>
        <?php endif; ?>
    </div>
</div>