<?php
include 'db.php';

$id = $_POST['id_makanan'];
$nama_pemesan = $_POST['nama_pemesan'];
$no_hp = $_POST['no_hp'];
$tanggal = $_POST['tanggal'];

$result = $koneksi->query("SELECT * FROM makanan WHERE id=$id");
$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Nota Pembelian</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body onload="window.print()" class="bg-light">

<div class="container mt-5 bg-white p-4 rounded shadow">
  <h3 class="text-center">🧾 Nota Pembelian</h3>
  <hr>
  <p><strong>Nama Pemesan:</strong> <?= $nama_pemesan ?></p>
  <p><strong>No HP:</strong> <?= $no_hp ?></p>
  <p><strong>Tanggal Kunjungan:</strong> <?= $tanggal ?></p>
  <hr>
  <p><strong>Nama Makanan:</strong> <?= $row['nama'] ?></p>
  <p><strong>Harga:</strong> Rp <?= number_format($row['harga'], 0, ',', '.') ?></p>
  <hr>
  <h4 class="text-end">Total: Rp <?= number_format($row['harga'], 0, ',', '.') ?></h4>
  <div class="text-center mt-4">
    <a href="index.php" class="btn btn-primary">Kembali ke Beranda</a>
  </div>
</div>

</body>
</html>
