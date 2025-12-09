<?php
include('koneksi.php');

if (!empty($_POST['nim_lama']) && isset($_POST['submit'])) {
    $nim_lama = mysqli_real_escape_string($db, trim($_POST['nim_lama']));
    $nama_mhs = mysqli_real_escape_string($db, trim($_POST['nama_mhs']));
    $tgl_lahir = mysqli_real_escape_string($db, trim($_POST['tgl_lahir']));
    $alamat = mysqli_real_escape_string($db, trim($_POST['alamat']));

    $sql = "UPDATE mahasiswa SET 
            nama_mhs='$nama_mhs', 
            tgl_lahir='$tgl_lahir', 
            alamat='$alamat' 
            WHERE nim='$nim_lama'";

    if (mysqli_query($db, $sql)) {
        header('Location: index.php?p=list');
        exit;
    } else {
        echo "Error: " . mysqli_error($db);
    }
} else {
    header('Location: index.php?p=list');
    exit;
}
?>