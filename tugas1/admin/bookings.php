<?php
session_start();
if(!isset($_SESSION['admin_id'])) header('Location: login.php');
require_once '../inc/db.php';
$res = $mysqli->query("SELECT b.*, p.title as paket FROM booking b LEFT JOIN paket p ON b.paket_id=p.id ORDER BY b.created_at DESC");
?>
<!doctype html><html><head><meta charset="utf-8"><title>Pemesanan</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body>
<nav class="navbar navbar-dark bg-dark"><div class="container"><a class="navbar-brand" href="dashboard.php">Admin</a>
<a href="logout.php" class="btn btn-sm btn-danger">Logout</a></div></nav>
<div class="container my-4">
  <h3>Daftar Pemesanan</h3>
  <table class="table">
    <thead><tr><th>#</th><th>Nama</th><th>Paket</th><th>Tanggal</th><th>Jumlah</th><th>Kontak</th><th>Waktu</th></tr></thead>
    <tbody>
      <?php while($r=$res->fetch_assoc()): ?>
      <tr>
        <td><?=$r['id']?></td>
        <td><?=htmlspecialchars($r['nama'])?></td>
        <td><?=htmlspecialchars($r['paket'])?></td>
        <td><?=htmlspecialchars($r['tanggal'])?></td>
        <td><?=htmlspecialchars($r['jumlah'])?></td>
        <td><?=htmlspecialchars($r['phone']).'<br>'.htmlspecialchars($r['email'])?></td>
        <td><?=htmlspecialchars($r['created_at'])?></td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>
</body></html>
