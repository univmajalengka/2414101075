<?php
// update.php
include 'koneksi.php';

// Validasi data wajib
if (
    !isset($_POST['id']) ||
    !isset($_POST['nama']) ||
    !isset($_POST['hp']) ||
    !isset($_POST['tanggal']) ||
    !isset($_POST['hari']) ||
    !isset($_POST['peserta']) ||
    !isset($_POST['pelayanan']) ||
    !isset($_POST['harga']) ||
    !isset($_POST['total'])
) {
    echo "<script>
            alert('Data tidak lengkap!');
            window.location='modifikasi_pesanan_wisata.php';
          </script>";
    exit;
}

$id       = intval($_POST['id']);
$nama     = $_POST['nama'];
$hp       = $_POST['hp'];
$tanggal  = $_POST['tanggal'];
$hari     = intval($_POST['hari']);
$peserta  = intval($_POST['peserta']);
$pelayanan = implode(",", $_POST['pelayanan']);
$harga    = intval($_POST['harga']);
$total    = intval($_POST['total']);

// Proses update
$update = mysqli_query($koneksi, "
    UPDATE pesanan SET
        nama = '$nama',
        hp = '$hp',
        tanggal = '$tanggal',
        hari = '$hari',
        peserta = '$peserta',
        pelayanan = '$pelayanan',
        harga = '$harga',
        total = '$total'
    WHERE id = $id
");

// Hasil update
if ($update) {
    echo "<script>
            alert('Pesanan berhasil diperbarui');
            window.location='modifikasi_pesanan_wisata.php';
          </script>";
} else {
    echo "<script>
            alert('Gagal memperbarui pesanan!');
            window.location='edit.php?id=$id';
          </script>";
}
?>
