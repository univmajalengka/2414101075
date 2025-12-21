<?php
include 'koneksi.php';

$nama = $_POST['nama'];
$hp = $_POST['hp'];
$tanggal = $_POST['tanggal'];
$hari = $_POST['hari'];
$peserta = $_POST['peserta'];
$harga = $_POST['harga'];
$total = $_POST['total'];

mysqli_query($koneksi, "INSERT INTO pesanan VALUES(
    '', '$nama', '$hp', '$tanggal', '$hari', 'Lengkap', '$peserta', '$harga', '$total'
)");

header("location:modifikasi_pesanan.php");
?>
