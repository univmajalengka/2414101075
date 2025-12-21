<?php
// hapus_pesanan.php
include 'koneksi.php';

// Validasi parameter ID
if (!isset($_GET['id']) || $_GET['id'] == '') {
    echo "<script>
            alert('ID pesanan tidak valid!');
            window.location='modifikasi_pesanan_wisata.php';
          </script>";
    exit;
}

$id = intval($_GET['id']); // amankan ID

// Cek apakah data ada
$cek = mysqli_query($koneksi, "SELECT id FROM pesanan WHERE id = $id");
if (mysqli_num_rows($cek) == 0) {
    echo "<script>
            alert('Data pesanan tidak ditemukan!');
            window.location='modifikasi_pesanan_wisata.php';
          </script>";
    exit;
}

// Proses hapus
$hapus = mysqli_query($koneksi, "DELETE FROM pesanan WHERE id = $id");

if ($hapus) {
    echo "<script>
            alert('Pesanan berhasil dihapus');
            window.location='modifikasi_pesanan_wisata.php';
          </script>";
} else {
    echo "<script>
            alert('Gagal menghapus pesanan!');
            window.location='modifikasi_pesanan_wisata.php';
          </script>";
}
?>
