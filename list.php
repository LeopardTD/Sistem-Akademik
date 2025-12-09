<h2 class="text-center mb-4">Daftar Mahasiswa</h2>
    <div class="mb-3">
        <a href="create.php" class="btn btn-success">Tambah Data Mahasiswa</a>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-primary">
                <tr>
                    <th>No</th>
                    <th>NIM</th>
                    <th>Nama Mahasiswa</th>
                    <th>Tanggal Lahir</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $no = 1;
            $tampil = mysqli_query($db, "SELECT * FROM mahasiswa ORDER BY nim ASC");
            
            if (mysqli_num_rows($tampil) == 0) {
                echo "<tr><td colspan='6' class='text-center'>Belum ada data mahasiswa</td></tr>";
            } else {
                while ($data = mysqli_fetch_assoc($tampil)) {
                    $nim = htmlspecialchars($data['nim']);
                    
                    // Format tanggal lahir
                    $tgl_lahir = '-';
                    if (!empty($data['tgl_lahir']) && $data['tgl_lahir'] !== '0000-00-00') {
                        $dt = DateTime::createFromFormat('Y-m-d', $data['tgl_lahir']);
                        if ($dt !== false) {
                            $tgl_lahir = $dt->format('d-m-Y');
                        }
                    }

                    echo "<tr>
                            <td class='text-center'>". $no++ ."</td>
                            <td>". $nim ."</td>
                            <td>". htmlspecialchars($data['nama_mhs']) ."</td>
                            <td class='text-center'>". $tgl_lahir ."</td>
                            <td>". nl2br(htmlspecialchars($data['alamat'])) ."</td>
                            <td class='text-center'>
                                <a href='edit.php?nim={$nim}' class='btn btn-sm btn-warning me-1'>Edit</a>
                                <a href='hapus.php?nim={$nim}' class='btn btn-sm btn-danger' onclick=\"return confirm('Yakin ingin menghapus data mahasiswa {$nim}?');\">Hapus</a>
                            </td>
                          </tr>";
                }
            }
            ?>
            </tbody>
        </table>
    </div>